<?php
add_shortcode('upside_caption', 'upside_lite_toolkit_shortcode_caption');
function upside_lite_toolkit_shortcode_caption($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'title' => esc_attr__('Title', 'upside-lite-toolkit')
        ),
    $atts );

    $output = '';
    
    if($content){
        $output = sprintf('<div class="elements-box"><div class="element-title text-center">
                            <span></span>
                            <h2>%s</h2>
                            <p>%s</p>
                        </div></div>', esc_html($atts['title']), $content);
    }

    return apply_filters('upside_lite_toolkit_shortcode_caption', $output, $content);
}
