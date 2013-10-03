<?php

// Environment constants
define('ENV_PRODUCTION', 'production');
define('ENV_DEVELOPMENT', 'development');
define('ENV_STAGING', 'staging');
define('ENV_LOCALHOST', 'localhost');

// Setup environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', ENV_LOCALHOST);