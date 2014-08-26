<h1> Mobile Apps </h1><br>
	
    	<div class="modal-body row">
    				
    				
				 <div class="col-md-6" >
						<p class="bg-info" style="text-align:center"><font size="6pt">iOS</font></p><br>
						<center><a href="http://www.appstore.com/myweb" target="_blank"><img src="../images/App_Store_Badge_EN.gif" height="70px" width="220px"></a>

    					<footer>
							<script type='text/javascript'>
								var _merchantSettings=_merchantSettings || [];_merchantSettings.push(['AT', 'YourAffiliateTokenHere']);
								(function(){var     autolink=document.createElement('script');autolink.type='text/javascript';autolink.async=true; autolink.src='https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';
								var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(autolink, s);})();
							</script>
							
							</br></br>
							
							
									<form action="./mobile"  method="POST" >	
<h1>Activate mobile access:</h1>

       	
    <?php     	if (isset($_POST['iosbase64']) || isset($_POST['androidbase64']))
         {echo	"<h3> Done!</h3>";}
         	
         ?>	


<h3>iOS</h3>	

id:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="iosid" size="40">
</br>base64:
<input type="text" name="iosbase64" size="40">
    	
         	
         	
         </br>
         	
<h3>Android    </h3>    	
         	
base64: <input type="text" name="androidbase64" size="40" ></br></br>
    	<button type="submit" name="sub" value="ok" class="btn btn-primary" style="width: 100px; " >
         	<span class="glyphicon glyphicon-log-in"></span> OK</button>
         	  	
       
      </form> 		
			
						</footer>
		
		</div>
							
							
							
						
				
				<div class="col-md-6">	
						<p class="bg-info" style="text-align:center"><font size="6pt">Android</font></p><br>
						<center><a href="http://www.appstore.com/myweb" target="_blank"><img src="../images/google-play.png" height="70px" width="220px"></a>

    					<footer>
							<script type='text/javascript'>
								var _merchantSettings=_merchantSettings || [];_merchantSettings.push(['AT', 'YourAffiliateTokenHere']);
								(function(){var     autolink=document.createElement('script');autolink.type='text/javascript';autolink.async=true; autolink.src='https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';
								var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(autolink, s);})();
							</script>
							
							
						</br></br>		
						





<h1> Config </h1>
							
								<div id="qrcode" >
									<script type="text/javascript">
									var kod="<?=$profileqr?>";
									
										var qrcode = new QRCode(document.getElementById("qrcode"), {
										text : ("http://"+kod+".getresults.isaacloud.com/"),
										width : 180,
										height : 180
											});
										makeCode(); 
									</script>
									
							
							
							
						</footer>
						
		
				</div>




			</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	
	

		