<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Introduce', 'register_block'));
class Upside_Lite_Toolkit_Widget_Introduce extends Kopa_Widget {
    public $kpb_group = 'miscellaneous';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Introduce'] = new Upside_Lite_Toolkit_Widget_Introduce();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-intro-widget';
        $this->widget_description = esc_attr__( 'Show introduction with 2 buttons. This is designed for the place of slider at the home page.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-intro-widget';
        $this->widget_name        = esc_attr__( '(Upside lite) Introduction', 'upside-lite-toolkit' );

        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Title', 'upside-lite-toolkit')
            ),
            'description' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_attr__('Description', 'upside-lite-toolkit'),
            ),
            'btn1_label' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Button 1 label', 'upside-lite-toolkit'),
            ),
            'btn1_link' => array(
                'type'    => 'text',
                'std' => '',
                'label' => esc_attr__( 'Button 1 link', 'upside-lite-toolkit' )
            ),
            'btn2_label' => array(
                'type'    => 'text',
                'std' => '',
                'label' => esc_attr__( 'Button 2 label', 'upside-lite-toolkit' )
            ),
            'btn2_link' => array(
                'type'    => 'text',
                'std' => '',
                'label' => esc_attr__( 'Button 2 link', 'upside-lite-toolkit' )
            ),
            'scroll_label' => array(
                'type'    => 'text',
                'std' => '',
                'label' => esc_attr__( 'Scroll down label', 'upside-lite-toolkit' )
            ),
            'scroll_item_id' => array(
                'type'    => 'text',
                'std' => '',
                'label' => esc_attr__( 'Scroll to item ID', 'upside-lite-toolkit' ),
                "desc" => esc_attr__("Enter the ID of HTML elements which you would like to scroll to.", 'upside-lite-toolkit'),
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
                <div class="widget-header s1">
                    <h4 class="widget-title widget-title-s13"><?php echo esc_html($title); ?></h4>
                    <div class="kopa-lb">
                        <span></span>
                    </div>
                </div>
                <?php endif; ?>

            <div class="widget-content">

                <?php if ( ! empty($description) ) : ?>
                <h5><?php echo wp_kses_post($description); ?></h5>
                <?php endif; ?>

                <?php if ( ! empty($btn1_label) || ! empty($btn2_label) ) : ?>
                <ul class="btn-intro clearfix">
                    <?php if ( ! empty($btn1_label) ) : ?>
                    <li><a href="<?php echo esc_url($btn1_link); ?>" title="<?php echo esc_attr($btn1_label); ?>"><?php echo esc_html($btn1_label); ?></a></li>
                    <?php endif; ?>
                    <?php if ( ! empty($btn2_label) ) : ?>
                    <li><a href="<?php echo esc_url($btn2_link); ?>" title="<?php echo esc_attr($btn2_label); ?>"><?php echo esc_html($btn2_label); ?></a></li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>

                <?php if ( ! empty($scroll_label) ) :
                $scroll_element = 'kopa-page-footer';
                if ( ! empty($scroll_item_id) ) {
                    $scroll_element = $scroll_item_id;
                }
                ?>
                <a class="it-scroll-down" href="#<?php echo esc_attr($scroll_element);?>">
                    <p><?php echo esc_html($scroll_label); ?></p>
                    <span class="fa fa-angle-down"></span>
                </a>
                <?php endif; ?>

            </div>

        <?php
        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }

}
