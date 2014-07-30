
<h2><center><strong>My profile</strong></center></h2><br><br>
    
						           
                   	<dl class="dl-horizontal">
  						<dt>First name:</dt>
  						<dd><?php if(empty($myprofile["firstName"])) echo "---------"; else echo $myprofile["firstName"]; ?></dd>
  						
  						<dt>Last name:</dt>
  						<dd><?php if(empty($myprofile["lastName"])) echo "---------"; else echo $myprofile["lastName"]; ?></dd>
  						
  						<dt>Score:</dt>
  						<dd><?php if(empty($myprofile["leaderboards"]["1"]["score"])) echo "---------"; else echo $myprofile["leaderboards"]["1"]["score"]; ?></dd>
  						
  						<dt>Position:</dt>
  						<dd><?php if(empty($myprofile["leaderboards"]["1"]["score"])) echo "---------"; else echo $myprofile["leaderboards"]["1"]["position"]; ?></dd>
  						
  						
					</dl>       
                             
                                
                    
                             
 		<br><br>
        
        
        <center><button type="button" class="btn btn-primary btn-lg" >
        <span class="glyphicon glyphicon-list-alt"></span>
        <a href="./leaderboard"><font color="white">Leaderboard</font></a></button></center>