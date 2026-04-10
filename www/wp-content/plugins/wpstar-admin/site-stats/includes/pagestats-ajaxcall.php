<div class="wpstr-wid-admin">

<script>		
	jQuery(document).ready(function(){
		function page_registrations_by_year(){
			jQuery.ajax(
						{
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_pagestats"},
					success: function(data)
							{
								jQuery(".wpstr_pagestats").html(data);
							}
						});
		}
		page_registrations_by_year();
			setInterval(function(){
				page_registrations_by_year();	
			}, 300000)
			
	        jQuery(document).on('click', "#pagestats_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_pagestats").html("Loading...");
						page_registrations_by_year();
						//console.log("recall");
	                            }
	        });
	});
			
</script>


<div class="wpstr_pagestats">
	
</div>


</div>