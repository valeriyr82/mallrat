<?php

// General application structure
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', APPLICATION_ROOT . '/application');
defined('LIBRARY_PATH') ||
    define('LIBRARY_PATH', APPLICATION_ROOT . '/library');
defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', APPLICATION_ROOT . '/public');

// Setup environments
require_once APPLICATION_PATH . '/Environment.php';

// Ensure library/ is on include_path
set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            realpath(LIBRARY_PATH),
            get_include_path(),
        )
    )
);
