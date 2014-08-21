<?php 

	class Setup_data{
	
		var $games;
		var $groups;
		
		public function create_data($games, $groups){
		
			$dane= array();
			
			foreach($games as $game): 
				$size_g=sizeof($game["segments"]);
				if(!empty($game["segments"])) {
					 for($i=0; $i<$size_g ; $i++){
						foreach($groups as $group):
							$size_gr=sizeof($group["segments"]);
				 				for($k=0; $k<$size_gr ; $k++){
									if( $game["segments"][$i]== $group["segments"][$k]) {
										$size_con= sizeof($game["conditions"]);
											for($l=0; $l<$size_con; $l++){
												$nr=$l+1;
												echo "<option>". $group["label"] ." ".$nr."</option>";
												$dane[$l]["name"]=$group["label"];
												$dane[$l]["nr"]=$nr;
												$dane[$l]["condition"]=$game["conditions"][$l];
												}
										}
									}
						endforeach;
							}
						}
			endforeach;
			
			return $dane;
		
		
		
			}
	
	
	}


?>