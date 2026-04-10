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


function wpstr_css_element_color($type) {
    global $wpstradmin;
    return ".btn-" . $type . ", .btn-" . $type . ".inverted:hover { background-color: " . $wpstradmin[$type . "-color"] . "; border-color: transparent;}
.btn-" . $type . ":hover, .btn-" . $type . ":focus, .btn-" . $type . ".inverted { border-color: " . $wpstradmin[$type . "-color"] . "; background-color:transparent; color: " . $wpstradmin[$type . "-color"] . ";}
.btn-" . $type . ":hover .fa, .btn-" . $type . ":focus .fa, .btn-" . $type . ".inverted .fa { color: " . $wpstradmin[$type . "-color"] . ";}
.btn-" . $type . ".inverted:hover, .btn-" . $type . ".inverted:hover .fa {color: #ffffff;} 
.alert-" . $type . "{ background-color: " . $wpstradmin[$type . "-color"] . "; color: white;}
.alert-" . $type . " .close .fa{color:white;}
.progress-bar-" . $type . " { background-color: " . $wpstradmin[$type . "-color"] . ";}

";
}

function wpstr_css_color($selector, $id, $opacity = "", $valuetype = "") {
    global $wpstradmin;
    if ($valuetype == "string") {
        $value = $id;
    } else {
        $value = $wpstradmin[$id];
        if (is_array($value) && sizeof($value) == 0) {
            return;
        } else if (is_array($value) && sizeof($value) > 0) {
            $value = $wpstradmin[$id]['regular'];
        }
        if ($value == "") {
            return;
        }
    }
    return " ".$selector . "{color:" . wpstr_hextorgba($value, $opacity) . " /*".$value."*/;} ";
}

function wpstr_css_shadow($selector, $id, $opacity = "", $side, $width, $string = "",$valuetype = "") {
    if ($width == "") {
        $width = "1px";
    }
    
    if ($side == "") {
        $side = "bottom";
    }

if ($side == "top") {
        $side_css = "0px ".$width." 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset";
    }
    if ($side == "right") {
        $side_css = "0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	-".$width." 0px 0px 0px color inset";
    }
    if ($side == "bottom") {
        $side_css = "0px 0px 0px 0px color inset, 
	0px -".$width." 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset";

    }
    if ($side == "left") {
        $side_css = "0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	".$width." 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset";
    }
    
    if ($side == "left-right" || $side == "right-left") {
        $side_css = "0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	".$width." 0px 0px 0px color inset, 
	-".$width." 0px 0px 0px color inset";
    }
    
    if ($side == "top-bottom" || $side == "bottom-top") {
        $side_css = "0px ".$width." 0px 0px color inset, 
	0px -".$width." 0px 0px color inset, 
	0px 0px 0px 0px color inset, 
	0px 0px 0px 0px color inset";
    }
    
    if ($side == "all" || $side == "top-right-bottom-left") {
        $side_css = "0px ".$width." 0px 0px color inset, 
	0px -".$width." 0px 0px color inset, 
	".$width." 0px 0px 0px color inset, 
	-".$width." 0px 0px 0px color inset";
    }
    
    
    if($side == "multiple"){
        $side_css = $string;
    }

    global $wpstradmin;
    
    if($string == "string"){
        $value = $id;
    } else if($valuetype == "string"){
        $value = $id;
    } else {
        $value = $wpstradmin[$id];
        if (is_array($value) && sizeof($value) == 0) {
            return;
        } else if (is_array($value) && sizeof($value) > 0) {
            $value = $wpstradmin[$id]['regular'];
        }
    }
    
    if ($value == "") {
        return;
    }
    
    
    /* Relative color code */ 
    /*    * * Darken Color - In box shadow the original color gets lighter ** */
    //    echo $value;
    $hex = $value;
    /*    
    //    echo "0. ".$hex . "[HEX]\n";
    $rgb = HTMLToRGB($hex);
    //    echo "1. ".$rgb . "[HEX to RGB]\n";
    $new_color = ChangeLuminosity($rgb, 63);
    //    echo "2. ".$new_color . "[Dark RGB (rgb-hsl-dark hsl-rgb)]\n";
    $new_hex = RGBToHTML($new_color);
    //    echo "3. ".$new_hex . "[HEX]\n";
    $value = $new_hex;
    //    echo "===========\n";
    */
    
    
        if($hex != "transparent"){ $color = wpstr_hextorgba($hex, $opacity);} else { $color = "transparent";} // same color as separator - no darker version
        $side_css = str_replace("color",$color,$side_css);
        return " ".$selector . "{box-shadow: " . $side_css . " ;\n"
            . "-webkit-box-shadow: " . $side_css . " ;\n"
            . "-o-box-shadow: " . $side_css . " ;\n"
            . "-moz-box-shadow: " . $side_css . " ;\n"
            . "-ms-box-shadow: " . $side_css . " /*".$hex."*/;} \n";
}

function wpstr_link_color($selector, $id, $opacity = "", $type = "", $valuetype = "") {
    global $wpstradmin;
    if($valuetype == "array"){
        $value = $id;
    } else {
        $value = $wpstradmin[$id];
    }

    if (sizeof($value) == 0) {
        return;
    }
    
    $selector_visited = $selector_hover = $selector_focus = "";
    $exp = explode(",", $selector);
    foreach ($exp as $single) {
        $selector_visited .= trim($single) . ":visited, ";
        $selector_hover .= trim($single) . ":hover, ";
        $selector_focus .= trim($single) . ":focus, ";
    }

    $selector_visited = substr($selector_visited, 0, -2);
    $selector_hover = substr($selector_hover, 0, -2);
    $selector_focus = substr($selector_focus, 0, -2);

    $regular = (isset($value['regular']) && $value['regular'] != "") ? $value['regular'] : $wpstradmin['primary-color'];
    $hover = (isset($value['hover']) && $value['hover'] != "") ? $value['hover'] : $regular;
    $active = (isset($value['active']) && $value['active'] != "") ? $value['active'] : $hover;
    $visited = (isset($value['visited']) && $value['visited'] != "") ? $value['visited'] : $regular;

    if (isset($type) && $type == "hover") {
        return $selector . "{color:" . wpstr_hextorgba($value['hover'], $opacity) . " /*".$value['hover']."*/;} ";
    } else {
        return $selector . "{color:" . wpstr_hextorgba($regular, $opacity) ." /*".$regular."*/;} " .
//                $selector_visited . " {color:" . wpstr_hextorgba($visited, $opacity) . ";} " .
                $selector_hover . " {color:" . wpstr_hextorgba($hover, $opacity) ." /*".$hover."*/;} " .
                $selector_focus . " {color:" . wpstr_hextorgba($hover, $opacity) ." /*".$hover."*/;} \n";
    }
}

function wpstr_css_bgcolor($selector, $id, $opacity = "", $valuetype = "",$important = "") {
    global $wpstradmin;

    $imp = "";
    if($important == "imp"){
        $imp = "!important";
    }
    
    if ($valuetype == "string") {
        $value = $id;
    } else if($valuetype == "luminosity"){
        $value = $wpstradmin[$id];
        $hex = $value;  /*HEX*/
        $rgb = wpstr_HTMLToRGB($hex); /*HEX to RGB*/
        $new_color = wpstr_ChangeLuminosity($rgb, $opacity); /*rgb-hsl-new hsl-rgb*/
        $new_hex = wpstr_RGBToHTML($new_color); /*HEX*/
        $value = $new_hex;
    }else {
        $value = $wpstradmin[$id];
        if (is_array($value) && sizeof($value) == 0) {
            return;
        } else if (is_array($value) && sizeof($value) > 0) {
            $value = $wpstradmin[$id]['regular'];
        }
        if ($value == "") {
            return;
        }
    }
    $color = "";
    if($value == "transparent"){ $color = "transparent"; } 
    else if(strpos($value,"rgba") !== false){ $color = $value;}
    else {$color = wpstr_hextorgba($value, $opacity);}
    return " ".$selector . "{background-color:" . $color .$imp." /*".$value."*/;} ";
}

function wpstr_css_border_color($selector, $id, $opacity = "", $bordertype, $valuetype = "") {
    global $wpstradmin;
    
    if ($valuetype == "string") {
        $value = $id;
    } else {
        $value = $wpstradmin[$id];
        if (is_array($value) && sizeof($value) == 0) {
            return;
        } else if (is_array($value) && sizeof($value) > 0) {
            if (isset($wpstradmin[$id]['regular'])) {
                $value = $wpstradmin[$id]['regular'];
            }
        }
    }
    if ($value == "") {
        return;
    }
    
    
    if ($bordertype == "all") {
        $css_property = "border-color";
    } else if ($bordertype == "top") {
        $css_property = "border-top-color";
    } else if ($bordertype == "right") {
        $css_property = "border-right-color";
    } else if ($bordertype == "bottom") {
        $css_property = "border-bottom-color";
    } else if ($bordertype == "left") {
        $css_property = "border-left-color";
    }
    
    $color = "";
    if($value != "transparent"){ $color = wpstr_hextorgba($value, $opacity);} else { $color = "transparent";}
    
    return " ".$selector . "{" . $css_property . ":" . $color ." /*".$value."*/;}\n ";
}

function wpstr_css_background($selector, $id, $opacity = "",$type = "",$important = "") {
    global $wpstradmin;
    if($type == "array"){
        $value = $id;
    } else {
        $value = $wpstradmin[$id];
    }

    $imp = "";
    if($important == "imp"){
        $imp = "!important";
    }

    if(!isset($value['background-image'])){$value['background-image'] = "";}
    if(!isset($value['background-repeat'])){$value['background-repeat'] = "";}
    if(!isset($value['background-color'])){$value['background-color'] = "";}
    if(!isset($value['background-size'])){$value['background-size'] = "";}
    if(!isset($value['background-attachment'])){$value['background-attachment'] = "";}
    if(!isset($value['background-position'])){$value['background-position'] = "";}


    $bg_image = "";
    $wpstradminID = $value['background-image'];
    if (isset($wpstradminID) && trim($wpstradminID) != "") {
        $bg_image = "background-image:url(" . $wpstradminID . ")".$imp."; ";
    }

    $bg_color = "";
    $wpstradminID = $value['background-color'];
    $colorcode = wpstr_colorcode($wpstradminID,$opacity,$imp);
    $bg_color = "background-color: ".$colorcode."; ";
    
    $bg_repeat = "";
    $wpstradminID = $value['background-repeat'];
    if (isset($wpstradminID) && trim($wpstradminID) != "") {
        $bg_repeat = "background-repeat:" . $wpstradminID . "".$imp."; ";
    }

    $bg_size = "";
    $wpstradminID = $value['background-size'];
    if (isset($wpstradminID) && trim($wpstradminID) != "") {
        $bg_size = "-webkit-background-size:" . $wpstradminID . "".$imp."; "
                . "-moz-background-size:" . $wpstradminID . "".$imp."; "
                . "-o-background-size:" . $wpstradminID . "".$imp."; "
                . "background-size:" . $wpstradminID . "".$imp."; ";
    }

    $bg_attach = "";
    $wpstradminID = $value['background-attachment'];
    if (isset($wpstradminID) && trim($wpstradminID) != "") {
        $bg_attach = "background-attachment:" . $wpstradminID . "".$imp."; ";
    }

    $bg_pos = "";
    $wpstradminID = $value['background-position'];
    if (isset($wpstradminID) && trim($wpstradminID) != "") {
        $bg_pos = "background-position:" . $wpstradminID . "".$imp."; ";
    }


    return " ".$selector . "{" . $bg_color . $bg_image . $bg_pos . $bg_attach . $bg_size . $bg_repeat . "} ";
}

function wpstr_hextorgba($value, $opacity) {
    if ($opacity == "" || !isset($opacity)) {
        $opacity = 1;
    }
    $rgb = wpstr_hex2rgb($value);
    return "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ",$opacity)";
}






function wpstr_colorcode($color,$opacity = "",$addstr = ""){
        $ret = $color;
        $code = "";
        if($opacity == ""){$opacity = "1.0";}
        global $wpstradmin;
        //$wpstradmin = wpstr_color();
        
        if (isset($color) &&  trim($color) != "" &&  trim($color) != "#") {
        if ($color == "transparent") {
            $ret = "transparent".$addstr."; ";
        } else if ($color == "primary") {
            $ret = $wpstradmin['primary-color'].$addstr."; ";
        } else if ($color == "primary2") {
            $ret = $wpstradmin['primary2-color'].$addstr."; ";
        } else if ($color == "secondary") {
            $ret = $wpstradmin['secondary-color'].$addstr."; ";
        } else if(strpos($color,"rgb") !== false){
            $ret = $color.$addstr."; ";
        } else if(strpos($color,"/") !== false){
            $colorexp = explode("/",$color);
            if(trim($colorexp[0]) == "primary"){ $code = $wpstradmin['primary-color'];}
            else if(trim($colorexp[0]) == "primary2"){ $code = $wpstradmin['primary2-color'];}
            else if(trim($colorexp[0]) == "secondary"){ $code = $wpstradmin['secondary-color'];}
            else {$code = trim($colorexp[0]);}
            if(trim($colorexp[1]) != ""){$opacity = trim($colorexp[1]);}
            $ret = wpstr_hextorgba($code, $opacity).$addstr ." /*".$code."*/; ";
        } else {
            $ret = wpstr_hextorgba($color, $opacity).$addstr ." /*".$color."*/; ";
//            $ret = $color ." /*".$color."*/; ";
        }
    }
    
return $ret;
    
}


?>