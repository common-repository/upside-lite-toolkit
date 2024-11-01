<?php

if( !class_exists('Upside_Lite_Toolkit_Course') ){

	class Upside_Lite_Toolkit_Course{

		public function __construct(){				
			add_action('init', array($this, 'init'), 0);			
			add_filter('manage_k_course_posts_columns', array($this, 'manage_colums'));
			add_action('manage_k_course_posts_custom_column' , array($this, 'manage_colum'));
            add_action('admin_init', array($this, 'register_metabox'));
            add_action('pre_get_posts', array($this, 'edit_query_course_archive'));
        }

        public function register_metabox(){

            #SPEAKERS
            $utp_speakers = array('' => esc_attr__('-- none --', 'upside-lite-toolkit'));
            $speakers = new WP_Query( array(
                'post_type' => 'staff',
                'post_status'    => array('publish'),
                'posts_per_page' => -1,
            ) );

            if ( $speakers->have_posts() ) {
                while ( $speakers->have_posts() ) {
                    $speakers->the_post();
                    global $post;
                    $utp_speakers[$post->ID] = $post->post_title;
                }
            }
            wp_reset_postdata();


            $utp_course = array(
                array(
                    'title'   => esc_attr__('Course ID', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-id',
                    'desc' => esc_attr__('Enter an unique course ID', 'upside-lite-toolkit')
                ),
                array(
                    'title'   => esc_attr__('Start Date', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-date-start'
                ),
                array(
                    'title'   => esc_attr__('End Date', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-date-end'
                ),
                array(
                    'title'   => esc_attr__('Duration', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-duration',
                    'desc' => esc_attr__('Enter course duration e.g: 3 weeks', 'upside-lite-toolkit')
                ),
                array(
                    'title'   => esc_attr__('Regular Price', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-price',
                    'desc' => esc_attr__('Enter regular price. This is only for the purpose of display.', 'upside-lite-toolkit')
                ),
                array(
                    'title'   => esc_attr__('Sale Price', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-price-sale',
                    'desc' => esc_attr__('Enter sale price. This is only for the purpose of display', 'upside-lite-toolkit')
                ),
                array(
                    'title'   => esc_attr__('Text before price', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-price-text',
                ),
                array(
                    'title'   => esc_attr__('Featured', 'upside-lite-toolkit'),
                    'label'   => esc_attr__('Yes', 'upside-lite-toolkit'),
                    'type'    => 'checkbox',
                    'id'      => 'utp-course-is-featured',
                    'std' => '0'
                ),
                array(
                    'title'   => esc_attr__('Address', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-address'
                ),
                array(
                    'title'   => esc_attr__('Contact Phone', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-phone'
                ),
                array(
                    'title'   => esc_attr__('Contact email', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-email'
                ),
                array(
                    'title'   => esc_attr__('Instructor', 'upside-lite-toolkit'),
                    'type'    => 'multiselect',
                    'id'      => 'utp-course-instructors',
                    'options' => $utp_speakers,
                    'std' => ''
                ),
                array(
                    'title'   => esc_attr__('"Download Button" label', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-btn-download-text',
                    'std' => esc_attr__('Download document', 'upside-lite-toolkit')
                ),
                array(
                    'title'   => esc_attr__('"Download Button" link', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-btn-download-link'
                ),
                array(
                    'title'   => esc_attr__('Link to Woocommerce product', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-product',
                    'std' => '',
                    'desc' => esc_attr__('Enter product ID', 'upside-lite-toolkit')
                ),
                array(
                    'title'   => esc_attr__('"Join Button" Text', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-btn-join-text',
                    'std' => esc_attr__('Join this event', 'upside-lite-toolkit')
                ),
                array(
                    'title'   => esc_attr__('"Join Button" link', 'upside-lite-toolkit'),
                    'type'    => 'text',
                    'id'      => 'utp-course-btn-join-link',
                    'desc' => esc_attr__('Enter the URL you want to redirect to when clicking on "Joint Button" in case you have not linked this course to any Woocommerce product.', 'upside-lite-toolkit')
                ),

            );
            $utp_course = apply_filters('utp_course_custom_attributes', $utp_course);
            $args = array(
                'id'          => 'utp-k-course-options-metabox',
                'title'       => esc_attr__('Course Details', 'upside-lite-toolkit'),
                'desc'        => '',
                'pages'       => array( 'k_course' ),
                'context'     => 'normal',
                'priority'    => 'high',
                'fields'      => $utp_course
            );

            kopa_register_metabox( $args );
        }

		public function init(){

			$labels = array(
				'name'               => _x( 'Courses', 'post type general name', 'upside-lite-toolkit' ),
				'singular_name'      => _x( 'Course', 'post type singular name', 'upside-lite-toolkit' ),
				'menu_name'          => _x( 'Courses', 'admin menu', 'upside-lite-toolkit' ),
				'name_admin_bar'     => _x( 'Course', 'add new on admin bar', 'upside-lite-toolkit' ),
				'add_new'            => _x( 'Add New', 'k_course', 'upside-lite-toolkit' ),
				'add_new_item'       => esc_attr__( 'Add New Course', 'upside-lite-toolkit' ),
				'new_item'           => esc_attr__( 'New Course', 'upside-lite-toolkit' ),
				'edit_item'          => esc_attr__( 'Edit Course', 'upside-lite-toolkit' ),
				'view_item'          => esc_attr__( 'View Course', 'upside-lite-toolkit' ),
				'all_items'          => esc_attr__( 'All Courses', 'upside-lite-toolkit' ),
				'search_items'       => esc_attr__( 'Search Courses', 'upside-lite-toolkit' ),
				'parent_item_colon'  => esc_attr__( 'Parent Courses:', 'upside-lite-toolkit' ),
				'not_found'          => esc_attr__( 'No courses found.', 'upside-lite-toolkit' ),
				'not_found_in_trash' => esc_attr__( 'No courses found in Trash.', 'upside-lite-toolkit' )
			);

			$args = array(
				'menu_icon'          => 'dashicons-admin-network',
				'public'             => true,	      
				'labels'             => $labels,
				'supports'           => array('title', 'thumbnail', 'editor', 'comments', 'author'),
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
                'show_in_nav_menus'  => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'k_course' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 100
		    );

		    register_post_type('k_course', $args);

		    $labels = array(
				'name'              => _x('Course Categories', 'taxonomy general name', 'upside-lite-toolkit'),
				'singular_name'     => _x('Category', 'taxonomy singular name', 'upside-lite-toolkit'),
				'search_items'      => esc_attr__('Search Categories', 'upside-lite-toolkit'),
				'all_items'         => esc_attr__('All Categories', 'upside-lite-toolkit'),
				'parent_item'       => esc_attr__('Parent Category', 'upside-lite-toolkit'),
				'parent_item_colon' => esc_attr__('Parent Category:', 'upside-lite-toolkit'),
				'edit_item'         => esc_attr__('Edit Category', 'upside-lite-toolkit'),
				'update_item'       => esc_attr__('Update Category', 'upside-lite-toolkit'),
				'add_new_item'      => esc_attr__('Add New Category', 'upside-lite-toolkit'),
				'new_item_name'     => esc_attr__('New Category Name', 'upside-lite-toolkit'),
				'menu_name'         => esc_attr__('Categories', 'upside-lite-toolkit'),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_nav_menus' => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => 'course-category'),
			);

			register_taxonomy('course-category', array('k_course'), $args);
		}

		public function manage_colums($columns){	
			$columns = array(
				'cb'                     => esc_attr__('<input type="checkbox" />', 'upside-lite-toolkit'),
				'utp-thumb'              => esc_attr__('Thumb', 'upside-lite-toolkit'),
				'title'                  => esc_attr__('Title', 'upside-lite-toolkit'),
				'taxonomy-course-category' => esc_attr__('Categories', 'upside-lite-toolkit'),
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
                case 'taxonomy-course-category';
                    the_terms($post->ID, 'course-category');
                    break;

			}
		}

        public function edit_query_course_archive($query){

            if ( !is_admin() ) {
                if ( $query->is_post_type_archive('k_course') || is_tax('course-category') ) {
                    $post_per_page = (int) esc_attr( get_theme_mod('upside-course-posts_per-page', '6') );
                    if ( $post_per_page ) {
                        $query->query_vars['posts_per_page'] = $post_per_page;
                    }
                    return $query;
                } elseif ( $query->is_main_query() ) {
                    if ( isset($_GET['type']) && 'k_course' == $_GET['type'] ) {
                        $search_params = upside_lite_get_search_param();
                        $tax_query = array();
                        $meta_query = array();
                        foreach ( $search_params as $param ) {
                            if ( isset($_GET[$param['id']]) ) {
                                $search_value = $_GET[$param['id']];
                            }

                            if ( isset($search_value) && ! empty($search_value) ) {
                                switch ( $param['data'] ) {
                                    case 'metabox':
                                        $meta_query[] = array(
                                            'key' => $param['id'],
                                            'value'   => $search_value,
                                            'compare' => 'LIKE',
                                        );
                                        break;

                                    case 'taxonomy':
                                        $tax_query[] = array(
                                            'taxonomy' => $param['data-source'],
                                            'field'    => 'slug',
                                            'terms'    => $search_value
                                        );
                                        break;
                                }
                            }
                        }
                        if ( $tax_query ) {
                            $query->set( 'tax_query', $tax_query );
                        }
                        if ( $meta_query ) {
                            $query->set( 'meta_query', $meta_query);
                        }

                        $query->set('post_type', 'k_course');
                    }
                }
                return $query;
            }

        }

        public function add_image_size(){
            add_image_size( 'upside-post-type-thumb', 60, 60, true );
        }

	}

	$upside_lite_toolkit_course = new Upside_Lite_Toolkit_Course();
    $upside_lite_toolkit_course->add_image_size();
}