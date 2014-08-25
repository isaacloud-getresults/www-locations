<h1> WWW Apps </h1><br>
	
			
	
    				<div class="modal-body row">
    					<div class="col-md-6" >
				 		
				 			<div class="modal-body row">
    							<div class="col-md-5" >
				 					<div id="qrcode1" ></div>
										<script type="text/javascript">
											var kod="<?=$qrurl?>";
											var qrcode = new QRCode(document.getElementById("qrcode1"), {
												text : ("http://getresults.isaacloud.com/global/"+kod),
												width : 160,
												height : 160
												});
											makeCode(); 
										</script>
								
								</div>
							
				 				<div class="col-md-7" >
				 					<p class="bg-info" style="text-align:center"><font size="6pt">General</font></p><br>
									<center><a href="./global"><button class="btn btn-primary" style="width:120px"><font color="white" size="4pt">Open</font></button></a></center>
								</div>
							</div>
						</div>
						
				
						<div class="col-md-6">	
						
							<div class="modal-body row">
    							<div class="col-md-5" >
    								<div id="qrcode2" ></div>
										<script type="text/javascript">
											var kod="<?=$profileqr?>";
											var qrcode = new QRCode(document.getElementById("qrcode2"), {
												text : ("http://"+kod+".getresults.isaacloud.com/"),
												width : 160,
												height : 160
												});
											makeCode(); 
										</script>
										
								</div>
							
				 				<div class="col-md-7" >
									<p class="bg-info" style="text-align:center"><font size="6pt">User Profile</font></p><br>
									<center><a href="./user"><button class="btn btn-primary" style="width:120px"><font color="white" size="4pt">Open</font></button></a></center>
							</div>
						</div>
					</div>
				</div>	
			
			<center><br><h2> Rooms: </h2></center>
				<?php 	if(empty($rooms)) echo "<center>Empty</center>";
						else { ?>
				<div class="modal-body row">
    				
			    		<?php $i=4; foreach ($rooms as $room): ?>

						<div class="col-md-3" >
					
                          <p class="bg-info" style="text-align:center"><font size="4pt"><?php echo $room["label"]; 
                          $room_id=$room["id"];?></a></font></p><br>
                          
                          <center><a href="./room<?php echo $room["id"];?>"><button class="btn btn-primary" style="width:120px"><font color="white">Open</font></button></a>
							<BR><br>
                          
                          
                    			<?php echo "<div id=\"qrcode".$i."\" ></div>"; ?>
									<script type="text/javascript">
									var kod="<?=$qrurl?>";
									var id="<?=$room_id?>";
									var i="<?=$i?>";
										var qrcode = new QRCode(document.getElementById("qrcode"+i), {
										text : ("http://getresults.isaacloud.com/room"+id+"/"+kod),
										width : 160,
										height : 160
											});
										makeCode(); 
									</script></center>
					
                    <?php 
                     $i++; 
                    if(!($i % 4))
                    	echo "</div></div><br>";
                    else 
                    	echo "</div>";
                    endforeach; } ?> 
                    	
                    	
			
		</div></div><br>	