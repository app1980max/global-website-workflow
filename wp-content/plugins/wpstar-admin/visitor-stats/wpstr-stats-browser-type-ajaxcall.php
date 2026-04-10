<div class="wpstr-stats">

<script>		
	jQuery(document).ready(function(){
		function browsers_used_by_visitors(){

			jQuery.ajax({
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_browser_type"},
					success: function(data)
							{
								jQuery(".wpstr_browser_type").html(data);
							}
				});
		}
			browsers_used_by_visitors();
	
			setInterval(function(){
					browsers_used_by_visitors();
			}, 300000)
	

	        jQuery(document).on('click', "#wpstr_browser_type_wp_dashboard .ui-sortable-handle", function () {
	                            if(!jQuery(this).parent().hasClass("closed")){
						jQuery(".wpstr_browser_type").html("Loading...");
						browsers_used_by_visitors();
						//console.log("recall");
	                            }
	        });

	});




			
</script>

<div class="wpstr_browser_type">Loading...</div>


</div>