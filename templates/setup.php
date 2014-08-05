<?php 
  
  	if(isset($_SESSION["dane"]))
  		$_SESSION["dane"]= array();
  		
  ?> 			

<h2>SetUp beacons</h2>
</br></br>
<form method="POST" action="./setup">

Beacon 1 UID: <input type="text" name="beacon1" size="50"></textarea>
<?php echo "   "; ?>
Location: <select name="location">
<option>--Select location--</option>

<?php  
$dane= array();
	foreach($games as $game): 
	$size_g=sizeof($game["segments"]);
		if(!empty($game["segments"])) {
		 for($i=0; $i<$size_g ; $i++){
			foreach($groups as $group):
			$size_gr=sizeof($group["segments"]);
				 for($k=0; $k<$size_gr ; $k++){
					if( $game["segments"][$i]== $group["segments"][$k]) {
						$size_con= sizeof($game["conditions"]);
							for($l=0; $l<$size_con; $l++){
							$nr=$l+1;
				echo "<option>". $group["label"] ." ".$nr."</option>";
							$dane[$l]["name"]=$group["label"];
							$dane[$l]["nr"]=$nr;
							$dane[$l]["condition"]=$game["conditions"][$l];
							}
						}
					}
			endforeach;
			}
		}
	endforeach;

?>


</select><br>


<br><br>	

 <center><button type= "submit" name="ok" value="ok" class="btn btn-primary btn-lg"><font color="white">Go to IsaaCloud</font></a></button><br><br>	</center>
         
 
</form>

<?php 
$_SESSION["dane"] = $dane;
//print_r($_SESSION["dane"]); 
?>