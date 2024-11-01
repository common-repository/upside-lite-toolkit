<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Customer_Carousel', 'register_block'));
class Upside_Lite_Toolkit_Widget_Customer_Carousel extends Kopa_Widget {

	public $kpb_group = 'customer';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Customer_Carousel'] = new Upside_Lite_Toolkit_Widget_Customer_Carousel();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'kopa-ads-3-widget';
		$this->widget_description = esc_attr__('Display logo of customer with carousel slider.', 'upside-lite-toolkit');
		$this->widget_id          = 'upside-lite-toolkit-customer-carousel-widget';
		$this->widget_name        = esc_attr__( '(Upside lite) Customer logo', 'upside-lite-toolkit' );

        $customer_tags = get_terms( 'customer-tag', array(
            'hide_empty' => false,
        ) );
        $customer_tags_options = array( '' => esc_attr__( '---- All ----', 'upside-lite-toolkit' ) );
        if ( $customer_tags ) {
            foreach ( $customer_tags as $term ) {
                $customer_tags_options[ $term->term_id ] = $term->name;
            }
        }

        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_attr__('Title', 'upside-lite-toolkit'),
            ),
            'description' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_attr__('Description', 'upside-lite-toolkit'),
            ),
            'customer_tag' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => esc_attr__('Customer tags', 'upside-lite-toolkit'),
                "desc" => esc_attr__('Hold Ctrl to choose multiple values', 'upside-lite-toolkit'),
                'options' => $customer_tags_options
            ),
            'total_item' => array(
                'type' => 'text',
                'std' => '6',
                'label' => esc_attr__('Number of items', 'upside-lite-toolkit')
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
                    'ID' => esc_attr__( 'ID', 'upside-lite-toolkit' ),
                ),
            ),
        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {	
		extract( $args );
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
        extract( $instance );

        $upside_query = array(
            'post_type'      => array('customer'),
            'posts_per_page' => (int) $total_item,
            'post_status'    => array('publish'),
            'order'          => isset( $order ) ?  $order : 'DESC',
            'orderby'        => isset( $orderby ) ? $orderby : 'date',
        );

        $customer_tag_count = count ( $customer_tag );
        if ( 1 === $customer_tag_count && '' === $customer_tag[0] ) {
            $customer_all_tag = array();
        } else {
            $customer_all_tag = $customer_tag;
        }

        if ( $customer_all_tag ) {
            if ( $customer_all_tag ) {
                $upside_query['tax_query'] = array(
                    array(
                        'taxonomy' => 'customer-tag',
                        'field'    => 'id',
                        'terms'    => $customer_all_tag
                    ),
                );
            }
        }
        $upside_results = new WP_Query( $upside_query );

        echo $before_widget;

        if ( ! empty($title) || ! empty($description) ) : ?>
            <div class="widget-title widget-title-s5 text-center">
                <span></span>
                <?php if ( ! empty($title) ) : ?>
                <h2><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ( ! empty($description) ) : ?>
                <p><?php echo esc_textarea($description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="widget-content">
            <?php if ( $upside_results->have_posts() ) : ?>
                <div class="owl-carousel owl-carousel-4">
                    <?php
                    while ( $upside_results->have_posts() ) :
                        $upside_results->the_post();
                        $upside_web = get_post_meta(get_the_ID(), 'upside_customer_website', true);
                        if ( has_post_thumbnail() ) :
                            ?>
                            <div class="item">
                                <?php if ( ! empty($upside_web) ) : ?>
                                    <a href="<?php echo esc_url($upside_web); ?>" title="<?php the_title(); ?>" target="_blank">
                                <?php endif; ?>

                                <?php the_post_thumbnail('full'); ?>

                                <?php if ( ! empty($upside_web) ) : ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif;
                        endwhile; wp_reset_postdata(); ?>
                </div>
                <!-- owl-carousel -->
            <?php endif; ?>
        </div>
        <?php
        echo $after_widget;
	}

}