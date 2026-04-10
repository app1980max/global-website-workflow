/**
 * @Package: WordPress Plugin
 * @Subpackage: WPStar - White Label WordPress Admin Theme Theme
 * @Since: Wpstr 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of WPStar - White Label WordPress Admin Theme Theme Plugin.
 */


jQuery(function($) {

    'use strict';

    var WPSTR_SETTINGS = window.WPSTR_SETTINGS || {};

    
    /******************************
     Menu resizer
     *****************************/
    WPSTR_SETTINGS.menuResizer = function() {
        var menuWidth = $("#adminmenuwrap").width();
        if($("#adminmenuwrap").is(":hidden")){
          $("body").addClass("menu-hidden");
          $("body").removeClass("menu-expanded");
          $("body").removeClass("menu-collapsed");
        }
        else if(menuWidth > 60){
          $("body").addClass("menu-expanded");
          $("body").removeClass("menu-hidden");
          $("body").removeClass("menu-collapsed");
        } else {
          $("body").addClass("menu-collapsed");
          $("body").removeClass("menu-expanded");
          $("body").removeClass("menu-hidden");
        }
    };

    WPSTR_SETTINGS.menuClickResize = function() {
      $(document).on('click', '#collapse-menu, #wp-admin-bar-menu-toggle', function(e){
        var menuWidth = $("#adminmenuwrap").width();
        if($("#adminmenuwrap").is(":hidden")){
          $("body").addClass("menu-hidden");
          $("body").removeClass("menu-expanded");
          $("body").removeClass("menu-collapsed");
        }
        else if(menuWidth > 46){
          $("body").addClass("menu-expanded");
          $("body").removeClass("menu-hidden");
          $("body").removeClass("menu-collapsed");
        } else {
          $("body").addClass("menu-collapsed");
          $("body").removeClass("menu-expanded");
          $("body").removeClass("menu-hidden");
        }
      });
    };

    WPSTR_SETTINGS.logoURL = function() {

      $("#adminmenuwrap").prepend("<div class='logo-overlay'></div>");

      $(document).on('click', '#adminmenuwrap .logo-overlay', function(e){      
        var logourl = $("#wpstr-logourl").attr("data-value");
        if(logourl != ""){
          window.location = logourl;
        }
      });
    };


    WPSTR_SETTINGS.TopbarFixed = function() {
            var menu = $('#wpadminbar');
            if ($(window).scrollTop() > 60) {
                menu.addClass('showfixed');
                $("#wpcontent").addClass('hasfixedtopbar');
            } else {
                menu.removeClass('showfixed');
                $("#wpcontent").removeClass('hasfixedtopbar');
            }

    };


    WPSTR_SETTINGS.menuUserProfileInfo = function() {
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
                        console.log(window.innerHeight);
                        jQuery("#adminmenu").height(window.innerHeight - 100);
                        var links = jQuery("#wp-admin-bar-user-actions").html();
                        //console.log(links);
                        jQuery(".wpstr-menu-profile-links .all-links").html(links);
                        jQuery("#wp-admin-bar-my-account").remove();
                      }
                });
            }
              wpstr_menu_userinfo_ajax();
    };

    /******************************
     initialize respective scripts 
     *****************************/
    $(document).ready(function() {
        WPSTR_SETTINGS.menuResizer();
        WPSTR_SETTINGS.menuClickResize();
        WPSTR_SETTINGS.logoURL();

    Waves.attach('li a.menu-top', ['waves-button', 'waves-float', 'waves-ripple']);
    Waves.attach('.row-actions a', ['waves-button', 'waves-float', 'waves-ripple']);

    if($(".reduk-container").length == "0" && $(".usof-content").length == "0"){}
    Waves.init();
    
    
    $(document).on('click', "#screen-meta-links .screen-meta-toggle", function () {
        
        setInterval(function(){
          var h=$("#screen-meta").height();
          $("#screen-meta-links").css({'top':h});
          if(h > 0){
            $("#screen-meta-links").addClass("opened");
          } else {
            $("#screen-meta-links").removeClass("opened");
          }
        }, 1);

      });

    if($("#wpbody-content .wrap h1:not(.screen-reader-text)").length == 0){
        //console.log("noh1");
        $("#wpcontent").addClass("wpstr_nopagetitle");
    } else {
        $("#wpcontent").removeClass("wpstr_nopagetitle");
        //console.log("h1present");
    }



    });

    $(window).resize(function() {
        WPSTR_SETTINGS.menuResizer();
        WPSTR_SETTINGS.menuClickResize();

    });

    $(window).load(function() {
        WPSTR_SETTINGS.menuResizer();
        WPSTR_SETTINGS.menuClickResize();
    });

    $(window).scroll(function() {
        WPSTR_SETTINGS.TopbarFixed();
    });

});