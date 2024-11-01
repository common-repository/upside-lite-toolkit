<?php
if(!class_exists('Upside_Lite_Toolkit_Megamenu')){

    class Upside_Lite_Toolkit_Megamenu{

        public function __construct(){
            add_action('init', array($this, 'register_post_type'), 0);
            add_action('admin_init', array($this, 'register_metabox'));
            add_filter('manage_megamenu_posts_columns', array($this, 'manage_colums'));
            add_action('manage_megamenu_posts_custom_column' , array($this, 'manage_colum'));
        }

        public function register_post_type(){

            $labels = array(
                'name' => esc_attr__('Mega Menus', 'upside-lite-toolkit'),
                'singular_name' => esc_attr__('Mega Menu', 'upside-lite-toolkit'),
                'menu_name' => esc_attr__('Mega Menus', 'upside-lite-toolkit'),
                'name_admin_bar' => esc_attr__('Mega Menus', 'upside-lite-toolkit'),
                'add_new' => esc_attr__('Add New', 'upside-lite-toolkit'),
                'add_new_item' => esc_attr__('Add New Mega Menu', 'upside-lite-toolkit'),
                'new_item' => esc_attr__('New Mega Menu', 'upside-lite-toolkit'),
                'edit_item' => esc_attr__('Edit Mega Menu', 'upside-lite-toolkit'),
                'view_item' => esc_attr__('View Mega Menu', 'upside-lite-toolkit'),
                'all_items' => esc_attr__('All Mega Menus', 'upside-lite-toolkit'),
                'search_items' => esc_attr__('Search Mega Menus', 'upside-lite-toolkit'),
                'not_found' => esc_attr__('No mega menus found.', 'upside-lite-toolkit'),
                'not_found_in_trash' => esc_attr__('No mega menus found in Trash.', 'upside-lite-toolkit')
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_icon' => 'dashicons-index-card',
                'query_var' => true,
                'rewrite' => array('slug' => 'megamenu'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'menu_position' => 80,
                'supports' => array('title')
            );

            register_post_type('megamenu', $args);
        }

        public function register_metabox(){

            global $wp_registered_sidebars;

            $register_sidebar = array();
            $register_sidebar[''] = '--None--';
            foreach ( $wp_registered_sidebars as $k => $v ) {
                $register_sidebar[$k] = $v['name'];
            }
            $args = array(
                'id'          => 'ut-megamenu-options-metabox',
                'title'       => esc_attr__('Settings', 'upside-lite-toolkit'),
                'desc'        => '',
                'pages'       => array( 'megamenu' ),
                'context'     => 'normal',
                'priority'    => 'low',
                'fields'      => array(
                    array(
                        'title'   => esc_attr__('Column 1 ( 1/4 )', 'upside-lite-toolkit'),
                        'type'    => 'select',
                        'id'      => 'ut-sidebar-1',
                        'options' => $register_sidebar
                    ),
                    array(
                        'title'   => esc_attr__('Column 2 ( 1/4 )', 'upside-lite-toolkit'),
                        'type'    => 'select',
                        'id'      => 'ut-sidebar-2',
                        'options' => $register_sidebar
                    ),
                    array(
                        'title'   => esc_attr__('Column 3 ( 1/2 )', 'upside-lite-toolkit'),
                        'type'    => 'select',
                        'id'      => 'ut-sidebar-3',
                        'options' => $register_sidebar
                    )
                )
            );

            kopa_register_metabox( $args );
        }

        public function manage_colums($columns){
            $columns = array(
                'cb' => esc_attr__('<input type="checkbox" />', 'upside-lite-toolkit'),
                'title' => esc_attr__('Title', 'upside-lite-toolkit'),
                'ut-shortcode' => esc_attr__('Shortcode', 'upside-lite-toolkit')
            );

            return $columns;
        }

        public function manage_colum($column){
            global $post;
            switch ($column) {
                case 'ut-shortcode':
                    echo '[upside_megamenu id=' . $post->ID . ']';
                    break;
            }
        }
    }

    $upside_lite_toolkit_megamenu = new Upside_Lite_Toolkit_Megamenu();

}