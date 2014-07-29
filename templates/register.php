

Get Results</br></br>

<form action="./register" method="POST">
Register your domain
<input type="text" name="domain">
<input type="submit" name="join" value="Join"></br>
</form>


<?php

//session_start();
//$_SESSION['email']= "agolebiowska@sosoftware.pl";

echo $_SESSION['email'];


if(  isset($_POST['join'])   &&  isset($_SESSION['email'])  ) {




//wygeneruj token
//$token= md5($_SESSION['email'].time()); 
$token = "abc";
$_SESSION['activation']= $token;
echo "token wpisany";


echo "</br>";


$domain = $_POST['domain'];
$_SESSION['domain'] = $domain;
$base_url="http://".$domain.".getresults.isaacloud.com/" ;


$to      = $_SESSION['email'];
$subject = 'Isaacloud Activation';
$message = 'Click here to activate   <br/> <br/> <a href="'.$base_url.'activate/'.$token.'">'.$base_url.'activate/'.$token.'</a>';

$headers = 'From: getresults@isaacloud.com';

mail($to, $subject, $message, $headers);





}



?>