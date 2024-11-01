<?php
add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_Owl_Slider', 'register_widget'));
class Upside_Lite_Toolkit_Widget_Owl_Slider extends Kopa_Widget {

	public $kpb_group = 'slider';

    public static function register_widget(){
        register_widget('Upside_Lite_Toolkit_Widget_Owl_Slider');
    }

	public function __construct() {
		$this->widget_cssclass    = 'home-slider home-slider-2';
		$this->widget_description = esc_attr__('Display Owl carousel slides.', 'upside-lite-toolkit');
		$this->widget_id          = 'upside-lite-slider-two';
		$this->widget_name        = esc_attr__( '(Upside lite) Owl carousel Slider', 'upside-lite-toolkit' );

        $cbo_tags_options = array( '' => __( '-- All --', 'upside-lite-toolkit' ) );

        $tags = get_terms('slide-tag');
        if($tags && !is_wp_error($tags)){
            foreach ($tags as $tag) {
                $cbo_tags_options[$tag->slug] = "{$tag->name} ({$tag->count})";
            }
        }

        $setting['posts_per_page']    = array(
            'type'    => 'text',
            'label'   => esc_attr__( 'Number of slide:', 'upside-lite-toolkit' ),
            'std'     => '3'
        );

        $setting['tags']    = array(
            'type'    => 'select',
            'label'   => esc_attr__( 'Slider tags:', 'upside-lite-toolkit' ),
            'std'     => '',
            'options' => $cbo_tags_options
        );

        $setting['button_style']    = array(
            'type'    => 'select',
            'label'   => esc_attr__( 'Button color:', 'upside-lite-toolkit' ),
            'std'     => 'pink-button',
            'options' => array(
                'pink-button' => esc_attr__('Pink', 'upside-lite-toolkit'),
                'blue-button' => esc_attr__('Blue', 'upside-lite-toolkit')
            )
        );

        $setting['slide_speed']    = array(
            'type'    => 'text',
            'label'   => esc_attr__( 'Speed:', 'upside-lite-toolkit' ),
            'std'     => '600'
        );

        $setting['slide_auto']    = array(
            'type'    => 'select',
            'label'   => esc_attr__( 'Auto play:', 'upside-lite-toolkit' ),
            'std'     => 'no',
            'options' => array(
                'no' => esc_attr__('No', 'upside-lite-toolkit'),
                'yes' => esc_attr__('Yes', 'upside-lite-toolkit')
            )
        );

        $this->settings = $setting;

		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		ob_start();
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		extract( $instance );
        $query = array(
            'post_type'      => array('slide'),
            'posts_per_page' => (int) $posts_per_page,
            'post_status'    => array('publish')
        );

        if(!empty($tags)){
            $query['tax_query'] = array(
                array(
                    'taxonomy' => 'slide-tag',
                    'field'    => 'slug',
                    'terms'    => $tags
                ),
            );
        }

        $result_set = new WP_Query( $query );
		echo $before_widget;

        if ( $result_set->have_posts() ) :
            $syn1 = 'sync1-'.wp_generate_password(8, false);
            ?>

        <div class="home-slider home-slider-2">

            <div id="<?php echo esc_attr($syn1);?>" class="owl-carousel owl-carousel-2 up-slide2" data-id="<?php echo esc_attr($syn1);?>">

                <?php
                while ( $result_set->have_posts() ) {
                    $result_set->the_post();
                    $post_title = get_the_title();
                    $post_sumary = get_post_meta(get_the_ID(), 'upside-lite-slide-description', true);
                    $post_button_text = get_post_meta(get_the_ID(), 'upside-lite-slide-btn-text', true);
                    $post_button_link = get_post_meta(get_the_ID(), 'upside-lite-slide-website', true);

                    ?>

                    <div class="item">

                        <article class="entry-item">
                            <div class="entry-thumb">
                                <?php if ( has_post_thumbnail()) : ?>
                                    <?php upside_lite_the_post_thumbnail(get_the_ID(), 'upside-slide-one-1366-602' ); ?>
                                <?php else: ?>
                                    <img src="//placehold.it/1366x602" alt="<?php echo wp_kses_post($post_title); ?>" />
                                <?php endif; ?>
                                <div class="mask"></div>
                            </div>

                            <div class="entry-content text-center">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="entry-title">
                                                <h2><a href="<?php echo esc_url($post_button_link); ?>" title="<?php echo wp_kses_post($post_title);?>"><?php echo wp_kses_post($post_title); ?></a></h2>
                                                <p><span></span></p>
                                            </div>

                                            <?php if ( ! empty($post_sumary)) : ?>
                                                <p class="entry-excerpt"><?php echo wp_kses_post($post_sumary); ?></p>
                                            <?php endif; ?>

                                            <?php if ( ! empty($post_button_text) && ! empty($post_button_link) ) :
                                            ?>
                                                <a href="<?php echo esc_url($post_button_link); ?>" title="<?php echo esc_attr($post_button_text); ?>" class="kopa-button <?php echo esc_attr($button_style);?> medium-button"><?php echo esc_html($post_button_text); ?></a>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <!-- entry-item -->

                    </div>
                    <!-- item -->

                    <?php
                }
                wp_reset_postdata();
                ?>

            </div>
            <!-- owl-carousel-2 -->

            <div class="loading">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- loading -->

        </div>
        <?php
        endif;

		echo $after_widget;
		$content = ob_get_clean();
		echo $content;		
	}
}