<h2><center><strong>Timeline</strong></center></h2><br>

<?php 
date_default_timezone_set('Europe/Warsaw'); //set the timezone
include ("./funkcje/feed.php"); //include class Feed


/******************************* build  array ******************************************/
	if(empty($data))
		echo "<p><center>Empty</center></p>";
	else{
	
	$obj= new Feed;
	$feed = $obj->build_history($data);
 

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