<div class="wpstr-stats">

<script>		
	jQuery(document).ready(function(){
			setInterval(function(){
				jQuery.ajax(
						{
					type: 'POST',
					url: wpstrwid_ajax.wpstrwid_ajaxurl,
					data: {"action": "wpstrwid_visitors2"},
					success: function(data)
							{
								jQuery(".visitors2").html(data);
							}
						});	
			}, 300000)
	});
			
</script>


<div class="visitors2"></div>


</div>