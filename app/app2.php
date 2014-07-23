<?php

defined('VENDOR_PATH') || define('VENDOR_PATH', realpath(__DIR__ . '/../vendor'));
require VENDOR_PATH . '/autoload.php';




define("YOUR_CLIENT_ID", "145");
define("YOUR_SECRET", "836b991365dcf9ecb5b6a9d7eb925b50");



///////////////////////////////////    google oauth


//settings
$google_client_id 		= '549829565881-cidmn7k1pgph6joliv96soubbes1d4vb.apps.googleusercontent.com';
$google_client_secret 	= '5PH89Qrq-gDiV5pKoqW9WRsX';
$google_redirect_url 	= 'http://localhost/~mac/'; //path to your script
$google_hd 	            = 'hd=sosoftware.pl';  // in google_oauth




//include google api files
require_once './src/Google_Client.php';
require_once './src/contrib/Google_Oauth2Service.php';

//start session
session_start();

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
	header('Location: http://localhost/~mac/' );
	//header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	return;
}


if (isset($_SESSION['token'])) 
{ 
	$gClient->setAccessToken($_SESSION['token']);
}


if ($gClient->getAccessToken()) 
{
	  //For logged in user, get details from google using access token
	  
	  //w sumie mozna powywalac bo i tak tylko email jest istotny
	  $user 				= $google_oauthV2->userinfo->get();
	  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
	  $_SESSION['token'] 	= $gClient->getAccessToken();
	  $_SESSION['email']    = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
}
else 
{
	//For Guest user, get google login url
	$authUrl = $gClient->createAuthUrl();          
}




///////////////////////////////

//Configuration for running slim framework
$config = array(
    'debug' => true,
    
    'templates.path' => TEMPLATES_PATH
);




//New instance of slim
$app = new \Slim\Slim($config);


$app->client = $gClient;




//Configuration connection into IsaaCloud server
$isaaConf = array(
    "clientId" => 157,
    //Its your client id
    "secret" => "59f8d59eb77eaec6f7ef9f1023815550"
    //Its your application secret



///////////////////////////////////////////////



);
//create new instance of IsaaCloud SDK
$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);


///////////////////////////////////////////////////////////////////  Redirect for cases like room/x -> homepage etc



$app->get('/room/dashboard', function () use ($app) {
    $app->response->redirect($app->urlFor('d'), 303); 
});


$app->get('/room/leaderboard', function () use ($app) {
    $app->response->redirect($app->urlFor('l'), 303); 
});


$app->get('/room/room', function () use ($app) {
    $app->response->redirect($app->urlFor('r'), 303); 
});


$app->get('/room/users', function () use ($app) {
    $app->response->redirect($app->urlFor('u'), 303); 
});



$app->get('/room/details', function () use ($app) {
    $app->response->redirect($app->urlFor('de'), 303); 
});

$app->get('/room/users/:x', function ($x) use ($app) {

   $a= $app->urlFor('u');
    $b="/";
     $y=$a.$b.$x;
     

     
    $app->response->redirect($y, 303); 
});



$app->get('/room/logout', function () use ($app) {
    $app->response->redirect($app->urlFor('o'), 303); 
});




$app->get('/users/dashboard', function () use ($app) {
    $app->response->redirect($app->urlFor('d'), 303); 
});


$app->get('/users/leaderboard', function () use ($app) {
    $app->response->redirect($app->urlFor('l'), 303); 
});


$app->get('/users/room', function () use ($app) {
    $app->response->redirect($app->urlFor('r'), 303); 
});


$app->get('/users/users', function () use ($app) {
    $app->response->redirect($app->urlFor('u'), 303); 
});



$app->get('/users/details', function () use ($app) {
    $app->response->redirect($app->urlFor('de'), 303); 
});


$app->get('/users/logout', function () use ($app) {
    $app->response->redirect($app->urlFor('o'), 303); 
});


///////////////////////////////////////////////////////////////////     Define routes



///  index

$app->get('/', function () use ($app,$sdk,$authUrl) {
 


 
 if(isset($authUrl))
 {   // echo "niezalogowany";    
      $app->render('welcome.php', array( 'url' => $authUrl));}
  
 else
 
 { //echo "zal   ";  
  //print_r($_SESSION);
 
            
    $app->response->redirect($app->urlFor('d'), 303); 
 

 }
 
 
  //$app->response->redirect($app->urlFor('de'), 303); 
 
 
})->name("root");





$app->get('/error', function () use ($app) {

  		$app->render('error.php');
 

 
 
 
  //$app->response->redirect($app->urlFor('de'), 303); 
 
 
})->name("e");


/// dashboard : my profile, list of all rooms  //////////////////////////////////////////

$app->get('/dashboard', function () use ($app,$sdk) {


  	if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }
        
/******************* logged-in user's data (session variables) **************************/

//print_r($res);
$sdk->path("cache/users")
 				//->withParameters(array("userId" =>1))
                ->withFields("id","firstName","lastName","level")
				->withQueryParameters(array("fields" => array("firstName","lastName","leaderboards","email")));

  
$res = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


foreach ($res as $r): 
        if($r["email"]==($_SESSION["email"])){

			$_SESSION["lastName"]=$r["lastName"];
			$_SESSION["firstName"]=$r["firstName"];
			$_SESSION["id"]=$r["id"];


		}
endforeach; 


/***************************************************************************************/  
        
        
  	$myid=	$_SESSION["id"];
  	$pref="cache/users/";
	$p=$pref.$myid;	
  

    	$sdk->path($p)
 				//->withParameters(array("userId" =>1))
                ->withFields("id","firstName","lastName","level")
				->withQueryParameters(array("fields" => array("firstName","lastName","leaderboards","email")));

  
$res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

		$app->render('header.php'); //header
		$app->render('myprofileshort.php', array('myprofile' => $res)); //first column
   
   
   
   
    	$sdk->path("cache/users/groups")
               
                ->withOrder(array("id"=>"ASC"))
                 ->withFields("counterValues","level")
				 ->withQueryParameters(array("fields" => array("counterValues","level","label")));
    

  
$res = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

		$app->render('midd.php'); // part between column
		$app->render('roomlist.php', array('rooms' => $res)); //second column
  		$app->render('footer.php');  //footer
  		
})->name("d");


//// details : my profile, list of achievements //////////////////////////////////////////


$app->get('/details', function () use ($app,$sdk) {

if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

  		$app->render('header.php');
  		
  	$myid=$_SESSION["id"];
  	$pref="cache/users/";
	$p=$pref.$myid;	
  
    	$sdk->path($p)
               // ->withParameters(array("userId" =>1))
                ->withOrder(array("gainedAchievements.$i.achievement"=>"ASC"))
                ->withFields("firstName","lastName")
				->withQueryParameters(array("fields" => array("firstName","lastName","gainedAchievements","email","leaderboards")));
    

  
$res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

     	$app->render('myprofileshort2.php', array('myprofile' => $res)); // first column
    	$app->render('midd.php');
     
     
    	 $sdk->path("/cache/achievements")
    	 	->withOrder(array("label"=>"ASC"))
            ->withFields("name")
			->withQueryParameters(array("fields" => array("name","id","label")));
				 
$res1 = $sdk->api("/cache/achievements", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

 
 	 	$app->render('history.php', array('history' => $res, 'achievements' => $res1)); // second column
   		$app->render('footer.php'); 
})->name("de");


// leaderboards: my points, leaderboards ////////////////////////////////////////////////


$app->get('/leaderboard', function () use ($app,$sdk) {

if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

  		$app->render('header.php');
  		
  		
 	$myid=$_SESSION["id"];
  	$pref="cache/users/";
	$p=$pref.$myid; 
  	
  
    	$sdk->path($p)
            
                 ->withFields("firstName","lastName")
				 ->withQueryParameters(array("fields" => array("firstName","lastName","email","leaderboards")));
    

  
$res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	
		    
  		$app->render('users1.php', array('user' => $res)); //first column
   		$app->render('midd.php');
   		
   $sdk->path("cache/users")
                ->withOrder (array("leaderboards.1.position"=>"ASC"))
                 ->withFields("firstName","lastName")
				 ->withQueryParameters(array("fields" => array("firstName","lastName","email","leaderboards")));
    

  
$res = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );		
   		
   		
    	$app->render('users2.php', array('users' => $res)); //second column
  		$app->render('footer.php');   
})->name("l");

///////// logout

$app->get('/logout', function () use ($app,$sdk) {

session_destroy();
 // $app->render('logout.php');
  $app->view()->setData('token', null);
  $app->response->redirect($app->urlFor('root'), 303); 
  $app->client->revokeToken();
  
  
  
  
})->name("o");



//////////////// empty

$app->get('/users', function () use ($app) {

})->name("u");


/**************************** Routes with variables *************************************/

 ///// Room : number of users in x room, list of users ///////////////////////////////////

$app->get('/room/:id', function($id) use ($app,$sdk){


if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }


 
    	$app->render('header2.php');
    
    
 //list of  users in x room  
$pref="cache/users/groups/";
$suf="/users";
$p=$pref.$id.$suf;

    $sdk->path($p)
                // ->withParameters(array("userId" =>1))
                ->withOrder (array("id"=>"ASC"))
                ->withFields("firstName","lastName")
				->withQueryParameters(array("fields" => array("firstName","lastName","email")));

$res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    
    
//Room's name
  
$pref="cache/users/groups/";  
$p=$pref.$id;

    $sdk->path($p)
                // ->withParameters(array("userId" =>1))
                ->withFields("label");
				// ->withQueryParameters(array("fields" => array("firstName","lastName","email")));

$res2 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    

		$app->render('currentroom.php', array('roomid' => $res2,'userscount' => $res )); // first column
      	$app->render('midd.php');
   		$app->render('roomusers.php', array('users' => $res)); // second column
    	$app->render('footer.php');
})->name("ri");


////// User profile //////////////////////////////////////////////////////////////////////

$app->get('/users/:id', function($id) use ($app,$sdk){


if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }


 
    	$app->render('header2.php');
    
$pref="cache/users/";
$p=$pref.$id;

    
    $sdk->path($p)
                // ->withParameters(array("userId" =>1))
                ->withFields("firstName","lastName")
				 ->withQueryParameters(array("fields" => array("firstName","lastName","email","leaderboards")));
    
$res2 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    
  
   		$app->render('user.php', array('users' => $res2)); // first column
    	$app->render('midd.php');
    	// second column is empty
    	$app->render('footer.php');
})->name("ui");







/***************************** run application  *****************************************/
$app->run();

?>





