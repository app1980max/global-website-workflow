<div class="wpstr-wid-admin">

<script>		
	jQuery(document).ready(function(){
		function user_registrations_by_year(){
			jQuery.ajax(
						{
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_userstats"},
					success: function(data)
							{
								jQuery(".wpstr_userstats").html(data);
							}
						});
		}
		user_registrations_by_year();
			setInterval(function(){
					user_registrations_by_year();
			}, 300000)
			
	        jQuery(document).on('click', "#userstats_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_userstats").html("Loading...");
						user_registrations_by_year();
						//console.log("recall");
	                            }
	        });
	});
			
</script>


<div class="wpstr_userstats">
	
</div>


</div>