<div class="wpstr-wid-admin">

<script>		
	jQuery(document).ready(function(){

			function comment_stats_by_year(){
				jQuery.ajax(
						{
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_commentstats"},
					success: function(data)
							{
								jQuery(".wpstr_commentstats").html(data);
							}
						});	
			}
			comment_stats_by_year();
			setInterval(function(){
				comment_stats_by_year();
			}, 300000)
			
	        jQuery(document).on('click', "#commentstats_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_commentstats").html("Loading...");
						comment_stats_by_year();
						//console.log("recall");
	                            }
	        });
	});
			
</script>


<div class="wpstr_commentstats">
	
</div>


</div>