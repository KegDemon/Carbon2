<?php

#member = 2

switch($_GET['function']){

	case NULL:
	
		echo "
		
			<table border='0' cellpadding='1' cellspacing='1' class='admin_panel' width='100%'>
			
				<tr>
				
					<td align='center' valign='middle'>
		
						<a href='?page=admin&function=site' class='admin_panel'><strong>Site Configuration</strong></a>
						
					</td>									
					<td align='center' valign='middle'>
					
						 <a href='?page=admin&function=module' class='admin_panel'><strong>Module Manager</strong></a>
						 
					</td>
					
				</tr>
				
				";
					
		$dir			=	"./pages/prefs/";
		
		$count_glob		=	glob("$dir*_prefs.php");
		
		$count_glob2	=	count($count_glob);
		
		$rows	=	0;
		
		$limit	=	0;
		
		for ( $i = 0; $i < $count_glob2; ) {
		
			$rows++;
			
			echo "<tr>\n\n";
			
			$limit	=	$i + 2;
			
			for ( ; $i < $limit; $i++ ){
			
				if (!isset($count_glob[$i])) {
                	
                	break;
            	
            	}
            	
            	#var_dump($count_glob);
            	
            	$page	=	$count_glob[$i];
            	
            	$link	=	$page;
            	
            	$link	=	str_replace(".php", "", $link);
            	$link	=	str_replace("./pages/prefs/", "", $link);
            	
            	$page	=	str_replace(".php", "", $page);
            	$page	=	str_replace("./pages/prefs/", "", $page);
            	$page	=	str_replace("_", " ", $page);
           
           
           		$page	=	str_replace("prefs", "options", $page); 	
            	$page	=	ucwords($page);
           
            	echo "<td valign='middle' align='center'> 
            	
            			<a href='?page=admin&function=pref&pref=$link'><strong>$page</strong></a>
            		
            		</td> \n\n";
            
			}
			
			echo "\n\n</tr>\n\n";
					
		}
		
		
		echo "
		
			</table>
		
		";
		
		#end main display -> moving on to lower which displays actual pref file
			
	break;
	
	case "pref":
	
		$pref		=	$_GET['pref'];
		
		$pref_file	=	"./pages/prefs/$pref.php";
		
		if ( $pref	!=	NULL && is_file($pref_file) ){
		
			include($pref_file);
		
		} else {
		
			echo "<center>Error: The page you've requested could not be found</center>";
		
		}
	
	break;
	
	case "site":
	
		if ($_POST){
		
			$title				=	strip_tags($_POST['site_title']);
			$name				=	$_POST['site_name'];
			$welcome			=	$_POST['welcome'];
			$login_time			=	$_POST['login_time'];
			$date_format		=	$_POST['date_format'];
			$template			=	$_POST['template'];
			$user_active		=	$_POST['active'];
			$min_pass			=	$_POST['min_pass'];
			$min_user			=	$_POST['min_user'];
			$user_reg			=	$_POST['user_reg'];
			$front_page			=	$_POST['front_page'];
			$sig_length			=	$_POST['sig_length'];
			
			$update				=	array(
			'title'				=>	$title,
			'name'				=>	$name,
			'welcome'			=>	$welcome,
			'template'			=>	$template,
			'front_page'		=>	$front_page,
			'user_reg'			=>	$user_reg,
			'user_active'		=>	$user_active,
			'login_time'		=>	$login_time,
			'date_format'		=>	$date_format,
			'min_pass_length'	=>	$min_pass,
			'min_user_length'	=>	$min_user,
			'sig_length'		=>	$sig_length,
			);
			
			if(!$sql->update(array(
				'db'		=> $database,
				'table' 	=> 'config',
				'where'		=> array('id = 1'),
				'values'	=> $update,
			)))
			{
			
				 die('An error occurred, txtSQL said: '.$sql->get_last_error());
			
			}
			
			echo "<center>Site configuration has been updated. <br /> \n Click <a href='?page=admin'><u>here</u></a> to return to admin page or <a href='?page=admin&function=site'><u>here</u></a> to return to Site Configuration.</center>";
		
		} else {
	
			echo "
			
				<a href='?page=admin'> <strong> Back </strong> </a> \n <br /> <br /> \n
			
				<form action='?page=admin&function=site' method='post'>
			
				<table border='0' cellpadding='0' cellspacing='1' width='100%'>
				
					<tr>
		
						<td colspan='2'>

							<strong>Site</strong>
							
						</td>
						
					</tr>
				
					<tr>
		
						<td width='175px'>

							Title:
							
						</td>
						
						<td>
						
							<input type='text' name='site_title' class='login_box' value='".carbon::config(title, 0)."'>
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Name:
							
						</td>
						
						<td>
						
							<input type='text' name='site_name' class='login_box' value='".carbon::config(name, 0)."'>
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Welcome Message:
							
						</td>
						
						<td>
						
							<input type='text' name='welcome' class='login_box' value='".carbon::config(welcome, 0)."'>
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Login Time (in seconds):
							
						</td>
						
						<td>
						
							<input type='text' name='login_time' class='login_box' value='".carbon::config(login_time, 0)."'>
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Date Format:
							
						</td>
						
						<td>
						
							<input type='text' name='date_format' class='login_box' value='".carbon::config(date_format, 0)."'>
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Template:
							
						</td>
						
						<td>
						
							<select name='template' style='width:100%;'>
							
							";
							
								$dir	=	"./template/";
							
								if (is_dir($dir)) {
								
									if ($dh = opendir($dir)) {
								
										while (($file = readdir($dh)) !== false) {
								
											if ( $file != '.' && $file != '..' && $file != '.DS_Store'){
											
												if ( carbon::config(template, 0) == $file ) {
												
													echo "<option value='$file' selected='selected'> $file </option>\n";
												
												} else {
											
													echo "<option value='$file'> $file </option>\n";
													
												}
											
											}
								
										}
								
									closedir($dh);
								
									}
								
								}
							
							echo "</select>
						
						</td>
						
					</tr>
					
					<tr>
					
						<td>
						
							Front Page:	
						
						</td>
						
						<td>
						
							<select name='front_page' style='width:100%;'> \n";
							
							
								$front_grab	=	$sql->select(array('db' => $database, 'table' => 'module', 'where' => array('active = 2'), 'orderby' => array('mod_name', 'ASC')));
								
								foreach ( $front_grab as $key => $front ) {
								
									$mod	=	$front['mod_name'];
									
									$mod2	=	str_replace("_", " ", $mod);
									
									$mod2	=	ucwords($mod2);
								
									if ( carbon::config('front_page', 0) == $mod ){
									
										echo "<option value='$mod' selected='selected'>$mod2</option>\n";
									
									} else {
								
										echo "<option value='$mod'>$mod2</option>\n";
										
									}
								
								}
								
							
							echo " </select>
						
						</td>
					
					</tr>
					
					<tr>
		
						<td colspan='2'>

							<br />
						
							<strong>Registration</strong>
							
						</td>
											
					</tr>
					
					<tr>
		
						<td width='175px'>

							Registration:
							
						</td>
						
						<td>
						
							Enabled <input type='radio' name='user_reg' value='1' "; if ( carbon::config(user_reg, 0) == 1){ echo 'checked'; } echo ">
							Disabled <input type='radio' name='user_reg' value='0' "; if ( carbon::config(user_reg, 0) == 0){ echo 'checked'; } echo ">
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Activation Required:
							
						</td>
						
						<td>
						
							Yes <input type='radio' name='active' value='1' "; if ( carbon::config(active, 0) == 1){ echo 'checked'; } echo ">
							No <input type='radio' name='active' value='0' "; if ( carbon::config(active, 0) == 0){ echo 'checked'; } echo ">
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Min. Password Length:
							
						</td>
						
						<td>
						
							<input type='text' name='min_pass' class='login_box' value='".carbon::config(min_pass_length, 0)."'>
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Min. Username Length:
							
						</td>
						
						<td>
						
							<input type='text' name='min_user' class='login_box' value='".carbon::config(min_user_length, 0)."'>
						
						</td>
						
					</tr>
										
					<tr>
					
						<td>
						
							<br /> \n
						
							<strong>Misc.</strong>
							
						</td>
						
					</tr>
					
					<tr>
					
						<td>
						
							Maximum Signature Length:
						
						</td>
						
						<td>
						
							<input type='text' name='sig_length' class='login_box' value='". carbon::config(sig_length, 0) ."'>
						
						</td>
						
					</tr>
				
					<tr>
					
						<td colspan='2' align='center'>
						
							<br />
						
							<input type='submit' name='submit' value='Update' class='submit'>
						
						</td>
						
					</tr>
					
				</table>
			
			</form>
			
			";
			
		}
	
	break;
	
	case "module":
	
		echo "<a href='?page=admin'><strong>Back</strong></a> \n <br /> <br /> \n";
	
		/*********/
		
		if ( $_GET['deactivate'] != NULL ) {
		
			$sql->update(array('db' => $database, 'table' => 'module', 'where' => array('id = ' . $_GET['deactivate']), 'values' => array('active' => '1')));
			
			$sql->delete(array('db' => $database, 'table' => 'nav', 'where' => array('id = ' . $_GET['deactivate'])));
			
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=admin&function=module">';
		
		} elseif ( $_GET['activate'] != NULL ) {
		
			$sql->update(array('db' => $database, 'table' => 'module', 'where' => array('id = ' . $_GET['activate']), 'values' => array('active' => '2')));
			
			$grab	=	$sql->select(array('db' => $database, 'table' => 'module', 'where' => array('id = ' . $_GET['activate'])));
			
			$mod_name	=	$grab[0]['mod_name'];
			
			$mod_page	=	$mod_name . ".php";
			
			$mod_short	=	$mod_name;
			
			$ins1	=	array(
			
				'name'	=>	$mod_name,
				'page'	=>	$mod_page,
				'short_url'	=>	$mod_short,
			
			);
			
			if ( !$sql->insert(array(
					'db'     	=> $database,
					'table'  	=> 'nav',
					'values' 	=> $ins1) ) )
				{
				   die('Unable to add link to Database');
				}
			
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=admin&function=module">';
		
		} elseif ( $_GET['uninstall'] != NULL) {
	
			$grab	=	$sql->select(array('db' => $database, 'table' => 'module', 'where' => array('id = ' . $_GET['uninstall'])));
	
			$del	=	$grab[0]['mod_name'];
	
			$sql->delete(array('db' => $database, 'table' => 'module', 'where' => array('id = ' . $_GET['uninstall'])));
			
			$sql->delete(array('db' => $database, 'table' => 'nav', 'where' => array('name = ' . $del)));
			
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=admin&function=module">';
		
		} else {
	
		$dir	=	'./pages';
		
		$mod_list_a	=	$sql->select(array('db' => $database, 'table' => 'module', 'where' => array('active = 1', 'OR', 'active = 2'), 'orderby' => array('active', 'ASC')));
		
		$mod_counter	=	count($mod_list_a);
	
		echo "<em> <u> Modules Installed ( $mod_counter )</u> </em> \n <br />";
		
		$mod_list_a	=	$sql->select(array('db' => $database, 'table' => 'module', 'where' => array('active = 1', 'OR', 'active = 2'), 'orderby' => array('active', 'ASC')));
		
		foreach($mod_list_a as $key => $module){
		
			$module_name	=	$module['mod_name'];
			$module_active	=	$module['active'];
			$module_id		=	$module['id'];
			
			
			
			switch ( $module_active ) {
			
				case '3':
				
					$module_active	=	"Core Module";
				
				break;
				
				case '2':
				
					$module_active	=	"<a href='?page=admin&function=module&deactivate=$module_id'>Deactivate</a>";
				
				break;
				
				case '1':
				
					$module_active	=	"<a href='?page=admin&function=module&activate=$module_id'>Activate</a>";
				
				break;
			
			}
			
			$module_name	=	str_replace("_"," ", $module_name);
			$module_name	=	ucwords($module_name);
			
			echo "[ $module_active / <a href='?page=admin&function=module&uninstall=$module_id'> Uninstall</a> ] " . $module_name . "\n <br /> \n";
		
		}
		
		$mod_list_c	=	$sql->select(array('db' => $database, 'table' => 'module', 'where' => array('active = 3'), 'orderby' => array('mod_name', 'ASC')));
		
		$mod_counter_c	=	count($mod_list_c);
		
		echo " \n <br /> \n <em> <u> Core Modules Installed ( $mod_counter_c )</u> </em> \n <br />";
			
		foreach ( $mod_list_c as $key => $modu ){
		
			$core_name	=	$modu['mod_name'];
			
			$core_name	=	str_replace("_"," ", $core_name);
			$core_name	=	ucwords($core_name);
			
			echo $core_name . " \n <br /> \n";
		
		}
		
		}
		
		/**********************/
		
		
		echo "\n <br /> \n <em> <u> Modules Not Installed</u> </em> \n <br />";
	
		if ( $_GET['install'] != NULL ){
		
			$mod_name	=	$_GET['install'];
		
			$ins	=	array(
			'mod_name'	=> $mod_name,
			);
				
			if ( !$sql->insert(array(
					'db'     	=> $database,
					'table'  	=> 'module',
					'values' 	=> $ins) ) )
				{
				   die('Unable to add Module to Database');
				}
				
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=admin&function=module">';
			
		} else {
	
	
		if ( is_dir($dir) ) {
		
			if ( $dh = opendir($dir) ) {
			
				while (($file = readdir($dh)) !== false) {
				 
					if ( $file != '.' && $file != '..' && $file != '.DS_Store' && $file != 'admin.php' && $file != 'index.php' && $file != 'userpage.php' && $file != 'comment_handler.php' && $file != 'gallery' && $file != 'login.php' && $file != 'logout.php' && $file != 'register.php' && $file != 'prefs') {
					
						$file	=	str_replace(".php", "", $file);
						
						$check	=	$sql->select(array('db' => $database, 'table' => 'module', 'where' => array('mod_name = ' . $file)));
						
						if ( !$check ){
							
							$file2	=	$file;
							
							$file2	=	str_replace("_"," ",$file2);
							$file2	=	ucwords($file2);
						
							echo "[ <a href='?page=admin&function=module&install=$file'>Install</a> ] " . $file2 . "\n <br /> \n";
							
						}
					
					}
				
				}
				
				closedir($dh);
			
			}
		
		}
		
		}
	
	break;

}

?>