<?php 
// build array with feed data
include ("./funkcje/time_ago.php"); //include class Time_ago

class Feed{

	var $data;
	var $person;
	
	public function build_array($data, $person){
		$ss=sizeof($data);
		$k=0;
		$feed= array();

		// create array with data
		foreach ($data as $d):
	
			foreach ($person as $p):
	
				if($d["subjectId"]==$p["id"]){
	
					$mil = $d["updatedAt"];
					$seconds = ($mil / 1000);
					$prevtime = date("d-m-Y H:i:s", $seconds);
					$time=$d["updatedAt"]/1000;
				
					$obiekt= new Time_ago;
					$feed[$k]["ago"]=$obiekt->ago($time);
					
						if(empty ($p["firstName"]) || empty($p["lastName"]))
							$feed[$k]["name"]= "Unknown user";
						else
						
					$feed[$k]["name"]=$p["firstName"]." ".$p["lastName"];
					$feed[$k]["message"]=$d["data"]["body"]["message"];
					$feed[$k]["time"]=$prevtime;
					
					$k++;
				}
			endforeach;
	
		endforeach; 
		
		return $feed;
		}
		
		
		
		public function build_history($data){
				$k=0;
				$feed= array();
				// create array with data
			foreach ($data as $d):
	
				$mil = $d["updatedAt"];
				$seconds = ($mil / 1000) ;  // diff between 
				$prevtime = date("d-m-Y H:i:s", $seconds);
				$time=$d["updatedAt"]/1000;
				$obiekt= new Time_ago;
				
				$feed[$k]["ago"]=$obiekt->ago($time);
				$feed[$k]["message"]=$d["data"]["body"]["message"];
				$feed[$k]["time"]=$prevtime;
					
				$k++;
		
	
			endforeach;
		
		return $feed;
		
		}
		
	}

?>