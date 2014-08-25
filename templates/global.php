<?php
/************************** display global statistics **********************************/

include ("./funkcje/statistics.php"); //include class Statistics

$obiekt= new Statistics;
$data= $obiekt->create_statistic($res1);

$obiekt1= new Statistics;
$visits= $obiekt1->amount_of_visits($resA);

/*************************************************************************/

echo "<div id=\"newusers\" class=\"container\">";
echo "<h3><strong>".sizeof($res1)."</strong> <img src=\"../images/Users-icon.png\" height=\"40px\" width=\"50px\" align=\"right\">"."New users"."</h3>"; 
echo "<br></div><br>";

echo "<div id=\"rooms_amount\" class=\"container\">";
echo "<h3><strong>".sizeof($resA)."</strong> <img src=\"../images/rooms.png\" height=\"40px\" width=\"50px\" align=\"right\">"."Rooms"."</h3>"; 
echo "<br></div><br>";

echo "<div class=\"container\" id=\"points\">";
echo "<h3><strong>".$data['points']."</strong> <img src=\"../images/points.png\" height=\"40px\" width=\"50px\" align=\"right\">"."Points"."</h3>"; 
echo "<br></div><br>";

echo "<div class=\"container\" id=\"achievements\">";
echo "<h3><strong>".$data['achievements']."</strong> <img src=\"../images/achievement.png\" height=\"40px\" width=\"50px\" align=\"right\">"."Achievements"."</h3>"; 
echo "<br></div><br>";


	if(!empty($visits)){
	
		foreach($visits as $visit): 
		
			echo "<div class=\"container\" id=\"room\">";
			echo "<h3><strong>".$visit['amount']."</strong> <img src=\"../images/visits.png\" height=\"40px\" width=\"50px\" align=\"right\">".$visit['label']." visits"."</h3>"; 
			echo "<br></div><br>";
	 	endforeach;
		} 


?>


