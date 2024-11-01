<?php
function upside_toolkit_get_shortcode($content, $enable_multi = false, $shortcodes = array()) {

    $codes         = array();
    $regex_matches = '';
    $regex_pattern = get_shortcode_regex();

    preg_match_all('/' . $regex_pattern . '/s', $content, $regex_matches);

    foreach ($regex_matches[0] as $shortcode) {
        $regex_matches_new = '';
        preg_match('/' . $regex_pattern . '/s', $shortcode, $regex_matches_new);

        if (in_array($regex_matches_new[2], $shortcodes)) :
            $codes[] = array(
                'shortcode' => $regex_matches_new[0],
                'type'      => $regex_matches_new[2],
                'content'   => $regex_matches_new[5],
                'atts'      => shortcode_parse_atts($regex_matches_new[3])
            );

            if (false == $enable_multi) {
                break;
            }
        endif;
    }

    return $codes;
}

/*
* --------------------------------------------------
* Get default profile socials
* --------------------------------------------------
*/
function upside_lite_toolkit_get_profile_socials() {
    $socials = array(
        'facebook' => array(
            'class' => 'fa fa-facebook',
            'title' => esc_attr__('Facebook', 'upside-lite-toolkit')
        ),
        'twitter' => array(
            'class' => 'fa fa-twitter',
            'title' => esc_attr__('Twitter', 'upside-lite-toolkit')
        ),
        'google' => array(
            'class' => 'fa fa-google-plus',
            'title' => esc_attr__('Google plus', 'upside-lite-toolkit')
        ),
        'instagram' => array(
            'class' => 'fa fa-instagram',
            'title' => esc_attr__('Instagram', 'upside-lite-toolkit')
        ),
    );
    return apply_filters('upside_filter_socials', $socials);
}

/*
* --------------------------------------------------
* Custom user profile
* --------------------------------------------------
*/
function upside_lite_toolkit_modify_user_profile($profile_fields) {
    $profile_fields['job'] = esc_attr__('Job', 'upside-lite-toolkit');
    $profile_fields['company'] = esc_attr__('Company', 'upside-lite-toolkit');
    $socials = upside_lite_toolkit_get_profile_socials();
    if ( $socials ) {
        foreach ( $socials as $key => $social ) {
            $profile_fields[$key] = $social['title'];
        }
    }

    return $profile_fields;
}

function upside_lite_toolkit_show_profile_share_follow(){
    $socials = upside_lite_toolkit_get_profile_socials();
    if ( $socials ) : ?>
        <ul class="social-links clearfix">
            <?php
            foreach ( $socials as $k => $v ) {
                $key_value = get_the_author_meta($k);
                if ( ! empty($key_value) ) {
                    echo sprintf('<li><a class="%s" href="%s" rel="nofollow" target="_blank"></a></li>', esc_attr($v['class']), esc_url($key_value));
                }
            }
            ?>
        </ul>
    <?php endif;
}

function upside_lite_toolkit_show_single_follow(){
    $author_socials = upside_lite_get_profile_socials();
    $upside_have_social_choosed = false;
    $ups_author = esc_attr( get_theme_mod('course_single_author', '1') );
    if ( $author_socials ) {
        foreach ( $author_socials as $k => $v ) {
            $key_value = get_the_author_meta($k);
            if ( ! empty($key_value) ) {
                $upside_have_social_choosed = true;
                break;
            }
        }
    }

    if ( $author_socials && 1 == $ups_author && $upside_have_social_choosed ) : ?>
        <div class="social-box clearfix">
            <span class="pull-left"><?php esc_html_e('Follows:', 'upside-lite-toolkit'); ?></span>
            <ul class="social-links pull-right">
                <?php
                foreach ( $author_socials as $k => $v ) {
                    $key_value = get_the_author_meta($k);
                    if ( ! empty($key_value) ) {
                        echo sprintf('<li><a class="%s" href="%s" rel="nofollow" target="_blank"></a></li>', esc_attr($v['class']), esc_url($key_value));
                    }
                }
                ?>
            </ul>
        </div>
        <!-- social-box -->
    <?php endif;
}

function upside_lite_toolkit_set_excerpt_length($length) {
    $length = $GLOBALS['upside_excerpt_length'];
    return $length;
}

/*
* --------------------------------------------------
* Build params for query
* --------------------------------------------------
*/
function upside_lite_toolkit_get_post_widget_query( $atts ){
    $query = array(
        'post_type'      => 'post',
        'posts_per_page' => isset( $atts['number'] ) ? $atts['number'] : 12 ,
        'order'          => isset( $atts['order'] ) ?  $atts['order'] : 'DESC',
        'orderby'        => isset( $atts['orderby'] ) ? $atts['orderby'] : 'date',
        'ignore_sticky_posts' => true
    );
    if ( isset($atts['categories']) && ! empty($atts['categories']) ) {
        if ( 1 === count($atts['categories']) && ! empty($atts['categories'][0]) ) {
            $query['tax_query'][] = array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $atts['categories'],
            );
        }
    }

    if ( isset($atts['tags']) && ! empty($atts['tags']) ) {
        if ( 1 === count($atts['tags']) && ! empty($atts['tags'][0]) ) {
            $query['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field'    => 'slug',
                'terms'    => $atts['tags'],
            );
        }
    }

    if ( isset( $query['tax_query'] ) &&
        count( $query['tax_query'] ) === 2 ) {
        $query['tax_query']['relation'] = 'OR';
    }

    if ( isset($atts['post_format']) && !empty($atts['post_format']) ) {
        $query['tax_query'][] = array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array( $atts['post_format'] )
        );
    }
    return apply_filters( 'upside_lite_toolkit_get_post_widget_query', $query );
}

/*
* --------------------------------------------------
* Get widget args for get posts
* Use for widget
* --------------------------------------------------
*/
function upside_lite_toolkit_get_post_widget_args($title_default = '', $number = '5'){

    $all_cats = get_categories();
    $categories = array('' => esc_attr__('-- none --', 'upside-lite-toolkit'));
    foreach ( $all_cats as $cat ) {
        $categories[ $cat->slug ] = $cat->name;
    }

    $all_tags = get_tags();
    $tags = array('' => esc_attr__('-- none --', 'upside-lite-toolkit'));
    foreach( $all_tags as $tag ) {
        $tags[ $tag->slug ] = $tag->name;
    }

    return array(
        'title'  => array(
            'type'  => 'text',
            'std'   => $title_default,
            'label' => esc_attr__( 'Title:', 'upside-lite-toolkit' ),
        ),
        'categories' => array(
            'type'    => 'multiselect',
            'std'     => '',
            'label'   => esc_attr__( 'Categories:', 'upside-lite-toolkit' ),
            'options' => $categories,
            'size'    => '5',
        ),
        'relation'    => array(
            'type'    => 'select',
            'label'   => esc_attr__( 'Relation:', 'upside-lite-toolkit' ),
            'std'     => 'OR',
            'options' => array(
                'AND' => esc_attr__( 'AND', 'upside-lite-toolkit' ),
                'OR'  => esc_attr__( 'OR', 'upside-lite-toolkit' ),
            ),
        ),
        'tags' => array(
            'type'    => 'multiselect',
            'std'     => '',
            'label'   => esc_attr__( 'Tags:', 'upside-lite-toolkit' ),
            'options' => $tags,
            'size'    => '5',
        ),
        'order' => array(
            'type'  => 'select',
            'std'   => 'DESC',
            'label' => esc_attr__( 'Order:', 'upside-lite-toolkit' ),
            'options' => array(
                'ASC'  => esc_attr__( 'ASC', 'upside-lite-toolkit' ),
                'DESC' => esc_attr__( 'DESC', 'upside-lite-toolkit' ),
            ),
        ),
        'orderby' => array(
            'type'  => 'select',
            'std'   => 'date',
            'label' => esc_attr__( 'Ordered by:', 'upside-lite-toolkit' ),
            'options' => array(
                'date'          => esc_attr__( 'Date', 'upside-lite-toolkit' ),
                'rand'          => esc_attr__( 'Random', 'upside-lite-toolkit' ),
                'comment_count' => esc_attr__( 'Number of comments', 'upside-lite-toolkit' ),
            ),
        ),
        'number' => array(
            'type'    => 'number',
            'std'     => $number,
            'label'   => esc_attr__( 'Number of posts:', 'upside-lite-toolkit' ),
            'min'     => '1',
        ),
        'excerpt_length' => array(
            'type'    => 'number',
            'std'     => 55,
            'label'   => esc_attr__( 'Exerpt length. E.g: 55:', 'upside-lite-toolkit' ),
            'min'     => '1',
        )
    );
}

function upside_lite_toolkit_register_metabox_post_featured() {
    if ( function_exists( 'kopa_register_metabox' ) ) {

        $fields = array(
            array(
                'title' => esc_attr__('Show page title', 'upside-lite-toolkit'),
                'type'  => 'checkbox',
                'default' => 1,
                'id'    =>  'upside-show-page-title',
            ),
            array(
                'title' => esc_attr__('Show breadcrumb', 'upside-lite-toolkit'),
                'type'  => 'checkbox',
                'default' => 1,
                'id'    => 'upside-show-breadcrumb'
            ),
            array(
                'title' => esc_attr__('Custom page title', 'upside-lite-toolkit'),
                'type'  => 'text',
                'id'    =>  'upside-page-title',
                'desc'  => esc_attr__('If you do not want to use the above page title, you can enter any word here to replace that.', 'upside-lite-toolkit'),
            ),
            array(
                'title' => esc_attr__('Page description', 'upside-lite-toolkit'),
                'type'  => 'textarea',
                'id'    => 'upside-page-description',
                'desc'  => esc_attr__('Enter the page description, it will be shown under the page title.', 'upside-lite-toolkit'),
            )
        );


        $document_search = array(
            'title' => esc_attr__('Show document search', 'upside-lite-toolkit'),
            'type'  => 'checkbox',
            'id'    => 'upside-page-show-document-search',
			'desc'  => esc_attr__('This option is to show document search box on the page title area. This is designed for document page.', 'upside-lite-toolkit'),
        );
        $fields[] = $document_search;

        $args = array(
            'id'       => 'upside-pages-options',
            'title'    => esc_attr__('Page Options', 'upside-lite-toolkit'),
            'desc'     => '',
            'pages'    => array('post', 'page'),
            'context'  => 'normal',
            'priority' => 'low',
            'fields'   => $fields
        );

        kopa_register_metabox( $args );

        $post_fields = array(
            array(
                'title' => esc_attr__('Gallery:', 'upside-lite-toolkit'),
                'type'  => 'gallery',
                'id'    =>  'matteritix_gallery',
                'desc'  => esc_attr__('This option only apply for post-format "Gallery".', 'upside-lite-toolkit'),
            ),
            array(
                'title' => esc_attr__('Custom content:', 'upside-lite-toolkit'),
                'type'  => 'textarea',
                'id'    => 'matteritix_custom',
                'desc'  => esc_attr__('Enter custom content as shortcode or custom HTML, ...', 'upside-lite-toolkit'),
            )
        );

        $args = array(
            'id'       => 'upside-post-options-metabox',
            'title'    => esc_attr__('Featured content', 'upside-lite-toolkit'),
            'desc'     => '',
            'pages'    => array('post'),
            'context'  => 'normal',
            'priority' => 'low',
            'fields'   => $post_fields
        );

        kopa_register_metabox( $args );

        $fields = array();
        $sizes = array();
        if ( function_exists('') ) {
            $sizes = upside_lite_get_image_sizes();
        }

        if ( $sizes ) {
            foreach( $sizes as $image ) {
                if ( isset($image['enable_custom']) && $image['enable_custom'] ) {
                    $fields[] = array(
                        'title'   => $image['widget_title'],
                        'type'    => 'upload',
                        'id'      => $image['slug'],
                        'desc'    => $image['widget_description'],
                        'mimes'   => 'image',
                    );
                }
            }
        }

        $args = array(
            'id'          => 'upside_post_feature_imgage_size',
            'title'       => esc_attr__('Custom featured image size','upside-lite-toolkit'),
            'desc'        => '',
            'pages'       => array( 'post' ),
            'context'     => 'normal',
            'priority'    => 'low',
            'fields'      => $fields
        );

        kopa_register_metabox( $args );
    }
}

function upside_lite_toolkit_get_default_image($image_slug, $attributes = array(), $echo = true){
    if ( ! isset($attributes['alt']) ) {
        $attributes['alt'] = '';
    }
    $temp_image = upside_lite_get_image_info($image_slug);
    $image_info = array();
    if ( isset($temp_image['info'] ) ) {
        $image_info = $temp_image['info'];
    }
    $image = '';

    if(!empty($image_info)){
        $str_attributes = '';
        if(!empty($attributes)){

            foreach ($attributes as $key => $value) {
                $str_attributes .= sprintf(" %s='%s'", $key, $value);
            }
        }

        $image = apply_filters('upside_get_default_image', sprintf('<img src="//placehold.it/%sx%s" %s>', $image_info[0], $image_info[1], $str_attributes), $image_info, $attributes, $echo);
    }

    if($echo)
        echo wp_kses_post($image);
    else
        return $image;
}

/*
* --------------------------------------------------
* Get widget args for get posts
* Use for widget
* --------------------------------------------------
*/
function upside_get_post_widget_args($title_default = '', $number = '5'){

    $all_cats = get_categories();
    $categories = array('' => esc_attr__('-- none --', 'upside-lite-toolkit'));
    foreach ( $all_cats as $cat ) {
        $categories[ $cat->slug ] = $cat->name;
    }

    $all_tags = get_tags();
    $tags = array('' => esc_attr__('-- none --', 'upside-lite-toolkit'));
    foreach( $all_tags as $tag ) {
        $tags[ $tag->slug ] = $tag->name;
    }

    return array(
        'title'  => array(
            'type'  => 'text',
            'std'   => $title_default,
            'label' => esc_attr__( 'Title:', 'upside-lite-toolkit' ),
        ),
        'categories' => array(
            'type'    => 'multiselect',
            'std'     => '',
            'label'   => esc_attr__( 'Categories:', 'upside-lite-toolkit' ),
            'options' => $categories,
            'size'    => '5',
        ),
        'relation'    => array(
            'type'    => 'select',
            'label'   => esc_attr__( 'Relation:', 'upside-lite-toolkit' ),
            'std'     => 'OR',
            'options' => array(
                'AND' => esc_attr__( 'AND', 'upside-lite-toolkit' ),
                'OR'  => esc_attr__( 'OR', 'upside-lite-toolkit' ),
            ),
        ),
        'tags' => array(
            'type'    => 'multiselect',
            'std'     => '',
            'label'   => esc_attr__( 'Tags:', 'upside-lite-toolkit' ),
            'options' => $tags,
            'size'    => '5',
        ),
        'order' => array(
            'type'  => 'select',
            'std'   => 'DESC',
            'label' => esc_attr__( 'Order:', 'upside-lite-toolkit' ),
            'options' => array(
                'ASC'  => esc_attr__( 'ASC', 'upside-lite-toolkit' ),
                'DESC' => esc_attr__( 'DESC', 'upside-lite-toolkit' ),
            ),
        ),
        'orderby' => array(
            'type'  => 'select',
            'std'   => 'date',
            'label' => esc_attr__( 'Ordered by:', 'upside-lite-toolkit' ),
            'options' => array(
                'date'          => esc_attr__( 'Date', 'upside-lite-toolkit' ),
                'rand'          => esc_attr__( 'Random', 'upside-lite-toolkit' ),
                'comment_count' => esc_attr__( 'Number of comments', 'upside-lite-toolkit' ),
            ),
        ),
        'number' => array(
            'type'    => 'number',
            'std'     => $number,
            'label'   => esc_attr__( 'Number of posts:', 'upside-lite-toolkit' ),
            'min'     => '1',
        )
    );
}