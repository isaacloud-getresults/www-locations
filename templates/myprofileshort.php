<?php 
/****************************** display my profile **************************************/

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
 	<a href="./details"><button type="button" class="btn btn-link">
        <span class="glyphicon glyphicon-list"></span> Details
        
    </button></a> <br><br>

	<a href="./leaderboard"><button type="button" class="btn btn-primary btn-lg" >
		<span class="glyphicon glyphicon-list-alt"></span>
		<font color="white">Leaderboard</font>
	</button></a>
</center>                         
       
