<html>

	<head>
	
		<title> <?php carbon::config("title", 1); ?> </title>
		
		<link rel="stylesheet" type="text/css" href="./template/<?php carbon::config("template", 1); ?>/style.css">
		
	</head>
	
	<body>
	
		<table border='0' cellpadding='0' cellspacing='0' width='760px' align='center'>
		
			<tr>
			
				<td>
				
					<img src='./template/<?php carbon::config("template", 1); ?>/images/top-left.gif'>
					
				</td>
				
				<td>
				
					<img src='./template/<?php carbon::config("template",1); ?>/images/top.gif'>
					
				</td>
				
				<td>
				
					<img src='./template/<?php carbon::config("template", 1); ?>/images/top-right.gif'>
					
				</td>
				
			</tr>
			
			<tr>
			
				<td valign='top'>
				
					<img src='./template/<?php carbon::config("template", 1); ?>/images/left.gif'>
					
				</td>
				
				<td>
				
					<table border='0' cellpadding='0' cellspacing='0' width='100%'>
					
						<tr>
						
							<td id='header' colspan='4' height='75px'>
							
							<?php carbon::config("name", 1); ?>
								
							</td>
							
						</tr>
						
						<tr>
						
							<td>
							
								<img src='./template/<?php carbon::config("template", 1); ?>/images/nav-left.gif' width='' height=''>
							
							</td>
							
							<td style='background-color: #1a1a1a;' width='470px'>
							
								<?php carbon::navagation(1); ?>
							
							</td>
							
							<td style='background-color: #1a1a1a; text-align: right; color: #3364c6' width='250px'>
							
								<?php carbon::loggedin(1); ?>
							
							</td>
							
							<td>
							
								<img src='./template/<?php carbon::config("template", 1); ?>/images/nav-right.gif' width='' height=''>
							
							</td>
						
						</tr>
						
					</table>
					
				</td>
			
				<td valign="top">
					
					<img src='./template/<?php carbon::config("template", 1); ?>/images/right.gif'>
					
				</td>
								
			</tr>
			
			<tr>
			
				<td>
				
				</td>
				
				<td>
				
					<br>
				
				<!-- middle -->
				