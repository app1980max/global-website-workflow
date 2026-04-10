jQuery(function($) {

  'use strict';

  var WPSTR_LOGIN_SETTINGS = window.WPSTR_LOGIN_SETTINGS || {};

     WPSTR_LOGIN_SETTINGS.loginForm = function() {
      let width = $("#login form").width();
      let height = $("#login form").height();
      let wh = $(window).height();
      let ww = $(window).width();
      console.log(width +" "+ height + " " + wh);

      let mt = (wh - height) / 2;
      let ml = ((ww / 1.618) - width) / 2;

      $("#login form").css("margin-top", mt);
      $("#login form").css("left", ml);

    };

    /******************************
     initialize respective scripts 
     *****************************/
  $(document).ready(function() {
    WPSTR_LOGIN_SETTINGS.loginForm();
  });

  $(window).resize(function() {
      WPSTR_LOGIN_SETTINGS.loginForm();
  });

  $(window).load(function() {
      WPSTR_LOGIN_SETTINGS.loginForm();
  });
});