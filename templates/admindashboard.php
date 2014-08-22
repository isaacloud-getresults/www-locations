<?php
/************************* display statistics *****************************************/

include ("./funkcje/statistics.php"); //include class Statistics

echo "<h1><strong>Statistics</strong></h1>";

$obiekt= new Statistics;
$data= $obiekt->create_statistic($res1);

$obiekt1= new Statistics;
$data2= $obiekt1->amount_of_visits($resA);

	
echo "<h4>".sizeof($res1)." Users"."</h4>";
echo "<h4>".sizeof($resA)." Rooms"."</h4>";
echo "<h4>".$data['points']." Points"."</h4>";
echo "<h4>".$data['achievements']." Achievements"."</h4>";
if (!empty($data2)){
foreach ($data2 as $d):
		echo "<h4>".$d['amount']." ".$d['label']."</h4>";
endforeach;
}

//echo "<h4>".sizeof($res4)." Events"."</h4>";

?>
