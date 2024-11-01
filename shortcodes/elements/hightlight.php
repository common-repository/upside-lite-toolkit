<?php
add_shortcode('upside_hightlight', 'upside_lite_toolkit_shortcode_hightlight');
function upside_lite_toolkit_shortcode_hightlight($atts, $content = null) {
    if ($content) {
        extract(shortcode_atts(array(
            'text_decoration' => 'underline',
            'color' => '#ed145b'
        ), $atts));

        $style = sprintf('text-decoration:%s; color:%s;', esc_attr($text_decoration), esc_attr($color));
        $html = sprintf('

            <span style="%s">%s</span>

        ', $style, do_shortcode($content)
        );

        return apply_filters('upside_lite_toolkit_shortcode_hightlight', $html, $atts, $content);
    }
}