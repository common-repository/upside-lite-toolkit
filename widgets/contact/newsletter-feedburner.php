<?php
add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_Newsletter_Feedburner', 'register_widget'));
class Upside_Lite_Toolkit_Widget_Newsletter_Feedburner extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget(){
		register_widget('Upside_Lite_Toolkit_Widget_Newsletter_Feedburner');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-newsletter-widget';
		$this->widget_description = esc_attr__( 'Display a newsletter registration form with feedburner.', 'upside-lite-toolkit' );
		$this->widget_id          = 'upside-newsletter-widget';
		$this->widget_name        = esc_attr__( '(Upside lite) Newsletter Feedburner', 'upside-lite-toolkit' );
		
		$this->settings['title'] = array(
			'type'  => 'text',				
			'std'   => esc_attr__('Newsletter', 'upside-lite-toolkit'),
			'label' => esc_attr__( 'Title:', 'upside-lite-toolkit' ),
		);

        $this->settings['description'] = array(
            'type'  => 'textarea',
            'std'   => '',
            'label' => esc_attr__( 'Description:', 'upside-lite-toolkit' ),
        );

		$this->settings['uri'] = array(
			'type'  => 'text',				
			'std'   => '',
			'label' => esc_attr__( 'FeedBurner. Example, if your feedburner URL is http://feeds.feedburner.com/wordpress, you need to enter "wordpress" to bellow text box.', 'upside-lite-toolkit' )
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		extract( $instance );
		echo $before_widget;
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        if ( ! empty($title) ) : ?>
            <h4 class="widget-title"><?php echo esc_html($title); ?></h4>
        <?php endif; ?>

        <?php if ( ! empty($uri) ) :?>
            <form class="newsletter-form clearfix" method="post" action="http://feedburner.google.com/fb/a/mailverify"
                  target="popupwindow"
                  onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_url($uri); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');
                      return true;">
                <?php if ( ! empty($description) ) : ?>
                    <p><?php echo esc_textarea($description); ?></p>
                <?php endif; ?>
                <p class="input-email clearfix">
                    <input type="text" size="40" class="email" value="" name="email" onblur="if(this.value=='')this.value=this.defaultValue;" onfocus="if(this.value==this.defaultValue)this.value='';">
                    <input type="submit" class="submit" value="<?php esc_attr_e('Subscribe','upside-lite-toolkit');?>">
                </p>
            </form>
            <input type="hidden" value="<?php echo esc_url($uri); ?>" name="uri"/>
            <input type="hidden" name="loc" value="en_US"/>
        <?php
		    endif;
		$content = ob_get_clean();
		echo $content;
		echo $after_widget;
	}
}