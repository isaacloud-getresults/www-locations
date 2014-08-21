<?php 
/********************* display all users in the restaurant *****************************/
include ("./funkcje/amount_users.php"); //include class Amount users
include ("./funkcje/leaderboard.php"); //include class Leaderboard

// check amount of users
$obiekt = new Amount_users;
$tab= $obiekt->amount($users, $roomid);

if($tab==0) 
	echo "<center>Empty</center>";
else{
	$obiekt2 = new Leaderboard;
	$data = $obiekt2-> create_array($users, $roomid);

?>


  <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        
 			
                        <th>Name</th>
                        <th style="text-align:right; ">Score</th>
                   
                    </tr>
                </thead>
                <tbody>


					<?php foreach ($data as $d): ?>
 						<tr>
							<td><?php if(empty($d["name"])) echo "<em>"."(".$d["email"].")"."</em>"; else echo $d["name"]; ?></td>
            				<td align="right"><span class="badge "><?php echo $d["score"];?></span></td>	
            			</tr>
               		
 					<?php endforeach; ?>


                </tbody>
		</table>
		
<?php } ?>