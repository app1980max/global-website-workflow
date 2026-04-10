<?php
crypterio_get_header();

$config = crypterio_config();

$load_more = array(
	'crypto_blog'
);

$tpl = (in_array($config['layout'], $load_more)) ? 'extended' : '';

?>

<div class="content-area">

	<?php
	while ( have_posts() ) {
		the_post();

		get_template_part( 'partials/content', $tpl);

	}
	?>

</div>

<?php get_footer(); ?>
