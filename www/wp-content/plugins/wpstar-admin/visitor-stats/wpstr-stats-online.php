	<script>		
		jQuery(document).ready(function()
			{

				function wpstr_find_online_users(){
					jQuery.ajax({
						type: 'POST',
						url: wpstrwid_ajax.wpstrwid_ajaxurl,
						data: {"action": "wpstrwid_ajax_online_total"},
						success: function(data)
								{
									jQuery(".onlinecount .count").html(data);
								}
					});
				}
				
				wpstr_find_online_users();
				
				setInterval(function(){
					wpstr_find_online_users();	
				}, 60000)
			});
				
	</script>
	<div class="onlinecount">
		<span class="count">...</span>
		<span class='onlinelabel'>Users<br>Online</span>
	</div>
