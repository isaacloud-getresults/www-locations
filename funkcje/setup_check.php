<?php 

	class Setup_check{
	
	var $data;
	var $loc;
	var $res2;
	
	public function check($data, $loc, $res2){
		foreach($data as $dat):
			if(($loc[0]==$dat["name"]) && ($loc[1]==$dat["nr"]))
				$con=  $dat["condition"];
		
		endforeach;

	 	foreach ($res2 as $condition):
	 	 			
	 	 	if($con == $condition["id"] )
	 	 		$c_id=$con;
	 	 				
	 	endforeach;
	 	
	 	return $c_id;


	
			}
		}

?>