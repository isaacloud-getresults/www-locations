<?php 

$s= sizeof($users);
if($s==0) echo "<center>Empty</center>";
else {

?>





  <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        
 			
                        <th>Name</th>
                        <th style="text-align:right; ">Score</th>
                   
                    </tr>
                </thead>
                <tbody>


					<?php 
					foreach ($users as $user):
						$size=sizeof($user["counterValues"]);
						for($i=0;$i<$size;$i++){
 							if(($user["counterValues"][$i]["counter"]==$instanceConf['counterid']) and ($user["counterValues"][$i]["value"]== $roomid["id"]) ){
 							
 					 ?>
 					<tr>

 				
            			<td><?php if((empty($user["firstName"]))||(empty($user["lastName"]))) echo "<em>"."(".$user["email"].")"."</em>"; 
            				else echo $user["firstName"]." ".$user["lastName"]; ?></td>
            			<td align="right">
            			<span class="badge ">
            			<?php if(empty($user["leaderboards"][$instanceConf['leaderboard']]["score"])) echo "0"; else echo $user["leaderboards"][$instanceConf['leaderboard']]["score"];?></span>
            			</td>	
            			
               		</tr>
 				<?php 
 	
 			
 						}
					}
					endforeach; 

				?>


                </tbody>
		</table>
		<?php 
			} 
		?>