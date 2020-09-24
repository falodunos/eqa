<?php
namespace Admin\Form\Fieldset\Question;

use Admin\Entity\Question\Section as QuestionSection;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Repository\Contract\Question\SectionRepositoryInterface as QuestionSectionRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class SectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;
    
    protected $_questionSectionService;

    public function __construct(QuestionSectionRepositoryInterface $questionSectionRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('question-section-fieldset');
        
        $this->_questionSectionService = $serviceLocator->get('examsqa_admin_question_section_service');
        $questionSection = new QuestionSection();
        $this->_entityManager = $questionSectionRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($questionSection);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
        ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'sectionInfo',
            'attributes' => array(
                'id' => 'sectionInfo',
                'class' => 'form-control',
                'placeholder' => 'Section Information or Questions Introduction',
                'rows' => 4 
            ),
            'options' => array(
                'label' => 'Section Info'
            )
        ))
        ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'sectionName',
            'attributes' => array(
                'id' => 'sectionName',
                'class' => 'form-control',
                'placeholder' => 'Section Name'
            ),
            'options' => array(
                'label' => 'Section Name'
            )
        ))
        ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'sectionDescription',
            'attributes' => array(
                'id' => 'sectionDescription',
                'class' => 'form-control',
                'placeholder' => 'Section Description',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Description'
            )
        ))
        ->add(array(
            'name' => 'sectionPaper',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'sectionPaper',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Question Paper',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Question\Paper',
                'property' => 'paperName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Paper -',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => $this->_questionSectionService->getInstitutionDepartmentSelectFilterCriteria()
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
            'id' => ['required' => false],
            'sectionName' => ['required' => true],
            'sectionPaper' => ['required' => true],
            'sectionDescription' => ['required' => true],
            'isActive' => ['required' => true]
        );
    }
}