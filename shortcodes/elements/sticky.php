<?php
add_shortcode('upside_sticky', 'upside_lite_toolkit_shortcode_sticky');
function upside_lite_toolkit_shortcode_sticky($atts, $content = null) {
    if ($content) {
        extract(shortcode_atts(array(
            'class' => 'sticky-note sticky-sky'
        ), $atts));

        $html = sprintf('

            <div class="%s">
                <p>%s</p>
            </div>

        ', esc_attr($class),
           do_shortcode($content)
        );

        return apply_filters('upside_lite_toolkit_shortcode_sticky', $html, $atts, $content);
    }
}