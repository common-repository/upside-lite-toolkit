<?php
if(!class_exists('Upside_Lite_Slide')){

	class Upside_Lite_Slide{

		public function __construct(){				
			add_action('init', array($this, 'init'), 0);			
			add_action('admin_init', array($this, 'register_metabox'));
			add_filter('manage_slide_posts_columns', array($this, 'manage_colums'));			
			add_action('manage_slide_posts_custom_column' , array($this, 'manage_colum'));				
		}

		public function init(){

			$labels = array(
				'name'               => _x( 'Slides', 'post type general name', 'upside-lite-toolkit' ),
				'singular_name'      => _x( 'Slide', 'post type singular name', 'upside-lite-toolkit' ),
				'menu_name'          => _x( 'Slides', 'admin menu', 'upside-lite-toolkit' ),
				'name_admin_bar'     => _x( 'Slide', 'add new on admin bar', 'upside-lite-toolkit' ),
				'add_new'            => _x( 'Add New', 'slide', 'upside-lite-toolkit' ),
				'add_new_item'       => esc_attr__( 'Add New Slide', 'upside-lite-toolkit' ),
				'new_item'           => esc_attr__( 'New Slide', 'upside-lite-toolkit' ),
				'edit_item'          => esc_attr__( 'Edit Slide', 'upside-lite-toolkit' ),
				'view_item'          => esc_attr__( 'View Slide', 'upside-lite-toolkit' ),
				'all_items'          => esc_attr__( 'All Slides', 'upside-lite-toolkit' ),
				'search_items'       => esc_attr__( 'Search Slides', 'upside-lite-toolkit' ),
				'parent_item_colon'  => esc_attr__( 'Parent Slides:', 'upside-lite-toolkit' ),
				'not_found'          => esc_attr__( 'No slides found.', 'upside-lite-toolkit' ),
				'not_found_in_trash' => esc_attr__( 'No slides found in Trash.', 'upside-lite-toolkit' )
			);

			$args = array(
				'menu_icon'          => 'dashicons-slides',
				'public'             => true,	      
				'labels'             => $labels,
				'supports'           => array('title', 'thumbnail'),
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'slide' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 100
		    );

		    register_post_type('slide', $args);

		    $labels = array(
				'name'              => _x('Slide Tags', 'taxonomy general name', 'upside-lite-toolkit'),
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
				'rewrite'           => array('slug' => 'slide-tag'),
			);

			register_taxonomy('slide-tag', array('slide'), $args);
		}

		public function register_metabox(){
			$args = array(
				'id'          => 'upside-slide-options-metabox',
			    'title'       => esc_attr__('Options', 'upside-lite-toolkit'),
			    'desc'        => '',
			    'pages'       => array( 'slide' ),
			    'context'     => 'normal',
			    'priority'    => 'low',
			    'fields'      => array(		
			    	array(
						'title'   => esc_attr__('Description:', 'upside-lite-toolkit'),
						'type'    => 'textarea',
						'id'      => 'upside-lite-slide-description',
					),
                    array(
                        'title'   => esc_attr__('Button label:', 'upside-lite-toolkit'),
                        'type'    => 'text',
                        'id'      => 'upside-lite-slide-btn-text',
                    ),
			    	array(
						'title'   => esc_attr__('Button link:', 'upside-lite-toolkit'),
						'type'    => 'text',
						'id'      => 'upside-lite-slide-website',
					)					
			    )
			);			
			
			kopa_register_metabox( $args );
		}

		public function manage_colums($columns){			
			$columns = array(
				'cb'                          => esc_attr__('<input type="checkbox" />', 'upside-lite-toolkit'),
				'upside-lite-toolkit-thumb'   => esc_attr__('IMG', 'upside-lite-toolkit'),
				'title'                       => esc_attr__('Title', 'upside-lite-toolkit'),
				'taxonomy-slide-tag'          => esc_attr__('Tags', 'upside-lite-toolkit'),
				'upside-lite-toolkit-website' => esc_attr__('Link to', 'upside-lite-toolkit'),
			);

			return $columns;
		}

		public function manage_colum($column){
			global $post;
			switch ($column) {
				case 'upside-lite-toolkit-thumb':
					if(has_post_thumbnail($post->ID)){
						the_post_thumbnail('upside-post-type-thumb');
					}					
					break;
				case 'upside-lite-toolkit-website':
					if($website = get_post_meta($post->ID, 'upside-lite-slide-website', true)){
						printf('<a href="%1$s" target="_blank">%1$s</a>', $website);
					}
					break;					
			}
		}

	}

	$Upside_Lite_Slide = new Upside_Lite_Slide();

}