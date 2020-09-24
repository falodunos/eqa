<?php
namespace Admin\Service;

use Admin\Service\Contract\SubjectServiceInterface;
use Admin\Entity\Contract\SubjectInterface;
use Admin\Repository\Contract\SubjectRepositoryInterface;
use Base\Service\BaseService;
use Admin\Entity\Subject;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubjectService extends BaseService implements SubjectServiceInterface
{

    protected $_subjectRepository = null;

    protected $_subjectEntity = null;

    protected $_institution;

    protected $_department;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setSubjectRepository($this->getServiceLocator()
            ->get('examsqa_admin_subject_repository'));
        
        if (is_null($this->_subjectEntity)) {
            $this->_subjectEntity = new Subject();
        }
        $this->_institution = $this->getZfcUserIdentity()->getInstitution();
        $this->_department = $this->getZfcUserIdentity()
            ->getIdentity()
            ->getDepartment();
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\SubjectServiceInterface::findSubjectBy()
     */
    public function findSubjectBy(array $criteria)
    {
        return $this->getSubjectRepository()->findBy($criteria);
    }

    protected function _setSubjectRepository(SubjectRepositoryInterface $subjectRepository)
    {
        $this->_subjectRepository = $subjectRepository;
    }

    public function getSubjectRepository()
    {
        return $this->_subjectRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\SubjectServiceInterface::findAllSubjects()
     */
    public function findAllSubjects()
    {
        return $this->getSubjectRepository()->findAll();
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\SubjectServiceInterface::findSubject()
     */
    public function findSubject($id)
    {
        return $this->getSubjectRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\SubjectServiceInterface::saveSubject()
     */
    public function saveSubject($post)
    {
        // this action will perform both create and update operation on Subject object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_subject_form'); // Create the exam form
        $subjectRepository = $this->getSubjectRepository();
        $dateTime = new \DateTime("now");
        $id = $post['subject-fieldset']['id'];
        
        if ($id) { // updating exam entity ...
            $subjectRepository->setEntityClass($this->_subjectEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $subjectRepository->update($entity)->getId() ? true : false; // save modified entity
            } else {
                var_dump($form->getMessages());
            }
        } else { // creating new subject entity ...
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setInstitution($this->_institution)
                    ->setCreatedAt($dateTime)
                    ->setUpdatedAt($dateTime);
                return $subjectRepository->insert($entity)->getId() ? true : false;
            } else {
                var_dump($form->getMessages());
            }
        }
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\SubjectServiceInterface::deleteSubject()
     */
    public function deleteSubject(SubjectInterface $subject)
    {
        // TODO Auto-generated method stub
    }

    public function getExamSubjectsHtml()
    {
        $path = '/module/Admin/view/admin/subject/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        
        $criteria = [];
        $adminRoleId = $this->getZfcUserIdentity()
            ->getRoles()[0]
            ->getRoleId();
        
        if ($adminRoleId == 'operation-admin') {
            $criteria['department'] = $this->_department;
        } elseif ($adminRoleId == 'super-admin') {
            $criteria['institution'] = $this->_institution;
        }
        
        foreach ($this->findSubjectBy($criteria) as $subject) {
            $count += 1;
            $status = (int) $subject->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=subject-edit-" . $subject->getId() . ">Edit</option>
                            <option value=subject-delete-" . $subject->getId() . ">Delete</option>
                        </select>";
            
            $html .= "<tr><td>" . $count . "</td><td>" . $subject->getSubjectName() . "</td><td>" . $subject->getSubjectCode() . "</td><td>" . $subject->getSubjectDescription() . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $subject = $this->findSubject($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $subject->getId()
            ],
            [
                'id' => 'subjectName',
                'value' => $subject->getSubjectName()
            ],
            [
                'id' => 'subjectCode',
                'value' => $subject->getSubjectCode()
            ],
            [
                'id' => 'subjectDescription',
                'value' => $subject->getSubjectDescription()
            ],
            [
                'id' => 'isActive',
                'value' => $subject->getIsActive()
            ]
        );
    }
}