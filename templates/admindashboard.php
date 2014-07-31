<h1><strong>Statistics</strong></h1>	
	
	
	
	<?php



echo sizeof($res1) . " users";
echo "</br>";

$points=0;
 $achievements = 0;
  $kitchen = 0;
for ($i=0;$i<sizeof($res1);$i++)
{
$points=$points+ $res1[$i]['leaderboards'][1]['score'];
$achievements=$achievements+ sizeof($res1[$i]['gainedAchievements']);
if (!empty($res1[$i]['counterValues'][0]['value']))
{$kitchen=$kitchen+ $res1[$i]['counterValues'][0]['value'];}

}



echo $points . " points";
echo "</br>";
echo $achievements . " achievements";
echo "</br>";
echo $kitchen . " kitchen visits";
echo "</br>";



//var_dump($res3);

echo sizeof($res3) . " notifications";
echo "</br>";


//var_dump($res4);

echo sizeof($res4) . " events";
echo "</br>";







?>