<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Featured_Content_Simple', 'register_block'));
class Upside_Lite_Toolkit_Widget_Featured_Content_Simple extends Kopa_Widget {
    public $kpb_group = 'miscellaneous';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Featured_Content_Simple'] = new Upside_Lite_Toolkit_Widget_Featured_Content_Simple();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'widget_text upside_lite_featured_content_simple';
        $this->widget_description = esc_attr__( 'Show a text block with title and a button.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-featured-content-simple';
        $this->widget_name        = esc_attr__( '(Upside lite) Simple Featured Content', 'upside-lite-toolkit' );

        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Title', 'upside-lite-toolkit')
            ),
            'content' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_attr__('Description', 'upside-lite-toolkit'),
            ),
            'btn_label' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Button label', 'upside-lite-toolkit'),
            ),
            'btn_link' => array(
                'type'    => 'text',
                'std' => '',
                'label' => esc_attr__( 'Button link', 'upside-lite-toolkit' )
            ),
        );
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );
        extract( $instance );

        echo $before_widget;
        ?>

        <?php if ( ! empty($title) ) : ?>
            <h4><?php echo wp_kses_post($title); ?></h4>
        <?php endif; ?>

        <?php if ( ! empty($content) ) : ?>
            <p><?php echo wp_kses_post($content); ?></p>
        <?php endif; ?>

        <?php if ( ! empty($btn_label) || ! empty($btn_link) ) : ?>
            <a class="kopa-button blue-button medium-button" href="<?php echo esc_url($btn_link); ?>" title="<?php echo esc_attr($btn_label); ?>"><?php echo esc_html($btn_label); ?></a>
        <?php endif;

        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }

}
