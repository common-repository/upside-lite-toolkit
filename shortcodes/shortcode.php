<?php
class Upside_Toolkit_Lite_Shortcode{
	
	function __construct(){
        add_action('admin_enqueue_scripts', array($this,'upside_lite_toolkit_admin_enqueue_scripts'), 20);
        add_action('admin_init', array($this, 'admin_init'));
	}

	public function load_shortcodes(){
        require ULT_PATH . 'shortcodes/elements/caption.php';
        require ULT_PATH . 'shortcodes/elements/dropcaps.php';
        require ULT_PATH . 'shortcodes/elements/grid.php';
        require ULT_PATH . 'shortcodes/elements/blockquote.php';
        require ULT_PATH . 'shortcodes/elements/button.php';
        require ULT_PATH . 'shortcodes/elements/progress.php';
        require ULT_PATH . 'shortcodes/elements/tabs.php';
        require ULT_PATH . 'shortcodes/elements/toggle.php';
        require ULT_PATH . 'shortcodes/elements/price_table.php';
        require ULT_PATH . 'shortcodes/elements/check_table.php';
        require ULT_PATH . 'shortcodes/elements/alert.php';
        require ULT_PATH . 'shortcodes/elements/sticky.php';
        require ULT_PATH . 'shortcodes/elements/hightlight.php';
        require ULT_PATH . 'shortcodes/elements/megamenu.php';
        require ULT_PATH . 'shortcodes/elements/accordions.php';
        require ULT_PATH . 'shortcodes/elements/ulist.php';
        require ULT_PATH . 'shortcodes/elements/custom_ctf7.php';
        require ULT_PATH . 'shortcodes/elements/gallery.php';
	}

    public function upside_lite_toolkit_admin_enqueue_scripts($hook){
        if(in_array($hook, array('widgets.php', 'post.php', 'post-new.php'))){
            wp_localize_script( 'jquery', 'upside_toolkit', array(
                'i18n' => array(
                    'u_list'         => esc_attr__('Unorder list', 'upside-lite-toolkit'),
                    'u_list_square'  => esc_attr__('Square icon', 'upside-lite-toolkit'),
                    'u_list_no_icon' => esc_attr__('No icon', 'upside-lite-toolkit'),
                    'u_list_round'   => esc_attr__('Round icon', 'upside-lite-toolkit'),
                    'u_list_plus'    => esc_attr__('Plus icon', 'upside-lite-toolkit'),
                    'u_list_custom'  => esc_attr__('Custom icon', 'upside-lite-toolkit'),
                    'u_list_default' => esc_attr__('Default icon', 'upside-lite-toolkit'),
                    'u_list_check'   => esc_attr__('Check icon', 'upside-lite-toolkit'),
                    'icon_picker'    => esc_attr__('Icon Picker', 'upside-lite-toolkit'),
                    'shortcodes'     => esc_attr__('Shortcodes', 'upside-lite-toolkit'),
                    'caption'        => esc_attr__('Caption', 'upside-lite-toolkit'),
                    'grid'           => esc_attr__('Grid', 'upside-lite-toolkit'),
                    'container'      => esc_attr__('Container', 'upside-lite-toolkit'),
                    'tabs'           => esc_attr__('Tabs', 'upside-lite-toolkit'),
                    'accordion'      => esc_attr__('Accordion', 'upside-lite-toolkit'),
                    'toggle'         => esc_attr__('Toggle', 'upside-lite-toolkit'),
                    'dropcap'        => esc_attr__('Dropcap', 'upside-lite-toolkit'),
                    'circle'         => esc_attr__('Circle', 'upside-lite-toolkit'),
                    'rectangle'      => esc_attr__('Rectangle', 'upside-lite-toolkit'),
                    'transparent'    => esc_attr__('Transparent', 'upside-lite-toolkit'),
                    'alert'          => esc_attr__('Alert box', 'upside-lite-toolkit'),
                    'notice'         => esc_attr__('Notice', 'upside-lite-toolkit'),
                    'info'           => esc_attr__('Info', 'upside-lite-toolkit'),
                    'success'        => esc_attr__('Success', 'upside-lite-toolkit'),
                    'warning'        => esc_attr__('Warning', 'upside-lite-toolkit'),
                    'danger'         => esc_attr__('Danger', 'upside-lite-toolkit'),
                    'button'         => esc_attr__('Button', 'upside-lite-toolkit'),
                    'pink'           => esc_attr__('Pink', 'upside-lite-toolkit'),
                    'pink_middle'    => esc_attr__('Midnight-blue', 'upside-lite-toolkit'),
                    'blue'           => esc_attr__('Blue', 'upside-lite-toolkit'),
                    'navy'           => esc_attr__('Navy', 'upside-lite-toolkit'),
                    'green'          => esc_attr__('Green', 'upside-lite-toolkit'),
                    'red'            => esc_attr__('Red', 'upside-lite-toolkit'),
                    'sky'            => esc_attr__('Sky', 'upside-lite-toolkit'),
                    'yellow'         => esc_attr__('Yellow', 'upside-lite-toolkit'),
                    'small'          => esc_attr__('Small', 'upside-lite-toolkit'),
                    'medium'         => esc_attr__('Medium', 'upside-lite-toolkit'),
                    'large'          => esc_attr__('Large', 'upside-lite-toolkit'),
                    'small_line'     => esc_attr__('Small with border', 'upside-lite-toolkit'),
                    'medium_line'    => esc_attr__('Medium with border', 'upside-lite-toolkit'),
                    'large_line'     => esc_attr__('Large with border', 'upside-lite-toolkit'),
                    'default'        => esc_attr__('Default', 'upside-lite-toolkit'),
                    'special'        => esc_attr__('Special', 'upside-lite-toolkit'),
                    'blockquote'     => esc_attr__('Blockquote', 'upside-lite-toolkit'),
                    'progress'       => esc_attr__('Progress', 'upside-lite-toolkit'),
                    'table'          => esc_attr__('Table', 'upside-lite-toolkit'),
                    'check_table'    => esc_attr__('Check table', 'upside-lite-toolkit'),
                    'sticky'         => esc_attr__('Sticky', 'upside-lite-toolkit'),
                    'orange'         => esc_attr__('Orange', 'upside-lite-toolkit'),
                    'hightlight'     => esc_attr__('Hightlight', 'upside-lite-toolkit'),
                    'soundcloud'     => esc_attr__('Soundcloud', 'upside-lite-toolkit'),
                    'contact'        => esc_attr__('Custom contact form 7', 'upside-lite-toolkit'),
                )
            ) );
            wp_enqueue_style('upside-toolkit-shortcode', ULT_DIR . "assets/css/shortcode.css", array(), NULL);
        }
    }

    public function admin_init(){
        if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
            add_filter('mce_external_plugins', array($this, 'mce_external_plugins'));
            add_filter('mce_buttons', array($this, 'mce_buttons'));
        }
    }

    public function mce_external_plugins($plugin_array) {
        $plugin_array['upside_shortcodes'] = ULT_DIR . "assets/js/tinymce.js";
        return $plugin_array;
    }

    public function mce_buttons($buttons) {
        $buttons[] = 'upside_shortcodes';
        return $buttons;
    }
}

$upside_toolkit_lite_shortcodes = new Upside_Toolkit_Lite_Shortcode();
$upside_toolkit_lite_shortcodes->load_shortcodes();