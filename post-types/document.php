<?php
if (!class_exists('Upside_Lite_Toolkit_Document')) {

    class Upside_Lite_Toolkit_Document {

        public function __construct() {
            add_action('init', array($this, 'init'));
            add_action('admin_init', array($this, 'register_metabox'));
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
            add_action('pre_get_posts', array($this, 'edit_query_search'));
        }
       
        public function init() {

            $labels = array(
                'name' => _x('Documents', 'post type general name', 'upside-lite-toolkit'),
                'singular_name' => _x('Document', 'post type singular name', 'upside-lite-toolkit'),
                'menu_name' => _x('Documents', 'admin menu', 'upside-lite-toolkit'),
                'name_admin_bar' => _x('Document', 'add new on admin bar', 'upside-lite-toolkit'),
                'add_new' => _x('Add New', 'document', 'upside-lite-toolkit'),
                'add_new_item' => esc_attr__('Add New Document', 'upside-lite-toolkit'),
                'new_item' => esc_attr__('New Document', 'upside-lite-toolkit'),
                'edit_item' => esc_attr__('Edit Document', 'upside-lite-toolkit'),
                'view_item' => esc_attr__('View Document', 'upside-lite-toolkit'),
                'all_items' => esc_attr__('All Documents', 'upside-lite-toolkit'),
                'search_items' => esc_attr__('Search Documents', 'upside-lite-toolkit'),
                'parent_item_colon' => esc_attr__('Parent Documents:', 'upside-lite-toolkit'),
                'not_found' => esc_attr__('No documents found.', 'upside-lite-toolkit'),
                'not_found_in_trash' => esc_attr__('No documents found in Trash.', 'upside-lite-toolkit')
            );

            $args = array(
                'menu_icon' => 'dashicons-book',
                'public' => true,
                'labels' => $labels,
                'supports' => array('title', 'editor', 'comments'),
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'document'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => 100
            );

            register_post_type('document', $args);

            $labels = array(
                'name' => _x('Document Tags', 'taxonomy general name', 'upside-lite-toolkit'),
                'singular_name' => _x('Tag', 'taxonomy singular name', 'upside-lite-toolkit'),
                'search_items' => esc_attr__('Search Tags', 'upside-lite-toolkit'),
                'all_items' => esc_attr__('All Tags', 'upside-lite-toolkit'),
                'parent_item' => esc_attr__('Parent Tag', 'upside-lite-toolkit'),
                'parent_item_colon' => esc_attr__('Parent Tag:', 'upside-lite-toolkit'),
                'edit_item' => esc_attr__('Edit Tag', 'upside-lite-toolkit'),
                'update_item' => esc_attr__('Update Tag', 'upside-lite-toolkit'),
                'add_new_item' => esc_attr__('Add New Tag', 'upside-lite-toolkit'),
                'new_item_name' => esc_attr__('New Tag Name', 'upside-lite-toolkit'),
                'menu_name' => esc_attr__('Tag', 'upside-lite-toolkit'),
            );

            $args = array(
                'hierarchical' => false,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'document-tag'),
            );

            register_taxonomy('document-tag', array('document'), $args);
        }

        public function admin_enqueue_scripts($hook) {
            if (in_array($hook, array('post.php', 'post-new.php'))) {
                global $post;
                if ($post->post_type == 'document') {
                    wp_enqueue_media();
                }
            }
        }

        public function edit_query_search($query){
            if ( !is_admin() && $query->is_main_query() ) {
                if ( $query->is_search ) {
                    if ( isset($_GET['type']) && 'document' == $_GET['type'] ) {
                        $query->set('post_type', 'document');
                        return $query;
                    }
                }
            }
        }

        public function register_metabox() {
            $args = array(
                'id' => 'utp-document-options-metabox',
                'title' => esc_attr__('Options', 'upside-lite-toolkit'),
                'desc' => '',
                'pages' => array('document'),
                'context' => 'normal',
                'priority' => 'low',
                'fields' => array(
                    array(
                        'title' => esc_attr__('Icon', 'upside-lite-toolkit'),
                        'type' => 'icon',
                        'id' => 'utp-document-icon',
                    )
                )
            );

            kopa_register_metabox($args);            
        }
    }

    $upside_lite_toolkit_document = new Upside_Lite_Toolkit_Document();
}