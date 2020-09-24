<?php
namespace Admin;

return [
    'form_elements' => [
        'factories' => []
        // 'examsqa_admin_question_image_form' => 'Admin\Form\Factory\Question\ImageFormFactory'
        
    ],
    'service_manager' => [
        'invokables' => [
            'examsqa_admin_academic_institution_entity' => 'Admin\Entity\Academic\Institution',
            'examsqa_admin_academic_department_entity' => 'Admin\Entity\Academic\Department',
            
            'examsqa_admin_answer_option_entity' => 'Admin\Entity\Answer\Option',
            
            'examsqa_admin_exam_certificate_entity' => 'Admin\Entity\Exam\Certificate',
            'examsqa_admin_exam_exam_entity' => 'Admin\Entity\Exam',
            'examsqa_admin_exam_level_entity' => 'Admin\Entity\Exam\Level',
            'examsqa_admin_exam_month_entity' => 'Admin\Entity\Exam\Month',
            
            'examsqa_admin_question_question_entity' => 'Admin\Entity\Question',
            'examsqa_admin_question_questionimage_entity' => 'Admin\Entity\Question\Image',
            'examsqa_admin_question_questionpaper_entity' => 'Admin\Entity\Question\Paper',
            'examsqa_admin_question_questionsection_entity' => 'Admin\Entity\Question\Section',
            'examsqa_admin_question_questiontype_entity' => 'Admin\Entity\Question\Type',
            
            'examsqa_admin_subject_subject_entity' => 'Admin\Entity\Subject'
        ],
        
        'factories' => [
            // Forms Configuration
            'examsqa_admin_exam_form' => 'Admin\Form\Factory\ExamFormFactory',
            'examsqa_admin_subject_form' => 'Admin\Form\Factory\SubjectFormFactory',
            'examsqa_admin_level_form' => 'Admin\Form\Factory\Exam\LevelFormFactory',
            'examsqa_admin_certificate_form' => 'Admin\Form\Factory\Exam\CertificateFormFactory',
            'examsqa_admin_question_paper_form' => 'Admin\Form\Factory\Question\PaperFormFactory',
            'examsqa_admin_exam_month_form' => 'Admin\Form\Factory\Exam\MonthFormFactory',
            'examsqa_admin_question_section_form' => 'Admin\Form\Factory\Question\SectionFormFactory',
            'examsqa_admin_question_form' => 'Admin\Form\Factory\QuestionFormFactory',
            'examsqa_admin_question_type_form' => 'Admin\Form\Factory\Question\TypeFormFactory',
            'examsqa_admin_answer_option_form' => 'Admin\Form\Factory\Answer\OptionFormFactory',
            'examsqa_admin_question_image_form' => 'Admin\Form\Factory\Question\ImageFormFactory',
            'examsqa_admin_institution_form' => 'Admin\Form\Factory\Academic\InstitutionFormFactory',
            'examsqa_admin_department_form' => 'Admin\Form\Factory\Academic\DepartmentFormFactory',
            'examsqa_admin_permission_add_user_form' => 'Admin\Form\Factory\Permission\User\AddFormFactory',
            
            
            // Repositories Configuration
            'examsqa_admin_exam_repository' => 'Admin\Repository\Factory\ExamRepositoryFactory',
            'examsqa_admin_level_repository' => 'Admin\Repository\Factory\Exam\LevelRepositoryFactory',
            'examsqa_admin_subject_repository' => 'Admin\Repository\Factory\SubjectRepositoryFactory',
            'examsqa_admin_certificate_repository' => 'Admin\Repository\Factory\Exam\CertificateRepositoryFactory',
            'examsqa_admin_question_paper_repository' => 'Admin\Repository\Factory\Question\PaperRepositoryFactory',
            'examsqa_admin_exam_month_repository' => 'Admin\Repository\Factory\Exam\MonthRepositoryFactory',
            'examsqa_admin_question_section_repository' => 'Admin\Repository\Factory\Question\SectionRepositoryFactory',
            'examsqa_admin_question_repository' => 'Admin\Repository\Factory\QuestionRepositoryFactory',
            'examsqa_admin_question_type_repository' => 'Admin\Repository\Factory\Question\TypeRepositoryFactory',
            'examsqa_admin_department_repository' => 'Admin\Repository\Factory\Academic\DepartmentRepositoryFactory',
            'examsqa_admin_institution_repository' => 'Admin\Repository\Factory\Academic\InstitutionRepositoryFactory',
            'examsqa_admin_answer_option_repository' => 'Admin\Repository\Factory\Answer\OptionRepositoryFactory',
            'examsqa_admin_question_image_repository' => 'Admin\Repository\Factory\Question\ImageRepositoryFactory',
            
            
            // Service Configuration
            'examsqa_admin_exam_service' => 'Admin\Service\Factory\ExamServiceFactory',
            'examsqa_admin_level_service' => 'Admin\Service\Factory\Exam\LevelServiceFactory',
            'examsqa_admin_certificate_service' => 'Admin\Service\Factory\Exam\CertificateServiceFactory',
            'examsqa_admin_subject_service' => 'Admin\Service\Factory\SubjectServiceFactory',
            'examsqa_admin_question_paper_service' => 'Admin\Service\Factory\Question\PaperServiceFactory',
            'examsqa_admin_exam_month_service' => 'Admin\Service\Factory\Exam\MonthServiceFactory',
            'examsqa_admin_question_section_service' => 'Admin\Service\Factory\Question\SectionServiceFactory',
            'examsqa_admin_question_service' => 'Admin\Service\Factory\QuestionServiceFactory',
            'examsqa_admin_question_type_service' => 'Admin\Service\Factory\Question\TypeServiceFactory',
            'examsqa_admin_department_service' => 'Admin\Service\Factory\Academic\DepartmentServiceFactory',
            'examsqa_admin_institution_service' => 'Admin\Service\Factory\Academic\InstitutionServiceFactory',
            'examsqa_admin_answer_option_service' => 'Admin\Service\Factory\Answer\OptionServiceFactory',
            'examsqa_admin_question_image_service' => 'Admin\Service\Factory\Question\ImageServiceFactory',
            'examsqa_admin_dashboard_service' => 'Admin\Service\Factory\DashboardServiceFactory'
        ]
    ],
    'view_helpers' => [
        'factories' => [
            'getBreadcrumbWidget' => 'Admin\View\Helper\Page\Factory\BreadcrumbWidgetFactory',
            'getEntityListWidget' => 'Admin\View\Helper\Entity\Factory\ListWidgetFactory'
        ]
    ],
    'controllers' => [
        'invokables' => [
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Ajax' => 'Admin\Controller\AjaxController',
            'Admin\Controller\Wysiwyg' => 'Admin\Controller\WysiwygController',
        ],
        'factories' => [
            'Admin\Controller\Exam' => 'Admin\Controller\Factory\ExamControllerFactory',
            'Admin\Controller\Level' => 'Admin\Controller\Factory\Exam\LevelControllerFactory',
            'Admin\Controller\Certificate' => 'Admin\Controller\Factory\Exam\CertificateControllerFactory',
            'Admin\Controller\Subject' => 'Admin\Controller\Factory\SubjectControllerFactory',
            'Admin\Controller\QuestionPaper' => 'Admin\Controller\Factory\Question\PaperControllerFactory',
            'Admin\Controller\ExamMonth' => 'Admin\Controller\Factory\Exam\MonthControllerFactory',
            'Admin\Controller\QuestionSection' => 'Admin\Controller\Factory\Question\SectionControllerFactory',
            'Admin\Controller\QuestionType' => 'Admin\Controller\Factory\Question\TypeControllerFactory',
            'Admin\Controller\Question' => 'Admin\Controller\Factory\QuestionControllerFactory',
            'Admin\Controller\AnswerOption' => 'Admin\Controller\Factory\Answer\OptionControllerFactory',
            'Admin\Controller\QuestionImage' => 'Admin\Controller\Factory\Question\ImageControllerFactory',
            'Admin\Controller\Institution' => 'Admin\Controller\Factory\Academic\InstitutionControllerFactory',
            'Admin\Controller\Department' => 'Admin\Controller\Factory\Academic\DepartmentControllerFactory',
            'Admin\Controller\Dashboard' => 'Admin\Controller\Factory\DashboardControllerFactory',
            'Admin\Controller\Permission' => 'Admin\Controller\Factory\PermissionControllerFactory'
        ]
    ],
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'ajax' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ],
                            'defaults' => []
                        ]
                    ],
                    'exam' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ],
                            'defaults' => []
                        ]
                    ],
                    'default' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/\[:controller[/:action\]\[/:lang\]]',
                            'constraints' => [
                                'controller' => '\[a-zA-Z\]\[a-zA-Z0-9_-\]*',
                                'action' => '\[a-zA-Z\]\[a-zA-Z0-9_-\]*',
                                'locale' => '[a-zA-Z]{2}_[a-zA-Z]{2}',
                            ],
                            'defaults' => [
                                'locale' => 'en_US'
                            ],
                        ],
                    ],
                ]
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ]
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
                'text_domain' => __NAMESPACE__,
            )
        )
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];