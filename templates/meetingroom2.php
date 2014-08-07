<?php 
//date_default_timezone_set('Europe/Warsaw');

/************************* time ago function *******************************************/
function ago($ptime)
{
    $etime = time() - ($ptime - 950);

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}





////////////////// build  array   /////////////////////////////////////////////////
$ss=sizeof($data);
$k=0;
$feed= array();
foreach ($data as $d):
	
	foreach ($person as $p):
	
		if($d["subjectId"]==$p["id"]){
	
			
				$mil = $d["updatedAt"];
				$seconds = ($mil / 1000)-950;
				$prevtime = date("d-m-Y H:i:s", $seconds);
				$time=$d["updatedAt"]/1000;
				$feed[$k]["ago"]=ago($time);
				$feed[$k]["name"]=$p["firstName"]." ".$p["lastName"];
				$feed[$k]["message"]=$d["data"]["body"]["message"];
				$feed[$k]["time"]=$prevtime;
					
				$k++;
				}
	endforeach;
	
endforeach; 



//////////////////////// display array ////////////////////////////////////////////
?>


<div class="container" style="border:outset; width:500px"> 

				<h3 style="text-shadow: 1px 1px 2px gray"><center>Your daily feed</center></h3>
		<hr/>

<?php 


////////////////////////// showtext function ////////////////////////////////////////////
?>

<script type="text/javascript">
  var jArr= <?php echo json_encode($feed); ?>;
  var jArray = jArr.slice(6);
  var len = jArray.length;
  var item=jArray.reverse();

  
function showtext(){
	var i=1;
	for(i;i<7;i++){

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
///////////////////////// text area /////////////////////////////////////////////////

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

?>
</div>
<?php

	}
	
/************************ Show more button ******************************************/

?>

<button class="btn btn-success" style="width: 450px">
<h4><span class="glyphicon glyphicon-arrow-down"></span>
<a onclick="showtext('jArray')" href="javascript:void(0);"><center><font color="white"><strong>Next</strong></font></h4></cemter></a></button>
<br><font color="white">.</font>
		
	
</div></div></div>     
     
    </body>
</html>