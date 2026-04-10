<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php if(!empty($element['data'])): ?>
    <div class="stm-icontext">

        <?php if(!empty($element['data']['link'])): ?>
            <a class="no_deco" target="_blank" href="<?php echo esc_url($element['data']['link']); ?>">
        <?php endif; ?>


            <?php if(!empty($element['data']['icon'])): ?>
                <i class="stm-icontext__icon stm_hb_mtc <?php echo esc_attr($element['data']['icon']); ?>"></i>
            <?php endif; ?>
            <?php if(!empty($element['data']['title'])): ?>
                <object class="stm-icontext__text"><?php echo esc_attr($element['data']['title']); ?></object>
            <?php endif; ?>

        <?php if(!empty($element['data']['link'])): ?>
            </a>
        <?php endif; ?>

    </div>
<?php endif; ?>