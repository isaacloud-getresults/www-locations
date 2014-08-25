<?php



/**************************** Routes without login *************************************/



////////////////////// kitchen: no login required ////////////////////////////      use objectid    53d63daa776946f76a8b4567


$app->get('/admin/room:id', @function($id) use ($app,$sdk, $cr){


      $m = new MongoClient(); 
      $db = $m->isaa;
      $collection = $db->users;
   
      $cursor = $collection->findOne(array( '_id' => new MongoId($b))); 

      if(!empty($cursor))                                             
	  {
	

              	if ($cursor["base64"] != null)                                                /// user exists and owns an instance
     	         { 
 	             $dane=base64_decode($cursor["base64"]);
 				 list ($clientid, $secret) = explode(":", $dane);
                 }      		
	  }
      else
        	{
        	$app->response->redirect($app->urlFor('e'), 303);
        	}			


     //Configuration connection into IsaaCloud server
	 $isaaConf = array(
     "clientId" => $clientid,
     "secret" => $secret
	);

	//create new instance of IsaaCloud SDK
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  

	
		
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
      $p=$pref.$id; // 

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
	
})->name("roomlog");















////////////////////// kitchen: no login required ////////////////////////////      use objectid    53d63daa776946f76a8b4567

$app->get('/kitchen/:b', function ($b) use ($app,$sdk,$cr, $id_k) {


      $m = new MongoClient(); 
      $db = $m->isaa;
      $collection = $db->users;
   
      $cursor = $collection->findOne(array( '_id' => new MongoId($b))); 

      if(!empty($cursor))                                             
	  {
	

              	if ($cursor["base64"] != null)                                                /// user exists and owns an instance
     	         { 
 	             $dane=base64_decode($cursor["base64"]);
 				 list ($clientid, $secret) = explode(":", $dane);
                 }      		
	  }
      else
        	{
        	$app->response->redirect($app->urlFor('e'), 303);
        	}			


     //Configuration connection into IsaaCloud server
	 $isaaConf = array(
     "clientId" => $clientid,
     "secret" => $secret
	);

	//create new instance of IsaaCloud SDK
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  

	
		
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
	
})->name("kitnolog");




////////////////////    global : no login required  ///////////////////////////         use objectid    53d63daa776946f76a8b4567

$app->get('/global/:b', function ($b) use ($app, $sdk) {


        $m = new MongoClient(); 
        $db = $m->isaa;
        $collection = $db->users;
            
        $cursor = $collection->findOne(array( '_id' => new MongoId($b)));
   

    if(!empty($cursor))                                             
	{

              	if ($cursor["base64"] != null)                                                /// user exists and owns an instance
     	             { 
 	                  $dane=base64_decode($cursor["base64"]);
 				      list ($clientid, $secret) = explode(":", $dane);
 	      			 }	      		   		
	}

	else
 	         {
 	         $app->response->redirect($app->urlFor('e'), 303);
 	         }			
 			


	//Configuration connection into IsaaCloud server
	$isaaConf = array(
     "clientId" => $clientid,
     "secret" => $secret
	);

	//create new instance of IsaaCloud SDK
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);  

	$app->render('column.php');
  		
  	//get statistics
  	
  			$sdk->path("cache/users")
				->withQueryParameters(array("limit" => 0,"fields" => array("firstName","lastName","leaderboards","email", "gainedAchievements", "counterValues", "wonGames")));


      $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


	  $sdk->path("cache/users/groups")
		->withOrder(array("segments"=>"ASC"))
		->withQueryParameters(array("limit" => 0, "offset" => 1,"fields" => array("segments", "label")));

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
        	
	

})->name("glnolog");




/////////////////////////////////////////////////////////////////////////////////////

////////////////////// no login restaurant: list of users, feed ////////////////////////////

$app->get('/restaurant/:b', function ($b) use ($app, $sdk, $cr, $id_r) {



      $m = new MongoClient(); 
      $db = $m->isaa;
      $collection = $db->users;
   
      $cursor = $collection->findOne(array( '_id' => new MongoId($b))); 

      if(!empty($cursor))                                             
	  {
	

              	if ($cursor["base64"] != null)                                                /// user exists and owns an instance
     	         { 
 	             $dane=base64_decode($cursor["base64"]);
 				 list ($clientid, $secret) = explode(":", $dane);
                 }      		
	  }
      else
        	{
        	$app->response->redirect($app->urlFor('e'), 303);
        	}			


     //Configuration connection into IsaaCloud server
	 $isaaConf = array(
     "clientId" => $clientid,
     "secret" => $secret
	);

	//create new instance of IsaaCloud SDK
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);


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
  		
  		
})->name("restnolog");

////////////////////// no login meeting_room: list of users, feed ////////////////////////////


$app->get('/meetingroom/:b', function ($b) use ($app, $sdk, $cr, $id_mr) {



      $m = new MongoClient(); 
      $db = $m->isaa;
      $collection = $db->users;
   
      $cursor = $collection->findOne(array( '_id' => new MongoId($b))); 

      if(!empty($cursor))                                             
	  {
	

              	if ($cursor["base64"] != null)                                                /// user exists and owns an instance
     	         { 
 	             $dane=base64_decode($cursor["base64"]);
 				 list ($clientid, $secret) = explode(":", $dane);
                 }      		
	  }
      else
        	{
        	$app->response->redirect($app->urlFor('e'), 303);
        	}			


     //Configuration connection into IsaaCloud server
	 $isaaConf = array(
     "clientId" => $clientid,
     "secret" => $secret
	);

	//create new instance of IsaaCloud SDK
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);


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
  		
})->name("meetnolog");



?>