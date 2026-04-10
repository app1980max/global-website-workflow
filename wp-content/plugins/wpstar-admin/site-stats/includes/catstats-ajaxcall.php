<div class="wpstr-wid-admin">

<script>		
	jQuery(document).ready(function(){
			function cat_stats_by_year(){
				jQuery.ajax(
						{
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_catstats"},
					success: function(data)
							{
								jQuery(".wpstr_catstats").html(data);
							}
				});
			}
			cat_stats_by_year();
			setInterval(function(){
				cat_stats_by_year();	
			}, 300000)

	        jQuery(document).on('click', "#catstats_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_catstats").html("Loading...");
						cat_stats_by_year();
						//console.log("recall");
	                            }
	        });
	});
			
</script>


<div class="wpstr_catstats">
	
</div>


</div>