<?php 
/************************** display user profile *************************************/

include ("./funkcje/profile.php"); //include class Profile

$obiekt  = new Profile;
$data = $obiekt->profile_data($users);

echo "<h2><center><strong>Profile:</strong></center></h2><br>";
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
	<button type="button" class="btn btn-primary btn-lg" >
		<span class="glyphicon glyphicon-list-alt"></span>
		<a href="./leaderboard"><font color="white">Leaderboard</font></a>
	</button>
</center>

  
