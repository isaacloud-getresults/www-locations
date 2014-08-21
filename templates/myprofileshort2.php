<?php 
/****************** display my profile (without detail's button) *******************/

include ("./funkcje/profile.php"); //include class Profile

$obiekt  = new Profile;
$data = $obiekt->profile_data($myprofile);

echo "<h2><center><strong>My profile</strong></center></h2><br>";
?>
         

           
                   	<dl class="dl-horizontal">
  						<dt>First name:</dt>
  						<dd><?php echo $data["firstName"]; ?></dd>
  						
  						<dt>Last name:</dt>
  						<dd><?php echo $data["lastName"]; ?></dd>
  						
  						<dt>Score:</dt>
  						<dd><?php echo $data["score"]; ?></dd>
  						
  						<dt>Position:</dt>
  						<dd><?php echo $data["position"]; ?></dd>
  						
  						
					</dl> <br><br>   

<center>
	<a href="./leaderboard"><button type="button" class="btn btn-primary btn-lg" >
		<span class="glyphicon glyphicon-list-alt"></span>
		<font color="white">Leaderboard</font>
	</button></a>
</center>      