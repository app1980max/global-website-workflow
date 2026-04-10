<?php
$tpls = get_template_directory() . '/partials/ico_listing/parts/';
$post_id = get_the_ID();
$meta = get_post_meta($post_id);
$metas = [];

if (!empty($meta)) {
	foreach ($meta as $key => $value) {
		if (!empty($value[0])) {
			$metas[$key] = $value[0];
		}
	}
}

?>

<div class="single-ico-listing" itemscope itemtype="http://schema.org/Product">

    <div class="container">
		<?php require_once($tpls . 'title_and_icon.php'); ?>

		<?php require_once($tpls . 'ico_date_and_image.php'); ?>

        <div class="stm_single_ico__content">
			<?php the_content(); ?>
        </div>

		<?php require_once($tpls . 'token_sale.php'); ?>

		<?php require_once($tpls . 'additional_links.php'); ?>

		<?php require_once($tpls . 'screenshots.php'); ?>

		<?php require_once($tpls . 'market_and_returns.php'); ?>

		<?php require_once($tpls . 'rates.php'); ?>

		<?php require_once($tpls . 'short_review.php'); ?>

		<?php require_once($tpls . 'related.php'); ?>
    </div>

    <div class="stm_single_ico__comments">
        <div class="container">
			<?php if (comments_open(get_the_ID())) {
				comments_template();
			} ?>
        </div>
    </div>

</div>