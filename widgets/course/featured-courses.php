<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Featured_Course', 'register_block'));
class Upside_Lite_Toolkit_Widget_Featured_Course extends Kopa_Widget {
    public $kpb_group = 'course';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Featured_Course'] = new Upside_Lite_Toolkit_Widget_Featured_Course();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-ads-2-widget';
        $this->widget_description = esc_attr__( 'Display list of featured courses.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-course-featured-widget';
        $this->widget_name        = esc_attr__( '(Upside lite) Featured courses', 'upside-lite-toolkit' );

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
            'total_item' => array(
                'type' => 'text',
                'std' => '8',
                'label' => esc_attr__('Number of items', 'upside-lite-toolkit')
            ),

        );
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );
        extract( $instance );

        echo $before_widget;

        if ( ! empty($title) || ! empty($description) ) : ?>
            <div class="widget-title widget-title-s5 text-center">
                <span></span>
                <?php if ( ! empty($title) ) : ?>
                <h2><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ( ! empty($description) ) : ?>
                <p><?php echo esc_textarea($description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif;

        $upside_query = array(
            'post_type'      => array('k_course'),
            'posts_per_page' => (int) $total_item,
            'post_status'    => array('publish'),
            'meta_query' => array(
                array(
                    'key'     => 'utp-course-is-featured',
                    'value'   => '1',
                    'compare' => '=',
                ),
            ),
        );

        $upside_results = new WP_Query( $upside_query );
            if ( $upside_results->have_posts() ) :
                ?>

                <ul class="clearfix">
                    <?php
                    while ( $upside_results->have_posts() ) {
                        $upside_results->the_post();
                        ?>
                        <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'upside-course-thumb-350-161');
                            } else {
                                upside_lite_toolkit_get_default_image('upside-course-thumb-350-161');
                            }
                            ?>
                        </a></li>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </ul>

            <?php
            endif;
        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }

}
