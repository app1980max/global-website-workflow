/**
 * @Package: WordPress Plugin
 * @Subpackage: WPStar - White Label WordPress Admin Theme Theme
 * @Since: Wpstr 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of WPStar - White Label WordPress Admin Theme Theme Plugin.
 */


jQuery(function($) {

    'use strict';

    var WPSTR_MENUMNG_SETTINGS = window.WPSTR_MENUMNG_SETTINGS || {};

    

    WPSTR_MENUMNG_SETTINGS.iconPanel = function(e) {

      $(document).on("click",".wpstricon",function(e) {
        e.stopPropagation();
        var panel = $(this).parent().find(".wpstriconpanel");
        var iconstr = $(".wpstricons").html();
        panel.html("");
        panel.append(iconstr);
        panel.show();
      });


    };




    WPSTR_MENUMNG_SETTINGS.menuToggle = function() {

      $(document).on("click",".wpstrtoggle",function(e) {

        var id = $(this).parent().attr("data-id");

        if($(this).hasClass("plus")) {
          $(this).removeClass("plus dashicons-plus").addClass("minus dashicons-minus");
          //$(this).html("-");
          $(this).parent().parent().find(".wpstrmenupanel").removeClass("closed").addClass("opened");
        } else if($(this).hasClass("minus")) {
          $(this).removeClass("minus dashicons-minus").addClass("plus dashicons-plus");
          //$(this).html("+");
          $(this).parent().parent().find(".wpstrmenupanel").removeClass("opened").addClass("closed");
        }

      });


      $(document).on("click",".wpstrsubtoggle",function(e) {

        var id = $(this).parent().attr("data-id");

        if($(this).hasClass("plus")) {
          $(this).removeClass("plus dashicons-plus").addClass("minus dashicons-minus");
          //$(this).html("-");
          $(this).parent().parent().find(".wpstrsubmenupanel").removeClass("closed").addClass("opened");
        } else if($(this).hasClass("minus")) {
          $(this).removeClass("minus dashicons-minus").addClass("plus dashicons-plus");
          //$(this).html("+");
          $(this).parent().parent().find(".wpstrsubmenupanel").removeClass("opened").addClass("closed");
        }

      });


    };

    WPSTR_MENUMNG_SETTINGS.saveMenu = function() {

      $(document).on('click', '#wpstr-savemenu', function(e){


      // });      
      // $('#wpstr-savemenu').click(function(e) {

          var neworder = "";
          var newsuborder = "";
          var menurename = "";
          var submenurename = "";
          var menudisable = "";
          var submenudisable = "";

          $(".wpstrmenu").each(function(){
                    var id = $(this).attr("data-id");
                    var menuid = $(this).attr("data-menu-id");
                    neworder += menuid+"|";
                    if($(this).hasClass("disabled")){
                      menudisable += menuid+"|";
                    }
          });

          $(".wpstrsubmenu").each(function(){
                    var id = $(this).attr("data-id");
                    var parentpage = $(this).attr("data-parent-page");
                    newsuborder += parentpage+":"+id+"|";
                    if($(this).hasClass("disabled")){
                      submenudisable += parentpage+":"+id+"|";
                    }
          });

          $(".wpstr-menurename").each(function(){
                    var id = $(this).attr("data-id");
                    var sid = $(this).attr("data-menu-id");
                    var val = $(this).val();
                    var icon = $(this).parent().parent().find(".wpstr-menuicon").attr("value");
                    //console.log(icon);
                    // menurename += id+":"+sid+"@!@%@"+val+"[$!&!$]"+icon+"|#$%*|";
                    menurename += sid+"@!@%@"+val+"[$!&!$]"+icon+"|#$%*|";
                    // console.log(val);
          });


          $(".wpstr-submenurename").each(function(){
                    var id = $(this).attr("data-id");
                    var parent = $(this).attr("data-parent-id");
                    var parentpage = $(this).attr("data-parent-page");
                    var val = $(this).val();
                    // submenurename += parentpage+"[($&)]"+parent+":"+id+"@!@%@"+val+"|#$%*|";
                    submenurename += parentpage+"[($&)]"+id+"@!@%@"+val+"|#$%*|";
                    // console.log(val);
          });


          // console.log(neworder);
          // console.log(menurename);

            var action = 'wpstr_savemenu';
            var data = {
                neworder: neworder,
                newsuborder: newsuborder,
                menurename: menurename,
                submenurename: submenurename,
                menudisable: menudisable,
                submenudisable: submenudisable,
                action: action,
                wpstr_nonce: wpstr_vars.wpstr_nonce
            };

        $.post(ajaxurl, data, function(response) {
             //console.log(response);
             location.reload();
            //console.log(response);
        });

        return false;

        });

    };


    WPSTR_MENUMNG_SETTINGS.resetMenu = function() {

      $(document).on('click', '#wpstr-resetmenu', function(e){

            var action = 'wpstr_resetmenu';
            var data = {
                action: action,
                wpstr_nonce: wpstr_vars.wpstr_nonce
            };

        $.post(ajaxurl, data, function(response) {
             location.reload();
            //console.log(response);
        });

        return false;

        });

    };





    WPSTR_MENUMNG_SETTINGS.menuDisplay = function() {

      $(document).on('click', '.wpstrdisplay, .wpstrsubdisplay', function(e){


        //var id = $(this).parent().attr("data-id");

        if($(this).hasClass("disable")) {
          $(this).removeClass("disable").addClass("enable");
          //$(this).html("show");
          $(this).parent().parent().removeClass("enabled").addClass("disabled");
        } else if($(this).hasClass("enable")) {
          $(this).removeClass("enable").addClass("disable");
          //$(this).html("hide");
          $(this).parent().parent().removeClass("disabled").addClass("enabled");
        }

      });

    };


    /******************************
     initialize respective scripts 
     *****************************/
    $(document).ready(function() {
       
        WPSTR_MENUMNG_SETTINGS.menuToggle();
        WPSTR_MENUMNG_SETTINGS.saveMenu();
        WPSTR_MENUMNG_SETTINGS.menuDisplay();
        WPSTR_MENUMNG_SETTINGS.iconPanel();
        WPSTR_MENUMNG_SETTINGS.resetMenu();
       

    });


});



jQuery(function($) {
    if($.isFunction($.fn.sortable)){
        $( "#wpstr-enabled, #wpstr-disabled" ).sortable({
          connectWith: ".wpstr-connectedSortable",
          handle: ".wpstrmenu-wrap",
          cancel: ".wpstrtoggle",
          placeholder: "ui-state-highlight",
        }).disableSelection();
      }
  });


jQuery(function($) {
    if($.isFunction($.fn.sortable)){
      $( ".wpstrsubmenu-wrap" ).sortable({
        placeholder: "ui-state-highlight",
      }).disableSelection();
  }
  });


jQuery(function($) {
  $(document).ready(function(){
    $(document).on('click', ".pickicon", function () {
          var clss = $(this).attr("data-class");
          var prnt = $(this).parent().parent();
          //console.log(clss);
          prnt.find("input").attr("value",clss);
          prnt.find("input").val(clss);
          var main = prnt.find(".wpstrmenuicon");
          main.removeClass(main.attr("data-class")).addClass(clss);
          main.attr("data-class",clss);
          return false;
      });

    $(document).on('click', "body", function () {
          $(".wpstriconpanel").hide();
          //return false;
      });



    });
});
