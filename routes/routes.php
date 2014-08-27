<?php 



////////////////////////////////  root   /////////////////////////////////////////////

$app->get('/', function () use ($app,$sdk,$authUrl,$authUrl1,$authUrl2,$jest) {
 

    if(isset($authUrl1) && isset($authUrl2))
     {                                         
      // not logged in   
      $app->render('welcome.php', array( 'url1' => $authUrl1, 'url2' => $authUrl2  ));
     }

                 else
                 {      
                 
                              if (isset($_SESSION['email']) && $_SESSION['state']="admin"  )
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
 	      		 										}

                                 }                
                 
                 
             //logged in  
                        if  ($jest)          // if exists in database go to admin dashboard else register
                              {     
                              $app->response->redirect($app->urlFor('ad'), 303);   
                              }
                              else 
                              {  
                              $app->response->redirect($app->urlFor('ar'), 303);   
                              }
                              
                              
                  }

 
 
})->name("root");


////////////////////////////////  root  - user route  /////////////////////////////////////////////

$app->get('/user', function () use ($app,$sdk,$authUrl1,$authUrl2,$jest) {

	
 	if(isset($authUrl1) && isset($authUrl2))
 				 {        
 				 // not logged in  
    			$app->render('welcome.php', array( 'url1' => $authUrl1, 'url2' => $authUrl2  ));
    			 }
    			 
         else
                 
                 
                 {                     
                 //logged in  
               
                              if (isset($_SESSION['email']) && isset($_SESSION['domain'] ) && $_SESSION['state']="user" )
                              {             

								$m = new MongoClient(); 
								$db = $m->isaa;
								$collection = $db->users;
    
    							$ok=false; 
    
                                $cursor = $collection->find(array( 'domain' => $_SESSION['domain'] ));      // check in database for instance
   
   
  								if(!empty($cursor))                                             
									              {
	
	   											   foreach ($cursor as $user): 

            									   if ($user["base64"] != null)                                               
     	        								        { 
 	
 	           									    	$dane=base64_decode($user["base64"]);
 														list ($clientid, $secret) = explode(":", $dane);
 	
 														$ok=true;
 			
 														$_SESSION['clientid']=$clientid;
 														$_SESSION['secret']=$secret;
													    }
 	      		
 	   											   endforeach;		
 	      		
 	      		
	 											  }
   
				                }




 					         if  ($ok)        
     							{     
   								  $app->response->redirect($app->urlFor('d'), 303);       
    						    }
 							else 
 						     	{  
     							  $app->response->redirect($app->urlFor('ue'), 303);  
       
    							 }     
     
     
      }
 

 
})->name("rootuser");





////////////////////////////////  error (access denied)  /////////////////////////////////////////////


$app->get('/error', function () use ($app) {

  $app->render('error.php');
  session_destroy();
  $app->view()->setData('token', null); 
  $app->client->revokeToken();
 
 
})->name("e");



//////////////////////////// user doesn't exist   ///////////////////////////////////////

$app->get('/uerror', function () use ($app) {

  $app->render('nouser.php');
  session_destroy();
  $app->view()->setData('token', null); 
  $app->client->revokeToken(); 
 
 
})->name("ue");





///////// logout /////////////////////////////////////////////////////////////////////////



$app->get('/ulogout', function () use ($app,$sdk) {

   session_destroy();
   $app->view()->setData('token', null);
   $app->client->revokeToken();  

 
   if (isset($_SESSION['domain']) && $_SESSION['domain']!= "" )
   {  
     	$u= "http://".$_SESSION['domain'].".getresults.isaacloud.com/";
   //  	$u = "http://".$_SESSION['domain']."/~mac/";
   
    		 $app->response->redirect($u);
    }

  else 
   { 
     $app->response->redirect($app->urlFor('root'), 303);
   }

   
  
})->name("uo");



//////////////// empty, used for redirecting /////////////////////////////////////////////////////////////////

$app->get('/users', function () use ($app) {

})->name("u");


//////////////// update config file for mobile apps /////////////////////////////////////////////////////////////////

$app->get('/mconfig', function () use ($app) {

  $app->render('config.php');
  $app->response->redirect('/config.json', 303);

})->name("mconfig");




 ?>