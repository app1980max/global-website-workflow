<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

wp_enqueue_style('stm_services_grid', get_template_directory_uri() . '/assets/css/shared/vc/stm_services_grid.css', array(), CRYPTERIO_THEME_VERSION);
wp_enqueue_script('isotope');
wp_enqueue_script('imagesloaded');

$number = (!empty($number)) ? intval($number) : 10;

$args = array(
	'post_type'      => 'stm_service',
	'posts_per_page' => -1,
);

$categories = get_terms('stm_service_category');

$uniq = uniqid('stm_services_grid');

$q = new WP_Query($args); ?>

<?php if ($q->have_posts()): ?>
    <div class="stm_services_grid <?php echo esc_attr($uniq . ' ' . $css_class); ?>">

		<?php if (!empty($categories)): ?>
            <div class="stm_services_grid__categories sbc heading_font">
				<?php foreach ($categories as $category): ?>
                    <div class="stm_services_grid__categories_single mbc_h"
                         data-slug="<?php echo esc_attr($category->slug); ?>">
						<?php echo esc_attr($category->name); ?>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>

        <div class="stm_services_grid__posts">
			<?php while ($q->have_posts()):
                $q->the_post();
			    $post_id = get_the_ID();
			    $service_cost = get_post_meta($post_id, 'service_cost', true);
			?>
                <a href="<?php the_permalink(); ?>" class="stm_services_grid__posts_single no_deco
                <?php echo implode(' ', crypterio_get_terms_array($post_id, 'stm_service_category', 'slug')); ?>">
                    <div class="stm_services_grid__posts_hover">
                        <div class="stm_services_grid__posts_single_image">
                            <?php echo crypterio_get_image_vc(get_post_thumbnail_id(), '350x195'); ?>
                        </div>
                        <div class="stm_services_grid__posts_single__inner">
                            <h4 class="stm_services_grid__posts_single_title sbc_a">
                                <?php the_title(); ?>
                            </h4>
                            <div class="stm_services_grid__posts_single_meta heading_font">
                                <?php if(!empty($service_cost)): ?>
                                    <div class="service_cost"><?php echo esc_attr($service_cost); ?></div>
                                <?php endif; ?>
                                <div class="read_more">
                                    <span class="ttc"><?php esc_html_e('Read more', 'crypterio'); ?></span>
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
			<?php endwhile; ?>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            var $container = $(".<?php echo esc_attr($uniq); ?> .stm_services_grid__posts");
            var originLeft = true;
            if ($('body').hasClass('rtl')) {
                originLeft = false;
            }
            $container.isotope({
                layoutMode: 'fitRows',
                itemSelector: '.stm_services_grid__posts_single',
                isOriginLeft: originLeft,
                filter: function () {
                    return $(this).index() < <?php echo esc_js($number) ?>
                }
            });
            $container.imagesLoaded().progress(function () {
                $container.isotope('layout');
            });
            $container.isotope('layout');
            $('.<?php echo esc_attr($uniq); ?> .stm_services_grid__categories_single').on('click', function () {
                var i = 0;

                $(this).closest('.stm_services_grid__categories').find('.stm_services_grid__categories_single').removeClass('mbc');
                $(this).addClass('mbc');
                var sort = $(this).attr('data-slug');
                $container.isotope({
                    filter: function () {
                        if ($(this).hasClass(sort) && i < <?php echo esc_js($number) ?>) {
                            i++;
                            return $(this);
                        }
                    }
                });
                return false;
            });

            $('.<?php echo esc_attr($uniq); ?> .stm_services_grid__categories_single:first-child').trigger('click');
        });
    </script>
<?php endif;