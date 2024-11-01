<?php
add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_Advertisement', 'register_widget'));
class Upside_Lite_Toolkit_Widget_Advertisement extends Kopa_Widget {

	public $kpb_group = 'Call to action';

	public static function register_widget(){
		register_widget('Upside_Lite_Toolkit_Widget_Advertisement');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-ads-widget-1';
		$this->widget_description = esc_attr__( 'Display a banner with custom link.', 'upside-lite-toolkit' );
		$this->widget_id          = 'upside_advertisement';
		$this->widget_name        = esc_attr__( '(Upside lite) Advertisement', 'upside-lite-toolkit' );
		
		$this->settings           = array(			
			'banner'    => array(
				'type'  => 'upload',
				'std'   => '',
				'label' =>  esc_attr__( 'Banner:', 'upside-lite-toolkit')
			),
			'link_to'  => array(
				'type'  => 'text',
				'std'   => '#',
				'label' => esc_attr__( 'Link to:', 'upside-lite-toolkit')
			));


		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		extract( $instance );
		echo $before_widget;
		?>
            <a href="<?php echo esc_url($link_to); ?>" title="">
                <img src="<?php echo esc_url($banner); ?>"  alt="">
            </a>
		<?php
		$content = ob_get_clean();
		echo $content;
		echo $after_widget;
	}
}