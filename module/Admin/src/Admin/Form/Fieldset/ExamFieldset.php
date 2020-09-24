<?php
namespace Admin\Form\Fieldset;

use Admin\Entity\Exam as ExamEntity;
use Admin\Form\Fieldset\SubjectFieldset;
use Admin\Repository\Contract\ExamRepositoryInterface;
use Admin\Repository\Contract\SubjectRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExamFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(ExamRepositoryInterface $examRepository, SubjectRepositoryInterface $subjectRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('exam-fieldset');
        
        $exam = new ExamEntity();
        $this->_entityManager = $examRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($exam);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden',
            ),
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'examName',
            'attributes' => array(
                'id' => 'examName',
                'class' => 'form-control',
                'placeholder' => 'Exam Name'
            ),
            'options' => array(
                'label' => 'Name'
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
            'name' => 'examCode',
            'attributes' => array(
                'id' => 'examCode',
                'class' => 'form-control',
                'placeholder' => 'Exam Code'
            ),
            'options' => array(
                'label' => 'Code'
            )
        ))
            ->add(array(
            'name' => 'examLevel',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'examLevel',
                'class' => 'form-control',
                'placeholder' => 'Exam Level'
            ),
            'options' => array(
                'label' => 'Levels',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Exam\Level',
                'property' => 'levelName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Level -'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'examDescription',
            'attributes' => array(
                'id' => 'examDescription',
                'class' => 'form-control',
                'placeholder' => 'Exam Description',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Description'
            )
        ))
            ->add(array(
            'name' => 'examCertificate',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'examCertificate',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Certificates',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Exam\Certificate',
                'property' => 'certName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Certificate -'
            )
        ))
            ->add(array(
            'name' => 'isActive',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'isActive',
                'class' => 'form-control',
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
        $subjectFieldset = new SubjectFieldset($subjectRepository, $serviceLocator);
        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'subjects',
            'options' => array(
                'count' => 2,
                'target_element' => $subjectFieldset
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
            'examName' => array(
                'required' => true
            ),
            'dateEstablished' => array(
                'required' => true
            ),
            'examCode' => array(
                'required' => true
            ),
            'examLevel' => array(
                'required' => true
            ),
            'examCertificate' => array(
                'required' => true
            ),
            'examDescription' => array(
                'required' => true
            ),
            'isActive' => array(
                'required' => true
            )
        );
    }
}