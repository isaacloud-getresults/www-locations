<?php 

	class Setup_check{
	
	var $data;
	var $res2;
	var $loc;
	
	public function check($data, $loc, $res2){
		$c_id=array();
		if (!empty($data) && !empty($loc) && !empty($res2)){

	 		$c_id=array();
	 		$i=0;
	 			
	 			foreach ($data as $d):
	 				
	 				if ($loc==$d['name']){
	 				
	 					foreach($d['segments'] as $segment):
	 					
	 						foreach ($res2 as $r):

								if($r['id']== $segment['condition']){
								
									$c_id[$i]['id']=$r['id'];
									$c_id[$i]['name']=$r['name'];
									$i++;
								
								}
							
							endforeach;
								 					
	 					endforeach;
	 			}
	 			endforeach;
	 		
	 	return $c_id;


	
			}
		}
		}

?>