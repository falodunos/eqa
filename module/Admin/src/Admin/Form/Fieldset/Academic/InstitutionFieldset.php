<?php
namespace Admin\Form\Fieldset\Academic;

use Admin\Entity\Academic\Institution as InstitutionEntity;
use Admin\Repository\Contract\Academic\InstitutionRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class InstitutionFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(InstitutionRepositoryInterface $instRepository)
    {
        parent::__construct('institution-fieldset');
        
        $institution = new InstitutionEntity();
        $this->_entityManager = $instRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($institution);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'instName',
            'attributes' => array(
                'required' => true,
                'id' => 'instName',
                'class' => 'form-control',
                'placeholder' => 'Institution Name e.g. The Federal University of Technology, Akure.'
            ),
            'options' => array(
                'label' => 'Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'instAcronym',
            
            'attributes' => array(
                'required' => true,
                'id' => 'instAcronym',
                'class' => 'form-control',
                'placeholder' => 'Institution Acronym e.g. FUTA'
            ),
            'options' => array(
                'label' => 'Acronym'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'instDescription',
            'attributes' => array(
                'required' => true,
                'id' => 'instDescription',
                'class' => 'form-control',
                'placeholder' => 'Institution Description',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Description'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dateEstablished',
            'attributes' => array(
                'required' => true,
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
            'name' => 'instPhone',
            'attributes' => array(
                'required' => true,
                'id' => 'instPhone',
                'class' => 'form-control',
                'placeholder' => 'Institution\'s Phone Number '
            ),
            'options' => array(
                'label' => 'Phone'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'instEmail',
            'attributes' => array(
                'required' => true,
                'id' => 'instEmail',
                'class' => 'form-control',
                'placeholder' => 'Institution\'s Email '
            ),
            'options' => array(
                'label' => 'Email'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'contactPerson',
            'attributes' => array(
                'required' => true,
                'id' => 'contactPerson',
                'class' => 'form-control',
                'placeholder' => 'Name of Contact Person'
            ),
            'options' => array(
                'label' => 'Contact Person'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'user',
            'attributes' => array(
                'id' => 'user'
            )
        ))
            ->add(array(
            'name' => 'isActive',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'required' => true,
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
            'user' => array(
                'required' => false
            ),
            'instName' => array(
                'required' => true,
            ),
            'instPhone' => array(
                'required' => true
            ),
            'dateEstablished' => array(
                'required' => true
            ),
            'instAcronym' => array(
                'required' => true
            ),
            'instEmail' => array(
                'required' => true
            ),
            'contactPerson' => array(
                'required' => true
            ),
            'instDescription' => array(
                'required' => true
            ),
            'isActive' => array(
                'required' => true
            )
        );
    }
}