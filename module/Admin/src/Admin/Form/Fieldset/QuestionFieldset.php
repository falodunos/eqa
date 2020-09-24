<?php
namespace Admin\Form\Fieldset;

use Admin\Entity\Question;
use Admin\Repository\Contract\QuestionRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QuestionFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    protected $_questionService;

    public function __construct(QuestionRepositoryInterface $questionRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('question-fieldset');
        
        $question = new Question();
        $this->_entityManager = $questionRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($question);
        $this->_questionService = $serviceLocator->get('examsqa_admin_question_service');
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'name' => 'questionPaper',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'questionPaper',
                'class' => 'form-control',
                'data-key' => 'question-paper-selected'
            ),
            'options' => array(
                'label' => 'Question Paper',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Question\Paper',
                'property' => 'paperName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Paper -',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => $this->_questionService->getInstitutionDepartmentSelectFilterCriteria()
                    )
                )
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
            'name' => 'questionType',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'questionType',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Question Type',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Question\Type',
                'property' => 'typeName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Type -'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'questionTag',
            'attributes' => array(
                'id' => 'questionTag',
                'class' => 'form-control',
                'placeholder' => 'Tag or number should be unique',
                'readonly' => 'true'
            ),
            'options' => array(
                'label' => 'Question No.'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'questionText',
            'attributes' => array(
                'id' => 'questionText',
                'class' => 'form-control',
                'placeholder' => 'Type question here',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Question Text'
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
                'target_class' => 'Base\Entity\Status',
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
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => [
                'required' => false
            ],
            'questionPaper' => [
                'required' => true
            ],
            'questionSection' => [
                'required' => true
            ],
            'questionType' => [
                'required' => true
            ],
            'questionText' => [
                'required' => true
            ],
            'isActive' => [
                'required' => true
            ]
        );
    }
}