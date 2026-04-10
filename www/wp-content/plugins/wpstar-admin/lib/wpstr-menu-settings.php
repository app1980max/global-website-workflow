<?php
$get_menumng_page = wpstr_get_option("wpstradmin_menumng_page","enable");


function wpstr_menumng_settings_page(){

	// global $menu;
	// echo "<pre>";
	// 	print_r($menu);
	// echo "</pre>";
	// die;

	global $wpstr_css_ver;
    
    $url = plugins_url('/', __FILE__).'../'.$wpstr_css_ver.'/wpstr-admin-menu-management.min.css';
    wp_deregister_style('wpstr-admin-menu-management', $url);
    wp_register_style('wpstr-admin-menu-management', $url);
    wp_enqueue_style('wpstr-admin-menu-management');


    global $wp_version;
    $plug = trim(get_current_screen()->id);

    if (isset($plug) && $plug == "wpstar-admin-addon_page_wpstr_menumng_settings"){

        $url = plugins_url('/', __FILE__).'../js/wpstr-scripts-menu-management.js';
        wp_deregister_script('wpstr-scripts-menu-management-js');
        wp_register_script('wpstr-scripts-menu-management-js', $url);
        wp_enqueue_script('wpstr-scripts-menu-management-js');

        $url = plugins_url('/', __FILE__).'../css/jquery-ui/minified/jquery-ui.min.css';
        wp_deregister_style('wpstr-jqueryui');
        wp_register_style('wpstr-jqueryui', $url);
        wp_enqueue_style('wpstr-jqueryui');

        $url = plugins_url('/', __FILE__).'../js/wpstr-jquery.ui.elements.js';
        wp_deregister_script('wpstr-jqueryui');
        wp_register_script('wpstr-jqueryui', $url);
        wp_enqueue_script('wpstr-jqueryui');

        wp_localize_script('wpstr-scripts-menu-management-js', 'wpstr_vars', array(
            'wpstr_nonce' => wp_create_nonce('wpstr-nonce')
                )
        );

    }



	global $menu;
	global $submenu;
	global $wpstrmenu;
	global $wpstrsubmenu;

	// print_r($wpstrmenu);
	// wpstradmin_menuorder
	$get_menuorder = wpstr_get_option("wpstradmin_menuorder","");
	$get_submenuorder = wpstr_get_option("wpstradmin_submenuorder","");

	if($get_menuorder == ""){
		$wpstrmenu = $menu;
	}

	if($get_submenuorder == ""){
		$wpstrsubmenu = $submenu;
	}


	// if(!is_array($wpstrmenu) || sizeof($wpstrmenu) == 0){
	// 	$wpstrmenu = $menu;
	// }

	// if(!is_array($wpstrsubmenu) || sizeof($wpstrsubmenu) == 0){
	// 	$wpstrsubmenu = $submenu;
	// }

	// wpstrprint('menu',$menu);
	// wpstrprint('submenu',$submenu);
	// wpstrprint('wpstrmenu',$wpstrmenu);
	//wpstrprint('wpstrsubmenu',$wpstrsubmenu);


	echo '<div class="wrap"><h1>'.__( 'Admin Menu Management', 'wpstr_framework' ).'</h1><div id="wpstr-enabled" class="wpstr-connectedSortable">';
	    	$menudisable = wpstr_get_option("wpstradmin_menudisable","");
	    $menudisablearr = array_unique(array_filter(explode("|", $menudisable)));

		    $submenudisable = wpstr_get_option("wpstradmin_submenudisable","");

	    $submenudisablearr = array_unique(array_filter(explode("|", $submenudisable)));

		foreach ($wpstrmenu as $menuid => $menuarr) {

			/*---------------- 
				menu tab 
			----------------*/
			// echo $menuid."<br>";
			// print_r($menuarr);

			//if($menuarr[4] == "wp-menu-separator"){
			if(strpos($menuarr[4], "wp-menu-separator") !== false){
				// separator
				//echo "<div class='wpstrmenusep' data-id='".$menuid."'><span class='wpstrtext'>".$menuarr[0]."</span></div>";
			} else {
				// menu item

				$tabid = $menuid;
				if(isset($menuarr['original'])){ $tabid = $menuarr['original'];}

				$sid = $tabid;
				if(isset($menuarr[5])){
					$sid = $menuarr[5];
				}

				$menupage = $tabid;
				if(isset($menuarr[2])){
					$menupage = $menuarr[2];
				}				

				//print_r($menuarr);
				$expstr = explode("<", $menuarr[0]);
				$menuarr[0] = $expstr[0];

				$originalname = $menuarr[0];
				//echo $originalname;
				if(isset($menuarr['originalname'])){
					$originalname = $menuarr['originalname'];
				}

				$expstr = explode("<", $originalname);
				$originalname = $expstr[0];

				$originalicon = "";
				if(isset($menuarr[6])){
				$originalicon = $menuarr[6];
				if(isset($menuarr['originalicon'])){
					$originalicon = $menuarr['originalicon'];
				}}

				$disabled = " enabled ";
				$disablebutclass = "disable";
				$disablebuttext = "hide";
				if(isset($menuarr[5]) && in_array($menuarr[5],$menudisablearr)){ 
					$disabled = " disabled "; 
					$disablebutclass = " enable ";
					$disablebuttext = "show";
				}


				echo "<div class='wpstrmenu ".$disabled."' data-id='".$tabid."' data-menu-id='".$sid."'>

						<div class='wpstrmenu-wrap'>
							<span class='wpstricon wp-menu-image dashicons-before ".$menuarr[6]."'></span>
							<span class='wpstrtext'>".strip_tags($menuarr[0])."</span>
							<span class='wpstrtoggle plus wp-menu-image dashicons-before dashicons-plus'></span>
							<span class='wpstrdisplay wp-menu-image dashicons-before dashicons-visibility ".$disablebutclass."'></span>
							<span class='wpstrmove wp-menu-image dashicons-before dashicons-editor-expand'></span>
						</div>
						<div class='clearboth'></div>

						<span class='wpstreditpanel wpstrmenupanel closed'>
							<div>
							<span class='ufield'>".__( 'Original', 'wpstr_framework' ).":</span>
							<span class='uvalue'>".$originalname."</span>
								<div class='clearboth'></div>
								<span class='ufield'>".__( 'Rename to', 'wpstr_framework' ).":</span>
								<span class='uvalue'><input type='text' data-id='".$tabid."' data-menu-id='".$sid."' class='wpstr-menurename' value='".wpstr_reformatstring($menuarr[0])."'></span>
								<div class='clearboth'></div>
								<span class='ufield'>".__( 'Menu Icon', 'wpstr_framework' ).":</span>
								<span class='uvalue'>
									<input type='hidden' data-id='".$tabid."' data-menu-id='".$sid."' class='wpstr-menuicon' value='".$menuarr[6]."'>
									<span data-class='".$menuarr[6]."' class='wpstricon wpstrmenuicon wp-menu-image dashicons-before ".$menuarr[6]."'></span>
									<span class='wpstriconpanel'></span>
								</span>
								<div class='clearboth'></div>
							</div>
						</span>";

				echo "<div class='clearboth'></div>";
				
				/*--------------------
					submenu tabs 
				----------------------*/
				echo "<div class='wpstrsubmenu-wrap'>";
				if(isset($wpstrsubmenu[$menuarr[2]])){

					$parentpage = "";
					if(isset($menuarr[2])){
						$parentpage = $menuarr[2];
					}
						
					foreach($wpstrsubmenu[$menuarr[2]] as $submenuid => $submenuarr){
						// print_r($submenuarr);
						//$submenuarr[0] = wpstr_reformatstring($submenuarr[0]);

						$expstr = explode("<", $submenuarr[0]);
						$submenuarr[0] = $expstr[0];
						
						$subtabid = $submenuid;
						if(isset($submenuarr['original'])){
							$subtabid = $submenuarr['original'];
						}

						$originalsubname = $submenuarr[0];
						if(isset($submenuarr['originalsubname'])){
							$originalsubname = $submenuarr['originalsubname'];
						}

						$expstr = explode("<", $originalsubname);
						$originalsubname = $expstr[0];

						$subdisabled = " enabled ";
						$subdisablebutclass = "disable";
						$subdisablebuttext = "hide";
						if(in_array($menupage.":".$subtabid,$submenudisablearr)){ 
							$subdisabled = " disabled "; 
							$subdisablebutclass = " enable ";
							$subdisablebuttext = "show";
						}

						//print_r($submenuarr);
						echo "<div class='wpstrsubmenu ".$subdisabled."' data-id='".$subtabid."' data-parent-id='".$tabid."' data-parent-page='".$parentpage."'>
								
								<div>
									<span class='wpstrtext'>".$submenuarr[0]."</span>
									<span class='wpstrsubtoggle plus wp-menu-image dashicons-before dashicons-plus'></span>
									<span class='wpstrsubdisplay wp-menu-image dashicons-before dashicons-visibility ".$subdisablebutclass."'></span>
									<span class='wpstrmove wp-menu-image dashicons-before dashicons-editor-expand'></span>
								</div>
								
								<div class='clearboth'></div>

								<span class='wpstreditpanel wpstrsubmenupanel closed'>
									<div>
									<span class='ufield'>".__( 'Original', 'wpstr_framework' ).":</span>
									<span class='uvalue'>".$originalsubname."</span>
										<div class='clearboth'></div>
										<span class='ufield'>".__( 'Rename to', 'wpstr_framework' ).":</span>
										<span class='uvalue'><input type='text' data-parent-page='".$parentpage."'  data-id='".$subtabid."' data-parent-id='".$tabid."' class='wpstr-submenurename' value='".wpstr_reformatstring($submenuarr[0])."'></span>
										<div class='clearboth'></div>
									</div>
								</span>		

								<div class='clearboth'></div>

							</div>";
					}

					//print_r($submenu[$menuarr[2]]);
				}
			echo "</div>"; // submenu end
			echo "</div>"; // menu end
			}
		}

		//echo "</pre>";

	echo '</div>';

	echo "<div class='wpstr-savearea'><span style='display:block;margin-bottom:12px;'>".__( 'Instructions', 'wpstr_framework' ).":<br></span><ul style='list-style:square;padding-left:18px;'>";
	echo "<li>".__( 'Drag and Drop', 'wpstr_framework' )." <span class='wp-menu-image dashicons-before dashicons-editor-expand'></span> ".__( 'menu and sub menu items to rearrange.', 'wpstr_framework' )."</li>";
	echo "<li>".__( 'Click on', 'wpstr_framework' )." <span class='wp-menu-image dashicons-before dashicons-visibility'></span> ".__( 'icon to show or hide the menu or submenu item.', 'wpstr_framework' )."</li>";
	echo "<li>".__( 'Click on', 'wpstr_framework' )." <span class='wp-menu-image dashicons-before dashicons-plus'></span> ".__( 'icon to edit menu and submenu link text', 'wpstr_framework' )."</li>";
	echo "<li>".__( 'Click on', 'wpstr_framework' )." <span class='wp-menu-image dashicons-before dashicons-plus'></span> ".__( 'icon, click on the menu icon to open the available icons panel and pick your icon.', 'wpstr_framework' )."</li>";
	echo "<li>".__( 'Click on save menu button after editing.', 'wpstr_framework' )."</li></ul>";

	echo '<p class="submit" style="padding-left:0px;margin-top:0px;padding-top:0px;"><input type="button" name="wpstr-savemenu" id="wpstr-savemenu" class="button button-primary" value="'.__( 'Save Menu', 'wpstr_framework' ).'"> <input type="button" name="wpstr-resetmenu" id="wpstr-resetmenu" class="button button-primary" value="'.__( 'Reset to Original', 'wpstr_framework' ).'"></p>';

	echo wpstr_menuicons_list();
	echo "</div>";

	echo "</div>"; // .wrap

}

add_action('wp_ajax_wpstr_savemenu', 'wpstr_savemenu');

function wpstr_savemenu() {
    if (!isset($_POST['wpstr_nonce']) || !wp_verify_nonce($_POST['wpstr_nonce'], 'wpstr-nonce')) {
        die('Permissions check failed. Please login or refresh (if already logged in) the page, then try Again.');
    }

    $neworder = $_POST['neworder'];
    $newsuborder = $_POST['newsuborder'];
    $menurename = $_POST['menurename'];
    $submenurename = $_POST['submenurename'];
    $menudisable = $_POST['menudisable'];
    $submenudisable = $_POST['submenudisable'];

		// print_r($menurename); 

	wpstr_update_option("wpstradmin_menuorder", $neworder);
	wpstr_update_option("wpstradmin_submenuorder", $newsuborder);
	wpstr_update_option("wpstradmin_menurename", $menurename);
	wpstr_update_option("wpstradmin_submenurename", $submenurename);
	wpstr_update_option("wpstradmin_menudisable", $menudisable);
	wpstr_update_option("wpstradmin_submenudisable", $submenudisable);
    //echo "success";
    die();
}

add_action('wp_ajax_wpstr_resetmenu', 'wpstr_resetmenu');

function wpstr_resetmenu() {
    if (!isset($_POST['wpstr_nonce']) || !wp_verify_nonce($_POST['wpstr_nonce'], 'wpstr-nonce')) {
        die('Permissions check failed. Please login or refresh (if already logged in) the page, then try Again.');
    }

    $neworder = "";
    $newsuborder = "";
    $menurename = "";
    $submenurename = "";
    $menudisable = "";
    $submenudisable = "";

    //print_r($_POST);
	wpstr_update_option("wpstradmin_menuorder", $neworder);
	wpstr_update_option("wpstradmin_submenuorder", $newsuborder);
	wpstr_update_option("wpstradmin_menurename", $menurename);
	wpstr_update_option("wpstradmin_submenurename", $submenurename);
	wpstr_update_option("wpstradmin_menudisable", $menudisable);
	wpstr_update_option("wpstradmin_submenudisable", $submenudisable);
    //echo "success";
    die();
}


if($get_menumng_page != "disable" && !is_network_admin()){
		add_action('admin_menu', 'wpstr_adminmenu_rearrange',999999999);
		add_filter( 'custom_menu_order', 'wpstr_admin_submenu_rearrange', 9999999999);
}


function wpstr_adminmenu_rearrange() {


	$enablemenumng = wpstr_get_user_type(); 


	global $menu;
	global $submenu;

	if($enablemenumng){

		// wpstrprint("menu",$menu);

		$renamemenu = wpstr_rename_menu();
		$menu = $renamemenu;
		// //wpstrprint("menu",$menu);
		// //return $menu;

		$neworder = wpstr_adminmenu_neworder();
		// wpstrprint("neworder",$neworder);

		$ret = wpstr_adminmenu_newmenu($neworder,$menu);
		$menu = $ret;

		$GLOBALS['wpstrmenu'] = $menu;

		$menu = wpstr_adminmenu_disable($menu);
		
	}


	//wpstrprint("menu",$menu);
	return $menu;

}


function wpstr_adminmenu_neworder() {

    $new = array();
    $subnew = array();
    $ret = array();

    $neworder = wpstr_get_option("wpstradmin_menuorder","");
    $newsuborder = wpstr_get_option("wpstradmin_submenuorder","");
    //echo $neworder; echo "<br>"; echo $newsuborder;

    $exp = explode("|",$neworder);
    $subexp = explode("|",$newsuborder);

    // set menu in new array
    foreach ($exp as $id) {
    	if(trim($id) != "") {
    		$new[] = $id;
    	}
    }

    // set submenu in new array with menu id
    foreach ($subexp as $id) {
    	if(trim($id) != "") {
    		$subid = explode(":",$id);
    		$subnew[$subid[0]][] = $subid[1];
    	}
    }

	// wpstrprint("new",$new);
	// wpstrprint("subnew",$subnew);

    $ret['menu'] = $new;
    $ret['submenu'] = $subnew;

    return $ret;

}


function wpstr_adminmenu_newmenu($neworder,$menu){
	// wpstrprint("menu",$menu);
	// wpstrprint("neworder",$neworder);


	if(isset($neworder["menu"]) && sizeof($neworder["menu"]) > 0){

			$relation = array();

			foreach($menu as $id=>$valarr){
				if(isset($valarr[5])){
				$relation[$valarr[5]] = $id;
			}}

			// wpstrprint("relation",$relation);

			$ret = array();
			$allids = $menu;

			$k = 100000;
			foreach($neworder['menu'] as $newmenuid) {
				if(isset($relation[$newmenuid])){	
					$k++;
					$ret[$k] = $menu[$relation[$newmenuid]];
					$ret[$k]['original'] = $relation[$newmenuid];
					unset($allids[$relation[$newmenuid]]);
				}
			}

			foreach($allids as $itemid => $item) {
				$k++;
				$ret[$k] = $item;
				$ret[$k]['original'] = $itemid;
			}

			//$ret = array_merge($ret,$allids);
		
			// wpstrprint("ret",$ret);
		
	}
	else{
		 return $menu;
	}
	return $ret;

}



function wpstr_adminmenu_newsubmenu($newsuborder,$submenu,$menu){

	// rearrange submenu to new ids

	$allids = $menu;
	$allsubids = $submenu;

	// wpstrprint("submenu",$submenu);
	// wpstrprint("submenu elementor",$submenu["elementor"]);
	// wpstrprint("newsuborder submenu",$newsuborder['submenu']);

		if(isset($newsuborder['submenu']) && sizeof($newsuborder['submenu']) > 0){

				$k = 0;
				$ret = array();
				foreach($newsuborder['submenu'] as $submenuid => $arr) {
					// echo "-----------------------------------".$submenuid;
					$k = 0;
					foreach($arr as $linkid) {
						// echo "####".$linkid."####";
						$submenu[$submenuid][$linkid]['original'] = $linkid;
						$ret[$submenuid]["".$k.""] = $submenu[$submenuid][$linkid];
						unset($allsubids[$submenuid][$linkid]);
						//$ret[$menumap[$submenuid]][]['original'] = $linkid;
						$k++;
					}
				}

				// wpstrprint("ret",$ret);

				// wpstrprint("allsubids",$allsubids);

				// foreach($allsubids as $itemid => $item) {
				// 	//if(sizeof($item) > 0){
				// 	// $k = 0;
				// 	foreach($item as $a => $b) {
				// 		$allsubids[$itemid][$a]['original'] = $a;
				// 		$ret[$itemid][$k] = $allsubids[$itemid][$a];
				// 		//$ret[$k] = $item;
				// 		//$ret[$k]['original'] = $itemid;
				// 		$k++;
				// 	}
				// 	//}
				// }



			return $ret;

		} else {

			return $submenu;
		}



}



function wpstr_admin_submenu_rearrange() 
{

	global $wpstrmenu;
	global $submenu;


	$enablemenumng = wpstr_get_user_type(); 
	if($enablemenumng){
		//wpstrprint('menu',$menu);
		//wpstrprint('submenu',$submenu);
		//return $submenu;

		$renamesubmenu = wpstr_rename_submenu();
		$submenu = $renamesubmenu;
		// wpstrprint('submenu',$submenu);


		$newsuborder = wpstr_adminmenu_neworder();
		// wpstrprint('newsuborder',$newsuborder);
		// echo "<pre>"; print_r($newsuborder); echo "</pre>";

		$ret = wpstr_adminmenu_newsubmenu($newsuborder,$submenu,$wpstrmenu);

		$submenu = $ret;
		// wpstrprint('submenu',$submenu);
		// // //return $submenu;

		$GLOBALS['wpstrsubmenu'] = $submenu;

		$submenu = wpstr_adminsubmenu_disable($submenu);

	}
	return $submenu;


}




function wpstr_rename_menu(){
	global $menu;

		$menurename = wpstr_get_option("wpstradmin_menurename","");

	// wpstrprint("menu",$menu);

	$relation = array();
	foreach ($menu as $k => $v) {
		if(isset($v[5])){
			$relation[$v[5]] = $k;
		}
	}
	// wpstrprint("relation",$relation);

	if(trim($menurename) != ""){

		$exp = explode("|#$%*|", $menurename);

		// wpstrprint("exp",$exp);
		foreach($exp as $str){

			if(trim($str) != ""){

				$id = $val = $icon = $original = "";

				$arr = explode("@!@%@", $str);
				if(isset($arr[0])){ $id = $arr[0]; }
				if(isset($arr[1])){ $str = $arr[1]; }
				$expstr = explode("[$!&!$]", $str);
				if(isset($expstr[0])){ $val = $expstr[0]; }
				if(isset($expstr[1])){ $icon = $expstr[1]; }


				// Migration from old menu management to new menu management version - Just to avoid any breaking changes in update
				if($id != "" && strpos($id,":") !== false){
					$expid = explode(":", $id);
					if(sizeof($expid) == 2){
						$id = $expid[1];
					}
				}

				if(isset($relation[$id]) && $relation[$id] != ""){
					$original = $menu[$relation[$id]][0];
					$menu[$relation[$id]][0] = $val; 
					$menu[$relation[$id]]['originalname'] = $original;

					$originalicon = $menu[$relation[$id]][6];
					$menu[$relation[$id]][6] = $icon;
					$menu[$relation[$id]]['originalicon'] = $originalicon;

				}

				//echo $id. " : ". $val."<br>";
			}
		}
	}
	//wpstrprint("menu",$menu);

	return $menu;
}
  


function wpstr_rename_submenu(){

	global $submenu;
		$submenurename = wpstr_get_option("wpstradmin_submenurename","");

	if(trim($submenurename) != ""){

		$exp = explode("|#$%*|", $submenurename);

		// wpstrprint("exp",$exp);

		foreach($exp as $str){

			$idstr = $page = $parentid = $id = $val = $original = "";

			$arr = explode("@!@%@", $str);
			if(isset($arr[0])){ $idstr = $arr[0]; }
			$idexp = explode("[($&)]", $idstr);
			if(isset($idexp[0])){ $page = $idexp[0]; }
			if(isset($idexp[1])){ $idexp2 = explode(":",$idexp[1]); }

			$id = $idexp[1];

			// if(isset($idexp2[0])){ $parentid = $idexp2[0]; }
			// if(isset($idexp2[1])){ $id = $idexp2[1]; }
			if(isset($arr[1])){ $val = $arr[1]; }

			// echo $page." - ". $parentid. " - ". $id." - ". $val."<br>";

			if(isset($submenu[$page][$id][0])){
				$original = $submenu[$page][$id][0];
				$submenu[$page][$id][0] = $val;
				$submenu[$page][$id]['originalsubname'] = $original;
			}
			//echo $id. " : ". $val."<br>";
		}
	}
	//echo "<pre>"; print_r($submenu); echo "</pre>"; 
	return $submenu;
}


function wpstr_adminmenu_disable($menu){
  	// wpstrprint("menu",$menu);
    $menudisable = wpstr_get_option("wpstradmin_menudisable","");
    $exp = array_unique(array_filter(explode("|", $menudisable)));
		// wpstrprint("exp",$exp);

    foreach($menu as $id => $arr){
    	if(isset($arr[5]) && in_array($arr[5],$exp)){
			unset($menu[$id]);
    	}
    }

	return $menu;
}


function wpstr_adminsubmenu_disable($submenu){
	//echo "<pre>"; print_r($submenu); echo "</pre>"; 
	//wpstrprint("submenu",$submenu);
	global $menu;
	//wpstrprint("menu",$menu);
	
	//enabled menu items 

	$enabledmenu = array();
	foreach ($menu as $key => $value) {
		$enabledmenu[] = $value[2];
	}

	// wpstrprint("enabledmenu",$enabledmenu);


	// map array of id and .php page of menu first
	$menumap = array();
	foreach($menu as $v){
		//$menumap[$v[2]] = $v[5];//$v['original'];
	}

	//wpstrprint("menumap",$menumap);
    	$submenudisable = wpstr_get_option("wpstradmin_submenudisable","");

    $exp = array_unique(array_filter(explode("|", $submenudisable)));
		// wpstrprint("exp",$exp);

    foreach ($submenu as $key => $value) {

    	// check if parent menu is enabled. if not then unset it from submenu
    	if(!in_array($key,$enabledmenu)){
    		unset($submenu[$key]);
    	} else {

	    $parentid = "";
    	//if(isset($parentid)){$parentid = $menumap[$key];}

    	foreach($value as $k => $v){
    		$subid = "";
    		if(isset($v['original'])){
    			$subid = $v['original']; 
    		}
    		if(in_array($key.":".$subid,$exp)){
    			unset($submenu[$key][$k]);
    		}
    	}
      }
    }

    //wpstrprint("submenu",$submenu);
return $submenu;

}

function wpstr_menuicons_list(){
	$ret = "";
	$ret .= "<div class='wpstricons'>";

	$str = wpstr_dashiconscsv();
	$exp = explode(",", $str);
	foreach ($exp as $key => $value) {
		$valexp = explode(":", $value);
		$class = trim($valexp[0]);
		$code = trim($valexp[1]);
		$ret .= "<span data-class = 'dashicons-".$class."' class='wpstricon pickicon wp-menu-image dashicons-before dashicons-".$class."'></span>";
	}

	$ret .= "</div>";
	return $ret;
}


function wpstr_removeslashes($string)
{
    $string=implode("",explode("\\",$string));
    return stripslashes(trim($string));
}

function wpstr_reformatstring($str){
	$str = htmlspecialchars($str, ENT_QUOTES);
	$str = wpstr_removeslashes($str);
	return $str;
}


function wpstr_dashiconscsv(){

	$str = "menu:f333,
	admin-site:f319,
	dashboard:f226,
	admin-media:f104,
	admin-page:f105,
	admin-comments:f101,
	admin-appearance:f100,
	admin-plugins:f106,
	admin-users:f110,
	admin-tools:f107,
	admin-settings:f108,
	admin-network:f112,
	admin-generic:f111,
	admin-home:f102,
	admin-collapse:f148,
	format-links:f103,
	format-standard:f109,
	format-image:f128,
	format-gallery:f161,
	format-audio:f127,
	format-video:f126,
	format-chat:f125,
	format-status:f130,
	format-aside:f123,
	format-quote:f122,
	welcome-edit-page:f119,
	welcome-add-page:f133,
	welcome-view-site:f115,
	welcome-widgets-menus:f116,
	welcome-comments:f117,
	welcome-learn-more:f118,
	image-crop:f165,
	image-rotate-left:f166,
	image-rotate-right:f167,
	image-flip-vertical:f168,
	image-flip-horizontal:f169,
	undo:f171,
	redo:f172,
	editor-bold:f200,
	editor-italic:f201,
	editor-ul:f203,
	editor-ol:f204,
	editor-quote:f205,
	editor-alignleft:f206,
	editor-aligncenter:f207,
	editor-alignright:f208,
	editor-insertmore:f209,
	editor-spellcheck:f210,
	editor-expand:f211,
	editor-contract:f506,
	editor-kitchensink:f212,
	editor-underline:f213,
	editor-justify:f214,
	editor-textcolor:f215,
	editor-paste-word:f216,
	editor-paste-text:f217,
	editor-removeformatting:f218,
	editor-video:f219,
	editor-customchar:f220,
	editor-outdent:f221,
	editor-indent:f222,
	editor-help:f223,
	editor-strikethrough:f224,
	editor-unlink:f225,
	editor-rtl:f320,
	editor-break:f474,
	editor-code:f475,
	editor-paragraph:f476,
	align-left:f135,
	align-right:f136,
	align-center:f134,
	align-none:f138,
	lock:f160,
	calendar:f145,
	calendar-alt:f508,
	visibility:f177,
	post-status:f173,
	edit:f464,
	trash:f182,
	external:f504,
	arrow-up:f142,
	arrow-down:f140,
	arrow-left:f141,
	arrow-right:f139,
	arrow-up-alt:f342,
	arrow-down-alt:f346,
	arrow-left-alt:f340,
	arrow-right-alt:f344,
	arrow-up-alt2:f343,
	arrow-down-alt2:f347,
	arrow-left-alt2:f341,
	arrow-right-alt2:f345,
	leftright:f229,
	sort:f156,
	randomize:f503,
	list-view:f163,
	exerpt-view:f164,
	grid-view:f509,
	hammer:f308,
	art:f309,
	migrate:f310,
	performance:f311,
	universal-access:f483,
	universal-access-alt:f507,
	tickets:f486,
	nametag:f484,
	clipboard:f481,
	heart:f487,
	megaphone:f488,
	schedule:f489,
	wordpress:f120,
	wordpress-alt:f324,
	pressthis:f157,
	update:f463,
	screenoptions:f180,
	info:f348,
	cart:f174,
	feedback:f175,
	cloud:f176,
	translation:f326,
	tag:f323,
	category:f318,
	archive:f480,
	tagcloud:f479,
	text:f478,
	media-archive:f501,
	media-audio:f500,
	media-code:f499,
	media-default:f498,
	media-document:f497,
	media-interactive:f496,
	media-spreadsheet:f495,
	media-text:f491,
	media-video:f490,
	playlist-audio:f492,
	playlist-video:f493,
	yes:f147,
	no:f158,
	no-alt:f335,
	plus:f132,
	plus-alt:f502,
	minus:f460,
	dismiss:f153,
	marker:f159,
	star-filled:f155,
	star-half:f459,
	star-empty:f154,
	flag:f227,
	share:f237,
	share1:f237,
	share-alt:f240,
	share-alt2:f242,
	twitter:f301,
	rss:f303,
	email:f465,
	email-alt:f466,
	facebook:f304,
	facebook-alt:f305,
	networking:f325,
	googleplus:f462,
	location:f230,
	location-alt:f231,
	camera:f306,
	images-alt:f232,
	images-alt2:f233,
	video-alt:f234,
	video-alt2:f235,
	video-alt3:f236,
	vault:f178,
	shield:f332,
	shield-alt:f334,
	sos:f468,
	search:f179,
	slides:f181,
	analytics:f183,
	chart-pie:f184,
	chart-bar:f185,
	chart-line:f238,
	chart-area:f239,
	groups:f307,
	businessman:f338,
	id:f336,
	id-alt:f337,
	products:f312,
	awards:f313,
	forms:f314,
	testimonial:f473,
	portfolio:f322,
	book:f330,
	book-alt:f331,
	download:f316,
	upload:f317,
	backup:f321,
	clock:f469,
	lightbulb:f339,
	microphone:f482,
	desktop:f472,
	tablet:f471,
	smartphone:f470,
	smiley:f328,
	index-card:f510,
	carrot:f511";

	return $str;
}

?>