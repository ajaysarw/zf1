<?php

// Define path to application directory ///var/www/myproject.com/application
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));



// Default setting
// Define application environment //production
//defined('APPLICATION_ENV')    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Customized: 15-08-2015
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', ($_SERVER['SERVER_ADDR'] != '127.0.0.1' ? 'production' : 'development'));

//echo APPLICATION_ENV;

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

//echo get_include_path();

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();