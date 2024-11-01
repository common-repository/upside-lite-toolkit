<?php
add_shortcode('upside_progress', 'upside_lite_toolkit_shortcode_progress');
function upside_lite_toolkit_shortcode_progress($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' => 'pro-bar-wrapper pro-blue',
            'font_awesome_icon' => 'fa fa-code',
            'icon_text' => '',
            'bar_percent' => '85',
            'bar_delay' => '400'
        ),
        $atts );

    extract($atts);
    ob_start();
    $output = NULL;

    ?>
<div class="<?php echo esc_attr($class);?>">
    <div class="pro-bar-container color-gray">
        <?php
        if ( ! empty($icon_text) ) {
            echo sprintf('<i>%s</i>', esc_html($icon_text));
        } elseif ( ! empty($font_awesome_icon) ) {
            echo sprintf('<i class="%s"></i>', esc_attr($font_awesome_icon));
        } else {
            echo '<i></i>';
        }
        ?>
        <div class="pro-bar bar-85 pro-midnight" data-pro-bar-percent="<?php echo esc_attr($bar_percent);?>" data-pro-bar-delay="<?php echo esc_attr($bar_delay); ?>">
            <div class=""><?php echo esc_html($content); ?></div>
        </div>
    </div>
</div>
<?php

    $output = ob_get_clean();
    return apply_filters('upside_lite_toolkit_shortcode_progress', force_balance_tags($output), $atts, $content);
}
