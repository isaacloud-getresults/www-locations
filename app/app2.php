<?php

//Isaacloud sdk files
defined('VENDOR_PATH') || define('VENDOR_PATH', realpath(__DIR__ . '/../vendor'));
require VENDOR_PATH . '/autoload.php';


//    google oauth    ////////////////////////////////////////////////////////////////////


//settings
$google_client_id 		= '549829565881-cidmn7k1pgph6joliv96soubbes1d4vb.apps.googleusercontent.com';
$google_client_secret 	= '5PH89Qrq-gDiV5pKoqW9WRsX';
$google_redirect_url 	= 'http://getresults.isaacloud.com/'; 
//$google_redirect_url 	= 'http://localhost/~mac/' ;



//include google api files
require_once './src/Google_Client.php';
require_once './src/contrib/Google_Oauth2Service.php';


//start session

session_name('g' );
session_start();


// Google Client
$gClient = new Google_Client();

$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);

$google_oauthV2 = new Google_Oauth2Service($gClient);




if (isset($_GET['code'])) 
{ 
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();

 
     if (strpos($_GET['state'],'admin') !== false)
 
     {  
       $domain = end(explode('admin', $_GET['state']));
       $_SESSION['domain']=$domain;
       $_SESSION['state']="admin";
 //      header('Location: http://localhost/~mac/' );
      header('Location: http://getresults.isaacloud.com/' );	
     }
    
      else if (strpos($_GET['state'],'user') !== false) 
 
             {
             $domain = end(explode('user', $_GET['state']));
             $_SESSION['domain']=$domain;
             $_SESSION['state']="user";
   //      header('Location: http://localhost/~mac/user' );
          header('Location: http://getresults.isaacloud.com/user' );
             }	    
	return;
}



if (isset($_SESSION['token'])) 
{ 
	$gClient->setAccessToken($_SESSION['token']);        
	
}



if ($gClient->getAccessToken()) 
      {
	  //For logged in user, get details from google using access token
	  
	  $user 				= $google_oauthV2->userinfo->get();
	  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
	  $_SESSION['token'] 	= $gClient->getAccessToken();
	  $_SESSION['email']    = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
      }
      
      else 
          {
	           if ($_SERVER['SERVER_NAME'] == "getresults.isaacloud.com")
	             { 
	             $sub="";
	             }
	             else
	                 {
	                  $sub = array_shift(explode(".",$_SERVER['SERVER_NAME']));  
	                 }  
	       
	       $state = 'user'.$sub;  
	       $gClient->setState($state);
	       $authUrl1 = $gClient->createAuthUrl(); 
	       

	       $state = 'admin'.$sub;  
	       $gClient->setState($state);
	       $authUrl2 = $gClient->createAuthUrl(); 
	             
         }


//////////////////////////////////////////////////////////////////////////////////////////



//Configuration for running slim framework
$config = array(
    'debug' => true,
    
    'templates.path' => TEMPLATES_PATH
);


//New instance of slim
$app = new \Slim\Slim($config);

// Google Client
$app->client = $gClient;

//Mongo Client
$m = new MongoClient(); 
$db = $m->isaa;
$collection = $db->users;



     
     if (isset($_SESSION['clientid']) && isset($_SESSION['secret']))      // isaacloud instance config
    {

		//Configuration connection into IsaaCloud server
		$isaaConf = array(
        "clientId" => $_SESSION['clientid'],
        "secret" => $_SESSION['secret']
		);

		//create new instance of IsaaCloud SDK
		$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  
	}




///////////config ////////////////////////////////////////////////////////////////////



$cr=1; // room's counter
$id_k = 4; // kitchen's id
$id_mr = 5; // meeting room's id
$id_r = 6; //restaurant's id



/*******************************     Redirect    **********************************/


require_once './routes/redirect.php';



/*******************************     Define routes    **********************************/


require_once './routes/routes.php';
require_once './routes/adminroutes.php';
require_once './routes/userroutes.php';
require_once './routes/nologinroutes.php';



/***************************** Run application  *****************************************/



$app->run();

?>





