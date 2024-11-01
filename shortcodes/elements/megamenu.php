<?php
add_shortcode('upside_megamenu', 'upside_lite_toolkit_shortcode_megamenu');
function upside_lite_toolkit_shortcode_megamenu($atts, $content = null) {
    extract(shortcode_atts(array('id' => 0), $atts));
    $output = '';

    if ( isset($atts['id']) && (int) $atts['id'] > 0 ) {
        $post_id = $atts['id'];
        $sidebar1 = get_post_meta($post_id, 'ut-sidebar-1', true);
        $sidebar2 = get_post_meta($post_id, 'ut-sidebar-2', true);
        $sidebar3 = get_post_meta($post_id, 'ut-sidebar-3', true);
        ob_start();

        if ( ( 'sidebar_hide' != $sidebar1 && is_active_sidebar($sidebar1) ) || ( 'sidebar_hide' != $sidebar2 && is_active_sidebar($sidebar2) ) || ( 'sidebar_hide' != $sidebar3 && is_active_sidebar($sidebar3) ) ) {
            echo '<div class="sf-mega sf-mega-s1">';

                echo '<div class="row">';

                    if ( ( 'sidebar_hide' != $sidebar1 && is_active_sidebar($sidebar1) ) || ( 'sidebar_hide' != $sidebar2 && is_active_sidebar($sidebar2) ) ) {
                        if ( 'sidebar_hide' != $sidebar3 && is_active_sidebar($sidebar3) ) {
                            $left_class = 'col-md-5 col-sm-5 col-xs-12';
                        } else {
                            $left_class = 'col-md-12 col-sm-12 col-xs-12';
                        }
                        echo sprintf('<div class="%s">', esc_attr($left_class));
                            ?>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?php
                                    if ( 'sidebar_hide' != $sidebar1 && is_active_sidebar($sidebar1) ) {
                                        dynamic_sidebar($sidebar1);
                                    }
                                    ?>

                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?php
                                        if ( 'sidebar_hide' != $sidebar2 && is_active_sidebar($sidebar2) ) {
                                            dynamic_sidebar($sidebar2);
                                        }
                                    ?>
                                </div>
                            </div>

                            <?php
                        echo '</div>';
                    }

                    if ( 'sidebar_hide' != $sidebar3 && is_active_sidebar($sidebar3) ) {
                        echo '<div class="col-md-7 col-sm-7 col-xs-12">';
                            dynamic_sidebar($sidebar3);
                        echo '</div>';
                    }

                echo '</div>';

            echo '</div>';
        }
        $output .= ob_get_contents();
        ob_end_clean();
    }

    return apply_filters('upside_lite_toolkit_shortcode_megamenu', $output, $atts, $content);
}
