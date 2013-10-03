<?php

defined('APPLICATION_ROOT')
    || define('APPLICATION_ROOT', realpath(__DIR__ . '/../'));
defined('DOMAINNAME')
	|| define('DOMAINNAME', 'http://dev.mallrat.com');
require_once APPLICATION_ROOT . '/application/Init.php';

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();