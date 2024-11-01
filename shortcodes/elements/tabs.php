<?php
add_shortcode('upside_tabs', 'upside_lite_toolkit_shortcode_tabs');
add_shortcode('upside_tab', '__return_false');
function upside_lite_toolkit_shortcode_tabs($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));

    $items  = upside_toolkit_get_shortcode($content, true, array('upside_tab'));
    $navs   = array();
    $panels = array();

    $default_items = array(
        'title' => esc_attr__('Tab title', 'upside-lite-toolkit'),
        'content' => ''
    );

    if ($items) {
        $active = 'active';
        foreach ($items as $item) {
            if ( ! $item['atts'] ) {
                $item['atts'] = array();
            }
            $item['atts'] = array_merge($default_items, $item['atts']);
            $title    = $item['atts']['title'];
            $item_id  = 'tab-' . wp_generate_password(4, false, false);
            $navs[]   = sprintf('<li class="%s"><a href="#%s" data-toggle="tab">%s</a></li>', esc_attr($active), esc_attr($item_id), do_shortcode($title));
            $panels[] = sprintf('<div class="tab-pane %s" id="%s">%s</div>', esc_attr($active), esc_attr($item_id), do_shortcode($item['content']));
            $active   = '';
        }
    }

    $output = '<div class="kopa-tab-container-1">';
    
    $output .= '<ul class="nav nav-tabs kopa-tabs-1">';
    $output .= implode('', $navs);
    $output .= '</ul>';
    
    $output .= '<div class="tab-content">';
    $output .= implode('', $panels);
    $output .= '</div>';
    
    $output .= '</div>';

    return apply_filters('upside_lite_toolkit_shortcode_tabs', $output, $atts, $content);
}