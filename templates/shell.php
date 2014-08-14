 <?php

 	$command= "sudo config/configFile/s0-configFile2.sh ".$_SESSION['base64'];
 	$a = popen($command, 'r'); 

     while($b = fgets($a, 2048)) 
         { 
          echo $b."<br>\n"; 
          ob_flush();flush(); 
         } 
     pclose($a); 
      
      
      ?>
      
      </br></br>
      <a href="./root">Go to main page</a>