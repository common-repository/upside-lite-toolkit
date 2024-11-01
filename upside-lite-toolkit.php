<?php
/*
Plugin Name: Upside Lite Toolkit
Description: A specific plugin use in Upside Lite Theme, included some custom post types,widgets and shortcodes.
Version: 1.0.3
Author: Kopa Theme
Author URI: http://kopatheme.com
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Upside Lite Toolkit plugin, Copyright 2015 Kopatheme.com
Upside Lite Toolkit is distributed under the terms of the GNU GPL

Requires at least: 4.4
Tested up to: 4.6.1
Text Domain: upside-lite-toolkit
Domain Path: /languages/
*/

define('ULT_DIR', plugin_dir_url(__FILE__));
define('ULT_PATH', plugin_dir_path(__FILE__));

add_action('plugins_loaded', array('Upside_Lite_Toolkit', 'plugins_loaded'));
add_action('after_setup_theme', array('Upside_Lite_Toolkit', 'after_setup_theme'), 20 );

class Upside_Lite_Toolkit {

	function __construct(){

		require ULT_PATH . 'hook.php';
		require ULT_PATH . 'api/menu-item-custom-fields/menu-item-custom-fields.php';

    /**
     * Custom post type
     */
    require ULT_PATH . 'post-types/course.php';
    require ULT_PATH . 'post-types/staff.php';
    require ULT_PATH . 'post-types/service.php';
    require ULT_PATH . 'post-types/customer.php';
    require ULT_PATH . 'post-types/document.php';
    require ULT_PATH . 'post-types/megamenu.php';
    require ULT_PATH . 'post-types/slide.php';

    /**
     * Widgets
     */
    require ULT_PATH . 'widgets/miscellaneous/introduce.php';
    require ULT_PATH . 'widgets/miscellaneous/featured-content-simple.php';
    require ULT_PATH . 'widgets/miscellaneous/featured-content.php';
    require ULT_PATH . 'widgets/miscellaneous/list-document.php';
    require ULT_PATH . 'widgets/miscellaneous/custom-nav.php';

    require ULT_PATH . 'widgets/post/list-posts-1.php';
    require ULT_PATH . 'widgets/post/list-posts-2.php';
    require ULT_PATH . 'widgets/post/list-posts-3.php';
    require ULT_PATH . 'widgets/post/single-post.php';
    require ULT_PATH . 'widgets/post/recent-comments.php';


    require ULT_PATH . 'widgets/course/search.php';
    require ULT_PATH . 'widgets/course/list-courses.php';
    require ULT_PATH . 'widgets/course/tab-courses.php';
    require ULT_PATH . 'widgets/course/featured-courses.php';

    require ULT_PATH . 'widgets/tagline/advertisement.php';
    require ULT_PATH . 'widgets/tagline/tagline.php';
    require ULT_PATH . 'widgets/tagline/tagline2.php';

    require ULT_PATH . 'widgets/contact/newsletter-feedburner.php';
    require ULT_PATH . 'widgets/contact/social-links.php';
    require ULT_PATH . 'widgets/contact/contact-info.php';
    require ULT_PATH . 'widgets/contact/google-map.php';

    require ULT_PATH . 'widgets/service/service-grid.php';
    require ULT_PATH . 'widgets/staff/staff-carousel.php';
    require ULT_PATH . 'widgets/customer/customer-carousel.php';
    
    require ULT_PATH . 'widgets/slider/owl-slider.php';

    #SHORTCODE
    require ULT_PATH . 'shortcodes/shortcode.php';

    #add job to user's profile
    if ( is_admin() ) {
    	add_filter('user_contactmethods', 'upside_lite_toolkit_modify_user_profile');
    	add_action('admin_init', 'upside_lite_toolkit_register_metabox_post_featured');
    }

    add_action('upside_lite_add_profile_share_follow', 'upside_lite_toolkit_show_profile_share_follow');
    add_action('upside_lite_add_single_follow', 'upside_lite_toolkit_show_single_follow');

    add_filter('widget_text', 'do_shortcode');
  }

  public static function plugins_loaded(){
  	load_plugin_textdomain('upside-lite-toolkit', false, ULT_PATH . '/languages/');
  }

  public static function after_setup_theme(){
  	if ( !class_exists('Kopa_Framework') )
  		return; 		
  	else	
  		new Upside_Lite_Toolkit();
  }

}