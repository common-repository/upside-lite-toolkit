<?php
add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_Social_Links', 'register_widget'));
class Upside_Lite_Toolkit_Widget_Social_Links extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget(){
		register_widget('Upside_Lite_Toolkit_Widget_Social_Links');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-social-link-widget';
		$this->widget_description = esc_attr__( 'Display your social links that you entered in Appearance > Customize > Theme Options.', 'upside-lite-toolkit' );
		$this->widget_id          = 'upside-social-links';
		$this->widget_name        = esc_attr__( '(Upside lite) Social Links', 'upside-lite-toolkit' );
		
		$this->settings 		  = array(
            'title' => array(
                'type'  => 'text',
                'std'   => esc_attr__('Follow us', 'upside-lite-toolkit'),
                'label' => esc_attr__('Title:', 'upside-lite-toolkit')
            ),
	    );

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		extract( $instance );
        echo $before_widget;
		?>

            <?php if ( ! empty($title) ) : ?>
                <h4 class="widget-title"><?php echo esc_html($title); ?></h4>
            <?php endif; ?>

            <?php
                $selected_socials = upside_lite_get_selected_follow_social();
                if ( $selected_socials ) : ?>

                <ul class="social-nav model-2 clearfix">
                    <?php
                        foreach ( $selected_socials as $k => $v ) {
                            printf('<li><a href="%s" target="_blank" title="%s" rel="nofollow" class="%s"><i class="%s"></i></a></li>', esc_url( $v['url'] ), esc_attr__( 'Follow us via ' ) . esc_attr( $v['title'] ), esc_attr( $v['id'] ),esc_attr( $v['icon'] ));
                        }
                    ?>
                </ul>

            <?php
                endif;
            $content = ob_get_clean();
            echo $content;
		echo $after_widget;
	}
}