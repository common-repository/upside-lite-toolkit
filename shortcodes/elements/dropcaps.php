<?php
add_shortcode('upside_dropcap', 'upside_lite_toolkit_shortcode_dropcap');
function upside_lite_toolkit_shortcode_dropcap($atts, $content = null) {
    if ($content) {
        extract(shortcode_atts(array('class' => '', 'f_char' => ''), $atts));
        $class = isset($atts['class']) ? $atts['class'] : 'kp-dropcap-1';
        $f_char = isset($atts['f_char']) ? $atts['f_char'] : '';
        return apply_filters('upside_lite_toolkit_shortcode_dropcap', sprintf('<p><span class="%s">%s</span>%s</p>', $class, $f_char, $content), $atts, $content);
    }
}