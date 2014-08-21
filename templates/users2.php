<?php 
/*************************** display leaderboard ***************************************/

include ("./funkcje/leaderboard.php"); //include class Leaderboard

echo "<center><h2><strong>Leaderboard</strong></h2></center><br><br>";

// amount of users in leaderboard
if(sizeof($users)==0) echo "<center>"."Empty"."</center>"; //no users

else { 
	$obiekt2 = new Leaderboard;
	$data= $obiekt2-> create_array2($users); ?>
		
     <table class="table table-bordered">
                <thead>
                    <tr>
                     <th>Position</th>
                        <th>Email</th>
                        <th>Name</th>
                      
                        <th>Score</th>
                    
                        
                    </tr>
                </thead>
                <tbody>
                
                    <?php foreach ($data as $d): ?>
                  
                        <tr >
                            <td><?php echo $d["position"]; ?></td>
                            <td><a href="./users/<?php echo $d["id"];?>"><?php echo $d["email"]; ?></a></td>
                        	<td><?php 
                            		if(empty($d["name"])) echo "-------------";
                            		else echo $d["name"]; ?></td>
                           
                            <td><?php echo $d["score"]; ?></td>
                        </tr>
                        
                    <?php endforeach; ?>
                </tbody>
		</table>
 
<?php } ?>

