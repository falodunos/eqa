<?php
namespace Admin\Service\Question;

use Admin\Service\Contract\Question\ImageServiceInterface as QuestionImageServiceInterface;
use Admin\Repository\Question\ImageRepository as QuestionImageRepository;
use Base\Service\BaseService;
use Admin\Entity\Question\Image as QuestionImage;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Entity\Contract\Question\ImageInterface as QuestionImageInterface;

class ImageService extends BaseService implements QuestionImageServiceInterface
{

    protected $_questionImageRepository;

    protected $_imageService;

    protected $_questionService;

    protected $_questionImageEntity;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setQuestionImageRepository($this->getServiceLocator()
            ->get('examsqa_admin_question_image_repository'));
        
        $this->_institutionService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        $this->_questionService = $this->getServiceLocator()->get('examsqa_admin_question_service');
        
        if (is_null($this->_questionImageEntity)) {
            $this->_questionImageEntity = new QuestionImage();
        }
        
        parent::__construct();
    }

    protected function _setQuestionImageRepository(QuestionImageRepository $examsqa_question_image_repository)
    {
        $this->_questionImageRepository = $examsqa_question_image_repository;
    }

    public function getQuestionImageRepository()
    {
        return $this->_questionImageRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\ImageServiceInterface::getQuestionImage()
     */
    public function getQuestionImage($id)
    {
        return $this->getQuestionImageRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\ImageServiceInterface::deleteQuestionImage()
     */
    public function deleteQuestionImage(QuestionImageInterface $questionImage)
    {}

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\ImageServiceInterface::getAllQuestionImages()
     */
    public function getAllQuestionImages()
    {
        return $this->getQuestionImageRepository()->findAll();
    }
    
    public function findQuestionImagesBy($criteria)
    {
        return $this->getQuestionImageRepository()->findBy($criteria);
    }
    
    public function upload($form, $data, $files)
    {
        $post = array_merge_recursive($data, $files);
        $form->setData($post);
        $absoluteUploadPath = $this->getUploadPath($post);
        $relativeUploadPath = $this->getUploadPath($post, false);//var_dump($relativeUploadPath);die(__METHOD__);
        
        $question_image_repository = $this->getQuestionImageRepository();
        $dateTime = new \DateTime("now");
        
        $id = $post['document-upload-fieldset']['id'];
        
        if ($id) { // changing or updating existing question image entity ...
            $question_image_repository->setEntityClass($this->_questionImageEntity);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $question_image_repository->update($entity)->getId() ? true : false;
            } else {
                throwException($form->getMessages());
            }
        } else { // creating new question image
            if ($form->isValid()) {
                $response = $this->moveUploadedFile($post, $files, $absoluteUploadPath); // move or upload file
                if ($response['upload_status'] == true) { // upload is successful, save image details to database
                    $entity = $this->setImageRelatedEntities($form->getData(), $post);
                    
                    $entity->setDocumentPath($relativeUploadPath)
                        ->setCreatedAt($dateTime)
                        ->setUpdatedAt($dateTime);
                    $isSuccess = $question_image_repository->insert($entity)->getId() ? true : false;
                    if ($isSuccess == true) {
                        return $response;
                    } else {
                        // problem occurred while saving the document info to the database
                        $response['upload_status'] = false;
                        $response['status_msg'] = 'Oops! something unexpected occured after uploding your file, please try again.';
                        $this->deleteUploadedFile($files, $absoluteUploadPath);
                        return $response;
                    }
                } else {
                    return $response;
                } // upload fail, image details not save to database
            } else {
                throw new \Exception($form->getMessages());
            }
        } // end: creating new image entity
    }

    public function getQuestionImages($post)
    {
        $imageRelativePath = 'admin' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $this->getUploadPath($post, false);
        chdir(getcwd() . "/public/"); // It's easier to work without /public in the image path.
        
        if (is_dir($imageRelativePath)) {
            $imageConfig = $this->getImageConfiguration();
            $allowedImageExtentions = $imageConfig['imageType'];
            $regexString = '';
            for ($n = 0; $n < count($allowedImageExtentions); $n ++) {
                $regexString .= $allowedImageExtentions[$n];
                $regexString .= $n < count($allowedImageExtentions) - 1 ? '|' : '';
            }
            
            $files = [];
            $i = 0;
            $iterator = new \FilesystemIterator($imageRelativePath);
            $filter = new \RegexIterator($iterator, '/.(' . $regexString . ')$/');
            
            $imagesDesc = $this->getImageDescription($post);
            
            foreach ($filter as $fullPath => $file) {
                if ($file->isFile()) {
                    $files[$i]["filelink"] = DIRECTORY_SEPARATOR . $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
                    $files[$i]["filename"] = $file->getFilename();
                    $files[$i]["description"] = count($imagesDesc) > $i ? $imagesDesc[$i] : $file->getFilename();
                    $i ++;
                }
            }
            
            chdir(dirname(getcwd()));
            return $files;
        }
        return [];
    }

    public function download($file)
    {
        $fileName = $this->getUploadPath() . DIRECTORY_SEPARATOR . $file;
        if (file_exists($fileName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            ob_clean();
            flush();
            readfile($fileName);
            exit();
        }
    }

    protected function renameUploadedImages($files)
    {
        foreach ($files['document-upload-fieldset'] as $key => $file) {
            $fileName = $this->getAdminImageCommonPath() . $file['name'];
            if (! file_exists($fileName)) {
                return rename($file['tmp_name'], $fileName);
            } else {
                return false;
            } // else : file exist already
        }
    }

    public function getUploadPath($post, $isAbsolutePath = true)
    {
        $imageInfo = $this->getImageInfo($post);
        $imagesDesc = $this->getQuestionImageRepository($imageInfo);
        
        $relativePath = $this->getConstructedEntityDocumentUploadPath($imageInfo);
        
        $absolutePath = $this->getAdminImageCommonPath() . $relativePath;
        if (! is_dir($absolutePath) && $isAbsolutePath == true) {
            mkdir($absolutePath, 0777, true);
        }
        
        $path = $isAbsolutePath == true ? $absolutePath : $relativePath;
        return $path;
    }

    protected function getImageDescription($post)
    {
        $description = [];
        $images = $this->getQuestionImageRepository()->getQuestionImagesDbInfo($this->getImageInfo($post));
        foreach ($images as $image) {
            $description[] = $image->getDocumentDescription();
        }
        return $description;
    }

    protected function getImageInfo($post)
    {
        $questionId = 0;
        if (isset($post['document-upload-fieldset']['parentEntityId'])) {
            $questionId += (int) $post['document-upload-fieldset']['parentEntityId'];
        } else 
            if (isset($post['parentEntityId'])) {
                $questionId += (int) $post['parentEntityId'];
            }
        
        $question = $this->_questionService->findQuestion($questionId);
        $section = $question->getQuestionSection();
        $paper = $question->getQuestionPaper();
        return [
            'instId' => $question->getInstitution()->getId(),
            'deptId' => $question->getDepartment()->getId(),
            'examId' => $paper->getPaperExam()->getId(),
            'subjectId' => $paper->getPaperSubject()->getId(),
            'paperId' => $paper->getId(),
            'sectionId' => $section->getId(),
            'questionId' => $questionId
        ];
    }

    protected function setImageRelatedEntities($imageEntity, $post)
    {
        $em = $this->getQuestionImageRepository()->getEntityManager();
        
        $questionId = $post['document-upload-fieldset']['parentEntityId'];
        $question = $this->_questionService->findQuestion($questionId);
        
        $section = $question->getQuestionSection();
        $paper = $question->getQuestionPaper();
        $exam = $paper->getPaperExam();
        $subject = $paper->getPaperSubject();
        
        $imageEntity->setInstitution($question->getInstitution())
            ->setDepartment($question->getDepartment())
            ->setExam($exam)
            ->setSubject($subject)
            ->setPaper($paper)
            ->setSection($section)
            ->setQuestion($question);
        return $imageEntity;
    }

    public function deleteImageTrailFromDb($imagePath)
    {
        $imagePathParts = explode('\admin\img', $imagePath);
        $imagePathPart2 = $imagePathParts[1];
        $imagePathPart2Arr = explode('\\', $imagePathPart2);
        $fileName = $imagePathPart2Arr[count($imagePathPart2Arr) - 1];
        $imagePathInDbArr = explode($fileName, $imagePathPart2);
        $imagePathInDb = $imagePathInDbArr[0];
        $imageInfo = $this->decomposePathToImageInfo($imagePathInDb);
        
        $isDeleted = $this->_questionImageRepository->deleteImageTrailFromDb($fileName, $imageInfo);
        return $isDeleted;
    }

    protected function decomposePathToImageInfo($imagePathInDb)
    {
        $imagePathParts = explode('\\', $imagePathInDb);
        return [
            'instId' => explode('_', $imagePathParts[3])[1],
            'deptId' => explode('_', $imagePathParts[5])[1],
            'examId' => explode('_', $imagePathParts[7])[1],
            'subjectId' => explode('_', $imagePathParts[9])[1],
            'paperId' => explode('_', $imagePathParts[11])[1],
            'sectionId' => explode('_', $imagePathParts[13])[1],
            'questionId' => explode('_', $imagePathParts[14])[1],
        ];
        // e.g. $imagePathInDb = '\examsqa\institutions\institution_1\departments\department_1\exams\exam_2\subjects\subject_1\papers\paper_2\sections\section_4\question_3\'
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {}
}