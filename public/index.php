<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
//apache_setenv('APPLICATION_ENV', 'production'); //test out production mode
chdir(dirname(__DIR__));
// Setup autoloading

$http_host = ($_SERVER['SERVER_PORT'] == "80") ? "http://" : "https://";

defined('PUBLIC_URL')
    || define('PUBLIC_URL', $http_host.$_SERVER['HTTP_HOST']);	

defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', dirname(__FILE__));

defined('ROOT_PATH')
    || define('ROOT_PATH', dirname(__FILE__) . "/../");    

defined('UPLOADS_PATH')
    || define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');


require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
