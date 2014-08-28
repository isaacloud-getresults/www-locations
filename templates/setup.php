<?php
$i=0;
  $zmienna= array();
      foreach ($_SESSION["beacons"] as $b): 
       $zmienna[$i]="</br>".$b['beacon'].": ".$b['location']." "."<a id="."\"".$b['beacon']."\""." onclick=\"return delete_element(this.id);\" href=\"#\">delete</a>";
       $i++;
      endforeach;
 
      
     $uu=0; 
      $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))   
	{     	
 	                
 	$uu=$cursor['UUID'];
 
 	
    }    
      
      
 
       ?>
<script>


function showtext(){
		
			 var zmienna=<?php echo json_encode($zmienna); ?>;
				
					document.getElementById("field").innerHTML = ("<br>" + "List of all beacons:"+ zmienna + ".");
				

			}











			function delete_element(clicked_id){
			

				var beac=<?php echo json_encode($_SESSION['beacons']); ?>;
				var i=0;
				var loc=0;
					for (i; i < beac.length; i++){
					if (beac[i]['beacon'] == clicked_id ){
						//alert (beac[i]['location']);
						loc= beac[i]['location'];
						}
				}
				
				
	
		
var w = "2";
 window.location.href = "./exec?location=" + loc + "&w="+ w;

 }




function validateForm() {



var mm=<?php echo json_encode($mm); ?>;
var u="<?=$uu?>";
var z = document.forms["myForm"]["major1"].value;
var y = document.forms["myForm"]["minor1"].value;
var x = document.forms["myForm"]["uuid"].value;
var beacon = z+"."+y;


  if ((u=0 && !x) || !x)   {
  
        alert("All fields must be filled out");
        return false;
       }
  
  	
  	if(z && y && mm){
    
	for(i=0;i< mm.length;i++){
		
		if(beacon == mm[i]){
				if(confirm ("Entered major.minor's assigned to the other location. Are you sure you want to continue?")){
    		return true;
 		}
 			else{
    			return false;
 			}
				
				}
			
				
	}	
	}

}

 		  	//var jArr= <?php echo json_encode($_SESSION['beacons']); ?>; //pass array from php to javascipt
  		

		








</script>





<?php 

/************ create a form to assign a beacon to selected localizaation ***************/
include ("./funkcje/setup_data.php"); //include class Setup_data
  
  	if(isset($_SESSION["dane"]))
  		$_SESSION["dane"]= array();
  		
  	if(isset($_SESSION["mm"]))
  		$_SESSION["mm"]= array();	
  		
  		
  		
?>		
<h2>SetUp </h2></br></br>

	<?php
    /*************************/
    $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;
	$cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   
   	if(!empty($cursor))                   
 		$uuid=$cursor['UUID'];
 	?>

<div class="modal-body row">
   <div class="col-md-7" >	
    	<h4><center><strong>Assign beacon to selected location: </strong></center></h4><br>		
			<form name="myForm" method="POST" action="./setup" onsubmit="return validateForm()">
 				
 				<dl class="dl-horizontal">
 					<dt><strong>UUID: </strong></dt>
  						<?php if(!isset($uuid))
								echo  "<dd><input type=\"text\" name=\"uuid\" size=\"40\"></dd><br>";
							else 
								echo  "<dd><input type=\"text\" name=\"uuid\" value=$uuid size=\"40\" ></dd><br>";	
  					 	?>
  					<dt><strong>Location: </strong></dt>	
  						<dd><a onclick="showtext()" href="javascript:void(0);"><select name="location" >
  							<option disabled>--Select location--</option>
				<?php
				$obiekt= new Setup_data;				
				$data=$obiekt->create_data($games, $groups); //create an array including: labels, conditions and number of locations in the select list
				
					foreach ($data as $d): ?>
					
						<option onclick="showtext()" ><?php echo $d['name']; ?></option>
					
					<?php endforeach; ?>
						</select></a><br><div id="field"></div></dd><br>
						
  					<dt><strong>Major.minor: </strong></dt>		
  					<dd><input type="text" name="major1" size="5"> .
  						<input type="text" name="minor1" size="3"></dd><br>
  				
  				</dl>


<center><button type="submit" name="ok" value="ok" class="btn btn-primary btn-lg"><font color="white">
<span class="glyphicon glyphicon-circle-arrow-down"></span> Save</font></button></center><br>

</form>




</div>
<div class="col-md-5" >	
    	<h4><strong><center>Add new or delete existing location/ List of all beacons: </center></strong></h4><br>
		<center><a href="./admin/add"><button class="btn btn-primary btn-lg"><font color="white">
		<span class="glyphicon glyphicon-hand-right"></span>  Click here </font></button></a></center><br><br>
 			
 	
 			
 			
 		<h4><strong><center>Add google calendar: </center></strong></h4>
	<center><a href="./admin/calendar"><img src="../images/google-calendar_logo.jpg" height="70px" width="220px"></a>
 				
	</div></div>

<?php	
$_SESSION["dane"] = $data; 

$_SESSION["mm"] = $mm; 


?>