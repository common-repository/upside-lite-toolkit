<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Single_Post', 'register_block'));
class Upside_Lite_Toolkit_Widget_Single_Post extends Kopa_Widget {
    public $kpb_group = 'post';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Single_Post'] = new Upside_Lite_Toolkit_Widget_Single_Post();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-article-list-1-widget';
        $this->widget_description = esc_attr__( 'Display a post by ID.', 'upside-lite-toolkit' );
        $this->widget_id          = 'kopa-article-list-1-widget';
        $this->widget_name        = esc_attr__( '(Upside lite) Single post', 'upside-lite-toolkit' );

        $this->settings           = array(
            'post_id' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Post ID', 'upside-lite-toolkit'),
                "desc" => sprintf( '%s  http://localhost/upside/wp-admin/post.php?post=<code>1</code>&action=edit, %s', esc_attr__( 'Enter id of post to show. Example, if your detail URL of post is', 'upside-lite-toolkit' ), esc_attr__( 'you need to enter "1" to above text box.', 'upside-lite-toolkit' ) ),
            )
        );
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );
        extract( $instance );

        if ( $post_id ) :
            $upside_post = get_post((int)$post_id);
            if ( $upside_post ) :
                $upside_format = get_post_format($post_id);
                if ( false == $upside_format ) {
                    $upside_format = 'standard';
                }
                ?>

            <div class="widget kopa-article-list-1-widget">

                <div class="widget-content">
                    <article class="entry-item <?php echo esc_attr($upside_format); ?>-post">
                        <div class="entry-thumb">
                            <div class="mask"></div>
                            <?php
                                if ( has_post_thumbnail($post_id) ) {
                                    upside_lite_the_post_thumbnail( $post_id, 'upside-featured-post-350-210' );
                                }
                            if ( ! empty( $upside_post->post_title ) ) : ?>
                            <h6 class="entry-title"><a href="<?php echo esc_url(get_permalink($upside_post)); ?>" title="<?php echo wp_kses_post($upside_post->post_title); ?>"><?php echo wp_kses_post($upside_post->post_title); ?></a></h6>
                            <?php endif; ?>
                            <a href="<?php echo esc_url(get_permalink($upside_post)); ?>" class="entry-icon" title="<?php echo wp_kses_post($upside_post->post_title); ?>"><span></span></a>
                        </div>
                        <div class="entry-content">

                            <header class="clearfix">
                                <span class="entry-time pull-left"><?php echo esc_html('At ', 'upside-lite-toolkit'); ?><?php echo esc_html( get_the_date(get_option('time_format'), $post_id) ); ?></span>
                                <span class="entry-meta pull-left">&nbsp;/&nbsp;</span>
                                <?php get_template_part( 'template/parts/common/author' ); ?>
                            </header>
                            <?php
                            if ( ! empty( $upside_post->post_excerpt ) ){
                                echo sprintf( '<p>%s</p>', wp_kses_post($upside_post->post_excerpt) );
                            }
                            ?>
                            <a href="<?php echo esc_url(get_permalink($upside_post)); ?>" title="<?php echo wp_kses_post($upside_post->post_title); ?>" class="more-link clearfix"><span class="pull-left"><?php echo esc_html__('Read more', 'upside-lite-toolkit'); ?></span><i class="fa fa-angle-right pull-left"></i></a>
                        </div>
                    </article>
                </div>

            </div>

            <?php
            endif;
        endif;

        $content = ob_get_clean();
        echo $content;
    }

}
