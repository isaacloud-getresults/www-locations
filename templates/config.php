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
 
 			$base64 = $cursor['base64'];
   			$uuid= $cursor['uuid'];
 		      		

		    $data['base64'][0] = $base64;
   			$data['UUID'][0] = $uuid;


			$newJsonString = json_encode($data, JSON_UNESCAPED_SLASHES);
			file_put_contents('config.json', $newJsonString);

         }



?>