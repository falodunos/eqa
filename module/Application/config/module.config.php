<?php
namespace Application;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'view_helpers' => array(
        'invokables' => array(
            'FlashMessengerHelper' => 'Application\View\Helper\Notification\FlashMessengerHelper',
            'getProfileImageUrl' => 'Application\View\Helper\User\Image\ProfileUrl',
        ),
        'factories' => array(
            'getExamsQAUserRegisterForm' => 'Application\View\Helper\User\Factory\RegisterFormWidgetFactory',
            'getBannerWidget' => 'Application\View\Helper\Page\Factory\BannerWidgetFactory',
            'getForgotPasswordForm' => 'Application\View\Helper\User\Factory\ForgotPasswordFormWidgetFactory',
            'getRoleIsAvailable' => 'Application\View\Helper\Role\Factory\IsAvailableFactory',
            'getServiceManager' => 'Application\View\Helper\Service\Factory\ManagerFactory',
            'getNavbarWidget' => 'Application\View\Helper\Page\Factory\NavbarWidgetFactory',
        )
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                )
            ),
            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                
                'child_routes' => array(
                    'front' => [
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
                    ]
                ),
                'default' => array(
                      'type' => 'Segment',
                      'options' => array(
                        'route' => '/\[:controller[/:action\]\[/:lang\]]',
                        'constraints' => array(
                          'controller' => '\[a-zA-Z\]\[a-zA-Z0-9_-\]*',
                          'action' => '\[a-zA-Z\]\[a-zA-Z0-9_-\]*',
                          'locale' => '[a-zA-Z]{2}_[a-zA-Z]{2}',
                        ),
                        'defaults' => array(
                        'locale' => 'en_US'
                        ),
                      ),
                    ),
            ),
            'zfcuser' => array(
                'child_routes' => array(
                    'edit-profile' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/edit-profile',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'edit-profile',
                            ),
                        ),
                    ),
            ))
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            'examsqa_application_string_generator_service' => 'Application\Service\Generator\Strings',
            'examsqa_application_user_identity_entity' => 'Application\Entity\User\Identity'
        ),
        'factories' => array(
            // SERVICES
            'examsqa_application_service_formsevice' => 'Application\Service\Factory\FormServiceFactory',
            'examsqa_application_user_service' => 'Application\Service\Factory\UserServiceFactory',
            'examsqa_application_user_identity_service' => 'Application\Service\Factory\User\IdentityServiceFactory',
            'examsqa_application_role_service' => 'Application\Service\Factory\RoleServiceFactory',
            'examsqa_application_zend_session' => 'Application\Service\Factory\Authentication\Storage\SessionServiceFactory',
            
            // REPOSITORIES
            'examsqa_application_user_identity_repository' => 'Application\Repository\Factory\User\IdentityRepositoryFactory',
            'examsqa_application_user_repository' => 'Application\Repository\Factory\UserRepositoryFactory',
            'examsqa_application_role_repository' => 'Application\Repository\Factory\RoleRepositoryFactory',
            
            //FORM
            'examsqa_application_user_profile_form' => 'Application\Form\Factory\User\ProfileFormFactory'
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator'
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
                'text_domain' => __NAMESPACE__,
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\User' => 'Application\Controller\UserController'
        ),
        'factories' => array(
            'zfcuser' => 'Application\Controller\Factory\UserControllerFactory',
            'Application\Controller\Institution' => 'Application\Controller\Factory\Academic\InstitutionControllerFactory',
            'Application\Controller\QuestionPaper' => 'Application\Controller\Factory\Question\PaperControllerFactory',
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array()
        )
    ),
    
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'zfcuser_entity'
                )
            )
        )
    ),
    
    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class' => 'Application\Entity\User',
        
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false
    )
);
// 'bjyauthorize' => [
// 'default_role' => 'guest',
// 'unauthorized_strategy' => 'BjyAuthorize\View\RedirectionStrategy',
// 'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

// 'role_providers' => [
// 'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => [
// 'object_manager' => 'doctrine.entitymanager.orm_default',
// 'role_entity_class' => 'Application\Entity\Role'
// ]
// ],

// 'role_providers' => [
// \BjyAuthorize\Provider\Role\Config::class => [],

// \BjyAuthorize\Provider\Role\ObjectRepositoryProvider::class => [
// 'role_entity_class' => 'Application\Entity\Role', // class name of the entity representing the role
// 'object_manager' => 'doctrine.entitymanager.orm_default'
// ]
// ], // service name of the object manager

// 'resource_providers' => [
// 'BjyAuthorize\Provider\Resource\Config' => []
// ],
// 'rule_providers' => [
// 'BjyAuthorize\Provider\Rule\Config' => [
// 'allow' => [],
// 'deny' => []
// ]
// ],
// 'guards' => [
// \BjyAuthorize\Guard\Controller::class => [],
// \BjyAuthorize\Guard\Route::class => [
// []
// ]
// ]
// ]
