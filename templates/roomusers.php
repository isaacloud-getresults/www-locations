
<center><h2><strong>List of all users</strong></h2></center><br><br>


	
<?php 

 $size= sizeof($users);
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
			$size=sizeof($user["counterValues"]);
			for($i=0;$i<$size;$i++){
 				if(($user["counterValues"][$i]["counter"]==6) and ($user["counterValues"][$i]["value"]== $roomid["id"])){
 	?>
 			<tr>

 				<td><a href="./users/<?php echo $user["id"];?>"><?php  echo $user["email"];?></a></td>
            		<td><?php if((empty($user["firstName"]))||(empty($user["lastName"]))) echo "----------"; 
            			else echo $user["firstName"]." ".$user["lastName"]; ?></td>
            	<td><?php if(empty($user["leaderboards"][1]["score"])) echo "0"; else echo $user["leaderboards"][1]["score"];?></td>	
            			
            </tr>
 	<?php 
 	
 		
 	}
}
endforeach; 

?>


                </tbody>
		</table>
		<?php } ?>






