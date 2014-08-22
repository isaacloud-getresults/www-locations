<h2><center><strong>Timeline</strong></center></h2><br>

<?php 
	date_default_timezone_set('Europe/Warsaw'); //set the timezone
	include ("./funkcje/time_ago.php"); //include class Time_ago


/******************************* build  array ******************************************/
	if(empty($data))
		echo "<p><center>Empty</center></p>";
	else{
	$k=0;
	$feed= array();
	// create array with data
	foreach ($data as $d):
	
				$mil = $d["updatedAt"];
				$seconds = ($mil / 1000)-950;   // diff between 
				$prevtime = date("d-m-Y H:i:s", $seconds);
				$time=$d["updatedAt"]/1000;
				$obiekt= new Time_ago;
				
				$feed[$k]["ago"]=$obiekt->ago($time);
				$feed[$k]["message"]=$d["data"]["body"]["message"];
				$feed[$k]["time"]=$prevtime;
					
				$k++;
		
	
	endforeach; 

?>

<div style="width: 750px; height: 400px; overflow: scroll;">
 <table class="table table-striped">


<?php
///////////////////////// display data /////////////////////////////////////////////////

foreach($feed as $f):

echo "<tr><td>";
echo "<p style=\"text-align:right\">".$f["ago"]."</p>";
echo "<p><span class=\"glyphicon glyphicon-user\"></span>"." "."You've"." ".$f["message"]; 
echo "<br>";
echo $f["time"]."</p></td></tr>";

endforeach;

?>
 </table>
</div>
<?php } ?>
 
            
