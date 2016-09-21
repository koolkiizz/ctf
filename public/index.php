<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
/* Load BaseUrl from config ini */
$config_base_url = new Zend_Config_Ini(
        APPLICATION_PATH . '/configs/application.ini', 'custom');
$baseUrl = $config_base_url->baseHttp;
define('BASE_URL', $baseUrl);
$timezone = $config_base_url->timezone;
date_default_timezone_set($timezone);

$application->bootstrap()
            ->run();