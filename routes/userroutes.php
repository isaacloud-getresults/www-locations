<?php

/**************************** user routes **********************************************/


/// dashboard : my profile, list of all rooms  //////////////////////////////////////////


$app->get('/dashboard', function () use ($app,$sdk,$isaaConf) {


  	if (!isset($_SESSION['token'])) 
  	{
        $app->response->redirect($app->urlFor('e'), 303);
    }
        

	$a=$_SESSION["email"];
	
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
	
	try {
			$sdk->path("cache/users")
 				->withQuery(array("email" => $a))
				->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email")));

  
			$res = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

		}
	catch (\Exception $e)   {
     		throw $e;
      		}
   						
	foreach ($res as $r): 
			$_SESSION["lastName"]=$r["lastName"];
			$_SESSION["firstName"]=$r["firstName"];
			$_SESSION["id"]=$r["id"];
	endforeach; 


/***************************************************************************************/  
        
           // user doesn't exist in current instance
    if (!isset($_SESSION["id"])) {
                 $app->response->redirect($app->urlFor('ue'), 303); 
             } 
        
   
	$myid=$_SESSION["id"];
	$pref="cache/users/";
	$p=$pref.$myid;	
  
  
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 

		try {

    	       $sdk->path($p)
					->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","leaderboards","email")));
  
				$res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	
			}
			
		catch (\Exception $e){
     			 throw $e;
     			 }
	

   $app->render('header.php'); //header
   $app->render('myprofileshort.php', array('myprofile' => $res)); 
   
   $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
 
 
 	try {
 
    	$sdk->path("cache/users/groups")
    			->withOrder(array("id"=>"ASC"))
				->withQueryParameters(array("limit" =>0, "fields" => array("counterValues","label")));
    

	    $res = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	    }

	catch (\Exception $e){
          throw $e;
       }
	

		$app->render('midd.php'); // part between column
		$app->render('roomlist.php', array('rooms' => $res)); 
  		$app->render('footer.php');  //footer
  		
  		
})->name("d");




//// details : my profile, list of achievements //////////////////////////////////////////


$app->get('/details', @function () use ($app,$sdk,$isaaConf) {


	 if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

  	$app->render('header.php');
  		
	$myid=$_SESSION["id"];
	$pref="cache/users/";
	$p=$pref.$myid;	
  
  
    $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
  
  try {
    	$sdk->path($p)
    			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","gainedAchievements","email","leaderboards")));
    
	    $res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	  }
 catch (\Exception $e){
      throw $e;
      }


     	$app->render('myprofileshort2.php', array('myprofile' => $res)); // first column
    	$app->render('midd.php');
     
    
/////////////////// notifications


	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 

 try {

 	 $sdk->path("queues/notifications")
            ->withQuery(array("subjectId" =>$myid, "typeId" => 1,))
            ->withOrder(array("updatedAt"=>"DESC"))
			->withQueryParameters(array("limit" =>0,"fields" => array("data","subjectId", "updatedAt", "typeId")));

	$res7 = $sdk->api("queues/notifications", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
     }
  catch (\Exception $e){
      throw $e;
      }
 
 	 	$app->render('history.php', array('data' => $res7)); 
   		$app->render('footer.php'); 
   		
})->name("de");




// leaderboards: my points, leaderboards ////////////////////////////////////////////////


$app->get('/leaderboard', function () use ($app,$sdk,$isaaConf) {

if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

  		$app->render('header.php');
  		
  		
	$myid=$_SESSION["id"];
	$pref="cache/users/";
	$p=$pref.$myid; 
  	
  	

  $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
  
  try {
  
    	$sdk->path($p)
				 ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email","leaderboards")));

	    $res = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	    }
      catch (\Exception $e){
          throw $e;
      }
		    
  		$app->render('users1.php', array('user' => $res)); 
   		$app->render('midd.php');
   		
   		$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
   		
   		
   	    try {	
   		
   		   $sdk->path("cache/users")
                ->withOrder (array("leaderboards.position"=>"ASC"))
				->withQueryParameters(array("limit" =>0, "fields" => array("firstName","lastName","email","leaderboards")));

	      $res = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );		
   			
           }
       catch (\Exception $e){
           throw $e;
          }
   			
    	$app->render('users2.php', array('users' => $res)); 
  		$app->render('footer.php');    	  
  	  
  		
})->name("l");



/**************************** Routes with variables *************************************/

///// Room : number of users in x room, list of users ///////////////////////////////////

$app->get('/room/:id', @function($id) use ($app,$sdk,$isaaConf){


      if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }

 
    	$app->render('header2.php');
    	
    	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
    	
    	
    try {

   		    $sdk->path("cache/users")
              	->withQuery(array("counterValues.counter" => 1))
              	->withOrder (array("leaderboards.1.position"=>"ASC"))
				->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				

	 		$res = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
       }
    catch (\Exception $e){
          throw $e;
       }
    
//Room's name
  
	$pref="cache/users/groups/";  
	$p=$pref.$id;

	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 

    try {

    		$sdk->path($p)
				->withQueryParameters(array("limit" =>0,"fields" => array("label")));

			$res2 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
	
	    }
	catch (\Exception $e){
          throw $e;
         }


		$app->render('currentroom.php', array('roomid' => $res2,'users' => $res )); 
      	$app->render('midd.php');
   		$app->render('roomusers.php', array('users' => $res, 'roomid' => $res2)); 
    	$app->render('footer.php');
    	
})->name("ri");


////// User profile //////////////////////////////////////////////////////////////////////

$app->get('/users/:id', function($id) use ($app,$sdk,$isaaConf){

if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }
 
    $app->render('header2.php');
    
	$pref="cache/users/";
	$p=$pref.$id;
	
	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
	
	try {
	
         $sdk->path($p)
				 ->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email","leaderboards")));
    
	     $res2 = $sdk->api($p, "get", $sdk->getParameters(),  $sdk->getQueryParameters() );
    
        }
    catch (\Exception $e){
        throw $e;
        }

   		$app->render('user.php', array('users' => $res2)); // first column
    	$app->render('midd.php');
    	$app->render('footer.php');
    	
    	
})->name("ui");




?>