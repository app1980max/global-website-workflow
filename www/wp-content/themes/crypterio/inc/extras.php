<?php
function stm_set_html_content_type() {
	return 'text/html';
}

add_filter( 'nav_menu_css_class', 'crypterio_nav_class', 10, 2 );
function crypterio_nav_class( $classes, $item ) {
	// Get post_type for this post
	$post_type = get_query_var( 'post_type' );

	// Removes current_page_parent class from blog menu item
	if ( get_post_type() === $post_type ) {
		$classes = array_filter( $classes, 'crypterio_nav_current_value' );
	}

	// Go to Menus and add a menu class named: {custom-post-type}-menu-item
	// This adds a current_page_parent class to the parent menu item
	if ( is_array( $classes ) && in_array( $post_type . '-menu-item', $classes, true ) ) {
		array_push( $classes, 'current_page_parent' );
	}

	return $classes;
}

function crypterio_nav_current_value( $element ) {
	return ( 'current_page_parent' !== $element );
}

if ( ! function_exists( 'crypterio_page_id' ) ) {
	function crypterio_page_id() {
		$page_ID = get_the_ID();

		if ( is_front_page() ) {
			$page_ID = get_option( 'page_on_front' );
		}

		if ( is_home() || is_category() || is_search() || is_tag() || is_tax() ) {
			$page_ID = get_option( 'page_for_posts' );
		}

		return $page_ID;
	}
}

add_filter( 'upload_mimes', 'crypterio_custom_mime' );

if ( ! function_exists( 'crypterio_custom_mime' ) ) {
	function crypterio_custom_mime( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['ico'] = 'image/icon';

		return $mimes;
	}
}

if ( ! function_exists( 'crypterio_comment' ) ) {
	function crypterio_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP );

		$rating = '';
		if ( isset( $comment->post_type ) && 'product' === $comment->post_type && get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
		}

		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' !== $args['style'] ) { ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body clearfix">
	<?php } ?>
		<?php if ( 0 !== $args['avatar_size'] ) { ?>
		<div class="vcard">
			<?php echo get_avatar( $comment, 174 ); ?>
		</div>
	<?php } ?>
		<div class="comment-info clearfix">
			<div class="comment-author"><?php echo get_comment_author_link(); ?></div>
			<div class="comment-meta commentmetadata">
				<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
					<?php /* translators: %1$s: date, %2$s: time */ ?>
					<?php printf( esc_html__( '%1$s at %2$s', 'crypterio' ), esc_html( get_comment_date() ), esc_html( get_comment_time() ) ); ?>
				</a>
				<?php if ( $rating ) { ?>
					<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating"
						title="
						<?php
						/* translators: %d: number */
						echo sprintf( esc_html__( 'Rated %d out of 5', 'crypterio' ), esc_html( $rating ) );
						?>
						">
						<span style="width:<?php echo esc_attr( ( $rating / 5 ) * 100 ); ?>%"><strong
									itemprop="ratingValue"><?php echo esc_html( $rating ); ?></strong> <?php esc_html_e( 'out of 5', 'crypterio' ); ?></span>
					</div>
				<?php } ?>
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'reply_text' => wp_kses( __( '<i class="fas fa-reply"></i> Reply', 'crypterio' ), array( 'i' => array() ) ),
							'add_below'  => $add_below,
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						)
					)
				);
				?>
				<?php edit_comment_link( esc_html__( 'Edit', 'crypterio' ), '  ', '' ); ?>
			</div>
			<div class="comment-text">
				<?php comment_text(); ?>
			</div>
			<?php if ( '0' === $comment->comment_approved ) { ?>
				<em
						class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'crypterio' ); ?></em>
			<?php } ?>
		</div>

		<?php if ( 'div' !== $args['style'] ) { ?>
		</div>
	<?php } ?>
		<?php
	}
}

add_filter( 'comment_form_default_fields', 'crypterio_comment_form_fields' );

if ( ! function_exists( 'crypterio_comment_form_fields' ) ) {
	function crypterio_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html5     = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		$fields    = array(
			'author' => '<div class="row">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="input-group comment-form-author">
		            			<input placeholder="' . esc_attr__( 'Name', 'crypterio' ) . ( $req ? ' *' : '' ) . '" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
	                        </div>
	                    </div>',
			'email'  => '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div class="input-group comment-form-email">
							<input placeholder="' . esc_attr__( 'E-mail', 'crypterio' ) . ( $req ? ' *' : '' ) . '" class="form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
						</div>
					</div>',
			'url'    => '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div class="input-group comment-form-url">
							<input placeholder="' . esc_attr__( 'Website', 'crypterio' ) . '" class="form-control" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
						</div>
					</div></div>',
		);

		return $fields;
	}
}

add_filter( 'comment_form_defaults', 'crypterio_comment_form' );

if ( ! function_exists( 'crypterio_comment_form' ) ) {
	function crypterio_comment_form( $args ) {
		$args['comment_field'] = '<div class="input-group comment-form-comment">
						        <textarea placeholder="' . _x( 'Message', 'noun', 'crypterio' ) . ' *" class="form-control" name="comment" rows="9" aria-required="true"></textarea>
							  </div>
							  <div class="input-group">
							    <button type="submit" class="button size-lg icon_left"><i class="fas fa-chevron-right"></i> ' . esc_html__( 'post a comment', 'crypterio' ) . '</button>
						    </div>';

		return $args;
	}
}

if ( ! function_exists( 'crypterio_move_comment_field_to_bottom' ) ) {
	function crypterio_move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;

		return $fields;
	}
}

add_filter( 'comment_form_fields', 'crypterio_move_comment_field_to_bottom' );

if ( ! function_exists( 'crypterio_wpml_lang_switcher' ) ) {
	function crypterio_wpml_lang_switcher() {
		if ( function_exists( 'icl_get_languages' ) ) {
			$languages = icl_get_languages( 'skip_missing=0&orderby=code' );
			$output    = '';
			if ( ! empty( $languages ) ) {
				$output .= '<div id="stm_wpml_lang_switcher">';
				$output .= '<div class="active_language">' . esc_html( ICL_LANGUAGE_NAME_EN ) . ' <i class="fas fa-angle-down"></i></div>';
				$output .= '<ul>';
				foreach ( $languages as $l ) {
					if ( ! $l['active'] ) {
						$output .= '<li>';
						$output .= '<a href="' . esc_url( $l['url'] ) . '">';
						$output .= esc_html( icl_disp_language( $l['native_name'] ) );
						$output .= '</a>';
						$output .= '</li>';
					}
				}
				$output .= '</ul>';
				$output .= '</div>';
				echo wp_kses_post( $output );
			}
		}
	}
}

if ( ! function_exists( 'crypterio_get_header_style' ) ) {
	function crypterio_get_header_style() {
		$header_style = get_theme_mod( 'header_style', 'header_style_1' );
		if ( isset( $_REQUEST['header_demo'] ) && 'header_style_1' === $_REQUEST['header_demo'] ) {
			$header_style = 'header_style_1';
		} elseif ( isset( $_REQUEST['header_demo'] ) && 'header_style_2' === $_REQUEST['header_demo'] ) {
			$header_style = 'header_style_2';
		} elseif ( isset( $_REQUEST['header_demo'] ) && 'header_style_3' === $_REQUEST['header_demo'] ) {
			$header_style = 'header_style_3';
		} elseif ( isset( $_REQUEST['header_demo'] ) && 'header_style_4' === $_REQUEST['header_demo'] ) {
			$header_style = 'header_style_4';
		} elseif ( isset( $_REQUEST['header_demo'] ) && 'header_style_5' === $_REQUEST['header_demo'] ) {
			$header_style = 'header_style_5';
		} elseif ( isset( $_REQUEST['header_demo'] ) && 'header_style_6' === $_REQUEST['header_demo'] ) {
			$header_style = 'header_style_6';
		} elseif ( isset( $_REQUEST['header_demo'] ) && 'header_style_7' === $_REQUEST['header_demo'] ) {
			$header_style = 'header_style_7';
		} elseif ( isset( $_REQUEST['header_demo'] ) && 'header_style_8' === $_REQUEST['header_demo'] ) {
			$header_style = 'header_style_8';
		}

		return $header_style;
	}
}

if ( ! function_exists( 'crypterio_get_header' ) ) {
	function crypterio_get_header( $header = '' ) {
		return get_header( $header );
	}
}

if ( ! function_exists( 'crypterio_get_socials' ) ) {
	function crypterio_get_socials( $type = 'header_socials' ) {
		$socials_array  = array();
		$socials_enable = get_theme_mod( $type );
		$socials_enable = explode( ',', $socials_enable );

		$socials        = get_theme_mod( 'socials' );
		$socials_values = array();
		if ( ! empty( $socials ) ) {
			parse_str( $socials, $socials_values );
		}

		if ( $socials_enable ) {
			foreach ( $socials_enable as $social ) {
				if ( ! empty( $socials_values[ $social ] ) ) {
					$socials_array[ $social ] = $socials_values[ $social ];
				}
			}
		}

		return $socials_array;
	}
}

if ( ! function_exists( 'crypterio_page_title' ) ) {
	function crypterio_page_title( $display = true, $single_posts = '', $vacancies_posts = '' ) {
		global $wp_locale;

		$m        = get_query_var( 'm' );
		$year     = get_query_var( 'year' );
		$monthnum = get_query_var( 'monthnum' );
		$day      = get_query_var( 'day' );
		$search   = get_query_var( 's' );
		$title    = '';

		// If there is a post
		if ( is_single() || ( is_home() && ! is_front_page() ) || ( is_page() && ! is_front_page() ) || is_front_page() ) {
			$title = single_post_title( '', false );
		}

		if ( is_home() ) {
			if ( ! get_option( 'page_for_posts' ) ) {
				$title = $single_posts;
			}
		}

		// If there's a post type archive
		if ( is_post_type_archive() ) {
			$post_type = get_query_var( 'post_type' );
			if ( is_array( $post_type ) ) {
				$post_type = reset( $post_type );
			}
			$post_type_object = get_post_type_object( $post_type );
			if ( ! $post_type_object->has_archive ) {
				$title = post_type_archive_title( '', false );
			}
		}

		// If there's a category or tag
		if ( is_category() || is_tag() ) {
			$title = single_term_title( '', false );
		}

		// If there's a taxonomy
		if ( is_tax() ) {
			$term = get_queried_object();
			if ( $term ) {
				$tax   = get_taxonomy( $term->taxonomy );
				$title = single_term_title( '', false );
			}
		}

		// If there's an author
		if ( is_author() && ! is_post_type_archive() ) {
			$author = get_queried_object();
			if ( $author ) {
				$title = $author->display_name;
			}
		}

		// Post type archives with has_archive should override terms.
		if ( is_post_type_archive() && $post_type_object->has_archive ) {
			if ( function_exists( 'is_shop' ) && is_shop() ) {
				$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
			} else {
				$title = post_type_archive_title( '', false );
			}
		}

		// If there's a month
		if ( is_archive() && ! empty( $m ) ) {
			$my_year  = substr( $m, 0, 4 );
			$my_month = $wp_locale->get_month( substr( $m, 4, 2 ) );
			$my_day   = intval( substr( $m, 6, 2 ) );
			$title    = $my_year . ( $my_month ? $my_month : '' ) . ( $my_day ? $my_day : '' );
		}

		// If there's a year
		if ( is_archive() && ! empty( $year ) ) {
			$title = $year;
			if ( ! empty( $monthnum ) ) {
				$title .= ' ' . $wp_locale->get_month( $monthnum );
			}
			if ( ! empty( $day ) ) {
				$title .= ' ' . zeroise( $day, 2 );
			}
		}

		// If it's a search
		if ( is_search() ) {
			/* translators: 1: separator, 2: search phrase */
			$title = esc_html__( 'Search Results', 'crypterio' );
		}

		// If it's a 404 page
		if ( is_404() ) {
			$title = esc_html__( 'Page not found', 'crypterio' );
		}

		if ( $display ) {
			echo esc_html( $title );
		} else {
			return esc_html( $title );
		}
	}
}

add_filter( 'woocommerce_add_to_cart_fragments', 'crypterio_cart_fragments' );
function crypterio_cart_fragments( $fragments ) {
	ob_start();
	?>
	<?php if ( ! WC()->cart->is_empty() ) : ?>
	<span class="count shopping-cart__product"><?php esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
<?php else : ?>
	<span class="count shopping-cart__product"><?php esc_html_e( '0', 'crypterio' ); ?></span>
<?php endif; ?>
	<?php

	$fragments['.shopping-cart__product'] = ob_get_clean();

	return $fragments;
}

if ( ! function_exists( 'crypterio_breadcrumbs' ) ) {
	function crypterio_breadcrumbs() {
		if ( function_exists( 'bcn_display' ) && ! get_post_meta( get_the_ID(), 'disable_breadcrumbs', true ) ) {
			?>
			<div class="breadcrumbs">
				<?php bcn_display(); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'crypterio_substr_text' ) ) {
	function crypterio_substr_text( $text = '', $len ) {
		if ( strlen( $text ) > $len ) {
			$text  = mb_substr( $text, 0, strpos( $text, ' ', $len ) );
			$text .= '...';
		}

		return $text;
	}
}

if ( ! function_exists( 'crypterio_get_structure' ) ) {
	function crypterio_get_structure( $sidebar_id, $sidebar_type, $sidebar_position, $layout = false ) {

		$cols_default = array( 9, 3 );

		$config = crypterio_config();
		if ( 'crypto_blog' === $config['layout'] ) {
			$cols_default = array( 8, 4 );
		}

		$output                   = array();
		$output['content_before'] = '';
		$output['content_after']  = '';
		$output['sidebar_before'] = '';
		$output['sidebar_after']  = '';
		$output['class']          = 'posts_list';

		if ( 'grid' === $layout ) {
			$output['class'] = 'posts_grid';
		}
		if ( ! empty( $_GET['layout'] ) && 'grid' === $_GET['layout'] ) {
			$output['class'] = 'posts_grid';
		}

		if ( 'vc' === $sidebar_type ) {
			if ( $sidebar_id ) {
				$sidebar = get_post( $sidebar_id );
			}
		} else {
			if ( $sidebar_id ) {
				$sidebar = true;
			}
		}

		if ( isset( $sidebar ) ) {
			$output['class'] .= ' with_sidebar';
		}

		if ( 'right' === $sidebar_position && isset( $sidebar ) ) {
			$output['content_before'] .= '<div class="row row-flex">';
			$output['content_before'] .= '<div class="col-lg-' . $cols_default[0] . ' col-md-' . $cols_default[0] . ' col-sm-12 col-xs-12">';
			$output['content_before'] .= '<div class="col_in __padd-right">';

			$output['content_after']  .= '</div>';
			$output['content_after']  .= '</div>'; // col
			$output['sidebar_before'] .= '<div class="col-lg-' . $cols_default[1] . ' col-md-' . $cols_default[1] . ' hidden-sm hidden-xs">';
			// .sidebar-area
			$output['sidebar_after'] .= '</div>'; // col
			$output['sidebar_after'] .= '</div>'; // row
		}

		if ( 'left' === $sidebar_position && isset( $sidebar ) ) {
			$output['content_before'] .= '<div class="row row-flex">';
			$output['content_before'] .= '<div class="col-lg-' . $cols_default[0] . ' col-lg-push-' . $cols_default[1] . ' col-md-' . $cols_default[0] . ' col-md-push-' . $cols_default[1] . ' col-sm-12 col-xs-12">';
			$output['content_before'] .= '<div class="col_in __padd-left">';

			$output['content_after']  .= '</div>';
			$output['content_after']  .= '</div>'; // col
			$output['sidebar_before'] .= '<div class="col-lg-' . $cols_default[1] . ' col-lg-pull-' . $cols_default[0] . ' col-md-' . $cols_default[1] . ' col-md-pull-' . $cols_default[0] . ' hidden-sm hidden-xs">';
			// .sidebar-area
			$output['sidebar_after'] .= '</div>'; // col
			$output['sidebar_after'] .= '</div>'; // row
		}

		return $output;
	}
}

if ( ! function_exists( 'crypterio_blog_layout' ) ) {
	function crypterio_blog_layout() {
		$blog_layout = get_theme_mod( 'blog_layout', 'list' );
		if ( isset( $_REQUEST['layout'] ) && 'grid' === $_REQUEST['layout'] ) {
			$blog_layout = 'grid';
		}

		return $blog_layout;
	}
}

if ( ! function_exists( 'crypterio_importer_done_function' ) ) {
	function crypterio_importer_done_function() {
		$crypterio_config = crypterio_config();

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$options_file = get_template_directory() . '/inc/demo/' . $crypterio_config['layout'] . '/options.json';
		if ( file_exists( $options_file ) ) {
			$encode_options = $wp_filesystem->get_contents( $options_file );
			$import_options = json_decode( $encode_options, true );
			foreach ( $import_options as $key => $value ) {
				update_option( $key, $value );
			}
		}

		update_option( 'show_on_front', 'page' );

		$front_page = get_page_by_title( 'home' );
		if ( isset( $front_page->ID ) ) {
			update_option( 'page_on_front', $front_page->ID );
		}
		$blog_page = get_page_by_title( 'news' );
		if ( isset( $blog_page->ID ) ) {
			update_option( 'page_for_posts', $blog_page->ID );
		}
		$shop_page = get_page_by_title( 'shop' );
		if ( isset( $shop_page->ID ) ) {
			update_option( 'woocommerce_shop_page_id', $shop_page->ID );
			update_option( 'shop_catalog_image_size[width]', 175 );
			update_option( 'shop_catalog_image_size[height]', 258 );
			update_option( 'shop_single_image_size[width]', 175 );
			update_option( 'shop_single_image_size[height]', 258 );
			update_option( 'shop_thumbnail_image_size[width]', 54 );
			update_option( 'shop_thumbnail_image_size[height]', 79 );
		}
		$checkout_page = get_page_by_title( 'checkout' );
		if ( isset( $checkout_page->ID ) ) {
			update_option( 'woocommerce_checkout_page_id', $checkout_page->ID );
		}
		$cart_page = get_page_by_title( 'cart' );
		if ( isset( $cart_page->ID ) ) {
			update_option( 'woocommerce_cart_page_id', $cart_page->ID );
		}
		$account_page = get_page_by_title( 'my account' );
		if ( isset( $account_page->ID ) ) {
			update_option( 'woocommerce_myaccount_page_id', $account_page->ID );
		}

		update_option( 'booked_light_color', '#002e5b' );
		update_option( 'booked_dark_color', '#6c98e1' );
		update_option( 'booked_button_color', '#6c98e1' );

		$theme_mods_file = get_template_directory() . '/inc/demo/' . $crypterio_config['layout'] . '/theme_mods.json';
		if ( file_exists( $theme_mods_file ) ) {
			$encode_theme_mods = $wp_filesystem->get_contents( $theme_mods_file );
			$import_theme_mods = json_decode( $encode_theme_mods, true );
			foreach ( $import_theme_mods as $key => $value ) {
				set_theme_mod( $key, $value );
			}
		}

		$widgets_file = get_template_directory() . '/inc/demo/' . $crypterio_config['layout'] . '/widget_data.json';
		if ( file_exists( $widgets_file ) ) {
			$encode_widgets_array = $wp_filesystem->get_contents( $widgets_file );
			crypterio_import_widgets( $encode_widgets_array );
		}

		if ( class_exists( 'RevSlider' ) ) {

			$main_slider = get_template_directory() . '/inc/demo/' . $crypterio_config['layout'] . '/main_slider.zip';

			if ( file_exists( $main_slider ) ) {
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $main_slider );
			}

			$about_us_slider = get_template_directory() . '/inc/demo/' . $crypterio_config['layout'] . '/about_us_slider.zip';

			if ( file_exists( $about_us_slider ) ) {
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $about_us_slider );
			}

			$service_slider = get_template_directory() . '/inc/demo/' . $crypterio_config['layout'] . '/service_slider.zip';

			if ( file_exists( $service_slider ) ) {
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $service_slider );
			}

			$fullscreen_main_slider = get_template_directory() . '/inc/demo/' . $crypterio_config['layout'] . '/fullscreen_main_slider.zip';

			if ( file_exists( $fullscreen_main_slider ) ) {
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $fullscreen_main_slider );
			}
		}
	}
}

add_action( 'stm_importer_done', 'crypterio_importer_done_function' );
add_action( 'after_switch_theme', 'crypterio_setup_options' );

if ( ! function_exists( 'crypterio_setup_options' ) ) {
	function crypterio_setup_options() {
		$crypterio_config = crypterio_config();

		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$options_file = get_template_directory() . '/inc/demo/' . $crypterio_config['layout'] . '/options.json';
		if ( file_exists( $options_file ) ) {
			$encode_options = $wp_filesystem->get_contents( $options_file );
			$import_options = json_decode( $encode_options, true );
			foreach ( $import_options as $key => $value ) {
				update_option( $key, $value );
			}
		}
	}
}

if ( ! function_exists( 'crypterio_sass_config' ) ) {
	function crypterio_sass_config( $defaults ) {
		return array(
			'variables' => array( get_template_directory_uri() . '/assets/scss/site/_base_variables.scss' ),
			'imports'   => array( get_template_directory_uri() . '/style.scss' ),
		);
	}
}

add_filter( 'sass_configuration', 'crypterio_sass_config' );

if ( ! function_exists( 'crypterio_hex2rgba' ) ) {
	function crypterio_hex2rgba( $color, $opacity = false ) {

		$default = 'rgb(0,0,0)';

		if ( empty( $color ) ) {
			return $default;
		}

		if ( '#' === $color[0] ) {
			$color = substr( $color, 1 );
		}

		if ( strlen( $color ) === 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) === 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		$rgb = array_map( 'hexdec', $hex );

		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ',', $rgb ) . ')';
		}

		return $output;
	}
}

if ( ! function_exists( 'crypterio_get_top_bar_info' ) ) {
	function crypterio_get_top_bar_info() {
		$top_bar_info = array();
		for ( $i = 1; $i <= 10; $i++ ) {
			$top_bar_info_office = get_theme_mod( 'top_bar_info_' . $i . '_office' );
			if ( ! empty( $top_bar_info_office ) ) {
				$top_bar_info[ $i ]['office'] = $top_bar_info_office;
			}
			$top_bar_info_address = get_theme_mod( 'top_bar_info_' . $i . '_address' );
			if ( ! empty( $top_bar_info_address ) && ! empty( $top_bar_info_office ) ) {
				$top_bar_info[ $i ]['address'] = $top_bar_info_address;
			}
			$top_bar_info_address_icon = get_theme_mod( 'top_bar_info_' . $i . '_address_icon', 'stm-marker' );
			if ( ! empty( $top_bar_info_address ) && ! empty( $top_bar_info_address_icon ) && ! empty( $top_bar_info_office ) ) {
				$top_bar_info[ $i ]['address_icon'] = $top_bar_info_address_icon;
			}
			$top_bar_info_hours = get_theme_mod( 'top_bar_info_' . $i . '_hours' );
			if ( ! empty( $top_bar_info_hours ) && ! empty( $top_bar_info_office ) ) {
				$top_bar_info[ $i ]['hours'] = $top_bar_info_hours;
			}
			$top_bar_info_hours_icon = get_theme_mod( 'top_bar_info_' . $i . '_hours_icon', 'fas fa-clock' );
			if ( ! empty( $top_bar_info_hours ) && ! empty( $top_bar_info_hours_icon ) && ! empty( $top_bar_info_office ) ) {
				$top_bar_info[ $i ]['hours_icon'] = $top_bar_info_hours_icon;
			}
			$top_bar_info_phone = get_theme_mod( 'top_bar_info_' . $i . '_phone' );
			if ( ! empty( $top_bar_info_phone ) && ! empty( $top_bar_info_office ) ) {
				$top_bar_info[ $i ]['phone'] = $top_bar_info_phone;
			}
			$top_bar_info_phone_icon = get_theme_mod( 'top_bar_info_' . $i . '_phone_icon', 'fas fa-phone' );
			if ( ! empty( $top_bar_info_phone ) && ! empty( $top_bar_info_phone_icon ) && ! empty( $top_bar_info_office ) ) {
				$top_bar_info[ $i ]['phone_icon'] = $top_bar_info_phone_icon;
			}
		}

		return $top_bar_info;
	}
}

function crypterio_sanitize_text_field( $text ) {
	return apply_filters( 'crypterio_sanitize_text_field', $text );
}

if ( ! function_exists( 'crypterio_paging_nav' ) ) :
	function crypterio_paging_nav( $paging_extra_class = '', $current_query = '' ) {
		global $wp_query, $wp_rewrite;

		if ( ! $current_query ) {
			$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
			$pages = $wp_query->max_num_pages;
		} else {
			$paged = $current_query->query_vars['paged'];
			$pages = $current_query->max_num_pages;
		}

		if ( $pages < 2 ) {
			return;
		}

		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		$links = paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $pages,
				'current'   => $paged,
				'mid_size'  => 1,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => '<i class="fas fa-chevron-left"></i>',
				'next_text' => '<i class="fas fa-chevron-right"></i>',
				'type'      => 'list',
			)
		);

		if ( $links ) :
			?>
			<?php echo wp_kses_post( $links ); ?>
			<?php
		endif;
	}
endif;

function stm_ajax_load_events() {
	check_ajax_referer( 'stm_ajax_load_events', 'security' );
	$data           = array();
	$load_more      = true;
	$posts_per_page = ( ! empty( $_POST['load_by'] ) ) ? intval( $_POST['load_by'] ) : 1;
	$page           = ( ! empty( $_POST['page'] ) ) ? intval( $_POST['page'] ) : 1;
	$events_filter  = ( ! empty( $_POST['filter'] ) ) ? sanitize_text_field( $_POST['filter'] ) : null;
	$category       = ( ! empty( $_POST['category'] ) ) ? esc_html( $_POST['category'] ) : null;

	$offset = $page * $posts_per_page;
	$args   = array(
		'post_type'      => 'stm_event',
		'posts_per_page' => $posts_per_page,
		'offset'         => $offset,
		'orderby'        => 'meta_value_num',
		'meta_key'       => 'stm_event_date_start',
		'post_status'    => 'publish',
		'order'          => 'ASC',
	);

	if ( 'upcoming' === $events_filter ) {
		$args['meta_query'][] = array(
			'key'     => 'stm_event_date_start',
			'value'   => time(),
			'compare' => '>=',
		);
	} elseif ( 'past' === $events_filter ) {
		$args['meta_query'][] = array(
			'key'     => 'stm_event_date_start',
			'value'   => time(),
			'compare' => '<=',
		);
	}

	if ( 'all' !== $category ) {
		$args['stm_event_category'] = $category;
	}
	$query = new WP_Query( $args );

	$html = '';
	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();

			get_template_part( 'partials/content-event', 'modern' );
		}
		$html = ob_get_clean();
	}

	$data['new_page'] = $page + 1;
	$data['html']     = $html;

	if ( $query->max_num_pages === $data['new_page'] ) {
		$load_more = false;
	}

	$data['load_more'] = $load_more;

	echo wp_json_encode( $data );

	exit;
}

add_action( 'wp_ajax_stm_ajax_load_events', 'stm_ajax_load_events' );
add_action( 'wp_ajax_nopriv_stm_ajax_load_events', 'stm_ajax_load_events' );

function stm_ajax_load_portfolio() {
	check_ajax_referer( 'stm_ajax_load_portfolio', 'security' );
	$data           = array();
	$load_more      = true;
	$posts_per_page = ( ! empty( $_POST['load_by'] ) ) ? intval( $_POST['load_by'] ) : 1;
	$page           = ( ! empty( $_POST['page'] ) ) ? intval( $_POST['page'] ) : 1;
	$category       = ( ! empty( $_POST['category'] ) ) ? esc_html( $_POST['category'] ) : null;

	$offset = $page * $posts_per_page;
	$args   = array(
		'post_type'      => 'stm_portfolio',
		'posts_per_page' => $posts_per_page,
		'offset'         => $offset,
	);
	if ( 'all' !== $category ) {
		$args['stm_portfolio_category'] = $category;
	}
	$query = new WP_Query( $args );

	$html = '';
	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();

			get_template_part( 'partials/content', 'portfolio' );
		}
		$html = ob_get_clean();
	}

	$data['new_page'] = $page + 1;
	$data['html']     = $html;

	if ( $query->max_num_pages === $data['new_page'] ) {
		$load_more = false;
	}

	$data['load_more'] = $load_more;

	echo wp_json_encode( $data );

	exit;
}

add_action( 'wp_ajax_stm_ajax_load_portfolio', 'stm_ajax_load_portfolio' );
add_action( 'wp_ajax_nopriv_stm_ajax_load_portfolio', 'stm_ajax_load_portfolio' );

add_action( 'before_delete_post', 'member_before_delete' );
function member_before_delete( $postid ) {
	global $post_type;
	if ( 'event_member' !== $post_type ) {
		return;
	}

	$event_id = get_post_meta( $postid, 'memberId', true );

	$event_attended = get_post_meta( $event_id, 'event_attended', true );
	update_post_meta( $event_id, 'event_attended', $event_attended - 1 );
}

add_filter( 'language_attributes', 'stm_preloader_html_class', 100 );

function stm_preloader_html_class( $output ) {
	$enable_preloader = get_theme_mod( 'enable_preloader', false );
	$preloader_class  = '';

	if ( $enable_preloader ) {
		$preloader_class = ' class="stm-site-preloader"';
	}

	return $output . $preloader_class;
}

// AMP Custom styles
add_action( 'amp_post_template_css', 'ampforwp_add_custom_css_example', 11 );
function ampforwp_add_custom_css_example() {
	?>
	/* Add your custom css here */
	.stm_sidebar, .vc_cta3-container, .post_bottom .media-body, .stm_post_comments, .amp-wp-article-content .post_thumbnail, .stm_post_info  {
	display: none;
	}
	.share_buttons label {
	display: block;
	padding: 0 0 10px 5px;
	}
	<?php
}

function blockchain_check_string( $string ) {
	return 'true' === $string;
}

function blockchain_vpb_animate_style( $animation = '' ) {
	$animate = ( 'none' !== $animation ) ? 'wpb_animate_when_almost_visible wpb_' . $animation . ' ' . $animation : '';
	return $animate;
}

add_filter( 'mc4wp_form_element_attributes', 'stm_mc4wp_form_element_attributes' );

function stm_mc4wp_form_element_attributes( $attributes ) {
	return $attributes;
}

function crypterio_load_vc_element( $__template, $__vars = array(), $__template_name = '', $custom_path = '' ) {
	extract( $__vars );
	include crypterio_locate_vc_element( $__template, $__template_name, $custom_path );
}

function crypterio_locate_vc_element( $templates, $template_name = '', $custom_path ) {
	$located = false;

	foreach ( (array) $templates as $template ) {

		$folder = $template;

		if ( ! empty( $template_name ) ) {
			$template = $template_name;
		}

		if ( substr( $template, -4 ) !== '.php' ) {
			$template .= '.php';
		}

		if ( empty( $custom_path ) ) {
			$located = locate_template( 'partials/vc_parts/' . $folder . '/' . $template );
			if ( ! $located ) {
				$located = get_template_directory() . '/partials/vc_parts/' . $folder . '/' . $template;
			}
		} else {
			$located = locate_template( $custom_path );
			if ( ! $located ) {
				$located = get_template_directory() . '/' . $custom_path . '.php';
			}
		}

		if ( file_exists( $located ) ) {
			break;
		}
	}

	return apply_filters( 'crypterio_locate_vc_element', $located, $templates );
}

add_filter( 'stm_hb_theme_options', 'crypterio_hb_theme_options' );

function crypterio_hb_theme_options( $options ) {
	$options['header']['options']['top_bar']['options']['top_fullwidth'] = array(
		'type' => 'select',
		'data' => array(
			'title'   => esc_html__( 'Enable fullwidth', 'crypterio' ),
			'value'   => '',
			'choices' => array(
				''          => esc_html__( 'Disable', 'crypterio' ),
				'fullwidth' => esc_html__( 'Enable', 'crypterio' ),
			),
		),
	);
	return $options;
}

add_filter( 'stm_hb_row_class', 'crypterio_hb_row_class', 10, 2 );

function crypterio_hb_row_class( $row, $pos ) {
	$options = get_option( 'stm_hb_settings', array() );

	if ( ! empty( $options[ $pos . '_fullwidth' ] ) ) {
		$row .= ' stm_header_row_' . $pos . '__fullwidth';
	}

	return $row;
}

function crypterio_get_terms_array( $id, $taxonomy, $filter, $link = false, $args = '', $limit = 0 ) {
	$terms = wp_get_post_terms( $id, $taxonomy );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		if ( $limit ) {
			$terms = array_slice( $terms, 0, $limit );
		}

		if ( $link ) {
			$links = array();
			if ( ! empty( $args ) ) {
				$args = crypterio_array_as_string( $args );
			}
			foreach ( $terms as $term ) {
				$url     = get_term_link( $term );
				$links[] = "<a {$args} href='{$url}' title='{$term->name}'>{$term->name}</a>";
			}
			$terms = $links;
		} else {
			$terms = wp_list_pluck( $terms, $filter );
		}
	} else {
		$terms = array();
	}

	return apply_filters( 'pearl_get_terms_array', $terms );
}

function crypterio_array_as_string( $arr ) {
	$r = implode( ' ', array_map( 'crypterio_array_map', $arr, array_keys( $arr ) ) );

	return $r;
}

function crypterio_array_map( $v, $k ) {
	return $k . '="' . $v . '"';
}

function crypterio_get_image_vc( $id, $image_size ) {
	$image = wpb_getImageBySize(
		array(
			'attach_id'  => $id,
			'thumb_size' => $image_size,
		)
	);
	return ( ! empty( $image['thumbnail'] ) ) ? $image['thumbnail'] : '';
}

function crypterio_minimize_word( $word, $length = 40, $affix = '...' ) {
	return mb_strimwidth( $word, 0, $length, $affix );
}

add_action( 'wp', 'crypterio_post_views' );

function crypterio_post_views() {
	if ( is_singular( 'post' ) ) {
		if ( empty( $_COOKIE['stm_post_watched'] ) ) {
			$id      = get_the_ID();
			$cookies = $id;
			setcookie( 'stm_post_watched', $cookies, time() + ( 86400 * 30 ), '/' );
			stm_increase_views( get_the_ID() );
		}

		if ( ! empty( $_COOKIE['stm_post_watched'] ) ) {
			$cookies = $_COOKIE['stm_post_watched'];
			$cookies = explode( ',', $cookies );

			if ( ! in_array( get_the_ID(), $cookies, true ) ) {
				$cookies[] = get_the_ID();

				$cookies = implode( ',', $cookies );

				stm_increase_views( get_the_ID() );
				setcookie( 'stm_post_watched', $cookies, time() + ( 86400 * 30 ), '/' );
			}
		}
	}
}

function stm_increase_views( $post_id ) {
	$keys = array(
		'stm_post_views',
	);

	foreach ( $keys as $key ) {

		$current_views = intval( get_post_meta( $post_id, $key, true ) );

		$new_views = ( ! empty( $current_views ) ) ? $current_views + 1 : 1;

		update_post_meta( $post_id, $key, $new_views );
	}
}

function stm_display_views( $id ) {
	$views = get_post_meta( $id, 'stm_post_views', true );
	echo ( ! empty( $views ) ) ? esc_html( $views ) : 0;
}

add_filter( 'vc_wpb_getimagesize', 'crypterio_vc_wpb_getimagesize', 100, 3 );

/**
 * Hook in VC function and crop retina image then add it to the original img tag with retina data param
 *
 * @param $attachment
 * @param $id
 * @param $params
 * @return mixed
 */
function crypterio_vc_wpb_getimagesize( $attachment, $id, $params ) {
	/*Already cropped*/
	if ( ! empty( $params['retined'] ) && $params['retined'] ) {
		return $attachment;
	}
	/*Empty thumbnail*/
	if ( empty( $attachment['thumbnail'] ) || empty( $params['thumb_size'] ) ) {
		return $attachment;
	}

	/*Get size as array width - height*/
	$img_size = $params['thumb_size'];

	$retinasize = explode( 'x', $img_size );

	/*If size is in wrong format*/
	if ( ! is_array( $retinasize ) || count( $retinasize ) !== 2 ) {
		return $attachment;
	}

	/*If still wrong*/
	if ( ! intval( $retinasize[0] ) || ! intval( $retinasize[1] ) ) {
		return $attachment;
	}

	$retinasize = $retinasize[0] * 2 . 'x' . $retinasize[1] * 2;

	$retina_img = wpb_getImageBySize(
		array(
			'attach_id'  => $id,
			'thumb_size' => $retinasize,
			'retined'    => true,
		)
	);

	if ( ! empty( $retina_img['thumbnail'] ) ) {
		$retina = explode( ' ', $retina_img['thumbnail'] );
		$retina = ( is_array( $retina ) && ! empty( $retina[2] ) ) ? str_replace( 'src', 'srcset', $retina[2] ) : '';
	}

	if ( ! empty( $retina ) ) {
		$retina                  = substr( $retina, 0, -1 ) . ' 2x"';
		$attachment['thumbnail'] = str_replace( '<img', '<img ' . $retina, $attachment['thumbnail'] );
	}

	/*Adding lazyload*/
	$lazyload = str_replace(
		array( 'srcset="', 'src="', 'class="' ),
		array( 'data-srcset="', 'data-src="', 'class="lazyload ' ),
		$attachment['thumbnail']
	);

	$thumbsizes = explode( 'x', $img_size );
	if ( ! is_array( $thumbsizes ) || count( $thumbsizes ) !== 2 ) {
		return $attachment;
	}

	if ( ! intval( $thumbsizes[0] ) || ! intval( $thumbsizes[1] ) ) {
		return $attachment;
	}

	$thumbsize = $thumbsizes[0] / 10 . 'x' . $thumbsizes[1] / 10;
	$thumb_img = wpb_getImageBySize(
		array(
			'attach_id'  => $id,
			'thumb_size' => $thumbsize,
			'retined'    => true,
		)
	);

	if ( ! empty( $thumb_img['thumbnail'] ) ) {
		preg_match( '@src="([^"]+)"@', $thumb_img['thumbnail'], $thumb );
		$thumb    = array_pop( $thumb );
		$lazyload = str_replace(
			'data-src="',
			'src="' . $thumb . '" data-src="',
			$lazyload
		);
	}

	$padding = 0;

	$attachment['thumbnail']  = '<div class="stm_lazyload" style="padding-bottom:' . $padding . '%">';
	$attachment['thumbnail'] .= $lazyload;
	$attachment['thumbnail'] .= '</div>';

	return $attachment;
}

function crypterio_upload_photo( $file, $parent_post_id ) {
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}

	$attach_id = '';

	$upload_overrides = array( 'test_form' => false );

	$photo = wp_handle_upload( $file, $upload_overrides );
	if ( $photo && ! isset( $photo['error'] ) ) {
		$filename      = $photo['file'];
		$filetype      = wp_check_filetype( basename( $filename ), null );
		$wp_upload_dir = wp_upload_dir();

		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

		require_once ABSPATH . 'wp-admin/includes/image.php';

		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		set_post_thumbnail( $parent_post_id, $attach_id );

	} else {
		$attach_id = $photo['error'];
	}

	return $attach_id;
}

function crypterio_socials_list() {
	return array(
		'facebook'      => esc_html__( 'Facebook', 'crypterio' ),
		'twitter'       => esc_html__( 'Twitter', 'crypterio' ),
		'instagram'     => esc_html__( 'Instagram', 'crypterio' ),
		'google-plus'   => esc_html__( 'Google+', 'crypterio' ),
		'vimeo'         => esc_html__( 'Vimeo', 'crypterio' ),
		'linkedin'      => esc_html__( 'Linkedin', 'crypterio' ),
		'behance'       => esc_html__( 'Behance', 'crypterio' ),
		'dribbble'      => esc_html__( 'Dribbble', 'crypterio' ),
		'flickr'        => esc_html__( 'Flickr', 'crypterio' ),
		'github'        => esc_html__( 'Git', 'crypterio' ),
		'pinterest'     => esc_html__( 'Pinterest', 'crypterio' ),
		'yahoo'         => esc_html__( 'Yahoo', 'crypterio' ),
		'delicious'     => esc_html__( 'Delicious', 'crypterio' ),
		'dropbox'       => esc_html__( 'Dropbox', 'crypterio' ),
		'reddit'        => esc_html__( 'Reddit', 'crypterio' ),
		'soundcloud'    => esc_html__( 'Soundcloud', 'crypterio' ),
		'google'        => esc_html__( 'Google', 'crypterio' ),
		'skype'         => esc_html__( 'Skype', 'crypterio' ),
		'youtube'       => esc_html__( 'Youtube', 'crypterio' ),
		'youtube-play'  => esc_html__( 'Youtube Play', 'crypterio' ),
		'tumblr'        => esc_html__( 'Tumblr', 'crypterio' ),
		'whatsapp'      => esc_html__( 'Whatsapp', 'crypterio' ),
		'paper-plane'   => esc_html__( 'Telegram', 'crypterio' ),
		'odnoklassniki' => esc_html__( 'Odnoklassniki', 'crypterio' ),
		'vk'            => esc_html__( 'Vk', 'crypterio' ),
		'xing'          => esc_html__( 'Xing', 'crypterio' ),
	);
}

function crypterio_get_date_format() {
	return get_option( 'date_format', 'M j, Y' );
}

function crypterio_allowed_html() {
	$allowed_html           = wp_kses_allowed_html( 'post' );
	$allowed_html['canvas'] = array(
		'width'           => 1,
		'height'          => 1,
		'class'           => 1,
		'style'           => 1,
		'allowfullscreen' => array(),
		'allow'           => array(),
	);

	return apply_filters( 'crypterio_allowed_html', $allowed_html );
}
