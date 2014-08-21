<?php 
/************ create a form to assign a beacon to selected localizaation ***************/
include ("./funkcje/setup_data.php"); //include class Setup_data
  
  	if(isset($_SESSION["dane"]))
  		$_SESSION["dane"]= array();
  		
echo "<h2>SetUp beacons</h2></br></br>";
echo "<form method=\"POST\" action=\"./setup\">";

echo "<div class=\"container\" style=\"width:900px\">";
 		echo "<div class=\"modal-body row\">";
 		echo "<center>";
    	 	echo "<div class=\"col-md-6\" >";
    	 	
    	/*************************/
    	$m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
	$cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

   
   	if(!empty($cursor))                   
 		$uuid=$cursor['uuid'];
 
  
    	/***************************/ 	

				echo "<strong>UUID:</strong><br>";
				if(!isset($uuid))
					echo  "<input type=\"text\" name=\"uuid\" size=\"50\">";
				else 
				echo  "<input type=\"text\" name=\"uuid\" value=$uuid size=\"50\" >";
				
			echo "</div>";
			
			echo "<div class=\"col-md-3\" >";
				echo "<strong>Location:</strong><br>";
				echo "<select name=\"location\">";
				echo "<option>--Select location--</option>";

				$obiekt= new Setup_data;				
				$data=$obiekt->create_data($games, $groups); //create an array including: labels, conditions and number of locations in the select list

				echo "</select>";
			echo "</div>";
			
			echo "<div class=\"col-md-3\" >";			
				echo " <strong>Major.minor:</strong><br>";
				echo " <input type=\"text\" name=\"major1\" size=\"8\">"; 
				echo " . <input type=\"text\" name=\"minor1\" size=\"8\">";
			echo "</div>";
		echo "</div>";
	echo "</div>";	
echo "<br><br><center><button type=\"submit\" name=\"ok\" value=\"ok\" class=\"btn btn-primary btn-lg\"><font color=\"white\">Go to IsaaCloud</font></a></button><br><br></center>";
echo "</form>";
	
$_SESSION["dane"] = $data; 



?>