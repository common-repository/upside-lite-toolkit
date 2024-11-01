<?php
add_shortcode('upside_price_tables', 'upside_lite_toolkit_shortcode_price_tables');
add_shortcode('upside_price_table', '__return_false');
function upside_lite_toolkit_shortcode_price_tables($atts, $content = null) {
    extract(shortcode_atts(array(
        'column_per_row' => '4'
    ), $atts));

    $default_items = array(
        'title' => esc_attr__('Price title', 'upside-lite-toolkit'),
        'price_value' => '09',
        'price_currency' => '$',
        'price_per' => esc_attr__('Month', 'upside-lite-toolkit'),
        'special_text' => '',
        'features' => '',
        'btn_title' => esc_attr__('Sign-up', 'upside-lite-toolkit'),
        'btn_link_to' => '#',
        'btn_link_target' => '_blank'
    );
    $items  = upside_toolkit_get_shortcode($content, true, array('upside_price_table'));
    $cols = array();

    if ( ! in_array($column_per_row, array('2', '3', '4')) ) {
        $column_per_row = '4';
    }
    $row_cls = sprintf('pricing-column col-md-%s col-sm-%s col-xs-12', 12/(int)$column_per_row, 12/(int)$column_per_row);


    if ($items) {

        foreach ($items as $item) {
            if ( ! $item['atts'] ) {
                $item['atts'] = array();
            }
            $item['atts'] = array_merge($default_items, $item['atts']);

            $features_html = '';
            $special_html = '';
            if ( ! empty($item['atts']['features']) ) {
                $features = explode('|', $item['atts']['features']);
                if ( $features ) {
                    $features_html .= '<ul class="features">';
                        foreach ( $features as $feature ) {
                            $features_html .= sprintf('<li><p>%s</p></li>', wp_kses_post($feature));
                        }
                    $features_html .= '</ul>';
                }
            }

            if ( ! empty($item['atts']['special_text']) ) {
                $special_html = sprintf('<span class="special"><span>%s</span></span>', esc_html($item['atts']['special_text']));
            }

            $cols[] = sprintf('

                <div class="%s">

                    <div class="pricing-column-inner">
                        <div class="pricing-header">
                            %s
                            <div class="pricing-title">
                                %s
                            </div>
                            <div class="pricing-price">
                                <span><sup>%s</sup>%s</span>/%s
                            </div>
                        </div><!--end:pricing-header -->
                        %s
                        <div class="pricing-footer">
                            <a href="%s" class="kopa-button medium-button pink-button" target="%s">%s</a>
                        </div>
                    </div>

                </div>

            ', esc_attr($row_cls),
               $special_html,
               esc_html($item['atts']['title']),
               esc_html($item['atts']['price_currency']),
               esc_html($item['atts']['price_value']),
               esc_html($item['atts']['price_per']),
                $features_html,
               esc_url($item['atts']['btn_link_to']),
               esc_attr($item['atts']['btn_link_target']),
               esc_html($item['atts']['btn_title'])
            );
        }
    }

    $output = '<div class="table-4col table-4col-s1 text-center row"> ';
        $output .= implode('', $cols);
    $output .= '</div>';

    return apply_filters('upside_lite_toolkit_shortcode_price_tables', $output, $atts, $content);
}