<?php
add_shortcode('upside_accordions', 'upside_lite_toolkit_shortcode_accordions');
add_shortcode('upside_accordion', '__return_false');

function upside_lite_toolkit_shortcode_accordions($atts, $content = null) {
    extract(shortcode_atts(array('icon_pos'=>'right'), $atts));
    $parent_cls = 'kopa-accordion';
    if ( ! isset($icon_pos) ) {
        $icon_pos = '';
    }
    if ( 'left' == $icon_pos ) {
        $parent_cls .= ' style1';
    }

    $default_items = array(
        'title' => esc_attr__('Accordion title', 'upside-lite-toolkit'),
        'content' => ''
    );
    $items = upside_toolkit_get_shortcode($content, true, array('upside_accordion'));

    $output = '<div class="' . esc_attr($parent_cls) . '">';

        if ($items) {
            $parent_id = 'accordions-' . wp_generate_password(4, false, false);

            $output    .= sprintf('<div class="panel-group accordion" id="%s">', esc_attr($parent_id));

                $is_first = true;
                foreach ($items as $item) {
                    if ( ! $item['atts'] ) {
                        $item['atts'] = array();
                    }
                    $item['atts'] = array_merge($default_items, $item['atts']);
                    $child_id = 'accordion-' . wp_generate_password(4, false, false);
                    $title = $item['atts']['title'];

                    $output.= '<div class="panel panel-default">';
                        $panel_heading_class = 'panel-heading';
                        $panel_collapse_class = 'panel-collapse';
                        if ( $is_first ) {
                            $panel_heading_class .= ' active';
                            $panel_collapse_class .= ' in';
                        } else {
                            $panel_collapse_class .= ' collapse';
                        }
                        $output.= '<div class="' . esc_attr($panel_heading_class) . '">';

                            $output .= '<h4 class="panel-title">';
                            $output .= sprintf('<a data-toggle="collapse" data-parent=".accordion" href="#%s" class="collapsed">', esc_attr($child_id));
                            $output .= '<span class="btn-title"></span>';
                            $output .= sprintf('<span class="tab-title">%s</span>', esc_html($title));
                            $output .= '</a>';
                            $output .= '</h4>';

                        $output .= '</div><!--end heading-->';

                        $output .= sprintf('<div id="%s" class="%s">', esc_attr($child_id), esc_attr($panel_collapse_class));

                            $output .= '<div class="panel-body">';
                            $output .= do_shortcode($item['content']);
                            $output .= '</div>';

                        $output .= '</div><!--panel-collapse-->';

                    $output .= '</div><!--end panel-->';
                    $is_first = false;
                }

            $output     .= '</div>';

        }

    $output .= '</div>';


    return apply_filters('upside_lite_toolkit_shortcode_accordions', $output, $atts, $content);
}