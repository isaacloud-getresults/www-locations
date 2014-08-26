<?php

$cal = null;

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

	
    var z = document.forms["myForm"]["calendar1"].value;
    var y = document.forms["myForm"]["calendar2"].value;
    var stg = z+":"+y;
    var x= btoa(stg);

    if (z == null || z== "" || y == null || y == "" ) {
  
        alert("All fields must be filled out");
        return false;
       
    	}
    if(!(z == null || z== "" || y == null || y == "" ) && x != cal && cal  ){
   
    	if (confirm("Base64 for your email already exists. Are you sure you want to continue?")){
    		return true;
 		 		}
 		 	else{
    			return false;
 			}
 		}
 	if(!(z == null || z== "" || y == null || y == "" ) && x == cal ){
  
        alert("Base64 already exists in database");
        return false;
       
    }
  
    
}
</script>



<h2>Add Google calendar</h2>
<br><br>

<form name="myForm" method="POST" action="./calendar" onsubmit="return validateForm()">
<dl class="dl-horizontal">

<dt>ID:</dt>
<dd><input type="text" name="calendar1" size="50"></dd><br>

<dt>Secret:</dt>
<dd><input type="text" name="calendar2" size="50"><br><br>

<button type="submit" name="ok" value="ok" class="btn btn-primary "><font color="white">
<span class="glyphicon glyphicon-circle-arrow-down"></span> Save</font></button></dd></dl><br>
</form>