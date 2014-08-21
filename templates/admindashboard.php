<?php
/************************* display statistics *****************************************/

include ("./funkcje/statistics.php"); //include class Statistics

echo "<h1><strong>Statistics</strong></h1>";

$obiekt= new Statistics;
$data= $obiekt->create_statistic($res1);

$obiekt2= new Statistics;
$rooms= $obiekt2->rooms_array($resA);

$obiekt3= new Statistics;
$games= $obiekt3->games_array($resG);

$obiekt4= new Statistics;
$users= $obiekt4->users_array($res1);

$obiekt5= new Statistics;
$visits= $obiekt5->visits_amount($rooms, $games, $users);


	
echo "<h4>".sizeof($res1)." Users"."</h4>";
echo "<h4>".$data['points']." Points"."</h4>";
echo "<h4>".$data['achievements']." Achievements"."</h4>";

//display  rooms visits	
	if(!empty($visits)){
		foreach($visits as $visit):
			echo "<h4>".$visit['amount']." ".$visit['room']." visits"."</h4>";
		endforeach;
	}

echo "<h4>".sizeof($res4)." Events"."</h4>";

?>
