<?php 
/************ create a form to assign a beacon to selected localizaation ***************/
include ("./funkcje/setup_data.php"); //include class Setup_data
  
  	if(isset($_SESSION["dane"]))
  		$_SESSION["dane"]= array();
  		
echo "<h2>SetUp beacons</h2></br></br>";
echo "<form method=\"POST\" action=\"./setup\">";
echo "Beacon 1 UID: <input type=\"text\" name=\"beacon1\" size=\"50\"></textarea>";
echo "   ";
echo "Location: <select name=\"location\">";
echo "<option>--Select location--</option>";

$obiekt= new Setup_data;				
$data=$obiekt->create_data($games, $groups); //create an array including: labels, conditions and number of locations in the select list

echo "</select><br><br><br>";

echo "<center><button type=\"submit\" name=\"ok\" value=\"ok\" class=\"btn btn-primary btn-lg\"><font color=\"white\">Go to IsaaCloud</font></a></button><br><br></center>";
echo "</form>";
	
$_SESSION["dane"] = $data; 

?>