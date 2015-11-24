<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>

	<title><?php carbon::config(title,1); ?></title>
  
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

	<!-- **** layout stylesheet **** -->
	<link rel="stylesheet" type="text/css" href="./template/<?php carbon::config(template,1); ?>/style.css" />

	<!-- **** colour scheme stylesheet **** -->
	<link rel="stylesheet" type="text/css" href="./template/<?php carbon::config(template,1); ?>/colour.css" />

</head>

<body>
 
	<div id="main">
    
		<div id="header">
      
			<div id="logo">
			
				<h1><?php carbon::config(name, 1); ?></h1>
			
			</div>
   
   </div>

	<div id="menu">
     
		<!-- rounded corners - top **** -->
    
		<div class="rtop"><div class="r1"></div><div class="r2"></div><div class="r3"></div><div class="r4"></div></div>
    
    		
    
			<?php carbon::navagation(1);?>

			
     
		<!-- rounded corners - bottom **** -->
     
		<div class="rbottom"><div class="r4"></div><div class="r3"></div><div class="r2"></div><div class="r1"></div></div>
   
	</div>
    
	<div class="sidebar">
	
		<div class="sidebaritem">
       
			<!-- rounded corners - top **** -->
	        <div class="rtop"><div class="r1"></div><div class="r2"></div><div class="r3"></div><div class="r4"></div></div>

			<?php if ( carbon::logged() == FALSE ){ echo "<center><strong>Controls</strong></center>"; } else { echo "<center><strong>Welcome " . carbon::username(0) . "</strong></center>"; } ?>
			
			<br />
			
			<?php carbon::loggedin(0); ?>
			
	        <!-- rounded corners - bottom **** -->
	        <div class="rbottom"><div class="r4"></div><div class="r3"></div><div class="r2"></div><div class="r1"></div></div>
      
		</div>
     
		<div class="sidebaritem">
       
			<!-- rounded corners - top **** -->
	        <div class="rtop"><div class="r1"></div><div class="r2"></div><div class="r3"></div><div class="r4"></div></div>

			<center><strong>News Headlines</strong></center>
			
			<br />
			
			<?php carbon::news_feed(1); ?>
			
	        <!-- rounded corners - bottom **** -->
	        <div class="rbottom"><div class="r4"></div><div class="r3"></div><div class="r2"></div><div class="r1"></div></div>
      
		</div>
   
	</div>
	
    <div id="content">
	
	