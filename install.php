<?php
	
	#Carbon2 Installer

	if (!$_POST){
	
		echo "Please create a user now:
		<form action='install.php' method='post'>
		Admin Username: <input type='text' name='admin_username'>
		<br />
		Admin Password: <input type='password' name='admin_password'>
		<br />
		Admin Password (again): <input type='password' name='admin_password2'>
		<br />
		<input type='submit' value='Start Install!'>
		</form>
		";
	
	} elseif($_POST) {
	
	if ( $_POST['admin_password'] != $_POST['admin_password2'] ) {
	
		die ("Error: Passwords don't match.");
	
	}
	
include('./txtSQL.class.php');

$db_username	=	"root";
$db_password	=	"feeble";
$database		=	"carbon";

//**************PLACE THE DATABASE IS STORED***********//

$sql = new txtSQL('./data/');  

//***********CONNECT TO DATABASE****************//

$sql->connect($db_username, $db_password) or die ('Unable to Connect To' . $database);

//**********CREATE THE DATABASE**************//

$sql->createdb(array('db' => $database)) or die('Error creating txtSQL DB, txtSQL said: '.$sql->get_last_error());

//**********SELECT DATABASE TO USE**************//

if ( !$sql->selectdb($database) )
{
    print ($database . 'Could not be selected, check to make sure it exists');
}

//****************CREATE TABLES IN DATABASE*****************//

$nav	=	array(
					'id'			=> array('type'	=> 'int', 'auto_increment' => 1),
					'name'			=> array('type' => 'string'),
					'page'			=> array('type' => 'string'),
					'short_url'		=> array('type' => 'string'),
					'order_id'		=> array('type'	=> 'int'),
					);
					
$sql->createtable(array(
						'db'		=>	$database,
						'table'		=>	'nav',
						'columns'	=>	$nav ) );

/*******************************************/

$nav = array(
			'name'					=> "News",
			'page'					=> "index.php",
			'short_url'				=> "news",
			);

if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'nav',
                        'values' 	=> $nav) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

/********************************************/
			
$con	=	array(
					'id'				=> array('type'	=> 'int', 'auto_increment' => 1),
					'title'				=> array('type' => 'string'),
					'name'				=> array('type' => 'string'),
					'welcome'			=> array('type' => 'string'),
					'template'			=> array('type' => 'string'),
					'front_page'		=> array('type' => 'string'),
					'date_format'		=> array('type' => 'string'),
					'news_comments'		=> array('type' => 'int'),
					'news_comments_loggedin'		=> array('type' => 'int'),
					'user_reg'			=> array('type' => 'int'),
					'user_active'		=> array('type' => 'int'),
					'min_pass_length'	=> array('type' => 'int'),					
					'min_user_length'	=> array('type' => 'int'),
					'login_time'		=> array('type' => 'int'),
					'install_date'		=> array('type' => 'date'),
					);
					
$sql->createtable(array(
						'db'		=>	$database,
						'table'		=>	'config',
						'columns'	=>	$con ) );

/*******************************************/

$con = array(
			'title'					=> "Carbon2 Alpha",
			'name'					=> "Carbon<sup>2</sup> Alpha",
			'welcome'				=> "Welcome to Carbon<sup>2</sup> Alpha",
			'date_format'			=> "M jS, Y @ G:i:s",
			'template'				=> "carbon",
			'front_page'			=> "news",
			'news_comments'			=> "1",
			'user_reg'				=> "1",
			'user_active'			=> "1",
			'login_time'			=> "3600",
			'min_pass_length'		=> "6",
			'min_user_length'		=> "4",
			);

if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'config',
                        'values' 	=> $con) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}						

/*******************************************/

$users	=	array(
					'id'			=> array('type'	=> 'int', 'auto_increment' => 1),
					'active'		=> array('type' => 'int'),
					'rank'			=> array('type' => 'int'),
					'username'		=> array('type' => 'string'),
					'username_f'	=> array('type' => 'string'),
					'password'		=> array('type' => 'string'),
					'email'			=> array('type' => 'string'),
					'show_email'	=> array('type' => 'int'),
					'avatar'		=> array('type' => 'string'),
					'security_q'	=> array('type' => 'string'),
					'security_a'	=> array('type' => 'string'),
					'date'			=> array('type' => 'date'),
										);
					
$sql->createtable(array(
						'db'		=>	$database,
						'table'		=>	'users',
						'columns'	=>	$users ) );
						

						
/*******************************************/

$usn	=	strtolower($_POST['admin_username']);
$psw	=	md5($_POST['admin_password']);

$us	=	array(
			'username_f'			=> $_POST['admin_username'],
			'username'				=> $usn,
			'password'				=> $psw,
			'active'				=> "1",
			'rank'					=> "2",
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'users',
                        'values' 	=> $us) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}	

/*******************************************/

$messages	=	array(
					'id'				=> array('type'	=> 'int', 'auto_increment' => 1),
					'install_date'		=> array('type' => 'date'),
					'read'				=> array('type' => 'int', 'default' => 0),
					'sender_id'			=> array('type' => 'int'),
					'rec_id'			=> array('type' => 'int'),
					'subject'			=> array('type' => 'string'),
					'body'				=> array('type' => 'text'),
					);
					
$sql->createtable(array(
						'db'		=>	$database,
						'table'		=>	'messages',
						'columns'	=>	$messages ) );	

/*******************************************/

$news	=	array(
					'id'			=> array('type'	=> 'int', 'auto_increment' => 1),
					'user_id'		=> array('type' => 'int'),
					'title'			=> array('type' => 'string'),
					'description'	=> array('type' => 'text'),
					'body'			=> array('type' => 'text'),
					'comments'		=> array('type' => 'int'),
					'date'			=> array('type' => 'date'),
					);
					
$sql->createtable(array(
						'db'		=>	$database,
						'table'		=>	'news',
						'columns'	=>	$news ) );
						
/*******************************************/

$comments	=	array(
					'id'			=> array('type'	=> 'int', 'auto_increment' => 1),
					'news_id'		=> array('type' => 'int'),
					'user_id'		=> array('type' => 'int'),
					'title'			=> array('type' => 'string'),
					'body'			=> array('type' => 'text'),
					'date'			=> array('type' => 'date'),
					);
					
$sql->createtable(array(
						'db'		=>	$database,
						'table'		=>	'news_comments',
						'columns'	=>	$comments ) );
						
/*******************************************/

$module	=	array(
					'id'			=> array('type'	=> 'int', 'auto_increment' => 1),
					'mod_name'		=> array('type' => 'string'),
					'active'		=> array('type' => 'int'),
					);
					
$sql->createtable(array(
						'db'		=>	$database,
						'table'		=>	'module',
						'columns'	=>	$module ) );
						
$mod1	=	array(
			'mod_name'				=> 'admin',
			'active'				=> '3',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod1) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

$mod2	=	array(
			'mod_name'				=> 'index',
			'active'				=> '3',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod2) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}


$mod3	=	array(
			'mod_name'				=> 'login',
			'active'				=> '3',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod3) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

$mod4	=	array(
			'mod_name'				=> 'logout',
			'active'				=> '3',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod4) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

$mod5	=	array(
			'mod_name'				=> 'comment_handler',
			'active'				=> '3',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod5) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

$mod6	=	array(
			'mod_name'				=> 'register',
			'active'				=> '3',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod6) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

$mod7	=	array(
			'mod_name'				=> 'admin',
			'active'				=> '3',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod7) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

$mod8	=	array(
			'mod_name'				=> 'news',
			'active'				=> '2',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod8) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

$mod9	=	array(
			'mod_name'				=> 'message_center',
			'active'				=> '3',
			);
			
if ( !$sql->insert(array(
						'db'     	=> $database,
                        'table'  	=> 'module',
                        'values' 	=> $mod9) ) )
{
    die('An error occurred, txtSQL said: '.$sql->get_last_error());
}

/*****************************************/

	echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=">';
						
} else {

	echo "Something fucked up!";

}

?>