<?php

#member = 2

#navigation_pref.php file

switch ( $_GET['m'] ) {
			
			case NULL:
			
			echo "
				
				<a href='?page=admin'><strong>Back</strong></a> \n
				
			<table border='0' cellpadding='0' cellspacing='1' class='admin_panel' width='100%'>
			
				<tr>
				
					<td align='center' valign='middle'>
		
						<a href='?page=admin&function=pref&pref=navigation_prefs&m=add' class='admin_panel'><strong>Add Site Link(s)</strong></a>
						
					</td>
					
					<td align='center' valign='middle'>
					
						 <a href='?page=admin&function=pref&pref=navigation_prefs&m=edit' class='admin_panel'><strong>Edit Site Link(s)</strong></a>
						 
					</td>
					
				</tr>
				
				<tr>
				
					<td align='center' valign='middle'>
		
						<a href='?page=admin&function=pref&pref=navigation_prefs&m=delete' class='admin_panel'><strong>Delete Site Link(s)</strong></a>
						
					</td>
					
				</tr>
				
			</table>
			
				";
			
			break;
			
			case "add":
			
				if ( $_POST ){
				
					$short	=	str_replace(" ", "_", $_POST['url']);
					$page	=	$_POST['url'] . ".php";
				
					$title	=	strip_tags($_POST['title']);
				
					$ins	=	array(
						'name' => $title,
						'page' => $page,
						'short_url'	=> $short,
					);
					
					if ( !$sql->insert(array(
						'db'     	=> $database,
						'table'  	=> 'nav',
						'values' 	=> $ins) ) )
					{
					   die('Unable to add new Link to Database');
					}
					
					echo "<center>Navigation link added \n <br /> \n <a href='?page=admin&function=pref&pref=navigation_prefs&m=add'>Click to go back</a></center>";
				
				} else {
			
					echo "<a href='?page=admin&function=pref&pref=navigation_prefs'><strong>Back</strong></a> \n <br /> <br /> \n
				
						<form action='?page=admin&function=pref&pref=navigation_prefs&m=add' method='post'>
				
						<table border='0' cellpadding='0' cellspacing='1' width='100%'>
					
							<tr>
							
								<td width='150px'>
								
									Title:
									
								</td>
								
								<td>
								
									<input type='text' name='title' class='login_box'>
									
								</td>
								
							</tr>
							
							<tr>
							
								<td width='150px'>
								
									Page (without *.PHP):
									
								</td>
								
								<td>
								
									<input type='text' name='url' class='login_box'>
								
								</td>
								
							</tr>
							
							<tr>
							
								<td colspan='2' align='center'>
								
									<input type='submit' value='Add' class='submit'>
								
								</td>
								
							</tr>
					
						</table>
				
						</form>
					";
				
				}
				
			break;
			
			case "delete":
			
				echo "<a href='?page=admin&function=pref&pref=navigation_prefs'><strong>Back</strong></a> \n <br /> <br /> \n";
				
				$fetch	=	$sql->select(array('db' => $database, 'table' => 'nav'));
				
				foreach ( $fetch as $key => $nav ){
				
					$nav_id	=	$nav['id'];
					
					echo "[ <a href='?page=admin&function=pref&pref=navigation_prefs&m=delete&delete=$nav_id'>X</a> ] " . $nav['name'] . " \n <br /> \n";
					
					if ( $_GET['delete'] != NULL ){
				
						$sql->delete(array('db' => $database, 'table' => 'nav', 'where' => array('id = ' . $_GET['delete'])));
					
						echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=admin&function=pref&pref=navigation_prefs&m=delete">';
				
					}
				
				}
			
			break;
			
			case "edit":
			
				$fetch	=	$sql->select(array('db' => $database, 'table' => 'nav', 'orderby' => array('order_id', 'ASC')));
			
				if ( $_POST['update'] ){
				
					foreach ( $fetch as $key => $nav ){
					
						$nav_id		=	$nav['id'];
						$nav_title	=	$nav['title'];
						$nav_short	=	$nav['short_url'];
						$nav_page	=	$nav['page'];
						$nav_order	=	$nav['order'];
						
						$nav_orderr	=	"order_". $nav_id;
						$nav_titler	=	"name_"	. $nav_id;
						$nav_shortr	=	"name_"	. $nav_id;
						$nav_pager	=	"page_" . $nav_id;
						
						$nav_order1	=	$_POST["$nav_orderr"];
						$nav_short1	=	$_POST["$nav_shortr"];
						$nav_title1	=	$_POST["$nav_titler"];
						$nav_page1	=	$_POST["$nav_pager"];
						
						$work	=	array(
						'order_id'		=>	$nav_order1,
						'short_url'	=>	$nav_short1,
						'name'		=>	$nav_title1,
						'page'		=>	$nav_page1,
						);
						
						if ( !$sql->update(array(
										'db'     => $database,
										'table'  => 'nav',
										'where'  => array('id = ' . $nav_id),
										'values' => $work,
										'limit'  => array(0))) )
						{
							die('An error occurred, txtSQL said: '.$sql->get_last_error());
						}

					
					}
										
					echo "<center>Navagation links have been updated \n <br /> \n <a href='?page=admin&function=pref&pref=navigation_prefs&m=edit'>Click Here</a> to continue.</center>";	
				
				} else {
				
				echo "<a href='?page=admin&function=pref&pref=navigation_prefs'><strong>Back</strong></a> \n <br /> <br /> \n";
				
				echo "
				
					<table border='0' cellspacing='1' cellpadding='0' width='100%'>
					
						<tr>
							
							<td width='6%'>
							
								Order #
								
							</td>
							
							<td width='30%'>
							
								Title
								
							</td>
							
							<td width='30%'>
							
								Page
								
							</td>
							
						</tr>
						
						<form action='?page=admin&function=pref&pref=navigation_prefs&m=edit' method='post'>
						
						";
						
						foreach ( $fetch as $key => $nav ) {
						
						$id		=	$nav['id'];
						$order	=	$nav['order_id'];
						$title	=	$nav['name'];
						$page	=	$nav['page'];
						
						echo "<tr>
							
							<td>
							
								<input type='text' class='login_box' value='$order' name='order_$id'>
								
							</td>
							
							<td>
							
								<input type='text' class='login_box' value='$title' name='name_$id'>
								
							</td>
							
							<td>
							
								<input type='text' class='login_box' value='$page' name='page_$id'>
								
							</td>
							
						</tr> ";
						
						}
						
						
					echo"	
					
						<tr>
						
							<td colspan='3' width='100%' align='center'>
							
								<input type='submit' name='update' value='Update' class='submit'>
								
							</td>
							
						</tr>
					
						</form>
					
					</table>
				
				";
				
				}
			
			break;
			
		}

?>