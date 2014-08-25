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
 						if(!empty($user["leaderboards"][1]["position"])) 
 							$tab[$i]['position']=$user["leaderboards"][1]["position"];
 						if(empty($user["leaderboards"][1]["score"])) 	$tab[$i]['score']="0";
 						else $tab[$i]['score']=$user["leaderboards"][1]["score"];

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
 						if(empty($user["leaderboards"][1]["position"])) 	$tab3[$i]['position']="-";
 						else $tab3[$i]['position']=$user["leaderboards"][1]["position"];
 					
 						if(empty($user["leaderboards"][1]["score"])) 	$tab3[$i]['score']="0";
 						else $tab3[$i]['score']=$user["leaderboards"][1]["score"];

 						$i++;	
 							
				endforeach;
			
			return $tab3;
	
			}
			
		
		
			public function guests_array($members, $data2){
			$guests=array();
			$i=0;
	echo sizeof($data2);

		
		foreach($data2 as $d):
				foreach ($members as $m):
				if($d['id']==$m['id']) echo "tak";
				else echo "nie";
			endforeach;
		endforeach;
	
			
			}
			
			
	
	}


?>