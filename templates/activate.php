
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="SoInteractive">	
       <title> Get Results </title>

         <link href="../../css/bootstrap.min.css" rel="stylesheet">
         <script src="js/jquery-1.9.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
       
       
       <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">  
       
       
 <script>
  
  	
		function showPleaseWait() {
			var butt = document.getElementById("msgDiv");
			butt.innerHTML="Please wait while your instance is being configured. It may take a few minutes.";
			 document.getElementById('progressbar').style.display = "";
		 return true;
		}
  
  
  $(function() {
$("#progressbar").progressbar({ value: 0 });
setTimeout(updateProgress, 4000);
});

function updateProgress() {
  var progress;
  progress = $("#progressbar")
    .progressbar("option","value");
  if (progress < 100) {
      $("#progressbar")
        .progressbar("option", "value", progress + 1);
      setTimeout(updateProgress, 4000);
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
        
        
        
        
    </head>

    <body>
    
    	
    	<br><br><br>
    	<div class="container">
			<div class="page-header" >
   				<h1><center>Get Results</center></h1><br>
   				<h3><center>Confirmation</center></h3><br>
   			</div>
   		</div>
   		
   		<div class="container" id="act1">
   			<center>
   			<h4>Domain: <?php echo $_SERVER['SERVER_NAME']; ?> </h4></br>
   			
   			
1. Go to <a href="https://isaacloud.com/sign-up/"  target="_blank">isaacloud.com/sign-up/</a></br>
2. Create Instance</br>
3. Create Application</br>
</br>




<form action="./activate" name="myForm" method="POST" onSubmit="return showPleaseWait()" >
Your base64 token:</br>
<input type="text" name="base64" size="40">


   			
   			
   			</center>
   		</div>
	<br><br>
    	<div class="container" id="act2">
    		<center><button type="submit" name="sub" value="ok" class="btn btn-primary" style="width: 300px; height: 60px" >
         	<span class="glyphicon glyphicon-log-in"></span> OK</button></center>
         
      </form> 
      </br></br>  	
      <center>   	
	<div id="msgDiv"></div></br></br>
	
	<div id="progressbar" style="display: none;"></div> 
	
	</center>
         		
        </div>
	<br><br><br>
 	<div class="container">   	
		<hr />
		<h5><center>Contact: xyz@sointeractive.pl</center></h5>
	</div>
     
    </body>

</html>







