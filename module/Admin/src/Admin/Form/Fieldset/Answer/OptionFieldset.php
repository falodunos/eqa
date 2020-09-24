<?php
namespace Admin\Form\Fieldset\Answer;

use Admin\Repository\Contract\Answer\OptionRepositoryInterface as AnswerOptionRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OptionFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;
    
    protected $_answerOptionService;

    public function __construct(AnswerOptionRepositoryInterface $optionRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('answer-option-fieldset');
        
        $answer_option = $serviceLocator->get('examsqa_admin_answer_option_entity');
        $this->_answerOptionService = $serviceLocator->get('examsqa_admin_answer_option_service');
        
        $user = $this->_answerOptionService->getZfcUserIdentity();
        $instId = !is_null($user->getIdentity()->getInstitution()) ? $user->getIdentity()->getInstitution()->getId() : null;
        $deptId = !is_null($user->getDepartment()) ? $user->getIdentity()->getDepartment()->getId() : null;
        
        $this->_entityManager = $optionRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($answer_option);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'name' => 'questionExam',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'questionExam',
                'class' => 'form-control',
                'data-key' => 'exam-selected'
            ),
            'options' => array(
                'label' => 'Exam',
                'object_manager' => $this->_entityManager,
                'target_class' => $serviceLocator->get('examsqa_admin_exam_exam_entity')
                    ->getEntityClass(),
                'property' => 'examName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Exam -',
                'is_method' => true,
                'find_method' => array(
                    // 'name' => 'getExamsByInstitutionAndDepartment'
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'isActive' => 1,
                            'institution' => $instId,
                            'department' => $deptId
                        )
                    )
                )
            )
        ))
            ->add(array(
            'name' => 'questionPaper',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'questionPaper',
                'class' => 'form-control',
                'data-key' => 'question-paper-selected'
            ),
            'options' => array(
                'label' => 'Question Paper',
                'value_options' => array(
                    '' => '- Select Paper -'
                ),
                'disable_inarray_validator' => true
            )
        ))
            ->add(array(
            'name' => 'questionSection',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'questionSection',
                'class' => 'form-control',
                'data-key' => 'question-section-selected'
            ),
            'options' => array(
                'label' => 'Question Section',
                'value_options' => array(
                    '' => '- Select Section -'
                ),
                'disable_inarray_validator' => true
            )
        ))
            ->add(array(
            'name' => 'question',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'question',
                'class' => 'form-control',
                'data-key' => 'question-selected'
            ),
            'options' => array(
                'label' => 'Question Tag',
                'value_options' => array(
                    '' => '- Select Question -'
                ),
                'disable_inarray_validator' => true
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'optionText',
            'attributes' => array(
                'id' => 'optionText',
                'class' => 'form-control',
                'placeholder' => 'Option Text',
                'rows' => 5
            ),
            'options' => array(
                'label' => 'Option Text'
            )
        ))
            ->add(array(
            'name' => 'isActive',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'isActive',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Status',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Exam\Level',
                'property' => array(
                    'statusName',
                    'statusValue'
                ),
                'display_empty_item' => true,
                'empty_item_label' => '- Select Status -',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'getStatusOptionsAsArrayKeyedByValue'
                )
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'isCorrect',
            'options' => array(
                'label' => 'Check as correct option',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'value' => '0',
                'id' => 'isCorrect'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'add-option',
            'options' => array(
                'label' => 'Add Option'
            ),
            'attributes' => array(
                'value' => 'Add Option',
                'class' => 'btn btn-success',
                'id' => 'add-option-btn'
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'id' => [
                'required' => false
            ],
            'questionExam' => [
                'required' => true
            ],
            'questionPaper' => [
                'required' => true
            ],
            'questionSection' => [
                'required' => true
            ],
            'question' => [
                'required' => true
            ],
            'optionText' => [
                'required' => true
            ],
            'isCorrect' => [
                'required' => true
            ],
            'isActive' => [
                'required' => true
            ]
        ];
    }
}