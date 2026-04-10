<div class="wpstr-wid-admin">

<script>		
	jQuery(document).ready(function(){
		function post_registrations_by_year(){
			jQuery.ajax(
						{
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_poststats"},
					success: function(data)
							{
								jQuery(".wpstr_poststats").html(data);
							}
						});
		}
		post_registrations_by_year();
			setInterval(function(){
					post_registrations_by_year();
			}, 300000)
			
	        jQuery(document).on('click', "#poststats_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_poststats").html("Loading...");
						post_registrations_by_year();
						//console.log("recall");
	                            }
	        });
	});
			
</script>


<div class="wpstr_poststats">
	
</div>


</div>