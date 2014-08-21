<?php 

	class Profile{
	
		var $users;
		
		public function profile_data($users){
		
			$arr= array();
			
			if(empty($users["firstName"]))
				$arr['firstName']= "---------";
			else 
				$arr['firstName']= $users["firstName"];
				
			if(empty($users["lastName"]))
				$arr['lastName']= "---------";
			else 
				$arr['lastName']= $users["lastName"];	
				
			if(empty($users["leaderboards"]["1"]["score"]))
				$arr['score']= "0";
			else 
				$arr['score']= $users["leaderboards"]["1"]["score"];
				
			if(empty($users["leaderboards"]["1"]["position"]))
				$arr['position']= "---------";
			else 
				$arr['position']= $users["leaderboards"]["1"]["position"];	
	
	
	
		return $arr;
		
		}
		
		

	
	}



?>
