<!--  footer -->

				<td valign="top" style="background-image: url(./template/<?php carbon::config("template", 1); ?>/images/right.gif); height: 100%;">
					
				</td>
				
			</tr>
			
			<tr>
			
				<td>
				
					<img src="./template/<?php carbon::config("template", 1); ?>/images/bottomleft.gif"  width="20" height="19">
					
				</td>
				
				<td valign="top" style="background-image: url(./template/<?php carbon::config("template", 1); ?>/images/bottom.gif); width: 100%;">
				
				</td>
				
				<td>
				
					<img src="./template/<?php carbon::config("template", 1); ?>/images/bottomright.gif"  width="19" height="20">
					
				</td>
				
			</tr>
			
			<tr>
			
				<td colspan='2' align="center">
				
					<?php carbon::version(); ?>
				
				</td>
				
			</tr>
			
		</table>
		
	</body>
	
</html>

<?php carbon::disconnect(); ?>