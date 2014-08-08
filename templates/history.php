<h2><center><strong>Timeline</strong></center></h2><br>
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

<div style="width: 750px; height: 400px; overflow: scroll;">
 <table class="table table-striped">


<?php
///////////////////////// text area /////////////////////////////////////////////////

foreach($feed as $f):

echo "<tr><td>";
echo "<p style=\"text-align:right\">".$f["ago"]."</p>";
echo "<p><span class=\"glyphicon glyphicon-user\"></span>"." "."You've"." ".$f["message"]; 
echo "<br>";
echo $f["time"]."</p></td></tr>";

endforeach;

?>
 </table>
</div>