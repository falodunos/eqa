<?php
namespace Admin\Form\Fieldset\Exam;

use Admin\Entity\Exam\Certificate;
use Doctrine\ORM\EntityManager as ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class CertificateFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(ObjectManager $entityManager)
    {
        parent::__construct('certificate-fieldset');
        
        $this->_entityManager = $entityManager;
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject(new Certificate());
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'certName',
            'attributes' => array(
                'id' => 'certName',
                'class' => 'form-control',
                'placeholder' => 'Certificate Name'
            ),
            'options' => array(
                'label' => 'Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'certCode',
            'attributes' => array(
                'id' => 'certCode',
                'class' => 'form-control',
                'placeholder' => 'Certificate Code'
            ),
            'options' => array(
                'label' => 'Code'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'certDescription',
            'attributes' => array(
                'id' => 'certDescription',
                'class' => 'form-control',
                'placeholder' => 'Certificate Description',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Description'
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
            'attributes' => array(
                'id' => 'isActive',
                'class' => 'form-control'
            ),
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Status',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Exam\Certificate',
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
            'certName' => array(
                'required' => true
            ),
            'certCode' => array(
                'required' => true
            ),
            'certDescription' => array(
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