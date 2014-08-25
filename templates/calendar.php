<?php

$cal=0;

$m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'email' => $_SESSION['email'] ));
   

    if(!empty($cursor))   
	{     	
 	                
 	$cal=$cursor['calendar'] ;
 
    }

?>
<script>
function validateForm() {
	var cal="<?=$cal?>";
    var x = document.forms["myForm"]["calendar"].value;
    if (x == null || x== "" ) {
  
        alert("Base64 must be filled out");
        return false;
       
    	}
    if(!(x == null || x== "" ) && x != cal ){
   
    	if (confirm("Base64 for your eamil is already exist. Are you sure you want to continue?")){
    		return true;
 		 		}
 		 	else{
    			return false;
 			}
 		}
 	if(!(x == null || x== "" ) && x == cal ){
  
        alert("The same base64's already exist");
        return false;
       
    }
  
    
}
</script>



<h2>Add google calendar</h2>
<br><br>

<form name="myForm" method="POST" action="./calendar" onsubmit="return validateForm()">
<dl class="dl-horizontal">
<dt>Base64:</dt>
<dd><input type="text" name="calendar" size="50"><br><br>

<button type="submit" name="ok" value="ok" class="btn btn-primary "><font color="white">
<span class="glyphicon glyphicon-circle-arrow-down"></span> Save</font></button></dd></dl><br>
</form>