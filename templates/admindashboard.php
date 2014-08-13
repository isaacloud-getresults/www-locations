<h1><strong>Statistics</strong></h1>	
	
	

	<?php



echo "<h4>".sizeof($res1)." users"."</h4>";


$points=0;
 $achievements = 0;
  $kitchen = 0;
for ($i=0;$i<sizeof($res1);$i++)
{
if (!empty($res1[$i]['leaderboards'][1]['score']))
{$points=$points+ $res1[$i]['leaderboards'][1]['score'];}
$achievements=$achievements+ sizeof($res1[$i]['gainedAchievements']);
//if (!empty($res1[$i]['counterValues'][0]['value']))
//{$kitchen=$kitchen+ $res1[$i]['counterValues'][0]['value'];}   //na razie nie dziala

}


echo "<h4>".$points." points"."</h4>";
echo "<h4>".$achievements." achievements"."</h4>";
//echo "<h4>".$kitchen." kitchen visits"."</h4>";
echo "<h4>".sizeof($res3)." notifications"."</h4>";
echo "<h4>".sizeof($res4)." events"."</h4>";

?>