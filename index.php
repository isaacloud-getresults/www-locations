<?php


/**
 * @author Arnold Sikorski <asikorski@sointeractive.pl>
 */

/** Setup environment variables * */
defined('VENDOR_PATH') || define('VENDOR_PATH', realpath(__DIR__ .'/vendor'));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__ . '/app'));
defined('TEMPLATES_PATH') || define('TEMPLATES_PATH', realpath(__DIR__ . '/templates'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));




defined('SLIM_PATH') || define('SLIM_PATH', realpath(__DIR__ . '/Slim'));

require SLIM_PATH . '/Slim.php';
\Slim\Slim::registerAutoloader();





/** Composer autoloader * */
require VENDOR_PATH . '/autoload.php';



require APPLICATION_PATH . '/app2.php';


?>