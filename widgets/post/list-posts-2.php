<?php
add_filter('kopa_page_bulder_set_classname', 'upside_lite_toolkit_list_post_title_dynamic_param', 10, 2);
function upside_lite_toolkit_list_post_title_dynamic_param($option_class, $widget_data){
    if ( 'kopa-article-list-4-widget' === $option_class && isset($widget_data['up_layout']) ) {
        switch ( $widget_data['up_layout'] ) {
            case 'grid_two_posts_small_thumbnail':
                $option_class = 'kopa-article-list-4-widget';
                break;
            case 'list_posts_small_thumbnail':
                $option_class = 'kopa-article-list-5-widget';
                break;
        }
    }
    return $option_class;
}

add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_List_Post_2', 'register_block'));
class Upside_Lite_Toolkit_Widget_List_Post_2 extends Kopa_Widget {

	public $kpb_group = 'post';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_List_Post_2'] = new Upside_Lite_Toolkit_Widget_List_Post_2();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-article-list-4-widget';
		$this->widget_description = esc_attr__('Display posts list, with small thumbnails.', 'upside-lite-toolkit');
		$this->widget_id          = 'list-post-with-title-widget';
		$this->widget_name        = esc_attr__( '(Upside lite) Post list 2', 'upside-lite-toolkit' );
        $setting = upside_lite_toolkit_get_post_widget_args();

        $setting['up_layout']    = array(
            'type'    => 'select',
            'label'   => esc_attr__( 'Layout:', 'upside-lite-toolkit' ),
            'std'     => 'grid_two_posts_small_thumbnail',
            'options' => array(
                'grid_two_posts_small_thumbnail' => esc_attr__( 'Grid two columns, small thumbnail', 'upside-lite-toolkit' ),
                'list_posts_small_thumbnail' => esc_attr__( ' Posts list small thumbnail', 'upside-lite-toolkit' ),
            )
        );

        $setting['title_icon']    = array(
            'type'    => 'select',
            'label'   => esc_attr__( 'Display icon in the title:', 'upside-lite-toolkit' ),
            'std'     => 'yes',
            'options' => array(
                'yes' => esc_attr__( 'Yes', 'upside-lite-toolkit' ),
                'no' => esc_attr__( 'No', 'upside-lite-toolkit' ),
            )
        );

		$this->settings = $setting;


		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
        $query_args = upside_lite_toolkit_get_post_widget_query($instance);
        echo $before_widget;
        switch ( $instance['up_layout'] ) {
            case 'grid_two_posts_small_thumbnail':
                $this->grid_two_posts_small_thumbnail( $query_args, $instance);
                break;
            case 'list_posts_small_thumbnail':
                $this->list_posts_small_thumbnail( $query_args, $instance);
                break;
        }
        echo $after_widget;
	}

    public function grid_two_posts_small_thumbnail($query_args, $instance) {
        extract($instance);
        $all_posts = new WP_Query( $query_args );

            if ( ! empty($title) ) : ?>
                <div class="widget-title widget-title-s8 clearfix">
                    <?php if ( 'yes' == $title_icon ) : ?>
                        <i class="fa fa-newspaper-o pull-left"></i>
                    <?php endif; ?>
                    <h4 class="pull-left"><?php echo esc_html($title); ?></h4>
                </div>
                <!-- widget-title -->
            <?php endif;

            if ( $all_posts->have_posts() ) : ?>
                <ul class="clearfix">
                    <?php
                    while ( $all_posts->have_posts() ) {
                        $all_posts->the_post();

                        $post_author_name = get_the_author_meta( 'display_name' );
                        $post_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
                        $no_thumb_class = 'no_thumb';
                        ?>

                            <li>
                                <article class="entry-item clearfix">
                                    <?php if ( has_post_thumbnail() ) :
                                        $no_thumb_class = '';
                                    ?>
                                        <div class="entry-thumb pull-left">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php
                                                    upside_lite_the_post_thumbnail( get_the_ID(), 'upside-list-post-140-110' );
                                                ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="entry-content <?php echo esc_attr($no_thumb_class); ?>">
                                        <span class="entry-author"><a href="<?php echo esc_url($post_author_link); ?>" class="title-color-blue"><?php echo esc_html($post_author_name); ?></a></span>
                                        <h6 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>
                                    </div>
                                </article>
                            </li>

                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            <?php endif;
    }

    public function list_posts_small_thumbnail($query_args, $instance) {
        extract($instance);
        $all_posts = new WP_Query( $query_args );

        if ( ! empty($title) ) : ?>
            <div class="widget-title widget-title-s8 clearfix">
                <?php if ( 'yes' == $title_icon ) : ?>
                    <i class="fa fa-newspaper-o pull-left"></i>
                <?php endif; ?>
                <h4 class="pull-left"><?php echo esc_html($title); ?></h4>
            </div>
            <!-- widget-title -->
        <?php endif; ?>

        <?php if ( $all_posts->have_posts() ) : ?>

            <div class="widget-content">
                <ul>
                    <?php
                    while ( $all_posts->have_posts() ) {
                        $all_posts->the_post();
                        ?>

                        <li>
                            <article class="entry-item clearfix">
                                <?php if ( has_post_thumbnail() ) : ?>
                                <div class="entry-thumb pull-left">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php
                                            upside_lite_the_post_thumbnail( get_the_ID(), 'upside-list-post-160-100' );
                                        ?>
                                    </a>
                                </div>
                                <?php endif; ?>

                                <div class="entry-content">

                                    <header class="clearfix">
                                        <span class="entry-time pull-left"><?php echo esc_html('At ', 'upside-lite-toolkit'); ?><?php echo get_the_date(get_option('time_format'), get_the_ID()); ?></span>
                                        <span class="entry-meta pull-left">&nbsp;/&nbsp;</span>
                                        <?php get_template_part( 'template/parts/common/author'); ?>
                                    </header>

                                    <h5 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
                                    <?php
                                    if ( ! isset($excerpt_length) ) {
                                        $excerpt_length = 55;
                                    }
                                    upside_lite_get_excerpt_length($excerpt_length);
                                    add_filter('excerpt_length', 'upside_lite_toolkit_set_excerpt_length');
                                    the_excerpt();
                                    remove_filter( 'excerpt_length', 'upside_lite_toolkit_set_excerpt_length' );
                                    ?>
                                </div>
                            </article>
                        </li>


                        <?php
                    }
                    wp_reset_postdata();
                    ?>

                </ul>
            </div>
            <!-- widget-content -->

        <?php endif;

    }
}