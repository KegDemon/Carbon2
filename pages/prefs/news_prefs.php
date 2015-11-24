<?php

#member = 2

#news_prefs.php

switch ( $_GET['sub'] ){
		
			case NULL:
			
				echo "
				
				<a href='?page=admin'><strong>Back</strong></a> \n
				
			<table border='0' cellpadding='1' cellspacing='1' class='admin_panel' width='100%'>
			
				<tr>
				
					<td align='center' valign='middle'>
					
						 <a href='?page=admin&function=pref&pref=news_prefs&sub=options' class='admin_panel'><strong>Configure</strong></a>
						 
					</td>
				
					<td align='center' valign='middle'>
		
						<a href='?page=admin&function=pref&pref=news_prefs&sub=new' class='admin_panel'><strong>New News Post</strong></a>
						
					</td>
					
				</tr>
				
				<tr>
				
					<td align='center' valign='middle'>
					
						 <a href='?page=admin&function=pref&pref=news_prefs&sub=edit' class='admin_panel'><strong>Edit News Post</strong></a>
						 
					</td>
					
					<td align='center' valign='middle'>
		
						<a href='?page=admin&function=pref&pref=news_prefs&sub=delete' class='admin_panel'><strong>Delete News Post</strong></a>
						
					</td>
					
				</tr>
				
			</table>
			
				";
			
			break;
			
			case "options":
				
				if ( $_POST ){
				
					$comm	=	$_POST['news_comments'];
					$com2	=	$_POST['news_comments_logged'];
					
					$up		=	array(
					'news_comments'				=>	$comm,
					'news_comments_loggedin'	=>	$com2
					);
					
					if(!$sql->update(array(
						'db'		=> $database,
						'table' 	=> 'config',
						'where'		=> array('id = 1'),
						'values'	=> $up,
					)))
					{
			
						die('An error occurred, txtSQL said: '.$sql->get_last_error());
			
					}
					
					echo "<center>News Options have been updated. \n <br /> \n <a href='?page=admin&function=pref&pref=news_prefs&sub=options'>Click Here</a> to go back. </center>";
				
				} else {
				
					echo "<a href='?page=admin&function=pref&pref=news_prefs'><strong>Back</strong></a> \n <br /> <br /> \n\n
					
					<form action='?page=admin&function=pref&pref=news_prefs&sub=options' method='post'>
					
					<table border='0' cellpadding='0' cellspacing='1' width='100%'>
					
					<tr>
		
						<td width='175px'>

							Global News Comments:
							
						</td>
						
						<td>
						
							Enabled <input type='radio' name='news_comments' value='1'"; if ( carbon::config(comments, 0) == 1){ echo "checked"; } echo ">
							Disabled <input type='radio' name='news_comments' value='0'"; if ( carbon::config(comments, 0) == 0){ echo "checked"; } echo ">
						
						</td>
						
					</tr>
					
					<tr>
		
						<td width='175px'>

							Public Commenting:
							
						</td>
						
						<td valign='top'>
						
							Enabled <input type='radio' name='news_comments_logged' value='1'"; if ( carbon::config(news_comments_logged, 0) == 1){ echo "checked"; } echo ">
							Disabled <input type='radio' name='news_comments_logged' value='0'"; if ( carbon::config(news_comments_logged, 0) == 0){ echo "checked"; } echo ">
						
						</td>
						
					</tr>

					<tr>
					
						<td colspan='2' align='center'>
						
							<input type='submit' value='Update' class='submit'>
							
						</td>
						
					</tr>

					</table>
					";
				
				}
			
			break;
			
			case "new":
			
				if ( $_POST ){
				
					switch ( $_POST['news_lines'] ){
					
						case 1:
						
							$news_body	=	nl2br(stripslashes($_POST['news_body']));
							$news_desc	=	nl2br(stripslashes($_POST['news_desc']));
							
						break;
						
						case 0:
						
							$news_body	=	stripslashes($_POST['news_body']);
							$news_desc	=	stripslashes($_POST['news_desc']);
							
						break;
					
					}
					
					$news_title	=	stripslashes($_POST['news_title']);
					$news_comm	=	$_POST['news_comments'];
					
					$ins	=	array(
						'title'			=>	$news_title,
						'user_id'		=>	$_COOKIE['user'],
						'description'	=>	$news_desc,
						'body'			=>	$news_body,
						'comments'		=>	$news_comm,
					);
					
					if ( !$sql->insert(array(
						'db'     	=> $database,
						'table'  	=> 'news',
						'values' 	=> $ins) ) )
					{
					   die('Unable to add news to Database');
					}
					
					echo "<center>News post - <em>$news_title</em> - was posted. \n <br /> \n Click <a href='?page=admin&function=pref&pref=news_prefs'>Here</a> to return to news manager.</center>";
					
				
				} else {
				
					echo "
					
						<a href='?page=admin&function=pref&pref=news_prefs'><strong>Back</strong></a>
					
						<form action='?page=admin&function=pref&pref=news_prefs&sub=new' method='post'>
					
						<table border='0' cellpadding='0' cellspacing='1' width='100%'>
						
							<tr>
				
								<td width='175px'>
									
									Title:
									
								</td>
								
								<td>
								
									<input type='text' name='news_title' class='login_box'>
								
								</td>
								
							</tr>
							
							<tr>
				
								<td width='175px' valign='top'>
									
									Description:
									
								</td>
								
								<td>
								
									<textarea name='news_desc' class='textarea'></textarea>
								
								</td>
								
							</tr>
							
							<tr>
				
								<td width='175px' valign='top'>
									
									Main Body:
									
								</td>
								
								<td>
								
									<textarea name='news_body' class='textarea_full'></textarea>
								
								</td>
								
							</tr>
							
							<tr>
							
								<td>
								
									Comments:
								
								</td>
								
								<td>
								
									Enabled <input type='radio' name='news_comments' value='1' checked>
									Disabled <input type='radio' name='news_comments' value='0'>
								
								</td>
								
							</tr>
							
							<tr>
							
								<td>
								
									Automatic Linebreaks:
								
								</td>
								
								<td>
								
									Enabled <input type='radio' name='news_line' value='1' checked>
									Disabled <input type='radio' name='news_lines' value='0'>
								
								</td>
								
							</tr>
							
							<tr>
							
								<td colspan='2' align='center'>
								
									<input type='submit' value='Submit News' class='submit'>
									
								</td>
								
							</tr>
							
						</table>
					
						</form>
					
					";
				
				}
			
			break;
			
			case "edit":
			
				if ( $_POST['select'] ) {
				
					$id		=	$_POST['news_id'];
					
					$fetch	=	$sql->select(array('db' => $database, 'table' => 'news', 'where' => array('id = ' . $id)));
					
					$title	=	stripslashes($fetch[0]['title']);
					$desc	=	stripslashes(str_replace("<br />", "", $fetch[0]['description']));
					$body	=	stripslashes(str_replace("<br />", "", $fetch[0]['body']));
					$comm	=	$fetch[0]['comments'];
					$date	=	$fetch[0]['date'];
					
					if ( $comm == '1' ) {
					
						$checked	=	"checked";
					
					} elseif ( $comm == '0' ){
					
						$checked2	=	"checked";
					
					}
					
					echo "<a href='?page=admin&function=pref&pref=news_prefs&sub=edit'><strong>Back</strong></a> <br /> \n\n
					
						<form action='?page=admin&function=pref&pref=news_prefs&sub=edit' method='post'>
						
						<table border='0' cellpadding='0' cellspacing='1' width='100%'>
						
							<tr>
							
								<td width='150px'>
								
									Title:
								
								</td>
								
								<td>
								
									<input type='text' name='title' value='$title' class='login_box'>
								
								</td>
								
							</tr>
							
							<tr>
							
								<td width='150px' valign='top'>
								
									Description:
								
								</td>
								
								<td>
								
									<textarea name='desc' class='textarea'>$desc</textarea>
								
								</td>
								
							</tr>
							
							<tr>
							
								<td width='150px' valign='top'>
								
									Body:
								
								</td>
								
								<td>
								
									<textarea name='body' class='textarea_full'>$body</textarea>
								
								</td>
								
							</tr>
							
							<tr>
							
								<td>
								
									Comments:
								
								</td>
								
								<td>
								
									Enabled <input type='radio' name='news_comments' value='1' $checked>
									Disabled <input type='radio' name='news_comments' value='0' $checked2>
								
								</td>
								
							</tr>
							
							<tr>
							
								<td>
								
									Automatic Linebreaks:
								
								</td>
								
								<td>
								
									Enabled <input type='radio' name='news_line' value='1' checked>
									Disabled <input type='radio' name='news_lines' value='0'>
								
								</td>
								
							</tr>

							<tr>
							
								<td colspan='2' align='center'>
								
									<input type='hidden' name='news_id' value='$id'>
									
									<input type='submit' name='edit' value='Edit News' class='submit'>
									
								</td>
								
							</tr>
						
						</table>
						
						</form>
						
					";
				
				} elseif ( $_POST['edit'] ) {
				
					$id		=	$_POST['news_id'];
					$title	=	stripslashes($_POST['title']);
					$desc	=	stripslashes($_POST['desc']);
					$body	=	stripslashes($_POST['body']);
					$comm	=	$_POST['news_comments'];
					$lines	=	$_POST['news_lines'];
					
					if ( $lines == '1' ){
					
						$body	=	nl2br($body);
						$desc	=	nl2br($desc);
					
					} 
					
					$update	=	array(
					
						'title'			=> $title,
						'description' 	=> $desc,
						'body'			=> $body,
						'comments' 		=> $comm,
					
					);
					
					if(!$sql->update(array(
						'db'		=> $database,
						'table' 	=> 'news',
						'where'		=> array('id = '. $id),
						'values'	=> $update,
					)))
					{
			
						 die('An error occurred, txtSQL said: '.$sql->get_last_error());
			
					}
					
					echo "<center>News Article - <em>$title</em> - has been updated \n <br /> \n <a href='?page=admin&function=pref&pref=news_prefs&sub=edit'>Click Here</a> to continue editing.";
				
				} else {
				
					echo "<a href='?page=admin&function=pref&pref=news_prefs'><strong>Back</strong></a> <br /> \n\n";
					
					echo "
					
						<form action='?page=admin&function=pref&pref=news_prefs&sub=edit' method='post'>
						
						<table border='0' cellpadding='0' cellspacing='1' width='100%'>
						
							<tr>
							
								<td width='150px'>
								
									Select News Artical:
									
								</td>
								
								<td> 
								
									<select name='news_id' style='width:100%'>";
									
									$fetch	=	$sql->select(array('db' => $database, 'table' => 'news', 'orderby' => array('title', 'ASC')));
									
									foreach ( $fetch as $key => $news ){
									
										$id		=	$news['id'];
										$name	=	$news['title'];
										
										echo "<option value='$id'>$name</option>";
									
									}	
									
									echo "</select>
						
								</td>
								
							</tr>
							
							<tr>
							
								<td colspan='2' align='center'>
								
									<input type='submit' name='select' value='Go!' class='submit'>
								
								</td>
								
							</tr>
						
						</table>
						
						</form>
					
					";
				
				}
			
			break;
			
			case "delete":
			
				echo "<a href='./?page=admin&function=pref&pref=news_prefs'><strong>Back</strong></a> \n <br /> <br /> \n";
			
				$fetch	=	$sql->select(array('db' => $database, 'table' => 'news', 'orderby' => array('id', 'DESC')));
				
				foreach( $fetch as $key => $news ) {
				
					$news_id = $news['id'];
				
					echo "[ <a href='./?page=admin&function=pref&pref=news_prefs&sub=delete&delete=$news_id'>X</a> ] " . $news['title'] . " \n <br /> \n";
				
				}
				
				if ( $_GET['delete'] != NULL ){
				
					$sql->delete(array('db' => $database, 'table' => 'news', 'where' => array('id = ' . $_GET['delete'])));
					
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=./?page=admin&function=pref&pref=news_prefs&sub=delete">';
				
				}
			
			break;
		
		
		}

?>