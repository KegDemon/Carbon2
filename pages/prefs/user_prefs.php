<?php

#member = 2

#User Panel page

if ( $_POST['select'] ){
		
			$uid	=	$_POST['id'];
		
			$fetch	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array('id = ' . $uid)));
			
			$username	=	$fetch[0]['username_f'];
			$rank		=	$fetch[0]['rank'];
			$active		=	$fetch[0]['active'];
			$sig		=	$fetch[0]['sig'];
			
			echo "
			
				<a href='?page=admin&function=pref&pref=user_prefs'> <strong>Back</strong> </a> <br /> <br />
			
				<form action='?page=admin&function=pref&pref=user_prefs' method='post'>
			
				<table border='0' cellpadding='0' cellspacing='1' width='100%'>
				
					<tr>
					
						<td width='100px'>
						
							Selected User:
						
						</td>
						
						<td align='left'>
						
							<strong> $username </strong>
							
						</td>
						
					</tr>
					
					";
					
					if ( $uid != '1' ) {
					
					echo "
					
					<tr>
					
						<td width='100px' valign='top'>
						
							Rank:
							
						</td>
						
						<td>
						
							<input type='radio' name='rank' value='0' "; if ( $rank == 0 ) {  echo "checked"; } echo "> Banned <br />
							<input type='radio' name='rank' value='1' "; if ( $rank == 1 ) {  echo "checked"; } echo "> Normal User <br />
							<input type='radio' name='rank' value='2' "; if ( $rank == 2 ) {  echo "checked"; } echo "> Admin
							
						</td>
						
					</tr>
					
					<tr>
					
						<td width='100px' valign='top'>
						
							Active:
						
						</td>
						
						<td>
						
							<input type='radio' name='active' value='0' "; if ( $active == 0 ) {  echo "checked"; } echo "> Inactive <br />
							<input type='radio' name='active' value='1' "; if ( $active == 1 ) {  echo "checked"; } echo "> Active<br />
						
						</td>
						
					</tr> ";
					
					}
					
					echo " <tr>
					
						<td width='100px'>
						
							Signature:
							
						</td>
						
						<td>
						
							<input type='text' name='sig' value='$sig' class='login_box'>
							
						</td>
						
					</tr>
					
					<tr>
					
						<td colspan='2'align='center'>
						
							<input type='hidden' value='$uid' name='user_id'>
							<input type='hidden' value='$username' name='user_name'>
						
							<input type='submit' value='Update' name='update' class='submit'>
							
						</td>
						
					</tr>
					
				</table>
				
				</form>
			
			";
			
		} elseif ( $_POST['update'] ) {
			
			$rank	=	$_POST['rank'];
			$active	=	$_POST['active'];
			$sig	=	$_POST['sig'];
			$id		=	$_POST['user_id'];
			$username	=	$_POST['user_name'];
				
			$up		=	array(
				'rank'	=>	$rank,
				'active'	=>	$active,
				'sig'	=>	$sig,
			);
			
			$sql->update(array(
			'db'	=>	$database,
			'table'	=>	'users',
			'where'	=>	array('id = ' . $id),
			'values'=>	$up,
			));
			
			echo "<center>User - <em>$username</em> - updated successfully. <br /> \n <a href='?page=admin&function=pref&pref=user_prefs'>Click here</a> to go back.</center>";
		
		} else {
	
			echo "<a href='?page=admin'><strong>Back</strong></a> \n <br /> <br /> \n\n";
		
			echo "
		
				<form action='?page=admin&function=pref&pref=user_prefs' method='post'>
			
					<table border='0' cellpadding='0' cellspacing='1' width='100%'>
					
						<tr>
						
							<td width='100px'>
							
								Select User:
								
							</td>
							
							<td>
							
								<select name='id' style='width:100%;'> \n";
							
								$u_list	=	$sql->select(array('db' => $database, 'table' => 'users', 'orderby' => array('username', 'ASC')));
								
								foreach ( $u_list as $key => $list ) {
								
									$id		=	$list['id'];
									$name	=	$list['username_f'];
									
									echo "<option value='$id'>$name</option> \n";
								
								}
								
							echo " </select>
							
							</td>
							
						</tr>
						
						<tr>
						
							<td colspan='2' align='center'>
							
								<input type='submit' value=' Go! ' class='submit' name='select'>
								
							</td>
							
						</tr>
					
					</table>
			
				</form>
		
			";
		
		}

?>