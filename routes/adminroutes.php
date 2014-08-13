<?php


/****************************  admin routes  ******************************************/



//////////////////////////// admin dashboard : menu, statistics ////////////////////////

$app->get('/admin/dashboard', function () use ($app,$sdk) {

	if (!isset($_SESSION['token'])) 
	 {
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
    
    if (!isset($_SESSION['token'])) 
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
       
        $app->render('checkemail.php');      
       
   
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


    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'token' => $_SESSION['activation'] ));
   

    if(!empty($cursor))   // token exists
	{     	
 	                
 	//update database
 	$cursor['base64'] = $_POST['base64'];
 	$_SESSION['base64']= $_POST['base64'];
 	$collection->save($cursor);
 	
 	//configure instance
 	

 	
 	
 	$app->response->redirect($app->urlFor('ic'), 303); 
 	
 	   
 	      		
	}


    else { echo "nieprawidlowy token";   }




    // $app->response->redirect($app->urlFor('root'), 303); 
 
   
    

})->name("scct");


//////////////////////////

$app->get('/admin/ic', function () use ($app) {

 	echo "<a href=./shelltest.php>start config</a>";

})->name("ic");




/////////////////// admin mobile : menu, QR Codes and links to appstore for mobile app. ///

$app->get('/admin/mobile', function () use ($app) {

	if (!isset($_SESSION['token'])) 
	{
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


    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
    
      
    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
      
    $qrurl = $cursor["_id"];         //get Object id of IsaaCloud instance, generate url for QR code





 	$app->render('header3.php');
	$app->render('menu.php');
	$app->render('www.php'  ,  array('qrurl' => $qrurl, 'profileqr' => $_SESSION['profileqr']) );
    $app->render('footer.php'); 


})->name("ww");


//////////////////// admin setup :  beacon's location (get)  /////////////////////////


$app->get('/admin/setup', function () use ($app, $sdk) {

    if (!isset($_SESSION['token'])) 
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
      
     
  	$app->render('setup.php', array('games' => $res, 'groups' => $res1, 'conditions' => $res2 )); // in progress
  	$app->render('footer.php'); 
 

})->name("se");



//////////////////// admin setup (post)  /////////////////////////



$app->post('/admin/setup', function () use ($app, $sdk) {
 
   if (!isset($_SESSION['token'])) 
        {
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
      		->withOrder(array("id"=>"ASC"));
					
   $res2 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
  
  
  
     /*********************** check ***************************/
     
    if((empty($_POST["beacon1"])) || (empty($_POST["location"]))) echo "Nie podano wszystkich danych!";
    else {
    $uid = $_POST["beacon1"];
	$location= $_POST["location"];
	$loc= explode(" ", $location);
	$data = $_SESSION["dane"];

	
		foreach($data as $dat):
			if(($loc[0]==$dat["name"]) && ($loc[1]==$dat["nr"]))
			$con=  $dat["condition"];
		
		endforeach;

	 	foreach ($res2 as $condition):
	 	 			
	 	 	if($con == $condition["id"] )
	 	 		$c_id=$con;
	 	 				
	 	endforeach;
	 

	if($c_id){
		echo "Success!";
	$pre="admin/conditions/";
  	$p=$pre.$c_id;  
  	
  	$sdk->path($p);  	
			  	
 	$res2 = $sdk->api($p, "put", $sdk->getParameters(),  $sdk->getQueryParameters() ,  array('rightSide' =>  $uid)  ); 
  	}
  	else
  		echo "There's no condition for selected id";
  		
  		}
  		$app->render('footer.php'); 



})->name("set");




////////////////////   admin global : statistics, global feed  ///////////////////////////



$app->get('/admin/global', function () use ($app, $sdk) {

   if (!isset($_SESSION['token'])) 
        {
        $app->response->redirect($app->urlFor('e'), 303);
        }


  $app->render('column.php');
  		
  //get statictics
  	
  $sdk->path("cache/users")
				->withQueryParameters(array("limit" => 0,"fields" => array("firstName","lastName","leaderboards","email", "gainedAchievements", "counterValues")));

  $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

  $sdk->path("queues/notifications");

  $res3 = $sdk->api("queues/notifications", "get",$sdk->getParameters(),  $sdk->getQueryParameters()  );

  $sdk->path("queues/events/done");

  $res4 = $sdk->api("queues/events/done", "get",$sdk->getParameters(),  $sdk->getQueryParameters()  );

  $app->render('global.php', array('res1' => $res1, 'res3' => $res3, 'res4' => $res4) );
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

		if (!isset($_SESSION['token'])) {
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



         // notification id for selected room
         
         foreach ($res9 as $type):
         	if($type['name']==$res5['name']) $room=$type['id'];
         
         endforeach;
         
         ////////////////////////////////////
 /******render *****/ 		
  		$app->render('column.php');
    	$app->render('restaurant.php', array('users' => $res4, 'roomid' => $res5)); //<- list of users (to do)
    	$app->render('midd2.php');

////////////////////////////

		if(isset($room))
		{		
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

		if (!isset($_SESSION['token'])) 
		{
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
 /******render *****/ 		
  		$app->render('column.php');
    	$app->render('meetingroom.php', array('users' => $res4, 'roomid' => $res5)); //<- list of users (to do)
    	$app->render('midd2.php');

////////////////////////////

		if(isset($room))
		{		
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

	if (!isset($_SESSION['token'])) 
	{
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

		if(isset($room))
		{		
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