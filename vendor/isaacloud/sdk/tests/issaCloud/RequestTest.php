<?php
/**
 * IsaaCloud PHP Sdk (http://isaacloud.com/)
 * 
 *
 * @link        https://github.com/isaacloud/java-sdk
 * @copyright 
 * @license
 */

class RequestTest extends PHPUnit_Framework_TestCase 
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
     */    
    public function testParameterParse($config, $api, $auth, $version)
    {
        /**
         * mock
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\IsaaCloud")
                ->setConstructorArgs(array($config, $api, $auth))
                ->getMockForAbstractClass();          
        
        $stub->path("cache/users/{userId}")
             ->withPaginator(10,2)
             ->withGroups(array(1,2,"3"))
             ->withIds(array(1,2,3))
             ->withSegments(array(1,2,3))
             ->withFields(array("s",2))
             ->withOrder(array(
                 "name"=>"DESC",
                 "email"=>"ASC"
              ))
             ->withQuery(array(
                 "firstName"       => "John",
                 "wonGames.amount" => 12,
                 "wonGames.game"   => 1
              ))
              ->withCustom()
              ->withCustoms(array(
                  "avatar","address"
              ))
              ->withUpdatedAt(1396613832,1396613832)
              ->withCreatedAt(1396613832,1396613832)
              ->withParameters(array(
                  "{userId}" => 12
              ))
              ->withQueryParameters(
                array(
                  "city" => array("Kraków","Wrocław","Poznań"),
                  "address" => "wiejscka 3"
                 )
              )
        ;
        
        $uri = $stub->buildUri($stub->getPath(), $stub->getParameters(), $stub->getQueryParameters());
        $this->assertNotNull($uri);
    }
    
    /**
     * 
     * @return array
     */
    public function mergeProvider() 
    {
        $dataProvider = array(
            array(
                "/resource/{test1}",
                array(
                    "{test1}" => 1),
                "/resource/1"
            ),
            array(
                "/resource/{test1}/resource2/{test2}",
                array(
                    "{test1}" => 1,
                    "{test2}" => 2),
                "/resource/1/resource2/2"
            ),
            array(
                "/resource/{test1}/resource2/{test2}/resource3/{test3}",
                array(
                    "{test1}" => 1,
                    "{test2}" => 2,
                    "{test3}" => 3),
                "/resource/1/resource2/2/resource3/3"
            ),
            array(
                "/resource/1",
                array(),
                "/resource/1"
            )
            ,
            array(
                "/resource/{test1}/resource2/{test2}",
                array(
                    "{test1}" => "string",
                    "{test2}" => "string2"),
                "/resource/string/resource2/string2"
            )
        );
        
        return $dataProvider;
    }

    /**
     * @dataProvider mergeProvider
     */
    public function testBuildUri($string, $parameters, $expected)
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
                ->setConstructorArgs($args)
                ->getMockForAbstractClass();

        /**
         * TestIt!
         */
        $mergedString = $stub->buildUri($string, $parameters);
        $this->assertNotNull($mergedString);
        $this->assertEquals(urldecode($mergedString), $expected);
    }    

    /**
     * @dataProvider authProvider
     */    
    public function testWithParams($config, $api, $auth, $version)
    {
        /**
         * mock
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\IsaaCloud")
                ->setConstructorArgs(array($config, $api, $auth))
                ->getMockForAbstractClass();          
        
        $path = "cache/users";
        $stub->path($path)
             ->withQueryParameters(array(
                 "test" => array(1,2,3)
             ));

        $uri = $stub->buildUri(
                $stub->getPath(), 
                $stub->getParameters(), 
                $stub->getQueryParameters());
                
        $this->assertEquals(urldecode($uri), "$path?test=1,2,3");
    }    
    
    /**
     * @dataProvider authProvider
     */    
    public function testWithPaginator($config, $api, $auth, $version)
    {
        /**
         * mock
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\IsaaCloud")
                ->setConstructorArgs(array($config, $api, $auth))
                ->getMockForAbstractClass();          
        
        $path = "cache/users";
        $offset = 10;
        $limit = 2;
        
        $stub->path($path)
             ->withPaginator($limit, $offset);
        
        $uri = $stub->buildUri(
                $stub->getPath(), 
                $stub->getParameters(), 
                $stub->getQueryParameters());
        
        $this->assertEquals($uri, "$path?offset=$offset&limit=$limit");
    }    
    
    /**
     * @dataProvider authProvider
     */    
    public function testGetUsersRequest($config, $api, $auth, $version)
    {
        /**
         * mock
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\IsaaCloud")
                ->setConstructorArgs(array($config, $api, $auth))
                ->getMockForAbstractClass();          
        
        $return = $stub
                ->path("cache/users")
                ->get();
        
        $this->assertNotNull($return);
    }
    
    /**
     * @dataProvider authProvider
     */    
    public function testPostUsersRequest($config, $api, $auth, $version)
    {
        /**
         * mock
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\IsaaCloud")
                ->setConstructorArgs(array($config, $api, $auth))
                ->getMockForAbstractClass();          
        
        $email = "ttt+".rand(10000,999999)."@a.pl";
        $return = $stub
                ->path("admin/users")
                ->post(array(
                    "email" => $email,
                    "firstName" => "Tom",
                    "lastName" => "Waier",
                    "gender" => "MALE",
                    "birthDate" => "1990-11-11",
                    "password" => "Test.123",
                    "status" => "ACTIVE",
                    "level" => 1
                ));
        
        $this->assertNotNull($return);
        $this->assertNotNull($return["id"]);
        $this->assertEquals($return["email"], $email);
        
        /**
         * cleaer
         */
        $return = $stub
                ->path("admin/users/{userId}")
                ->withParameters(array("{userId}" => $return["id"]))
                ->delete();        
    }    
    
    /**
     * @dataProvider authProvider
     */    
    public function testPutUsersRequest($config, $api, $auth, $version)
    {
        /**
         * mock
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\IsaaCloud")
                ->setConstructorArgs(array($config, $api, $auth))
                ->getMockForAbstractClass();          
        
        /**
         * create new user
         */
        $email = "ttt+".rand(10000,999999)."@a.pl";
        $return = $stub
                ->path("admin/users")
                ->post(array(
                    "email" => $email,
                    "firstName" => "Tom",
                    "lastName" => "Waier"
                ));        
        
        $this->assertNotNull($return);
        $this->assertNotNull($return["id"]);
        $this->assertEquals($return["email"], $email);
        
        /**
         * update
         */
        $firstName = "_UPDATE_TEST_";
        $lastName = "_UPDATE_TEST_";
        $return = $stub
                ->path("admin/users/{userId}")
                ->withParameters(array("{userId}" => $return["id"]))
                ->put(array(
                    "firstName" => $firstName,
                    "lastName" => $lastName
                ));
        
        $this->assertNotNull($return);
        $this->assertEquals($return["firstName"], $firstName);
        $this->assertEquals($return["lastName"], $lastName);
        
        /**
         * cleaer
         */
        $return = $stub
                ->path("admin/users/{userId}")
                ->withParameters(array("{userId}" => $return["id"]))
                ->delete();         
    }
    
    /**
      * @expectedException        \IsaaCloud\Sdk\Connector\Exception\NotFoundException   
      * @expectedExceptionMessage Element not found  
      * @expectedExceptionCode    40401
      * @dataProvider authProvider
     */    
    public function testDeleteUsersRequest($config, $api, $auth, $version)
    {
        /**
         * mock
         */
        $stub = $this->getMockBuilder("IsaaCloud\Sdk\IsaaCloud")
                ->setConstructorArgs(array($config, $api, $auth))
                ->getMockForAbstractClass();          
        
        /**
         * create new user
         */
        $email = "ttt+" . rand(10000,999999) . "@a.pl";
        $return = $stub
                ->path("admin/users")
                ->post(array(
                    "email" => $email,
                    "firstName" => "Tom",
                    "lastName" => "Waier"
                ));        
        
        $this->assertNotNull($return);
        $this->assertNotNull($return["id"]);
        $this->assertEquals($return["email"], $email);

        /**
         * delete
         */
        $stub
                ->path("admin/users/{userId}")
                ->withParameters(array("{userId}" => $return["id"]))
                ->delete()
                ;
        
        /**
         * get
         */
        $return = $stub
                ->path("admin/users/{userId}")
                ->withParameters(array("{userId}" => $return["id"]))
                ->get()
                ;
    }
}