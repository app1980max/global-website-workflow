jQuery(document).ready(function(){
		function wpstr_menu_userinfo_ajax(){
			jQuery.ajax({
					type: 'POST',
					url: wpstr_wp_stats_ajax.wpstr_wp_stats_ajaxurl,
					data: {"action": "wpstr_wp_stats_ajax_online_total"},
					success: function(data)
							{
								//console.log("Hello world"+data);
								//jQuery("#adminmenuback").append(data);
								jQuery("#adminmenuwrap").prepend(data);
								//jQuery(".wpstr_online_total").html(data);
								//console.log(window.innerHeight);
								jQuery("#adminmenu").height(window.innerHeight - 100);
								var links = jQuery("#wp-admin-bar-user-actions").html();
								//console.log(links);
								jQuery(".wpstr-menu-profile-links .all-links").html(links);
								jQuery("#wp-admin-bar-my-account").remove();
							}
				});
		}
			wpstr_menu_userinfo_ajax();
	});