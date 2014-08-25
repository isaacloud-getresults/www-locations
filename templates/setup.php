<?php 
/************ create a form to assign a beacon to selected localizaation ***************/
include ("./funkcje/setup_data.php"); //include class Setup_data
  
  	if(isset($_SESSION["dane"]))
  		$_SESSION["dane"]= array();
  		
echo "<h2>SetUp </h2></br></br>";




    	
    	 	
    	/*************************/
    	$m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
	$cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   
   	if(!empty($cursor))                   
 		$uuid=$cursor['uuid'];
 
  
    	/***************************/ 
echo "<div class=\"modal-body row\">";
   
    echo "<div class=\"col-md-7\" >";	
    	echo "<h4><center><strong>Assign beacon to selected location: </strong></center></h4><br>";		
echo "<form method=\"POST\" action=\"./setup\">";
 		echo "<dl class=\"dl-horizontal\">";
 	
  				echo "<dt><strong>UUID: </strong></dt>";
  					if(!isset($uuid))
						echo  "<dd><input type=\"text\" name=\"uuid\" size=\"40\"></dd><br>";
					else 
						echo  "<dd><input type=\"text\" name=\"uuid\" value=$uuid size=\"40\" ></dd><br>";	
  					
  				echo "<dt><strong>Location: </strong></dt>";	
  						echo "<dd><select name=\"location\" >";
  						echo "<option disabled>--Select location--</option>";

				$obiekt= new Setup_data;				
				$data=$obiekt->create_data($games, $groups); //create an array including: labels, conditions and number of locations in the select list
				
					foreach ($data as $d):
					
						echo "<option>".$d['name']."</option>";
					
					endforeach;
				echo "</select></dd><br>";
  				echo " <dt><strong>Major.minor: </strong></dt>";		
  				echo " <dd><input type=\"text\" name=\"major1\" size=\"5\">";
  				echo " . <input type=\"text\" name=\"minor1\" size=\"3\"></dd><br>";
  				
  				echo "</dl>";


			//////////////////////////
			

		
echo "<center><button type=\"submit\" name=\"ok\" value=\"ok\" class=\"btn btn-primary btn-lg\"><font color=\"white\">
<span class=\"glyphicon glyphicon-circle-arrow-down\"></span> Save</font></button></center><br>";

echo "</form>";
 echo "</div>";
  echo "<div class=\"col-md-5\" >";	
    	echo "<h4><strong><center>Add new or delete existing location: </center></strong></h4><br>";
		echo "<center><a href=\"./admin/add\"><button class=\"btn btn-primary btn-lg\"><font color=\"white\">
		<span class=\"glyphicon glyphicon-plus-sign\"></span> Add / <span class=\"glyphicon glyphicon-minus-sign\"></span> delete location</font></button></a></center><br><br>";
 			
 		echo "<h4><strong><center>Add google calendar: </center></strong></h4>";
		echo "<center><a href=\"./admin/calendar\"><img src=\"../images/google-calendar_logo.jpg\" height=\"70px\" width=\"220px\"></a>	";
 				
	echo "</div></div>";

	
$_SESSION["dane"] = $data; 



?>
