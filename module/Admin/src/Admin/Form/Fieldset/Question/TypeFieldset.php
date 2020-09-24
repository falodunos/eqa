<?php
namespace Admin\Form\Fieldset\Question;

use Admin\Entity\Question\Type as QuestionType;
use Admin\Repository\Contract\Question\TypeRepositoryInterface as QuestionTypeRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class TypeFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(QuestionTypeRepositoryInterface $questionTypeRepository)
    {
        parent::__construct('question-type-fieldset');
        
        $questionType = new QuestionType();
        $this->_entityManager = $questionTypeRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($questionType);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'typeName',
            'attributes' => array(
                'id' => 'typeName',
                'class' => 'form-control',
                'placeholder' => 'Type Name'
            ),
            'options' => array(
                'label' => 'Type Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'typeDescription',
            'attributes' => array(
                'id' => 'typeDescription',
                'class' => 'form-control',
                'placeholder' => 'Type Description',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Description'
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
            'typeName' => [
                'required' => true
            ],
            'typeDescription' => [
                'required' => true
            ],
            'isActive' => [
                'required' => true
            ]
        );
    }
}