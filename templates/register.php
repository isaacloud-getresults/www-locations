
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
   			
  <font color="red"> 	<?php	if ($sub)	{  echo "Subdomain already exists, please pick a different name.";
        echo "</br>";  echo "</br>"; }   ?>   </font>
   			
   			
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






<?php

//session_start();
//$_SESSION['email']= "agolebiowska@sosoftware.pl";

//echo $_SESSION['email'];


if(  isset($_POST['join'])   &&  isset($_SESSION['email']) ) {

echo "generuje token";


//wygeneruj token
//$token= md5($_SESSION['email'].time()); 
$token = "abc";
$_SESSION['activation']= $token;
echo "token wpisany";


//echo "</br>";


$domain = $_POST['domain'];
$_SESSION['domain'] = $domain;
$base_url="http://".$domain.".getresults.isaacloud.com/" ;


$to      = $_SESSION['email'];
$subject = 'Isaacloud Activation';
$message = 'Click here to activate   <br/> <br/> <a href="'.$base_url.'activate/'.$token.'">'.$base_url.'activate/'.$token.'</a>';

$headers = 'From: getresults@isaacloud.com';

mail($to, $subject, $message, $headers);

echo "wyslano maila";



}



?>