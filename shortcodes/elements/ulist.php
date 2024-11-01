<?php
add_shortcode('upside_ulists', 'upside_lite_toolkit_shortcode_ulist');
add_shortcode('upside_ulist', '__return_false');
function upside_lite_toolkit_shortcode_ulist($atts, $content = null) {

    extract(shortcode_atts(array(
        'type' => 'no-icon'
    ), $atts));

    $ulist_cls = '';
    switch ( $type ) {
        case 'no-icon':
            $ulist_cls = 'kopa-list-1';
            break;
        case 'round':
            $ulist_cls = 'kopa-e-list list-unorder';
            break;
        case 'plus':
            $ulist_cls = 'kopa-e-list kopa-plus-list';
            break;
        case 'custom':
            $ulist_cls = 'kopa-e-list kopa-icon-list';
            break;
    }

    $items  = upside_toolkit_get_shortcode($content, true, array('upside_ulist'));
    $lists   = array();

    if ($items) {
        foreach ($items as $item) {
            switch ( $type ) {
                case 'round':
                    $lists[]   = sprintf('<li><p>%s</p></li>', wp_kses_post($item['content']));
                    break;
                case 'plus':
                    $lists[]   = sprintf('<li><span class="fa fa-plus"></span>%s</li>', wp_kses_post($item['content']));
                    break;
                case 'custom':
                    if ( isset($item['atts']['font_awesome_icon']) && ! empty($item['atts']['font_awesome_icon']) ) {
                        $lists[]   = sprintf('<li><i class="%s"></i>%s</li>', esc_attr($item['atts']['font_awesome_icon']), wp_kses_post($item['content']));
                    } else {
                        $lists[]   = sprintf('<li>%s</li>', wp_kses_post($item['content']));
                    }
                    break;
                case 'no-icon':
                    $lists[]   = sprintf('<li>%s</li>', wp_kses_post($item['content']));
                    break;
            }
        }
    }

    $output = '<ul class="' . esc_attr($ulist_cls) . '">';
        $output .= implode('', $lists);
    $output .= '</ul>';

    return apply_filters('upside_lite_toolkit_shortcode_ulist', $output, $atts, $content);
}