
 <h2><center><strong>Profile:</strong></center></h2><br>
         

           
                   	<dl class="dl-horizontal">
  						<dt>First name:</dt>
  						<dd><?php if(empty($users["firstName"])) echo "---------"; else echo $users["firstName"]; ?></dd>
  						
  						<dt>Last name:</dt>
  						<dd><?php if(empty($users["lastName"])) echo "---------"; else echo $users["lastName"]; ?></dd>
  						
  						<dt>Score:</dt>
  						<dd><?php echo $users["leaderboards"]["1"]["score"]; ?></dd>
  						
  						<dt>Position:</dt>
  						<dd><?php echo $users["leaderboards"]["1"]["position"]; ?></dd>
  						
  						
					</dl>       
                             
                                
                    
                             
 		<br><br>


        
        
<center><button type="button" class="btn btn-primary btn-lg" >
	<span class="glyphicon glyphicon-list-alt"></span>
	<a href="./leaderboard"><font color="white">Leaderboard</font></a>
</button></center>

  
