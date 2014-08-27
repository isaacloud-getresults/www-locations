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
use \IsaaCloud\Sdk\Connector\Exception as Ex;

/**
 * 
 * Main Connector class
 */
abstract class Connector
{
    /**
     * GET
     */
    const HTTP_GET = 'GET';
    
    /**
     * POST
     */
    const HTTP_POST = 'POST';
    
    /**
     * PUT
     */
    const HTTP_PUT = 'PUT';
    
    /**
     * OPTIONS
     */
    const HTTP_OPTIONS = 'OPTIONS';
    
    /**
     * DELETE
     */
    const HTTP_DELETE = 'DELETE';
    
    /**
     * Base authorization uri
     * @var type 
     */
    private $auth = null;

    /**
     * Base api url
     * @var type 
     */
    private $api = null;

    /**
     * Version of API with connect it
     * @var type 
     */
    private $version = null;

    /**
     * Default content type
     * @var type 
     */
    private $contentType = "application/json charset=utf-8";

    /**
     * Http method types
     * @var type 
     */
    private $methods = array(
        self::HTTP_POST, 
        self::HTTP_GET, 
        self::HTTP_PUT, 
        self::HTTP_OPTIONS, 
        self::HTTP_DELETE
    );

    /**
     * Authentication data
     * @var type 
     */
    private $oauthData = array();

    /**
     * Client Identyfication
     * @var type 
     */
    private $clientId = null;

    /**
     * Secret of application
     * @var type 
     */
    private $secret = null;

    /**
     * Connection timeout
     * @var type 
     */
    private $timeout = 2;
    
    /**
     * Get client id
     * 
     * @return type
     */
    public function getClientId()
    {
        return $this->clientId;
    }       
    
    /**
     * Get secret
     * 
     * @return type
     */
    public function getSecret()
    {
        return $this->secret;
    }        
    
    /**
     * 
     * @return type
     */
    public function getBaseOAuthUrl() 
    {
        return $this->auth;
    }

    /**
     * Get base api url
     * @return type
     */
    public function getBaseApiUrl() 
    {
        return $this->api;
    }

    /**
     * Get version
     * @return type
     */
    public function getVersion() 
    {
        return $this->version;
    }    

    /**
     * Constructor of connector, set up all connection parameters
     * 
     * @param string $api Base url path to api server
     * @param string $oauth Base url path to authenticate server
     * @param string $version Version compatible API (in pattern x.y.z)
     * @param array $config Array of configutation
     * @throws Ex\ConnectorException
     */
    public function __construct($api, $oauth, $version, $config) 
    {
        // set up api
        if ((filter_var($api, FILTER_VALIDATE_URL) == true)) {
            $this->api = $api;
        } else {
            throw new Ex\ConnectorException("{$api} is invalid url!", 3001);
        }

        // set up auth
        if ((filter_var($oauth, FILTER_VALIDATE_URL) == true)) {
            $this->auth = $oauth;
        } else {
            throw new Ex\ConnectorException("{$oauth} is invalid url!", 3002);
        }

        $this->version = $version;

        // Set up configuration
        if (is_array($config)) {
            
            //Set up clientId
            if (empty($config["clientId"])) {
                throw new Ex\ConnectorException("There are not defined client id", 3003);
            }
            $this->clientId = $config["clientId"];

            if (empty($config["secret"])) {
                throw new Ex\ConnectorException("There are not defined secret", 3004);
            }
            $this->secret = $config["secret"];
        }
    }
    
    /**
     * This method provide low level REST-call access mechanism
     * 
     * @param type $uri - the relative url addr
     * @param type $httpMethod - http method in the filed of GET, POST, PUT, OPTIONS, or PATH
     * @param type $parameters array of request parameters
     * @param type $queryParameters
     * @param null $body
     * @param \IsaaCloud\Sdk\Closure $callback
     * @return type
     * @throws Ex\ConnectorException
     */
    public function callService($uri, $httpMethod, $parameters, $queryParameters, $body = null, $callback = null)
    {
        // Get method type from string
        $method = strtoupper($httpMethod);
        if (!in_array($method, $this->methods)) {
            throw new Ex\ConnectorException("{$httpMethod} is invalid http method!", 3005);
        }
        
        // Build request header
        $header = array(
            "Content-Type" => $this->contentType,
            "Authorization" => $this->getAuthentication()
        );

        if (in_array($method, array(self::HTTP_GET, self::HTTP_DELETE))) {
            $body = null;
        }

        // merge uri parameters
        $uri = $this->buildUri($uri, $parameters, $queryParameters);
        
        // Build url address to call
        $url = $this->buildUrl($this->api, $this->version, $uri);
        
        // Responder data object
        $responseBody = $this->curlIt($header, $method, $url, $body, "raw-json");
        
        // Error handler 
        if (isset($responseBody["error"])) {
            
            // Throw new exception with error
            throw new Ex\ConnectorException("Error while executing query, error message: " . $responseBody["error"], 3006);

        } else {
            
            // Callback if was defined
            if ((is_string($callback) && function_exists($callback)) || (is_object($callback) && ($callback instanceof Closure))) {
                return $callback($responseBody);
            } else {
                return $responseBody;
            }            
        }
    }
    
    /**
     * Build uri with params
     * 
     * @param type $uri
     * @param array $parameters
     * @param array $queryParameters
     * @return string
     * @throws Ex\ConnectorException
     */
    public function buildUri($uri = "", array $parameters = array(), array $queryParameters = array())
    {
        // merge path params
        if ((null != $parameters) && (count($parameters) > 0)) {
            foreach ($parameters as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    throw new Ex\ConnectorException("Key `{$key}` can't be an Array or Object", 3007);
                }                
                if (false != strstr($uri, $key)) {
                    $uri = str_replace($key, $value, $uri);
                }
            }
        }        
        
        // parse parameters
        if (is_array($queryParameters) && !empty($queryParameters)) {
            try {
                $uri = $uri . "?" . http_build_query($queryParameters);
            } catch (\Exception $e) {
                throw new Ex\ConnectorException("An error occurred while building the query", 3008);
            }
        }
        
        return $uri;
    }     
    
    /**
     * Build url to call
     * 
     * @example buildUrl("http://api.isaacloud.com", "v1", "resource1") will return "http://api.isaacloud.com/v1/resource1"
     * @return string $url
     */
    public function buildUrl(/* polymorphic */)
    {
        $args = func_get_args();

        $urlArray = array();
        foreach ($args as $arg) {
            if (!empty($arg)) {
                $urlArray[] = trim($arg, "/");
            }
        }

        return implode("/", $urlArray);
    }
    
    /**
     * Build authentication data
     * 
     * Firstly check cookie data, if cookie not exists or is invalid - make request to oauth server, to obtain token
     * At the end build token string
     * @return string Authentication Token
     */
    public function getAuthentication()
    {
        $oauthData = $this->getOauthData();
        if (!$this->isValidOauthData($oauthData)) {
            //Request into OAuth server and get authentication token
            try {
                
                $oauthData = $this->obtainOAuthToken();
                if (!is_array($oauthData)) {
                    return null; // if invalid token data, return null
                } else {
                    $this->setOauthData($oauthData);
                }
                
            } catch (Exception $e) {
                return null; // if some exception catched, return null
            }
        }
            
        // build token string
        $token = $this->buildTokenByOauthData($oauthData);
        return $token;
    }    
    
    /**
     * Get oauth data
     * 
     * @return type
     */
    public function getOauthData() 
    {
        return $this->oauthData;
    }    
    
    /**
     * Set oatuh data
     * 
     * @param array $oauthData
     */
    public function setOauthData(array $oauthData)
    {
        if ($this->isValidOauthData($oauthData)) {
            
            //compose data object
            $data = array(
                "access_token" => $oauthData["access_token"],
                "token_type" => $oauthData["token_type"]
            );

            $this->oauthData = $data;            
        }
    }
    
    /**
     * Validation of oauth parameters
     * 
     * @param type $oauthData
     * @return boolean
     */
    public function isValidOauthData(array $oauthData)
    {
        if (is_array($oauthData) &&
            isset($oauthData["access_token"]) &&
            isset($oauthData["token_type"])) 
        {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Build token with oauth data
     * 
     * @param array $oauthData
     * @return type
     */
    public function buildTokenByOauthData(array $oauthData)
    {
        return trim(ucfirst($oauthData["token_type"]) . " " . $oauthData["access_token"]);
    }    
    
    /**
     * Create request into OAuth server, to get authentication token
     * 
     * @param type $authMethod
     * @return type
     * @throws Ex\ConnectorException
     */
    public function obtainOAuthToken($authMethod = "Basic")
    {

        // Build http headers
        $header = array(
            "Authorization" => $authMethod . " " . $this->encodeCredential($this->clientId, $this->secret),
        );

        // prepare url to call
        $url = $this->buildUrl($this->auth, "token");

        // set http fields - grant type for obtaining oauth token	
        $body = array(
            "grant_type" => "client_credentials",
        );

        // curlIt to get response from oauth server
        $responseBody = $this->curlIt($header, self::HTTP_POST, $url, $body, "x-www-form-urlencoded");
        
        // if body contains good token data create token, and return it
        if (isset($responseBody["token_type"]) && 
            isset($responseBody["expires_in"]) && 
            isset($responseBody["access_token"])) 
        {
            
            //return token data
            return array(
                "token_type"   => $responseBody["token_type"],
                "expires_in"   => $responseBody["expires_in"],
                "access_token" => $responseBody["access_token"]
            );
            
        } elseif (isset($responseBody["error"])) {
            // Throw new exception with oauth error
            throw new Ex\ConnectorException("Error while obtaining OAuth Token: " . $responseBody["error"], 3009);
        } else {
            // Server responded but without error description
            throw new Ex\ConnectorException("Unknown error while obtaining OAuth Token", 3010);
        }
    }
    
    /**
     * Encode credintial into valid base64 string
     * 
     * @param type $clientId
     * @param type $secret
     * @return type
     * @throws Ex\ConnectorException
     */
    public function encodeCredential($clientId, $secret) 
    {
        if (is_numeric($clientId) && !is_null($secret)) {
            
            //Combine client id and secret
            $cobinedString = $clientId . ":" . $secret;

            //Encode into base64
            $result = $this->base64url_encode(trim($cobinedString));

            return $result;
            
        } else {
            throw new Ex\ConnectorException("Client Id or secret are invalid!", 3011);
        }
    }    
    
    /**
     * Encode base64url
     * 
     * @param type $data
     * @return type
     */
    public function base64url_encode($data) 
    {
        return rtrim(base64_encode($data));
    }    
    
    /**
     * Build and call request with CURL
     * 
     * @param array $header
     * @param type $method
     * @param type $url
     * @param array $body
     * @param type $dataType
     * @return type
     * @throws Ex\ConnectorException
     * @throws Ex\InternalServerException
     * @throws Ex\NotFoundException
     * @throws Ex\BadRequestException
     * @throws Ex\UnauthorizedException
     */
    public function curlIt(array $header, $method, $url, array $body = null, $dataType = "raw-json") 
    {
        // Check if properly installed PHP extensions 
        if (!extension_loaded('curl')) {
            throw new Ex\ConnectorException("cURL extension(s) are not available, you need properly install this extensions!", 3012);
        }

        // Curl init
        $curl = curl_init($url);

        // Set curl timeout
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CAINFO, $this->getCertificate());
        curl_setopt($curl, CURLOPT_HEADER, true);        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        // For update method
        if (self::HTTP_POST === $method) {
            curl_setopt($curl, CURLOPT_POST, true);
        } else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }

        // Build headers
        $headers = array();
        if (count($header) > 0) {
            foreach ($header as $key => $value) {
                $headers[] = "{$key}: {$value}";
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        
        // Set up encoding
        switch ($dataType) {
            case "x-www-form-urlencoded":
                $data = http_build_query($body, null, '&');
                break;
            case "raw-json":
                $data = json_encode($body);
                break;
            default:
                throw new Ex\ConnectorException("Invalid data type!", 3013);
        }
        
        // Setup body for update method
        if ($method === self::HTTP_POST || $method === self::HTTP_PUT) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }           

        // Response IT!
        $curlResponse = curl_exec($curl);
        
        // Check for some curl errors
        $error = curl_error($curl);
        if ($error) {
            throw new Ex\ConnectorException("!!!!!!!!!     There are error(s) while invoking remote resource: {$method} {$url}, with error(s): $error", 3014);
        }

        // Check that response is empty
        if (($curlResponse === null) || is_null($curlResponse)) {
            throw new Ex\ConnectorException("The response is empty, and cannot be parse!", 3015);
        }
        
        // Parse response
        try {

            list($curlResponseHeader, $curlBody) = explode("\r\n\r\n", $curlResponse, 2);
            $jsonCurlBody = json_decode($curlBody, true);
            
        } catch (Exception $exc) {
            throw new Ex\ConnectorException("Error while parsing remote response!", 3016);
        }        
        
        // Get curl response http code
        $curlHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // Close connection
        curl_close($curl);        
        
        // Handle result
        if (200 == $curlHttpCode || 201 == $curlHttpCode) {
            return $jsonCurlBody;
        } else {
            
            $errMessage = null;
            if (isset($jsonCurlBody["message"])) {
                $errMessage = $jsonCurlBody["message"];
            }
            
            $errCode = null;
            if (isset($jsonCurlBody["code"])) {
                $errCode = $jsonCurlBody["code"];
            }
            
            switch ($curlHttpCode) {
                case 500 : throw new Ex\InternalServerException($errMessage,$errCode);
                case 404 : throw new Ex\NotFoundException($errMessage,$errCode);
                case 400 : throw new Ex\BadRequestException($errMessage,$errCode);
                case 401 : throw new Ex\UnauthorizedException($errMessage,$errCode);
            }            
        }
    }
    
    /**
     * Get certificate from PEM file
     * 
     * @return string
     * @throws Ex\ConnectorException
     */
    public function getCertificate()
    {
        $file = __DIR__ . "/isaacloud.pem";

        if (file_exists($file)) {
            return $file;
        } else {
            throw new Ex\ConnectorException("The certificate file cannot be found!", 3017);
        }
    }
}