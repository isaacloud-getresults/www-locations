<?php 

	class Setup_data{
	
		var $games;
		var $groups;
		
		public function create_data($games, $groups){
		
			$place= array();
			
			$i=0;
			$k=0;
			foreach ($groups as $g):
				if(!empty($g['segments'])){
					foreach ($games as $ga):
						if(!empty($ga['segments']) && !empty($ga['conditions'])){
						foreach ($g['segments'] as $segment):
							if($segment == $ga['segments'][0]){
								$place[$i]['name'] = $g['label'];
								$place[$i]['id_r'] = $g['id'];
								$place[$i]['segments'][$k]['id']=$segment;
								$place[$i]['segments'][$k]['condition']=$ga['conditions'][0];
								$k++;
							
								}
						endforeach;
						}
					endforeach;
					$i++;}
			
			endforeach;
			
			return $place;
		
		
			}
	
	
	
		public function data_to_save($beacon_id, $c_id){
		
			$save = array();
			foreach ($c_id as $cd):
				if(strpos($cd['name'], 'exit') == true){
				
					$save[1]['id']= $cd['id'];
					$save[1]['beacon']= $beacon_id.".exit";	
					}
					
				elseif (strpos($cd['name'], 'group') == true){
				
					$save[2]['id']= $cd['id'];
					$save[2]['beacon']= $beacon_id.".group";
					}
					
				else {
				
					$save[0]['id']= $cd['id'];
					$save[0]['beacon']= $beacon_id;
					}
		
			endforeach;
			
			
			return $save;
		
		}
	
	}


?>