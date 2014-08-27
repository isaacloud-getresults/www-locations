<?php


/****************************  admin routes  ******************************************/



//////////////////////////// admin dashboard : menu, statistics ////////////////////////

$app->get('/admin/dashboard', function () use ($app,$sdk,$isaaConf) {

	if (!isset($_SESSION['token'])) 
	 {
      $app->response->redirect($app->urlFor('e'), 303);
     }

	$app->render('header3.php');
	$app->render('menu.php');
	
	
	
	
	//get statistics 
	
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  
	
	$sdk->path("cache/users")
				->withQueryParameters(array("limit" => 0,"fields" => array("firstName","lastName","leaderboards","email", "gainedAchievements", "counterValues", "wonGames")));
  
 
    
    $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    
$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  

	$sdk->path("cache/users/groups")
		->withOrder(array("segments"=>"ASC"))
		->withQueryParameters(array("limit" => 0, "offset" =>1, "fields" => array("label", "counterValues")));

	$resA = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );



    $app->render('admindashboard.php', array('res1' => $res1, 'resA' => $resA) );
	$app->render('footer.php');

})->name("ad");



//////////////////////////  admin register (get)  //////////////////////////////////////

$app->get('/admin/register', function () use ($app) {
    
    if (!isset($_SESSION['token'])) 
    {
    $app->response->redirect($app->urlFor('e'), 303);
    }


    $sub=false;   // subdomain doesn't exist


	$token= md5($_SESSION['email'].time());        // generate registration token            
	$_SESSION['activation']= $token;
	
	
	
	  $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
	
	
	      $cursor2 = $collection->findOne(array( 'email' => $_SESSION['email']));       
         if (empty($cursor2))
       
       
       {
    
      
            $set=false;
         }
         
         else
         
         { 
          $set=true;
         }         
        
	
	
	

	$app->render('register.php', array('sub' => $sub,'set' => $set));  
 
})->name("ar");


//////////////////////////  admin register (post)   ///////////////////////////////////

$app->post('/admin/register', function () use ($app) {

     if (!isset($_SESSION['token'])) 
     {
     $app->response->redirect($app->urlFor('e'), 303);
     }

    $sub=false;

    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
    
    $cursor = $collection->findOne(array( 'domain' => $_POST['domain'] ));
    
    $_SESSION['domain'] = $_POST['domain'];   
    

    if (empty($cursor)) 
    {
        $sub=false;
       
       
         $user=array(
                "email" =>  $_SESSION['email'],
                "token" =>  $_SESSION['activation'],
			    "base64" =>  null,
			    "domain" =>  $_POST['domain'],
			    "activation" =>  "false",
			    "uuid" =>  null,
			    "iosbase64" =>  null,
			     "androidbase64" =>  null,
			     "iosid" =>  null,
			    "calendar" =>  null
			    
   
              );
              
            $collection->insert($user);  
       
        $app->render('checkemail.php');          
        

     }
    else
    
       {   
         $sub=true;
         $set=false;
         $app->render('register.php', array('sub' => $sub, 'set' => $set));   
       }




})->name("sar");

//////////////////////// admin activation (get) //////////////////////////////////////////


$app->get('/admin/activate/:code', function ($code) use ($app) {

	/// check in database if the user and token are active (if not->activate)
	

	// tu tez spr tokena ale co jesli go nie ma????
	
	
	
	
	

    $_SESSION['activation']= $code;

    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;

    $cursor = $collection->findOne(array( 'token' => $code ));
   

    if(!empty($cursor)) // token exists
	{

              	if ($cursor["activation"] == "false")   
     	        { 
 	 	                
 				//update database
 				$cursor["activation"] = true;
 				$collection->save($cursor);
 				
  			    $app->render('activate.php', array('domain' => $cursor['domain'])); 
 
 	      		}	      		
 	      		
	}


    else echo "nieprawidlowy token";   



})->name("cct");




/////////////////////////////// admin activate (post) ////////////////////////////////////////

$app->post('/admin/activate/activate', function () use ($app) {


	$_SESSION['base64']= $_POST['base64'];


 	   
 	   $app->response->redirect($app->urlFor('ic'), 303); 
 	   
 	      		
	

 

})->name("scct");


/////////////////////////////// starting configuration script execution ////////////////////////////////////////


$app->get('/admin/ic', function () use ($app) {


   $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'token' => $_SESSION['activation'] ));
   

    if(!isset($_SESSION['token']))    //////////   w sumie to do usuniecia, jesli nie ma tokena to odeslac do logowania? hm
	{     	
 	                
 	//musi sie zalogowac
 
    }

 if(empty($cursor)) {  echo "nieprawidlowy token";}     


 	 $app->render('shell.php');

})->name("ic");



/////////////////////////////// redirecting to admin dashboard, fetching variables ////////////////////////////////////////

$app->get('/admin/init', function () use ($app) {


     if (isset($_SESSION['token']) )
                                {             //checking if user exists in database   

   								  $m = new MongoClient(); 
  								  $db = $m->isaa;
  								  $collection = $db->users;
    
  								  $cursor = $collection->find(array( 'email' => $_SESSION['email'] ));
   

   								 if(!empty($cursor))                                             
														{
	
	   													 foreach ($cursor as $user): 

              											if ($user["base64"] != null)                         /// user exists and owns an instance
     	      											     { 
 	
 	         											     $dane=base64_decode($user["base64"]);
 															 list ($clientid, $secret) = explode(":", $dane);
 															
 															 $jest=true;
 															 
 															 $_SESSION['base64']=$user["base64"];
 			
 															 $_SESSION['clientid']=$clientid;
 															 $_SESSION['secret']=$secret;

               												 $_SESSION['profileqr']=$user["domain"];    // get subdomain name for user profile link

 	      		                                             }
 	      		
 	                                                       endforeach;		
 	                                                       
 	                                                       
 	                                                       
 	                                                       echo "ok";
 	                                                       
 	      		 										}

                                 }                


	   
 	   $app->response->redirect($app->urlFor('ad'), 303); 

 	 

})->name("init");






/////////////////// admin mobile (get) : menu, links to appstore, qr code for config, mobile access activation ///

$app->get('/admin/mobile', function () use ($app) {

	if (!isset($_SESSION['token'])) 
	{
    $app->response->redirect($app->urlFor('e'), 303);
    }
        
        
    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
    
      
    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
      
   
    $profileqr= $cursor["domain"];

        
        
    $app->render('header3.php');
	$app->render('menu.php');
 	$app->render('mobile.php', array('profileqr' => $profileqr ));
    $app->render('footer.php');    
        

})->name("mo");




/////////////////// admin mobile (post) ///

$app->post('/admin/mobile', function () use ($app) {

	if (!isset($_SESSION['token'])) 
	{
    $app->response->redirect($app->urlFor('e'), 303);
    }
        
        
    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
    
      
        $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))   
	{     	
 	$profileqr= $cursor["domain"];      
 	
 	
 		   if (!empty($_POST['iosid']) )     
 	{$cursor["iosid"] = $_POST["iosid"];
 	$collection->save($cursor);
 	}
 	
 	   if (!empty($_POST['iosbase64']) )     
 	{$cursor["iosbase64"] = $_POST["iosbase64"];
 	$collection->save($cursor);
 	}
 	
     if (!empty($_POST['androidbase64'] )) 
 	{$cursor["androidbase64"] = $_POST["androidbase64"];
 	$collection->save($cursor);
 	}
 	
 	
 	
 	
    }
   
        
        
    $app->render('header3.php');
	$app->render('menu.php');
 	$app->render('mobile.php', array('profileqr' => $profileqr ));
    $app->render('footer.php');    
        

})->name("mop");








///// admin www : menu, QR Codes and links to global view, user profile and rooms //

$app->get('/admin/www', function () use ($app,$sdk,$isaaConf) {


     if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }


    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
    
      
    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
      
    $qrurl = $cursor["_id"];        
    $profileqr= $cursor["domain"];

$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);

  	$sdk->path("cache/users/groups")
    			->withOrder(array("id"=>"ASC"))
				->withQueryParameters(array("limit" =>0, "offset"=>1, "fields" => array("counterValues","label")));
    

	$res = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );




 	$app->render('header3.php');
	$app->render('menu.php');
	$app->render('www.php'  ,  array('rooms' => $res,'qrurl' => $qrurl, 'profileqr' => $profileqr ));
    $app->render('footer.php'); 


})->name("ww");






///// Room : list of users in x room, feed ///////////////////////////////////

$app->get('/admin/room:id', @function($id) use ($app,$sdk, $cr,$isaaConf){


      if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

/***** types of notification ***********/

$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
  		$sdk->path("admin/notifications/types")
			->withQueryParameters(array("limit" =>0,"fields" => array("name","createdAt","updatedAt", "action")));
        $res9 = $sdk->api("admin/notifications/types", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


/***** users ****************************/
$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
   		$sdk->path("cache/users")
        	->withQuery(array("counterValues.counter" =>$cr ))
          	->withOrder (array("leaderboards.1.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				
        $res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


/***** Room's name *********************/
  
         $pref="cache/users/groups/"; 
         $p=$pref.$id; // id for restaurant
         
         $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 

		 $sdk->path($p)
			->withQueryParameters(array("fields" => array("name,label")));

         $res5 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );



         // notification id for selected room
         
         foreach ($res9 as $type):
         	if($type['name']==$res5['name']) $room=$type['id'];
         
         endforeach;
         
         ////////////////////////////////////
 /******render *****/


		$app->render('column.php');
		
	if(strpos($res5['name'], 'eeting') == true)
		$app->render('meetingroom.php', array('users' => $res4, 'roomid' => $res5)); //<- list of users (to do)
	else
    	$app->render('admin_room.php', array('users' => $res4, 'roomid' => $res5)); //<- list of users (to do)
    	$app->render('midd2.php');
 ////////////////////////////

         if(isset($room)){		
/****** all users *******************/  

$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  	
  		$sdk->path("cache/users")
             ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName", "counterValues")));   	
    	
         $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	

/********* notifications ************/

$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
    	 $sdk->path("queues/notifications")
            ->withQuery(array("typeId" =>$room))
            ->withOrder(array("updatedAt"=>"DESC"))
			->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

         $res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	

  		$app->render('admin_room2.php', array('data' => $res, 'person' => $res1)); //feed (to do)
            }
            else
	       echo "<center>"."There's no notification for selected room"."</center>";		
    	
})->name("aroom");











//////////////////// admin setup :   (get)  /////////////////////////


$app->get('/admin/setup', function () use ($app, $sdk,$isaaConf) {

    if (!isset($_SESSION['token'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
        
    $app->render('header3.php');
    $app->render('menu.php');
        
   $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);
        
    $sdk->path("cache/games")
				->withQueryParameters(array("limit" =>0,"fields" => array("conditions","segments", "name")));
				
    $res = $sdk->api("cache/games", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );      
 
 
 $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);
    $sdk->path("cache/users/groups")
				->withQueryParameters(array("limit" =>0,"fields" => array("label","segments")));
				
    $res1 = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
     
     
     $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);
    $sdk->path("admin/conditions")
      		->withOrder(array("id"=>"ASC"));
						
    $res2 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
    
   
  	$app->render('setup.php', array('games' => $res, 'groups' => $res1, 'conditions' => $res2 )); 
  	
  	$app->render('footer.php'); 
 

})->name("se");


//////////////////// admin add :  (get) /////////////////////////


$app->get('/admin/add', function () use ($app, $sdk) {

    if (!isset($_SESSION['token'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
        
    $app->render('header3.php');
    $app->render('menu.php');
        
 	$app->render('add.php') ;
  	
  	$app->render('footer.php'); 
 

})->name("add");

//////////////////// admin add :  (post) /////////////////////////


$app->post('/admin/add', function () use ($app, $sdk) {

    if (!isset($_SESSION['token'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
        
    $app->render('header3.php');
    $app->render('menu.php');
       
     /***********************************/   
    if(!empty($_POST['option'])){
		$option=$_POST['option'];
		
		if($option=='add'){
			$new_room=$_POST['newroom']; 
		
			foreach ($_SESSION['dane'] as $d):
				if($new_room==$d['name']){
					echo "Location's already exists!<br>";
					echo "<h4>List of all locations:</h4>";
					foreach ($_SESSION['dane'] as $d):
						if($new_room==$d['name'])
							echo "<strong><font color=\"red\">- ".$d['name']."</font></strong><br>";
						else
							echo "- ".$d['name']."<br>";
					endforeach;
					break;}
				else{
				$new= strtolower($new_room);
				$new=str_replace(" ","_","$new");
				$command1= "sudo config/configFile/s1-createGroup.sh";
   				$command2=" ";
   				$command=$command1.$command2.$_SESSION['base64'].$command2."\"".$new_room."\"".$command2.$new;
   				//echo $command;
   				exec($command,$result,$exit);
   				if ($exit ==0)
					echo "Success!";
					
				break;}
			endforeach;
			}
		else{
			$selected_room=$_POST['room'];
			
			
		 foreach ($_SESSION['dane'] as $d):
		 	if($d['name']==$selected_room)
		 		$del=$d['id_r'];
		 endforeach;
		 
		$pre="admin/users/groups/";
  		$p=$pre.$del;  
  	
  		$sdk->path($p);  	
		$res2 = $sdk->api($p, "delete", $sdk->getParameters(),  $sdk->getQueryParameters()  ); 
		
			}
		}
		else
			echo "Nie podano danych";
	
	
	/************************************/
  	$app->render('footer.php'); 
 

})->name("addd");


//////////////////// admin setup (post)  /////////////////////////



$app->post('/admin/setup', function () use ($app, $sdk) {
 
		if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }
       
        $app->render('header3.php');
        $app->render('menu.php');
        
        // games
            $sdk->path("cache/games")
				->withQueryParameters(array("limit" =>0,"fields" => array("conditions","segments", "name")));
				
        $res = $sdk->api("cache/games", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );      
       // groups
          $sdk->path("cache/users/groups")
				->withQueryParameters(array("limit" =>0,"fields" => array("label","segments")));
				
       $res1 = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
        
         //conditions
      $sdk->path("admin/conditions")
      		->withOrder(array("id"=>"ASC"))
      		->withQueryParameters(array("limit" =>0,"fields" => array("name")));
					
      $res2 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );  
       
  
     /*********************** check ***************************/
    
  	

    if((empty($_POST["uuid"])) || (empty($_POST["location"])) || (empty($_POST["major1"])) || (empty($_POST["minor1"]))) 
    	echo "You didn't fill all fields.";
    else {
    //mongo
    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))   
	{     	
 	                
 	$cursor['uuid'] = $_POST['uuid'];
 	$collection->save($cursor);
 	
    }
    
    ///
    
    $beacon_id = $_POST["major1"].".".$_POST["minor1"];
	$location= $_POST["location"];
	$data = $_SESSION["dane"];
	

	include ("./funkcje/setup_check.php"); //include class Setup check
	include ("./funkcje/setup_data.php"); //include class Setup data

 	$obiekt= new Setup_check;
  	$c_id= $obiekt->check($data, $location, $res2); //check if condition for selected id exists
  	
 


 	if(empty($c_id))

		echo "There's no condition for selected id";
		
	else{
	

		  	
	$obiekt2= new Setup_data;
  	$con= $obiekt2->data_to_save($beacon_id, $c_id); //check if condition for selected id exists
  
  foreach ($con as $c):
	$pre="admin/conditions/";
  	$p=$pre.$c['id'];  
  	
 
  	
  	$sdk->path($p);  	
			  	
 	$res2 = $sdk->api($p, "put", $sdk->getParameters(),  $sdk->getQueryParameters() ,  array('rightSide' =>  $c['beacon'])  ); 
  	
  endforeach;		echo "Success!";
  	}	
}
  		$app->render('footer.php'); 




})->name("set");




////////////////////   google calendar  (get)   ///////////////////////////

$app->get('/admin/calendar', function () use ($app, $sdk) {

    if (!isset($_SESSION['token'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
        
    $app->render('header3.php');
    $app->render('menu.php');
        
 	$app->render('calendar.php') ;
  	
  	$app->render('footer.php'); 
 

})->name("cal");
////////////////////   google calendar  (post)    ///////////////////////////

$app->post('/admin/calendar', function () use ($app, $sdk) {

    if (!isset($_SESSION['token'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
        
    $app->render('header3.php');
    $app->render('menu.php');

// ad base64
 if(empty($_POST['calendar1']) || empty($_POST['calendar2']))
 	echo "Enter base64 to your google calendar";
else{
	$m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))   
	{     	
 	      
 	 $c_base=$_POST['calendar1'].":".$_POST['calendar2'];        
 	$cursor['calendar'] =  base64_encode($c_base);
     

 	$collection->save($cursor);
 	echo "Success";
    }


}
//////
  	
  	$app->render('footer.php'); 
 

})->name("cl");





////////////////////   admin global : statistics, global feed  ///////////////////////////



$app->get('/admin/global', function () use ($app, $sdk,$isaaConf) {

         if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

  		    $app->render('column.php');
  		
  		
  		
  		
  		 //get statistics
  		 
  		 $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  
  	
  			$sdk->path("cache/users")
				->withQueryParameters(array("limit" => 0,"fields" => array("firstName","lastName","leaderboards","email", "gainedAchievements", "counterValues", "wonGames")));


            $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  
		
	      $sdk->path("cache/users/groups")
	    	->withOrder(array("segments"=>"ASC"))
	    	->withQueryParameters(array("limit" => 0, "offset" => 1, "fields" => array("counterValues", "label")));

          $resA = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


          $app->render('global.php', array('res1' => $res1, 'resA' => $resA ) );
  		  $app->render('midd2.php');
        
        //select from isaacloud 
            	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  
            	
            	
  	      $sdk->path("cache/users")
  			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName")));   	
    	
          $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	

$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  

          $sdk->path("queues/notifications")
              ->withQuery(array("typeId" =>1 ))
              ->withOrder(array("updatedAt"=>"DESC"))
              ->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

        $res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	
    	
    	$app->render('global2.php', array('data' => $res, 'person' => $res1));// global feed ->to do
        		

})->name("gl");



?>