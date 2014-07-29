<!DOCTYPE html>

<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="SoInteractive">	
        <title>PRZYKLADOWA APLIKACJA </title>

         <link href="./css/bootstrap.min.css" rel="stylesheet">
         <script src="js/jquery-1.9.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
       
       
       <script>
       	function logoutask(){
  		if (confirm('Are you sure you want to logout?')){
    		return true;
 		 }else{
    		return false;
 			}
		}
       
       </script> 
        
    </head>

    <body>
    
    	<br>
		<div class="container" >
			<p align="right"> Logged in as <?php echo $_SESSION["email"]; ?>   <button type="button" class="btn btn-default" id="confirm">
			<span class="glyphicon glyphicon-log-out"></span>  <a href="./logout" onclick="return logoutask();"> Log out</a> </button><p>
		</div><br>    	

    	<div class="container">
    		<ul class="nav nav-tabs" id="tabs">
    			<li><a href="./dashboard" data-toggle="tab">Dashboard</a></li>
    			<li><a href="./leaderboard" data-toggle="tab">Leaderboard</a></li>
    			<li><a href="./details" data-toggle="tab">My profile</a></li>
    		</ul>
    	</div>
    	
    	<div class="container" >
			<div class="page-header">
   				<h1><center><strong>Page Header </strong></center></h1><br>
   			</div>
   					
    		<div class="navbar-inner">
        		<button class="btn btn-default" ">
        		<span class="glyphicon glyphicon-arrow-left"></span>
         		<a href="javascript:history.go(-1)">Previous Page</a></button>
			</div>
		</div>
    	<br>
    	
  	<div class="container">
 
    	<div class="modal-body row">
    	 
  			<div class="col-md-4">