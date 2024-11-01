<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Course_Tab', 'register_block'));
class Upside_Lite_Toolkit_Widget_Course_Tab extends Kopa_Widget {
    public $kpb_group = 'course';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Course_Tab'] = new Upside_Lite_Toolkit_Widget_Course_Tab();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-tab-1-widget';
        $this->widget_description = esc_attr__( 'Display the courses in tabs. Each tab displays one course category.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-course-tab-widget';
        $this->widget_name        = esc_attr__( '(Upside lite) Course tabs', 'upside-lite-toolkit' );

        $couse_terms = get_terms( 'course-category', array(
            'hide_empty' => false,
        ) );
        $course_options = array( '' => esc_attr__( '---- All ----', 'upside-lite-toolkit' ) );
        if ( $couse_terms ) {
            foreach ( $couse_terms as $term ) {
                $course_options[ $term->term_id ] = $term->name;
            }
        }

        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Title', 'upside-lite-toolkit')
            ),
            'category' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => esc_attr__('Categories', 'upside-lite-toolkit'),
                "desc" => esc_attr__('Hold Ctrl to choose multiple values', 'upside-lite-toolkit'),
                'options' => $course_options
            ),
            'category_limit' => array(
                'type' => 'text',
                'std' => '3',
                'label' => esc_attr__('Number of courses in each category', 'upside-lite-toolkit')
            ),
            'order' => array(
                'type'  => 'select',
                'std'   => 'DESC',
                'label' => esc_attr__( 'Order:', 'upside-lite-toolkit' ),
                'options' => array(
                    'ASC'  => esc_attr__( 'ASC', 'upside-lite-toolkit' ),
                    'DESC' => esc_attr__( 'DESC', 'upside-lite-toolkit' ),
                ),
            ),
            'orderby' => array(
                'type'  => 'select',
                'std'   => 'date',
                'label' => esc_attr__( 'Ordered by:', 'upside-lite-toolkit' ),
                'options' => array(
                    'date'          => esc_attr__( 'Date', 'upside-lite-toolkit' ),
                    'rand'          => esc_attr__( 'Random', 'upside-lite-toolkit' ),
                    'comment_count' => esc_attr__( 'Number of comments', 'upside-lite-toolkit' ),
                    'ID' => esc_attr__( 'ID', 'upside-lite-toolkit' ),
                    'title' => esc_attr__( 'Title', 'upside-lite-toolkit' ),
                ),
            ),
            'show_des' => array(
                'type' => 'checkbox',
                'std' => '1',
                'label' => esc_attr__( 'Show description of course category', 'upside-lite-toolkit' ),
            )

        );
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );
        extract( $instance );

        echo $before_widget;

        if ( ! empty($title) ) : ?>
            <div class="widget-title widget-title-s8 clearfix">

                <i class="fa fa-newspaper-o pull-left"></i>

                <h4 class="pull-left"><?php echo esc_html($title); ?></h4>

            </div>
            <!-- widget-title -->
        <?php endif;

        $category_count = count ( $category );
        if ( 1 === $category_count && '' === $category[0] ) {
            $course_cat = array();
        } else {
            $course_cat = $category;
        }

        if ( $course_cat ) {
            $upside_unique_id = wp_generate_password( 8, false );
        ?>

            <div class="kopa-tab-container-1">

                <ul class="nav nav-tabs kopa-tabs-1">
                    <?php
                    $count = 0;
                    foreach ( $course_cat as $slug ) {
                        $upside_cat_object = get_term_by('id', $slug, 'course-category');
                        if ( $upside_cat_object ) :
                            $li_class = '';
                            $li_id = 'tab1-'.$upside_cat_object->slug.'-'.$upside_unique_id;
                            if ( 0 == $count ) {
                                $li_class = 'active';
                                $count++;
                            }
                            ?>
                            <li class="<?php echo esc_attr($li_class); ?>"><a href="#<?php echo esc_attr($li_id); ?>" data-toggle="tab"><?php echo esc_html($upside_cat_object->name); ?></a></li>

                            <?php
                        endif;
                    }
                    ?>
                </ul>
                <!-- nav-tabs -->

                <div class="tab-content">
                    <?php
                    $count2 = 1;
                    foreach ( $course_cat as $slug ) {
                        $upside_cat_object = get_term_by('id', $slug, 'course-category');
                        if ( $upside_cat_object ) :
                            $tab_class = 'tab-pane';
                            $tab_id = 'tab1-'.$upside_cat_object->slug.'-'.$upside_unique_id;
                            if ( $count2 ) {
                                $tab_class .= ' active';
                                $count2 = 0;
                            }
                            ?>

                            <div class="<?php echo esc_attr($tab_class); ?>" id="<?php echo esc_attr($tab_id); ?>">
                                <?php if ( '' !== $upside_cat_object->description && 1 == $show_des ) : ?>
								    <p><?php echo esc_textarea($upside_cat_object->description); ?></p>
                                <?php endif; ?>

                                <?php
                                $upside_query = array(
                                    'post_type'      => array('k_course'),
                                    'posts_per_page' => (int) $category_limit,
                                    'post_status'    => array('publish'),
                                    'order'          => isset( $order ) ?  $order : 'DESC',
                                    'orderby'        => isset( $orderby ) ? $orderby : 'date',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'course-category',
                                            'field'    => 'id',
                                            'terms'    => $slug
                                        )
                                    )
                                );
                                $upside_results = new WP_Query( $upside_query );
                                if ( $upside_results->have_posts() ) :
                                    ?>

                                    

                                    <ul class="toggle-view">
                                        <?php
                                        while ( $upside_results->have_posts() ) {
                                            $upside_results->the_post();
                                            ?>
                                            <li class="clearfix">
                                                <h6><a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title(); ?></a></h6>
                                                <span class="fa fa-plus"></span>
                                                <div class="clear"></div>
                                            </li>
                                            <?php
                                        }
                                        wp_reset_postdata();
                                        ?>

                                    </ul><!--end:toggle-view-->

                                    <?php endif; ?>
                            </div>
                            <!-- tab-panel -->
                            <?php
                        endif;
                    }

                    ?>

                </div>
                <!-- tab-content -->

            </div>
            <!-- kopa-tab-container-1 -->

            <?php
        }

        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }

}
