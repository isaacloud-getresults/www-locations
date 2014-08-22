
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="SoInteractive">	
        <title>Get Results </title>

         <link href="css/bootstrap.min.css" rel="stylesheet">
         <script src="js/jquery-1.9.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
       
        
        
    </head>

    <body>
    
    	
    	<br><br><br>
    	<div class="container">
			<div class="page-header" >
   				<h1><center>User not found!</center></h1><br>
   			</div>
   		</div>
   		
   		<div class="container">
   			<center>
   			<img src="http://upload.wikimedia.org/wikipedia/commons/0/02/Przyk%C5%82ad.jpg" class="img-responsive" alt="Responsive image">
   			</br></br>
   			<?php
   			if (isset ($_SESSION['domain']) &&  $_SESSION['domain'] != "" )
   {  
   	 $u= "http://".$_SESSION['domain'].".getresults.isaacloud.com/";
  	//	$u = "http://".$_SESSION['domain']."/~mac/";
    echo  "<a href=$u>Go to main page</a>";
    }
    else
    {
        echo  "<a href=./root>Go to main page</a>";
  }
    
?>



</br></br>
   			
   			</center>
   		</div>

    	
         	
         
         		
        </div>

 	<div class="container">   	
		<hr />
		<center>
	<address>
  		<strong>Contact: </strong><a href="mailto:#"> xyz@sointeractive.pl</a>
	</address></center>
	</div>
     
    </body>

</html>