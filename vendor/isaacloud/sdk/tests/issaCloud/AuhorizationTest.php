<?php
/**
 * IsaaCloud PHP Sdk (http://isaacloud.com/)
 * 
 *
 * @link        https://github.com/isaacloud/java-sdk
 * @copyright 
 * @license
 */

class AuthorizationTest extends PHPUnit_Framework_TestCase 
{
    /**
     *
     * @var type 
     */
    private $testBaseApiUrl   = "https://apidev.isaacloud.com"; 
    private $testBaseOAuthUrl = "https://oauthdev.isaacloud.com/";
    private $testVersion      = "v1";
    private $testClientId     = "3";
    private $testSecret       = "32d48ef72968bda294a8b56a8347";
    
    
    public function authProvider() 
    {
        $dataProvider = array(
            array(
                array(
                    "clientId" => $this->testClientId,
                    "secret" => $this->testSecret,
                ),            
                $this->testBaseApiUrl,
                $this->testBaseOAuthUrl,
                $this->testVersion
            )
        );
        return $dataProvider;
    }

    /**
     * @dataProvider authProvider
     * @expectedException \IsaaCloud\Sdk\Connector\Exception\UnauthorizedException
     */    
    public function testFailureAuthWithToken($config, $api, $auth, $version)
    {
        /**
         * mock
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\IsaaCloud")
                ->setConstructorArgs(array($config, $api, $auth))
                ->getMockForAbstractClass();          
        
        // expect expection \IsaaCloud\Sdk\Connector\Exception\UnauthorizedException
        $stub
                ->withToken('_FAIL_TOKEN_')
                ->path("cache/users")
                ->get();
    }        
    
    /**
     * @dataProvider authProvider
     */    
    public function testSuccessAuthWithToken($config, $api, $auth, $version)
    {
        /**
         * connector instance
         */
        $connectorObj = $this->getMockForAbstractClass("IsaaCloud\Sdk\Connector", array(
            $api, $auth, $version, $config));   
        
        // obtain auth token
        $oAuthToken = $connectorObj->obtainOAuthToken();
        
        $this->assertArrayHasKey("token_type", $oAuthToken);
        $this->assertArrayHasKey("expires_in", $oAuthToken);
        $this->assertArrayHasKey("access_token", $oAuthToken);
        
        $this->assertNotNull($oAuthToken["token_type"]);
        $this->assertNotNull($oAuthToken["expires_in"]);
        $this->assertNotNull($oAuthToken["access_token"]);
    }
    
    /**
     * @dataProvider authProvider
     * @expectedException \IsaaCloud\Sdk\Connector\Exception\UnauthorizedException
     */
    public function testFailureAuthanticate($config, $api, $auth, $version)
    {
        /**
         * connector instance
         */
        $connectorObj = $this->getMockForAbstractClass("IsaaCloud\Sdk\Connector", array(
            $api, $auth, $version, array(
                "clientId" => $this->testClientId,
                "secret" => '_FAILURE_SECRET_'                
           )));   
        
        // obtain auth token
        $oAuthToken = $connectorObj->obtainOAuthToken();
    }
    
    /**
     * 
     * @return array
     */
    public function getAuthenticationProvider() 
    {
        $dataProvider = array(
            array(
                array(
                    "token_type" => "Bearer",
                    "expires_in" => "3600",
                    "access_token" => "965c8d4d29717ad3ad8e82447c55b1e"
                ),
            ),
            array(
                array(
                    "token_type" => "Bearer",
                    "expires_in" => "1800",
                    "access_token" => "47c55b8d4d2965c3ad8e8249717ad1e"
                ),
            ),
            array(
                array(
                    "token_type" => "Basic",
                    "expires_in" => "3600",
                    "access_token" => "717ad3ad899e824e65c8d4d47c55b12"
                ),
            ),
            array(
                array(
                    "error" => "Invalid client",
                ),
                false
            ),
            array(
                array(
                    "error" => "Internal server error",
                ),
                false
            ),
            array(
                array(
                    "error" => "Resource not found",
                ),
                false
            ),
            array(
                array(
                    "error" => "Connection timeout",
                ),
                false
            )
        );

        return $dataProvider;
    }

    /**
     * Test get authentication string
     * @dataProvider getAuthenticationProvider
     */
    public function testGetAuthentication($token, $tokenOk = true) 
    {
        $args = array(
            "{$this->testBaseApiUrl}",
            "{$this->testBaseOAuthUrl}",
            "{$this->testVersion}",
            array(
                "clientId" => $this->testClientId,
                "secret" => $this->testSecret,
        ));
            
        /**
         * Build mock object
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\Connector")
                ->setMethods(array("obtainOAuthToken", "setOauthData"))
                ->setConstructorArgs($args)
                ->getMockForAbstractClass();

        $test = $this;
        $callback = function() use($token, $test, $tokenOk) {

            if ($tokenOk) {
                $test->assertArrayHasKey("token_type", $token);
                $test->assertArrayHasKey("expires_in", $token);
                $test->assertArrayHasKey("access_token", $token);

                return $token;
            } else {
                $test->assertArrayHasKey("error", $token);
                return null;
            }
        };
        
        /**
         * Set up excepts
         */
        $stub->expects($this->any())
             ->method("obtainOAuthToken")
             ->will($this->returnCallback($callback));

        
        
        $callbackSetOauthData = function() use($token) {
            $_COOKIE["test"] = json_encode($token);
            return $token;
        };

        $stub->expects($this->any())
             ->method("setOauthData")
             ->will($this->returnCallback($callbackSetOauthData));

        $authentcationString = $stub->getAuthentication();

        if ($tokenOk) {
            $this->assertNotNull($authentcationString);
            $this->assertNotEmpty($authentcationString);
        } else {
            $this->assertNull($authentcationString);
        }
    }    
}