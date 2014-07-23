
<center><h2><strong>List of all users</strong></h2></center><br><br>

	<?php if(sizeof($users)==0) echo "<center>"."Empty"."</center>"; 
		else { ?>
		<table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
 						<th>Email</th>
                        <th>Name</th>
                        
                   
                    </tr>
                </thead>
                <tbody>
                
                  
<?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user["id"];?></td>
            		<td><a href="./users/<?php echo $user["id"];?>"><?php echo $user["email"];?></a></td>
            		<td><?php if((empty($user["firstName"]))||(empty($user["lastName"]))) echo "----------"; 
            			else echo $user["firstName"]." ".$user["lastName"]; ?></td>
               </tr>
<?php endforeach; ?>

                </tbody>
		</table>
			<?php } ?>
     
