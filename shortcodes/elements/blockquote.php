<?php
add_shortcode('upside_blockquote', 'upside_lite_toolkit_shortcode_blockquote');
function upside_lite_toolkit_shortcode_blockquote($atts, $content = null) {
    ob_start();
    extract(shortcode_atts(array(
        'title' => '',
        'job' => ''
    ), $atts));
    $output = NULL;

    if (!empty($content)) {
        ?>
            <blockquote class="kopa-blockquote-1">
                <?php if ( ! empty($content) ) : ?>
                    <p class="clearfix"><i class="fa fa-quote-left"></i><?php echo esc_html($content); ?></p>
                    <?php if ( isset($title) && ! empty($title) ) : ?>
                        <h4><?php echo esc_html($title); ?></h4>
                    <?php endif; ?>
                    <?php if ( isset($job) && ! empty($job) ) : ?>
                        <span><?php echo esc_html($job); ?></span>
                    <?php endif; ?>

                <?php endif; ?>
            </blockquote>
        <?php
    }
    $output = ob_get_clean();
    return apply_filters('upside_lite_toolkit_shortcode_blockquote', force_balance_tags($output), $atts, $content);
}
