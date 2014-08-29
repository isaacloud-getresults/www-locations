<?php
//get data from database
	class Mongo_get{
	
	
		public function db_init(){
	    
	        $m = new MongoClient(); 
			$db = $m->isaa;
			$collection = $db->users;
			return $collection;
	    
	    }
	
	
	
		//get UUID
		public function get_uuid(){
		
			$m = new MongoClient(); 
			$db = $m->isaa;
			$collection = $db->users;

			$cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
		
			$uu=0;
			
			if(!empty($cursor)){     	
 	          $uu=$cursor['uuid'];
 	          return $uu;
 			} 
 		}	
 			
 			public function get_IC_base(){
		
			$m = new MongoClient(); 
			$db = $m->isaa;
			$collection = $db->users;

			$cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
		
			$uu=0;
			
			if(!empty($cursor)){     	
 	          $uu=$cursor['base64'];
 	          return $uu;
 			} 
 			
 			}
 			
 			public function get_CAL_base(){
		
			$m = new MongoClient(); 
			$db = $m->isaa;
			$collection = $db->users;

			$cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
		
			$uu=0;
			
			if(!empty($cursor)){     	
 	          $uu=$cursor['calendar'];
 	          return $uu;
 			} 
 			
 	}		
	}