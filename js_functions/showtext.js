	 	
	 	var jArr= <?php echo json_encode($_SESSION['feed']); ?>; //pass array from php to javascipt
  		var jArray = jArr.slice(6);
  		var item=jArray.reverse();

  
		function showtext(){
		
		
			var i=1;
			for(i;i<7;i++){
			//delete the last element from array and display it
				var opp=item.pop();
				if (item.pop()) 
					document.getElementById("textarea"+i).innerHTML = ("<p style=\"text-align:right\">"+opp['ago']+"</p>"+"<p><span class=\"glyphicon glyphicon-user\"></span><strong>" + opp['name']+"</strong>"+" "+opp['message']+"<br />"+opp['time']+"</p>"+"<hr/>");
				else { 
					alert ("No more notifications!");
					break;
					}
				}

			}