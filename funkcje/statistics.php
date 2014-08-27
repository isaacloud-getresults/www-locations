<?php 
// create array with statistics data

	class Statistics{
	
		var $res1;
		var $resA;
		
		
		public function create_statistic($res1){
			$points=0;
 			$achievements = 0;
  			$arr= array();
  			
			foreach ($res1 as $res):
				if (!empty($res['leaderboards'])){
						foreach($res['leaderboards'] as $leadb):
						if (!empty($leadb['score'])){
							$points=$points+ $leadb['score'];
							}
						endforeach;
					}
				$achievements=$achievements+ sizeof($res['gainedAchievements']);
			
			endforeach;
			$arr['points']=$points;
			$arr['achievements']=$achievements;
		
			
				return $arr;
	
			}
			
		public function amount_of_visits($resA){
			$array= array();
			$i=0;
			foreach ($resA as $r):

				if (!empty($r['counterValues'] )){
					foreach ($r['counterValues'] as $counter):
						if(!empty($counter['value'])){
						$array[$i]['label']=$r['label'];
						$array[$i]['amount']=$counter['value'];
						$i++;
						break;
						}
					endforeach;
					}
			endforeach;
			return $array;
			}
		}

?>