<div class="container" style="border:outset; width:500px"> 

				<h3 style="text-shadow: 1px 1px 2px gray"><center>Your daily feed</center></h3>
		<hr/>

<?php 


foreach ($data as $d):
	foreach ($person as $p):
		if($d["subjectId"]==$p["id"]){
			?>
		
				<p><span class="glyphicon glyphicon-user"></span><?php echo "<strong>"."  ".$p["firstName"]." ".$p["lastName"]."</strong>"." ".$d["data"]["body"]["message"]; 
				echo "<br>";
				$mil = $d["updatedAt"];
				$seconds = $mil / 1000;
				$prevtime = date("d-m-Y H:i:s", $seconds);
				echo $prevtime;
	
					?></p><hr/>
					<?php// echo "time ago"; ?>
			
			<?php
			}
	endforeach;
endforeach; ?>


</div></div></div>     
     
    </body>
</html>