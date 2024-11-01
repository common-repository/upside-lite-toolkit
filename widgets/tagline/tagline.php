<?php
add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_Tagline', 'register_widget'));
class Upside_Lite_Toolkit_Widget_Tagline extends Kopa_Widget {

	public $kpb_group = 'Call to action';

	public static function register_widget(){
		register_widget('Upside_Lite_Toolkit_Widget_Tagline');
	}


	public function __construct() {
		$this->widget_cssclass    = 'kopa-tagline-5-widget';
		$this->widget_description = esc_attr__( 'Display texts and buttons.', 'upside-lite-toolkit' );
		$this->widget_id          = 'upside_tagline';
		$this->widget_name        = esc_attr__( '(Upside lite) Call to action 1', 'upside-lite-toolkit' );
		
		$this->settings           = array(			
			'text1'    => array(
				'type'  => 'text',
				'std'   => '',
				'label' =>  esc_attr__( 'Text 1:', 'upside-lite-toolkit')
			),
            'text2'    => array(
                'type'  => 'text',
                'std'   => '',
                'label' =>  esc_attr__( 'Text 2:', 'upside-lite-toolkit')
            ),
            'button_text'  => array(
                'type'  => 'text',
                'std'   => esc_attr__('Signup now', 'upside-lite-toolkit'),
                'label' => esc_attr__( 'Button label:', 'upside-lite-toolkit')
            ),
			'button_link'  => array(
				'type'  => 'text',
				'std'   => '#',
				'label' => esc_attr__( 'Button link:', 'upside-lite-toolkit')
			),
            'banner'    => array(
                'type'  => 'upload',
                'std'   => '',
                'label' =>  esc_attr__( 'Background image', 'upside-lite-toolkit')
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
        if ( ! empty($banner) ) {
            echo '<div class="hide-banner" data-banner="' . esc_url($banner) . '"></div>';
        }
		?>
        <div class="row">
            <div class="col-md-10 col-sm-9 col-xs-12">
                <?php if ( ! empty($text1) || ! empty($text2) ) : ?>
                <h3><?php echo esc_html($text1); ?>
                    <?php if ( ! empty($text2) ) : ?>
                        <span><?php echo esc_html($text2); ?></span>
                        <?php endif; ?>
                </h3>
                <?php endif; ?>
            </div>
            <?php if ( ! empty($button_text) && ! empty($button_link) ) : ?>
                <div class="col-md-2 col-sm-3 col-xs-12">
                    <a href="<?php echo esc_url($button_link);?>" title="<?php echo esc_attr($button_text);?>" class="kopa-button pink-button medium-button"><?php echo esc_html($button_text);?></a>
                </div>
            <?php endif; ?>
        </div>
		<?php
		echo $after_widget;
        $content = ob_get_clean();
		echo $content;
	}
}