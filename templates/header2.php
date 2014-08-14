<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="SoInteractive">	
        <title> Get results </title>

        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
       	<script  src="./js_functions/logoutask.js"></script> <!-- include logoutask function -->
    
    </head>

    <body>
    
    	<br>
		<div class="container" >
			<p align="right"> Logged in as <?php echo $_SESSION["email"]; ?> <a href="./ulogout" onclick="return logoutask();"> <button type="button" class="btn btn-default">
			<span class="glyphicon glyphicon-log-out"></span>   Log out </button> </a><p>
		</div><br>    	

    	<div class="container">
    		<ul class="nav nav-tabs" id="tabs">
    			<li><a href="./dashboard" data-toggle="tab">Dashboard</a></li>
    			<li><a href="./leaderboard" data-toggle="tab">Leaderboard</a></li>
    			<li><a href="./details" data-toggle="tab">My profile</a></li>
    		</ul>
    	</div>
    	
    	<div class="container">
			<div class="page-header" >
   				<h1><center><img src="../images/logo.jpeg" height="50px" width="50px"><strong> Get Results </strong></center></h1><br>
   			</div>
  
    		<div class="navbar-inner">
        		<a href="javascript:history.go(-1)"><button class="btn btn-default" ">
        		<span class="glyphicon glyphicon-arrow-left"></span>
         		Previous Page</button></a>
			</div>
		</div>
    	<br><br>
    	
  	<div class="container">
 
    	<div class="modal-body row">
    	 
  			<div class="col-md-4">