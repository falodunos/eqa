<?php
namespace ForgotPassword;

return array(
    'controllers' => array(
        'invokables' => array(
            'goalioforgotpassword_forgot' => 'ForgotPassword\Controller\ForgotController',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'goalioforgotpassword_password_service' => 'ForgotPassword\Service\Password',
            'forgotpassword_password_entity' => 'ForgotPassword\Entity\GoalioForgot\Password'
        )
        ,
        'factories' => array(
            // GOALIO FORGOT PASSWORD
            'goalioforgotpassword_module_options' => 'ForgotPassword\Options\Service\ModuleOptionsFactory',
            'goalioforgotpassword_forgot_form' => 'GoalioForgotPassword\Form\Service\ForgotFactory',
            'goalioforgotpassword_reset_form' => 'GoalioForgotPassword\Form\Service\ResetFactory',
            'goalioforgotpassword_password_mapper' => 'ForgotPassword\Mapper\Service\PasswordFactory'
        )
    ),
    'router' => array(
        'routes' => array(
            'forgot-password' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/index',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'ForgotPassword\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
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
                )
            )
        )
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
                'text_domain' => __NAMESPACE__,
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ForgotPassword' => __DIR__ . '/../view'
        )
    ),
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
);
