<?php
add_filter('kopa_page_bulder_set_classname', 'upside_lite_toolkit_featured_content_dynamic_param', 10, 2);
function upside_lite_toolkit_featured_content_dynamic_param($option_class, $widget_data){
        if ( 'kopa-rounded-thumb-widget' == $option_class && isset($widget_data['element_layout']) ) {
            switch ( $widget_data['element_layout'] ) {
                case 'default_image':
                    $option_class = 'kopa-rounded-thumb-2-widget';
                    break;
            }
        }
    return $option_class;
}

add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Featured_Content', 'register_block'));
class Upside_Lite_Toolkit_Widget_Featured_Content extends Kopa_Widget {
    public $kpb_group = 'miscellaneous';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Featured_Content'] = new Upside_Lite_Toolkit_Widget_Featured_Content();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-rounded-thumb-widget';
        $this->widget_description = esc_attr__( 'Show a text block, image and button.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-featured-content';
        $this->widget_name        = esc_attr__( '(Upside lite) Featured Content', 'upside-lite-toolkit' );

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
            'image'    => array(
                'type'  => 'upload',
                'std'   => '',
                'label' =>  esc_attr__( 'Image:', 'upside-lite-toolkit')
            ),
            'element_layout'    => array(
                'type'    => 'select',
                'label'   => esc_attr__( 'Image display:', 'upside-lite-toolkit' ),
                'std'     => 'position_image',
                'options' => array(
                    'position_image' => esc_attr__( 'Image overlaps the border', 'upside-lite-toolkit' ),
                    'default_image' => esc_attr__( 'Image is inside the row', 'upside-lite-toolkit' ),
                )
            )

    );
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );
        extract( $instance );

        echo $before_widget;

        switch ( $instance['element_layout'] ) {
            case 'position_image':
                $this->position_image( $instance );
                break;
            case 'default_image':
                $this->default_image( $instance );
                break;
        }

        echo $after_widget;
    }

    public function position_image( $instance ){
        extract($instance);
        ?>

            <div class="widget-content">

                <article class="entry-item clearfix">

                    <?php
                    if ( ! empty($image) ) :?>
                        <div class="entry-thumb pull-right">
                            <a href="<?php echo esc_url($btn_link); ?>" title="<?php echo esc_attr($title); ?>">
                                <img src="<?php echo esc_url($image); ?>" alt="">
                            </a>
                        </div>
                        <!-- entry-thumb -->
                    <?php endif; ?>

                    <div class="entry-content">

                        <?php if ( ! empty($title) ) : ?>
                        <h2 class="entry-title"><a href="<?php echo esc_url($btn_link); ?>" title="<?php echo esc_attr($title); ?>"><?php echo wp_kses_post($title); ?></a></h2>
                        <?php endif; ?>

                        <?php if ( ! empty($description) ) : ?>
                        <p><?php echo wp_kses_post($description); ?></p>
                        <?php endif; ?>

                        <?php if ( ! empty($btn_label) ) : ?>
                        <a class="kopa-button blue-button medium-button" href="<?php echo esc_url($btn_link); ?>"><?php echo esc_html($btn_label); ?></a>
                        <?php endif; ?>

                    </div>
                    <!-- entry-content -->

                </article>
                <!-- entry-item -->

            </div>
            <!-- widget-content -->

        <?php

    }

    public function default_image( $instance ){
        extract($instance);
        ?>

        <div class="widget-content">

            <article class="entry-item clearfix">

                <?php if ( ! empty($image) ) : ?>
                    <div class="entry-thumb pull-right">
                        <a href="<?php echo esc_url($btn_link); ?>" title="<?php echo esc_attr($title); ?>"><img src="<?php echo esc_url($image); ?>" alt=""></a>
                    </div>
                    <!-- entry-thumb -->
                <?php endif; ?>

                <div class="entry-content">

                    <?php if ( ! empty($title) ) : ?>
                        <h2 class="entry-title"><a href="<?php echo esc_url($btn_link); ?>" title="<?php echo wp_kses_post($title); ?>"><?php echo wp_kses_post($title); ?></a></h2>
                    <?php endif; ?>

                    <?php if ( ! empty($description) ) : ?>
                        <p><?php echo wp_kses_post( $description ); ?></p>
                    <?php endif; ?>

                    <?php if ( ! empty($btn_label) ) : ?>
                        <a class="kopa-button blue-button medium-button" href="<?php echo esc_url($btn_link); ?>"><?php echo esc_html($btn_label); ?></a>
                    <?php endif; ?>

                </div>
                <!-- entry-content -->

            </article>
            <!-- entry-item -->

        </div>
        <!-- widget-content -->

        <?php
    }

}
