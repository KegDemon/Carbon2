<?php

	//comment handler
	
	$comment	=	$_GET['comment'];
	$type		=	$_GET['type'];
	$content	=	$_GET['content'];
	
	if ( $comment == NULL ){
		
		echo "<center>Error: No comment submited to the Comment Handler</center>";
		
	} else {
	
		switch ( $type ){
		
			case "news":
			
				$basis	=	explode("|", $content);
				
				$news_id	=	$basis[0];
				$title		=	$basis[1];
			
				if ( $_POST['comment'] ){
				
					$p_title	=	stripslashes(strip_tags($_POST['p_title']));
					$p_comment	=	stripslashes(strip_tags($_POST['p_comment']));
					
					if ($_POST['lines'] == 1){
					
						$p_comment	=	nl2br($p_comment);
					
					}
					
					$user_id	=	$_COOKIE['user'];
					
					$bulk	=	array(
								'news_id'	=>	$news_id,
								'user_id'	=>	$user_id,
								'title'		=>	$p_title,
								'body'		=>	$p_comment
								);
								
					if(!$sql->insert(array(
						'db'		=> $database,
						'table' 	=> 'news_comments',
						'values'	=> $bulk,
					)))
					{
			
						 die('An error occurred, txtSQL said: '.$sql->get_last_error());
			
					}
					
					echo "<center> News comment has been posted. <br /> <a href='?page=news&id=$news_id'>Back to news post</a> </center>";
				
				} else {
				
					echo "\n Leave a Comment for News Aritcle:  \n\n <br /> <br /> \n\n
						
						<form action='?page=comment_handler&comment=1&type=news&content=$content' method='post'>
						
							<table width='100%' border='0' cellpadding='0' cellspacing='1'>
									
								<tr>
								
									<td width='150px'>
								
										Title:
																					
									</td>
								
									<td>
									
										<input type='string' name='p_title' value='RE: $title' class='login_box'>
											
									</td>
									
								</tr>
							
								<tr>
								
									<td valign='top'>
									
										Comment:
								
									</td>
								
									<td>
									
										<textarea class='textarea' name='p_comment'></textarea>
									
									</td>
									
								</tr>
								
								<tr>
								
									<td>
									
										Automatic Line Breaks:
								
									</td>
									
									<td>
									
										<input type='radio' name='lines' value='1' checked>Enabled  <input type='radio' name='lines' value='0'>Disabled
									
									</td>
								
								</tr>
								
								<tr>
								
									<td colspan='2' align='center'>
									
										<input type='submit' value='Comment' class='submit' name='comment'>
									
									</td>
									
								</tr>
									
							</table>
						
						</form>
						
					";

				
				}
				
			break;
		
		}
	
	}
	
?>