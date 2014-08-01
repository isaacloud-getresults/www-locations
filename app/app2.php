<?php


defined('VENDOR_PATH') || define('VENDOR_PATH', realpath(__DIR__ . '/../vendor'));
require VENDOR_PATH . '/autoload.php';


//////////////////////////////////    google oauth


//settings
$google_client_id 		= '549829565881-cidmn7k1pgph6joliv96soubbes1d4vb.apps.googleusercontent.com';
$google_client_secret 	= '5PH89Qrq-gDiV5pKoqW9WRsX';
$google_redirect_url 	= 'http://getresults.isaacloud.com/'; //path to your script





//include google api files
require_once './src/Google_Client.php';
require_once './src/contrib/Google_Oauth2Service.php';

//start session
session_destroy();
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

	header('Location: http://getresults.isaacloud.com/' );
	
	
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
	//For Guest user, get google login url
	$authUrl = $gClient->createAuthUrl();          
}




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




if (isset($_SESSION['email'])){             //checking if user exists in database


    
    $cursor = $collection->find(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))                                             
	{
	
	    foreach ($cursor as $user): 



              	if ($user["base64"] != null)                                                /// user exists and owns an instance
     	        { 
 	
 	             $dane=base64_decode($user["base64"]);
 				list ($clientid, $secret) = explode(":", $dane);
 	
 				$jest=true;
 			
 	
 				$_SESSION['clientid']=$clientid;
 				$_SESSION['secret']=$secret;

 	      		}
 	      		
		
 	      endforeach;		
 	      		
 	      		
	}



     
     
     
     if (isset($_SESSION['clientid']) && isset($_SESSION['secret']))      // isaacloud intance config
    {

		//Configuration connection into IsaaCloud server
		$isaaConf = array(
        "clientId" => $_SESSION['clientid'],
        "secret" => $_SESSION['secret']
		);

		//create new instance of IsaaCloud SDK
		$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  
	}





}



/***************************** redirect  *****************************************/



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


$app->get('/admin/logout', function () use ($app) {
    $app->response->redirect($app->urlFor('o'), 303); 
});


$app->get('/admin/admin/dashboard', function () use ($app) {
    $app->response->redirect($app->urlFor('ad'), 303); 
});


$app->get('/admin/admin/www', function () use ($app) {
    $app->response->redirect($app->urlFor('ww'), 303); 
});

$app->get('/admin/admin/mobile', function () use ($app) {
    $app->response->redirect($app->urlFor('mo'), 303); 
});

$app->get('/admin/admin/setup', function () use ($app) {
    $app->response->redirect($app->urlFor('se'), 303); 
});


$app->get('/admin/user', function () use ($app) {
    $app->response->redirect($app->urlFor('d'), 303); 
});


/*******************************     Define routes    **********************************/


////////////////////////////////  root   /////////////////////////////////////////////

$app->get('/', function () use ($app,$sdk,$authUrl,$jest) {
 


 
 	if(isset($authUrl))
 				 {   // niezalogowany   
    			 $app->render('welcome.php', array( 'url' => $authUrl));
    			 }
     else
         { //zalogowany  
          if  ($jest)   //spr czy jest w bazie, jesli tak to idz do admin dashboard
                {     
                $app->response->redirect($app->urlFor('ad'), 303);   
                }

          else {  $app->response->redirect($app->urlFor('ar'), 303);   }


    }
 
 
})->name("root");



////////////////////////////////  error   /////////////////////////////////////////////


$app->get('/error', function () use ($app) {

  		$app->render('error.php');
 

 
  session_destroy();
  $app->view()->setData('token', null); 
  $app->client->revokeToken();
 
 
  //$app->response->redirect($app->urlFor('de'), 303); 
 
 
})->name("e");




//////////////////////////// user doesn't exist   ///////////////////////////////////////

$app->get('/uerror', function () use ($app) {

  		$app->render('nouser.php');
 

 
  session_destroy();
  $app->view()->setData('token', null); 
  $app->client->revokeToken();
 
 
  //$app->response->redirect($app->urlFor('de'), 303); 
 
 
})->name("ue");




/****************************  admin routes  ******************************************/



//////////////////////////// admin dashboard : menu, statistics ////////////////////////

$app->get('/admin/dashboard', function () use ($app,$sdk) {

	if (!isset($_SESSION['token'])) {
           	  $app->response->redirect($app->urlFor('e'), 303);
        	}

	$app->render('header3.php');
	$app->render('menu.php');
	
	//get statistics 
	
	$sdk->path("cache/users")
				->withQueryParameters(array("limit" => 0,"fields" => array("firstName","lastName","leaderboards","email", "gainedAchievements", "counterValues")));


  
$res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

	$sdk->path("queues/notifications");

$res3 = $sdk->api("queues/notifications", "get",$sdk->getParameters(),  $sdk->getQueryParameters()  );


	$sdk->path("queues/events/done");

$res4 = $sdk->api("queues/events/done", "get",$sdk->getParameters(),  $sdk->getQueryParameters()  );


    $app->render('admindashboard.php', array('res1' => $res1, 'res3' => $res3, 'res4' => $res4) );
	$app->render('footer.php');
    

})->name("ad");



//////////////////////////  admin register (get)  //////////////////////////////////////

$app->get('/admin/register', function () use ($app) {

 $sub=false;

	if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

	 $app->render('register.php', array('sub' => $sub));  
 

})->name("ar");


//////////////////////////  admin register (post)   ///////////////////////////////////

$app->post('/admin/register', function () use ($app) {

 $sub=false;

	if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }



    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
    
    $cursor = $collection->findOne(array( 'domain' => $_POST['domain'] ));
    
$_SESSION['domain'] = $_POST['domain'];   
    
  // if domain exists -> redirect to  ar  
    if (empty($cursor)) 
    {
       
        $app->render('checkemail.php');  
        
		$token= md5($_SESSION['email'].time());                  /// ZMIENIC TO!!!!!
		//$token = "abc";
		$_SESSION['activation']= $token;
        
       
 //add new user
   
        $user=array(
                "email" =>  $_SESSION['email'],
                "token" =>  $_SESSION['activation'],
			    "base64" =>  null,
			    "domain" =>  $_POST['domain'],
			    "activation" =>  "false"
   
              );
                  
        $collection->insert($user);

         }
    else
    
       {   
         $sub=true;
         $app->render('register.php', array('sub' => $sub));   
       }


})->name("sar");

//////////////////////// admin activate code //////////////////////////////////////////


$app->get('/admin/activate/:code', function ($code) use ($app) {



	/// check in database if the user and token are active (if not->activate)

    $_SESSION['activation']= $code;

    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;

    $cursor = $collection->findOne(array( 'token' => $code ));
   

    if(!empty($cursor)) // token exists
	{

              	if ($cursor["activation"] == "false")    // it hasn't activated yet
     	        { 
 	
 	                
 				//update database
 				$cursor["activation"] = true;
 				$collection->save($cursor);
 				
  			    $app->render('activate.php'); 
 
 	      		}	      		
 	      		
	}


    else echo "nieprawidlowy token";   



})->name("cct");




/////////////////////////////// admin activate ////////////////////////////////////////

$app->post('/admin/activate/activate', function () use ($app) {



    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'token' => $_SESSION['activation'] ));
   

    if(!empty($cursor))   // token exists
	{     	
 	                
 	//update database
 	$cursor['base64'] = $_POST['base64'];
 	$collection->save($cursor);
 	      		
	}


    else { echo "nieprawidlowy token";   }


     $app->response->redirect($app->urlFor('root'), 303); 
   
    

})->name("scct");


/////////////////// admin mobile : menu, QR Codes and links to appstore for mobile app. ///

$app->get('/admin/mobile', function () use ($app) {

	if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }
        
    $app->render('header3.php');
	$app->render('menu.php');
 	$app->render('mobile.php');
    $app->render('footer.php');    
        

})->name("mo");


///// admin www : menu, QR Codes and links to: kitchen, meeting room, restaurant, general and user profile //

$app->get('/admin/www', function () use ($app) {
if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

 	$app->render('header3.php');
	$app->render('menu.php');
	$app->render('www.php');
    $app->render('footer.php'); 


})->name("ww");


//////////////////// admin setup :  beacon's localization   /////////////////////////


$app->get('/admin/setup', function () use ($app,$sdk) {
if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }
 
        $app->render('header3.php');
        $app->render('menu.php'); 
  		 $app->render('setup.php');
  		$app->render('footer.php'); 
 


})->name("se");



$app->post('/admin/setup', function () use ($app,$sdk) {
if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }
   
// echo   $_POST['beacon1'];
 
 $uid = $_POST['beacon1'];
 
   
   
   
     		$sdk->path("admin/conditions")
  			    ->withQuery(array("rightSide" =>"kitchen"))
                ->withFields("name");
			  	
    	
$res1 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
  
  
  //echo "</br>";
  //echo $res1[0]['id'];
 // echo "</br>";
  
  
  $condid=$res1[0]['id'];
  
  
  //var_dump($res1); 
   
  // echo "</br>";
 

$pre="admin/conditions/";
 $p=$pre.$condid;     
    
    
             	
$sdk->path($p);

			  	
			  	
$res2 = $sdk->api($p, "put", $sdk->getParameters(),  $sdk->getQueryParameters() ,  array('rightSide' =>  $uid)  );        
       
       
       // var_dump($res2); 
       
     
       
        $app->render('header3.php');
        $app->render('menu.php');
  		$app->render('setup.php'); 
  		$app->render('footer.php'); 
 


})->name("pse");










////////////////////   admin global : statistics, global feed  ///////////////////////////

$app->get('/admin/global', function () use ($app, $sdk) {

  		$app->render('column.php');
  		$app->render('global.php');// general statictics -> to do
        $app->render('midd2.php');
        
        //select from isaacloud
        
            	
  		$sdk->path("cache/users")
  				 ->withOrder(array("updatedAt"=>"DESC"))
                ->withFields("firstName","lastName")
				->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName")));   	
    	
$res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	
	
    	$sdk->path("queues/notifications")
    	 		//->withQuery(array("typeId"=> ?)) <-uzupelnic
                 ->withOrder(array("updatedAt"=>"DESC"))
                ->withFields("data")
				 ->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId","typeId", "updatedAt")));

$res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	
    	
    	//print_r($res);	
    	
    	$app->render('global2.php', array('data' => $res, 'person' => $res1));// global feed ->to do
        	
  		

})->name("gl");


////////////////////// admin restaurant: list of users, feed ////////////////////////////

$app->get('/admin/restaurant', function () use ($app) {

  		
  		$app->render('column.php');
    	$app->render('restaurant.php'); //<- list of users (to do)
    	$app->render('midd2.php');
  		$app->render('restaurant2.php'); //feed (to do)
  		
})->name("rest");

////////////////////// admin meeting_room: list of users, feed ////////////////////////////


$app->get('/admin/meetingroom', function () use ($app) {

  		
  		
  		$app->render('column.php');
    	$app->render('meetingroom.php'); //<- list of users (to do)
    	$app->render('midd2.php');
  		$app->render('meetingroom2.php'); //feed (to do)
  		
  		

})->name("meet");

////////////////////// admin kitchen: list of users, feed ////////////////////////////

$app->get('/admin/kitchen', function () use ($app,$sdk) {

		$app->render('column.php');
//users
   $sdk->path("cache/users")
           ->withQuery(array("counterValues.counter" => 6, "counterValues.counter" => 1))
            ->withOrder (array("leaderboards.1.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				

$res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

   
//Room's name
  
$pref="cache/users/groups/"; 
$p=$pref."1"; // 1 ->id for kitchen

	$sdk->path($p)
				->withQueryParameters(array("fields" => array("label")));
				

$res5 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	

		
    	$app->render('kitchen.php', array('users' => $res4, 'roomid' => $res5) );
    	$app->render('midd2.php');
    	
  	$sdk->path("cache/users")
  				->withQuery(array("counterValues.counter" => 6, "counterValues.counter" => 1))
  				->withOrder(array("updatedAt"=>"DESC"))
             	->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName")));   	
    	
$res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	
    	

    	
    	 $sdk->path("queues/notifications")
                ->withQuery(array("typeId" =>4))
                ->withOrder(array("updatedAt"=>"DESC"))
				->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

$res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	

    	
    	$app->render('kitchen2.php', array('data' => $res, 'person' => $res1));
    	

 
})->name("kit");






////////////////////// kitchen: no login required ////////////////////////////      use objectid    53da382c5af6d8ecbcf7f4b5

$app->get('/kitchen/:b', function ($b) use ($app,$sdk) {


$m = new MongoClient(); 
$db = $m->isaa;
$collection = $db->users;

//echo $b;

     
   $cursor = $collection->findOne(array( '_id' => new MongoId($b)));
   
   
var_dump($cursor);   
   

    if(!empty($cursor))                                             
	{
	
	


//var_dump($cursor);


              	if ($cursor["base64"] != null)                                                /// user exists and owns an instance
     	        { 
 	

 	
 	
 	             $dane=base64_decode($cursor["base64"]);
 				list ($clientid, $secret) = explode(":", $dane);


 	      		}
 	      		
 	      		
 	      		
	}


 			


		//Configuration connection into IsaaCloud server
		$isaaConf = array(
        "clientId" => $clientid,
        "secret" => $secret
		);

		//create new instance of IsaaCloud SDK
		$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  



		$app->render('column.php');
//users
   $sdk->path("cache/users")
           ->withQuery(array("counterValues.counter" => 6, "counterValues.counter" => 1))
            ->withOrder (array("leaderboards.1.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				

$res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

   
//Room's name
  
$pref="cache/users/groups/"; 
$p=$pref."1"; // 1 ->id for kitchen

	$sdk->path($p)
				->withQueryParameters(array("fields" => array("label")));
				

$res5 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	

		
    	$app->render('kitchen.php', array('users' => $res4, 'roomid' => $res5) );
    	$app->render('midd2.php');
    	
  	$sdk->path("cache/users")
  				->withQuery(array("counterValues.counter" => 6, "counterValues.counter" => 1))
  				->withOrder(array("updatedAt"=>"DESC"))
             	->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName")));   	
    	
$res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	
    	

    	
    	 $sdk->path("queues/notifications")
                ->withQuery(array("typeId" =>4))
                ->withOrder(array("updatedAt"=>"DESC"))
				->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

$res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	

    	
    	$app->render('kitchen2.php', array('data' => $res, 'person' => $res1));
    	

 
})->name("kitnolog");






////////////////////    global : no login required  ///////////////////////////         use objectid    53da382c5af6d8ecbcf7f4b5

$app->get('/global/:b', function ($b) use ($app, $sdk) {





$m = new MongoClient(); 
$db = $m->isaa;
$collection = $db->users;

//echo $b;

     
   $cursor = $collection->findOne(array( '_id' => new MongoId($b)));
   

    if(!empty($cursor))                                             
	{
	
	


//var_dump($cursor);


              	if ($cursor["base64"] != null)                                                /// user exists and owns an instance
     	        { 
 	

 	
 	
 	             $dane=base64_decode($cursor["base64"]);
 				list ($clientid, $secret) = explode(":", $dane);


 	      		}
 	      		
 	      		
 	      		
	}


 			


		//Configuration connection into IsaaCloud server
		$isaaConf = array(
        "clientId" => $clientid,
        "secret" => $secret
		);

		//create new instance of IsaaCloud SDK
		$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  






  		$app->render('column.php');
  		$app->render('global.php');// general statictics -> to do
        $app->render('midd2.php');
        
        //select from isaacloud
        
            	
  		$sdk->path("cache/users")
  				 ->withOrder(array("updatedAt"=>"DESC"))
                ->withFields("firstName","lastName")
				->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName")));   	
    	
$res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	
	
    	$sdk->path("queues/notifications")
    	 		//->withQuery(array("typeId"=> ?)) <-uzupelnic
                 ->withOrder(array("updatedAt"=>"DESC"))
                ->withFields("data")
				 ->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId","typeId", "updatedAt")));

$res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	
    	
    	//print_r($res);	
    	
    	$app->render('global2.php', array('data' => $res, 'person' => $res1));// global feed ->to do
        	
  		

})->name("glnolog");










/**************************** user routes **********************************************/



/// dashboard : my profile, list of all rooms  //////////////////////////////////////////

$app->get('/dashboard', function () use ($app,$sdk) {


  	if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }
        
/******************* logged-in user's data (session variables) **************************/

$a=$_SESSION["email"];
$sdk->path("cache/users")
 				->withQuery(array("email" => $a))
				->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email")));

  
$res = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

foreach ($res as $r): 
    

			$_SESSION["lastName"]=$r["lastName"];
			$_SESSION["firstName"]=$r["firstName"];
			$_SESSION["id"]=$r["id"];

	
endforeach; 


/***************************************************************************************/  
        
        
           //sprawdzenie czy w danej instancji jest taki user
        if (!isset($_SESSION["id"])) {
                 $app->response->redirect($app->urlFor('ue'), 303); 
             } 
        
        
$myid=$_SESSION["id"];
$pref="cache/users/";
$p=$pref.$myid;	
  

    	$sdk->path($p)
				->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","leaderboards","email")));

  
$res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

		$app->render('header.php'); //header
		$app->render('myprofileshort.php', array('myprofile' => $res)); //first column
   
 
    	$sdk->path("cache/users/groups")
    			->withOrder(array("id"=>"ASC"))
				->withQueryParameters(array("limit" =>0,"fields" => array("counterValues","label")));
    

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
    			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","gainedAchievements","email","leaderboards")));
    

  
$res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

     	$app->render('myprofileshort2.php', array('myprofile' => $res)); // first column
    	$app->render('midd.php');
     
     
    	 $sdk->path("/cache/achievements")
    	 	->withOrder(array("label"=>"ASC"))
			->withQueryParameters(array("limit" =>0,"fields" => array("name","label")));
				 
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
				 ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email","leaderboards")));
    

  
$res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	
		    
  		$app->render('users1.php', array('user' => $res)); //first column
   		$app->render('midd.php');
   		
   		$sdk->path("cache/users")
                ->withOrder (array("leaderboards.1.position"=>"ASC"))
				->withQueryParameters(array("limit" =>0, "fields" => array("firstName","lastName","email","leaderboards")));
    

  
$res = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );		
   		
   		
    	$app->render('users2.php', array('users' => $res)); //second column
  		$app->render('footer.php');   
  		
})->name("l");

///////// logout /////////////////////////////////////////////////////////////////////////

$app->get('/logout', function () use ($app,$sdk) {

session_destroy();
  $app->view()->setData('token', null);
  $app->response->redirect($app->urlFor('root'), 303); 
  $app->client->revokeToken();
  
  
  
})->name("o");



//////////////// empty /////////////////////////////////////////////////////////////////

$app->get('/users', function () use ($app) {

})->name("u");


/**************************** Routes with variables *************************************/

 ///// Room : number of users in x room, list of users ///////////////////////////////////

$app->get('/room/:id', function($id) use ($app,$sdk){


if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }


 
    	$app->render('header2.php');


   		$sdk->path("cache/users")
              	->withQuery(array("counterValues.counter" => 6, "counterValues.value" => $id))
              	->withOrder (array("leaderboards.1.position"=>"ASC"))
				->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				

$res = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

    
//Room's name
  
$pref="cache/users/groups/";  
$p=$pref.$id;

    $sdk->path($p)
				->withQueryParameters(array("limit" =>0,"fields" => array("label")));

$res2 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    

		$app->render('currentroom.php', array('roomid' => $res2,'userscount' => $res )); // first column
      	$app->render('midd.php');
   		$app->render('roomusers.php', array('users' => $res, 'roomid' => $res2)); // second column
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
				 ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email","leaderboards")));
    
$res2 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    
  
   		$app->render('user.php', array('users' => $res2)); // first column
    	$app->render('midd.php');
    	// second column is empty
    	$app->render('footer.php');
})->name("ui");


/***************************** run application  *****************************************/
$app->run();

?>





