
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="SoInteractive">	
   <title> Get Results </title>

         <link href="../css/bootstrap.min.css" rel="stylesheet">
         <script src="js/jquery-1.9.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
       
        
        
    </head>

    <body>
    
    	
    	<br><br><br>
    	<div class="container">
			<div class="page-header" >
   				<h1><center>Get Results</center></h1><br>
   			</div>
   		</div>
   		
   		<div class="container">
   			<center>
   			
  <font color="red"> 	<?php	if ($sub)	{  echo "Subdomain already exists, please pick a different name.";
        echo "</br>";  echo "</br>"; }   ?>  
        
        <?php	if ($set)	{  echo "You've already registered your domain. Please activate your account.";
        echo "</br>";  echo "</br>"; }   ?>
        
        
         </font>
   			
   			
   			<form action="./register" method="POST">
Register your domain:</br></br>
<input type="text" name="domain">.getresults.isaacloud.com</br>



   			</center>
   		</div>
	<br><br>
    	<div class="container">
    		<center><button type="submit" name="join" value="Join"class="btn btn-primary" style="width: 300px; height: 60px" >
         	<span class="glyphicon glyphicon-log-in"></span> Join</button></center>
         
       </form>  	
         
         		
        </div>
	<br><br><br>
 	<div class="container">   	
		<hr />
		<h5><center>Contact: xyz@sointeractive.pl</center></h5>
	</div>
     
    </body>

</html>






