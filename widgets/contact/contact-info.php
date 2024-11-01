<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Contact_Info', 'register_block'));
class Upside_Lite_Toolkit_Widget_Contact_Info extends Kopa_Widget {

	public $kpb_group = 'contact';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Contact_Info'] = new Upside_Lite_Toolkit_Widget_Contact_Info();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-contact-2-widget';
		$this->widget_description = esc_attr__( 'Display your company contact information.', 'upside-lite-toolkit' );
		$this->widget_id          = 'upside-lite-toolkit-contact-info';
		$this->widget_name        = esc_attr__( '(Upside lite) Contact info', 'upside-lite-toolkit' );
		
		$this->settings           = array(			
			'u_title'    => array(
				'type'  => 'text',
				'std'   => esc_attr__( 'Contact information', 'upside-lite-toolkit'),
				'label' =>  esc_attr__( 'Title', 'upside-lite-toolkit')
			),
            'u_address'    => array(
                'type'  => 'text',
                'std'   => '',
                'label' =>  esc_attr__( 'Address:', 'upside-lite-toolkit')
            ),
			'u_email'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_attr__( 'Email', 'upside-lite-toolkit')
			),
            'u_telephone'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_attr__( 'Telephone', 'upside-lite-toolkit')
            )
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		extract( $instance );
		echo $before_widget;

            if ( $u_title ): ?>
                <h2 class="widget-title widget-title-s12"><?php echo esc_html($u_title); ?></h2>
            <?php endif; ?>

            <div class="widget-content" itemtype="http://schema.org/Organization" itemscope="">
                <?php if ( $u_address ) : ?>
                    <p class="contact-address">
                        <i class="fa fa-map-marker"></i>
                        <span><?php echo esc_html($u_address); ?></span>
                    </p>
                <?php endif; ?>

                <?php if ( $u_email ) : ?>
                    <p class="contact-mail">
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:<?php echo esc_attr($u_email); ?>"><?php echo esc_html($u_email);?></a>
                    </p>
                <?php endif; ?>

                <?php if ( $u_telephone ) : ?>
                    <p class="contact-phone">
                        <i class="fa fa-phone"></i>
                        <a href="#"><?php echo esc_html($u_telephone);?></a>
                    </p>
                <?php endif; ?>
            </div>

            <?php
		echo $after_widget;
        $content = ob_get_clean();
		echo $content;
	}
}