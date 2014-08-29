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
				
			foreach ($users["leaderboards"] as $leaderboard):
			
				if(empty($leaderboard["score"]))
					$arr['score']= "0";
				else 
					$arr['score']= $leaderboard["score"];
	
				
				if(empty($leaderboard["position"]))
					$arr['position']= "---------";
				else 
					$arr['position']= $leaderboard["position"];	
	
			endforeach;
	
		return $arr;
		
		}
		
		

	
	}



?>
