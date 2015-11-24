<?php 

#member = 1

if ( $_POST ){

	$email		=	$_POST['e_mail'];
	$show_email	=	$_POST['show_email'];
	$sig		=	$_POST['sig'];
	$user		=	$_COOKIE['user'];
	
	$sig		=	strip_tags($sig);
	
	#password update check info
	
	if ( $_POST['password'] != NULL ){
	
		$user	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('id = ' . $_COOKIE['user'])));
	
		$pass_old	=	md5($_POST['pass_old']);
	
		if ( $pass_old	==	$user[0]['password'] ){
	
			$pass_new	=	md5($_POST['pass_new']);
			$pass_new2	=	md5($_POST['pass_new2']);
			
			if ( $pass_new == $pass_new2 ){
			
				if ( carbon::config(min_pass_length, 0) < strlen($pass_new) ){
				
					$up	=	array( 'password'	=>	$pass_new, );
					
					if(!$sql->update(array(
						'db'		=> $database,
						'table' 	=> 'users',
						'where'		=> array('id = ' . $user),
						'values'	=> $up,
					)))
					{
			
						die('An error occurred, txtSQL said: '.$sql->get_last_error());
			
					}
				
				} else {
				
					echo "<center>Error: Password does not meet minimum required password length.</center>";
				
				}
			
			}
	
		} elseif( $pass_old	!=	$user[0]['password']) {
		
			echo "<center>Password does not match your current password.</center>";
		
		} else {
		
		}
		
	}
	
	
	#end password update
	
	if ($email == NULL) {
	
		echo "<center>Error: A valid E-mail Address must be entered.</center>"; 
	
	} else {
	
		$update	=	array(
		
			'email'			=>	$email,
			'show_email'	=>	$show_email,
			'sig'			=>	$sig,
		
		);
	
		if(!$sql->update(array(
				'db'		=> $database,
				'table' 	=> 'users',
				'where'		=> array('id = ' . $user),
				'values'	=> $update,
			)))
			{
			
				 die('An error occurred, txtSQL said: '.$sql->get_last_error());
			
			}
			
		echo "<center>Your user information has been updated.\n <br /> \n If you updated your password, it is suggested you logout and back in.</center>";
	
	}

} else {

	$user	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('id = ' . $_COOKIE['user'])));
	
	$email		=	$user[0]['email'];
	$show_email	=	$user[0]['show_email'];
	$sig		=	$user[0]['sig'];
	
?>

	<form action='?page=userpage' method='post'>

	<table border='0' cellpadding='0' cellspacing='1' width='100%'>
	
		<tr>
		
			<td colspan='2'>
			
				<strong>Change Password</strong>
			
			</td>
		
		</tr>
	
		<tr>
		
			<td width='150px'>
			
				Password (old<sup>1</sup>):
			
			</td>
			
			<td>
			
				<input type='password' name='pass_old' class='login_box'>
				
			</td>
		
		</tr>
		
		<tr>
		
			<td width='150px'>
			
				Password (new<sup>2</sup>):
			
			</td>
			
			<td>
			
				<input type='password' name='pass_new' class='login_box'>
				
			</td>
		
		</tr>
		
		<tr>
		
			<td width='150px'>
			
				Password (new again):
			
			</td>
			
			<td>
			
				<input type='password' name='pass_new2' class='login_box'>
				
			</td>
		
		</tr>
		
		<tr>
		
			<td colspan='2'>
			
				<br />
			
				<strong>User Information</strong>
							
			</td>
			
		</tr>
		
		<tr>
		
			<td width='150px'>
			
				E-mail:
			
			</td>
			
			<td>
			
				<input type='text' name='e_mail' class='login_box' value='<?php echo $email; ?>'>
			
			</td>
			
		</tr>
		
		<tr>
		
			<td width='150px'>
			
				Show E-mail?
				
			</td>
			
			<td>
			
				Enabled <input type='radio' value='1' name='show_email' <?php if ( $show_email == 1 ){ echo "checked"; } ?>>
				Disabled <input type='radio' value='0' name='show_email' <?php if ( $show_email == 0 || $show_email == NULL ){ echo "checked"; } ?>>
			
			</td>
			
		</tr>
		
		<tr>
		
			<td colspan='2'>
			
				<br />
			
				<strong>Misc.</strong>
							
			</td>
			
		</tr>
		
		<tr>
		
			<td width='150px'>
			
				Signature (<?php carbon::config(sig_length, 1); ?>max char.):
			
			</td>
			
			<td>
			
				<input type='text' name='sig' value='<?php echo $sig; ?>' class='login_box' maxlength='<?php carbon::config(sig_length, 1); ?>'>
			
			</td>
		
		</tr>
		
		<tr>
		
			<td colspan='2' align='center'>
			
				<input type='submit' value='Update' class='submit'>
			
			</td>
		
		</tr>
		
		<tr>
		
			<td colspan='2'>
			
				<sup>1</sup>Password only needs to be entered if updating your current Password
				
					<br />
					
				<sup>2</sup>Password must be atleast <?php carbon::config(min_pass_length, 1); ?> characters long
				
			</td>
			
		</tr>
			
	</table>

<?php

}

?>