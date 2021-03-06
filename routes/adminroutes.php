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
	
	
	
	try {
	
	$sdk->path("cache/users")
	            ->withOrder (array("leaderboards.position"=>"ASC"))
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
		->withQueryParameters(array("limit" => 0, "offset" =>1, "fields" => array("label", "counterValues")));

	$resA = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );

}
catch (\Exception $e){
      throw $e;
      }





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

	$token= md5($_SESSION['email'].time());        // generate activation token            
	$_SESSION['activation']= $token;
	
	   $db= new Mongo_get;
           $collection=$db->db_init();
	
	
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

       $db= new Mongo_get;
           $collection=$db->db_init();
    
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

	

    $_SESSION['activation']= $code;

   $db= new Mongo_get;
           $collection=$db->db_init();

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


   $db= new Mongo_get;
           $collection=$db->db_init();

    $cursor = $collection->findOne(array( 'token' => $_SESSION['activation'] ));
   
    if(empty($cursor)) {  echo "Incorrect token";}     

 	$app->render('shell.php');
 	

})->name("ic");



/////////////////////////////// redirecting to admin dashboard, fetching variables ////////////////////////////////////////

$app->get('/admin/init', function () use ($app) {


     if (isset($_SESSION['token']) )
                                {             //checking if user exists in database   

   				   $db= new Mongo_get;
           $collection=$db->db_init();
    
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
        
        
   $db= new Mongo_get;
           $collection=$db->db_init();
    
      
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
        
   $db= new Mongo_get;
           $collection=$db->db_init();
    
      
    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))   
	{     	
 	       $profileqr= $cursor["domain"];      
 	
 	
 		   if (!empty($_POST['iosid']) )     
 	             {
 	             $cursor["iosid"] = $_POST["iosid"];
 	             $collection->save($cursor);
 	             }
 	
 	       if (!empty($_POST['iosbase64']) )     
 	             {
 	             $cursor["iosbase64"] = $_POST["iosbase64"];
 	             $collection->save($cursor);
 	             }
 	
           if (!empty($_POST['androidbase64'] )) 
 	             {
                 $cursor["androidbase64"] = $_POST["androidbase64"];
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


            $db= new Mongo_get;
           $collection=$db->db_init();
    
      
    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
      
    $qrurl = $cursor["_id"];        
    $profileqr= $cursor["domain"];





   $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);
        
      try {  
        
    $sdk->path("cache/games")
				->withQueryParameters(array("limit" =>0,"fields" => array("conditions","segments", "name")));
				
    $res = $sdk->api("cache/games", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );      
 
 
 
}
catch (\Exception $e){
      throw $e;
      }
 
 
 $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);
 
 try {
 
    $sdk->path("cache/users/groups")
    	 ->withOrder (array("label"=>"ASC" ))
				->withQueryParameters(array("limit" =>0, "offset" =>1, "fields" => array("label","segments")));
				
    $res1 = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
     

}
catch (\Exception $e){
      throw $e;
      }


 	$app->render('header3.php');
	$app->render('menu.php');
	$app->render('www.php'  ,  array('games' => $res,'groups' => $res1, 'qrurl' => $qrurl, 'profileqr' => $profileqr ));
    $app->render('footer.php'); 


})->name("ww");




///// Room : list of users in x room, feed ///////////////////////////////////

$app->get('/admin/room:id', @function($id) use ($app,$sdk, $cr,$isaaConf){


      if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }


  $db= new Mongo_get;
           $collection=$db->db_init();
   
        $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));





/***** types of notification ***********/

        $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
        
        try {
        
        
  		$sdk->path("admin/notifications/types")
			->withQueryParameters(array("limit" =>0,"fields" => array("name","createdAt","updatedAt", "action")));
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
          	->withOrder (array("leaderboards.position"=>"ASC" ))
			->withQueryParameters(array("limit" =>0,"fields" => array("firstName","lastName","email", "counterValues", "leaderboards")));
				
        $res4 = $sdk->api("cache/users", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );


    	}
catch (\Exception $e){
      throw $e;
      }


/***** Room's name *********************/
  
         $pref="cache/users/groups/"; 
         $p=$pref.$id; // id for restaurant
         
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
         
         ////////////////////////////////////
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

try {


$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
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
    	

    	
    	
})->name("aroom");


//////////////////// admin setup :   (get)  /////////////////////////


$app->get('/admin/setup', function () use ($app, $sdk,$isaaConf) {

    if (!isset($_SESSION['token'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
        
    $app->render('header3.php');
    $app->render('menu.php');
    
    //////////////////////////////////////////////////////////////////////////////////////     
    
    
    
    
    /************* get from isaa **********************/
    
    try {
    
     //get conditions
    
    	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);    
       
      	$sdk->path("admin/conditions")
   			->withQuery(array("leftSide" => "place"))
   			->withQueryParameters(array("limit" => 0, "fields" => array("name","leftSide", "rightSide")));
   				 		   
$resN = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters()  ); 
   				 
   				 
   		}
catch (\Exception $e){
      throw $e;
      }	
      
      try {
         
     //get games
        $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
       
        $sdk->path("cache/games")
   			->withQueryParameters(array("limit" => 0, "fields" => array("segments","conditions", "name")));
   				 		   
$resN2 = $sdk->api("cache/games", "get", $sdk->getParameters(),  $sdk->getQueryParameters()  ); 
        
        }
catch (\Exception $e){
      throw $e;
      }	
      
       

      
      try {
      
     
     //get user groups
      
    	$sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf); 
   		$sdk->path("cache/users/groups")
   			->withOrder (array("label"=>"ASC" ))
   			->withQueryParameters(array("limit" => 0, "fields" => array("segments","label", "name")));
      
       $resN3 = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters()  );
      
      }
catch (\Exception $e){
      throw $e;
      } 
      
       
     
     $sdk = new IsaaCloud\Sdk\IsaaCloud($isaaConf);
     
     try {
     
    $sdk->path("admin/conditions")
      		->withOrder(array("id"=>"ASC"));
						
    $res2 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
    
    	}
catch (\Exception $e){
      throw $e;
      }    
      
      
      
      
      
$i=0;
       				$check_beacon=array();
       				$cond= array();
        			$mm=array();
    				$nr=array();
        				foreach ($resN as $r):
        
        					if(strpos($r['rightSide'], 'exit') == true &&  $r['rightSide'] !=0){
        						$cond[$i]['id']=$r['id'];
        						$nr[$i]= explode(".exit", $r['rightSide']);
        						$mm[$i]=$nr[$i][0];
        						$cond[$i]['mm']=$nr[$i][0];
        						$check_beacon[$i]['condition']=$r['id'];
        						$check_beacon[$i]['mm']=$nr[$i][0];
        		
        						$i++;
        						}
        				endforeach;

   
         			$i=0;
        			$segments= array();
        			foreach($resN2 as $game):
        				foreach($game['conditions'] as $condition):
        					foreach($cond as $c):
        						if($c['id'] == $condition){
        							$segments[$i]['segment']=$game['segments'][0];
        							$segments[$i]['condition']=$c['id'];
        							$i++;
        							break;
        							}
        					endforeach;
        				endforeach;
        
       				 endforeach;
        
   
   
      
        			$beacons1= array();
        			$i=0;
       				$k=1;
       					 foreach($resN3 as $group):
        					foreach($group['segments'] as $sm):
        						foreach($segments as $s):
        							if($s['segment']==$sm){
        								$beacons1[$i]['location']=$group['label'];
        								$beacons1[$i]['beacon']="Beacon ".$k;
        								$beacons1[$i]['condition']=$s['condition'];
        								$k++;
        								$i++;
        								break;
        								}
        						endforeach;
        					endforeach;
        				endforeach;
    
				$beacons= array(); 
				$i=0;


					foreach($beacons1 as $b):
						foreach($check_beacon as $c):
							if($b['condition'] == $c['condition']){
								$beacons[$i]['location']=$b['location'];
        						$beacons[$i]['beacon']=	$b['beacon'];
        						$beacons[$i]['condition']=$b['condition'];
        						$beacons[$i]['mm']=$c['mm'];
        		
        						$i++;
		
							}
						endforeach;

					endforeach;
        
        if(isset($_SESSION["beacons"]))
  			$_SESSION["beacons"]= array();
  		$_SESSION["beacons"]=	$beacons;
  			
//////// //////////////////////////////////////////////////////////////////////////////
    

   
  	$app->render('setup.php', array('games' => $resN2, 'groups' => $resN3, 'conditions' => $res2, 'mm' => $mm, 'resN' => $resN)); 
  	
  	$app->render('footer.php'); 
 

})->name("se");


//////////////////// admin setup :  beacon's location add  (get) /////////////////////////


$app->get('/admin/add', function () use ($app, $sdk) {

    if (!isset($_SESSION['token'])) 
       {
        $app->response->redirect($app->urlFor('e'), 303);
       }
      
        
    $app->render('header3.php');
    $app->render('menu.php');
    
    try {
        
     $sdk->path("cache/users/groups")
      ->withOrder (array("label"=>"ASC" ))
				->withQueryParameters(array("limit" =>0,  "fields" => array("label", "name")));
				
    $res1 = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );   
    
        	}
catch (\Exception $e){
      throw $e;
      } 
        
        
 	$app->render('add.php', array('groups' => $res1)) ;
  	
  	$app->render('footer.php'); 
  	
  	
 		 

})->name("add");

//////////////////// admin setup :  beacon's location add (post)  /////////////////////////


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
		
				$new= strtolower($new_room);
				$new=str_replace(" ","_","$new");
				$command1= "sudo config/configFile/s1-createGroup.sh";
   				$command2=" ";
   				$command=$command1.$command2.$_SESSION['base64'].$command2."\"".$new_room."\"".$command2.$new;
   				//echo $command;
   				 if ($c=exec($command)){
   				 
   	
   	 $app->response->redirect($app->urlFor('se'), 303);
   			 
					 }
					 else {
					 
					 echo "<h4>Error :  <a href=\"./admin/add\"> Please try again </a></h4>";
					 }
				
			
}
		else{
			$selected_room=$_POST['room'];
			
			
			
			try {
			
			$sdk->path("admin/users/groups")
				->withQuery(array("label" => $selected_room))
   				 ->withQueryParameters(array("fields" => array("name","label")));
			  	
			$res2 = $sdk->api("admin/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters()  ); 
			
			
			}
catch (\Exception $e){
      throw $e;
      }
			
		$name= $res2[0]['name']; // arg pierwszy
		
	  $db= new Mongo_get;
           $collection=$db->db_init();


   		 $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))   
	{     	
 
 	$base=$cursor['base64'] ;// arg drugi
 	
	}
	
 $url_delete="http://getresults.isaacloud.com:8080/deleteRoom?iB64=".$base."&name=".$name;
	
	
	// create a new cURL resource
	$ch = curl_init($url_delete);
	// grab URL and pass it to the browser


if (curl_exec($ch) == true){

// close cURL resource, and free up system resources
curl_close($ch);

	$app->response->redirect($app->urlFor('add'), 303);
}
else {
echo "<h4>Error :  <a href=\"./admin/add\"> Please try again </a></h4>";

}
  		
		
			}
		}
		else
			echo "Nie podano danych";
	
	
	/************************************/
  	$app->render('footer.php'); 
 

})->name("addd");


///// admin ecex //

$app->get('/admin/exec', function () use ($app, $sdk) {


     if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }




if (isset($_GET['location'])){
	echo $_GET['location'];
	$room=$_GET['location'];
	}

$i=0;
$b_del= array();
 foreach ($_SESSION['dane'] as $r):
 
 	if($r['name'] == $room){
 		foreach($r['segments'] as $condition):
 			$b_del[$i]=$condition['condition'];
 			$i++;
 		
 		endforeach;
 		break;
 		}
 
 endforeach;



  foreach ($b_del as $c):

	$pre="admin/conditions/";
  	$p=$pre.$c;  
  	echo "$p";
  	
  	try {
  	
  	$sdk->path($p);  	
			  	
 	$res2 = $sdk->api($p, "put", $sdk->getParameters(),  $sdk->getQueryParameters() ,  array('rightSide'=> "0" )  ); 
  	
  	    	}
catch (\Exception $e){
      throw $e;
      }
  	
  endforeach;


$beacons=$_SESSION['beacons'];


foreach ($beacons as $key => $value) { 

    if ($value["location"] == $room) { unset($beacons[$key]); }

}
$new = array();
$i=0;
foreach($beacons as $b):

	$new[$i]=$b;
	$i++;
endforeach;

 $_SESSION['beacons']= $new;
 
 if($_GET['w'] == "1" )
    $app->response->redirect($app->urlFor('add'), 303);
else
	$app->response->redirect($app->urlFor('se'), 303);
        

})->name("exec");



//////////////////// admin setup (post)  /////////////////////////



$app->post('/admin/setup', function () use ($app, $sdk) {
 
		if (!isset($_SESSION['token'])) {
             $app->response->redirect($app->urlFor('e'), 303);
        }
       
        $app->render('header3.php');
        $app->render('menu.php');
        
        
        try {
        
        
        // games
            $sdk->path("cache/games")
				->withQueryParameters(array("limit" =>0,"fields" => array("conditions","segments", "name")));
				
        $res = $sdk->api("cache/games", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );    
        
            	}
catch (\Exception $e){
      throw $e;
      }
        
        try {
          
       // groups
          $sdk->path("cache/users/groups")
				->withQueryParameters(array("limit" =>0,"fields" => array("label","segments")));
				
       $res1 = $sdk->api("cache/users/groups", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );  
       
       
           	}
catch (\Exception $e){
      throw $e;
      }
      
      
      try { 
        
         //conditions
      $sdk->path("admin/conditions")
      		->withOrder(array("id"=>"ASC"))
      		->withQueryParameters(array("limit" =>0,"fields" => array("name")));
					
      $res2 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );  
       
       
    	}
catch (\Exception $e){
      throw $e;
      }
       
  
     /*********************** check ***************************/
    
  	
 if((empty($_POST["uuid"])) || (empty($_POST["location"])) || (empty($_POST["major1"])) || (empty($_POST["minor1"]))) {
    	if((!empty($_POST["uuid"])) && ((empty($_POST["location"])) || (empty($_POST["major1"])) || (empty($_POST["minor1"])))){
        //mongo
   $db= new Mongo_get;
   $collection=$db->db_init();


    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))   
	{     	
 	                
 	$cursor['uuid'] = $_POST['uuid'];
 	$collection->save($cursor);
 	
    }
 
  $app->response->redirect($app->urlFor('se'), 303);
  
    }
    else
    
    
    	echo "<h4>All fields must be fill :  <a href=\"./admin/setup\"> Please try again </a></h4>";
    	
    	
    	}
    else {
    //mongo
  $db= new Mongo_get;
           $collection=$db->db_init();


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


		
		echo "<h4>There's no condition for selected id : <a href=\"./admin/add\"> Please try again </a></h4>";
		
		
	else{
	
  $b_exit= $beacon_id.".exit";
   $b_group= $beacon_id.".group";	
   
   try {
  
   $sdk->path("admin/conditions")
   		->withQuery(array("rightSide" => $beacon_id));

$reS1 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );  


    	}
catch (\Exception $e){
      throw $e;
      }

try {


 $sdk->path("admin/conditions")
   		->withQuery(array("rightSide" => $b_exit));

$reS2 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() );  

    	}
catch (\Exception $e){
      throw $e;
      }


try {

 $sdk->path("admin/conditions")
   		->withQuery(array("rightSide" => $b_group));

$reS3 = $sdk->api("admin/conditions", "get", $sdk->getParameters(),  $sdk->getQueryParameters() ); 


    	}
catch (\Exception $e){
      throw $e;
      }
	
	$obiekt2= new Setup_data;
  	$con= $obiekt2->data_to_save($beacon_id, $c_id); //check if condition for selected id exists
  
  
  $id_del=array(); 
 $i=0;
 if(!empty($reS1)){
  foreach ($reS1 as $r):
  	$id_del[$i]=$r['id'];
  $i++;
  endforeach;
  
  }
  
     $id_del2= array(); 
   if(!empty($reS2)){

 $i=0;
  foreach ($reS2 as $r):
  	$id_del2[$i]=$r['id'];
  $i++;
  endforeach;
  

  }
  
   $id_del3=array();
  
   if(!empty($reS3)){
   
 $i=0;
  foreach ($reS3 as $r):
  	$id_del3[$i]=$r['id'];
  $i++;
  endforeach;
  

}
$wynik = array_merge($id_del, $id_del2, $id_del3);
 foreach ($wynik as $c):
	$pre="admin/conditions/";
  	$p=$pre.$c; 
  	
  	try {
  	
  	$sdk->path($p);  	
			  	
 	$res2 = $sdk->api($p, "put", $sdk->getParameters(),  $sdk->getQueryParameters() ,  array('rightSide' =>  "0")  ); 
 	
  	    	}
catch (\Exception $e){
      throw $e;
      }
  	
  	
  endforeach;

  
  
  
  
  
  
  
  
  foreach ($con as $c):
	$pre="admin/conditions/";
  	$p=$pre.$c['id'];  
  	
  	try {
  	
  	$sdk->path($p);  	
			  	
 	$res2 = $sdk->api($p, "put", $sdk->getParameters(),  $sdk->getQueryParameters() ,  array('rightSide' =>  $c['beacon'])  ); 
 	
  	    	}
catch (\Exception $e){
      throw $e;
      }
  	
  endforeach;

 
$app->response->redirect($app->urlFor('se'), 303);
 
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
   $db= new Mongo_get;
           $collection=$db->db_init();


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
        
        //select from isaacloud 
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

    	
    	
    	$app->render('global2.php', array('data' => $res, 'person' => $res1));
        		

})->name("gl");



?>