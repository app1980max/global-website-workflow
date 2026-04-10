<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: WPStar - White Label WordPress Admin Theme Theme
 * @Since: Wpstr 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of WPStar - White Label WordPress Admin Theme Theme Plugin.
 */
?>
<?php

function wpstr_css_fonts() {

    global $wpstradmin;

    $bodyfont = "Poppins, -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
    $menufont = "Poppins, -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif ";
    $buttonfont = "Poppins, -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif ";
    $headingfont = "Poppins, -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";

    $body_letter_spacing = $body_word_spacing = "";
    $heading_letter_spacing = $heading_word_spacing = "";
    $menu_letter_spacing = $menu_word_spacing = "";
    $button_letter_spacing = $button_word_spacing = "";

    $body_font_weight = "font-weight:400; ";
    $menu_font_weight = "font-weight:400; ";
    $button_font_weight = "font-weight:400; ";
    $heading_font_weight = "font-weight:400; ";

    $body_font_style = "font-style:normal; ";
    $menu_font_style = "font-style:normal; ";
    $button_font_style = "font-style:normal; ";
    $heading_font_style = "font-style:normal; ";


    $body_font_size = "font-size:15px; ";
    $body_line_height = "line-height:23px; ";

    $menu_font_size = "font-size:14px; ";
    $menu_line_height = "line-height:23px; ";

    $button_font_size = "font-size:15px; ";
    $button_line_height = "line-height:23px; ";


    if (isset($wpstradmin['google_body']) && sizeof($wpstradmin['google_body']) && trim($wpstradmin['google_body']['font-family']) != "") {
        $bodyfont = "'".$wpstradmin['google_body']['font-family']."'";

        if (isset($wpstradmin['google_body']['font-backup'])) {
            $bodyfont .= ", " . $wpstradmin['google_body']['font-backup'].", -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
        } else {
            $bodyfont .= ", -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
        }
        if (isset($wpstradmin['google_body']['letter-spacing']) && trim(($wpstradmin['google_body']['letter-spacing']) != "")) {
            $body_letter_spacing = "letter-spacing:" . $wpstradmin['google_body']['letter-spacing'] . "; ";
        }
        if (isset($wpstradmin['google_body']['word-spacing']) && trim(($wpstradmin['google_body']['word-spacing']) != "")) {
            $body_word_spacing = "word-spacing:" . $wpstradmin['google_body']['word-spacing'] . "; ";
        }
        if (isset($wpstradmin['google_body']['font-weight']) && trim(($wpstradmin['google_body']['font-weight']) != "")) {
            $body_font_weight = "font-weight:" . $wpstradmin['google_body']['font-weight'] . "; ";
        }
        if (isset($wpstradmin['google_body']['font-style']) && trim(($wpstradmin['google_body']['font-style']) != "")) {
            $body_font_style = "font-style:" . $wpstradmin['google_body']['font-style'] . "; ";
        }
        if (isset($wpstradmin['google_body']['font-size']) && trim(($wpstradmin['google_body']['font-size']) != "")) {
            $body_font_size = "font-size:" . $wpstradmin['google_body']['font-size'] . "; ";
        }
        if (isset($wpstradmin['google_body']['line-height']) && trim(($wpstradmin['google_body']['line-height']) != "")) {
            $body_line_height = "line-height:" . $wpstradmin['google_body']['line-height'] . "; ";
        }
    }




    if (isset($wpstradmin['google_nav']) && sizeof($wpstradmin['google_nav']) && trim($wpstradmin['google_nav']['font-family']) != "") {
        $menufont = "'".$wpstradmin['google_nav']['font-family']."'";

        if (isset($wpstradmin['google_nav']['font-backup'])) {
            $menufont .= ", " . $wpstradmin['google_nav']['font-backup'].", -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
        } else {
            $menufont .= ", -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
        }
        if (isset($wpstradmin['google_nav']['letter-spacing']) && trim(($wpstradmin['google_nav']['letter-spacing']) != "")) {
            $menu_letter_spacing = "letter-spacing:" . $wpstradmin['google_nav']['letter-spacing'] . "; ";
        }
        if (isset($wpstradmin['google_nav']['word-spacing']) && trim(($wpstradmin['google_nav']['word-spacing']) != "")) {
            $menu_word_spacing = "word-spacing:" . $wpstradmin['google_nav']['word-spacing'] . "; ";
        }
        if (isset($wpstradmin['google_nav']['font-weight']) && trim(($wpstradmin['google_nav']['font-weight']) != "")) {
            $menu_font_weight = "font-weight:" . $wpstradmin['google_nav']['font-weight'] . "; ";
        }
        if (isset($wpstradmin['google_nav']['font-style']) && trim(($wpstradmin['google_nav']['font-style']) != "")) {
            $menu_font_style = "font-style:" . $wpstradmin['google_nav']['font-style'] . "; ";
        }
        if (isset($wpstradmin['google_nav']['font-size']) && trim(($wpstradmin['google_nav']['font-size']) != "")) {
            $menu_font_size = "font-size:" . $wpstradmin['google_nav']['font-size'] . "; ";
        }
        if (isset($wpstradmin['google_nav']['line-height']) && trim(($wpstradmin['google_nav']['line-height']) != "")) {
            $menu_line_height = "line-height:" . $wpstradmin['google_nav']['line-height'] . "; ";
        }
    }




    if (isset($wpstradmin['google_button']) && sizeof($wpstradmin['google_button']) && trim($wpstradmin['google_button']['font-family']) != "") {
        $buttonfont = "'".$wpstradmin['google_button']['font-family']."'";

        if (isset($wpstradmin['google_button']['font-backup'])) {
            $buttonfont .= ", " . $wpstradmin['google_button']['font-backup'].", -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
        } else {
            $buttonfont .= ", -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
        }
        if (isset($wpstradmin['google_button']['letter-spacing']) && trim(($wpstradmin['google_button']['letter-spacing']) != "")) {
            $button_letter_spacing = "letter-spacing:" . $wpstradmin['google_button']['letter-spacing'] . "; ";
        }
        if (isset($wpstradmin['google_button']['word-spacing']) && trim(($wpstradmin['google_button']['word-spacing']) != "")) {
            $button_word_spacing = "word-spacing:" . $wpstradmin['google_button']['word-spacing'] . "; ";
        }
        if (isset($wpstradmin['google_button']['font-weight']) && trim(($wpstradmin['google_button']['font-weight']) != "")) {
            $button_font_weight = "font-weight:" . $wpstradmin['google_button']['font-weight'] . "; ";
        }
        if (isset($wpstradmin['google_button']['font-style']) && trim(($wpstradmin['google_button']['font-style']) != "")) {
            $button_font_style = "font-style:" . $wpstradmin['google_button']['font-style'] . "; ";
        }
        if (isset($wpstradmin['google_button']['font-size']) && trim(($wpstradmin['google_button']['font-size']) != "")) {
            $button_font_size = "font-size:" . $wpstradmin['google_button']['font-size'] . "; ";
        }
        if (isset($wpstradmin['google_button']['line-height']) && trim(($wpstradmin['google_button']['line-height']) != "")) {
            $button_line_height = "line-height:" . $wpstradmin['google_button']['line-height'] . "; ";
        }
    }




    if (isset($wpstradmin['google_headings']) && sizeof($wpstradmin['google_headings']) && trim($wpstradmin['google_headings']['font-family']) != "") {
        $headingfont = "'".$wpstradmin['google_headings']['font-family']."'";

        if (isset($wpstradmin['google_headings']['font-backup'])) {
            $headingfont .= ", " . $wpstradmin['google_headings']['font-backup'].", -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
        } else {
            $headingfont .= ", -apple-system, BlinkMacSystemFont, 'Segoe UI', Poppins, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif";
        }
        if (isset($wpstradmin['google_headings']['letter-spacing']) && trim(($wpstradmin['google_headings']['letter-spacing']) != "")) {
            $heading_letter_spacing = "letter-spacing:" . $wpstradmin['google_headings']['letter-spacing'] . "; ";
        }
        if (isset($wpstradmin['google_headings']['word-spacing']) && trim(($wpstradmin['google_headings']['word-spacing']) != "")) {
            $heading_word_spacing = "word-spacing:" . $wpstradmin['google_headings']['word-spacing'] . "; ";
        }
        if (isset($wpstradmin['google_headings']['font-weight']) && trim(($wpstradmin['google_headings']['font-weight']) != "")) {
            $heading_font_weight = "font-weight:" . $wpstradmin['google_headings']['font-weight'] . "; ";
        }
        if (isset($wpstradmin['google_headings']['font-style']) && trim(($wpstradmin['google_headings']['font-style']) != "")) {
            $headings_font_style = "font-style:" . $wpstradmin['google_headings']['font-style'] . "; ";
        }
    }


//    else if(isset($wpstradmin['standard_body']) && trim($wpstradmin['standard_body']) != ""){ $bodyfont = "".$wpstradmin['standard_body']."";}
//    if(isset($wpstradmin['google_nav']) && trim($wpstradmin['google_nav']) != ""){ $menufont = "'".$wpstradmin['google_nav']."', sans-serif"; }
//    else if(isset($wpstradmin['standard_nav']) && trim($wpstradmin['standard_nav']) != ""){ $menufont = "".$wpstradmin['standard_nav']."";}
//    if(isset($wpstradmin['google_headings']) && trim($wpstradmin['google_headings']) != ""){ $headingfont = "'".$wpstradmin['google_headings']."', sans-serif"; }
//    else if(isset($wpstradmin['standard_headings']) && trim($wpstradmin['standard_headings']) != ""){ $headingfont = "".$wpstradmin['standard_headings']."";}


$ret = array();
$ret['body_font_css'] = "font-family: " . $bodyfont . ";" . $body_letter_spacing . " " . $body_word_spacing . " " . $body_font_weight . " " . $body_font_size . " " . $body_line_height . " ".$body_font_style;
$ret['head_font_css'] = "font-family: " . $headingfont . ";" . $heading_letter_spacing . " " . $heading_word_spacing . " " . $heading_font_weight . " ".$heading_font_style;
$ret['menu_font_css'] = " font-family: " . $menufont . ";" . $menu_letter_spacing . " " . $menu_word_spacing . " " . $menu_font_weight . " " . $menu_font_size . " " . $menu_line_height . " ".$menu_font_style;
$ret['button_font_css'] = " font-family: " . $buttonfont . ";" . $button_letter_spacing . " " . $button_word_spacing . " " . $button_font_weight . " " . $button_font_size . " " . $button_line_height . " ".$button_font_style;



return $ret;
}


function wpstr_fonts() {
    global $wpstradmin;
    $gfont = array();

    if (isset($wpstradmin['google_body']) && sizeof($wpstradmin['google_body']) && trim($wpstradmin['google_body']['font-family']) != "") {
        $font = $wpstradmin['google_body']['font-family'];
        $font = str_replace(", " . $wpstradmin['google_body']['font-backup'], "", $font);
        $gfont[urlencode($font)] = '"' . urlencode($font) . ':400,300,600,700:latin"';
    }

    if (isset($wpstradmin['google_nav']) && sizeof($wpstradmin['google_nav']) && trim($wpstradmin['google_nav']['font-family']) != "" 
        && $wpstradmin['google_nav']['font-family'] != $wpstradmin['google_body']['font-family']) {
        $font = $wpstradmin['google_nav']['font-family'];
        $font = str_replace(", " . $wpstradmin['google_nav']['font-backup'], "", $font);
        $gfont[urlencode($font)] = '"' . urlencode($font) . ':400,300,600,700:latin"';
    }

    if (isset($wpstradmin['google_headings']) && sizeof($wpstradmin['google_headings']) && trim($wpstradmin['google_headings']['font-family']) != "" 
        && $wpstradmin['google_headings']['font-family'] != $wpstradmin['google_body']['font-family'] 
        && $wpstradmin['google_headings']['font-family'] != $wpstradmin['google_nav']['font-family']) {
        $font = $wpstradmin['google_headings']['font-family'];
        $font = str_replace(", " . $wpstradmin['google_headings']['font-backup'], "", $font);
        $gfont[urlencode($font)] = '"' . urlencode($font) . ':400,300,600,700:latin"';
    }

    if (isset($wpstradmin['google_button']) && sizeof($wpstradmin['google_button']) && trim($wpstradmin['google_button']['font-family']) != "" 
        && $wpstradmin['google_button']['font-family'] != $wpstradmin['google_body']['font-family'] 
        && $wpstradmin['google_button']['font-family'] != $wpstradmin['google_headings']['font-family'] 
        && $wpstradmin['google_button']['font-family'] != $wpstradmin['google_nav']['font-family']) {
        $font = $wpstradmin['google_button']['font-family'];
        $font = str_replace(", " . $wpstradmin['google_button']['font-backup'], "", $font);
        $gfont[urlencode($font)] = '"' . urlencode($font) . ':400,300,600,700:latin"';
    }

    $gfonts = "";
    if ($gfont) {
        if (is_array($gfont) && !empty($gfont)) {
            $gfonts = implode(', ',$gfont);
        }
    }
    ?>

    <!-- Fonts - Start -->        
    <script type="text/javascript">
        WebFontConfig = {
    <?php if (!empty($gfonts)): ?>google: {families: [<?php echo $gfonts; ?>]},<?php endif; ?>
            custom: {}
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>
    <!-- Fonts - End -->        

    <?php
}
?>