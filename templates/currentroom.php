<center><h2><strong>Number of users :</strong></h2></center> <br><br>

   
<p class="text-center"> Currently in the <?php echo $roomid["label"]." "; ?> there are 
	 
	
	
<?php 
$size=0;
foreach ($users as $user):
	foreach($user['counterValues'] as $counter):
 		if(($counter["counter"]==1) and ($counter["value"]== $roomid["id"])) $size++;
 	endforeach;
endforeach;
if($size==0) echo "0"; else echo $size;

?> users. </p>