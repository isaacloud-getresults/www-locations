<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="SoInteractive">	
        <title>PRZYKLADOWA APLIKACJA </title>

        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="../qrcodesjs/qrcode.js"></script>
     
     	<script type="text/javascript">
     	
			function makeCode() {		
			var elText = document.getElementById("text");
	
			qrcode.makeCode(elText.value);
				}

		</script>
        
    </head>

    <body>
    
    	<br>
    	
        	
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
		
		
    	<br><br><br>