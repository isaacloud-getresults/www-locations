<?php
/************************** display global statistics **********************************/

include ("./funkcje/statistics.php"); //include class Statistics

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

/*************************************************************************/

echo "<div id=\"newusers\" class=\"container\">";
echo "<h1><strong>".sizeof($res1)."</strong> <img src=\"../images/Users-icon.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."New users"."</h4>"; 
echo "</div><br>";

echo "<div class=\"container\" id=\"points\">";
echo "<h1><strong>".$data['points']."</strong> <img src=\"../images/points.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Points"."</h4>"; 
echo "</div><br>";

echo "<div class=\"container\" id=\"achievements\">";
echo "<h1><strong>".$data['achievements']."</strong> <img src=\"../images/achievement.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Achievements"."</h4>"; 
echo "</div><br>";


	if(!empty($visits)){
		foreach($visits as $visit): 
		
			echo "<div class=\"container\" id=\"room\">";
			echo "<h1><strong>".$visit['amount']."</strong> <img src=\"../images/visits.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>".$visit['room']." visits"."</h4>"; 
			echo "</div><br>";
	 	endforeach;
		} 

echo "<div class=\"container\" id=\"events\">";
echo "<h1><strong>".sizeof($res4)."</strong> <img src=\"../images/event.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Events"."</h4>"; 
echo "</div><br>";

?>


