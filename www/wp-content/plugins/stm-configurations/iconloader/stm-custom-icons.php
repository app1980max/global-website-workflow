<?php

if (isset($_GET['dsm'])) {
    delete_option('stm_fonts');
    delete_option('stm_fonts_layout');
}


if (!class_exists('STM_Custom_Icons')) {
    class STM_Custom_Icons
    {
        var $paths = array();
        var $svg_file;
        var $json_file;
        var $stm_custom_vc_fonts;
        var $stm_fonts_dir;
        var $font_name = 'unknown';
        var $svg_config = array();
        var $json_config = array();
        static $iconlist = array();

        function __construct()
        {
            $this->paths = wp_upload_dir();
            $this->paths['fonts'] = 'stm_fonts';
            $this->paths['temp'] = trailingslashit($this->paths['fonts']) . 'stm_temp';
            $this->paths['fontdir'] = trailingslashit($this->paths['basedir']) . $this->paths['fonts'];
            $this->paths['tempdir'] = trailingslashit($this->paths['basedir']) . $this->paths['temp'];
            $this->paths['fonturl'] = set_url_scheme(trailingslashit($this->paths['baseurl']) . $this->paths['fonts']);
            $this->paths['tempurl'] = trailingslashit($this->paths['baseurl']) . trailingslashit($this->paths['temp']);
            $this->paths['config'] = 'charmap.php';
            $this->stm_custom_vc_fonts = trailingslashit($this->paths['basedir']) . $this->paths['fonts'] . '/stmicons';
            $this->stm_fonts_dir = get_template_directory() . '/assets/fonts/stmicons/';
            add_action('wp_ajax_stm_ajax_add_zipped_font', array($this, 'stm_add_zipped_font'));
            add_action('wp_ajax_stm_ajax_remove_zipped_font', array($this, 'stm_remove_zipped_font'));
            $defaults = get_option('stm_fonts');

            if (!$defaults) {
                add_action('admin_init', array($this, 'STM_move_fonts'));
            }
        }

        function stm_admin_scripts()
        {
            wp_enqueue_script('stm-admin-media', STM_CONFIGURATIONS_URL . 'assets/js/admin-media.js', array('jquery'), '1.1');
            wp_enqueue_script('media-upload');
            wp_enqueue_media();
            wp_enqueue_style('stm-icon-manager-admin', STM_CONFIGURATIONS_URL . 'assets/css/icon-manager-admin.css');
            $this->stm_enqueue_admin_scripts();
			$this->stm_enqueue_admin_scripts('stm_fonts_layout');
        }

        function stm_enqueue_admin_scripts($option = 'stm_fonts') {
			$upload_paths = wp_upload_dir();
			$custom_fonts = get_option($option);
			if (is_array($custom_fonts)) {
				foreach ($custom_fonts as $font => $info) {
					if (strpos($info['style'], 'http://') !== false) {
						wp_enqueue_style('stm-' . $font, $info['style'], null, '1.0', 'all');
					} else {
						wp_enqueue_style('stm-' . $font, trailingslashit($upload_paths['baseurl'] . '/stm_fonts/') . $info['style'], null, '1.0', 'all');
					}
				}
			}
        }

        function stm_icon_manager_dashboard()
        {
            ?>
            <div class="wrap">
            <h2>
                <?php esc_html_e('Pearl Custom Icons', 'stm-configurations'); ?>
                <a href="#stm_upload_icon" class="add-new-h2 stm_upload_icon" data-target="iconfont_upload"
                   data-title="<?php echo esc_html__("Upload/Select Fontello Font Zip", "stm-configurations") ?>"
                   data-type="application/octet-stream, application/zip"
                   data-button="<?php echo esc_html__("Insert Fonts Zip File", "stm-configurations"); ?>"
                   data-trigger="stm_insert_zip"
                   data-class="media-frame ">
                    <?php esc_html_e('Upload New Icons', 'stm-configurations'); ?>
                </a> &nbsp;<span class="spinner"></span></h2>
            <div id="msg"></div>
            <?php
            $fonts = get_option('stm_fonts');
            if (is_array($fonts)) :
                $this->stm_get_font_set(); ?>
                </div>
            <?php else: ?>
                <div class="error">
                    <p>
                        <?php esc_html_e('No font icons uploaded. Upload some font icons to display here.', 'stm-configurations'); ?>
                    </p>
                </div>
                <?php
            endif;
        }

        function stm_get_font_set($option = 'stm_fonts')
        {
            $fonts = get_option($option);

            if(!empty($fonts)) {
				foreach ($fonts as $font => $info) {
					$icon_set = array();
					$upload_dir = wp_upload_dir();
					$basedir = trailingslashit($upload_dir['basedir']);

					global $wp_filesystem;

					if (empty($wp_filesystem)) {
						require_once ABSPATH . '/wp-admin/includes/file.php';
						WP_Filesystem();
					}

					$json_file = $basedir . $info['include'] . '/' . 'selection.json';
					$json_file = json_decode($wp_filesystem->get_contents($json_file), true);

					$set_name = $json_file['metadata']['name'];
					$font_prefix = $json_file['preferences']['fontPref']['prefix'];

					if(empty($json_file['icons'])) continue;

					foreach ($json_file['icons'] as $icon) {
						$icon_set[$set_name][] = $font_prefix . $icon['properties']['name'];
					}

					$output = '<div class="icon_set-' . $font . ' metabox-holder">';
					$output .= '<div class="postbox">';


					if ($font == 'stmicons') {
						$output .= '<h3 class="icon_font_name"><strong>' . esc_html__('Default Icons', 'stm-configurations') . '</strong>';
					} elseif (strpos($font, 'stmicons_') !== false) {
						$output .= '<h3 class="icon_font_name"><strong>' . esc_html(ucfirst(str_replace('stmicons_', '', $font))) . '</strong>';
						if (empty($info['enabled'])) {
							$output .= '<button class="button button-primary button-small stm_layout_font_enabler" data-font=' . esc_attr($font) . ' data-title="' . esc_attr__('Enable Icon Set', 'stm-configurations') . '">' . esc_html__('Enable Icon Set', 'stm-configurations') . '</button>';
						} else {
							$output .= '<button class="button button-secondary button-small stm_layout_font_enabler" data-font=' . esc_attr($font) . ' data-title="' . esc_attr__('Disable Icon Set', 'stm-configurations') . '">' . esc_html__('Disable Icon Set', 'stm-configurations') . '</button>';
						}
					} else {
						$output .= '<h3 class="icon_font_name"><strong>' . esc_html(ucfirst($font)) . '</strong>';
						$output .= '<button class="button button-secondary button-small stm_del_icon" data-delete=' . esc_attr($font) . ' data-title="' . esc_attr__('Delete Icon Set', 'stm-configurations') . '">' . esc_html__('Delete Icon Set', 'stm-configurations') . '</button>';
					}

					$output .= '</h3>';
					$output .= '<div class="inside"><div class="icon_actions">';
					$output .= '</div>';
					$output .= '<div class="icon_search">';
                    $output .= '<ul class="icons-list fi_icon">';
					foreach ($icon_set as $icons) {
						foreach ($icons as $icon) {
							$output .= '<li>';
							$output .= '<i class="' . esc_attr($icon) . '"></i><label class="icon">' . esc_html($icon) . '</label></li>';
						}
					}
					$output . '</ul>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
					echo $output;
					if ($font == 'stmicons') {
						$this->STM_layout_fonts();
					}

				}
			}
            $script = '<script type="text/javascript">
                (function($) {
                    $(document).ready(function(){
                        $(".search-icon").keyup(function(){
                            $(".fonts-count").hide();
                            var filter = $(this).val(), count = 0;
                            $(".icons-list li").each(function(){
                                if ($(this).attr("data-icons-tag").search(new RegExp(filter, "i")) < 0) {
                                    $(this).fadeOut();
                                } else {
                                    $(this).show();
                                    count++;
                                }
                                if(count === 0) {
                                    $(".search-count").html(" ' . esc_js(__('Can\'t find the icon?', 'stm-configurations')) . ' <a href=\'#stm_upload_icon\' class=\'add-new-h2 stm_upload_icon\' data-target=\'iconfont_upload\' data-title=\' ' . esc_js(__('Upload/Select Fontello Font Zip', 'stm-configurations')) . ' \' data-type=\'application/octet-stream, application/zip\' data-button=\' ' . esc_js(__('Insert Fonts Zip File', 'stm-configurations')) . ' \' data-trigger=\'stm_insert_zip\' data-class=\'media-frame\'>' . esc_js(__('Click here to upload', 'stm-configurations')) . '</a>");
                                } else {
                                    $(".search-count").html(count+" ' . esc_js(__('Icons found.', 'stm-configurations')) . '");
                                }
                                if(filter === "") {
                                    $(".fonts-count").show();
                                }
                            });
                        });
                    });
				})(jQuery);
			</script>';
            echo $script;
        }

		function STM_layout_fonts() {
            $this->stm_get_font_set('stm_fonts_layout');
		}

		function STM_layouts() {
            $layouts = array(
                'beauty',
                'church',
            );
            return $layouts;
        }

        function stm_add_zipped_font()
        {
            $cap = 'update_plugins';
            if (!current_user_can($cap)) {
                die(esc_html__("Using this feature is reserved for Super Admins. You unfortunately don't have the necessary permissions.", "stm-configurations"));
            }
            $attachment = $_POST['values'];
            $path = realpath(get_attached_file($attachment['id']));
            $unzipped = $this->stm_zip_flatten($path, array('\.eot', '\.svg', '\.ttf', '\.woff', '\.json', '\.css'));
            if ($unzipped) {
                $this->stm_create_config();
            }
            if ($this->font_name == 'unknown') {
                $this->stm_delete_folder($this->paths['tempdir']);
                die(esc_html__('Was not able to retrieve the Font name from your Uploaded Folder', 'stm-configurations'));
            }
            die(esc_html__('stm_font_added:', 'stm-configurations') . $this->font_name);
        }

        function stm_remove_zipped_font()
        {
            $font = $_POST['del_font'];
            $list = self::stm_load_iconfont_list();
            $delete = isset($list[$font]) ? $list[$font] : false;
            if ($delete) {
                $this->stm_delete_folder($delete['include']);
                $this->stm_remove_font($font);
                die(esc_html__('stm_font_removed', 'stm-configurations'));
            }
            die(esc_html__('Was not able to remove Font', 'stm-configurations'));
        }

        function stm_zip_flatten($zipfile, $filter)
        {
            if (is_dir($this->paths['tempdir'])) {
                $this->stm_delete_folder($this->paths['tempdir']);
                $tempdir = stm_backend_create_folder($this->paths['tempdir'], false);
            } else {
                $tempdir = stm_backend_create_folder($this->paths['tempdir'], false);
            }
            if (!$tempdir) {
                die(esc_html__('Wasn\'t able to create temp folder', 'stm-configurations'));
            }
            $zip = new ZipArchive;
            if ($zip->open($zipfile)) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entry = $zip->getNameIndex($i);
                    if (!empty($filter)) {
                        $delete = true;
                        $matches = array();
                        foreach ($filter as $regex) {
                            preg_match("!" . $regex . "!", $entry, $matches);
                            if (!empty($matches)) {
                                $delete = false;
                                break;
                            }
                        }
                    }
                    if (substr($entry, -1) == '/' || !empty($delete)) {
                        continue;
                    } // skip directories and non matching files
                    $fp = $zip->getStream($entry);
                    $ofp = fopen($this->paths['tempdir'] . '/' . basename($entry), 'w');
                    if (!$fp) {
                        die(esc_html__('Unable to extract the file.', 'stm-configurations'));
                    }
                    while (!feof($fp)) {
                        fwrite($ofp, fread($fp, 8192));
                    }
                    fclose($fp);
                    fclose($ofp);
                }
                $zip->close();
            } else {
                die(esc_html__("Wasn't able to work with Zip Archive", 'stm-configurations'));
            }

            return true;
        }

        function stm_create_config()
        {
            $this->json_file = $this->stm_find_json();
            $this->svg_file = $this->stm_find_svg();
            if (empty($this->json_file) || empty($this->svg_file)) {
                $this->stm_delete_folder($this->paths['tempdir']);
                die(esc_html__('selection.json or SVG file not found. Was not able to create the necessary config files', 'stm-configurations'));
            }
            $response = wp_remote_fopen(trailingslashit($this->paths['tempurl']) . $this->svg_file);
            $json = file_get_contents(trailingslashit($this->paths['tempdir']) . $this->json_file);
            if (empty($response)) {
                $response = file_get_contents(trailingslashit($this->paths['tempdir']) . $this->svg_file);
            }
            if (!is_wp_error($json) && !empty($json)) {
                $xml = simplexml_load_string($response);
                $font_attr = $xml->defs->font->attributes();
                $this->font_name = (string)$font_attr['id'];
                $font_folder = trailingslashit($this->paths['fontdir']) . $this->font_name;
                if (is_dir($font_folder)) {
                    $this->stm_delete_folder($this->paths['tempdir']);
                    die(esc_html__("It seems that the font with the same name is already exists! Please upload the font with different name.", "stm-configurations"));
                }
                $file_contents = json_decode($json);
                if (!isset($file_contents->IcoMoonType)) {
                    $this->stm_delete_folder($this->paths['tempdir']);
                    die(esc_html__('Uploaded font is not from IcoMoon. Please upload fonts created with the IcoMoon App Only.', 'stm-configurations'));
                }
                $icons = $file_contents->icons;
                $n = 1;
                foreach ($icons as $icon) {
                    $icon_name = $icon->properties->name;
                    $icon_class = str_replace(' ', '', $icon_name);
                    $icon_class = str_replace(',', ' ', $icon_class);
                    $tags = implode(",", $icon->icon->tags);
                    $this->json_config[$this->font_name][$icon_name] = array(
                        "class" => $icon_class,
                        "tags" => $tags
                    );
                    $n++;
                }
                if (!empty($this->json_config) && $this->font_name != 'unknown') {
                    $this->stm_write_config();
                    $this->stm_re_write_css();
                    $this->stm_rename_files();
                    $this->stm_rename_folder();
                    $this->stm_add_font();
                }
            }

            return false;
        }

        function stm_write_config()
        {
            $charmap = $this->paths['tempdir'] . '/' . $this->paths['config'];
            $handle = @fopen($charmap, 'w');
            if ($handle) {
                fwrite($handle, '<?php $icons = array();');
                foreach ($this->json_config[$this->font_name] as $icon => $info) {
                    if (!empty($info)) {
                        $delimiter = "'";
                        fwrite($handle, "\r\n" . '$icons[\'' . $this->font_name . '\'][' . $delimiter . $icon . $delimiter . '] = array("class"=>' . $delimiter . $info["class"] . $delimiter . ',"tags"=>' . $delimiter . $info["tags"] . $delimiter . ');');
                    } else {
                        $this->stm_delete_folder($this->paths['tempdir']);
                        die(esc_html__('Was not able to write a config file', 'stm-configurations'));
                    }
                }
                fclose($handle);
            } else {
                $this->stm_delete_folder($this->paths['tempdir']);
                die(esc_html__('Was not able to write a config file', 'stm-configurations'));
            }
        }

        function stm_re_write_css()
        {
            $style = $this->paths['tempdir'] . '/style.css';
            $file = @file_get_contents($style);
            if ($file) {
                $str = str_replace('fonts/', '', $file);
                $str = str_replace('.icon {', '[class^="' . $this->font_name . '-"], [class*=" ' . $this->font_name . '-"] {', $str);
                $str = str_replace('i {', '[class^="' . $this->font_name . '-"], [class*=" ' . $this->font_name . '-"] {', $str);

                $str = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str);

                $str = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $str);

                @file_put_contents($style, $str);
            } else {
                die(esc_html__('Unable to write css. Upload icons downloaded only from icomoon', 'stm-configurations'));
            }
        }

        function stm_rename_files()
        {
            $extensions = array('eot', 'svg', 'ttf', 'woff', 'css');
            $folder = trailingslashit($this->paths['tempdir']);
            foreach (glob($folder . '*') as $file) {
                $path_parts = pathinfo($file);
                if (strpos($path_parts['filename'], '.dev') === false && in_array($path_parts['extension'], $extensions)) {
                    if ($path_parts['filename'] !== $this->font_name) {
                        rename($file, trailingslashit($path_parts['dirname']) . $this->font_name . '.' . $path_parts['extension']);
                    }
                }
            }
        }

        function stm_rename_folder()
        {
            $new_name = trailingslashit($this->paths['fontdir']) . $this->font_name;
            $this->stm_delete_folder($new_name);
            if (rename($this->paths['tempdir'], $new_name)) {
                return true;
            } else {
                $this->stm_delete_folder($this->paths['tempdir']);
                die(esc_html__("Unable to add this font. Please try again.", "stm-configurations"));
            }
        }

        function stm_delete_folder($new_name)
        {
            if (is_dir($new_name)) {
                $objects = scandir($new_name);
                foreach ($objects as $object) {
                    if ($object != "." && $object != "..") {
                        unlink($new_name . "/" . $object);
                    }
                }
                reset($objects);
                rmdir($new_name);
            }
        }

        function stm_add_font()
        {
            $fonts = get_option('stm_fonts');
            if (empty($fonts)) {
                $fonts = array();
            }
            $fonts[$this->font_name] = array(
                'include' => trailingslashit($this->paths['fonts']) . $this->font_name,
                'folder' => trailingslashit($this->paths['fonts']) . $this->font_name,
                'style' => $this->font_name . '/' . $this->font_name . '.css',
                'config' => $this->paths['config']
            );
            update_option('stm_fonts', $fonts);
        }

        function stm_remove_font($font)
        {
            $fonts = get_option('stm_fonts');
            if (isset($fonts[$font])) {
                unset($fonts[$font]);
                update_option('stm_fonts', $fonts);
            }
        }

        function stm_find_json()
        {
            $files = scandir($this->paths['tempdir']);
            foreach ($files as $file) {
                if (strpos(strtolower($file), '.json') !== false && $file[0] != '.') {
                    return $file;
                }
            }
        }

        function stm_find_svg()
        {
            $files = scandir($this->paths['tempdir']);
            foreach ($files as $file) {
                if (strpos(strtolower($file), '.svg') !== false && $file[0] != '.') {
                    return $file;
                }
            }
        }

        static function stm_load_iconfont_list()
        {
            if (!empty(self::$iconlist)) {
                return self::$iconlist;
            }
            $extra_fonts = get_option('stm_fonts');
            if (empty($extra_fonts)) {
                $extra_fonts = array();
            }
            $font_configs = $extra_fonts;
            $upload_dir = wp_upload_dir();
            $path = trailingslashit($upload_dir['basedir']);
            $url = trailingslashit($upload_dir['baseurl']);
            foreach ($font_configs as $key => $config) {
                if (empty($config['full_path'])) {
                    $font_configs[$key]['include'] = $path . $font_configs[$key]['include'];
                    $font_configs[$key]['folder'] = $url . $font_configs[$key]['folder'];
                }
            }
            self::$iconlist = $font_configs;

            return $font_configs;
        }

        function STM_move_fonts()
        {
            if (!is_dir($this->stm_custom_vc_fonts)) {
                wp_mkdir_p($this->stm_custom_vc_fonts);
            }

            $layouts = array();

            @chmod($this->stm_custom_vc_fonts, 0777);
            foreach (glob($this->stm_fonts_dir . '*') as $file) {
                $new_file = basename($file);
                if(!is_dir($file)) {
					@copy($file, $this->stm_custom_vc_fonts . '/' . $new_file);
				} else {
					if (!is_dir($this->stm_custom_vc_fonts . '/' . $new_file)) {
						wp_mkdir_p($this->stm_custom_vc_fonts . '/' . $new_file);
					}
					foreach (glob($this->stm_fonts_dir . $new_file . '/*') as $layout_file) {
					    $new_layout_file = basename($layout_file);
						@copy($layout_file, $this->stm_custom_vc_fonts . '/' . $new_file . '/' . $new_layout_file);
                    }

                    $layout_icons = array(
						'include' => trailingslashit($this->paths['fonts']) . 'stmicons/' . $new_file,
						'folder' => trailingslashit($this->paths['fonts']) . 'stmicons/' . $new_file,
						'style' => 'stmicons' . '/' . $new_file . '/stmicons' . '.css',
						'config' => $new_file . '/' . $this->paths['config']
					);

					$default_icons = array(
                        'linear',
                        'vicons',
                        'feather',
                        'icomoon'
                    );

					if(in_array($new_file, $default_icons)) {
						$layout_icons['enabled'] = true;
                    }

                     $layouts['stmicons_' . $new_file] = $layout_icons;
                }
            }
            $fonts['stmicons'] = array(
                'include' => trailingslashit($this->paths['fonts']) . 'stmicons',
                'folder' => trailingslashit($this->paths['fonts']) . 'stmicons',
                'style' => 'stmicons' . '/' . 'stmicons' . '.css',
                'config' => $this->paths['config']
            );

            $defaults = get_option('stm_fonts');
            if (!$defaults) {
                update_option('stm_fonts', $fonts);
            }

            $default_layouts = get_option('stm_fonts_layout');
			if (!$default_layouts) {
				update_option('stm_fonts_layout', $layouts);
			}

        }
    }
    if (!function_exists('stm_backend_create_folder')) {
        function stm_backend_create_folder(&$folder, $addindex = true)
        {
            if (is_dir($folder) && $addindex == false) {
                return true;
            }
            $created = wp_mkdir_p(trailingslashit($folder));
            @chmod($folder, 0777);
            if ($addindex == false) {
                return $created;
            }
            $index_file = trailingslashit($folder) . 'index.php';
            if (file_exists($index_file)) {
                return $created;
            }
            $handle = @fopen($index_file, 'w');
            if ($handle) {
                fwrite($handle, "<?php\r\necho 'Sorry, browsing the directory is not allowed!';\r\n?>");
                fclose($handle);
            }

            return $created;
        }
    }

    new STM_Custom_Icons;
}

add_action('admin_menu', 'pearl_register_menu', 99);

if (!function_exists('pearl_register_menu')) {
    function pearl_register_menu()
    {
        add_submenu_page(
            'my-pearl',
            esc_html__("Pearl Icon Manager", "stm-configurations"),
            esc_html__("Pearl Icon Manager", "stm-configurations"),
            "manage_options",
            "pearl-icon-manager",
            "stm_custom_icons_menu"
        );
        $STM_Custom_Icons = new STM_Custom_Icons;
        add_action('admin_enqueue_scripts', array($STM_Custom_Icons, 'stm_admin_scripts'));
    }
}

function stm_custom_icons_menu()
{
    $STM_Custom_Icons = new STM_Custom_Icons;
    $STM_Custom_Icons->stm_icon_manager_dashboard();
}

function stm_custom_fonts()
{
    $upload_paths = wp_upload_dir();
    $custom_fonts = get_option('stm_fonts');
    if (is_array($custom_fonts)) {
        foreach ($custom_fonts as $font => $info) {
            if (strpos($info['style'], 'http://') !== false) {
                wp_enqueue_style('stm-' . $font, $info['style'], null, '1.0.1', 'all');
            } else {
                wp_enqueue_style('stm-' . $font, trailingslashit($upload_paths['baseurl'] . '/stm_fonts/') . $info['style'], null, '1.0.2', 'all');
            }
        }
    }

	$custom_layout_fonts = get_option('stm_fonts_layout');
	if (is_array($custom_layout_fonts)) {
		foreach ($custom_layout_fonts as $font => $info) {
		    if(!empty($info['enabled'])) {
				if (strpos($info['style'], 'http://') !== false) {
					wp_enqueue_style('stm-' . $font, $info['style'], null, '1.0.1', 'all');
				} else {
					wp_enqueue_style('stm-' . $font, trailingslashit($upload_paths['baseurl'] . '/stm_fonts/') . $info['style'], null, '1.0.1', 'all');
				}
			}
		}
	}
}

add_action('wp_enqueue_scripts', 'stm_custom_fonts');

function stm_icons_load() {
    check_ajax_referer('stm_icons_load', 'security');
	$font = sanitize_title($_GET['font']);
	$fonts = get_option('stm_fonts_layout');

	$r = array(
		'text' => esc_html__('Enable icon set', 'pearl'),
		'class' => 'button-primary',
		'r_class' => 'button-secondary',
	);

	if(!empty($fonts) and !empty($fonts[$font])) {
		$current_font = $fonts[$font];
		if(empty($current_font['enabled'])) {
			$r = array(
				'text' => esc_html__('Disable icon set', 'pearl'),
				'class' => 'button-secondary',
				'r_class' => 'button-primary',
			);
			$fonts[$font]['enabled'] = true;
		} else {
			$fonts[$font]['enabled'] = false;
		}
	}

	update_option('stm_fonts_layout', $fonts);

	wp_send_json($r);
}

add_action('wp_ajax_stm_icons_load', 'stm_icons_load');

add_action( 'admin_menu', 'stm_register_cim', 99 );

if ( ! function_exists( 'stm_register_cim' ) ) {
	function stm_register_cim() {
		$icon_manager_page = add_theme_page(
			esc_html__( "STM Icon Manager", "stm_domain" ),
			esc_html__( "STM Icon Manager", "stm_domain" ),
			"administrator",
			"font-icon-Manager",
			"stm_custom_icons_menu"
		);
		$STM_Custom_Icons  = new STM_Custom_Icons;
		add_action( 'admin_enqueue_scripts', array( $STM_Custom_Icons, 'stm_admin_scripts' ) );
	}
}