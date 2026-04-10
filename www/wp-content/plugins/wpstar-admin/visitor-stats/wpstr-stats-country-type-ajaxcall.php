<div class="wpstr-stats">

<script>		
	jQuery(document).ready(function(){
		function countrys_used_by_visitors(){
			jQuery.ajax({
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_country_type"},
					success: function(data)
							{
								jQuery(".wpstr_country_type").html(data);
							}
				});
		}
			countrys_used_by_visitors();
	
			setInterval(function(){
					countrys_used_by_visitors();
			}, 300000)


	        jQuery(document).on('click', "#wpstr_country_type_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_country_type").html("Loading...");
						countrys_used_by_visitors();
						//console.log("recall");
	                            }
	        });


	});
			
</script>

<div class="wpstr_country_type">Loading...</div>


</div>