<?php


  $sub = array_shift(explode(".",$_SERVER['SERVER_NAME']));  




  $jsonString = file_get_contents('config.json');
  $data = json_decode($jsonString,true);


    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'domain' => $sub ));
   





    if(!empty($cursor))      //check if instance exists
	     {     	
 
 			$base64 = $cursor['mobilebase64'];
   			$uuid= $cursor['uuid'];
 		      		
 		      
 		      if ($cursor['mobilebase64']!= null)
 		      	{
           		 $dane=base64_decode($cursor["mobilebase64"]);
           		 list ($clientid, $secret) = explode(":", $dane);		
 		      		
 		      		
 		      	 $data['base64'] = $base64;

		   		 $data['clientid']= $clientid;
		    
   				 $data['secret'] = $secret;
   				 
   				} 
   				 
   				 
   				 else 
   				 
   				 {
   				 $data['base64']= null;
   				 $data['clientid']= null;
		    
   				 $data['secret'] = null;
   				 
   				 }
   				 
   				 
   				 if ($cursor['uuid']!= null)
 		      	{
   				 
   				 $data['uuid'] = $uuid;
                }
                else {$data['uuid'] = null;}
                
                
         }
         
         
         
         
         
    else   
    { 
                 $data['base64']= null;
                 $data['clientid']= null;
   				 $data['secret'] = null;
   				 $data['uuid'] = null;
    }






			$newJsonString = json_encode($data, JSON_UNESCAPED_SLASHES);
			file_put_contents('config.json', $newJsonString);


?>