<?php
namespace Admin\Service\Answer;

use Admin\Service\Contract\Answer\OptionServiceInterface as AnswerOptionServiceInterface;
// use Admin\Entity\Contract\AnswerOptionInterface;
use Admin\Repository\Answer\OptionRepository as AnswerOptionRepository;
use Base\Service\BaseService;
use Admin\Entity\Answer\Option as AnswerOptionEntity;
use Zend\ServiceManager\ServiceLocatorInterface;

class OptionService extends BaseService implements AnswerOptionServiceInterface
{

    protected $_answerOptionRepository;

    protected $_answerOptionEntity;

    protected $_departmentService;

    protected $_institutionService;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setAnswerOptionRepository($this->getServiceLocator()
            ->get('examsqa_admin_answer_option_repository'));
        
        $this->_departmentService = $this->getServiceLocator()->get('examsqa_admin_department_service');
        $this->_institutionService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        
        if (is_null($this->_answerOptionEntity)) {
            $this->_answerOptionEntity = new AnswerOptionEntity();
        }
    }

    protected function _setAnswerOptionRepository(AnswerOptionRepository $examsqa_answer_option_repository)
    {
        $this->_answerOptionRepository = $examsqa_answer_option_repository;
    }

    public function getAnswerOptionRepository()
    {
        return $this->_answerOptionRepository;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\AnswerOptionServiceInterface::findAllAnswerOptions()
     */
    public function findAllAnswerOptions()
    {
        return $this->getAnswerOptionRepository()->findAll();
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\AnswerOptionServiceInterface::findAnswerOption()
     */
    public function findAnswerOption($id)
    {
        return $this->getAnswerOptionRepository()->findById($id);
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\AnswerOptionServiceInterface::findAnswerOptionsByQuestion()
     */
    public function findAnswerOptionsByQuestion($questionId)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\AnswerOptionServiceInterface::findCorrectAnswerOptionsByQuestion()
     */
    public function findCorrectAnswerOptionsByQuestion($questionId)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\AnswerOptionServiceInterface::saveAnswerOption()
     */
    public function saveAnswerOption($post)
    {
        // this action will perform both create and update operation on Exam object ...
        $answerOptionRepository = $this->getAnswerOptionRepository();
        $dateTime = new \DateTime("now");
        $id = $post['answer-option-fieldset']['id'];
        
        if ($id) { // updating existing level entity ...
            $form = $this->getServiceLocator()->get('examsqa_admin_answer_option_form'); // Create the exam form
            $answerOptionRepository->setEntityClass($this->_answerOptionEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $answerOptionRepository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else { // creating new level entity
            $isSuccessful = true;
            foreach ($post['options'] as $option) {
                $option['id'] = '';
                $post['answer-option-fieldset'] = $option;
                
                $form = $this->getServiceLocator()->get('examsqa_admin_answer_option_form'); // Create the exam form
                $form->setData($post);
                
                if ($form->isValid()) {
                    $entity = $form->getData();
                    $entityRow = $this->createEntityRow($entity, $dateTime);
                    if (! $answerOptionRepository->insert($entityRow)->getId()) {
                        $isSuccessful = false;
                        throw new \Exception('Error occur while saving collection of answer options ...!');
                    }
                } else {
                    throw new \Exception($form->getMessages());
                }
            }
            return $isSuccessful;
        }
    }

    public function getCorrectOptions($options){
        $correctOptions = [];
        foreach ($options as $option){
            $correctOptions[] = [
                'id' => $option->getId(),
                'value' => (int) $option->getIsCorrect() == 1 ? true : false
            ];
        }
        
        return json_encode($correctOptions);
    }
    
    protected function createEntityRow($entity, $dateTime)
    {
        $answerOption = new AnswerOptionEntity();
        $answerOption->setInstitution($entity->getQuestion()
            ->getInstitution())
            ->setDepartment($entity->getQuestion()
            ->getDepartment())
            ->setOptionText($entity->getOptionText())
            ->setQuestion($entity->getQuestion())
            ->setQuestionExam($entity->getQuestionExam())
            ->setQuestionPaper($entity->getQuestionPaper())
            ->setQuestionSection($entity->getQuestionSection())
            ->setIsCorrect($entity->getIsCorrect())
            ->setIsActive($entity->getIsActive())
            ->setCreatedAt($dateTime)
            ->setUpdatedAt($dateTime);
        return $answerOption;
    }

    public function getAnswerOptionsHtml()
    {
        $path = '/module/Admin/view/admin/answer-option/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        return $fileParts[0] . $fileParts[1];
    }

    public function getAnswerOptions($post)
    {
        $checkboxElementFileParts = $this->getCheckboxElementHtml();
        
        $answerOptionRepository = $this->getAnswerOptionRepository();
        $options = $answerOptionRepository->getAnswerOptions($post->toArray(), $this->getZfcUserIdentity());
        $answerOptions = [];
        
        foreach ($options as $option) {
            $isCorrect = (int) $option->getIsCorrect() == 1 ? 'checked' : '';
            $isActive = (int) $option->getIsActive() == 1 ? 'checked' : '';
            
            $toggleCorrect = $checkboxElementFileParts[0] . $isCorrect . " id = 'answer_option-" . $option->getId() . "-check-correct-status'" . $checkboxElementFileParts[1];
            $toggleStatus = $checkboxElementFileParts[0] . $isActive . " id = 'answer_option-" . $option->getId() . "-check-active-status'" . $checkboxElementFileParts[1];
            
            $action = " <select data-key='delete-saved-answer-option' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=answer-option-" . $option->getId() . "-edit-saved>Edit Text</option>
                            <option value=answer-option-" . $option->getId() . "-delete-saved>Delete</option>
                        </select>";
            
            // "<a href='javascript:;' class = 'remove-saved-answer-option' id = 'answer-option-" . $option->getId() . "-saved'>Remove</a>"
            
            $answerOption = [];
            $answerOption[] = $option->getQuestionExam()->getExamCode();
            $answerOption[] = $option->getQuestionPaper()->getPaperName();
            $answerOption[] = $option->getQuestionSection()->getSectionName();
            $answerOption[] = $option->getQuestion()->getQuestionTag();
            $answerOption[] = strlen($option->getOptionText()) > 40 ? substr ($option->getOptionText(), 0, 40).'...' : $option->getOptionText();
            $answerOption[] = $toggleStatus;
            $answerOption[] = $toggleCorrect;
            $answerOption[] = $action;
            $answerOptions[] = $answerOption;
        }
        return $answerOptions;
    }

    public function getTinyMCEtextarea($post)
    {
        $path = '/module/Admin/view/admin/common/form/elements/answer-option/text.phtml';
        $tinyMCE = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        
        $answerOptionRepository = $this->getAnswerOptionRepository();
        $option = $answerOptionRepository->find($post['option_id']);
        $parts = explode('></textarea>', $tinyMCE);
        return $parts[0] . "id='questionText-" . $option->getId()."'>" . $option->getOptionText() . '</textarea>' . $parts[1]; 
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\AnswerOptionServiceInterface::deleteAnswerOption()
     */
    public function deleteAnswerOption($answerOptionId)
    {
        $answerOptionRepository = $this->getAnswerOptionRepository();
        $entity = $answerOptionRepository->find($answerOptionId);
        return $answerOptionRepository->delete($entity);
    }

    public function updateActiveStatus($post)
    {
        $answerOptionRepository = $this->getAnswerOptionRepository();
        $entity = $answerOptionRepository->find($post['entity_id']);
        $entity->setIsActive($post['value']);
        return $answerOptionRepository->update($entity)->getId() ? true : false;
    }

    public function updateCorrectStatus($post)
    {
        $answerOptionRepository = $this->getAnswerOptionRepository();
        $entity = $answerOptionRepository->find($post['entity_id']);
        $entity->setIsCorrect($post['value']);
        return $answerOptionRepository->update($entity)->getId() ? true : false;
    }
    
    public function updateOptionText($post){
        $answerOptionRepository = $this->getAnswerOptionRepository();
        $entity = $answerOptionRepository->find($post['option_id']);
        $entity->setOptionText($post['questionText']);
        return $answerOptionRepository->update($entity)->getId() ? true : false;
    }
    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $answerOption = $this->findAnswerOption($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $answerOption->getId()
            ],
            [
                'id' => 'levelName',
                'value' => $answerOption->getLevelName()
            ],
            [
                'id' => 'levelCode',
                'value' => $answerOption->getLevelCode()
            ],
            [
                'id' => 'levelDescription',
                'value' => $answerOption->getLevelDescription()
            ],
            [
                'id' => 'isActive',
                'value' => $answerOption->getIsActive()
            ]
        );
    }
}