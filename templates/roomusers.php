<center><h2><strong>List of all users</strong></h2></center><br><br>


	
<?php 
$size=0;
foreach ($users as $user):
	foreach($user['counterValues'] as $counter):
 		if(($counter["counter"]==1) and ($counter["value"]== $roomid["id"])) $size++;
 	endforeach;
endforeach; 				
 				
if($size==0) echo "<center>Empty</center>";
else {

?>

<table class="table table-hover">
                <thead>
                    <tr>
                        
 						<th>Email</th>
                        <th>Name</th>
                        <th>Score</th>
                   
                    </tr>
                </thead>
                <tbody>


	<?php 
		foreach ($users as $user):
			foreach($user['counterValues'] as $counter):
 				if(($counter["counter"]==1) and ($counter["value"]== $roomid["id"])){
?>
 			<tr>

 				<td><a href="./users/<?php echo $user["id"];?>"><?php  echo $user["email"];?></a></td>
            		<td><?php if((empty($user["firstName"]))||(empty($user["lastName"]))) echo "----------"; 
            			else echo $user["firstName"]." ".$user["lastName"]; ?></td>
            	<td><?php if(empty($user["leaderboards"][1]["score"])) echo "0"; else echo $user["leaderboards"][1]["score"];?></td>	
            			
            </tr>
 	<?php 
 	
 		
 	}
			endforeach;
		endforeach; 

?>


                </tbody>
		</table>
		<?php } ?>