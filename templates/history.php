
<center><h2><strong>List of Achievements</strong></h2></center><br><br>

	<?php
                            
             $size=sizeof($history["gainedAchievements"]);
            	for($i=0;$i<$size;$i++){
                        $ids[$i] = $history["gainedAchievements"][$i];
                    } 
                    
                    
 	?>
           
           
       <?php  if($size==0) echo "<center>"."Empty"."</center>"; 
       
       			else{ ?>    
           
           
           
            <table class="table table-striped">
                <thead>
                    <tr>
                    
                      
                        <th>Achievement</th>
                       <th>Amount</th> </tr>
                       
                 </thead>
                <tbody>
                    		
                    		<?php
                    		for ($i=0;$i<$size; $i++){
                    			foreach ($achievements as $achievement):
                    				if ($achievement["id"]==$ids[$i]["achievement"]) { ?>
                    					<tr><td><?php echo $achievement["label"]; ?> </td>
                    					<td><?php echo $ids[$i]["amount"]; ?> </td>
                    			 </tr> <?php 
                    			}
                    	endforeach;
                    	} 
                    		
                    		
                    		
                    		?>
                        
    
                </tbody>
            </table>
            
            <?php }  ?>
            
