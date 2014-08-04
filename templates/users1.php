
<center><h2><strong>My points :</strong></h2></center><br><br>
  		
  <p class="text-center"> You currently have 
  	 <?php if(empty($user["leaderboards"][$instanceConf['leaderboard']]["score"])) echo "0"; else echo $user["leaderboards"][$instanceConf['leaderboard']]["score"]; ?> points. </p>



