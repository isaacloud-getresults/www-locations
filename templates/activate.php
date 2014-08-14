
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
       
        
       <script language="JavaScript">
		<!--
		function showPleaseWait() {
			var butt = document.getElementById("msgDiv");
			butt.innerHTML="Please wait while your instance is being configured. It may take a while. </br></br> <img src="../../images/wait.gif">";
		 return true;
		}
		//-->
	</script> 
        
        
        
        
    </head>

    <body>
    
    	
    	<br><br><br>
    	<div class="container">
			<div class="page-header" >
   				<h1><center>Get Results</center></h1><br>
   				<h3><center>Confirmation</center></h3><br>
   			</div>
   		</div>
   		
   		<div class="container">
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
    	<div class="container">
    		<center><button type="submit" name="sub" value="ok" class="btn btn-primary" style="width: 300px; height: 60px" >
         	<span class="glyphicon glyphicon-log-in"></span> OK</button></center>
         
      </form> 
      </br></br>  	
      <center>   	
	<div id="msgDiv"></div>
	</center>
         		
        </div>
	<br><br><br>
 	<div class="container">   	
		<hr />
		<h5><center>Contact: xyz@sointeractive.pl</center></h5>
	</div>
     
    </body>

</html>







