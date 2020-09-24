<?php
namespace Admin\Form\Fieldset\Exam;

use Admin\Entity\Exam\Level as LevelEntity;
use Admin\Repository\Contract\Exam\LevelRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class LevelFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(LevelRepositoryInterface $levelRepository)
    {
        parent::__construct('level-fieldset');
        $level = new LevelEntity();
        $this->_entityManager = $levelRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($level);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'levelName',
            'attributes' => array(
                'id' => 'levelName',
                'class' => 'form-control',
                'placeholder' => 'Level Name'
            ),
            'options' => array(
                'label' => 'Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'levelCode',
            'options' => array(
                'label' => 'Code'
            ),
            'attributes' => array(
                'id' => 'levelCode',
                'class' => 'form-control',
                'placeholder' => 'Level Code'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'levelDescription',
            'options' => array(
                'label' => 'Description'
            ),
            'attributes' => array(
                'id' => 'levelDescription',
                'class' => 'form-control',
                'placeholder' => 'Level Description',
                'rows' => 4
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
                'empty_item_label' => '- Select Institution -',
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
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
            'levelName' => array(
                'required' => true
            ),
            'levelCode' => array(
                'required' => true
            ),
            'levelDescription' => array(
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