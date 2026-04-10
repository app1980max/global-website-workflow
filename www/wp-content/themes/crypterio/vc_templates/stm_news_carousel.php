<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

list($args) = vc_build_loop_query($loop, get_the_ID());

wp_enqueue_style('stm_news_grid', get_template_directory_uri() . '/assets/css/shared/vc/stm_news_grid.css', array(), CRYPTERIO_THEME_VERSION);
wp_enqueue_style('stm_news_carousel', get_template_directory_uri() . '/assets/css/shared/vc/stm_news_carousel.css', array(), CRYPTERIO_THEME_VERSION);
wp_enqueue_style('owl.carousel');
wp_enqueue_script('owl.carousel');
wp_enqueue_script('fancybox');
wp_enqueue_style('fancybox');

$owl_id = uniqid('owl-');

if (!empty($args)):
	if (!empty($offset)) $args['offset'] = $offset;
	$args['meta_query'] = array(array('key' => '_thumbnail_id'));

    if(!empty($popular) and $popular == 'popular') {
        $args['meta_value_num'] = 'DESC';
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'stm_post_views';
        $args['meta_query'][] = array(
            'key'     => 'stm_post_views',
            'value'   => intval(0),
            'compare' => '>=',
        );
    }

	$query = new WP_Query($args);
	if ($query->have_posts()): ?>
        <div class="stm_news_carousel mbc" id="<?php echo esc_attr($owl_id); ?>">
            <div class="stm_news_carousel__top">
				<?php if (!empty($title)): ?>
                    <div class="stm_news_carousel__title">
                        <h4 class="wtc"><?php echo esc_attr($title); ?></h4>
                    </div>
				<?php endif; ?>
            </div>
            <div class="stm_news_grid">
				<?php while ($query->have_posts()): $query->the_post(); ?>
                    <div class="stm_news_grid__single">
                        <div class="stm_news_grid__single_inner">
                            <div class="stm_news_grid__image">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php echo html_entity_decode(crypterio_get_image_vc(get_post_thumbnail_id(get_the_ID()), '220x135')); ?>
                                </a>
                                <?php get_template_part('partials/news/parts/_video'); ?>
                            </div>
                            <h4>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="wtc stc_h">
									<?php echo crypterio_minimize_word(get_the_title(), '50', ''); ?>
                                </a>
                            </h4>
                        </div>
                    </div>
				<?php endwhile; ?>
            </div>
        </div>
		<?php wp_reset_postdata(); ?>

        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(window).load(function () {
                    var owlRtl = false;
                    if ($('body').hasClass('rtl')) {
                        owlRtl = true;
                    }
                    $("#<?php echo esc_js($owl_id); ?> .stm_news_grid").owlCarousel({
                        rtl: owlRtl,
                        autoplay: false,
                        dots: false,
                        loop: true,
                        nav: true,
                        margin: 30,
                        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
                        responsive: {
                            0: {
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            1199: {
                                items: 3
                            }
                        }
                    });
                });
            });
        </script>

	<?php endif; ?>

<?php endif;