<?php
namespace Admin\Form\Fieldset\Question;

use Admin\Entity\Question\Paper as QuestionPaperEntity;
use Admin\Repository\Contract\Question\PaperRepositoryInterface as QuestionPaperRepositoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class PaperFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    protected $_subjectService;
    
    protected $_serviceLocator ;

    public function __construct(QuestionPaperRepositoryInterface $questionPaperRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('question-paper-fieldset');
        
        $questionPaper = new QuestionPaperEntity();
        $this->_serviceLocator = $serviceLocator;
        $this->_subjectService = $this->_serviceLocator->get('examsqa_admin_subject_service');
        $this->_entityManager = $questionPaperRepository->getEntityManager();
        
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($questionPaper);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'paperName',
            'attributes' => array(
                'id' => 'paperName',
                'class' => 'form-control',
                'placeholder' => 'Paper Name'
            ),
            'options' => array(
                'label' => 'Paper Name'
            )
        ))
            ->add(array(
            'name' => 'examMonth',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'examMonth',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Exam Month',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Exam\Month',
                'property' => 'examMonth',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Month -'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'paperYear',
            'attributes' => array(
                'id' => 'paperYear',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Year',
                'value_options' => $this->getYearOptionValues()
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Number',
            'name' => 'paperDuration',
            'attributes' => array(
                'id' => 'paperDuration',
                'class' => 'form-control',
                'placeholder' => 'Paper Duration (Min)',
                'min' => '1',
                'max' => '600',
                'step' => '1'
            ),
            'options' => array(
                'label' => 'Duration (Min)'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'paperDescription',
            'attributes' => array(
                'id' => 'paperDescription',
                'class' => 'form-control',
                'placeholder' => 'Paper Description',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Description'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'paperInstruction',
            'attributes' => array(
                'id' => 'paperInstruction',
                'class' => 'form-control',
                'placeholder' => 'Paper Instruction',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'Instruction'
            )
        ))
            ->add(array(
            'name' => 'paperSubject',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'paperSubject',
                'class' => 'form-control',
                'placeholder' => 'Paper Subject'
            ),
            'options' => array(
                'label' => 'Subject',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Subject',
                'property' => 'subjectName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Subject -',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => $this->_subjectService->getInstitutionDepartmentSelectFilterCriteria()
                    )
                )
            )
        ))
            ->add(array(
            'name' => 'paperExam',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'paperExam',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Exam',
                'object_manager' => $this->_entityManager,
                'target_class' => 'Admin\Entity\Exam',
                'property' => 'examName',
                'display_empty_item' => true,
                'empty_item_label' => '- Select Exam -',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => $this->_subjectService->getInstitutionDepartmentSelectFilterCriteria()
                    )
                )
            )
        ))->add(array(
            'name' => 'department',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'id' => 'department',
                'class' => 'form-control',
                'required' => true,
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
        ))->add(array(
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
        // $subjectFieldset = new SubjectFieldset($subjectRepository);
        // $this->add(array(
        // 'type' => 'Zend\Form\Element\Collection',
        // 'name' => 'subjects',
        // 'options' => array(
        // 'count' => 2,
        // 'target_element' => $subjectFieldset
        // )
        // ));
    }

    protected function getYearOptionValues()
    {
        $options = array(
            '' => '- Select Year -'
        );
        $currentYear = date('Y');
        $minYear = 1980;
        $Kount = 1;
        for ($i = $currentYear; $i >= $minYear; $i --) {
            $options[$i] = $i;
            ++ $Kount;
        }
        return $options;
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
            'paperYear' => array(
                'required' => true
            ),
            'paperName' => array(
                'required' => true
            ),
            'paperDuration' => array(
                'required' => true
            ),
            'paperInstruction' => array(
                'required' => true
            ),
            'paperSubject' => array(
                'required' => true
            ),
            'paperExam' => array(
                'required' => true
            ),
            'examMonth' => array(
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