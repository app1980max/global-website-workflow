<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/*Load butterbean framework*/
add_action('plugins_loaded', 'stm_listings_load_butterbean');
function stm_listings_load_butterbean()
{
    require_once(STM_CONFIGURATIONS_PATH . '/ico_directory/admin/butterbean/butterbean.php');
}

function stm_listings_validate_checkbox($value)
{
    return wp_validate_boolean($value) ? 'on' : false;
}

function stm_listings_no_validate($value)
{
    return $value;
}

function stm_listings_validate_image($value)
{
    return !empty($value) ? intval($value) : false;
}

function stm_listings_validate_repeater($value, $butterbean)
{

    /*We need to save user additional features in hidden taxonomy*/
    if ($butterbean->name == 'additional_features') {
        global $post;
        $post_id = $post->ID;
        $new_terms = explode(',', $value);
        wp_set_object_terms($post_id, $new_terms, 'stm_additional_features');
    }
    /*Saved*/

    return $value;
}

function stm_listings_multiselect($value, $butterbean)
{
    global $post;
    $post_id = $post->ID;
    wp_set_object_terms($post_id, $value, $butterbean->name);

    return $value ? implode(',', $value) : false;
}

function stm_listings_validate_gallery($value)
{
    $value = explode(',', $value);
    $values = array();

    $featured_image = '';

    if (!empty($value)) {
        $i = 0;
        foreach ($value as $img_id) {
            $i++;
            $img_id = intval($img_id);
            if (!empty($img_id)) {
                if ($i != 1) {
                    $values[] = $img_id;
                }
            }
        }
    }

    return !empty($values) ? $values : false;
}

function stm_gallery_videos_posters($value)
{
    if (!empty($value)) {
        $value = explode(',', $value);
    }
    return $value;
}

function stm_ico_validate_date($value) {
	return strtotime($value);
}