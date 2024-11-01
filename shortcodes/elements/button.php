<?php
add_shortcode('upside_button', 'upside_lite_toolkit_shortcode_button');
function upside_lite_toolkit_shortcode_button($atts, $content = null) {
    extract(shortcode_atts(array('class' => '', 'link' => '', 'target' => ''), $atts));

    $link    = isset($atts['link']) ? $atts['link'] : '#';
    $class   = isset($atts['class']) ? $atts['class'] : 'kopa-button pink-button small-button kopa-button-icon';
    $target  = isset($atts['target']) ? $atts['target'] : '';
    if(!$target){
        $target = '_self';
    }

    $output = sprintf('<a href="%s" class="%s" target="%s">%s</a>', $link, $class, $target, do_shortcode($content));
    return apply_filters('upside_lite_toolkit_shortcode_button', $output);
}
