<?php 
/********************* display all users in the meeting room **************************/
include ("./funkcje/amount_users.php"); //include class Amount users
include ("./funkcje/leaderboard.php"); //include class Leaderboard
include ("./funkcje/meeting.php"); //include class Meeting

/************* get data base64 and google calendar's base64 from mongo **/

 

    if(!empty($cursor))   
	{     	
 	
              
 	$base_cal=$cursor['calendar'] ;
 	$base=$cursor['base64'] ;
 	
}



//////////////////////////////////////////////////////////////////////////

// check amount of users
$obiekt = new Amount_users;
$tab= $obiekt->amount($users, $roomid);


	$obiekt2 = new Leaderboard;
	$data = $obiekt2-> create_array3($users);
	
echo "<center><h3>Meeting list:</h3></center>";	
	
//get data from webpage
if(isset($base_cal) and isset($base)){



$url_m="http://188.226.248.208:8080/meetingBoard?iB64=".$base."&cB64=".$base_cal."&id=".$roomid['id'];

$obiekt3 = new Meeting;
$inf = $obiekt3-> create_data($url_m);
$members=array();
if (empty($inf)) 
	echo "<center>Data not available! </center>";
else {
//create leaderboard
$obiekt4 = new Meeting;
$members = $obiekt4-> create_leaderboard($inf, $data);

if (!empty($members)){


?>


  <table class="table table-striped table-hover">
                <thead>
                    <tr>
                      <th>Name</th>
                        <th style="text-align:center ">Confirmation</th>
                        <th style="text-align:center ">Status</th>
                      
                   </tr>
                </thead>
                <tbody>
							
					<?php foreach ($members as $member): ?>
 						<tr>
							<td width= "45%" ><?php echo $member['name']; ?></td>
							<td align="center" ><?php echo $member['confirm']; ?></td>
							<td align="center" ><?php echo $member['status']; ?></td>
							
            			</tr>
               		<?php endforeach; ?>
               		
                </tbody>
		</table>
		
		
		
		
<?php 
}
}
}
else 
	echo "Check if you add base64 of google calendar";

if($tab==0) 
	echo "<br><br><br><center>Empty</center>";
else{

	$obiekt2 = new Leaderboard;
	$data2 = $obiekt2-> create_array($users, $roomid);
//print_r($data2);	
if (empty($members))
$data3=$data2;

else{
//print_r($members);
//print_r($data2);
	$obiekt3 = new Leaderboard;
	$data3 = $obiekt3-> guests_array($members, $data2);
	
	}
?>

<br><br><br><center><h4>Guests:</h4>
<?php if(empty($data3)) echo "<center>Empty</center>";
		else{ ?>
  <table class="table " style="width:50%">
                <thead>
                    <tr>
                        
 			
                        <th>Name</th>
                      
                   
                    </tr>
                </thead>
                <tbody>


					<?php foreach ($data3 as $d): ?>
 						<tr>
							<td><?php if(empty($d["name"])) echo "<em>"."(".$d["email"].")"."</em>"; else echo $d["name"]; ?></td>
            				
            			</tr>
               		
 					<?php endforeach; ?>


                </tbody>
		</table></center>

<?php
}


}
?>