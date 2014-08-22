<?php
/************************** display global statistics **********************************/

include ("./funkcje/statistics.php"); //include class Statistics

$obiekt= new Statistics;
$data= $obiekt->create_statistic($res1);

$obiekt1= new Statistics;
$visits= $obiekt1->amount_of_visits($resA);

/*************************************************************************/

echo "<div id=\"newusers\" class=\"container\">";
echo "<h1><strong>".sizeof($res1)."</strong> <img src=\"../images/Users-icon.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."New users"."</h4>"; 
echo "</div><br>";

echo "<div id=\"rooms_amount\" class=\"container\">";
echo "<h1><strong>".sizeof($resA)."</strong> <img src=\"../images/rooms.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Rooms"."</h4>"; 
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
			echo "<h1><strong>".$visit['amount']."</strong> <img src=\"../images/visits.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>".$visit['label']." visits"."</h4>"; 
			echo "</div><br>";
	 	endforeach;
		} 


?>


