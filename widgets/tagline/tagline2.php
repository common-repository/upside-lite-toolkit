<?php
add_filter('kopa_page_bulder_set_classname', 'upside_lite_toolkit_tagline2_dynamic_param', 10, 2);
function upside_lite_toolkit_tagline2_dynamic_param($option_class, $widget_data){
    if ( 'kopa-tagline-1-widget' === $option_class && isset($widget_data['button_style']) ) {
        switch ( $widget_data['button_style'] ) {
            case 'pink-button-icon-after-gray':
                $option_class = 'kopa-tagline-3-widget';
                break;
            case 'solid-button-icon-after-gray':
                $option_class = 'kopa-tagline-4-widget';
                break;
        }
    }
    return $option_class;
}

add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_Tagline2', 'register_widget'));
class Upside_Lite_Toolkit_Widget_Tagline2 extends Kopa_Widget {

	public $kpb_group = 'Call to action';

	public static function register_widget(){
		register_widget('Upside_Lite_Toolkit_Widget_Tagline2');
	}

	public function __construct() {
		$this->widget_cssclass    = 'kopa-tagline-1-widget';
		$this->widget_description = esc_attr__( 'Display texts and button.', 'upside-lite-toolkit' );
		$this->widget_id          = 'upside-lite-toolkit-tagline-2';
		$this->widget_name        = esc_attr__( '(Upside lite) Call to action 2', 'upside-lite-toolkit' );
		
		$this->settings           = array(			
			'title'    => array(
				'type'  => 'text',
				'std'   => '',
				'label' =>  esc_attr__( 'Title:', 'upside-lite-toolkit')
			),
            'description'    => array(
                'type'  => 'textarea',
                'std'   => '',
                'label' =>  esc_attr__( 'Description:', 'upside-lite-toolkit')
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
            'button_style'  => array(
                'type'  => 'select',
                'std'   => '',
                'label' => esc_attr__( 'Display:', 'upside-lite-toolkit'),
                'options' => array(
                    'solid-button' => esc_attr__('Title and button', 'upside-lite-toolkit'),
                    'pink-button-icon-after-gray' => esc_attr__('Title, description and button with gray background', 'upside-lite-toolkit'),
                    'solid-button-icon-after-gray' => esc_attr__('Title, description and button with blue background', 'upside-lite-toolkit'),
                )
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

        switch ( $button_style ) :
            case 'solid-button':
                if ( ! empty($title) ) : ?>
                    <h3><?php echo esc_html($title); ?></h3>
                <?php endif;
                if ( ! empty($button_text) && ! empty($button_link) ) : ?>
                    <a href="<?php echo esc_url($button_link);?>" title="<?php echo esc_attr($button_text);?>" class="kopa-button kopa-line-button-bg kopa-line-button medium-button"><?php echo esc_html($button_text);?></a>
                <?php endif;
                break;

            case 'pink-button-icon-after-gray':
                if ( ! empty($title) ) : ?>
                    <div class="entry-title">
                        <h2><a href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($title); ?></a></h2>
                        <p><span></span></p>
                    </div>
                <?php endif;
                if ( ! empty($description) ) : ?>
                    <p><?php echo wp_kses_post($description); ?></p>
                <?php endif;
                if ( ! empty($button_text) ) : ?>
                    <a href="<?php echo esc_url($button_link); ?>" class="kopa-button pink-button medium-button"><?php echo esc_html($button_text); ?></a>
                <?php endif;
                break;

            case 'solid-button-icon-after-gray':
                if ( ! empty($title) ) : ?>
                    <div class="entry-title">
                        <h2><a href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($title); ?></a></h2>
                        <p><span></span></p>
                    </div>
                <?php endif;
                if ( ! empty($description) ) : ?>
                    <p><?php echo wp_kses_post($description); ?></p>
                <?php endif;
                if ( ! empty($button_text) ) : ?>
                    <a href="<?php echo esc_url($button_link); ?>" class="kopa-button kopa-line-button medium-button"><?php echo esc_html($button_text); ?></a>
                <?php endif;
                break;
        endswitch;

		echo $after_widget;
        $content = ob_get_clean();
		echo $content;
	}
}