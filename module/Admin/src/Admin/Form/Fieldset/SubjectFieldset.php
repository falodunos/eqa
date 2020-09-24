<?php
namespace Admin\Form\Fieldset;

use Admin\Entity\Subject as SubjectEntity;
use Admin\Repository\Contract\SubjectRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubjectFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;
    protected $_serviceLocator ;
    public function __construct(SubjectRepositoryInterface $subjectRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('subject-fieldset');
        $this->_serviceLocator = $serviceLocator;
        
        $subject = new SubjectEntity();
        $this->_entityManager = $subjectRepository->getEntityManager(); 
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($subject);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'subjectName',
            'attributes' => array(
                'id' => 'subjectName',
                'class' => 'form-control',
                'placeholder' => 'Subject Name'
            ),
            'options' => array(
                'label' => 'Subject Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'subjectCode',
            'attributes' => array(
                'id' => 'subjectCode',
                'class' => 'form-control',
                'placeholder' => 'Subject Code'
            ),
            'options' => array(
                'label' => 'Subject Code'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'subjectDescription',
            'attributes' => array(
                'id' => 'subjectDescription',
                'class' => 'form-control',
                'placeholder' => 'Subject Description',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Subject Description'
            )
        ))
            ->add(array(
            'name' => 'department',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'department',
                'class' => 'form-control',
                'required' => true
            ),
            'options' => array(
                'label' => 'Departments',
                'object_manager' => $this->_entityManager,
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
            'subjectName' => array(
                'required' => true
            ),
            'subjectCode' => array(
                'required' => true
            ),
            'subjectDescription' => array(
                'required' => true
            ),
            'department' => array(
                'required' => false
            ),
            'isActive' => array(
                'required' => true
            )
        );
    }
}