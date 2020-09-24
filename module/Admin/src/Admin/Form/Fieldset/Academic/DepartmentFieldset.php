<?php
namespace Admin\Form\Fieldset\Academic;

use Admin\Entity\Academic\Department as DepartmentEntity;
use Admin\Repository\Contract\Academic\DepartmentRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class DepartmentFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        parent::__construct('department-fieldset');
        
        $department = new DepartmentEntity();
        $this->_entityManager = $departmentRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($department);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'deptName',
            'attributes' => array(
                'id' => 'deptName',
                'class' => 'form-control',
                'placeholder' => 'Department Name'
            ),
            'options' => array(
                'label' => 'Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'deptDescription',
            'attributes' => array(
                'id' => 'deptDescription',
                'class' => 'form-control',
                'placeholder' => 'Department Description',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Description'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'deptAcronym',
            'attributes' => array(
                'id' => 'deptAcronym',
                'class' => 'form-control',
                'placeholder' => 'Department Acronym e.g. CSC'
            ),
            'options' => array(
                'label' => 'Acronym'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dateEstablished',
            'attributes' => array(
                'id' => 'dateEstablished',
                'class' => 'form-control hasDatepicker',
                'data-original-title' => '',
                'title' => 'Select Date'
            ),
            'options' => array(
                'label' => 'Date Established'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'contactPerson',
            'attributes' => array(
                'id' => 'contactPerson',
                'class' => 'form-control',
                'placeholder' => 'Name of Contact Person'
            ),
            'options' => array(
                'label' => 'Contact Person'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'deptPhone',
            'attributes' => array(
                'id' => 'deptPhone',
                'class' => 'form-control',
                'placeholder' => 'Department\'s Phone Number'
            ),
            'options' => array(
                'label' => 'Phone'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'deptEmail',
            'attributes' => array(
                'id' => 'deptEmail',
                'class' => 'form-control',
                'placeholder' => 'Department\'s Email'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'institution',
            'attributes' => array(
                'id' => 'institution'
            )
        ))
            ->add(array(
            'name' => 'institution',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'institution',
                'class' => 'form-control',
                'required' => true
            ),
            'options' => array(
                'label' => 'Institutions',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Academic\Institution',
                'property' => 'instName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Institution -'
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
            'id' => array(
                'required' => false
            ),
            'deptName' => array(
                'required' => true
            ),
            'deptDescription' => array(
                'required' => true
            ),
            'deptAcronym' => array(
                'required' => true
            ),
            'dateEstablished' => array(
                'required' => true
            ),
            'contactPerson' => array(
                'required' => true
            ),
            'deptPhone' => array(
                'required' => true
            ),
            'deptEmail' => array(
                'required' => true
            ),
            'institution' => array(
                'required' => false
            ),
            'isActive' => array(
                'required' => true
            )
        );
    }
}