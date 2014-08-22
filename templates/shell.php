

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
  

   
      
   $result = array();
exec($command, $result,$exit);

   echo "</br>";

  
  
 
  
  
  
  
      
 if ($exit != 0)
 {
echo  "Error. Please check if your base64 token is correct and make sure your instance hasn't already been configured.";
 echo "</br>";
 
 echo implode("<br />", $result);   
  
  
  echo "</br>";
 
$but="Go back";
$url="javascript:history.go(-1)";

    
        	
 }
 else    
 {
 
 
  
  $m = new MongoClient(); 
    $db = $m->isaa;
    $collection = $db->users;


    $cursor = $collection->findOne(array( 'token' => $_SESSION['activation'] ));
   

    if(!empty($cursor))   // token exists
	{     	
 	                
 	//update database
 	$cursor['base64'] = $_SESSION['base64'];
 	$collection->save($cursor);
  
  
    }  
  
 
 
 
 
 
 
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
  
  
  
$but="Go to main page";
$url="./init";
  
 
 } 
      
      
      ?>
      
    
      
      
      <a href="<?php echo $url; ?>"><button class="btn btn-primary btn-lg"  style="width:200px"><font color="white"><?php echo $but; ?></font></button></a><br><br>	
      
   			
   
    
         		
        </div>
	<br><br><br>
 	<div class="container">   	
		<hr />
		<h5><center>Contact: xyz@sointeractive.pl</center></h5>
	</div>
     
    </body>

</html>











   