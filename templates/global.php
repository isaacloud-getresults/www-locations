<div class="container" style="	background: radial-gradient(#FF3399,#FF99CC);
								text-align: center;
								width:350px; 
								border-style:groove;
								border-radius: 10px;
								color:white;
								text-shadow: 3px 3px 5px black">
	<?php

	echo "<h1><strong>".sizeof($res1)."</strong> <img src=\"../Users-icon.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."New users"."</h4>"; ?>
</div><br>

	<?php
$points=0;
 $achievements = 0;
  $kitchen = 0;
for ($i=0;$i<sizeof($res1);$i++)
{
if (!empty($res1[$i]['leaderboards'][1]['score']))
{$points=$points+ $res1[$i]['leaderboards'][1]['score'];}
if (!empty($res1[$i]['gainedAchievements']))
{$achievements=$achievements+ sizeof($res1[$i]['gainedAchievements']);}
//if (!empty($res1[$i]['counterValues'][0]['value']))
//{$kitchen=$kitchen+ $res1[$i]['counterValues'][0]['value'];}   //na razie nie dziala

}


?>
<div class="container" style="	background: radial-gradient(#66CC66,#99FF99);
								text-align: center;
								width:350px; 
								border-style:groove;
								border-radius: 10px;
								color:white;
								text-shadow: 3px 3px 5px black">
	<?php

	echo "<h1><strong>".$points."</strong> <img src=\"../points.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Points"."</h4>"; ?>
</div><br>

<div class="container" style="	background: radial-gradient(#FF6600,#FFCC33);
								text-align: center;
								width:350px; 
								border-style:groove;
								border-radius: 10px;
								color:white;
								text-shadow: 3px 3px 5px black">
	<?php

	echo "<h1><strong>".$achievements."</strong> <img src=\"../achievement.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Achievements"."</h4>"; ?>
</div><br>


<div class="container" style="	background: radial-gradient(#9966FF ,#9999FF);
								text-align: center;
								width:350px; 
								border-style:groove;
								border-radius: 10px;
								color:white;
								text-shadow: 3px 3px 5px black">
	<?php

	echo "<h1><strong>".$kitchen."</strong> <img src=\"../visits.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Kitchen visits"."</h4>"; ?>
</div><br>


<div class="container" style="	background: radial-gradient(#0066FF,#66CCFF);
								text-align: center;
								width:350px; 
								border-style:groove;
								border-radius: 10px;
								color:white;
								text-shadow: 3px 3px 5px black">
	<?php

	echo "<h1><strong>".sizeof($res3)."</strong> <img src=\"../notification.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Notifications"."</h4>"; ?>
</div><br>

<div class="container" style="	background: radial-gradient(#FF0099,#FF6699);
								text-align: center;
								width:350px; 
								border-style:groove;
								border-radius: 10px;
								color:white;
								text-shadow: 3px 3px 5px black">
	<?php

	echo "<h1><strong>".sizeof($res4)."</strong> <img src=\"../event.png\" height=\"60px\" width=\"90px\" align=\"right\"></h1>"."<h4>"."Events"."</h4>"; ?>
</div><br>


