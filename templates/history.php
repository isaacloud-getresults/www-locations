<h2><center><strong>Timeline</strong></center></h2><br><br>
<?php 
date_default_timezone_set('Europe/Warsaw');

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
	
	
			
				$mil = $d["updatedAt"];
				$seconds = ($mil / 1000)-950;
				$prevtime = date("d-m-Y H:i:s", $seconds);
				$time=$d["updatedAt"]/1000;
				$feed[$k]["ago"]=ago($time);
				$feed[$k]["message"]=$d["data"]["body"]["message"];
				$feed[$k]["time"]=$prevtime;
					
				$k++;
		
	
endforeach; 




?>




<?php 


////////////////////////// showtext function ////////////////////////////////////////////
?>

<script type="text/javascript">
  var jArr= <?php echo json_encode($feed); ?>;
  var jArray = jArr.slice(5);
  var len = jArray.length;
  var item=jArray.reverse();


  ////////// next function
function next(){
	var i=1;
 
	for(i;i<6;i++){

		var opp=item.pop();
	
	
		if (item.pop()) 
			document.getElementById("textarea"+i).innerHTML = ("<p style=\"text-align:right\">"+opp['ago']+"</p>"+"<p><span class=\"glyphicon glyphicon-user\"></span>" + " " + "You've"+ " "+opp['message']+"<br />"+opp['time']+"</p>"+"<hr/>");
		else { 
			alert ("No more notifications!");
			break;
			}
			
		}
}

 </script>




<?php
///////////////////////// text area /////////////////////////////////////////////////

echo "<hr/>";
$feed_s = sizeof($feed);
if($feed_s<5)  $end=$feed_s; else $end=5;

for ($i=0; $i<$end; $i++){
$n=$i+1;
$text="textarea".$n;

echo "<div id=".$text.">";
echo "<p style=\"text-align:right\">".$feed[$i]["ago"]."</p>";
echo "<p><span class=\"glyphicon glyphicon-user\"></span>"." "."You've"." ".$feed[$i]["message"]; 
echo "<br>";
echo $feed[$i]["time"]."</p><hr/>";

?>
</div>
<?php

	}
	
/************************ Show more button ******************************************/

?>


<center><h4 align="right"><a onclick="next()" href="javascript:void(0);" ><strong>Next</strong></a>
<span class="glyphicon glyphicon-arrow-right"></span></h4></center>