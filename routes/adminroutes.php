<?php


/****************************  admin routes  ******************************************/



//////////////////////////// admin dashboard : menu, statistics ////////////////////////

$app->get('/admin/dashboard', function () use ($app,$sdk) {

	if (!isset($_SESSION['email'])) 
	 {
      $app->response->redirect($app->urlFor('e'), 303);
     }

	$app->render('header3.php');
	$app->render('menu.php');
	
	
	
	
	//get statistics 
	
	$sdk->path("cache/users")
				->withQueryParameters(array("limit" => 0,"fields" => array("firstName","lastName","leaderboards","email", "gainedAchievements", "counterValues", "wonGames")));
  
 
    
    $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    

	$sdk->path("cache/users/groups")
		->withOrder(array("segments"=>"ASC"))
		->withQueryParameters(array("limit" => 0, "offset" =>1, "fields" => array("label", "counterValues")));

	$resA = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );



    $app->render('admindashboard.php', array('res1' => $res1, 'resA' => $resA) );
	$app->render('footer.php');

})->name("ad");



//////////////////////////  admin register (get)  //////////////////////////////////////

$app->get('/admin/register', function () use ($app) {
    
    if (!isset($_SESSION['email'])) 
    {
    $app->response->redirect($app->urlFor('e'), 303);
    }


    $sub=false;   // subdomain doesn't exist


	$token= md5($_SESSION['email'].time());        // generate registration token            
	$_SESSION['activation']= $token;

	$app->render('register.php', array('sub' => $sub));  
 
})->name("ar");


//////////////////////////  admin register (post)   ///////////////////////////////////

$app->post('/admin/register', function () use ($app) {

     if (!isset($_SESSION['email'])) 
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
       
        $app->render('checkemail.php');      
       
   
        $user=array(
                "email" =>  $_SESSION['email'],
                "token" =>  $_SESSION['activation'],
			    "base64" =>  null,
			    "domain" =>  $_POST['domain'],
			    "activation" =>  "false",
			    "uuid" =>  null,
			    "mobilebase64" =>  null
   
              );
                  
           $cursor2 = $collection->findOne(array( 'email' => $_SESSION['email']));       
         if (empty($cursor2)) {           
                  
        $collection->insert($user);
        
        }
        
        

     }
    else
    
       {   
         $sub=true;
         $app->render('register.php', array('sub' => $sub));   
       }


})->name("sar");

//////////////////////// admin activation (get) //////////////////////////////////////////


$app->get('/admin/activate/:code', function ($code) use ($app) {

	/// check in database if the user and token are active (if not->activate)
	

	

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
 				
  			    $app->render('activate.php'); 
 
 	      		}	      		
 	      		
	}


    else echo "nieprawidlowy token";   



})->name("cct");




/////////////////////////////// admin activate (post) ////////////////////////////////////////

$app->post('/admin/activate/activate', function () use ($app) {


	$_SESSION['base64']= $_POST['base64'];


 	   
 	   $app->response->redirect($app->urlFor('ic'), 303); 
 	   
 	      		
	

 

})->name("scct");


/////////////////////////


$app->get('/admin/ic', function () use ($app) {


   $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'token' => $_SESSION['activation'] ));
   

    if(!empty($cursor))   // token exists
	{     	
 	                
 	$_SESSION['email']= $cursor['email'];    ///// hmmmmmmmm
 
    }

    else echo "nieprawidlowy token";


 	 $app->render('shell.php');

})->name("ic");




$app->get('/admin/init', function () use ($app) {


     if (isset($_SESSION['email']) )
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






/////////////////// admin mobile : menu, QR Codes and links to appstore for mobile app. ///

$app->get('/admin/mobile', function () use ($app) {

	if (!isset($_SESSION['email'])) 
	{
    $app->response->redirect($app->urlFor('e'), 303);
    }
        
        
    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
    
      
    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
      
           //get Object id of IsaaCloud instance, generate url for QR code
    $profileqr= $cursor["domain"];
   
        
        
    $app->render('header3.php');
	$app->render('menu.php');
 	$app->render('mobile.php', array('profileqr' => $profileqr ));
    $app->render('footer.php');    
        

})->name("mo");




/////////////////// admin mobile : menu, QR Codes and links to appstore for mobile app. ///

$app->post('/admin/mobile', function () use ($app) {

	if (!isset($_SESSION['email'])) 
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
 	$cursor['mobilebase64'] = $_POST['mobilebase64'];
 	$collection->save($cursor);
 	
    }
   
        
        
    $app->render('header3.php');
	$app->render('menu.php');
 	$app->render('mobile.php', array('profileqr' => $profileqr ));
    $app->render('footer.php');    
        

})->name("mop");








///// admin www : menu, QR Codes and links to: kitchen, meeting room, restaurant, general and user profile //

$app->get('/admin/www', function () use ($app,$sdk) {


     if (!isset($_SESSION['email'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }


    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
    
      
    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
      
    $qrurl = $cursor["_id"];         //get Object id of IsaaCloud instance, generate url for QR code
    $profileqr= $cursor["domain"];



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

$app->get('/admin/room:id', @function($id) use ($app,$sdk, $cr){


      if (!isset($_SESSION['email'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

/***** types of notification ***********/
  		$sdk->path("admin/notifications/types");

        $res9 = $sdk->api("admin/notifications/types", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	


/***** users ****************************/
   		$sdk->path("cache/users")
        	->withQuery(array("counterValues.counter" =>$cr ))
          	->withOrder (array("leaderboards.1.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				
        $res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


/***** Room's name *********************/
  
         $pref="cache/users/groups/"; 
         $p=$pref.$id; // id for restaurant

		 $sdk->path($p)
			->withQueryParameters(array("fields" => array("name")));

         $res5 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );



         // nootyfication id for selected room
         
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
  		$sdk->path("cache/users")
             ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName", "counterValues")));   	
    	
         $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	

/********* notifications ************/
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











//////////////////// admin setup :  beacon's location (get)  /////////////////////////


$app->get('/admin/setup', function () use ($app, $sdk) {

    if (!isset($_SESSION['email'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
        
    $app->render('header3.php');
    $app->render('menu.php');
        
        
    $sdk->path("cache/games")
				->withQueryParameters(array("limit" =>0,"fields" => array("conditions","segments", "name")));
				
    $res = $sdk->api("cache/games", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );      
 
    $sdk->path("cache/users/groups")
				->withQueryParameters(array("limit" =>0,"fields" => array("label","segments")));
				
    $res1 = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
     
    $sdk->path("admin/conditions")
      		->withOrder(array("id"=>"ASC"));
						
    $res2 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
    
   
  	$app->render('setup.php', array('games' => $res, 'groups' => $res1, 'conditions' => $res2 )); 
  	
  	$app->render('footer.php'); 
 

})->name("se");


//////////////////// admin setup :  beacon's location add  (get) /////////////////////////


$app->get('/admin/add', function () use ($app, $sdk) {

    if (!isset($_SESSION['email'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
        
    $app->render('header3.php');
    $app->render('menu.php');
        
 	$app->render('add.php') ;
  	
  	$app->render('footer.php'); 
 

})->name("add");

//////////////////// admin setup :  beacon's location add (post)  /////////////////////////


$app->post('/admin/add', function () use ($app, $sdk) {

    if (!isset($_SESSION['email'])) 
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
					}
				else{
				$new= strtolower($new_room);
				$new=str_replace(" ","_","$new");
				$command1= "sudo config/configFile/s1-createGroup.sh";
   				$command2=" ";
   				$command=$command1.$command2.$_SESSION['base64'].$command2.$new_room.$command2.$new;
   				//echo $command;
   				exec($command);
					echo "Success!";
					break;
				}
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
 
		if (!isset($_SESSION['email'])) {
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





////////////////////   admin global : statistics, global feed  ///////////////////////////



$app->get('/admin/global', function () use ($app, $sdk) {

         if (!isset($_SESSION['email'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

  		    $app->render('column.php');
  		
  		
  		
  		
  		 //get statistics
  	
  			$sdk->path("cache/users")
				->withQueryParameters(array("limit" => 0,"fields" => array("firstName","lastName","leaderboards","email", "gainedAchievements", "counterValues", "wonGames")));


            $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


		
	      $sdk->path("cache/users/groups")
	    	->withOrder(array("segments"=>"ASC"))
	    	->withQueryParameters(array("limit" => 0, "offset" => 1, "fields" => array("counterValues", "label")));

          $resA = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


          $app->render('global.php', array('res1' => $res1, 'resA' => $resA ) );
  		  $app->render('midd2.php');
        
        //select from isaacloud 
            	
  	      $sdk->path("cache/users")
  			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName")));   	
    	
          $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	

          $sdk->path("queues/notifications")
              ->withQuery(array("typeId" =>1 ))
              ->withOrder(array("updatedAt"=>"DESC"))
              ->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

        $res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	
    	
    	$app->render('global2.php', array('data' => $res, 'person' => $res1));// global feed ->to do
        		

})->name("gl");


////////////////////// admin restaurant: list of users, feed ////////////////////////////

$app->get('/admin/restaurant', function () use ($app, $sdk, $cr, $id_r) {

		if (!isset($_SESSION['email'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }


/***** types of notification ***********/
  		$sdk->path("admin/notifications/types");

        $res9 = $sdk->api("admin/notifications/types", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	


/***** users ****************************/
   		$sdk->path("cache/users")
        	->withQuery(array("counterValues.counter" =>$cr ))
          	->withOrder (array("leaderboards.1.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				
        $res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


/***** Room's name *********************/
  
         $pref="cache/users/groups/"; 
         $p=$pref.$id_r; // id for restaurant

		 $sdk->path($p)
			->withQueryParameters(array("fields" => array("name")));

         $res5 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );



         // nootyfication id for selected room
         
         foreach ($res9 as $type):
         	if($type['name']==$res5['name']) $room=$type['id'];
         
         endforeach;
         
         ////////////////////////////////////
 /******render *****/ 		
  		$app->render('column.php');
    	$app->render('restaurant.php', array('users' => $res4, 'roomid' => $res5)); //<- list of users (to do)
    	$app->render('midd2.php');

////////////////////////////

         if(isset($room)){		
/****** all users *******************/   	
  		$sdk->path("cache/users")
             ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName", "counterValues")));   	
    	
         $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	

/********* notifications ************/
    	 $sdk->path("queues/notifications")
            ->withQuery(array("typeId" =>$room))
            ->withOrder(array("updatedAt"=>"DESC"))
			->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

         $res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	

  		$app->render('restaurant2.php', array('data' => $res, 'person' => $res1)); //feed (to do)
            }
            else
	       echo "<center>"."There's no notification for selected room"."</center>";		
  			
  		
})->name("rest");

////////////////////// admin meeting_room: list of users, feed ////////////////////////////


$app->get('/admin/meetingroom', function () use ($app, $sdk, $cr, $id_mr) {

	if (!isset($_SESSION['email'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }


/***** types of notification ***********/
  		$sdk->path("admin/notifications/types");

        $res9 = $sdk->api("admin/notifications/types", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	 


/***** users ****************************/
   		$sdk->path("cache/users")
        	->withQuery(array("counterValues.counter" =>$cr ))
          	->withOrder (array("leaderboards.1.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				
$res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

 //   var_dump($res4);


/***** Room's name *********************/
  
         $pref="cache/users/groups/"; 
         $p=$pref.$id_mr; // id for kitchen

		 $sdk->path($p)
			->withQueryParameters(array("fields" => array("name")));

         $res5 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	
        //echo $res5['label']; // <- room's name


         // notification id for selected room
         
         foreach ($res9 as $type):
         	if($type['name']==$res5['name']) $room=$type['id'];
         
         endforeach;
         
         ////////////////////////////////////
		
         ////////////////////////////////////
 /******render *****/ 		
  		$app->render('column.php');
    	$app->render('meetingroom.php', array('users' => $res4, 'roomid' => $res5)); //<- list of users (to do)
    	$app->render('midd2.php');

////////////////////////////

         if(isset($room)){		
/****** all users *******************/   	
  		$sdk->path("cache/users")
             ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName", "counterValues")));   	
    	
        $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	

/********* notifications ************/
    	 $sdk->path("queues/notifications")
            ->withQuery(array("typeId" =>$room))
            ->withOrder(array("updatedAt"=>"DESC"))
			->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

        $res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	


  		$app->render('meetingroom2.php', array('data' => $res, 'person' => $res1)); //feed (to do)
        }
        else
	    echo "<center>"."There's no notification for selected room"."</center>";	
  		

})->name("meet");

////////////////////// admin kitchen: list of users, feed ////////////////////////////


$app->get('/admin/kitchen', function () use ($app,$sdk,$cr, $id_k) {

	if (!isset($_SESSION['email'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }	
		
/***** types of notification ***********/
  		$sdk->path("admin/notifications/types");

        $res9 = $sdk->api("admin/notifications/types", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	
 


/***** users ****************************/
   		$sdk->path("cache/users")
        	->withQuery(array("counterValues.counter" =>$cr ))
          	->withOrder (array("leaderboards.1.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				
        $res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


/***** Room's name *********************/
  
        $pref="cache/users/groups/"; 
        $p=$pref.$id_k; // id for kitchen

		$sdk->path($p)
			->withQueryParameters(array("fields" => array("name")));

         $res5 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	
        //echo $res5['label']; // <- room's name


         // notification id for selected room
         
         foreach ($res9 as $type):
         	if($type['name']==$res5['name']) $room=$type['id'];
         
         endforeach;
         
         ////////////////////////////////////
 /******render *****/ 		
  		$app->render('column.php');
    	$app->render('kitchen.php', array('users' => $res4, 'roomid' => $res5)); //<- list of users (to do)
    	$app->render('midd2.php');

////////////////////////////

         if(isset($room)){		
/****** all users *******************/   	
  		$sdk->path("cache/users")
             ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName", "counterValues")));   	
    	
        $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	

/********* notifications ************/
    	 $sdk->path("queues/notifications")
            ->withQuery(array("typeId" =>$room))
            ->withOrder(array("updatedAt"=>"DESC"))
			->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

        $res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	


  		$app->render('kitchen2.php', array('data' => $res, 'person' => $res1)); //feed (to do)
        }
        else
	   echo "<center>"."There's no notification for selected room"."</center>";	
	
})->name("kit");


?>