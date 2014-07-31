<?php 

function ago($ptime)
{
    $etime = time() - $ptime;

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
?>

<div class="container" style="border:outset; width:500px"> 

				<h3 style="text-shadow: 1px 1px 2px gray"><center>Your daily feed</center></h3>
		<hr/>

<?php 


//date_default_timezone_set('Europe/Warsaw');

foreach ($data as $d):
	foreach ($person as $p):
		if($d["subjectId"]==$p["id"]){
			?>
		<p style="text-align:right"><?php $time=$d["updatedAt"]/1000; echo ago($time); ?></p>
				<p><span class="glyphicon glyphicon-user"></span><?php echo "<strong>"."  ".$p["firstName"]." ".$p["lastName"]."</strong>"." ".$d["data"]["body"]["message"]; 
				echo "<br>";
				$mil = $d["updatedAt"];
				$seconds = $mil / 1000;
				$prevtime = date("d-m-Y H:i:s", $seconds);
				echo $prevtime;
	
					?></p><hr/>
				
			<?php
			}
	endforeach;
endforeach; ?>


</div></div></div>     
     
    </body>
</html>