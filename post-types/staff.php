<?php
if(!class_exists('Upside_Lite_Toolkit_Staff')){

	class Upside_Lite_Toolkit_Staff{

		public function __construct(){				
			add_action('init', array($this, 'init'), 0);			
			add_filter('manage_staff_posts_columns', array($this, 'manage_colums'));
			add_action('manage_staff_posts_custom_column' , array($this, 'manage_colum'));
            add_action('admin_init', array($this, 'register_metabox'));

            #PRINT LAYOUT
            //add_filter('upside_lite_is_override_default_template', array($this, 'is_override_default_template'));
            //add_action('upside_lite_load_template', array($this, 'load_template'));

            add_action('pre_get_posts', array($this, 'edit_query_staff_archive'));
        }

        public function register_metabox(){
            $utp_member = array(
                array(
                    'title'   => esc_attr__('Position', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-member-position',
                    'desc' => ''
                ),
            );

            $utp_socials = upside_lite_toolkit_get_profile_socials();
            $utp_socials = apply_filters('upside_lite_toolkit_staff_social_custom', $utp_socials);
            if ( $utp_socials ) {
                foreach ( $utp_socials as $k => $v ) {
                    $utp_member[] = array(
                        'title' => $v['title'],
                        'type' => 'text',
                        'id' => 'utp-k-member-social-'.$k
                    );
                }
            }
            $utp_member = apply_filters('upside_lite_toolkit_staff_custom_attributes', $utp_member);
            $args = array(
                'id'          => 'utp-staff-options-metabox',
                'title'       => esc_attr__('Staff Details', 'upside-lite-toolkit'),
                'desc'        => '',
                'pages'       => array( 'staff' ),
                'context'     => 'normal',
                'priority'    => 'high',
                'fields'      => $utp_member
            );

            kopa_register_metabox( $args );
        }

		public function init(){

			$labels = array(
				'name'               => _x( 'Staff', 'post type general name', 'upside-lite-toolkit' ),
				'singular_name'      => _x( 'Staff', 'post type singular name', 'upside-lite-toolkit' ),
				'menu_name'          => _x( 'Staff', 'admin menu', 'upside-lite-toolkit' ),
				'name_admin_bar'     => _x( 'Staff', 'add new on admin bar', 'upside-lite-toolkit' ),
				'add_new'            => _x( 'Add New', 'staff', 'upside-lite-toolkit' ),
				'add_new_item'       => esc_attr__( 'Add New Staff', 'upside-lite-toolkit' ),
				'new_item'           => esc_attr__( 'New Staff', 'upside-lite-toolkit' ),
				'edit_item'          => esc_attr__( 'Edit Staff', 'upside-lite-toolkit' ),
				'view_item'          => esc_attr__( 'View Staff', 'upside-lite-toolkit' ),
				'all_items'          => esc_attr__( 'All Staff', 'upside-lite-toolkit' ),
				'search_items'       => esc_attr__( 'Search Staff', 'upside-lite-toolkit' ),
				'parent_item_colon'  => esc_attr__( 'Parent Staff:', 'upside-lite-toolkit' ),
				'not_found'          => esc_attr__( 'No Staff found.', 'upside-lite-toolkit' ),
				'not_found_in_trash' => esc_attr__( 'No Staff found in Trash.', 'upside-lite-toolkit' )
			);

			$args = array(
				'menu_icon'          => 'dashicons-businessman',
				'public'             => true,	      
				'labels'             => $labels,
				'supports'           => array('title', 'thumbnail', 'editor', 'author', 'excerpt'),
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
                'show_in_nav_menus'  => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'staff' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 100
		    );

		    register_post_type( 'staff', $args );

		    $labels = array(
				'name'              => _x('Departments', 'taxonomy general name', 'upside-lite-toolkit'),
				'singular_name'     => _x('Department', 'taxonomy singular name', 'upside-lite-toolkit'),
				'search_items'      => esc_attr__('Search Departments', 'upside-lite-toolkit'),
				'all_items'         => esc_attr__('All Departments', 'upside-lite-toolkit'),
				'parent_item'       => esc_attr__('Parent Department', 'upside-lite-toolkit'),
				'parent_item_colon' => esc_attr__('Parent Department:', 'upside-lite-toolkit'),
				'edit_item'         => esc_attr__('Edit Department', 'upside-lite-toolkit'),
				'update_item'       => esc_attr__('Update Department', 'upside-lite-toolkit'),
				'add_new_item'      => esc_attr__('Add New Department', 'upside-lite-toolkit'),
				'new_item_name'     => esc_attr__('New Department Name', 'upside-lite-toolkit'),
				'menu_name'         => esc_attr__('Departments', 'upside-lite-toolkit'),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_nav_menus' => false,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => 'staff-department'),
			);

			register_taxonomy('staff-department', array('staff'), $args);
		}

		public function manage_colums($columns){	
			$columns = array(
				'cb'                     => esc_attr__('<input type="checkbox" />', 'upside-lite-toolkit'),
				'utp-thumb'              => esc_attr__('Thumb', 'upside-lite-toolkit'),
				'title'                  => esc_attr__('Title', 'upside-lite-toolkit'),
				'staff-department' => esc_attr__('Department', 'upside-lite-toolkit'),
				'date'                   => esc_attr__('Date', 'upside-lite-toolkit'),
			);

			return $columns;	
		}

		public function manage_colum($column){
			global $post;
			switch ($column) {
				case 'utp-thumb':
					if(has_post_thumbnail($post->ID)){
                        upside_lite_the_post_thumbnail($post->ID, 'upside-post-type-thumb', array());
					}
					break;
                case 'staff-department':
                    the_terms($post->ID, 'staff-department');
                    break;
			}
		}

        public function edit_query_staff_archive($query){
            if( !is_admin() && $query->is_main_query() && ( $query->is_post_type_archive('staff') ||  is_tax('staff-department') ) ) {
                $post_per_page = (int) esc_attr( get_theme_mod('upside-member-posts_per-page', '6') );
                if ( $post_per_page ) {
                    $query->query_vars['posts_per_page'] = $post_per_page;
                }
                return $query;
            }
        }

	}

	$Upside_Lite_Toolkit_Staff = new Upside_Lite_Toolkit_Staff();
}