

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
   				<h2><center>Configuration finished.</center></h2><br>
   			</div>
   		</div>
   		
   		<div class="container">
   			<center>
   			
 <?php


       
      
echo $_SESSION['email'];
echo "</br>;
 
 
	$command= "sudo config/configFile/s0-configFile2.sh ".$_SESSION['base64'];

      
   $result = array();
exec($command, $result,$exit);
echo implode("<br />", $result);   
  
  
  echo "</br>";
   echo "</br>";

  
      
 if ($exit != 0)
 {
echo  "Error";
 echo "</br>";
     
     	echo	"<a href=javascript:history.go(-1)>Go back</a>";
        	
 }
 else    
 {
 echo  "Configuration successful";
  echo " </br>";
 echo    " <a href=./root>Go to main page</a>";
 } 
      
      
      ?>
      
      
   			
   
    
         		
        </div>
	<br><br><br>
 	<div class="container">   	
		<hr />
		<h5><center>Contact: xyz@sointeractive.pl</center></h5>
	</div>
     
    </body>

</html>











   