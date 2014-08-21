<?php 
/************************ amount of users in selected room ****************************/
include ("./funkcje/amount_users.php"); //include class Amount_users

echo "<center><h2><strong>Number of users :</strong></h2></center><br><br>";
echo "<p class=\"text-center\"> Currently in the ".$roomid["label"]." there are "; 

$obiekt = new Amount_users;
$size= $obiekt->amount($users, $roomid); //check the number of users in x room
if($size==0) echo "0"; else echo $size;

echo " users</p>";


?>