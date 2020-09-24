<?php
namespace Admin\Service;

use Admin\Service\Contract\QuestionServiceInterface;
use Admin\Repository\QuestionRepository;
use Base\Service\BaseService;
use Admin\Entity\Question;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Entity\Contract\QuestionInterface;

class QuestionService extends BaseService implements QuestionServiceInterface
{

    protected $_questionRepository;

    protected $_departmentService;

    protected $_institutionService;

    protected $_questionEntity;

    protected $_questionPaperService;

    protected $_questionTypeService;

    protected $_questionSectionService;

    protected $_institution;

    protected $_department;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setQuestionRepository($this->getServiceLocator()
            ->get('examsqa_admin_question_repository'));
        
        $this->_departmentService = $this->getServiceLocator()->get('examsqa_admin_department_service');
        $this->_institutionService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        
        $this->_questionPaperService = $this->getServiceLocator()->get('examsqa_admin_question_paper_service');
        $this->_questionTypeService = $this->getServiceLocator()->get('examsqa_admin_question_type_service');
        $this->_questionSectionService = $this->getServiceLocator()->get('examsqa_admin_question_section_service');
        
        if (is_null($this->_questionEntity)) {
            $this->_questionEntity = new Question();
        }
        
        $this->_institution = $this->getZfcUserIdentity()->getInstitution();
        $this->_department = $this->getZfcUserIdentity()
            ->getIdentity()
            ->getDepartment();
        parent::__construct();
    }

    protected function _setQuestionRepository(QuestionRepository $examsqa_question_repository)
    {
        $this->_questionRepository = $examsqa_question_repository;
    }

    public function getQuestionRepository()
    {
        return $this->_questionRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\QuestionServiceInterface::findQuestion()
     */
    public function findQuestion($id)
    {
        return $this->getQuestionRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\QuestionServiceInterface::deleteQuestion()
     */
    public function deleteQuestion(QuestionInterface $question)
    {}

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\QuestionServiceInterface::findAllQuestionPapers()
     */
    public function findAllQuestions()
    {
        return $this->getQuestionRepository()->findAll();
    }

    protected function getQuestionInstitution()
    {
        if ($this->_auth->hasIdentity()) {
            $user = $this->_auth->getIdentity();
            return $user->getInstitution();
        }
    }

    protected function getQuestionDepartment()
    {
        if ($this->_auth->hasIdentity()) {
            $userIdentity = $this->_auth->getIdentity();
            return $userIdentity->getDepartment();
        }
    }

    public function getQuestionTag($post)
    {
        $paperId = $post['paperId'];
        $questionPaper = $this->_questionPaperService->findQuestionPaper($paperId);
        $questions = $this->findQuestionsBy(array(
            'questionPaper' => $questionPaper
        ));
        return count($questions) + 1;
    }

    public function findQuestionsBy($criteria)
    {
        return $this->getQuestionRepository()->findBy($criteria);
    }

    protected function validateQuestionTag($post)
    {
        $paperId = $post['question-fieldset']['questionPaper'];
        $questionPaper = $this->_questionPaperService->findQuestionPaper($paperId);
        $questions = $this->findQuestionsBy(array(
            'questionPaper' => $questionPaper
        ));
        
        return count($questions) + 1 == (int) $post['question-fieldset']['questionTag'] ? true : false;
    }

    public function saveQuestion($post)
    {
        // this action will perform both create and update operation on Question object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_question_form'); // Create the exam form
        $question_type_repository = $this->getQuestionRepository();
        $dateTime = new \DateTime("now");
        $id = $post['question-fieldset']['id'];
        
        $institution = $this->getQuestionInstitution();
        $department = $this->getQuestionDepartment();
        
        $questionPaper = $this->_questionPaperService->findQuestionPaper($post['question-fieldset']['questionPaper']);
        $questionSection = $this->_questionSectionService->findQuestionSection($post['question-fieldset']['questionSection']);
        $questionType = $this->_questionTypeService->findQuestionType($post['question-fieldset']['questionType']);
        
        if ($id) { // updating existing Qeustion entity ...
            $question_type_repository->setEntityClass($this->_questionEntity);
            $form->setData($post);
            
            if ($form->isValid()) {
                $questionTag = $this->findQuestion($id)->getQuestionTag(); // get existing question tag to prevent malicious override
                $entity = $form->getData();
                $entity->setQuestionPaper($questionPaper)
                    ->setQuestionSection($questionSection)
                    ->setQuestionType($questionType)
                    ->setUpdatedAt($dateTime)
                    ->setQuestionTag($questionTag);
                
                return $question_type_repository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else {
            if (! $this->validateQuestionTag($post)) {
                return false;
            }
            
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setInstitution($this->_institutionService->getInstitutionFromAuthService())
                    ->setQuestionPaper($questionPaper)
                    ->setQuestionSection($questionSection)
                    ->setQuestionType($questionType)
                    ->setCreatedAt($dateTime)
                    ->setUpdatedAt($dateTime);
                
                $department = $this->_departmentService->getDepartmentFromAuthService();
                ! is_null($department) ? $entity->setDepartment($department) : '';
                
                return $question_type_repository->insert($entity)->getId() ? true : false;
            }
        }
    }

    public function getSectionQuestions($sectionId = null)
    {
        $repository = $this->getQuestionRepository();
        return $repository->getSectionQuestions($this->getZfcUserIdentity(), $sectionId);
    }

    public function getQuestionsHtml()
    {
        $path = '/module/Admin/view/admin/question/index.phtml';
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
        
        foreach ($this->findQuestionsBy($criteria) as $question) {
            $count += 1;
            $status = (int) $question->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = "<select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=question-image-" . $question->getId() . ">Add Image</option>
                            <option value=question-edit-" . $question->getId() . ">Edit</option>
                            <option value=question-delete-" . $question->getId() . ">Delete</option>
                        </select>";
            $html .= "<tr><td>" . $count . "</td><td>" . $question->getQuestionPaper()->getPaperName() . "</a></td><td>" . $question->getQuestionSection()->getSectionName() . "</a></td><td>" . $question->getQuestionType()->getTypeName() . "</a></td><td>" . $question->getQuestionText() . "</td><td>" . 'answer' . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $question = $this->findQuestion($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $question->getId()
            ],
            [
                'id' => 'questionPaper',
                'value' => $question->getQuestionPaper()->getId()
            ],
            [
                'id' => 'questionSection',
                'value' => $question->getQuestionSection()->getId()
            ],
            [
                'id' => 'questionType',
                'value' => $question->getQuestionType()->getId()
            ],
            [
                'id' => 'questionTag',
                'value' => $question->getQuestionTag()
            ],
            [
                'id' => 'questionText',
                'value' => $question->getQuestionText()
            ],
            [
                'id' => 'isActive',
                'value' => $question->getIsActive()
            ]
        );
    }
}