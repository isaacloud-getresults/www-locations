<?php
/************************* display statistics *****************************************/

include ("./funkcje/statistics.php"); //include class Statistics
include ("./funkcje/leaderboard.php"); //include class Leaderboard



echo "<div class=\"modal-body row\">";
   echo "<div class=\"col-md-5\" >";
   
echo "<h1><strong>Statistics</strong></h1><br>";

$obiekt= new Statistics;
$data= $obiekt->create_statistic($res1);

$obiekt1= new Statistics;
$data2= $obiekt1->amount_of_visits($resA);

	
echo "<h4>".sizeof($res1)." Users"."</h4>";
echo "<h4>".sizeof($resA)." Rooms"."</h4>";
echo "<h4>".$data['points']." Points"."</h4>";
echo "<h4>".$data['achievements']." Achievements"."</h4>";
if (!empty($data2)){
foreach ($data2 as $d):
		echo "<h4>".$d['amount']." ".$d['label']." visits</h4>";
endforeach;
}

	echo "</div>";

	   echo "<div class=\"col-md-7\" >";
	   
	   echo "<h1><strong>Leaderboard</strong></h1><br>";

// amount of users in leaderboard
if(sizeof($res1)==0) echo "<center>"."Empty"."</center>"; //no users

else { 
	$obiekt2 = new Leaderboard;
	$data= $obiekt2-> create_array2($res1); ?>
	<div style="height: 400px; overflow: scroll;">	
     <table class="table table-hover">
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
		</table></div>
 
<?php }
	echo "</div></div>";
?>