<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Course_Search', 'register_block'));
class Upside_Lite_Toolkit_Widget_Course_Search extends Kopa_Widget {
    public $kpb_group = 'course';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Course_Search'] = new Upside_Lite_Toolkit_Widget_Course_Search();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-course-search-widget';
        $this->widget_description = esc_attr__( 'Display courses search form.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-course-search-widget';
        $this->widget_name        = esc_attr__( '(Upside lite) Course search', 'upside-lite-toolkit' );

        $search_params = upside_lite_get_search_param();       

        $settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Title', 'upside-lite-toolkit')
            ),
            'short_description' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_attr__('Description 1', 'upside-lite-toolkit'),
            ),
            'description' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_attr__('Description 2', 'upside-lite-toolkit'),
            ),
            'button_text' => array(
                'type' => 'text',
                'std' => esc_attr__('Search', 'upside-lite-toolkit'),
                'label' => esc_attr__('Button label', 'upside-lite-toolkit'),
            )
        );

        if ( $search_params ) {

            $settings[ 'seach_title' ] = array(
                'type' => 'caption',
                'label' => esc_attr__( 'Advanced options', 'upside-lite-toolkit' ),
            );

            foreach ( $search_params as $param ) {
                if ( 's' == $param['id'] ) {
                    continue;
                }
                $settings[ $param['id'] ] = array(
                    'type' => 'checkbox',
                    'std' => '1',
                    'label' => 'Search by: ' . $param['backend_title'],
                );
            }
        }

        $this->settings = $settings;

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );
        extract( $instance );
        echo $before_widget;
        ?>

            <?php if ( ! empty($title) && ! empty($short_description) ) : ?>
                <div class="widget-title widget-title-s5 text-center">
                    <span></span>
                    <h2><?php echo esc_html($title); ?></h2>
                    <p><?php echo wp_kses_post($short_description); ?></p>
                </div>
                <?php endif; ?>
            <!-- widget-title -->

            <div class="widget-content">

                <form class="course-form clearfix" action="<?php echo esc_url(trailingslashit(home_url('/'))); ?>" method="get">

                    <div class="row">

                        <?php

                        $search_params = upside_lite_get_search_param();

                        #Get exclude ids field to hide
                        $upside_exclude_arr = array();
                        foreach ( $search_params as $param ) {
                            if ( 's' == $param['id'] ) {
                                continue;
                            }
                            if ( '1' !== $instance[$param['id']] ) {
                               $upside_exclude_arr[] = $param['id'];
                            }
                        }

                        foreach ( $search_params as $param ) {
                            if ( $upside_exclude_arr ) {
                                if ( in_array($param['id'], $upside_exclude_arr) ) {
                                    continue;
                                }
                            }
                            switch ( $param['element-type'] ) {
                                case 'text':
                                    echo '<div class="col-md-3 col-sm-3 col-xs-12">';
                                    echo '<div class="text-block">';
                                    echo sprintf('<input type="text" name="%s" placeholder="%s" />', esc_attr($param['id']), esc_attr($param['title']));
                                    echo '</div>';
                                    echo '</div>';
                                    break;
                                case 'select':
                                    echo '<div class="col-md-3 col-sm-3 col-xs-12">';
                                    echo '<div class="select-block">';
                                    echo sprintf('<select name="%s">', esc_attr($param['id']));
                                    echo sprintf('<option value="">%s</option>', esc_html($param['title']));
                                    if ( 'taxonomy' == $param['data'] ) {
                                        $terms = get_terms( $param['data-source'] );
                                        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                                            foreach ( $terms as $term ) {
                                                echo sprintf('<option value="%s">%s</option>', esc_attr($term->slug), esc_attr($term->name));
                                            }
                                        }
                                    } elseif ( 'metabox' == $param['data'] && isset($param['data-source']) ) {
                                        $post_types = new WP_Query( array(
                                            'post_type' => $param['data-source'],
                                            'post_status'    => array('publish'),
                                            'posts_per_page' => -1,
                                        ) );

                                        if ( $post_types->have_posts() ) {
                                            while ( $post_types->have_posts() ) {
                                                $post_types->the_post();
                                                echo sprintf('<option value="%s">%s</option>', esc_attr(get_the_ID()), esc_attr(get_the_title()));
                                            }
                                        }
                                        wp_reset_postdata();
                                    }
                                    echo '</select>';
                                    echo '<i class="fa fa-sort-desc"></i>';
                                    echo '</div>';
                                    echo '</div>';
                                    break;
                            }

                        }
                        ?>

                    </div>
                    <!-- row -->

                    <input type="hidden" name="type" value="k_course" />
                    <div class="text-center">
                        <input class="course-submit" type="submit" value="<?php echo esc_attr($button_text); ?>">
                    </div>

                </form>

                <?php if ( ! empty($description) ) : ?>
                <p class="text-center"><?php echo wp_kses_post($description); ?></p>
                <?php endif; ?>

            </div>
            <!-- widget-content -->

        <?php
        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }

}
