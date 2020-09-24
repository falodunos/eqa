<?php
namespace Base\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\InputFilter;
use Base\Service\Contract\BaseServiceInterface;

abstract class BaseService implements ServiceLocatorAwareInterface, BaseServiceInterface
{

    protected $_serviceLocator;

    protected $_baseDocumentPath = '';

    private  $_adminCommonImagePath;

    protected static $_DS = DIRECTORY_SEPARATOR;

    protected $_auth = null;

    public function __construct()
    {
        $DS = self::$_DS;
        $this->_adminCommonImagePath = getcwd() . $DS . 'public' . $DS . 'admin' . $DS . 'img' . $DS;
        
        $this->_auth = $this->getServiceLocator()->get('zfcuser_auth_service');
    }

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
    }

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->_serviceLocator;
    }

    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    abstract public function getEntityDataArray($entityId);

    public function getAdminImageCommonPath()
    {
        return $this->_adminCommonImagePath;
    }

    public function addFileInputFilter($documentPath)
    {
        $inputFilter = new InputFilter\InputFilter();
        // File Input
        $fileInput = new InputFilter\FileInput("document-upload-fieldset['documentName']");
        $fileInput->setRequired(true)
            ->getValidatorChain()
            ->attachByName('filesize', array(
            'max' => 204800
        ))
            ->attachByName('fileimagesize', array(
            'maxWidth' => 200,
            'maxHeight' => 200
        ))
            ->attachByName('filemimetype', array(
            'mimeType' => 'image/png, image/x-png, image/jpeg'
        ));
        $fileInput->getFilterChain()->attachByName('filerenameupload', array(
            'target' => $documentPath, // './data/tmpuploads/avatar.png'
            'overwrite' => true,
            'randomize' => true
        ));
        return $inputFilter->add($fileInput);
    }

    public function getConstructedEntityDocumentUploadPath(array $entity_info)
    {
        $DS = self::$_DS;
        try {
            $instId = $entity_info['instId'];
            $deptId = $entity_info['deptId'];
            $examId = $entity_info['examId'];
            $subjectId = $entity_info['subjectId'];
            $paperId = $entity_info['paperId'];
            $sectionId = $entity_info['sectionId'];
            $questionId = $entity_info['questionId'];
            $optionId = isset($entity_info['optionId']) && ! empty($entity_info['optionId']) ? $entity_info['optionId'] : '';
            $institution = 'examsqa' . $DS . 'institutions' . $DS . 'institution_' . $instId . $DS . 'departments' . $DS;
            $department = 'department_' . $deptId . $DS . 'exams' . $DS;
            $exam = 'exam_' . $examId . $DS . 'subjects' . $DS;
            $subject = 'subject_' . $subjectId . $DS . 'papers' . $DS;
            $paper = 'paper_' . $paperId . $DS . 'sections' . $DS;
            $section = 'section_' . $sectionId . $DS;
            $question = 'question_' . $questionId;
            $answerOption = $DS . 'answers' . $DS . 'option_' . $optionId;
            
            $this->_baseDocumentPath = $optionId == '' ? $institution . $department . $exam . $subject . $paper . $section . $question : $institution . $department . $exam . $subject . $paper . $section . $question . $answerOption ;
            
            return $this->_baseDocumentPath . $DS; // return the document real path ...
        } catch (\Exception $ex) {
            return '';
        }
    }

    protected function deleteUploadedFile($files, $target_dir)
    {
        $file = $files['document-upload-fieldset']['documentName'];
        $target_file = $target_dir . basename($file["name"]);
        if (file_exists($target_file)) {
            return unlink($target_file);
        }
    }

    public function getImageConfiguration()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['examsqa']['admin']['imageFile'];
    }

    public function getCorrectFileName($fileName)
    {
        $fileName = preg_replace('/[^a-z0-9_\\-\\.]+/i', '_', $fileName);
        $fileInfo = pathinfo($fileName);
        
        if (preg_match('/^_+$/', $fileInfo['filename'])) {
            $fileName = 'file.' . $fileInfo['extension'];
        }
        return $fileName;
    }

    protected function moveUploadedFile($post, $files, $target_dir)
    {
        $config = $this->getServiceLocator()->get('config');
        $imageFileUploadConfig = $config['examsqa']['admin']['imageFile'];
        $response = array(
            'upload_status' => true,
            'status_msg' => ''
        );
        $file = $files['document-upload-fieldset']['documentName'];
        $canOveriteFile = (int) $post['document-upload-fieldset']['overiteExistingFile'] == 1 ? true : false;
        $target_file = $target_dir . $this->getCorrectFileName(basename($file["name"]));
        
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            $response['status_msg'] = 'Invalid : Please a valid image file.';
            $response['upload_status'] = false;
            return $response;
        }
        
        if (file_exists($target_file) && $canOveriteFile == false) {
            $response['status_msg'] = 'Duplicate : Please select a different file or click to overite existing file on the form and try again!';
            $response['upload_status'] = false;
            return $response;
        }
        
        if ($file["size"] > $imageFileUploadConfig['imageSize']) {
            $response['status_msg'] = 'Size Error : Maximum file size is 50000 bytes.';
            $response['upload_status'] = false;
            return $response;
        }
        
        if (in_array($imageFileType, $imageFileUploadConfig['imageType']) === false) {
            $response['status_msg'] = 'Format Error : File format should be either jpg, png, jpeg or gif';
            $response['upload_status'] = false;
            return $response;
        }
        
        // Check if $response['upload_status'] is set to true
        if ($response['upload_status'] == true) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $response['status_msg'] = 'Success : File upload was successful !';
                return $response;
            } else {
                $response['status_msg'] = 'Oops! Something unusual happened while trying to upload your file, please try again.';
                $response['upload_status'] = false;
                return $response;
            }
        }
    }

    public function getCheckboxElementHtml()
    {
        $path = '/module/Admin/view/admin/common/form/elements/checkbox.phtml';
        $fileCheckbox = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $fileCheckbox);
        return $fileParts;
    }

    public function getZfcUserIdentity()
    {
        $auth = $this->getServiceLocator()->get('zfcuser_auth_service');
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        
        return null;
    }

    public function getInstitutionDepartmentSelectFilterCriteria()
    {
        $criteria = [];
        $identity = $this->getZfcUserIdentity()->getIdentity();
        
        if (! is_null($identity)) {
            ! is_null($identity->getInstitution()) ? $criteria['institution'] = $identity->getInstitution() : '';
            ! is_null($identity->getDepartment()) ? $criteria['department'] = $identity->getDepartment() : '';
        }
        
        $criteria['isActive'] = 1;
        return $criteria;
    }

    public function getAdminRoleId()
    {
        if (! is_null($this->getZfcUserIdentity())) {
            return $this->getZfcUserIdentity()
                ->getRoles()[0]
                ->getRoleId();
        }
        return null;
    }
}