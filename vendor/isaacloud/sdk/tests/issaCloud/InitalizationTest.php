<?php
/**
 * IsaaCloud PHP Sdk (http://isaacloud.com/)
 * 
 *
 * @link        https://github.com/isaacloud/java-sdk
 * @copyright 
 * @license
 */

class InitializationTest extends PHPUnit_Framework_TestCase 
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
    
    public function constructorValidProvider() 
    {
        $dataProvider = array(
            array(
                "{$this->testBaseApiUrl}",
                "{$this->testBaseOAuthUrl}",
                "{$this->testVersion}",
                array(
                    "clientId" => $this->testClientId,
                    "secret" => $this->testSecret,
                ))
        );
        return $dataProvider;
    }

    /**
     * @dataProvider constructorValidProvider
     * @expectedException \IsaaCloud\Sdk\Connector\Exception\ConnectorException
     */
    public function testInvalidApiUrl($baseApiPath, $baseOauthDataPath, $version, $configuration) 
    {
        /**
         * mock
         */
        $stub = $this->getMockForAbstractClass("IsaaCloud\Sdk\Connector", array('_INVALID_URL_', $baseOauthDataPath, $version, $configuration));
    }     
    
    /**
     * @dataProvider constructorValidProvider
     * @expectedException \IsaaCloud\Sdk\Connector\Exception\ConnectorException
     */
    public function testInvalidOAuthUrl($baseApiPath, $baseOauthDataPath, $version, $configuration) 
    {
        /**
         * mock
         */
        $stub = $this->getMockForAbstractClass("IsaaCloud\Sdk\Connector", array($baseApiPath, '_INVALID_URL_', $version, $configuration));
    }
    
    /**
     * @dataProvider constructorValidProvider
     * @expectedException \IsaaCloud\Sdk\Connector\Exception\ConnectorException
     */
    public function testInvalidClientId($baseApiPath, $baseOauthDataPath, $version, $configuration) 
    {
        /**
         * mock
         */
        $stub = $this->getMockForAbstractClass("IsaaCloud\Sdk\Connector", array($baseApiPath, $baseOauthDataPath, $version, array(
                    "clientId" => null,
                    "secret" => $this->testSecret,            
        )));
    }      
    
    /**
     * @dataProvider constructorValidProvider
     * @expectedException \IsaaCloud\Sdk\Connector\Exception\ConnectorException
     */
    public function testInvalidSecret($baseApiPath, $baseOauthDataPath, $version, $configuration) 
    {
        /**
         * mock
         */
        $stub = $this->getMockForAbstractClass("IsaaCloud\Sdk\Connector", array($baseApiPath, $baseOauthDataPath, $version, array(
                    "clientId" => $this->testClientId,
                    "secret" => null,            
        )));
    }    
    
    /**
     * @dataProvider constructorValidProvider
     */
    public function testValidConstructor($baseApiPath, $baseOauthDataPath, $version, $configuration) 
    {
        /**
         * mock
         */
        $stub = $this->getMockForAbstractClass("IsaaCloud\Sdk\Connector", array($baseApiPath, $baseOauthDataPath, $version, $configuration));
        
        /**
         * assert
         */
        $this->assertEquals($stub->getClientId(), $configuration["clientId"]);
        $this->assertEquals($stub->getSecret(), $configuration["secret"]);
        $this->assertEquals($stub->getBaseOAuthUrl(), $baseOauthDataPath);
        $this->assertEquals($stub->getBaseApiUrl(), $baseApiPath);
        $this->assertEquals($stub->getVersion(), $version);
    }    
}