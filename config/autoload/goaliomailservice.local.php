<?php
/**
 * GoalioMailService Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
// $settings = array(

//     /**
//      * Transport Class
//      *
//      * Name of Zend Transport Class to use
//      */
//     'type' => 'Zend\Mail\Transport\File',

//     'options' => array(
// 	    'path'              => getcwd().'/data/mail/',
// 	),

//     /**
//      * End of GoalioMailService configuration
//      */
// );


/*
 GoalioMailService uses sendmail by default, but you can set it up to use SMTP by putting
 your information in the config file like this:
 */
$settings = array(
    'type' => 'Zend\Mail\Transport\Smtp',

    'options_class' => 'Zend\Mail\Transport\SmtpOptions',

    'options' => array(
        'host' => 'smtp.gmail.com',
        'connection_class' => 'login',
        'connection_config' => array(
            'ssl' => 'tls',
            'username' => '',
            'password' => ''
        ),
        'port' => 587
    )
);


/**
 * You do not need to edit below this line
 */
return array(
    'goaliomailservice' => $settings,
);