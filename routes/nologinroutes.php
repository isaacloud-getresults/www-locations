<?php



/**************************** Routes without login *************************************/



////////////////////// kitchen: no login required ////////////////////////////      


$app->get('/room:id/:b', @function($id,$b) use ($app,$sdk, $cr,$isaaConf){


      $m = new MongoClient(); 
      $db = $m->isaa;
      $collection = $db->users;
   
      $cursor = $collection->findOne(array( '_id' => new MongoId($b))); 

      if(!empty($cursor))                                             
	  {
	

              	if ($cursor["base64"] != null)                                                
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

	    $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
	    
	    
	    try {

  		$sdk->path("admin/notifications/types");

        $res9 = $sdk->api("admin/notifications/types", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	
        
        
        }
catch (\Exception $e){
      throw $e;
      }

/***** users ****************************/

	    $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
	    
	    
	    try {

   		$sdk->path("cache/users")
        	->withQuery(array("counterValues.counter" =>$cr ))
          	->withOrder (array("leaderboards.1.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				
        $res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
        
        
        }
catch (\Exception $e){
      throw $e;
      }

/***** Room's name *********************/
  
        $pref="cache/users/groups/"; 
        $p=$pref.$id; // 

     	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 

try {


		$sdk->path($p)
			->withQueryParameters(array("fields" => array("name", "label")));

       $res5 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

}
catch (\Exception $e){
      throw $e;
      }

// notification id for selected room
         
        foreach ($res9 as $type):
        if($type['name']==$res5['name']) $room=$type['id'];
         
        endforeach;
         
 /******render *****/ 	
 	
  		$app->render('column.php');
  		
  		
  		
  		if(strpos($res5['name'], 'eeting') == true)
		$app->render('meetingroom.php', array('users' => $res4, 'roomid' => $res5, 'cursor' => $cursor));
	    else
    	$app->render('admin_room.php', array('users' => $res4, 'roomid' => $res5)); 
    	$app->render('midd2.php');

////////////////////////////

         if(isset($room)){		
/****** all users *******************/  




	    $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
	    
	    
	    try {

  		$sdk->path("cache/users")
             ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName", "counterValues")));   	
    	
        $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 
        
        
        }
catch (\Exception $e){
      throw $e;
      }	

/********* notifications ************/

     	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 

try {
    	$sdk->path("queues/notifications")
            ->withQuery(array("typeId" =>$room))
            ->withOrder(array("updatedAt"=>"DESC"))
			->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

        $res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );	
        
        }
catch (\Exception $e){
      throw $e;
      }

        
        

  		$app->render('admin_room2.php', array('data' => $res, 'person' => $res1)); 
         }
        else
	    echo "<center>"."There are no notifications for selected room"."</center>";
	
})->name("roomlog");




////////////////////    global : no login required  ///////////////////////////         

$app->get('/global/:b', function ($b) use ($app, $sdk,$isaaConf) {


        $m = new MongoClient(); 
        $db = $m->isaa;
        $collection = $db->users;
            
        $cursor = $collection->findOne(array( '_id' => new MongoId($b)));
   

    if(!empty($cursor))                                             
	{

              	if ($cursor["base64"] != null)                                                
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
  	
  	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
  	
  	
  	try {
  	
  	
  	$sdk->path("cache/users")
				->withQueryParameters(array("limit" => 0,"fields" => array("firstName","lastName","leaderboards","email", "gainedAchievements", "counterValues", "wonGames")));


    $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    
            }
catch (\Exception $e){
      throw $e;
      }
    

	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 


try {

	 $sdk->path("cache/users/groups")
	    	->withOrder(array("segments"=>"ASC"))
	    	->withQueryParameters(array("limit" => 0, "offset" => 1, "fields" => array("counterValues", "label")));

    $resA = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


             }
catch (\Exception $e){
      throw $e;
      }
     
     
    $app->render('global.php', array('res1' => $res1, 'resA' => $resA ) );
  	$app->render('midd2.php');   
        
  
        
        
    $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
        
         
         try {
           	
  	$sdk->path("cache/users")
  			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName")));   	
    	
    $res1 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 	
    
    
            }
catch (\Exception $e){
      throw $e;
      }

	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 


try {

    $sdk->path("queues/notifications")
              ->withQuery(array("typeId" =>1 ))
              ->withOrder(array("updatedAt"=>"DESC"))
              ->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

    $res = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );		
    	
        }
catch (\Exception $e){
      throw $e;
      }
    	
    	
    $app->render('global2.php', array('data' => $res, 'person' => $res1));// global feed ->to do
        	

})->name("glnolog");




/////////////////////////////////////////////////////////////////////////////////////



?>