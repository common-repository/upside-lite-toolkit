<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Google_Map', 'register_block'));
class Upside_Lite_Toolkit_Widget_Google_Map extends Kopa_Widget {

	public $kpb_group = 'contact';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Google_Map'] = new Upside_Lite_Toolkit_Widget_Google_Map();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-map-2-widget';
		$this->widget_description = esc_attr__( 'Display your google map.', 'upside-lite-toolkit' );
		$this->widget_id          = 'upside-lite-toolkit-google-map';
		$this->widget_name        = esc_attr__( '(Upside lite) Google Map', 'upside-lite-toolkit' );
		
		$this->settings           = array(			
			'u_place'    => array(
				'type'  => 'text',
				'std'   => '',
				'label' =>  esc_attr__( 'Location', 'upside-lite-toolkit')
			),
            'u_latitude'    => array(
                'type'  => 'text',
                'std'   => '',
                'label' =>  esc_attr__( 'Latitude:', 'upside-lite-toolkit')
            ),
			'u_longitude'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_attr__( 'Longitude', 'upside-lite-toolkit')
			),
            'u_height'  => array(
                'type'  => 'text',
                'std'   => '336px',
                'label' => esc_attr__( 'Map Height ( E.g: 336px )', 'upside-lite-toolkit')
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

        if (!empty($u_latitude) && !empty($u_longitude)):
            $style = ($u_height) ? "height: {$u_height};" : '';
            $map_id = 'upside-map-' . wp_generate_password(4, false, false);
            ?>
            <div class="kopa-map-wrapper">
                <div id="<?php echo esc_attr($map_id);?>"
                     class="kopa-map"
                     style="<?php echo esc_attr($style); ?>"
                     data-latitude="<?php echo esc_attr($u_latitude); ?>"
                     data-longitude="<?php echo esc_attr($u_longitude); ?>"
                     data-place="<?php echo esc_attr($u_place); ?>"></div>
            </div>
        <?php
        endif;

		echo $after_widget;
        $content = ob_get_clean();
		echo $content;
	}
}