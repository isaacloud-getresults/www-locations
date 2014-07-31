
<center><h2><strong>Number of users :</strong></h2></center> <br><br>

   
<p class="text-center"> Currently in the <?php echo $roomid["label"]." "; ?> there are 
	 
	
	
<?php 
 $size= sizeof($userscount);
if($size==0) echo "0"; else echo $size;

?> users. </p>