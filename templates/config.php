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
 
 			$iosbase64 = $cursor['iosbase64'];
 			$androidbase64 = $cursor['androidbase64'];
   			$uuid= $cursor['uuid'];
   			$iosid = $cursor['iosid'];
 		      		
 		      
 		      if ($cursor['iosbase64']!= null)
 		      	{
 		      	
 		      	$data['iosbase64']= $iosbase64;
 		      	
           		 $dane=base64_decode($cursor["iosbase64"]);
           		 

           		 
           		 list ($clientid, $secret) = explode(":", $dane);	
           		 
           	
           		  $data['iossecret']= $secret;
           		  	 $data ["clientid"] = $clientid;
			   
   				} 
   				 
   				 
   				 else 
   				 
   				 {

   				 
   				 $data['iosbase64']= null;
		    
   				 $data['iossecret'] = null;
   				 
   				 $data ["clientid"] = null;
   				 
   				 }
   				 
   				 
   			  if ($cursor['androidbase64']!= null)
 		      	{
 		      	
 		      	$data['androidbase64']= $androidbase64;
 		      	
           		 $dane=base64_decode($cursor["androidbase64"]);
           		 

           		 
           		 list ($clientid, $secret) = explode(":", $dane);
           		
           		 $data['androidsecret']= $secret;
           
			 
			 
			 
   				 if ($data['clientid']  == null){$data['clientid']=$clientid;}
			 
			 
   				} 
   				 
   				 
   				 else 
   				 
   				 {

   				 
   				 $data['androidbase64']= null;
		    
   				 $data['androidsecret'] = null;
   				 
   				 }
   				 
   				 
   				 
   				 
   				 
   				 
   				 
   				 
   				 
   				 if ($cursor['uuid']!= null)
 		      	{
   				 
   				 $data['uuid'] = $uuid;
                }
                else {$data['uuid'] = null;}
                
                
                 if ($cursor['iosid']!= null)
 		      	{
   				 
   				 $data['iosid'] = $iosid;
                }
                else {$data['iosid'] = null;}
                
                
                
                
         }
         
         
         
         
         
    else   
    { 
                 $data['iosbase64']= null;
                 $data['iossecret']= null;
                 $data['androidbase64']= null;
                 $data['androidsecret']= null;
                 $data['clientid']= null;
   				 $data['iosid'] = null;
   				 $data['uuid'] = null;
    }






			$newJsonString = json_encode($data, JSON_UNESCAPED_SLASHES);
			file_put_contents('config.json', $newJsonString);


?>