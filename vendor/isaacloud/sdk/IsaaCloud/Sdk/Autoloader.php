<?php
/**
 * IsaaCloud PHP Sdk (http://isaacloud.com/)
 * 
 * The Isaacloud PHP SDK can be used to access the IsaaCloud API through PHP. 
 * The user can make any number of request calls to the API.
 * 
 * Basics
 * 
 * This SDK can be used to connect to Isaacloud v1 REST API on api.isaacloud.com. Main class in "isaacloud", 
 * which gives the possibility to connect to the public api. It has convenience methods for delete, get, post, 
 * put and patch methods. In future it will also contain a wrapper, which will offer all 
 * methods defined by isaacloud raml api.
 * 
 * @link        https://github.com/isaacloud/php-sdk
 * @copyright 
 * @license
 */

/**
 * @namespace
 */
namespace IsaaCloud\Sdk;

/**
 * Autoloader
 *
 */
class Autoloader
{

    /**
     * Register autoloader
     *
     * @static
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'load'));
    }

    /**
     * Autoload a class
     * 
     * @static
     * @param  string $class
     * @return void
     */
    public static function load($class)
    {
        if (substr($class, 0, 13) == 'IsaaCloud\\Sdk') {

            $class = str_replace(
                array('\\'),
                array('/'),
                $class
            );
            
            $path = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . $class . '.php';            
            require_once (realpath($path));
        }
    }
}