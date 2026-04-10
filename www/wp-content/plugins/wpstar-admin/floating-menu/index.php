<?php
function wpstr_floating_menu_settings()
{

  global $wpstradmin;
  $wpstradmin = wpstradmin_network($wpstradmin);
  $element = "floatingmenu-enable";
  if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) == "1") {


    $floatstyle = "slidein";
    $floatpos = "br";
    if (isset($wpstradmin['floatingmenu-pos']) && trim($wpstradmin['floatingmenu-pos']) != "") {
      $floatpos = $wpstradmin['floatingmenu-pos'];
    }

    $floatopen = "hover";
    if (isset($wpstradmin['floatingmenu-open']) && trim($wpstradmin['floatingmenu-open']) != "") {
      $floatopen = $wpstradmin['floatingmenu-open'];
    }


?>



    <ul id="wpstr-floatingmenu" class="fmenu--<?php echo $floatpos; ?> wpstrfm-<?php echo $floatstyle; ?>" data-wpstrfm-toggle="<?php echo $floatopen; ?>">
      <li class="fmenu__wrap">
        <a href="#" class="fmenu__button--main">
          <i class="fmenu__main-icon--resting dashicons-before dashicons-menu"></i>
          <i class="fmenu__main-icon--active dashicons-before dashicons-no"></i>
        </a>
        <ul class="fmenu__list">
          <?php
          $floating_links_arr = array();
          $floating_links_arr[] = $wpstradmin['floatingmenu-links-1'];
          $floating_links_arr[] = $wpstradmin['floatingmenu-links-2'];
          $floating_links_arr[] = $wpstradmin['floatingmenu-links-3'];
          $floating_links_arr[] = $wpstradmin['floatingmenu-links-4'];
          $floating_links_arr[] = $wpstradmin['floatingmenu-links-5'];

          foreach ($floating_links_arr as $key => $value) {
            if (trim($value) != "") {
              $exp = explode("|", $value);
              if (sizeof($exp) == 3) {
                $title = trim($exp[0]);
                $icon = trim($exp[1]);
                $link = trim($exp[2]);
                $link = str_replace("ADMINURL/", admin_url(), $link);
                echo "<li><a href='" . $link . "' class='fmenu__button--child'><i class='fmenu__child-icon " . $icon . "'></i></a><span data-wpstrfm-label='" . $title . "'></span></li>";
              }
            }
          }
          ?>
        </ul>
      </li>
    </ul>

<?php



  }
}
?>