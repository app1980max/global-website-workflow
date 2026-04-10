<?php crypterio_get_header('ico_listing');
$crypterio_config = crypterio_config();

$tpl = '';

if($crypterio_config['layout'] == 'ico_listing') {
    $tpl = 'ico_listing';
}

?>

<div class="content-area">

	<?php while (have_posts()) {
		the_post();
		get_template_part('partials/ico_listing/single', $tpl);
    } ?>
</div>

<?php get_footer(); ?>