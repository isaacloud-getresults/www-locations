<?php 
/************************* display all users in selected room **************************/
include ("./funkcje/leaderboard.php"); //include class Leaderboard

echo "<center><h2><strong>List of all users</strong></h2></center><br><br>";

//Amount_users class is included in currentroom.php
$obiekt = new Amount_users;
$size= $obiekt->amount($users, $roomid); //check the number of users in x room
 				
if($size==0) 
	echo "<center>Empty</center>";
else {

$obiekt2= new Leaderboard;
$tab = $obiekt2->create_array($users, $roomid); //create leaderboard data

?>

		<table class="table table-hover">
                <thead>
                    <tr>
                        
 						<th>Email</th>
                        <th>Name</th>
                    
                   
                    </tr>
                </thead>
                <tbody>

					<?php foreach ($tab as $t): ?>

 						<tr>
							<td><a href="./users/<?php echo $t["id"];?>"><?php  echo $t["email"];?></a></td>
            				<td><?php if(empty($t["name"])) echo "----------"; else echo $t["name"]; ?></td>
            	
           				</tr>
 					<?php endforeach; ?>


                </tbody>
		</table>
		
<?php } ?>






