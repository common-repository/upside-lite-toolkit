<?php
add_shortcode('upside_alert', 'upside_lite_toolkit_shortcode_alert');
function upside_lite_toolkit_shortcode_alert($atts, $content = null) {
    if ($content) {
        extract(shortcode_atts(array(
            'class' => 'alert alert-dark-blue alert-dismissable',
            'font_awesome_icon' => 'fa fa-check'
        ), $atts));

        $html = sprintf('

            <div class="%s">
                <i class="%s"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                %s
            </div>

        ', esc_attr($class),
           esc_attr($font_awesome_icon),
           do_shortcode($content)
        );

        return apply_filters('upside_lite_toolkit_shortcode_alert', $html, $atts, $content);
    }
}