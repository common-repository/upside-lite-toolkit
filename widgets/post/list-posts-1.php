<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_List_Post_1', 'register_block'));
class Upside_Lite_Toolkit_Widget_List_Post_1 extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_List_Post_1'] = new Upside_Lite_Toolkit_Widget_List_Post_1();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-nothumb-widget';
        $this->widget_description = esc_attr__('Display list posts with "see all posts" link.', 'upside-lite-toolkit');
        $this->widget_id          = 'list-post-with-more-link-widget';
        $this->widget_name        = esc_attr__( '(Upside lite) Posts lits 1', 'upside-lite-toolkit' );
        $setting = upside_lite_toolkit_get_post_widget_args();

        $setting['up_excerpt_length']    = array(
            'type'    => 'text',
            'label'   => esc_attr__( 'Excerpt lengh (E.g: 24):', 'upside-lite-toolkit' ),
            'std'     => '24'
        );

        $setting['more_text']    = array(
            'type'    => 'text',
            'label'   => esc_attr__( '"See all posts" label:', 'upside-lite-toolkit' ),
            'std'     => ''
        );

        $setting['more_link']    = array(
            'type'    => 'text',
            'label'   => esc_attr__( '"See all posts" link:', 'upside-lite-toolkit' ),
            'std'     => ''
        );

        $this->settings = $setting;


        parent::__construct();
    }

    public function widget( $args, $instance ) {
        extract( $args );
        $instance = wp_parse_args((array) $instance, $this->get_default_instance());
        $query_args = upside_lite_toolkit_get_post_widget_query($instance);

        echo $before_widget;
        $this->grid_two_item_no_thumb( $query_args, $instance);
        echo $after_widget;
    }

    public function grid_two_item_no_thumb($query_args, $instance) {
        extract($instance);
        $all_posts = new WP_Query( $query_args ); ?>

        <?php if ( ! empty($title) ) : ?>
        <div class="widget-title widget-title-s2 clearfix">

            <div class="pull-left"><span></span></div>

            <h4 class="pull-left"><?php echo esc_attr($title); ?></h4>

            <?php if ( ! empty($more_text) || ! empty($more_link) ) : ?>
            <span class="see-more pull-right"><a href="<?php echo esc_url( $more_link ); ?>" title="<?php echo esc_attr( $more_text ); ?>"><?php echo esc_html($more_text); ?></a></span>
            <?php endif; ?>

        </div>
        <!-- widget-title-s2	 -->
        <?php endif; ?>

        <div class="widget-content">
            <?php if ( $all_posts->have_posts() ) : ?>

            <div class="row">

                <?php while ( $all_posts->have_posts() ) :
                $all_posts->the_post();
                $post_id = get_the_ID();
                $post_title = get_the_title();
                ?>

                <div class="col-md-6 col-sm-6 col-xs-12">

                    <article class="entry-item clearfix">

                        <div class="entry-date pull-left">
                            <strong><?php echo get_the_date('d', $post_id); ?></strong>
                            <span><?php echo get_the_date('M', $post_id); ?></span>
                        </div>

                        <div class="entry-content">

                            <header class="clearfix">
                                <span class="entry-time pull-left"><?php echo esc_html('At ', 'upside-lite-toolkit'); ?><?php echo get_the_date(get_option('time_format'), $post_id); ?></span>
                                <span class="entry-meta pull-left">&nbsp;/&nbsp;</span>
                                <?php get_template_part( 'template/parts/common/author'); ?>
                            </header>

                            <h5 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($post_title); ?>"><?php echo esc_html($post_title); ?></a></h5>
                            <?php
                            upside_lite_get_excerpt_length($up_excerpt_length);
                            add_filter('excerpt_length', 'upside_lite_toolkit_set_excerpt_length');
                            the_excerpt();
                            remove_filter( 'excerpt_length', 'upside_lite_toolkit_set_excerpt_length' );
                            ?>
                            <?php get_template_part( 'template/parts/common/readmore'); ?>
                        </div>

                    </article>

                </div>
                <!-- col-md-6 -->

                <?php
            endwhile;
                wp_reset_postdata();
                ?>

            </div>
            <!-- row -->

            <?php endif; ?>

        </div>
        <!-- widget-content -->

    <?php
    }
}