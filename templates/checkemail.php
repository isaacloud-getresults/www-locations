
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="SoInteractive">	
        <title>PRZYKLADOWA APLIKACJA </title>

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
  
				<h3>Please check your email.	</h3>
				
			</center>
        </div><br><br>
	
 		<div class="container">   	
		<hr />
		<h5><center>Contact: xyz@sointeractive.pl</center></h5>
	</div>
     
    </body>

</html>







<?php


$token= $_SESSION['activation']; 


$domain = $_POST['domain'];
$_SESSION['domain'] = $domain;
$base_url="http://".$domain.".getresults.isaacloud.com/" ;


$to      = $_SESSION['email'];
$subject = 'Isaacloud Activation';
$message = 'Click to activate '.$base_url.'admin/activate/'.$token;

$headers = 'From: getresults@isaacloud.com';

mail($to, $subject, $message, $headers);



?>