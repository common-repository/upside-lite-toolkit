<?php

if(!class_exists('Upside_Lite_Toolkit_Customer')){

	class Upside_Lite_Toolkit_Customer{

		public function __construct(){				
			add_action('init', array($this, 'init'), 0);			
			add_action('admin_init', array($this, 'register_metabox'));
			add_filter('manage_customer_posts_columns', array($this, 'manage_colums'));
			add_action('manage_customer_posts_custom_column' , array($this, 'manage_colum'));
		}

		public function init(){

			$labels = array(
				'name'               => _x( 'Customers', 'post type general name', 'upside-lite-toolkit' ),
				'singular_name'      => _x( 'Customer', 'post type singular name', 'upside-lite-toolkit' ),
				'menu_name'          => _x( 'Customers', 'admin menu', 'upside-lite-toolkit' ),
				'name_admin_bar'     => _x( 'Customer', 'add new on admin bar', 'upside-lite-toolkit' ),
				'add_new'            => _x( 'Add New', 'customer', 'upside-lite-toolkit' ),
				'add_new_item'       => esc_attr__( 'Add New Customer', 'upside-lite-toolkit' ),
				'new_item'           => esc_attr__( 'New Customer', 'upside-lite-toolkit' ),
				'edit_item'          => esc_attr__( 'Edit Customer', 'upside-lite-toolkit' ),
				'view_item'          => esc_attr__( 'View Customer', 'upside-lite-toolkit' ),
				'all_items'          => esc_attr__( 'All Customers', 'upside-lite-toolkit' ),
				'search_items'       => esc_attr__( 'Search Customers', 'upside-lite-toolkit' ),
				'parent_item_colon'  => esc_attr__( 'Parent Customers:', 'upside-lite-toolkit' ),
				'not_found'          => esc_attr__( 'No customers found.', 'upside-lite-toolkit' ),
				'not_found_in_trash' => esc_attr__( 'No customers found in Trash.', 'upside-lite-toolkit' )
			);

			$args = array(
				'menu_icon'          => 'dashicons-awards',
				'public'             => true,	      
				'labels'             => $labels,
				'supports'           => array('title', 'thumbnail', 'editor'),
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'customer' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 100
		    );

		    register_post_type('customer', $args);

		    $labels = array(
				'name'              => _x('Customer Tags', 'taxonomy general name', 'upside-lite-toolkit'),
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
				'rewrite'           => array('slug' => 'customer-tag'),
			);

			register_taxonomy('customer-tag', array('customer'), $args);
		}

		public function register_metabox(){
			$args = array(
				'id'          => 'customer-options-metabox',
			    'title'       => esc_attr__('Other infomation:', 'upside-lite-toolkit'),
			    'desc'        => '',
			    'pages'       => array('customer'),
			    'context'     => 'normal',
			    'priority'    => 'low',
			    'fields'      => array(
			    	array(
						'title'   => esc_attr__('Website:', 'upside-lite-toolkit'),
						'type'    => 'text',
						'id'      => 'upside_customer_website',
					)					
			    )
			);			
			
			kopa_register_metabox( $args );
		}

		public function manage_colums($columns){			
			$columns = array(
				'cb'                          => esc_attr__('<input type="checkbox" />', 'upside-lite-toolkit'),
				'upside_toolkit_plus-thumb'   => esc_attr__('IMG', 'upside-lite-toolkit'),
				'title'                       => esc_attr__('Title', 'upside-lite-toolkit'),
				'taxonomy-customer-tag'          => esc_attr__('Tags', 'upside-lite-toolkit'),
				'upside_toolkit_plus_website' => esc_attr__('Website / Blog', 'upside-lite-toolkit'),
			);

			return $columns;	
		}

		public function manage_colum($column){
			global $post;
			switch ($column) {
				case 'upside_toolkit_plus-thumb':
					if(has_post_thumbnail($post->ID)){
						the_post_thumbnail('upside-post-type-thumb');
					}					
					break;
				case 'upside_toolkit_plus_website':
					if($website = get_post_meta($post->ID, 'upside_brand_website', true)){
						printf('<a href="%1$s" target="_blank">%1$s</a>', $website);
					}
					break;					
			}
		}

	}

	$Upside_Lite_Toolkit_Customer = new Upside_Lite_Toolkit_Customer();
}