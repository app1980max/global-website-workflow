<div class="wpstr-stats">

<script>		
	jQuery(document).ready(function(){
		function online_today_visitors(){
			jQuery.ajax({
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_online_today_visitors"},
					success: function(data)
							{
								jQuery(".wpstr_online_today_visitors").html(data);
							}
				});
		}
			online_today_visitors();
	
			setInterval(function(){
					online_today_visitors();
			}, 300000)

	        jQuery(document).on('click', "#wpstr_today_visitors_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_online_today_visitors").html("Loading...");
						online_today_visitors();
						//console.log("recall");
	                            }
	        });

			
	});
			
</script>

<div class="wpstr_online_today_visitors">Loading...</div>


</div>