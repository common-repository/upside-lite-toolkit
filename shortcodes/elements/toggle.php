<?php
add_shortcode('upside_toggles', 'upside_lite_toolkit_shortcode_toggles');
add_shortcode('upside_toggle', '__return_false');
function upside_lite_toolkit_shortcode_toggles($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));

    $items = upside_toolkit_get_shortcode($content, true, array('upside_toggle'));

    $output = '';

    if ($items) {
        $output.= '<ul class="toggle-view">';
        foreach ($items as $item) {
            $default_items = array(
                'title' => esc_attr__('Tab title', 'upside-lite-toolkit'),
            );
            if ( ! $item['atts'] ) {
                $item['atts'] = array();
            }
            $item['atts'] = array_merge($default_items, $item['atts']);
            $title    = $item['atts']['title'];
            $output .= '<li class="clearfix">';
                $output .= sprintf('<h6>%s</h6>', esc_html($title));
                $output .= '<span class="fa fa-plus"></span>';
                $output .= '<div class="clear"></div> ';
                $output .= '<div class="kopa-panel clearfix">';
                    $output .= sprintf('<p>%s</p>', do_shortcode($item['content']));
                $output .= '</div>';
            $output .= '</li>';
        }
        $output .= '</ul>';
    }


    return apply_filters('upside_lite_toolkit_shortcode_toggles', $output, $atts, $content);
}