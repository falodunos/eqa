<?php
namespace Base\Form\Fieldset\Common;

use Base\Repository\Contract\BaseDbRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class DocumentFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(BaseDbRepositoryInterface $entityRepository, $entityInstance)
    {
        parent::__construct('document-upload-fieldset');
        
        $this->_entityManager = $entityRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($entityInstance);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'parentEntityId',
            'attributes' => array(
                'id' => 'parentEntityId'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'overiteExistingFile',
            'options' => array(
                'label' => 'Overite file if already exist.',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'value' => '0',
                'id' => 'overiteExistingFile'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'documentDescription',
            'options' => array(
                'label' => 'Document Description'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'documentDescription',
                'placeholder' => 'Fig. 1.2 : The Fourth Dimension of The Human Entity '
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'documentName',
            'options' => array(
                'label' => 'Click to Locate Your Document(s)'
            ),
            'attributes' => array(
                'class' => 'imgupload',
                'id' => 'documentName'
            )
        ))
        // 'multiple' => true
        
        
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
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'btnUploadFiles',
            'options' => array(
                'label' => 'Upload File'
            ),
            'attributes' => array(
                'value' => 'Save Image',
                'class' => 'btn btn-success',
                'id' => 'btnUploadFiles'
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => [
                'required' => false
            ],
            'documentDescription' => [
                'required' => true
            ],
            'documentName' => [
                'required' => false
            ],
            'parentEntityId' => [
                'required' => true
            ],
            'isActive' => [
                'required' => true
            ]
        );
    }
}