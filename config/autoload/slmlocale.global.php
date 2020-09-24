<?php
/**
 * SlmLocale Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
$settings = array(
    /**
     * Default locale
     *
     * Some good description here. Default is something
     *
     * Accepted is something else
     */
    //'default' => 'en_US',
    
    /**
     * Supported locales
     *
     * Some good description here. Default is something
     *
     * Accepted is something else
     */
    'supported' => array(
        'en_US',
        'fr_FR'
    ),
    'langs' => array(
        'en_US' => 'English',
        'fr_FR' => 'French'
    ),
    
    /**
     * Strategies
     *
     * Some good description here. Default is something
     *
     * Accepted is something else
     */
    'strategies' => array('query', 'cookie', 'acceptlanguage'),
//     'strategies' => array(
//         array(
//             'name' => 'query',
//             'priority' => 4
//         ),
//         array(
//             'name' => 'cookie',
//             'priority' => 3
//         ),
//         array(
//             'name' => 'host',
//             'priority' => 2,
//             'options' => array(
//                 'domain' => 'http://localhost:8080.:locale',
//                 'aliases' => array('com' => 'en-US', 'co.uk' => 'en-GB'),
//             )
//         ),
//         array(
//             'name' => 'acceptlanguage',
//             'priority' => 1
//         )
//     )
);
/**
 * End of SlmLocale configuration
 */

/**
 * You do not need to edit below this line
 */
return array(
    'slm_locale' => $settings
);
