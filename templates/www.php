 		    <h1> WWW Apps </h1><br>
	
			
 
    				<div class="modal-body row">
				 		<div class="col-md-4" >
							<p class="bg-info" style="text-align:center"><font size="6pt">Kitchen</font></p><br>
							<center><button class="btn btn-primary" style="width:120px"><a href="./kitchen"><font color="white">Open</font></a></button>
							<BR><BR><BR><BR>
							
							<div id="qrcode" ></div>
									<script type="text/javascript">
									var kod="<?=$qrurl?>";
										var qrcode = new QRCode(document.getElementById("qrcode"), {
										text : ("http://getresults.isaacloud.com/kitchen/"+kod),
										width : 180,
										height : 180
											});
										makeCode(); 
									</script></center><BR><BR>
					
						
						</div>
						
				
						<div class="col-md-4">	
							<p class="bg-info" style="text-align:center"><font size="6pt">Meeting Room</font></p><br>
							<center><button class="btn btn-primary" style="width:120px"><a href="./meetingroom"><font color="white">Open</font></a></button>
							<BR><BR><BR><BR>
							
							<div id="qrcode1" ></div>
									<script type="text/javascript">
									var kod="<?=$qrurl?>";
										var qrcode = new QRCode(document.getElementById("qrcode1"), {
										text : ("http://getresults.isaacloud.com/meetingroom/"+kod),
										width : 180,
										height : 180
											});
										makeCode(); 
									</script></center><BR><BR>
						</div>
						
					
						<div class="col-md-4">
							<p class="bg-info" style="text-align:center"><font size="6pt">Restaurant</font></p><br>
						 	<center><button class="btn btn-primary" style="width:120px"><a href="./restaurant"><font color="white">Open</font></a></button>
							<BR><BR><BR><BR>
							
							<div id="qrcode2" ></div>
									<script type="text/javascript">
									var kod="<?=$qrurl?>";
										var qrcode = new QRCode(document.getElementById("qrcode2"), {
										text : ("http://getresults.isaacloud.com/restaurant/"+kod),
										width : 180,
										height : 180
											});
										makeCode(); 
									</script></center><BR><BR>
						<div>

				</div> </div></div> <br>
				
				
				
 
    				<div class="modal-body row">
    				
    					
    					
				 		<div class="col-md-4 col-md-offset-2" >
							<p class="bg-info" style="text-align:center"><font size="6pt">General</font></p><br>
							<center><button class="btn btn-primary" style="width:120px"><a href="./global"><font color="white">Open</font></a></button>
							<BR><BR><BR><BR>
							
							<div id="qrcode3" ></div>
									<script type="text/javascript">
									var kod="<?=$qrurl?>";
										var qrcode = new QRCode(document.getElementById("qrcode3"), {
										text : ("http://getresults.isaacloud.com/global/"+kod),
										width : 180,
										height : 180
											});
										makeCode(); 
									</script></center><BR><BR>
					
						
						</div>
						
				
						<div class="col-md-4">	
							<p class="bg-info" style="text-align:center"><font size="6pt">User Profile</font></p><br>
							<center><button class="btn btn-primary" style="width:120px"><a href="./user"><font color="white">Open</font></a></button>
							<BR><BR><BR><BR>
							
							
							
							<div id="qrcode4" ></div>
									<script type="text/javascript">
									var kod="<?=$profileqr?>";
									
										var qrcode = new QRCode(document.getElementById("qrcode4"), {
										text : ("http://"+kod+".getresults.isaacloud.com/"),
										width : 180,
										height : 180
											});
										makeCode(); 
									</script></center><BR><BR>
						</div>
						

				</div></div>   	