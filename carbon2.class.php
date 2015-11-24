<?php

//error_reporting(E_ALL);

require_once("db.php");

if (!function_exists('str_ireplace')) {
   function str_ireplace($needle, $str, $haystack) {
       $needle = preg_quote($needle, '/');
       return preg_replace("/$needle/i", $str,      $haystack);
   }
}

ob_start();

class carbon {

var	$date_format;
var $_template;

		
	function config($action, $return){

		global $sql; global $database;
	
		if ( $action != NULL ) {
		
			$config	=	$sql->select(array('db' => $database, 'table' => 'config', 'limit' => array(0)));
		
			$config	=	$config[0];
			
			$title				=	$config['title'];
			$name				=	$config['name'];
			$install			=	$config['install_date'];
			$date_f				=	$config['date_format'];
			$welcome			=	$config['welcome'];
			$temp				=	$config['template'];
			$news_comments		=	$config['news_comments'];
			$news_comments_logged	=	$config['news_comments_loggedin'];
			$user_reg			=	$config['user_reg'];
			$user_active		=	$config['user_active'];
			$min_pass_length	=	$config['min_pass_length'];
			$min_user_length	=	$config['min_user_length'];
			$login_time			=	$config['login_time'];
			$front_page			=	$config['front_page'];
			$sig_length			=	$config['sig_length'];
			
			$this->date_format	=	$date_f;
			$this->_template	=	$temp;
			
		}
		
		switch ( $action ) {
		
			case NULL:
			
				echo "Error: No call defined.";
			
			break;
			
			case "title":
			
				switch ( $return ) {
				
					case 1:
			
						echo $title;
					
					break;
					
					case 0:
					
						return $title;
					
					break;
				
				}
			
			break;
			
			case "welcome":
			
				switch ( $return ){
				
					case 1:
			
						echo $welcome;
						
					break;
					
					case 0:
					
						return $welcome;
						
					break;
					
				}
			
			break;
			
			case "name":
			
				switch ( $return ){
				
					case 1:
			
						echo $name;
						
					break;
					
					case 0:
					
						return $name;
						
					break;
					
				}
			
			break;
			
			case "template":
			
				switch ( $return ) {
				
					case 1:
			
						echo $temp;
			
					break;
					
					case 0:
					
						return $temp;
			
					break;
					
				}
			
			break;
			
			case "date_format":
			
				switch ( $return ) {
				
					case 1:
								
						echo $date_f;
			
					break;
					
					case 0:
					
						return $date_f;
						
					break;
				
				}
			
			break;
			
			case "comments":
			
				return $news_comments;
			
			break;
			
			case "news_comments_logged":
			
				switch($return){
			
					case 1:
					
						echo $news_comments_logged;
						
					break;
				
					case 0:
				
						return $news_comments_logged;
						
					break;
					
				}
				
			break;
			
			case "install":
			
				echo date($date_f, $install);
			
			break;
			
			case "active":
			
				switch($return){
			
					case 1:
					
						echo $user_active;
						
					break;
				
					case 0:
				
						return $user_active;
						
					break;
					
				}
				
			break;
			
			case "user_reg":
			
				switch ( $return ) {
				
					case 1:
					
						echo $user_reg;
						
					break;
					
					case 0:
					
						return $user_reg;
						
					break;
				
				}
			
			break;
			
			case "min_pass_length":
			
				switch ( $return ) {
				
					case 1:
					
						echo $min_pass_length;
						
					break;
					
					case 0:
					
						return $min_pass_length;
						
					break;
					
				}
				
			break;
			
			case "min_user_length":
			
				switch ( $return ) {
				
					case 1:
					
						echo $min_user_length;
						
					break;
					
					case 0:
					
						return $min_user_length;
						
					break;
					
				}
				
			break;
			
			case "login_time":
			
				switch ( $return) {
			
					case 1:
					
						echo $login_time;
						
					break;
					
					case 0:
					
						return $login_time;
						
					break;
					
				}
			
			break;
			
			case "front_page":
			
				switch ( $return ){
				
					case 1:
					
						echo $front_page;
						
					break;
					
					case 0:
					
						return $front_page;
						
					break;
				
				}
			
			break;
			
			case "sig_length":
			
				switch ( $return ) {
				
					case 1:
				
						echo $sig_length;
					
					break;
				
					case 0:
				
						return $sig_length;
					
					break;
				
				}
			
			break;
			
			case "dump":
			
				echo "<p>";
			
					print_r($config);
				
				echo "</p>";
			
			break;
		
		}

	
	}
	
	function login($username, $password){
	
		global $sql; global $database;
	
		if ( $username == NULL ){
		
			echo "Error: No username entered.";
		
		} elseif ( $password == NULL ) {
		
			echo "Error: No password entered.";
		
		} elseif ( $username && $password != NULL ) {
		
			$username	=	strtolower($username);
		
			$password	=	md5($password);
		
			$check	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('username = ' . $username)));
		
			if ( $check != NULL && $password == $check[0]['password'] && $check[0]['rank'] != '0') {
			
				if ( $check[0]['active'] == "1" ) {
			
					$uid	=	$check[0]['id'];
				
					setcookie("user", $uid, time() + carbon::config(login_time, 0) );
					
					echo "<center>You've been logged in. Click <a href='./'>Here</a> to continue.</center>";
					
				} else {
				
					echo "<center>Error: User has not been activated by an admin.</center>";
				
				}
			
			} else {
			
				if ( $check[0]['rank'] == 0 ){
				
					echo "<center>Error: This user has been banned.</center>";
				
				} else {
			
					echo "<center>Error: Invalid information entered.</center>";
					
				}
			
			}
		
		} else {
		
			echo "<center>Error: Something is completely wrong.</center>";
		
		}
	
	}
	
	function logout() {
	
		setcookie("user", "", time() - carbon::config(login_time, 0));
		
		echo "<center>You have logged out.</center>";
		
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=?page=">';
	
	}
	
	function navagation($return, $linebreaks){
	
		global $sql; global $database;
	
		$nav	=	$sql->select(array('db' => $database, 'table' => 'nav', 'orderby' => array('order_id', 'ASC')));
		
		foreach($nav as $key => $nav){
		
			$id			=	$nav['id'];
			$name		=	$nav['name'];
			$short_url	=	$nav['short_url'];
			$page		=	$nav['page'];

			$name	=	str_replace("_", " ", $name);
			$name	=	ucwords($name);
			
			switch ( $return ) {
				
				case 0:
				
					switch ($linebreaks){
				
						case 0:
						echo "<a href='?page=$short_url' class='link_nav'>$name</a> \n <br>";
						break;
					
						case 1:
						echo "<a href='?page=$short_url' class='link_nav'>$name</a> ";
						break;		
					}
				
				break;
		
				case 1:
				
					switch ($linebreaks){
					
						case 0:
						return "<a href='?page=$short_url' class='link_nav'>$name</a> \n <br>";
						break;
					
						case 1:
						return "<a href='?page=$short_url' class='link_nav'>$name</a> ";
						break;
					
					}
				
				break;
			
			}
			
		}
	
	} #end navagation function
	
	function message_count(){
	
		global $sql; global $database;
		
		$cookie	=	$_COOKIE['user'];
		
		$thing	=	$sql->select(array('db' => $database, 'table' => 'messages', 'where' => array('rec_id = ' . $cookie, 'AND', 'read = 0')));
		
		$count	=	count($thing);
		
		if ( $count == NULL ) {
		
			$count = 0;
		
		}
		
		if ( carbon::rank() > 1 ){
		
			$admin_activation	=	$sql->select(array('db' => $datbase, 'table' => 'users', 'where' => array('active = 0')));
		
			$ad_count	=	count($admin_activation);
		
		}
		
		$count	=	$count + $ad_count;
	
		$contents = "$count New message(s)";
		
		return $contents;
	
	}
	
	function admin_activation(){
	
		global $sql;
		global $database;
	
		if ( carbon::rank() > 1 ){
		
			$activation	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('active = 0')));
				
			#var_export($activation);
			
			echo "<strong> Users requiring activation: </strong> <br /> \n\n";
			
			if ( !$activation == NULL ){
				
				foreach ( $activation as $key => $active ) {
				
					$user_id	=	$active['id'];

					$user	=	$active['username_f'];
					
					echo "[ <a href='?page=message_center&activate=$user_id'>Activate</a> ] $user \n <br /> \n";
				
				}
			
			} else {
			
				echo "No users require activation \n <br /> \n";
			
			}
			
			if ( !$_GET['activate'] == NULL ){
			
				$uid	=	$_GET['activate'];
			
				$sql->update(array('db' => $database, 'table' => 'users', 'where' => array('id = ' . $uid), 'values' => array('active' => '1')));
				
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=message_center">';
			
			}
			
			echo "\n <br /> \n";
			
		}
	
	}
	
	function message_center_fetch($switch) {
	
		global $sql; 
		global $database;
		
		switch($switch) {
		
		case 1:
		
			$fetch = $sql->select(array('db' => $database, 'table' => 'messages', 'where' => array('rec_id =' . $_COOKIE['user']), 'orderby' => array('date', 'DESC')));
		
			if ( $_GET['d'] != NULL ){
			
				if ( $fetch != NULL ){
				
					$sql->delete(array('db' => $database, 'table' => 'messages', 'where' => array('id = ' . $_GET['d'])));
					
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=message_center">';
				
				}
			
			}
		
			foreach ( $fetch as $key => $fetch ) {
		
				$id	=	$fetch['id'];
				
				if ($fetch['read'] == 1){
				
					$subject	=	$fetch['subject'];
					
				} else {
				
					$subject	=	"* <em>" . $fetch['subject'] . "</em>";
				
				}
				
				$date	=	date($this->date_format, $fetch['date']);
			
				$sender	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('id =' . $fetch['sender_id'])));
			
				$sender	=	$sender[0]['username_f'];
			
				echo "
			
					<tr>
				
						<td>
					
							[ <a href='?page=message_center&d=$id'>X</a> ] <a href='?page=message_center&read=read&id=$id'> $subject </a>
						
						</td>
					
						<td>
					
							$sender
						
						</td>
					
						<td>
					
							$date
						
						</td>
					
					</tr>
			
				";
			
			}
			
		break;
		
		case 2:
		
			$fetch	=	$sql->select(array('db' => $database, 'table' => 'messages', 'where' => array('id = ' . $_GET['id'])));
		
			if ( $fetch[0]['rec_id'] != $_COOKIE['user'] ){
			
				echo "<center> Error: You are not able to view this message.</center>";
			
			} else {
		
				$id	=	$_GET['id'];
				
				$sql->update(array('db' => $database, 'table' => 'messages', 'where' => array('id = ' . $_GET['id']), 'values' => array('read' => '1')));
		
				echo "<a href='?page=message_center'> <strong> Back </strong> </a> | <a href='?page=message_center&read=reply&id=$id'> <strong >Reply </strong> </a> <br> <br> Subject: " . $fetch[0]['subject'] . " <br> Date: " . date($this->date_format, $fetch[0]['date']) . " <br> <div id='message_body'>" . $fetch[0]['body'] . "</div>";
			
			}
		
		break;
		
		case 3:
	
			$fetch	=	$sql->select(array('db' => $database, 'table' => 'messages', 'where' => array('id = ' . $_GET['id'])));
				
			$subject	=	$fetch[0]['subject'];
			$body		=	nl2br(stripslashes($fetch[0]['body']));
			$send		=	$fetch[0]['sender_id'];
			
			if ( $_POST ) {
			
				$sender		=	$_COOKIE['user'];
				$rec		=	$send;
				$sub		=	strip_tags(Stripslashes($_POST['subject']));
				$bod		=	stripslashes($_POST['body']);
				
				$send		=	array(
				
					'read'		=>	0,
					'sender_id'	=>	$sender,
					'rec_id'	=>	$rec,
					'subject'	=>	$sub,
					'body'		=>	$bod,
				
					);
				
					if ( !$sql->insert(array(
						'db'     	=> $database,
						'table'  	=> 'messages',
						'values' 	=> $send) ) )
					{
					   die('Unable to add new Link to Database');
					}
				
				echo "<center>Message Sent.</center>";
			
			} else {
			
				$body	=	strip_tags($body);
		
				echo "
				
					<form action='?page=message_center&read=reply&id=2' method='post'>
			
					<table border='0' cellpadding='0' cellspacing='1' width='100%'>
					
						<tr>
						
							<td width='100px'>
							
								Subject:
								
							</td>
							
							<td>
							
								<input type='text' name='subject' value='Re: $subject' class='login_box'>
								
							</td>
							
						</tr>
						
						<tr>
						
							<td width='100px' valign='top'>
							
								Body:
								
							</td>
							
							<td>
							
								<textarea class='textarea_full' name='body'>

---ORIGINAL MESSAGE---

$body</textarea>
								
							</td>
							
						</tr>
						
						<tr>
						
							<td colspan='2' align='center'>
							
								<input type='submit' value='Send Message' class='submit'>
								
							</td>
							
						</tr>
					
					</table>
					
					</form>
			
				";
				
			}
		
		break;
		
		case 4:
		
			if ( $_POST ) {
			
				$body		=	nl2br(stripslashes(strip_tags($_POST['body'])));
				$subject	=	strip_tags(stripslashes($_POST['subject']));
				$rec		=	$_POST['rec'];
				$sender		=	$_COOKIE['user'];
				$read		=	0;
				
				$send		=	array(
					'subject'	=>	$subject,
					'body'		=>	$body,
					'sender_id'	=>	$sender,
					'rec_id'	=>	$rec,
					'read'		=>	$read,
				);
				
				if ( !$sql->insert(array(
					'db'     	=> $database,
					'table'  	=> 'messages',
					'values' 	=> $send) ) )
				{
				   die('Unable to add news to Database');
				}
				
				echo "<center>Message Sent.</center>";
			
			} else {
		
			$user_list	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('active = 1'), 'orderby' => array('username', 'ASC')));
			
			echo "
			
				<form action='?page=message_center&read=write' method='post'>
			
				<table border='0' cellpadding='0' cellspacing='1' width='100%'>
				
					<tr>
					
						<td width='100px' valign='top'>
						
							Recipient:
						
						</td>
						
						<td>
						
							<select name='rec' style='width:100%;'> \n";
							
								foreach ( $user_list as $key => $list ) {
								
									$username	=	$list['username_f'];
									$u_id		=	$list['id'];
								
									echo "<option value='$u_id'>$username</option> \n";
								
								}
							
							echo "</select>
							
						</td>
						
					</tr>
					
					<tr>
					
						<td width='100px'>
						
							Subject:
							
						</td>
						
						<td>
						
							<input type='text' name='subject' class='login_box'>
							
						</td>
						
					</tr>
					
					<tr>
					
						<td width='100px' valign='top'>
						
							Body:
							
						</td>
						
						<td>
						
							<textarea name='body' class='textarea_full'></textarea>
							
						</td>
						
					</tr>
					
					<tr>
					
						<td colspan='2' align='center'>
						
							<input type='submit' value='Send Message' class='submit'>
							
						</td>
					
					</tr>
				
				</table>
				
				</form>
			
			";
			
			}
		
		break;
		
		}
	
	}
	
	function logged(){
	
		if ( $_COOKIE['user'] == NULL ) {
		
			return FALSE;
		
		} else {
	
			return TRUE;
			
		}
	
	}
	
	function username($word){
	
		global $sql; global $database;
		
		$username	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('id = ' . $_COOKIE['user'])));
		
		switch ( $word ) {
		
		case 1:
		 
			echo $username[0]['username_f'];
			
		break;
		
		case 0:
		
			return $username[0]['username_f'];
	
		break;
	
		}
		
	}
	
	function rank(){
		
		global $sql; global $database;
		
		$rank	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('id = ' . $_COOKIE['user'])));
		
		return $rank[0]['rank'];
	
	}
	
	function loggedin($linebreaks){
	
		global $sql; global $database;
	
		$logged_in	=	$_COOKIE['user'];

		if ( carbon::rank() > 1 && $logged_in == TRUE ){
		
			switch ( $linebreaks ) {
			
				case 0:
				
					$admin	=	"<a href='?page=admin'>Admin Page</a> \n <br /> \n";
				
				break;
				
				case 1:
				
					$admin	=	"<a href='?page=admin'>Admin Page</a> | ";
				
				break;
			
			}	
		
		}
		
		if ( $logged_in	== TRUE ){
		
			switch ( $linebreaks ) {
			
				case 0:
				echo "<a href='?page=message_center'>" . carbon::message_count() . "</a>  \n <br> \n $admin <a href='?page=userpage'>Userpage</a> \n <br> \n <a href='?page=logout'>Logout</a> \n <br> \n";
				break;
				
				case 1:
				echo "<a href='?page=message_center'> " . carbon::message_count() . " </a> | $admin <a href='?page=userpage'>Userpage</a> | <a href='?page=logout'>Logout</a>";
				break;
		
			}
		
		} else {
		
			switch ( $linebreaks ) {
			
				case 0:
				echo "<a href='?page=login'>Login</a> \n <br> \n <a href='?page=register'>Register</a> \n <br> \n";
				break;
				
				case 1:
				echo "<a href='?page=login'>Login</a> | <a href='?page=register'>Register</a> ";
				break;
		
			}
		
		}
		
	
	}
	
	function register($info){
	
		global $sql; global $database;
	
		$info	=	strip_tags($info);
	
		$info	=	explode(", ", $info);
		
		$username_f	=	$info[0];
		$username	=	$info[1];
		$password	=	$info[2];
		$password_2	=	$info[3];
		$email		=	$info[4];
		$security	=	$info[5];
		$answer		=	$info[6];
		$rank		=	"1";
		
		########################
		
		$username_f	=	str_replace(" ", "", $username_f);
		$username	=	str_replace(" ", "", $username);
		
		########################
		
		#	Check if username is already taken or e-mail is already used	#
		
		$user_check	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('username = ' . $username, 'OR', 'email = ' . $email)));
		
		########################
		
		$active		=	carbon::config("active", 0);
		
		if ( $active	==	"1" ){
		
			$active_message	=	"<center>An Admin must activate your account before you can log in.</center>";
			
		} elseif ( $active == "0" ) {
		
			$active_message =	"<center>Your account has been created! <br /> You may now log in from the <a href='?page=login'>Login</a> page.</center>";
		
		}
		
		########################
		
		if ( $username_f == NULL || $username == NULL || $password == NULL || $password_2 == NULL || $email == NULL || $security == NULL || $answer == NULL ) {
		
			echo("<center>Error: All form fields must be entered.</center>");
		
		} elseif ( $password != $password_2) {
		
			echo("<center>Error: Passwords do not match.</center>");
		
		} elseif ( $password == NULL || $password_2 == NULL ) {
		
			echo("<center>Error: Password field(s) are empty.</center>");
		
		} elseif (strlen($password) < carbon::config("min_pass_length", 0)) {
		
			echo("<center> Error: Password too short. Must be atleast ". carbon::config('min_pass_length', 0)." characters long. </center>");
		
		} elseif (strlen($username_f) < carbon::config("min_user_length", 0)) {
		
			echo("<center> Error: Username too short. Must be atleast ". carbon::config('min_user_length', 0)." characters long. </center>");
		
		} elseif (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) == FALSE){
		
			echo("<center>Error: Please enter a valid E-mail Address.</center>");
		
		} elseif ( $user_check[0]['username'] == $username ){
		
			echo("<center>Error: Username is already taken.</center>");
		
		} elseif ( $user_check[0]['email'] == $email ){
		
			echo("<center>Error: E-mail address is already taken.</center>");
		
		} else {
		
		######################## {
		
			$password	=	md5($password);
			
			if ( carbon::config("active", 0) == 0 ){
			
				$activel	=	1;
			
			} else {
			
				$activel	=	0;
			
			}
			
			$add_user = array(
                'username' 				=> $username,
                'username_f' 			=> $username_f,
				'password'				=> $password,
				'email'					=> $email,
				'security_q'			=> $security,
				'security_a'			=> $answer,
				'rank'					=> $rank,
				'active'				=> $activel,
				);

			if ( !$sql->insert(array(
				'db'     	=> $database,
				'table'  	=> 'users',
				'values' 	=> $add_user) ) )
			{
			   die('Unable to add user to Database');
			}
			
			echo $active_message ;
		
		}
		
		########################
	
	}
	
	function header(){
	
		global $sql; global $database;
		
		$title		=	carbon::config('title', 0);
		$welcome	=	carbon::config('welcome', 0);
		$name		=	carbon::config('name', 0);
		$template	=	carbon::config('template', 0);
		$nav1		=	carbon::navagation(1,1);
		$nav2		=	carbon::navagation(1,0);
	
		$something	=	$sql->select(array('db'	=>	$database, 'table'	=>	'config', 'where' => array('id = 1')));
		
		$template	=	$something[0]['template'];
		
		$temp	=	"./template/$template/_header.php";
		
		$open	=	fopen($temp, "r");
				
		$contents = fread($open, filesize($temp));
		
		$contents	=	str_ireplace('{TITLE}', $title, $contents);
		$contents	=	str_ireplace('{WELCOME}', $welcome, $contents);
		$contents	=	str_ireplace('{NAME}', $name, $contents);
		$contents	=	str_ireplace('{template}', $template, $contents);
		$contents	=	str_ireplace('{NAVAGATION,1}', $nav1, $contents);
		$contents	=	str_ireplace('{NAVAGATION,2}', $nav2, $contents);
		
		fclose($open);
		
		echo $contents;
		
		//include("./template/$template/_header.php");
	
	}
	
	function site() {
	
		global $sql; global $database;
		
		$page		=	$_GET['page'];
	
		$page_dir	=	'./pages/';
			
		if ( $page == NULL ){
		
			$page	=	carbon::config('front_page', 0);
		
		}

		$mods_installed	=	$sql->select(array('db' => $database, 'table' => 'module', 'where' => array('mod_name =' . $page)));
		
		if ( $mods_installed[0]['active'] == 1 ){
		
			echo "<center> Module is not currently active </center>";
		
		} else {
		
		if ( is_file($page_dir . $page . '.php') ) {
			
			$contents 	= 	file($page_dir . $page . '.php');
			
			$something	=	file_get_contents($page_dir . $page . '.php');
		
			$check	=	strpos($something, '#member = 1');
			$check2	=	strpos($something, '#member = 2');
		
			$check	=	$check + 10;
			$check2	=	$check2 + 10;
		
			if ( $something[$check] ==	'1') {
			
				if ( carbon::logged() == TRUE ) {
			
					include($page_dir . $page . '.php');
					
				} else {
				
					echo "<center>Error: You must be logged in to view this page</center>";
				
				}
				
			} elseif ( $something[$check2] ==	'2') {
								
				if ( carbon::rank() >= 2 && carbon::logged() == TRUE) {
				
					include($page_dir . $page . '.php');
				
				} else {
				
					echo "<center>Error: You must be an Admin to view this page</center>";
				
				}
				
				
			} else {
			
				if ( $mods_installed[0]['active'] == 2 OR  $mods_installed[0]['active'] == 3) {
			
					include($page_dir . $page . '.php');
				
				} else {
				
					echo "<center> An error has occured: The following page you've requested - <em>$page</em> - could not be found. </center>";
				
				}
				
			}
			
		} else {
		
			echo "<center> An error has occured: The following page you've requested - <em>$page</em> - could not be found. </center>";
		
		}
		
		}
	
	}
	
	function footer(){
	
		global $sql; global $database;
	
		$something	=	$sql->select(array('db'	=>	$database, 'table'	=>	'config'));
		
		$template	=	$something[0]['template'];
	
		include("./template/$template/_footer.php");
		
		//$sql->emptyCache();
	
	}
	
	function news_feed($vert){
	
		global $sql; global $database;
		
		$news_headlines	=	$sql->select(array('db' => $database, 'table' => 'news', 'orderby' => array('id', 'DESC')));
		
		foreach($news_headlines as $key => $headlines){
	
			$id	=	$headlines['id'];
			$date	=	date("[n / j]", $headlines['date']);
			
			$words	=	wordwrap($headlines['title'], 25, "...", TRUE);
			
			$words	=	explode("...",$words);
			
			switch ( $vert ) {
			
				case 0:
				
					echo "$date <a href='?page=news&id=$id'>" . $words[0] . "...</a>";
				
				break;
				
				case 1:
				
					echo "$date <a href='?page=news&id=$id'>" . $words[0] . "...</a><br />";
				
				break;
			
			
			}
	
		}
	
	}
	
			
	function version(){

		echo "Version 0.0.9 ALPHA";
	
	}
	
	function disconnect(){
	
		global $sql;
		global $database;
		
		$sql->disconnect();
	
	}

}

?>