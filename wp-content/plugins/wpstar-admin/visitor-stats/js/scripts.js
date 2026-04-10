
jQuery(document).ready(function()
	{




      var hook = true;
      window.onbeforeunload = function() {
        if (hook) {
			
		  document.cookie="knp_landing=0; path=/";
		  
				var knp_online_count = -1;
				jQuery.ajax(
					{
				type: 'POST',
				url: wpstrwid_ajax.wpstrwid_ajaxurl,
				data: {"action": "wpstrwid_offline_visitors", "knp_online_count":knp_online_count},
				success: function(data)
						{
							
						}
					});	
		  
		  
		  
		  
		  
        }
      }

		
		
		
		
	
	});	







