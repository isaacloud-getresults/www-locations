	<script type="text/javascript">
			function disable(){
				if(document.getElementById('nazwa').options[document.getElementById('nazwa').selectedIndex].value =='add')
				{document.getElementById('text1').disabled=true;
				document.getElementById('text2').disabled=false;}
				if(document.getElementById('nazwa').options[document.getElementById('nazwa').selectedIndex].value =='delete') 
				{document.getElementById('text1').disabled=false;
				document.getElementById('text2').disabled=true;}
			
			}
		</script>


<div class= "continer" style="width:600px" >

    	<h3><center>Add/delete location:</center></h3>	<br>
	<form action="./add" method="POST" >
	
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
Execute</font></button></center>
	
	</form>
</div>