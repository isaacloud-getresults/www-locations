<?php
//amount of users in x room
	class Amount_users{
	
		var $users;
		var $roomid;
	
		public function amount($users, $roomid){
			$tab = 0;
		
			foreach ($users as $user):
				$sz=sizeof($user["counterValues"]);
					if($sz!=0){
						foreach ($user["counterValues"] as $count):
							if(($count['value']==$roomid["id"]) && ($count['counter']==1)) $tab++;
						endforeach;
						}
			endforeach;
		
			return $tab;
	
			}
		
	}


?>