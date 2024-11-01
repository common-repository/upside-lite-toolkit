<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Staff_Carousel', 'register_block'));
class Upside_Lite_Toolkit_Widget_Staff_Carousel extends Kopa_Widget {
    public $kpb_group = 'staff';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Staff_Carousel'] = new Upside_Lite_Toolkit_Widget_Staff_Carousel();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-owl-5-widget';
        $this->widget_description = esc_attr__( 'Show staff with carousel slider.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-member-carousel-widget';
        $this->widget_name        = esc_attr__( '(Upside lite) Staff carousel', 'upside-lite-toolkit' );

        $cbo_departments_options = array( '' => esc_attr__( '-- All --', 'upside-lite-toolkit' ) );

        $terms = get_terms('staff-department');
        if($terms && !is_wp_error($terms)){
            foreach ($terms as $tag) {
                $cbo_departments_options[$tag->slug] = "{$tag->name} ({$tag->count})";
            }
        }

        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Title', 'upside-lite-toolkit')
            ),
            'department' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => esc_attr__('Departments', 'upside-lite-toolkit'),
                'options' => $cbo_departments_options
            ),
            'post_per_page' => array(
                'type' => 'text',
                'std' => '6',
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
        $upside_query = array(
            'post_type'      => array('staff'),
            'posts_per_page' => (int) $post_per_page,
            'post_status'    => array('publish'),
            'order'          => isset( $order ) ?  $order : 'DESC',
            'orderby'        => isset( $orderby ) ? $orderby : 'date',
        );

        $department_count = count ( $department );
        if ( 1 !== $department_count || '' !== $department[0] ) {
            $upside_query['tax_query'] = array(
                array(
                    'taxonomy' => 'staff-department',
                    'field'    => 'slug',
                    'terms'    => $department
                ),
            );
        }

        $upside_results = new WP_Query( $upside_query );
        echo $before_widget;
        ?>

            <?php if ( ! empty($title) ) : ?>
                <h4 class="widget-title widget-title-s9"><?php echo esc_html($title); ?></h4>
            <?php endif; ?>

            <div class="widget-content">
                <?php if ( $upside_results->have_posts() ) : ?>
                    <div class="owl-carousel owl-carousel-5">

                        <?php while ( $upside_results->have_posts() ) :
                            $upside_results->the_post();
                            $position = get_post_meta(get_the_ID(), 'utp-member-position', true);
                            ?>

                            <div class="item">

                                <article class="entry-item">
                                    <?php
                                    if ( has_post_thumbnail(get_the_ID()) ) : ?>
                                        <div class="entry-thumb">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php upside_lite_the_post_thumbnail(get_the_ID(), 'upside-member-list-255-255'); ?></a>
                                        </div>
                                        <?php endif; ?>

                                    <div class="entry-content">
                                        <header>
                                            <h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                            <?php if ( ! empty($position) ) : ?>
                                            <span><?php echo esc_html($position); ?></span>
                                            <?php endif; ?>
                                        </header>
                                        <?php the_excerpt(); ?>

                                        <?php
                                        $utp_socials = upside_lite_get_profile_socials();
                                        $utp_socials = apply_filters('utp_member_social_custom', $utp_socials);
                                        $utp_socials_values = array();
                                        if ( $utp_socials ) {
                                            foreach ( $utp_socials as $k => $v ) {
                                                $value = get_post_meta(get_the_ID(), 'utp-k-member-social-'.$k, true);
                                                if ( ! empty($value) ) {
                                                    $utp_socials_values[] = sprintf('<li><a href="%s" class="%s" rel="nofollow"></a></li>', esc_url($value), esc_attr($v['class']));
                                                }
                                            }
                                        }
                                        if ( $utp_socials_values ) :
                                            ?>
                                            <ul class="social-links clearfix">
                                                <?php echo join('', $utp_socials_values); ?>
                                            </ul>
                                            <?php endif; ?>
                                    </div>
                                </article>

                            </div>

                        <?php endwhile; wp_reset_postdata(); ?>

                    </div>
                    <!-- owl-carousel -->
                <?php endif; ?>
            </div>

        <?php
        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }

}
