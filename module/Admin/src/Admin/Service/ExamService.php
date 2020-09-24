<?php
namespace Admin\Service;

use Admin\Service\Contract\ExamServiceInterface;
use Admin\Entity\Contract\ExamInterface;
use Admin\Repository\Contract\ExamRepositoryInterface;
use Admin\Repository\Contract\Exam\LevelRepositoryInterface;
use Admin\Repository\Contract\Exam\CertificateRepositoryInterface;
use Base\Service\BaseService;
use Admin\Entity\Exam;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExamService extends BaseService implements ExamServiceInterface
{

    protected $_examRepository = null;

    protected $_levelRepository = null;

    protected $_certRepository = null;

    protected $_examEntity = null;

    protected $_departmentService;

    protected $_institutionService;

    protected $_institution;

    protected $_department;

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::findExamsBy()
     */
    public function findExamsBy($criteria)
    {
        return $this->getExamRepository()->findBy($criteria);
    }

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setExamRepository($this->getServiceLocator()
            ->get('examsqa_admin_exam_repository'));
        
        $this->_setLevelRepository($this->getServiceLocator()
            ->get('examsqa_admin_level_repository'));
        
        $this->_setCertificateRepository($this->getServiceLocator()
            ->get('examsqa_admin_certificate_repository'));
        
        if (is_null($this->_examEntity)) {
            $this->_examEntity = new Exam();
        }
        $this->_departmentService = $this->getServiceLocator()->get('examsqa_admin_department_service');
        $this->_institutionService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        
        $this->_institution = $this->getZfcUserIdentity()->getInstitution();
        $this->_department = $this->getZfcUserIdentity()
            ->getIdentity()
            ->getDepartment();
    }

    protected function _setExamRepository(ExamRepositoryInterface $examRepository)
    {
        $this->_examRepository = $examRepository;
    }

    public function getExamRepository()
    {
        return $this->_examRepository;
    }

    protected function _setLevelRepository(LevelRepositoryInterface $levelRepository)
    {
        $this->_levelRepository = $levelRepository;
    }

    public function getLevelRepository()
    {
        return $this->_levelRepository;
    }

    protected function _setCertificateRepository(CertificateRepositoryInterface $certRepository)
    {
        $this->_certRepository = $certRepository;
    }

    public function getCertificateRepository()
    {
        return $this->_certRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::findAllExams()
     */
    public function findAllExams()
    {
        return $this->getExamRepository()->findAll();
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::findExam()
     */
    public function findExam($id)
    {
        return $this->getExamRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::saveExam()
     */
    public function saveExam($post)
    {
        // this action will perform both create and update operation on Exam object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_exam_form'); // Create the exam form
        $exam_repository = $this->getExamRepository();
        $dateTime = new \DateTime("now");
        $id = $post['exam-fieldset']['id'];
        if ($id) { // updating exam entity ...
            $exam_repository->setEntityClass($this->_examEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $exam_repository->update($entity)->getId() ? true : false; // save modified entity
            } else {
                var_dump($form->getMessages());
            }
        } else { // creating new exam entity ...
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                
                $entity->setInstitution($this->_institutionService->getInstitutionFromAuthService())
                    ->setCreatedAt($dateTime)
                    ->setUpdatedAt($dateTime);
                
                $department = $this->_departmentService->getDepartmentFromAuthService();
                ! is_null($department) ? $entity->setDepartment($department) : '';
                
                return $exam_repository->insert($entity)->getId() ? true : false;
            } else {
                var_dump($form->getMessages());
            }
        }
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::deleteExam()
     */
    public function deleteExam(ExamInterface $exam)
    {}

    public function getExamsHtml()
    {
        $path = '/module/Admin/view/admin/exam/index.phtml';
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
        
        foreach ($this->findExamsBy($criteria) as $exam) {
            $count += 1;
            $status = (int) $exam->getIsActive() == 1 ? 'Active' : 'In-active';
            $dateEstablished = $exam->getDateEstablished() instanceof \DateTime ? $exam->getDateEstablished()->format('M d, Y') : '';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=exam-edit-" . $exam->getId() . ">Edit</option>
                            <option value=exam-delete-" . $exam->getId() . ">Delete</option>
                        </select>";
            
            $html .= "<tr><td>" . $count . "</td><td>" . $exam->getExamName() . "</td><td>" . $exam->getExamCode() . "</td><td>" . $exam->getExamLevel()->getLevelName() . "</td><td>" . $exam->getExamCertificate()->getCertName() . "</td><td>" . $exam->getExamDescription() . "</td><td>" . $dateEstablished . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $exam = $this->findExam($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $exam->getId()
            ],
            [
                'id' => 'examName',
                'value' => $exam->getExamName()
            ],
            [
                'id' => 'examCode',
                'value' => $exam->getExamCode()
            ],
            [
                'id' => 'examDescription',
                'value' => $exam->getExamDescription()
            ],
            [
                'id' => 'isActive',
                'value' => $exam->getIsActive()
            ],
            [
                'id' => 'examLevel',
                'value' => $exam->getExamLevel()->getId()
            ],
            [
                'id' => 'examCertificate',
                'value' => $exam->getExamCertificate()->getId()
            ],
            [
                'id' => 'dateEstablished',
                'value' => $exam->getDateEstablished() instanceof \DateTime ? $exam->getDateEstablished()->format('Y-m-d') : ''
            ]
        );
    }
}