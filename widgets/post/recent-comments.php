<?php
add_action( 'widgets_init', array('Upside_Lite_Toolkit_Widget_Recent_Comment', 'register_widget'));
class Upside_Lite_Toolkit_Widget_Recent_Comment extends Kopa_Widget {

	public $kpb_group = 'post';

    public static function register_widget(){
        register_widget('Upside_Lite_Toolkit_Widget_Recent_Comment');
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-recent-comment-widget';
		$this->widget_description = esc_attr__('Display recent comments.', 'upside-lite-toolkit');
		$this->widget_id          = 'upside-recent-comment';
		$this->widget_name        = esc_attr__( '(Upside lite) Recent Comments', 'upside-lite-toolkit' );

        $this->settings = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => esc_attr__( 'Recent Comments', 'upside-lite-toolkit' ),
                'label' => esc_attr__( 'Title:', 'upside-lite-toolkit' ),
            ),
            'number' => array(
                'type'    => 'number',
                'std'     => 2,
                'label'   => esc_attr__( 'Number of items:', 'upside-lite-toolkit' ),
                'min'     => '1',
            ),
            'show_post_title' => array(
                'type'    => 'checkbox',
                'std'     => '1',
                'label'   => esc_attr__( 'Show post title', 'upside-lite-toolkit' ),
            )
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		ob_start();

		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		extract( $instance );

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_attr__( 'Recent Comments', 'upside-lite-toolkit' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 2;
        if ( ! $number )
            $number = 2;

        $comments = get_comments( apply_filters( 'widget_comments_args', array(
            'number'      => $number,
            'status'      => 'approve',
            'post_status' => 'publish'
        ) ) );

		echo $before_widget;

        if ( ! empty($title) ) : ?>
            <h4 class="widget-title widget-title-s10"><?php echo esc_html($title); ?></h4>
        <?php endif;

        if ( $comments ) :	?>

            <ul class="clearfix">
                <?php
                    foreach ( (array) $comments as $comment):
                        $author_url = get_the_author_meta('url');
                        $author_job = get_the_author_meta('job');
                        $author_company = get_the_author_meta('company');
                ?>
                    <li>
                        <article class="comment-item">
                            <div class="comment-content cleafix">
                                <i class="fa fa-comment-o pull-left"></i>
                                <p><?php echo wp_kses_post($comment->comment_content); ?></p>
                            </div>
                            <div class="comment-author clearfix">
                                <div class="comment-avatar pull-left">
                                    <a href="<?php echo esc_url($author_url); ?>" target="_blank"><?php echo get_avatar($comment->comment_author_email, 40); ?></a>
                                </div>
                                <div class="comment-name">
                                    <h6><a href="<?php echo esc_url($author_url); ?>" target="_blank"><?php echo esc_html($comment->comment_author); ?></a>
                                        <?php if ( 1 == $show_post_title) : ?>
                                            <?php esc_html_e('on ', 'upside-lite-toolkit'); ?><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php echo esc_html(get_the_title( $comment->comment_post_ID )); ?></a>
                                        <?php endif; ?>
                                    </h6>
                                    <?php if ( ! empty($author_job) || ! empty($author_company) ) : ?>
                                        <em><?php echo esc_html($author_job); ?> @ <?php echo esc_html($author_company); ?></em>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    </li>
                <?php endforeach; ?>
            </ul>

			<?php
		endif;

		wp_reset_postdata();

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;		
	}

}