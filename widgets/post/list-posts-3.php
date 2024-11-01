<?php
add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_List_Post_3', 'register_widget'));
class Upside_Lite_Toolkit_Widget_List_Post_3 extends Kopa_Widget {

	public $kpb_group = 'post';

    public static function register_widget(){
        register_widget('Upside_Lite_Toolkit_Widget_List_Post_3');
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-article-list-8-widget';
		$this->widget_description = esc_attr__('Display posts list with medium thumbnails.', 'upside-lite-toolkit');
		$this->widget_id          = 'upside-recent-post';
		$this->widget_name        = esc_attr__( '(Upside lite) Posts list 3', 'upside-lite-toolkit' );
		$this->settings 		  = upside_lite_toolkit_get_post_widget_args( esc_attr__('Posts list 3', 'upside-lite-toolkit'), '4' );

		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		ob_start();
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		extract( $instance );
		
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);		
		$query = upside_lite_toolkit_get_post_widget_query($instance);
		$result_set = new WP_Query( $query );
		echo $before_widget;

        if ( ! empty($title) ) : ?>
            <h4 class="widget-title widget-title-s10"><?php echo esc_html($title); ?></h4>
        <?php endif;

		if ( $result_set->have_posts() ) :	?>

                <ul class="clearfix">
                    <?php while($result_set->have_posts() ) :
                        $result_set->the_post();
                        $post_title = get_the_title();
                    ?>

                    <li>
                        <article class="entry-item clearfix">
                            <?php if ( has_post_thumbnail() ) :
                            $image_slug = 'upside-widget-recent-post';
                            ?>
                                <div class="entry-thumb pull-left">
                                    <a href="<?php the_permalink(); ?>" title="<?php echo wp_kses_post($post_title); ?>">
                                        <?php upside_lite_the_post_thumbnail(get_the_ID(), $image_slug, array('class' => 'img-responsive')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content">
                                <h6 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo wp_kses_post($post_title); ?>"><?php echo wp_kses_post($post_title); ?></a></h6>
                                <div class="meta-box clearfix">
                                    <?php get_template_part( 'template/parts/common/author'); ?>
                                    <span class="entry-meta pull-left">&nbsp;/&nbsp;</span>
                                    <?php get_template_part( 'template/parts/common/date'); ?>
                                </div>
                            </div>
                        </article>
                        <!-- entry-item -->
                    </li>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    ?>
                </ul>

			<?php
		endif;
		wp_reset_postdata();
		echo $after_widget;
		$content = ob_get_clean();
		echo $content;		
	}
}