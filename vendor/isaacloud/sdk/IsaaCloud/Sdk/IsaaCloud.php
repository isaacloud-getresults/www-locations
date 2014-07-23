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
 * Main Sdk Class
 * 
 * 
 */
class IsaaCloud extends \IsaaCloud\Sdk\Connector
{

    /**
     * Api url
     * @var string
     */    
    private $api = "https://api.isaacloud.com";
    
    /**
     * Oauth url
     * @var string
     */    
    private $oauth = "https://oauth.isaacloud.com";
    
    /**
     * Version
     * @var string
     */    
    private $version = "v1";
    
    /**
     * Parameters
     * @var type 
     */
    private $parameters = array();

    /**
     * Query parameters
     * @var type
     */    
    private $queryParameters = array();    
    
    /**
     * Path
     * @var type
     */    
    private $path = null;

    /**
     * Construct the isacloud object
     * 
     * @param type $config
     * @param type $api
     * @param type $oauth
     */
    public function __construct($config, $api = null, $oauth = null)
    {
        if ($api) {
            $this->api = $api;
        }        
        if ($oauth) {
            $this->oauth = $oauth;
        }
        
        parent::__construct($this->api, $this->oauth, $this->version, $config);
    }

    /**
     * Get base api url
     * @return type
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Get base oauth url
     * @return type
     */
    public function getOauth() 
    {
        return $this->oauth;
    }

    /**
     * Get base version
     * @return type
     */
    public function getVersion() 
    {
        return $this->version;
    }

    /**
     * Get token
     * @return type
     */
    public function getToken()
    {
        return $this->getAuthentication();
    }
    
    /**
     * Set up path
     * @param type $path
     * @return \IsaaCloud\Sdk\IsaaCloud
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function path($path) 
    {
        if (empty($path)) {
            throw new \IsaaCloud\Sdk\Exception("Path cannot be empty!", 3018);
        }

        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     * 
     * @return type
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get query parameters
     * 
     * @return type
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }        

    /**
     * Get parameters
     * 
     * @return type
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set AccessToken
     * 
     * @param type $token
     * @param type $tokenType
     * @return \IsaaCloud\Sdk\IsaaCloud
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function withToken($token, $tokenType = "Bearer")
    {
        if (empty($token)) {
            throw new \IsaaCloud\Sdk\Exception("AccessToken cannot be empty!", 3019);
        }
        
        $this->setOauthData(array(
            "access_token" => $token,
            "token_type" => $tokenType
        ));
        
        return $this;
    }
    
    /**
     * Add query parameters manually.
     * 
     * @param array $parameteres
     * @return \IsaaCloud\Sdk\IsaaCloud
     */
    public function withQueryParameters(array $parameters = array())
    {
        if (is_array($parameters) && !empty($parameters)) {
            foreach ($parameters as $key => $val) {
                if (is_array($val)) {
                     $this->queryParameters = array_merge($this->queryParameters, array($key => implode(",",$val)));
                } else {
                     $this->queryParameters = array_merge($this->queryParameters, array($key => $val));
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Uri parameters
     * 
     * @param array $parameters
     * @return \IsaaCloud\Sdk\IsaaCloud
     */
    public function withParameters(array $parameters = array())
    {
        if (is_array($parameters) && !empty($parameters)) {
            $this->parameters = array_merge($this->parameters, $parameters);
        }
        
        return $this;
    }    

    /**
     * Returns only the resources last updated between certain dates given as milliseconds. 
     * In case one of the queryParameters is Null, the limit is not set.
     *
     * @param type $from
     * @param type $to
     * @return \IsaaCloud\Sdk\IsaaCloud
     */
    public function withUpdatedAt($from = null, $to = null) 
    {
        if (!is_null($from)) {
            $this->queryParameters = array_merge($this->queryParameters, array("fromu" => $from));
        }        
        if (!is_null($to)) {
            $this->queryParameters = array_merge($this->queryParameters, array("tou" => $to));
        }
        
        return $this;
    }

    /**
     * Returns only the resources created between certain dates given as milliseconds. 
     * In case one of the queryParameters is Null, the limit is not set.
     * 
     * @param type $from
     * @param type $to
     * @return \IsaaCloud\Sdk\IsaaCloud
     */
    public function withCreatedAt($from = null, $to = null)
    {
        if (!is_null($from)) {
            $this->queryParameters = array_merge($this->queryParameters, array("fromc" => $from));
        }        
        if (!is_null($to)) {
            $this->queryParameters = array_merge($this->queryParameters, array("toc" => $to));
        }
        
        return $this;
    }

    /**
     *  Limits the number and defines the offset for the results, works only with list resources
     * 
     * @param type $limit
     * @param type $offset
     * @return \IsaaCloud\Sdk\IsaaCloud
     */
    public function withPaginator($limit = null, $offset = null) 
    {
        if (!(is_numeric($limit) || is_numeric($offset))) {
            throw new \IsaaCloud\Sdk\IsaaCloud("Invalid parameteres, limit and offset should be valid number!", 3020);
        }
        
        if (!is_null($offset)) {
            $this->queryParameters = array_merge($this->queryParameters, array("offset" => $offset));
        }
        if (!is_null($limit)) {
            $this->queryParameters = array_merge($this->queryParameters, array("limit" => $limit));
        }

        return $this;
    }

    /**
     * Returns only the the resources with segments' ids, which are in the list of the method
     * 
     * @return \IsaaCloud\Sdk\IsaaCloud
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function withSegments(/* polymorphic */)
    {
        $args = func_get_args();
        
        $segments = array();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $a) {
                    if (!is_numeric($a)) {
                        throw new \IsaaCloud\Sdk\Exception("Segment should be numeric!", 3021);
                    }
                    array_push($segments, $a);
                }                 
            } else {
                if (!is_numeric($arg)) {
                    throw new \IsaaCloud\Sdk\Exception("Segment should be numeric!", 3022);
                }                
                array_push($segments, $arg);
            }
        }

        if ($segments) {
            $this->queryParameters = array_merge($this->queryParameters, array("segments" => implode(",", $segments)));
        }
        
        return $this;
    }

    /**
     * Returns only the the resources with groups' ids, which are in the list of the method
     * 
     * @return \IsaaCloud\Sdk\IsaaCloud
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function withGroups(/* polymorphic */)
    {
        $args = func_get_args();
        
        $groups = array();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $a) {
                    if (!(is_numeric($a) || is_string($a))) {
                        throw new \IsaaCloud\Sdk\Exception("Groups queryParameters should be string or numeric!", 3023);
                    }
                    array_push($groups, $a);
                }                 
            } else {
                if (!(is_numeric($arg) || is_string($arg))) {
                    throw new \IsaaCloud\Sdk\Exception("Groups queryParameters should be string or numeric!", 3024);
                }                
                array_push($groups, $arg);
            }
        }

        if ($groups) {
            $this->queryParameters = array_merge($this->queryParameters, array("groups" => implode(",", $groups)));
        }
        
        return $this;        
    }
    
    /**
     * Retruns only the resources with ids, witch are in the list of method
     * 
     * @param array $ids
     * @return \IsaaCloud\Sdk\IsaaCloud
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function withIds(/* polymorphic */)
    {
        $args = func_get_args();
        
        $ids = array();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $a) {
                    if (!is_numeric($a)) {
                        throw new \IsaaCloud\Sdk\Exception("Id queryParameters should be numeric!", 3025);
                    }
                    array_push($ids, $a);
                }                 
            } else {
                if (!is_numeric($arg)) {
                    throw new \IsaaCloud\Sdk\Exception("Id queryParameters should be numeric!", 3026);
                }                
                array_push($ids, $arg);
            }
        }

        if ($ids) {
            $this->queryParameters = array_merge($this->queryParameters, array("ids" => implode(",", $ids)));
        }
        
        return $this;        
    }   

    /**
     *  Narrows the result set to contain only json fields, which are in the list of the method
     * 
     * @return \IsaaCloud\Sdk\IsaaCloud
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function withFields(/* polymorphic */)
    {
        $args = func_get_args();
        
        $fields = array();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $a) {
                    if (!(is_string($a) || is_numeric($a))) {
                        throw new \IsaaCloud\Sdk\Exception("Field queryParameters should be string or numeric!", 3027);
                    }
                    array_push($fields, $a);
                }                 
            } else {
                if (!(is_string($arg) || is_numeric($arg))) {
                    throw new \IsaaCloud\Sdk\Exception("Field queryParameters should be string or numeric!", 3028);
                }                
                array_push($fields, $arg);
            }
        }

        if ($fields) {
            $this->queryParameters = array_merge($this->queryParameters, array("fields" => implode(",", $fields)));
        }
        
        return $this;        
    }

    /**
     * Declares the order in which results in list resources should be returned
     * 
     * @param array $order
     * @return \IsaaCloud\Sdk\IsaaCloud
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function withOrder(array $order = array()) 
    {
        if (is_array($order) && !empty($order)) {
            $ord = array("ASC", "DESC");
            $order_arr = array();
            foreach ($order as $key => $value) {
                if (!(is_string($key) || in_array($value, $ord))) {
                    throw new \IsaaCloud\Sdk\Exception("Invalid ordering parameter", 3029);
                }
                $order_arr[] = $key . ":" . $value;
            }
            $this->queryParameters = array_merge($this->queryParameters, array("order" => implode(",", $order_arr)));
        }
        
        return $this;
    }

    /**
     * Performs a search with concrete field values.
     * 
     * @param array $query
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function withQuery(array $query = array())
    {
        if (is_array($query) && !empty($query)) {
            $query_arr = array();
            foreach ($query as $key => $value) {
                if (!(is_string($key) || is_null($value))) {
                    throw new \IsaaCloud\Sdk\Exception("Invalid query parameter", 3030);
                }
                $query_arr[] = $key . ":" . $value;
            }
            $this->queryParameters = array_merge($this->queryParameters, array("query" => implode(",", $query_arr)));
        }
        
        return $this;
    }

    /**
     * Declares exactly which fields in custom fields should be shown.
     * 
     * @return \IsaaCloud\Sdk\IsaaCloud
     * @throws \IsaaCloud\Sdk\Exception
     */
    public function withCustoms(/* polymorphic */) 
    {
        $args = func_get_args();
        
        $customs = array();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $a) {
                    if (!(is_string($a) || is_numeric($a))) {
                        throw new \IsaaCloud\Sdk\Exception("Custom should be string or numeric!", 3031);
                    }
                    array_push($customs, $a);
                }                 
            } else {
                if (!(is_string($arg) || is_numeric($arg))) {
                    throw new \IsaaCloud\Sdk\Exception("Custom should be string or numeric!", 3032);
                }                
                array_push($customs, $arg);
            }
        }

        if ($customs) {
            $this->queryParameters = array_merge($this->queryParameters, array("customs" => implode(",", $customs)));
        }
        
        return $this;        
    }
    
    /**
     * Shows custom fields in the result
     * 
     * @return \IsaaCloud\Sdk\IsaaCloud
     */
    public function withCustom() 
    {
        $this->queryParameters = array_merge($this->queryParameters, array("custom" => "true"));
        return $this;
    }

    /**
     * Create low-level API call
     * 
     * @param type $uri
     * @param type $method
     * @param type $queryParameters
     * @param type $body
     * @return type
     */
    public function api($uri, $method, $parameters, $queryParameters, $body = null)
    {
        return $this->callService($uri, $method, $parameters, $queryParameters, $body);
    }    
    
    /**
     * Use GET http method to retrive query
     * 
     * @return type
     */
    public function get() 
    {
        return $this->callService($this->path, parent::HTTP_GET, $this->parameters, $this->queryParameters, null);
    }
    
    /**
     * Use POST http method to retrive query
     * 
     * @param array $body
     * @return type
     */
    public function post(array $body = array()) 
    {
        return $this->callService($this->path, parent::HTTP_POST, $this->parameters, $this->queryParameters, $body);
    }

    /**
     * Use PUT http method to retrive query
     * 
     * @param array $body
     * @return type
     */
    public function put(array $body = array()) 
    {
        return $this->callService($this->path, parent::HTTP_PUT, $this->parameters, $this->queryParameters, $body);
    }

    /**
     * Use DELETE http method to retrive query
     * 
     * @return type
     */
    public function delete() 
    {
        return $this->callService($this->path, parent::HTTP_DELETE, $this->parameters, $this->queryParameters, null);
    }
}