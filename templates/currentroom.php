
<center><h2><strong>Number of users :</strong></h2></center> <br><br>

   
<p class="text-center"> Currently in the <?php echo $roomid["label"]." "; ?> there are 
	 
	
	
<?php 
$ucount=0;
for ($i=0;$i<sizeof($res);$i++)
{

for ($j=0;$j<sizeof($res[$i]["counterValues"]);$j++)
{
if ($res[$i]["counterValues"][$j]["counter"]==$instanceConf['counterid'] && $res[$i]["counterValues"][$j]["value"]==$id)
$ucount++;
}}
echo $ucount;







?> users. </p>