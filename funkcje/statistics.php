<?php 
// create array with statistics data

	class Statistics{
	
		var $res1;
		var $resA;
		var $resG;
		
		public function create_statistic($res1){
			$points=0;
 			$achievements = 0;
  			$arr= array();
  			
			for ($i=0;$i<sizeof($res1);$i++){
				if (!empty($res1[$i]['leaderboards'][1]['score']))
					$points=$points+ $res1[$i]['leaderboards'][1]['score'];
				$achievements=$achievements+ sizeof($res1[$i]['gainedAchievements']);
			

				}
			$arr['points']=$points;
			$arr['achievements']=$achievements;
		
			
				return $arr;
	
			}
			
			
		// rooms array: labels, segments, ids
		public function rooms_array($resA){
		
			$rooms= array();
			$i=0;
			foreach ($resA as $ra):

				if(!empty($ra['segments'])){
					$rooms[$i]['label']=$ra['label'];
					$rooms[$i]['segments']=$ra['segments'][0];
					$rooms[$i]['id']=$ra['id'];
					$i++;
					}	
			endforeach;
		
		return $rooms;
		
			}
			
			
		//games array:ids and segments
	
		public function games_array($resG){
		
			$games= array();
			$i=0;
			foreach ($resG as $rg):

				if(!empty($rg['segments'])){
					$games[$i]['segments']=$rg['segments'][0];
					$games[$i]['id']=$rg['id'];
					$i++;
					}	
			endforeach;
			
			return $games;
			}
			
			
		//users array:ids and wonGames

		public function users_array($res1){

			$users= array();
			$i=0;

			foreach ($res1 as $ru):

				if(!empty($ru['wonGames'])){
					$users[$i]['id']=$ru['id'];
					$k=0;
					foreach ($ru['wonGames'] as $won):
						$users[$i]['games'][$k]['id']=$won['game'];
						$users[$i]['games'][$k]['amount']=$won['amount'];
						$k++;
					endforeach;
				$i++;
				}

			endforeach;
			return $users;
				}
				
			
			
			// for every room 
			
			public function visits_amount($rooms, $games, $users){
				$visits = array();
				if (!empty($rooms) && !empty($games) && !empty($users)){
					$i=0;

					foreach ($rooms as $room):

						//compare room and game segment
						$game_id=0;
						foreach ($games as $game):

							if($game['segments']==$room['segments'])
								$game_id=$game['id'];
		
						endforeach;
						// check wonGames id; get amount
	
						if(!$game_id==0){
							$amount= array();
							$j=0;
							foreach ($users as $user):
	
								foreach ($user['games'] as $ugame):
		
									if($ugame['id']==$game_id){
										$amount[$j]=$ugame['amount'];
										$j++;
											}
		
								endforeach;
			
							endforeach;	
								if(!empty($amount)){
									$sum=0;
									foreach ($amount as $a):
			
										$sum+=$a;
			
									endforeach;
		
		
									$visits[$i]['room']=$room['label'];
									$visits[$i]['amount']=$sum;
									$i++;
									}
						}		
					endforeach;
						
								if(!empty($visits))
									return $visits;
						}
					}
				}

?>