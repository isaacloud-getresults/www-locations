
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
				document.getElementById('text2').disabled=true;}
			
			}
			
			
			
			
		function showPleaseWait() {
			var butt = document.getElementById("msgDiv");
			butt.innerHTML="Please wait while your location is being configured. It may take a while.";
			 document.getElementById('progressbar').style.display = "";
		 return true;
		}
  
  
  $(function() {
$("#progressbar").progressbar({ value: 0 });
setTimeout(updateProgress, 1000);
});

function updateProgress() {
  var progress;
  progress = $("#progressbar")
    .progressbar("option","value");
  if (progress < 100) {
      $("#progressbar")
        .progressbar("option", "value", progress + 1);
      setTimeout(updateProgress, 1000);
  }
}



	
			
			
			
			
		</script>


<style>
  #progressbar {
    margin-top: 20px;
  }
 
  .progress-label {
    font-weight: bold;
    text-shadow: 1px 1px 0 #fff;
  }
 
  .ui-dialog-titlebar-close {
    display: none;
  }
  </style>

<div class= "continer" style="width:600px" >

    	<h3><center>Add/delete location:</center></h3>	<br>
	<form action="./add" method="POST" name="myForm" onSubmit="return showPleaseWait()">
	
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
OK</font></button></center>
	</form>
	
	
	
	 </br></br>  	
      <center>   	
	<div id="msgDiv"></div></br></br>
	
	<div id="progressbar" style="display: none;"></div> 
	
	</center>
         		
        </div>
	
	
	
	
	
</div>