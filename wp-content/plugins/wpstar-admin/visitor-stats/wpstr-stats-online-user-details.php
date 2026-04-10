<script>		
	jQuery(document).ready(function()
		{

			function wpstr_find_online_user_details(){
				jQuery.ajax({
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_visitors_page"},
					success: function(data)
							{
								jQuery(".wpstr_visitors_details").html(data);
							}
				});	
			}

			wpstr_find_online_user_details();
			
			setInterval(function(){
				wpstr_find_online_user_details();
			}, 300000)
	});
			
</script>

	<div class="wpstr_visitors_details"></div>
