<?php
remove_shortcode('gallery');
add_shortcode('gallery', 'upside_lite_toolkit_shortcode_gallery');

function upside_lite_toolkit_shortcode_gallery($atts, $content = null) {
    extract(shortcode_atts(array(
        'ids' => ''
    ), $atts));
    $out = '';

    if ( ! empty($ids) ) {
        $id_arr = explode(',', $ids);
        if ( $id_arr ) {
            $out .= '<div class="owl-carousel owl-carousel-6">';
            foreach ( $id_arr as $id ) {
                $image_src = upside_lite_get_image_by_id($id);
                if ( ! empty($image_src) ) {
                    $params = array( 'width' => 826, 'height' => 440, 'crop' => true );
                    $out .= '<div class="item">';
                    $out .= '<img src="' . $image_src . '" alt="' . trim(strip_tags( get_post_meta($id, '_wp_attachment_image_alt', true) )) . '" />';
                    $out .= '</div>';
                }
            }
            $out .= '</div>';
        }
    }
    return $out;
}