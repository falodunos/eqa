<?php
namespace Admin\Form\Permission\User;

use Base\Form\Fieldset\CommonFieldset;
use Base\Form\Base as BaseForm;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\InputFilter\InputFilter;

class AddForm extends BaseForm 
{

    protected $_serviceLocator ;
    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
        
        parent::__construct('add-user-form');
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'permission-add-user-form',
            'method' => 'post',
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'token',
            'attributes' => array(
                'id' => 'token',
                'class' => 'form-control',
                'placeholder' => 'Please the user\'s token'
            ),
            'options' => array(
                'label' => 'User\'s Token'
            )
        ));
        $this->add(array(
            'name' => 'department',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'department',
                'class' => 'form-control',
                'required' => true,
            ),
            'options' => array(
                'label' => 'Departments',
                'object_manager' => $this->_serviceLocator->get('doctrine.entitymanager.orm_default'),
                'target_class' => 'Admin\Entity\Academic\Department',
                'property' => 'deptName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Department -',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'getAdminInstitutionDepartments',
                    'params' => array(
                        'serviceLocator' => $this->_serviceLocator
                    )
                )
            )
        ));
        $this->add(new CommonFieldset());
        
        $this->setInputFilter($this->inputFilter());
    }
    
    protected function inputFilter(){
        $inputFilter = new InputFilter();
        return $inputFilter->add(array(
            'name' => 'department',
            'required' => false
        ));
    }
    
}