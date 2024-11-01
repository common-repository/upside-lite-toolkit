<?php
#SHORTCODE FOR PAGE COURSE CATEGORY & CONTACT PAGE
add_shortcode( 'upside_contact_form_7', 'upside_lite_toolkit_contact_form_7_content' );

function upside_lite_toolkit_contact_form_7_content($atts, $content = null) {
    extract( shortcode_atts( array(
        'u_title' => '',
        'u_description' => ''
    ), $atts ) );

    ob_start();
    ?>

<div class="widget kopa-course-comment-widget">
    <?php if ( ! empty($u_title) || ! empty($u_description) ) : ?>
        <div class="widget-title widget-title-s5 text-center">
            <span></span><?php if ( ! empty($u_title) ) : ?><h2><?php echo esc_html($u_title); ?></h2><?php endif; ?>
            <?php if ( ! empty($u_description) ) : ?><p><?php echo wp_kses_post($u_description)?></p><?php endif; ?></div>
    <?php endif; ?>
    <!-- widget-title -->
    <div class="widget-content">

        <div id="respond-<?php echo wp_generate_password( 8, false ); ?>" class="respond">
            <?php
            echo do_shortcode($content);
            ?>
        </div>
        <!-- respond -->

    </div>
    <!-- widget-content -->

</div>

<?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}