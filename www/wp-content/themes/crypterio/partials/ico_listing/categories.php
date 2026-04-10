<?php $terms = get_terms('stm_ico_listing_category', array(
	'hide_empty' => true
));

$active = 'all';
$obj = get_queried_object();

if(!empty($obj->term_id)) $active = $obj->term_id;

if (!empty($terms)): ?>


	<a href="<?php echo esc_url(get_post_type_archive_link('stm_ico_listing')); ?>"
	   class="sbc_a <?php if ($active == 'all') echo 'active'; ?>">
		<?php esc_html_e('All', 'crypterio'); ?>
	</a>

	<?php foreach ($terms as $term): ?>
		<a href="<?php echo esc_url(get_term_link($term)); ?>" class="sbc_a <?php if($term->term_id === $active) echo 'active'; ?>">
			<?php echo esc_attr($term->name); ?>
		</a>
	<?php endforeach; ?>

<?php endif; ?>
