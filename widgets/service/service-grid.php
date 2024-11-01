<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Service_Grid', 'register_block'));
class Upside_Lite_Toolkit_Widget_Service_Grid extends Kopa_Widget {

	public $kpb_group = 'service';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Service_Grid'] = new Upside_Lite_Toolkit_Widget_Service_Grid();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-service-2-widget';
		$this->widget_description = esc_attr__('Display the services grid.', 'upside-lite-toolkit');
		$this->widget_id          = 'service-grid-widget';
		$this->widget_name        = esc_attr__( '(Upside lite) Service Grid', 'upside-lite-toolkit' );

        $tag_terms = get_terms( 'service-tag', array(
            'hide_empty' => false,
        ) );
        $tag_options = array( '' => esc_attr__( '---- All ----', 'upside-lite-toolkit' ) );
        if ( $tag_terms ) {
            foreach ( $tag_terms as $term ) {
                $tag_options[ $term->term_id ] = $term->name;
            }
        }

        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Title', 'upside-lite-toolkit'),
            ),
            'content' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_attr__('Description', 'upside-lite-toolkit'),
            ),
            'tag_ids' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => esc_attr__('Service tags', 'upside-lite-toolkit'),
                "desc" => esc_attr__('Hold Ctrl to choose multiple values', 'upside-lite-toolkit'),
                'options' => $tag_options
            ),
            'total_item' => array(
                'type' => 'text',
                'std' => '3',
                'label' => esc_attr__('Number of items', 'upside-lite-toolkit')
            ),
            'element_width' => array(
                'type'    => 'select',
                'label'   => esc_attr__( 'Number of columns', 'upside-lite-toolkit' ),
                'std'     => '4',
                'options' => array(
                    '2' => '6',
                    '3' => '4',
                    '4' => '3',
                    '6' => '2',
                    '12' => '1',
                )
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
                    'ID' => esc_attr__( 'ID', 'upside-lite-toolkit' ),
                    'title' => esc_attr__( 'Title', 'upside-lite-toolkit' ),
                ),
            ),
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
        extract( $instance );
        echo $before_widget;
        if ( ! empty($title) ): ?>
            <div class="widget-title widget-title-s5 text-center">
                <span></span>
                <h2><?php echo esc_html($title); ?></h2>

                <?php if ( ! empty($content) ) : ?>
                    <p><?php echo wp_kses_post($content); ?></p>
                <?php endif; ?>

            </div>
        <?php endif;
            $tag_count = count ( $tag_ids );
            if ( 1 === $tag_count && '' === $tag_ids[0] ) {
                $up_tags = array();
            } else {
               $up_tags = $tag_ids;
            }

            if ( !empty($tag_slugs) ) {
                $up_tags = explode(',', $tag_slugs);
            }
            $query = array(
                'post_type'      => array('service'),
                'posts_per_page' => (int)$total_item,
                'post_status'    => array('publish'),
                'order'          => isset( $order ) ?  $order : 'DESC',
                'orderby'        => isset( $orderby ) ? $orderby : 'date',
            );

            if ( $up_tags ) {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'service-tag',
                        'field'    => 'id',
                        'terms'    => $up_tags
                    ),
                );
            }

            $results = new WP_Query( $query );
            if ( $results->have_posts() ) : ?>
                <div class="widget-content">
                    <div class="row">
                        <?php
                            while ( $results->have_posts() ) :
                                $results->the_post();
                                $service_linkto = get_post_meta(get_the_ID(), 'upside_service_linkto', true);
                                $service_icon = get_post_meta(get_the_ID(), 'upside_service_icon', true);
                                $service_subtitle = get_post_meta(get_the_ID(), 'upside_service_subtitle', true);
                                $service_title = get_the_title();
                                $service_excerpt = get_the_excerpt();
                            ?>
                                <div class="col-md-<?php echo esc_attr($element_width); ?> col-sm-4 col-xs-12">
                                    <article class="entry-item clearfix">
                                        <?php if ( ! empty($service_icon) ) : ?>
                                        <div class="entry-thumb"><i class="<?php echo esc_attr($service_icon); ?>"></i></div>
                                        <?php endif; ?>

                                        <div class="entry-content">
                                            <?php if ( ! empty($service_title) ) : ?>
                                            <h5 class="entry-title">
                                                <?php if ( '' !== $service_subtitle ) : ?>
                                                    <span><?php echo esc_html( $service_subtitle);?></span>
                                                <?php endif; ?>
                                                <a href="<?php echo esc_url($service_linkto); ?>"><?php echo esc_html($service_title); ?></a></h5>
                                            <?php endif; ?>
                                            <?php
                                            if ( ! empty($service_excerpt) ) {
                                                echo sprintf('<p>%s</p>', wp_kses_post($service_excerpt));
                                            }
                                            ?>
                                        </div>
                                    </article>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        ?>
                    </div>
                </div>
        <?php
            endif;
        echo $after_widget;
	}

}