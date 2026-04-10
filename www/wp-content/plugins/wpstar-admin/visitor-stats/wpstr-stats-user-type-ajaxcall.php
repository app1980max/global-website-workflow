<div class="wpstr-stats">

<script>		
	jQuery(document).ready(function(){
		function wpstr_user_type_guest_or_registered(){
			jQuery.ajax({
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_user_type"},
					success: function(data)
							{
								jQuery(".wpstr_user_type").html(data);
							}
				});
		}
			wpstr_user_type_guest_or_registered();
	
			setInterval(function(){
					wpstr_user_type_guest_or_registered();
			}, 300000)
			
	        jQuery(document).on('click', "#wpstr_user_type_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_user_type").html("Loading...");
						wpstr_user_type_guest_or_registered();
						//console.log("recall");
	                            }
	        });
	});
			
</script>

<div class="wpstr_user_type">Loading...</div>


</div>