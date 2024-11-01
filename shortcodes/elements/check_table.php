<?php

add_shortcode('upside_check_tables', 'upside_lite_toolkit_shortcode_check_tables');
add_shortcode('upside_check_table', '__return_false');
function upside_lite_toolkit_shortcode_check_tables($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));

    $default_items = array(
        'title' => esc_attr__('Column title', 'upside-lite-toolkit'),
        'features' => '',
        'btn_title' => esc_attr__('Buy now', 'upside-lite-toolkit'),
        'btn_link_to' => '#',
        'btn_link_target' => '_blank',
        'btn_show' => '1',
    );
    $items  = upside_toolkit_get_shortcode($content, true, array('upside_check_table'));
    $cols = array();

    if ($items) {

        foreach ($items as $item) {
            if ( ! $item['atts'] ) {
                $item['atts'] = array();
            }
            $item['atts'] = array_merge($default_items, $item['atts']);

            $features_html = '';
            $footer_html = '';

            if ( ! empty($item['atts']['features']) ) {
                $features = explode('|', $item['atts']['features']);
                if ( $features ) {
                    $features_html .= '<ul class="features">';
                        foreach ( $features as $feature ) {
                            if ( 'check' == $feature ) {
                                $feature = '<i class="fa fa-check"></i>';
                            } elseif ( 'uncheck' == $feature ) {
                                $feature = '<i class="fa fa-close"></i>';
                            }
                            $features_html .= sprintf('<li><p>%s</p></li>', wp_kses_post($feature));
                        }
                    $features_html .= '</ul>';
                }
            }

            if ( 1 == $item['atts']['btn_show'] ) {
                $footer_html = sprintf('<a href="%s" class="kopa-button small-button navy-button" target="%s">%s</a>', esc_url($item['atts']['btn_link_to']), esc_attr($item['atts']['btn_link_target']), esc_html($item['atts']['btn_title']) );
            }

            $cols[] = sprintf('

                    <div class="pricing-column">
                        <div class="pricing-header">
                            %s
                        </div><!--end:pricing-header -->
                       %s
                        <div class="pricing-footer">
                            %s
                        </div><!--end:pricing-footer-->
                    </div><!--end:pricing-column-->

            ', esc_html($item['atts']['title']),
               $features_html,
               $footer_html
            );
        }
    }

    $output = '<div class="table-5col text-center clearfix">';
        $output .= implode('', $cols);
    $output .= '</div>';

    return apply_filters('upside_lite_toolkit_shortcode_check_tables', $output, $atts, $content);
}