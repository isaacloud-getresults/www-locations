<?php 
/****************************** display user's score ***********************************/
include ("./funkcje/profile.php"); //include class Profile

$obiekt  = new Profile;
$data = $obiekt->profile_data($user);

echo "<center><h2><strong>My points :</strong></h2></center><br><br>";
  		
echo "<p class=\"text-center\"> You currently have ".$data["score"]." points. </p>";


?>



