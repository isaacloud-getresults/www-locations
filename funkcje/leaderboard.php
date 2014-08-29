<?php 
// create an array with leaderboard data
	class Leaderboard{
	
		var $users;
		var $roomid;
		var $members;
		var $data2;
		
		public function create_array($users, $roomid){
		
			$tab = array();
			$i=0;
			foreach ($users as $user):
		
				foreach($user['counterValues'] as $counter):
 					if(($counter["counter"]==1) and ($counter["value"]== $roomid["id"])){
	
 											
 						$tab[$i]['id']=$user['id'];
 						$tab[$i]['email']=$user['email'];
 						if ((!empty($user["firstName"])) || (!empty($user["lastName"])) )
 						$tab[$i]['name']=$user["firstName"]." ".$user["lastName"];
 						
 						
 						foreach($user["leaderboards"] as $leaderboard):
 							if (!empty($leaderboard)){		
 						if(!empty($leaderboard["position"])) 
 							$tab[$i]['position']=$leaderboard["position"];
 						if(empty($leaderboard["score"])) 	$tab[$i]['score']="0";
 						else $tab[$i]['score']=$leaderboard["score"];
							}
						endforeach;
 						$i++;	
 							}
				endforeach;
			
			endforeach; 
		
			return $tab;
	
			}
			
			
			
			
			public function create_array2($users){
		
			$tab2 = array();
			$i=0;
			foreach ($users as $user):
		
				
 					if(!empty($user["leaderboards"])){
	
 						foreach($user["leaderboards"] as $leaderboard):
 							if (!empty($leaderboard)){		
 								$tab2[$i]['id']=$user['id'];
 								$tab2[$i]['email']=$user['email'];
 								if ((!empty($user["firstName"])) || (!empty($user["lastName"])) )
 									$tab2[$i]['name']=$user["firstName"]." ".$user["lastName"];
 								$tab2[$i]['position']=$leaderboard["position"];
 								if(empty($leaderboard["score"])) 	$tab2[$i]['score']="0";
 								else $tab2[$i]['score']=$leaderboard["score"];

 								$i++;	
 								break;
 								}
 						endforeach;
 							}
				endforeach;
		
			return $tab2;
	
			}
			
			
			
			public function create_array3($users){
		
			$tab3 = array();
			$i=0;
			foreach ($users as $user):
		
									
 						$tab3[$i]['id']=$user['id'];
 						$tab3[$i]['email']=$user['email'];
 						if ((!empty($user["firstName"])) || (!empty($user["lastName"])) )
 						$tab3[$i]['name']=$user["firstName"]." ".$user["lastName"];
 						
 						foreach($user["leaderboards"] as $leaderboard):
 							if (!empty($leaderboard)){		
 						if(!empty($leaderboard["position"])) 
 							$tab3[$i]['position']=$leaderboard["position"];
 						else 
 							$tab3[$i]['position']="-";
 						if(empty($leaderboard["score"])) 	$tab3[$i]['score']="0";
 						else $tab3[$i]['score']=$leaderboard["score"];
							}
						endforeach;
 						
 					
 						$i++;	
 							
				endforeach;
			
			return $tab3;
	
			}
			
		
		
			public function guests_array($members, $data2){
			$guests=array();
			$ids=array();
			$i=0;

		foreach($data2 as $d):
				foreach ($members as $m):
				
				if($d['id'] == $m['id'])
					$ids[$i]= $m['id'];
					
			endforeach;
		endforeach;
		
		
		foreach($data2 as $d):
			if(!empty($ids)){
				foreach ($ids as $id):
				
				if(!($id == $d['id'])){
			
					$guests[$i]['name']=$d['name'];
					$guests[$i]['email']=$d['email'];
					$guests[$i]['score']=$d['score'];
				
				}
					
					
			endforeach;
				}
			else{
			
				$guests[$i]['name']=$d['name'];
					$guests[$i]['email']=$d['email'];
					$guests[$i]['score']=$d['score'];
			
			
			}
		endforeach;
	
	return $guests;
			
			}
			
			
	
	}


?>