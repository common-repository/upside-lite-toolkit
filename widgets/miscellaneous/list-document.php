<?php
add_action( 'kpb_get_widgets_list', array('Upside_Lite_Toolkit_Widget_Documet_List', 'register_block'));
class Upside_Lite_Toolkit_Widget_Documet_List extends Kopa_Widget {
    public $kpb_group = 'miscellaneous';

    public static function register_block($blocks){
        $blocks['Upside_Lite_Toolkit_Widget_Documet_List'] = new Upside_Lite_Toolkit_Widget_Documet_List();
        return $blocks;
    }

    public function __construct() {
        $this->widget_cssclass    = 'kopa-document-widget';
        $this->widget_description = esc_attr__( 'Display list of documents.', 'upside-lite-toolkit' );
        $this->widget_id          = 'upside-lite-toolkit-document-list';
        $this->widget_name        = esc_attr__( '(Upside lite) Document list', 'upside-lite-toolkit' );

        $tag_terms = get_terms( 'document-tag', array(
            'hide_empty' => false,
        ) );
        $tag_options = array( '' => esc_attr__( '---- All ----', 'upside-lite-toolkit' ) );
        if ( $tag_terms ) {
            foreach ( $tag_terms as $term ) {
                $tag_options[ $term->term_id ] = $term->name;
            }
        }

        $this->settings           = array(
            'tag_ids' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => esc_attr__('Document tags', 'upside-lite-toolkit'),
                "desc" => esc_attr__('Hold Ctrl to choose multiple values', 'upside-lite-toolkit'),
                'options' => $tag_options
            ),
            'tag_limit' => array(
                'type' => 'number',
                'std' => '4',
                'label' => esc_attr__('Number of document in each tag', 'upside-lite-toolkit'),
                'min' => '0'
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
        ob_start();
        extract( $args );
        extract( $instance );

        $upside_tags = array();
        $tag_count = count ( $tag_ids );
        if ( 1 === $tag_count && '' === $tag_ids[0] ) {
            $upside_terms = get_terms('document-tag');
            if ( $upside_terms ) {
                foreach ( $upside_terms as $term ) {
                    $upside_tags[] = $term->slug;
                }
            }
        } else {
            $upside_tags = $tag_ids;
        }

        if ( $upside_tags ) :

        echo $before_widget; ?>

        <div class="masonry-list-wrapper">

            <ul class="clearfix">
                <?php
                foreach ($upside_tags as $slug ) :
                    $upside_term = get_term_by('id', $slug, 'document-tag');
                    if ( $upside_term ) :
                        $upside_query = array(
                            'post_type'      => array('document'),
                            'posts_per_page' => (int) $tag_limit,
                            'post_status'    => array('publish'),
                            'order'          => isset( $order ) ?  $order : 'DESC',
                            'orderby'        => isset( $orderby ) ? $orderby : 'date',
                        );
                        $upside_results = new WP_Query( $upside_query );
                        ?>

                        <li class="masonry-item">

                            <article class="document-block">
                                <header class="clearfix">
                                    <i class="fa fa-folder-open pull-left"></i>
                                    <h5 class="pull-left"><?php echo esc_html($upside_term->name); ?></h5>
                                </header>
                                <?php if ( $upside_results->have_posts() ) : ?>
                                <ul class="clearfix">
                                    <?php
                                    while ( $upside_results->have_posts() ) {
                                        $upside_results->the_post(); ?>
                                        <li><a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title();?></a></li>
                                        <?php }
                                    wp_reset_postdata();
                                    ?>
                                </ul>
                                <?php endif; ?>
                            </article>
                            <!-- document-block -->

                        </li>

                        <?php
                    endif;
                endforeach; ?>

            </ul>

        </div>

        <?php echo $after_widget;

        endif;
    }

}
