<?php 
/********************* display all users in the meeting room **************************/
include ("./funkcje/amount_users.php"); //include class Amount users
include ("./funkcje/leaderboard.php"); //include class Leaderboard
include ("./funkcje/meeting.php"); //include class Meeting

// check amount of users
$obiekt = new Amount_users;
$tab= $obiekt->amount($users, $roomid);

if($tab==0) 
	echo "<center>Empty</center>";
else{
	$obiekt2 = new Leaderboard;
	$data = $obiekt2-> create_array3($users);
	
	
//get data from webpage

$url_m= 'http://188.226.248.208:8080/meetingBoard';
$obiekt3 = new Meeting;
$inf = $obiekt3-> create_data($url_m);

//create leaderboard
$obiekt4 = new Meeting;
$members = $obiekt4-> create_leaderboard($inf, $data);

?>


  <table class="table table-striped table-hover">
                <thead>
                    <tr>
                      <th>Name</th>
                        <th style="text-align:center ">Confirmation</th>
                        <th style="text-align:center ">Status</th>
                        <th style="text-align:right ">Score</th>
                   </tr>
                </thead>
                <tbody>
							
					<?php foreach ($members as $member): ?>
 						<tr>
							<td width= "45%" ><?php echo $member['name']; ?></td>
							<td align="center" ><?php echo $member['confirm']; ?></td>
							<td align="center" ><?php echo $member['status']; ?></td>
							<td align="right"><span class="badge "><?php echo $member['score']; ?></span></td>	
            			</tr>
               		<?php endforeach; ?>
               		
                </tbody>
		</table>
		
<?php } 





?>