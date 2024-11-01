<?php
add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_Custom_Nav', 'register_widget'));
class Upside_Lite_Toolkit_Widget_Custom_Nav extends Kopa_Widget {

	public $kpb_group = 'miscellaneous';

    public static function register_widget(){
            register_widget('Upside_Lite_Toolkit_Widget_Custom_Nav');
    }

	public function __construct() {
		$this->widget_cssclass    = 'upside-custom-nav';
		$this->widget_description = esc_attr__('Display custom menu for megamenu items.', 'upside-lite-toolkit');
		$this->widget_id          = 'upside-custom-nav';
		$this->widget_name        = esc_attr__( '(Upside lite) Custom menu', 'upside-lite-toolkit' );

        $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
        $menu_arr = array();

        foreach ( $menus as $menu ) {
            $menu_arr[$menu->term_id] = esc_html( $menu->name );
        }

		$this->settings 		  = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_attr__( 'Title:', 'upside-lite-toolkit' ),
            ),
            'nav_menu'    => array(
                'type'    => 'select',
                'label'   => esc_attr__( 'Select Menu:', 'upside-lite-toolkit' ),
                'std'     => '',
                'options' => $menu_arr
            )
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		ob_start();

		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
		extract( $instance );

        $menu_items = wp_get_nav_menu_items($nav_menu);

        if ( $menu_items ) : ?>

            <ul class="toggle-view kopa-toggle-2">
                <?php
                    $parent_items = array();
                    $child_items = array();
                    foreach ( $menu_items as $menu ) {
                        if ( 0 == $menu->menu_item_parent ) {
                            $parent_items[] = $menu;
                        } else {
                            $child_items[] = $menu;
                        }
                    }

                    foreach ( $parent_items as $parent ) {
                        $menu_child = array();
                        foreach ( $child_items as $child ) {
                            if ( $child->menu_item_parent == $parent->ID ) {
                                $menu_child[] = $child;
                            }
                        }
                        ?>

                        <li class="clearfix">
                            <h6>
                                <?php
                                    $upside_icon = get_post_meta($parent->ID, 'menu-item-field-menuicon', true);
                                    if ( ! empty($upside_icon) ) {
                                        echo sprintf('<i class="%s"></i>', esc_attr($upside_icon));
                                    }
                                    echo esc_html($parent->title);
                                ?>
                            </h6>
                            <?php if ( $menu_child ) : ?>
                                <span class="fa fa-plus"></span>
                                <div class="clear"></div>
                                <div class="kopa-panel clearfix">
                                    <?php
                                    foreach ( $menu_child as $value ) {
                                        echo sprintf('<p><a href="%s" title="%s">%s</a></p>', esc_url($value->url), esc_html($value->title), esc_attr($value->title));
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                        </li>

                    <?php }

                ?>
            </ul>

        <?php endif;

		$content = ob_get_clean();

		echo $content;		
	}

}