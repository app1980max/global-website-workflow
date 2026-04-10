<?php crypterio_get_header('ico_listing');
$parts = crypterio_parts_config();

stm_ico_directory_module_styles($parts['ico_grid']);
stm_ico_directory_module_styles('stm_ico_grid_categories');
$atts = array();

$type = (!empty($_GET['type'])) ? sanitize_text_field($_GET['type']) : '';

$statuses = crypterio_status_score();

$queried = get_queried_object();
$title = $queried->name;

$offset = (!empty($_GET['stm_page'])) ? intval($_GET['stm_page']) : 0;

$term_id = intval($queried->term_id);

$atts['add_args'] = array();
$atts['add_args']['tax_query'] = array(
    array(
		'taxonomy' => 'stm_ico_listing_category',
		'field'    => 'term_id',
		'terms'    => $term_id,
    )
);

$atts['stm_category'] = $term_id;

$parts = crypterio_parts_config();
$atts['date_or_logo'] = $parts['date_or_logo'];

?>


    <div class="stm_ico_archive">
        <div class="vc_custom_heading text_align_center stripe_bottom">
            <h1 class="text-center"><?php echo esc_attr($title); ?></h1>
        </div>

		<?php if($parts['categories']): ?>
            <div class="container">
                <div class="heading_font stm_ico_grid_categories">
					<?php get_template_part('partials/ico_listing/categories'); ?>
                </div>
            </div>
		<?php endif; ?>

        <div class="container">
            <?php if(!empty($statuses[$type])):
                $atts['stm_pagination'] = true;
                $atts['offset'] = $offset;
                ?>
                <div class="stm_ico_archive__list">
				    <?php crypterio_load_vc_element('ico_grid', $atts, $type); ?>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <h4><?php esc_html_e('Upcoming ICO', 'crypterio'); ?></h4>
                        <?php crypterio_load_vc_element('ico_grid', $atts, 'upcoming'); ?>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <h4><?php esc_html_e('Active ICO', 'crypterio'); ?></h4>
                        <?php crypterio_load_vc_element('ico_grid', $atts, 'live'); ?>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <h4><?php esc_html_e('Ended ICO', 'crypterio'); ?></h4>
                        <?php crypterio_load_vc_element('ico_grid', $atts, 'finished'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php get_footer(); ?>