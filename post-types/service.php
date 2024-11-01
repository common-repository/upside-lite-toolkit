<?php
if(!class_exists('Upside_Lite_Toolkit_Service')){

	class Upside_Lite_Toolkit_Service{

		public function __construct(){				
			add_action('init', array($this, 'register_post_type'), 0);
			add_action('admin_init', array($this, 'register_metabox'));			
			add_filter('manage_service_posts_columns', array($this, 'manage_colums'));	
			add_action('manage_service_posts_custom_column' , array($this, 'manage_colum'));
            add_action( 'admin_enqueue_scripts', array($this, 'upside_service_admin_script'), 11 );
		}

		public function register_post_type(){

			$labels = array(
				'name'               => _x('Services', 'post type general name', 'upside-lite-toolkit'),
				'singular_name'      => _x('Service', 'post type singular name', 'upside-lite-toolkit'),
				'menu_name'          => _x('Services', 'admin menu', 'upside-lite-toolkit'),
				'name_admin_bar'     => _x('Service', 'add new on admin bar', 'upside-lite-toolkit'),
				'add_new'            => _x('Add New', 'service', 'upside-lite-toolkit'),
				'add_new_item'       => esc_attr__('Add New Service', 'upside-lite-toolkit'),
				'new_item'           => esc_attr__('New Service', 'upside-lite-toolkit'),
				'edit_item'          => esc_attr__('Edit Service', 'upside-lite-toolkit'),
				'view_item'          => esc_attr__('View Service', 'upside-lite-toolkit'),
				'all_items'          => esc_attr__('All Services', 'upside-lite-toolkit'),
				'search_items'       => esc_attr__('Search Services', 'upside-lite-toolkit'),
				'parent_item_colon'  => esc_attr__('Parent Services:', 'upside-lite-toolkit'),
				'not_found'          => esc_attr__('No services found.', 'upside-lite-toolkit'),
				'not_found_in_trash' => esc_attr__('No services found in Trash.', 'upside-lite-toolkit')
			);

			$args = array(
				'menu_icon'          => 'dashicons-lightbulb',
				'public'             => true,	      
				'labels'             => $labels,
				'supports'           => array('title', 'excerpt', 'thumbnail'),
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'service' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 100
		    );

		    register_post_type('service', $args);

			$labels = array(
				'name'              => _x('Service Tags', 'taxonomy general name', 'upside-lite-toolkit'),
				'singular_name'     => _x('Tag', 'taxonomy singular name', 'upside-lite-toolkit'),
				'search_items'      => esc_attr__('Search Tags', 'upside-lite-toolkit'),
				'all_items'         => esc_attr__('All Tags', 'upside-lite-toolkit'),
				'parent_item'       => esc_attr__('Parent Tag', 'upside-lite-toolkit'),
				'parent_item_colon' => esc_attr__('Parent Tag:', 'upside-lite-toolkit'),
				'edit_item'         => esc_attr__('Edit Tag', 'upside-lite-toolkit'),
				'update_item'       => esc_attr__('Update Tag', 'upside-lite-toolkit'),
				'add_new_item'      => esc_attr__('Add New Tag', 'upside-lite-toolkit'),
				'new_item_name'     => esc_attr__('New Tag Name', 'upside-lite-toolkit'),
				'menu_name'         => esc_attr__('Tag', 'upside-lite-toolkit'),
			);

			$args = array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_nav_menus' => false,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => 'service-tag'),
			);

			register_taxonomy('service-tag', array('service'), $args);		    
		}
		
		public function register_metabox(){
			$args = array(
				'id'          => 'upside-service-options-metabox',
			    'title'       => esc_attr__('Options', 'upside-lite-toolkit'),
			    'desc'        => '',
			    'pages'       => array( 'service' ),
			    'context'     => 'normal',
			    'priority'    => 'low',
			    'fields'      => array(				
					array(
						'title'   => esc_attr__('Icon', 'upside-lite-toolkit'),
						'type'    => 'icon',
						'id'      => 'upside_service_icon',
					),
                    array(
                        'title'   => esc_attr__('Link to', 'upside-lite-toolkit'),
                        'type'    => 'text',
                        'id'      => 'upside_service_linkto',
                    ),
                    array(
                        'title'   => esc_attr__('Sub title', 'upside-lite-toolkit'),
                        'type'    => 'text',
                        'id'      => 'upside_service_subtitle',
                    )
                )
			);			
			
			kopa_register_metabox( $args );
		}

		public function manage_colums($columns){				
			$columns = array(
				'cb'                   => esc_attr__('<input type="checkbox" />', 'upside-lite-toolkit'),
				'upside-thumb'            => esc_attr__('IMG', 'upside-lite-toolkit'),
				'title'                => esc_attr__('Title', 'upside-lite-toolkit'),
				'taxonomy-service-tag' => esc_attr__('Tags', 'upside-lite-toolkit'),
				'upside-icon-link'             => esc_attr__('Icon', 'upside-lite-toolkit'),
			);
			return $columns;	
		}

		public function manage_colum($column){
			global $post;
			switch ($column) {		
				case 'upside-thumb':
                    if(has_post_thumbnail($post->ID)){
                        upside_lite_the_post_thumbnail($post->ID, 'upside-post-type-thumb', array());
                    }
					break;		
				case 'upside-icon-link':
					if($icon = get_post_meta($post->ID, 'upside_service_icon', true)){
						echo sprintf('<i class="%s"></i>', esc_attr($icon));//esc_attr($icon);
					}
					break;				
			}
		}

        public function upside_service_admin_script() {
            $screen = get_current_screen();
            if ( isset($screen->post_type) && 'service' == $screen->post_type) {
                if( wp_style_is('kopa_font_awesome') ){
                    wp_enqueue_style('kopa_font_awesome');
                }else{
                    wp_enqueue_style('upside-font-awesome', get_template_directory_uri() . "/css/font.awesome.css", array(), NULL);
                }
            }
        }

	}

	$upside_lite_toolkit_service = new Upside_Lite_Toolkit_Service();

}