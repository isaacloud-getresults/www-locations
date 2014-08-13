
<center><h2><strong>Leaderboard</strong></h2></center><br><br>

<?php if(sizeof($users)==0) echo "<center>"."Empty"."</center>"; 
		else { ?>
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
                
                    <?php foreach ($users as $user): ?>
                    <?php if(!empty($user["leaderboards"]["1"]["position"])){ ?>
                        <tr >
                            <td><?php echo $user["leaderboards"][1]["position"]; ?></td>
                            	<td><a href="./users/<?php echo $user["id"];?>"><?php echo $user["email"]; ?></a></td>
                        		 <td><?php 
                            			if((empty($user["firstName"]))||(empty($user["lastName"]))) echo "-------------";
                            			else echo $user["firstName"]." ".$user["lastName"]; ?></td>
                           
                            <td><?php echo $user["leaderboards"][1]["score"]; ?></td>
            
                           
                        </tr> <?php } ?>
                    <?php endforeach; ?>
                </tbody>
		</table>
 
<?php } ?>

