<?php

if ( $_POST ){

	$username	=	$_POST['username'];
	$password	=	$_POST['password'];

	carbon::login($username, $password);

} elseif(carbon::logged() == 0) {

?>

<form action='?page=login' method='post'>

<table border='0' cellpadding='0' cellspacing='1' align='center' width='100%'>

	<tr>
	
		<td width='100px'>

			Username:
			
		</td>
		
		<td>
		
			<input type='text' name='username' class='login_box'>
		
		</td>
		
	</tr>
	
	<tr>
	
		<td width='100px'>

			Password:
			
		</td>
		
		<td>
		
			<input type='password' name='password' class='login_box'>
		
		</td>
		
	</tr>
	
	<tr>
	
		<td colspan='2' align='center'>
		
			<input type='submit' value='Login!' class='submit'>
		
		</td>
	
	</tr>
	
</table>
				

</form>

<?php

	} else {
	
		echo "<center>Error: You are currently logged in and cannot login again until you logout.</center>";
	
	}
	
?>