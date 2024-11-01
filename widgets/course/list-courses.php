<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Course_List', 'register_block'));
class Upside_Lite_Toolkit_Widget_Course_List extends Kopa_Widget {
    public $kpb_group = 'course';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Course_List'] = new Upside_Lite_Toolkit_Widget_Course_List();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-masonry-list-2-widget';
        $this->widget_description = esc_attr__( 'Display list of courses.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-course-list-widget';
        $this->widget_name        = esc_attr__( '(Upside lite) Courses list', 'upside-lite-toolkit' );

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
            'description' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_attr__('Description', 'upside-lite-toolkit'),
            ),
            'category' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => esc_attr__('Categories', 'upside-lite-toolkit'),
                "desc" => esc_attr__('Hold Ctrl to choose multiple values', 'upside-lite-toolkit'),
                'options' => $course_options
            ),
            'total_item' => array(
                'type' => 'text',
                'std' => '8',
                'label' => esc_attr__('Number of items', 'upside-lite-toolkit')
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
        );
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );
        extract( $instance );

        echo $before_widget;
        ?>

            <?php if ( ! empty($title) || ! empty($description) ) : ?>

                <div class="widget-title widget-title-s5 text-center">
                    <span></span>
                    <?php if ( ! empty($title) ) : ?>
                        <h2><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                    <?php if ( ! empty($description) ) : ?>
                        <p><?php echo wp_kses_post($description); ?></p>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

    <?php
        $upside_query = array(
            'post_type'      => array('k_course'),
            'posts_per_page' => (int) $total_item,
            'post_status'    => array('publish'),
            'order'          => isset( $order ) ?  $order : 'DESC',
            'orderby'        => isset( $orderby ) ? $orderby : 'date',
        );
        $category_count = count ( $category );
        if ( 1 === $category_count && '' === $category[0] ) {
            $course_cat = array();
        } else {
            $course_cat = $category;
        }

        if ( $course_cat ) {
            $upside_query['tax_query'] = array(
                array(
                    'taxonomy' => 'course-category',
                    'field'    => 'id',
                    'terms'    => $course_cat
                ),
            );
        }
        $upside_results = new WP_Query( $upside_query );
        if ( $upside_results->have_posts() ) : ?>

            <div class="masonry-list-wrapper">

                <ul class="clearfix">
                    <?php
                    while ( $upside_results->have_posts() ) :
                        $upside_results->the_post();
                        ?>
                        <li class="masonry-item">
                            <article class="entry-item hot-item">

                                <?php if ( has_post_thumbnail(get_the_ID()) ) : ?>

                                    <div class="entry-thumb">
                                        <div class="mask"></div>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title();?>">
                                            <?php upside_lite_the_post_thumbnail(get_the_ID(), 'upside-portfolio-relate'); ?>
                                        </a>
                                        <?php
                                            get_template_part( 'inc/post-types/course/parts/rate' );
                                            get_template_part( 'inc/post-types/course/parts/hot' );
                                        ?>
                                    </div>

                                <?php endif;?>

                                <div class="entry-content">
                                    <?php get_template_part( 'inc/post-types/course/parts/teacher' ); ?>
                                    <h6 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>
                                </div>
                            </article>
                        </li>
                        <!-- masonry-item -->

                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>


                </ul>
                <!-- clearfix -->

            </div>
            <!-- masonry-list-wrapper -->

        <?php endif;

        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }

}
