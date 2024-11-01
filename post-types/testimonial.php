<?php
if(!class_exists('Upside_Lite_Toolkit_Testimonial')){

	class Upside_Lite_Toolkit_Testimonial{

		public function __construct(){				
			add_action('init', array($this, 'register_post_type'), 0);			
			add_action('admin_init', array($this, 'register_metabox'));			
			add_filter('manage_testimonial_posts_columns', array($this, 'manage_colums'));	
			add_action('manage_testimonial_posts_custom_column' , array($this, 'manage_colum'));
		}

		public function register_post_type(){

			$labels = array(
				'name'               => _x('Testimonials', 'post type general name', 'upside-lite-toolkit'),
				'singular_name'      => _x('Testimonial', 'post type singular name', 'upside-lite-toolkit'),
				'menu_name'          => _x('Testimonials', 'admin menu', 'upside-lite-toolkit'),
				'name_admin_bar'     => _x('Testimonial', 'add new on admin bar', 'upside-lite-toolkit'),
				'add_new'            => _x('Add New', 'testimonial', 'upside-lite-toolkit'),
				'add_new_item'       => esc_attr__('Add New Testimonial', 'upside-lite-toolkit'),
				'new_item'           => esc_attr__('New Testimonial', 'upside-lite-toolkit'),
				'edit_item'          => esc_attr__('Edit Testimonial', 'upside-lite-toolkit'),
				'view_item'          => esc_attr__('View Testimonial', 'upside-lite-toolkit'),
				'all_items'          => esc_attr__('All Testimonials', 'upside-lite-toolkit'),
				'search_items'       => esc_attr__('Search Testimonials', 'upside-lite-toolkit'),
				'parent_item_colon'  => esc_attr__('Parent Testimonials:', 'upside-lite-toolkit'),
				'not_found'          => esc_attr__('No testimonials found.', 'upside-lite-toolkit'),
				'not_found_in_trash' => esc_attr__('No testimonials found in Trash.', 'upside-lite-toolkit')
			);

			$args = array(
				'menu_icon'          => 'dashicons-megaphone',
				'public'             => true,	      
				'labels'             => $labels,
				'supports'           => array('title', 'thumbnail', 'editor'),
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'testimonial' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 100
		    );

		    register_post_type('testimonial', $args);

				$labels = array(
				'name'              => _x('Testimonial Tags', 'taxonomy general name', 'upside-lite-toolkit'),
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
				'rewrite'           => array('slug' => 'testimonial-tag'),
			);

			register_taxonomy('testimonial-tag', array('testimonial'), $args);	   		 
		}
		
		public function register_metabox(){
            $args = array(
                'id'          => 'utp-testimonial-options-metabox',
                'title'       => esc_attr__('More info', 'upside-lite-toolkit'),
                'desc'        => '',
                'pages'       => array( 'testimonial' ),
                'context'     => 'normal',
                'priority'    => 'low',
                'fields'      => array(
                    array(
                        'title'   => esc_attr__('Job', 'upside-lite-toolkit'),
                        'type'    => 'text',
                        'id'      => 'utp_testi_job',
                    ),
                    array(
                        'title'   => esc_attr__('Company', 'upside-lite-toolkit'),
                        'type'    => 'text',
                        'id'      => 'utp_testi_company',
                    ),
                    array(
                        'title'   => esc_attr__('Website', 'upside-lite-toolkit'),
                        'type'    => 'text',
                        'id'      => 'utp_testi_website',
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
				'taxonomy-testimonial-tag'    => esc_attr__('Tags', 'upside-lite-toolkit'),
			);
			return $columns;	
		}

		public function manage_colum($column){
			global $post;
			switch ($column) {	
				case 'upside_toolkit_plus-thumb':
					if(has_post_thumbnail($post->ID)){
						the_post_thumbnail('thumbnail');						
					}					
					break;			
			}
		}
	}
	$upside_lite_toolkit_testimonial = new Upside_Lite_Toolkit_Testimonial();
}