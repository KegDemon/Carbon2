<?php

$news_id	=	$_GET['id'];
		
		if ( $news_id	== NULL ){
		
			$news_id	= "";
		
		}
		
		if ( $news_id == NULL ) {
		
			$fetch	=	$sql->select(array('db' => $database, 'table' => 'news', 'orderby' => array('id', 'DESC')));
			
			foreach ( $fetch as $key => $news ) {
			
				$title	=	$news['title'];
				$nid	=	$news['id'];
				$uid	=	$news['user_id'];
				$desc	=	nl2br($news['description']);
				$body	=	nl2br($news['body']);
				$date	=	$news['date'];
				
					#####################
					
					$get_user	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array("id = $uid")));
					
					$username	=	$get_user[0]['username_f'];
					
					#####################
					
					$get_comments	=	$sql->select(array('db' => $database, 'table' => 'news_comments', 'where' => array('news_id = '. $nid)));
					
					$comments	=	count($get_comments);
					
					#####################
				
				$date	=	date($this->date_format, $date);
				
				$temp	=	"./template/";
				$temp	.=	$this->_template;
				$temp	.=	"/_news.php";
				
				$open	=	fopen($temp, "r");
				
				$contents = fread($open, filesize($temp));

				$contents	=	str_ireplace('{ID}', $nid, $contents);
				$contents	=	str_ireplace('{TITLE}', $title, $contents);
				$contents	=	str_ireplace('{UID}', $uid, $contents);
				$contents	=	str_ireplace('{DESC}', $desc, $contents);
				$contents	=	str_ireplace('{BODY}', '', $contents);
				$contents	=	str_ireplace('{DATE}', $date, $contents);
				$contents	=	str_ireplace('{USERNAME}', $username, $contents);
				$contents	=	str_ireplace('{COMMENTS}', $comments . ' Comment(s)', $contents);
				$contents	=	str_ireplace('{README}',"<a href='?page=news&id=$nid'>Read Full News Article...</a>", $contents);
				
				fclose($open);
				
				echo $contents ;
				
			}
			
		} else {
		
			$fetch	=	$sql->select(array('db' => $database, 'table' => 'news', 'where' => array('id =' . $news_id)));
		
			foreach ( $fetch as $key => $news ) {
			
				$title	=	$news['title'];
				$nid	=	$news['id'];
				$uid	=	$news['user_id'];
				$desc	=	nl2br($news['description']);
				$body	=	nl2br($news['body']);
				$date	=	$news['date'];
				$comments=	$news['comments'];
				
					#####################
					
					$get_user	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array("id = $uid")));
					
					$username	=	$get_user[0]['username_f'];
					
					#####################
				
				$date	=	date($this->date_format, $date);
				
				$temp	=	"./template/";
				$temp	.=	$this->_template;
				$temp	.=	"/_news.php";
				
				$open	=	fopen($temp, "r");
				
				$contents = fread($open, filesize($temp));

				$contents	=	str_ireplace('{ID}', $nid, $contents);
				$contents	=	str_ireplace('{TITLE}', $title, $contents);
				$contents	=	str_ireplace('{UID}', $uid, $contents);
				$contents	=	str_ireplace('{DESC}', '', $contents);
				$contents	=	str_ireplace('{BODY}', $body, $contents);
				$contents	=	str_ireplace('{DATE}', $date, $contents);
				$contents	=	str_ireplace('{USERNAME}', $username, $contents);
				$contents	=	str_ireplace('{COMMENTS}', '', $contents);
				$contents	=	str_ireplace('{README}','<a href="?page=news">Back to News</a>', $contents);
				
				fclose($open);
				
				echo $contents ;
				
				#####################
				
				

				if ( carbon::config("comments", 0) == 1 && $comments == 1){
				
					if( carbon::config("news_comments_logged", 0) == 0 && $_COOKIE['user'] !== NULL){
					
						echo "<a href='?page=comment_handler&comment=1&type=news&content=$nid|$title'>Leave a comment</a> <br />";
					
					} elseif(carbon::config("news_comments_logged", 0) == 1) {
					
						echo "<a href='?page=comment_handler&comment=1&type=news&content=$nid|$title'>Leave a comment</a> <br />";
					
					} else {
					
						echo "<center>You must be logged in to post a comment</center> \n <br /> \n";
					
					}
				
				}  else {
					
					echo "\n <center> Commenting is currently disabled. </center> \n\n <br /> \n";
					
				}
								
				#####################
				
				$fetch_comments	=	$sql->select(array('db' => $database, 'table' => 'news_comments', 'where' => array('news_id = ' . $nid)));
								
				foreach ( $fetch_comments as $key => $comments ) {
				
					$cid	=	$comments['id'];
					$n_id	=	$comments['news_id'];
					$u_id	=	$comments['user_id'];
					$c_date	=	$comments['date'];
					$c_title	=	$comments['title'];
					$c_body	=	$comments['body'];
					
					$c_date	=	date($this->date_format, $c_date);
									
					$get_user2	=	$sql->select(array('db' => $database, 'table' => 'users', 'where' => array("id = $u_id")));
				
					#var_export($get_user2);
				
					$c_username	=	$get_user2[0]['username_f'];
					$c_sig		=	$get_user2[0]['sig'];
				
					$templ	=	"./template/";
					$templ	.=	$this->_template;
					$templ	.=	"/_comments.php";
					
					$open	=	fopen($templ, "r");
					
					$contents = fread($open, filesize($templ));

					$contents	=	str_ireplace('{ID}', $n_id, $contents);
					$contents	=	str_ireplace('{TITLE}', $c_title, $contents);
					$contents	=	str_ireplace('{UID}', $u_id, $contents);
					$contents	=	str_ireplace('{POST}', $c_body, $contents);
					$contents	=	str_ireplace('{DATE}', $c_date, $contents);
					$contents	=	str_ireplace('{USERNAME}', $c_username, $contents);
					$contents	=	str_ireplace('{SIG}', $c_sig, $contents);
					
					$c_delete	=	"<a href='?page=news&id=$n_id&delete=$cid'>Delete</a>";
					
					if ( $u_id == $_COOKIE['user'] || carbon::rank() > 1){
					
						$contents	=	str_ireplace('{DELETE}', $c_delete, $contents);
					
					} else {
					
						$contents	=	str_ireplace('{DELETE}', '', $contents);
					
					}

					fclose($open);
					
					echo $contents ;
					
				
				}
					
					# Delete comment
					
					if ( $_GET['delete'] != NULL ){
				
						if ( $u_id == $_COOKIE['user'] || carbon::rank() > 1 ){
					
							$sql->delete(array('db' => $database, 'table' => 'news_comments', 'where' => array('id = ' . $_GET['delete'])));
							
							echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=?page=news&id=$n_id'>";
					
						}
				
					}
					
					#end delete comment

			}

		}

?>