	    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css"> 

	
	
	
	
	<script type="text/javascript">
			function disable(){
				if(document.getElementById('nazwa').options[document.getElementById('nazwa').selectedIndex].value =='add')
				{document.getElementById('text1').disabled=true;
				document.getElementById('text2').disabled=false;}
				if(document.getElementById('nazwa').options[document.getElementById('nazwa').selectedIndex].value =='delete') 
				{document.getElementById('text1').disabled=false;
				document.getElementById('text2').value=null;
				document.getElementById('text2').disabled=true;}
			
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
				
				
	

var w = "1";
 window.location.href = "./exec?location=" + loc + "&w="+ w;
 }
 
  		function showPleaseWait() {
			var butt = document.getElementById("msgDiv");
			butt.innerHTML="Please wait while your location is being configured. It may take a while.";
			 document.getElementById('spinnerImg').style.display = "";
		 return true;
		}
  

 
 
 </script>
 
 
 
 
 <script>
 
 
 
 function validateForm() {
var mm=<?php echo json_encode($_SESSION['dane']); ?>;
var y = document.forms["myForm"]["option"].value;
var x = document.forms["myForm"]["room"].value;
var z = document.forms["myForm"]["newroom"].value;

  	if(z && mm){
    
	for(i=0;i< mm.length;i++){
		
		if(z == mm[i]['name']){
				alert ("Location's exists!")
    		return false;
}
}
}
if((z && y == "add") || (x && y == "delete")){

showPleaseWait();

}

  if ( (!z && y == "add") || (!x && y == "delete")) {
  
        alert("All fields must be filled out");
        return false;
       }
  
  




}
 

	
		</script>





<div class="modal-body row">
   <div class="col-md-6" >	

    	<h3><center>Add/delete location:</center></h3>	<br>
	<form name="myForm" action="./add" method="POST" onsubmit="return validateForm()" >
	
	<dl class="dl-horizontal">
	<dt>Option: </dt>
	<dd><select name="option" id='nazwa' onchange="disable()">
			<option ></option>
			<option disabled>-- options --</option>
			<option value='add'>Add</option>
			<option value='delete'>Delete</option>
		
		</select></dd><br>
		<dt>Locations: </dt>	
		<dd><select name="room" id='text1'  disabled >
		<option ></option>
		<option disabled>-- locations --</option>
			<?php foreach ($_SESSION['dane'] as $d):?>
		
			
			
			<option value='<?php echo $d['name']; ?>'><?php echo $d['name']; ?></option>
		<?php endforeach; ?>
		</select></dd><br>
		<dt>New location: </dt>
		<dd><input disabled id="text2" type="text" name="newroom" /><br>
		<font size='2pt'>(first letter must be capital, e.g. Kitchen)</font></dd>
	
		<br>	
	<dl>
	<center><button type="submit" name="execute" value="ok" class="btn btn-primary btn-lg"><font color="white">
Ok</font></button></center>
	
	</form>
	
		 </br> 	
      <center>   	
	<div id="msgDiv"></div></br>
	
	<div> <img src="../images/wait.gif" id="spinnerImg" style="display: none;" /></div>
	
	</center>

	
	
	
</div>

<div class="col-md-5 col-md-offset-1" >	
  	<h3><center>Beacons:</center></h3>	<br>
  
<table class="table table-striped table-hover">
                
                	<?php $i=0;
                		foreach ($_SESSION['beacons'] as $b): ?>
                			<tr>
                				<td><?php echo $b['beacon']; ?></td>
                				<td ><?php echo $b['location']; ?></td>
                				<td ><button id="<?php echo $b['beacon']; ?>" onclick="return delete_element(this.id); "class="btn btn-default " >Delete</button></td>
                			</tr>
                	<?php $i++;
                	endforeach; ?>
               
    </table>
    



</div></div>