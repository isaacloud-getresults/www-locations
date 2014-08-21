<?php 
include ("./funkcje/feed.php"); //include class Feed

$obiekt2= new Feed;				
$feed=$obiekt2->build_array($data, $person);

?> 
	<script type="text/javascript">
 		  	var jArr= <?php echo json_encode($feed); ?>; //pass array from php to javascipt
  			var jArray = jArr.slice(6);
 			var item=jArray.reverse();

  
		function showtext(){
		
			var i=1;
			for(i;i<7;i++){
			//delete the last element from array and display it
				var opp=item.pop();
				if (item.pop()) 
					document.getElementById("textarea"+i).innerHTML = ("<p style=\"text-align:right\">"+opp['ago']+"</p>"+"<p><span class=\"glyphicon glyphicon-user\"></span><strong>" + opp['name']+"</strong>"+" "+opp['message']+"<br />"+opp['time']+"</p>"+"<hr/>");
				else { 
					alert ("No more notifications!");
					break;
					}
				}

			}
 		
 		</script>

<?php
/***************************  display array *********************************************/

if (empty($feed)) echo "<center>Empty</center>";
else {

echo "<div class=\"container\" style=\"border:outset; width:500px\">";
echo "<h3 style=\"text-shadow: 1px 1px 2px gray\"><center>Your daily feed</center></h3><hr/>";

$feed_s = sizeof($feed);
if($feed_s<6)  $end=$feed_s; else $end=6;

for ($i=0; $i<$end; $i++){
	$n=$i+1;
	$text="textarea".$n;

	echo "<div id=".$text.">";
	echo "<p style=\"text-align:right\">".$feed[$i]["ago"]."</p>";
	echo "<p><span class=\"glyphicon glyphicon-user\"></span><strong>".$feed[$i]["name"]."</strong>"." ".$feed[$i]["message"]; 
	echo "<br>";
	echo $feed[$i]["time"]."</p><hr/>";
	echo "</div>";

	}
	
/************************ Show more button ******************************************/

?>
<a onclick="showtext()" href="javascript:void(0);">
<button class="btn btn-success" style="width: 450px">
<h4><span class="glyphicon glyphicon-arrow-down"></span>
<center><font color="white"><strong>Next</strong></font></h4></cemter></button></a>
<br><font color="white">.</font>
		
<?php } ?>	
		</div></div></div>     
     
    </body>
</html>
