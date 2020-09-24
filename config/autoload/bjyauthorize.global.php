<?php

// For PHP <= 5.4, you should replace any ::class references with strings
// remove the first \ and the ::class part and encase in single quotes
return [
    'bjyauthorize' => [
        // strategy service name for the strategy listener to be used when permission-related errors are detected
        'unauthorized_strategy' => 'BjyAuthorize\View\RedirectionStrategy',
        
        // set the 'guest' role as default (must be defined in a role provider)
        'default_role' => 'guest',

        /* this module uses a meta-role that inherits from any roles that should
         * be applied to the active user. the identity provider tells us which
         * roles the "identity role" should inherit from.
         * for ZfcUser, this will be your default identity provider
         * 'identity_provider' => \BjyAuthorize\Provider\Identity\ZfcUserZendDb::class,
        */

        /* If you only have a default role and an authenticated role, you can
         * use the 'AuthenticationIdentityProvider' to allow/restrict access
         * with the guards based on the state 'logged in' and 'not logged in'.
         *
         * 'default_role'       => 'guest',         // not authenticated
         * 'authenticated_role' => 'user',          // authenticated
         * 'identity_provider'  => \BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider::class,
         */
        'identity_provider' => \BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider::class,
        
        /* role providers simply provide a list of roles that should be inserted
         * into the Zend\Acl instance. the module comes with two providers, one
         * to specify roles in a config file and one to load roles using a
         * Zend\Db adapter.
         */
        'role_providers' => [
            /*
             * here, 'guest' and 'user are defined as top-level roles, with
             * 'admin' inheriting from user
             */
            \BjyAuthorize\Provider\Role\Config::class => [
                'guest' => [],
                'user' => [
                    'children' => [
                        'admin' => [
                            'children' => [
                                'operation-admin' => [
                                    'children' => [
                                        'supper-admin' => [
                                            'children' => [
                                                'root-admin' => []
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            
            // this will load roles from
            // the 'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' service
            \BjyAuthorize\Provider\Role\ObjectRepositoryProvider::class => [
                'role_entity_class' => 'Application\Entity\Role', // class name of the entity representing the role
                'object_manager' => 'doctrine.entitymanager.orm_default'
            ]
        ] // service name of the object manager

        ,
        // resource providers provide a list of resources that will be tracked
        // in the ACL. like roles, they can be hierarchical
        'resource_providers' => [
            'BjyAuthorize\Provider\Resource\Config' => [
//                 'zfcuser' => [],
                'Application\Controller\Index' => [],
                'Application\Controller\User' => [],
                'Application\Controller\Institution' => [],
                'Application\Controller\QuestionPaper' => [],
                
                'Admin\Controller\Index' => [],
                'Admin\Controller\Exam' => [],
                'Admin\Controller\Level' => [],
                'Admin\Controller\Certificate' => [],
                'Admin\Controller\Subject' => [],
                'Admin\Controller\QuestionPaper' => [],
                'Admin\Controller\ExamMonth' => [],
                'Admin\Controller\QuestionSection' => [],
                'Admin\Controller\QuestionType' => [],
                'Admin\Controller\Question' => [],
                'Admin\Controller\AnswerOption' => [],
                'Admin\Controller\QuestionImage' => [],
                'Admin\Controller\User' => [],
                'Admin\Controller\Permission' => [],
                'Admin\Controller\Institution' => [],
                'Admin\Controller\Department' => [],
                'Admin\Controller\Dashboard' => [],
                'Admin\Controller\Permission' => [],
                'Admin\Controller\Tinymce' => [],
                
                'goalioforgotpassword_forgot' => [],
                'ZF2I18n\Controller\Index' => []
            ]
            
        ],
        
        /* rules can be specified here with the format:
         * [roles (array), resource, [privilege (array|string), assertion])
         * assertions will be loaded using the service manager and must implement
         * Zend\Acl\Assertion\AssertionInterface.
         * *if you use assertions, define them using the service manager!*
         */
        'rule_providers' => [
            'BjyAuthorize\Provider\Rule\Config' => [
                'allow' => [
                    // allow guests and users (and admins, through inheritance)
                    // the "wear" privilege on the resource "pants"
                    // [['guest', 'user'), 'pants', 'wear'),
                    [
                        [
                            'guest'
                        ],
                        'goalioforgotpassword_forgot'
                    ],
                    [
                        [
                            'guest',
                            'user'
                        ],
                        'Application\Controller\Index'
                    ],

                    [
                        [
                            'user'
                        ],
                        ['Application\Controller\Institution', 'Application\Controller\QuestionPaper']
                    ],
                    [
                        [
                            'user'
                        ],
                        'ZF2I18n\Controller\Index'
                    ]
                ],
                // Don't mix allow/deny rules if you are using role inheritance.
                // There are some weird bugs.
                'deny' => [
//                     [
//                         [
//                             'admin'
//                         ],
//                         'goalioforgotpassword_forgot'
//                     ],
                ]
            ]
            // ...
            
            
        ],
        
        /*
         * Currently, only controller and route guards exist
         *
         * Consider enabling either the controller or the route guard depending on your needs.
         */
        'guards' => [
            /*
             * If this guard is specified here (i.e. it is enabled), it will block
             * access to all controllers and actions unless they are specified here.
             * You may omit the 'action' index to allow access to the entire controller
             */
            \BjyAuthorize\Guard\Controller::class => [
                [
                    'controller' => 'goalioforgotpassword_forgot',
                    'roles' => [
                        'guest',
                    ]
                ],                
                [
                    'controller' => 'Application\Controller\Index',
                    'roles' => [
                        'guest',
                        'user'
                    ]
                ],
                
                [
                    'controller' => 'Application\Controller\User',
                    'roles' => [
                        'guest',
                        'user'
                    ]
                ],
                [
                    'controller' => 'zfcuser',
                    'roles' => [
                        'guest',
                        'user'
                    ]
                ],
                [
                    'controller' => 'Application\Controller\Institution',
                    'roles' => [
                        'user'
                    ]
                ],
                [
                'controller' => 'Application\Controller\QuestionPaper',
                'roles' => [
                    'user'
                ]
                ],
                [
                'controller' => 'ZF2I18n\Controller\Index',
                'roles' => [
                    'user'
                ]
                ],
                [
                    'controller' => 'Admin\Controller\Index',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Exam',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Level',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Certificate',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Subject',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\QuestionPaper',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\ExamMonth',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\QuestionSection',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\QuestionType',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Question',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\AnswerOption',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\QuestionImage',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\User',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Permission',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Institution',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Department',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Dashboard',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Permission',
                    'roles' => [
                        'admin'
                    ]
                ],
                [
                    'controller' => 'Admin\Controller\Wysiwyg',
                    'roles' => [
                        'admin'
                    ]
                ]
            ]
        ]
    ]
];