

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="SoInteractive">	
        <title>Get Results</title>

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


 
 
 
	$command1= "sudo config/configFile/s0-configFile2.sh ";
    $command2=" ";
    $command=$command1.$_SESSION['base64'].$command2.$_SESSION['email'];
  
  echo $command;
      
      
   $result = array();
exec($command, $result,$exit);

   echo "</br>";

  
      
 if ($exit != 0)
 {
echo  "Error";
 echo "</br>";
 
 echo implode("<br />", $result);   
  
  
  echo "</br>";
 
     
     	echo	"<a href=javascript:history.go(-1)>Go back</a>";
        	
 }
 else    
 {
 echo  "Configuration successful";
  echo " </br>";
  
  
echo  "Created:</br>";
 echo  "- Transaction source</br>";
 echo  "- Segments</br>";
 echo  "- Conditions</br>";
 echo  "- Counters</br>";
 echo  "- Achievements</br>";
 echo  "- Notifications & notification types</br>";
 echo  "- Games</br>";
 echo  "- User groups</br>";
 echo  "- Client scripts</br>";
 echo  "- Leaderboards</br>";
 echo  "- Users</br>";
   echo  "</br>";
  
  
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











   