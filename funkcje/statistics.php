<?php 
// create array with statistics data

	class Statistics{
	
		var $res1;
		var $resA;
		
		
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