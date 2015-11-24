<?php

#member = 1

#Message Center

if ( $_GET['read'] == NULL ) {

	carbon::admin_activation();
	
	echo "<strong><a href='?page=message_center&read=write'>Send Message</a></strong> \n  <br /> <br /> \n";

?>

	<table border='0' cellpadding='0' cellspacing='0' width='100%'>

		<tr>
	
			<td class='message_center_top' width='30%'>
		
				<strong>Subject:</strong>
			
			</td>
		
			<td class='message_center_top' width='25%'>
		
				<strong>Sender:</strong>
			
			</td>
			
			<td class='message_center_top' width='20%'>
		
				<strong>Date:</strong>
			
			</td>
		
		</tr>
	
		<?php carbon::message_center_fetch('1'); ?>
	
	</table>

<?php
	
} elseif ( $_GET['read'] == 'read' ) {

	carbon::message_center_fetch('2');

} elseif ( $_GET['read'] == 'reply' ) {

	carbon::message_center_fetch('3');

} else {

	carbon::message_center_fetch('4');

}

?>