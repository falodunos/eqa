<?php
namespace Admin\Service\Question;

use Admin\Service\Contract\Question\PaperServiceInterface as QuestionPaperServiceInterface;
use Admin\Entity\Contract\Question\PaperInterface as QuestionPaperInterface;
use Admin\Repository\Question\PaperRepository as QuestionPaperRepository;
use Base\Service\BaseService;
use Admin\Entity\Question\Paper as QuestionPaper;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaperService extends BaseService implements QuestionPaperServiceInterface
{

    protected $_questionPaperRepository, $_questionPaperEntity, $_departmentService;

    protected $_institutionService, $_questionTypeEntity, $_subjectService, $_examsqaSession;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setQuestionPaperRepository($this->getServiceLocator()
            ->get('examsqa_admin_question_paper_repository'));
        
        $this->_departmentService = $this->getServiceLocator()->get('examsqa_admin_department_service');
        $this->_institutionService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        $this->_subjectService = $this->getServiceLocator()->get('examsqa_admin_subject_service');
        $this->_examsqaSession = $this->getServiceLocator()->get('examsqa_session');
        
        if (is_null($this->_questionPaperEntity)) {
            $this->_questionPaperEntity = new QuestionPaper();
        }
    }

    public function getExamsOfferingThisSubject($institutionId, $subjectId)
    {
        $institution = $this->_institutionService->findInstitution($institutionId);
        $subject = $this->_subjectService->findSubject($subjectId);
        
        $criteria = array(
            'institution' => $institution,
            'paperSubject' => $subject
        );
        
        $papers = $this->getQuestionPaperRepository()->findBy($criteria);
        $this->_examsqaSession->availableQuestionPapers = $papers;
        
        $requiredExams = [];
        $examCodes = [];
        foreach ($papers as $paper) {
            $exam = $paper->getPaperExam();
            $examCode = $exam->getExamCode();
            if (! in_array($examCode, $examCodes)) {
                $examCodes[] = $examCode;
                $requiredExams[] = $exam;
            }
        }
        return $requiredExams;
    }

    protected function _setQuestionPaperRepository(QuestionPaperRepository $examsqa_question_paper_repository)
    {
        $this->_questionPaperRepository = $examsqa_question_paper_repository;
    }

    public function getQuestionPaperRepository()
    {
        return $this->_questionPaperRepository;
    }

    protected function getPaperName($entity)
    {
        $paperName = $entity->getPaperName();
        $paperYear = $entity->getPaperYear();
        $examCode = $entity->getPaperExam()->getExamCode();
        $subjectCode = $entity->getPaperSubject()->getSubjectCode();
        
        return $paperName . '-' . $subjectCode . '-' . $examCode . '-' . $paperYear;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::saveExam()
     */
    public function saveQuestionPaper($post)
    {
        // this action will perform both create and update operation on Exam object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_question_paper_form'); // Create the exam form
        $question_paper_repository = $this->getQuestionPaperRepository();
        $dateTime = new \DateTime("now");
        $id = $post['question-paper-fieldset']['id'];
        
        if ($id) { // updating existing level entity ...
            $question_paper_repository->setEntityClass($this->_questionPaperEntity);
            $form->setData($post);
            if ($form->isValid()) {
                
                $entity = $form->getData();
                
                if (count(explode('-', $entity->getPaperName())) < 4) {
                    $entity->setUpdatedAt($dateTime);
                    $paperName = $this->getPaperName($entity);
                    $entity->setPaperName($paperName);
                    $entity->setPaperInstruction(trim($entity->getPaperInstruction()));
                }
                
                return $question_paper_repository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else { // creating new question paper entity
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $paperName = $this->getPaperName($entity); // get modified paper name ...
                $entity->setPaperName($paperName)->setPaperInstruction(trim($entity->getPaperInstruction())); // set paper name to the new modified one ...
                
                $entity->setInstitution($this->_institutionService->getInstitutionFromAuthService())
                    ->setCreatedAt($dateTime)
                    ->setUpdatedAt($dateTime);
                
                $department = $this->_departmentService->getDepartmentFromAuthService();
                ! is_null($department) ? $entity->setDepartment($department) : '';
                
                return $question_paper_repository->insert($entity)->getId() ? true : false;
            } else {
                /*
                 * var_dump($form->getMessages());
                 */
            }
        }
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\PaperServiceInterface::findQuestionPaper()
     */
    public function findQuestionPaper($id)
    {
        return $this->getQuestionPaperRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\PaperServiceInterface::findAllQuestionPapers()
     */
    public function findAllQuestionPapers()
    {
        return $this->getQuestionPaperRepository()->findAll();
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\PaperServiceInterface::deleteQuestionPaper()
     */
    public function deleteQuestionPaper(QuestionPaperInterface $questionPaper)
    {
        // TODO Auto-generated method stub
    }

    public function getExamPapers($examId = null)
    {
        $repository = $this->getQuestionPaperRepository();
        return $repository->getExamPapers($this->getZfcUserIdentity(), $examId);
    }

    public function getQuestionPapersHtml()
    {
        $path = '/module/Admin/view/admin/question-paper/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        
        foreach ($this->findQuestionPaperBy($this->getFilterPaperCriteria()) as $questionPaper) {
            $count += 1;
            $status = (int) $questionPaper->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=question_paper-edit-" . $questionPaper->getId() . ">Edit</option>
                            <option value=question_paper-delete-" . $questionPaper->getId() . ">Delete</option>
                        </select>";
            
            $institution = $this->_institutionService->findInstitution($questionPaper->getInstitution()
                ->getId())
                ->getInstName();
            $department = $this->_departmentService->findDepartment($questionPaper->getDepartment()
                ->getId())
                ->getDeptName();
            
            $html .= "<tr><td>" . $count . "</td><td>" . $questionPaper->getPaperName() . "</td><td>" . $questionPaper->getPaperDuration() . " min</td><td>" . $questionPaper->getPaperDescription() . "</td><td>" . $questionPaper->getPaperSubject()->getSubjectName() . "</td><td>" . $questionPaper->getPaperExam()->getExamName() . "</td><td>" . $questionPaper->getPaperYear() . "</td><td>" . $questionPaper->getPaperInstruction() . "</td><td>" . $institution . "</td><td>" . $department . "</td><td>" . $questionPaper->getExamMonth()->getExamMonth() . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    protected function getFilterPaperCriteria()
    {
        $criteria = [];
        $criteria['institution'] = $this->_institutionService->getInstitutionFromAuthService();
        $department = $this->_departmentService->getDepartmentFromAuthService();
        ! is_null($department) ? $criteria['department'] = $department : '';
        return $criteria;
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\PaperServiceInterface::findQuestionPaperBy()
     */
    public function findQuestionPaperBy($criteria)
    {
        return $this->getQuestionPaperRepository()->findBy($criteria);
    }

    public function getEntityDataArray($entityId)
    {
        $questionPaper = $this->findQuestionPaper($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $questionPaper->getId()
            ],
            [
                'id' => 'paperExam',
                'value' => $questionPaper->getPaperExam()->getId()
            ],
            [
                'id' => 'paperSubject',
                'value' => $questionPaper->getPaperSubject()->getId()
            ],
            [
                'id' => 'paperName',
                'value' => $questionPaper->getPaperName()
            ],
            [
                'id' => 'paperYear',
                'value' => $questionPaper->getPaperYear()
            ],
            [
                'id' => 'examMonth',
                'value' => $questionPaper->getExamMonth()->getId()
            ],
            [
                'id' => 'paperDuration',
                'value' => $questionPaper->getPaperDuration()
            ],
            [
                'id' => 'paperInstruction',
                'value' => $questionPaper->getPaperInstruction()
            ],
            [
                'id' => 'paperDescription',
                'value' => $questionPaper->getPaperDescription()
            ],
            [
                'id' => 'department',
                'value' => $questionPaper->getDepartment()->getId()
            ],
            [
                'id' => 'isActive',
                'value' => $questionPaper->getIsActive()
            ]
        );
    }
}