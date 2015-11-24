<html>

	<head>
	
		<title> <?php carbon::config("title", 1); ?> </title>
		
		<link rel="stylesheet" type="text/css" href="./template/<?php carbon::config("template", 1); ?>/style.css">
		
	</head>
	
	<body>
	
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="760px">
		
			<tr>
			
				<td>
				
					<img src="./template/<?php carbon::config("template", 1); ?>/images/topleft.gif"  width="20" height="25">
					
				</td>
				
				<td style="background-image: url(./template/<?php carbon::config("template", 1); ?>/images/top.gif); width: 100%;">

				</td>
				
				<td>
				
					<img src="./template/<?php carbon::config("template", 1); ?>/images/topright.gif"  width="20" height="25">
					
				</td>
				
			</tr>
			
			<tr>
			
				<td valign="top" style="background-image: url(./template/<?php carbon::config("template", 1); ?>/images/left.gif); height: 100%;">
				
				</td>
				
				<td>
				
					<table border="0" cellpadding="0" cellspacing="0">
					
						<tr>
						
							<td id="header" valign="top">
							
								<a href='?page='><?php carbon::config("name", 1); ?></a>
							
							</td>
							
						</tr>
						
						<tr>
						
							<td colspan='2' id='welcome'>
							
								<?php carbon::config("welcome", 1); ?>
							
							<br>
							
							<br>
							
								<table border='0' cellpadding='0' cellspacing='0'>
								
									<tr>
				
										<td>
										
											<img src="./template/<?php carbon::config("template", 1); ?>/images/navbar-left-edge.gif" width="2" height="22">
										
										</td>
										
										<td width="470px" id="nav" valign="middle" style="background-image: url(./template/<?php carbon::config("template", 1); ?>/images/navbar-center.gif);">
		
											<?php carbon::navagation(1); ?>
		
										</td>
										
										<td width="250px" id="nav" align="right" valign="middle" style="background-image: url(./template/<?php carbon::config("template", 1); ?>/images/navbar-center.gif);">
		
											<?php carbon::loggedin(1); ?>
		
										</td>
										
										<td>
					
											<img src="./template/<?php carbon::config("template", 1); ?>/images/navbar-right-edge.gif" width="2" height="22">
									
										</td>
									
									</tr>
									
								</table>
							
							<br>
							
							</td>
							
						</tr>
						
					</table>
					
		<!--  middle -->