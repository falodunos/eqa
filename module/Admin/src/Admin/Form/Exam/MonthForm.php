<?php
namespace Admin\Form\Exam;

use Base\Form\Fieldset\CommonFieldset;
use Admin\Repository\Contract\Exam\MonthRepositoryInterface as ExamMonthRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Form\Base as BaseForm;
use Zend\InputFilter\InputFilter;
use Admin\Entity\Exam\Month;
use Zend\InputFilter\InputFilterProviderInterface;

class MonthForm extends BaseForm implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(ExamMonthRepositoryInterface $examMonthRepository)
    {
        parent::__construct('exam-month-registration-form');
        $this->_entityManager = $examMonthRepository->getEntityManager();
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-month-registration-form'
        ));
        
        // The form will hydrate an object of type "ExamMonth"
        $this->setHydrator(new DoctrineHydrator($examMonthRepository->getEntityManager()))->setObject(new Month())
            ->setInputFilter(new InputFilter());
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'examMonth',
            'options' => array(
                'label' => 'Exam Month'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'examMonth',
                'placeholder' => 'e.g. May-June'
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
        $this->add(new CommonFieldset());
    }
	/* (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     */
    public function getInputFilterSpecification()
    {
        return array(
            'examMonth' => array(
                'required' => true
            ),
            'isActive' => array(
                'required' => true
            ),
        );
    }

}