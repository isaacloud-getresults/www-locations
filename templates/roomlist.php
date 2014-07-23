
<center><h2><strong>Rooms</strong></h2></center><br><br>

<?php if(sizeof($rooms)==0) echo "<center>"."Empty"."</center>"; 
		else { ?>

            <table class="table table-hover">
                <thead>
                	<tr>
                        <th>#</th>
                        <th>Name</th>
                	</tr>
                </thead>
                <tbody>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?php echo $room["id"]; ?></td>
                            <td><a href="./room/<?php echo $room["id"];?>"><?php echo $room["label"];?></a></td>
                    	</tr>
                    <?php endforeach; ?> 

                </tbody>
            </table>
    
	<?php } ?>