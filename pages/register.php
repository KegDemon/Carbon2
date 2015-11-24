<?php

	if ( $_POST ){
	
		$username_f	=	$_POST['username'];
		$username	=	strtolower($_POST['username']);
		
		$password	=	$_POST['password'];
		$password2	=	$_POST['password_check'];
		
		$email		=	$_POST['email'];
		
		$security_q	=	$_POST['security'];
		$security_a	=	$_POST['s_answer'];
	
		$info	=	"$username_f, $username, $password, $password2, $email, $security_q, $security_a";
	
		carbon::register($info);
	
	} elseif ( carbon::logged() == 0 ) {

		if ( carbon::config(user_reg, 0) == 1 ) {
	
?>

<form action='?page=register' method='post'>

<table border='0' cellpadding='0' cellspacing='1' align='center' width='100%'>

	<tr>
	
		<td width='150px'>

			Username:
			
		</td>
		
		<td>
		
			<input type='text' name='username' class='login_box'>
		
		</td>
		
	</tr>
	
	<tr>
	
		<td width='150px'>

			Password:
			
		</td>
		
		<td>
		
			<input type='password' name='password' class='login_box'>
		
		</td>
		
	</tr>
	
	<tr>
	
		<td width='150px'>

			Password (again):
			
		</td>
		
		<td>
		
			<input type='password' name='password_check' class='login_box'>
		
		</td>
		
	</tr>
	
	<tr>
	
		<td width='150px'>

			E-mail (Valid):
			
		</td>
		
		<td>
		
			<input type='text' name='email' class='login_box'>
		
		</td>
		
	</tr>
	
	<tr>
	
		<td width='150px'>

			Security Question:
			
		</td>
		
		<td>
		
			<input type='text' name='security' class='login_box'>
		
		</td>
		
	</tr>
	
	<tr>
	
		<td width='150px'>

			Answer:
			
		</td>
		
		<td>
		
			<input type='text' name='s_answer' class='login_box'>
		
		</td>
		
	</tr>
	
	<tr>
	
		<td colspan='2' align='center'>
		
			<input type='submit' value='Register' class='submit'>
			<input type='reset' value='Reset' class='submit'>
		
		</td>
	
	</tr>
	
</table>
				

</form>
<sup>1</sup> Username must be atleast: <?php carbon::config(min_user_length, 1); ?> characters long.
<br />
<sup>2</sup> Password must be atleast: <?php carbon::config(min_pass_length, 1); ?> characters long.
<br />
<sup>3</sup> Usernames cannot contain spaces and are not case sensitive.
<br />
<sup>4</sup> No HTML can be used in any text field.
		
<?php
		
		} else {
		
			echo "<center>User registration is currently disabled.</center>";
		
		}
		
	} else {
	
		echo "<center>Error: You are currently logged in and cannot create another account.</center>";
	
	}

?>