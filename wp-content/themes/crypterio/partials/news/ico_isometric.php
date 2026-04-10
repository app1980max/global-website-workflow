<?php
$post_thumbnail = wpb_getImageBySize(array(
    'attach_id'  => get_post_thumbnail_id(),
    'thumb_size' => '350x250',
));
$post_thumbnail = $post_thumbnail ? $post_thumbnail['thumbnail'] : '';

?>

<li>
    <div class="stm_flipbox">
        <div class="stm_flipbox__front">
            <div class="inner_flip">
                <div class="stm_projects__meta">
                    <div class="inner">
                        <div class="post_inner">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo html_entity_decode($post_thumbnail); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="stm_news_unit-block">
                                <h5 class="no_stripe"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stm_flipbox__back">
            <div class="inner_flip">
                <div class="stm_projects__meta">
                    <div class="inner">
                        <div class="post_inner">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo html_entity_decode($post_thumbnail); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>">
                                <div class="stm_news_unit-block">
                                    <h5><?php the_title(); ?></h5>
                                    <?php if ($excerpt = crypterio_substr_text(get_the_excerpt(), 50)): ?>
                                        <p class="flip_excerpt"><?php echo esc_html($excerpt); ?></p>
                                    <?php endif; ?>
                                    <p class="flip_date"><?php echo esc_html(get_the_date()); ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>