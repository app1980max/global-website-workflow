/**
 * @Package: WordPress Plugin
 * @Subpackage: Wpstr - White Label WordPress Admin Theme
 * @Since: Wpstr 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Wpstr - White Label WordPress Admin Theme Plugin.
 */


jQuery(function($) {

    'use strict';

    var WPSTR_LOGIN_SETTINGS = window.WPSTR_LOGIN_SETTINGS || {};


    WPSTR_LOGIN_SETTINGS.placeholderFields = function() {



        $('#user_login').attr('placeholder', 'Username');
        $('#user_email').attr('placeholder', 'Email');
        $('#user_pass').attr('placeholder', 'Password');

    };



    /******************************
     initialize respective scripts 
     *****************************/
    $(document).ready(function() {
        WPSTR_LOGIN_SETTINGS.placeholderFields();

    });

    $(window).resize(function() {
    });

    $(window).load(function() {
    });

});