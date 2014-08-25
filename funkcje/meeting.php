<?php 

	class Meeting{

		var $url;
		var $data= array();
		
	
	
		public function create_data($url){
			$inf= array();
			$headers = @get_headers($url);
			if(strpos($headers[0], '200') !== false){
		
				$homepage = file_get_contents($url);
				$tablica= explode(";", $homepage);
				$t=array();
					for ($i=0; $i<sizeof($tablica); $i++){
						if($t[$i]=explode(",",$tablica[$i])) { 
								if(isset($t[$i][0]) && $t[$i][0] != null){
									$inf[$i]['id']=$t[$i][0];
								 

								if(isset($t[$i][1]))
									$inf[$i]['status']=$t[$i][1];
	
								if(isset($t[$i][2]))
									$inf[$i]['confirm']=$t[$i][2];
										}
	    							}

								}
					}
					return $inf;
					
					}

		public function create_leaderboard($inf, $data){
				$arr= array();
				$i=0;
					foreach ($data as $d):
					
							foreach ($inf as $in):
							 
									if ($d['id']==$in['id'] ){
							
										if(empty($d["name"])) 
											$arr[$i]['name']= "<em>"."(".$d["email"].")"."</em>"; 
										else 
											$arr[$i]['name']= $d['name'];
										$arr[$i]['confirm']=$in['confirm'];
										$arr[$i]['status']=$in['status'];
										$arr[$i]['score']=$d['score'];
										$arr[$i]['id']= $in['id'];
										$i++;
										
										} 
							endforeach;
							
 					 endforeach;
 					 
				return $arr;
			}

		}


?>