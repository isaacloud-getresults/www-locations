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
 * Exception class
 */
class Exception extends \RuntimeException 
{
    
    /**
     * Constructor
     * 
     * @param type $message
     * @param type $code
     * @return type
     */
    public function __construct($message = '', $code = 0) 
    {
        return parent::__construct($message, $code);
    }
}