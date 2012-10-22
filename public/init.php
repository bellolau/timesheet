<?php

// Define path to root directory
if (!defined('DOCUMENT_ROOT')) {
	define('DOCUMENT_ROOT', realpath(dirname(__FILE__) . "/.."));
}

// Define path to application directory
if (!defined('APPLICATION_PATH')) {
	define('APPLICATION_PATH', DOCUMENT_ROOT . "/application");
}

if (!defined('APPLICATION_ENV')) {
    // Get environment variable set into virtual host
    $environment = getenv('APPLICATION_ENV');

    if ($environment === false) {
        define('APPLICATION_ENV', 'production');
    } else {
        define('APPLICATION_ENV', $environment);
    }
}

// Ensure /application and /library is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
	DOCUMENT_ROOT,
    DOCUMENT_ROOT . '/application',
	DOCUMENT_ROOT . '/library',
    DOCUMENT_ROOT . '/library/simukti/zf1',
	get_include_path()
)));

// Include Zend_Application
require_once('Zend/Application.php');

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
