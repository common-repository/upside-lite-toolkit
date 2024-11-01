<?php
/**
 * Menu item custom fields
 *
 * Copy this file into your wp-content/mu-plugins directory.
 *
 * @package Menu_Item_Custom_Fields_Example
 * @version 0.2.0
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 *
 *
 * Plugin name: Menu Item Custom Fields Example
 * Plugin URI: https://github.com/kucrut/wp-menu-item-custom-fields
 * Description: Example usage of Menu Item Custom Fields in plugins/themes
 * Version: 0.2.0
 * Author: Dzikri Aziz
 * Author URI: http://kucrut.org/
 * License: GPL v2
 */


/**
 * Sample menu item metadata
 *
 * This class demonstrate the usage of Menu Item Custom Fields in plugins/themes.
 *
 * @since 0.1.0
 */
class Upside_Lite_Toolkit_Menu_Item_Custom_Fields {

    /**
     * Holds our custom fields
     *
     * @var    array
     * @access protected
     * @since  Menu_Item_Custom_Fields_Example 0.2.0
     */
    protected static $fields = array();


    /**
     * Initialize plugin
     */
    public static function init() {
        add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 4 );
        add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
        add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );

        self::$fields = array(
            'field-megashortcode' => esc_attr__( 'Megamenu shortcode', 'upside-lite-toolkit' ),
            'field-menuicon' => esc_attr__( 'Font awesome icon', 'upside-lite-toolkit' ),
        );
    }


    /**
     * Save custom field value
     *
     * @wp_hook action wp_update_nav_menu_item
     *
     * @param int   $menu_id         Nav menu ID
     * @param int   $menu_item_db_id Menu item ID
     * @param array $menu_item_args  Menu item data
     */
    public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return;
        }

        foreach ( self::$fields as $_key => $label ) {
            $key = sprintf( 'menu-item-%s', $_key );

            // Sanitize
            if ( ! empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
                // Do some checks here...
                $value = $_POST[ $key ][ $menu_item_db_id ];
            }
            else {
                $value = null;
            }

            // Update
            if ( ! is_null( $value ) ) {
                update_post_meta( $menu_item_db_id, $key, $value );
            }
            else {
                delete_post_meta( $menu_item_db_id, $key );
            }
        }
    }


    /**
     * Print field
     *
     * @param object $item  Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args  Menu item args.
     * @param int    $id    Nav menu ID.
     *
     * @return string Form fields
     */
    public static function _fields( $id, $item, $depth, $args ) {
        foreach ( self::$fields as $_key => $label ) :
            $key   = sprintf( 'menu-item-%s', $_key );
            $id    = sprintf( 'edit-%s-%s', $key, $item->ID );
            $name  = sprintf( '%s[%s]', $key, $item->ID );
            $value = get_post_meta( $item->ID, $key, true );
            $class = sprintf( 'field-%s', $_key );

            if ( 'field-megashortcode' == $_key ) { ?>
                <p class="description description-wide <?php echo esc_attr( $class ) ?>">
                    <?php printf(
                        '<label for="%1$s">%2$s<br /><input type="text" id="%1$s" class="widefat %1$s" name="%3$s" value="%4$s" /></label>',
                        esc_attr( $id ),
                        esc_html( $label ),
                        esc_attr( $name ),
                        esc_attr( $value )
                    ); ?>
                </p>
            <?php } else { ?>
                <p class="description description-wide <?php echo esc_attr( $class ) ?>">
                    <?php printf(
                        '<label for="%1$s">%2$s<br /><input type="text" id="%1$s" class="widefat %1$s" name="%3$s" value="%4$s" /></label>',
                        esc_attr( $id ),
                        esc_html( $label ),
                        esc_attr( $name ),
                        esc_attr( $value )
                    ); ?>
                    <span class="description"><?php echo wp_kses_post('Please enter class of <a href="//fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome</a>.', 'upside-lite-toolkit');?></span>
                </p>
            <?php } ?>
        <?php
        endforeach;
    }


    /**
     * Add our fields to the screen options toggle
     *
     * @param array $columns Menu item columns
     * @return array
     */
    public static function _columns( $columns ) {
        $columns = array_merge( $columns, self::$fields );

        return $columns;
    }
}

Upside_Lite_Toolkit_Menu_Item_Custom_Fields::init();

class Upside_Lite_Toolkit_Walker_Main_Menu extends Walker_Nav_Menu {

        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            /* Add mega menu */
            $mega_shortcode = get_post_meta($item->ID, 'menu-item-field-megashortcode', true);
            if ( ! empty($mega_shortcode) ) {
                $classes[] = 'mega-menu';
            }


            /**
             * Filter the CSS class(es) applied to a menu item's list item element.
             *
             * @since 3.0.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
             * @param object $item    The current menu item.
             * @param array  $args    An array of {@see wp_nav_menu()} arguments.
             * @param int    $depth   Depth of menu item. Used for padding.
             */
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            /**
             * Filter the ID applied to a menu item's list item element.
             *
             * @since 3.0.1
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
             * @param object $item    The current menu item.
             * @param array  $args    An array of {@see wp_nav_menu()} arguments.
             * @param int    $depth   Depth of menu item. Used for padding.
             */
            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names .'>';

            $atts = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
            $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
            $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

            /**
             * Filter the HTML attributes applied to a menu item's anchor element.
             *
             * @since 3.6.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             *     @type string $title  Title attribute.
             *     @type string $target Target attribute.
             *     @type string $rel    The rel attribute.
             *     @type string $href   The href attribute.
             * }
             * @param object $item  The current menu item.
             * @param array  $args  An array of {@see wp_nav_menu()} arguments.
             * @param int    $depth Depth of menu item. Used for padding.
             */
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            /** This filter is documented in wp-includes/post-template.php */
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            /**
             * Add description to menu
             */
            if ( ! empty($item->description) ) :
                $item_output .= '<span class="menu-description">' . $item->description . '</span>';
            endif;
            $item_output .= '</a>';

            /* Add mega menu */
            if ( ! empty($mega_shortcode) ) {
                $item_output .= do_shortcode($mega_shortcode);
            }

            $item_output .= $args->after;

            /**
             * Filter a menu item's starting output.
             *
             * The menu item's starting output only includes `$args->before`, the opening `<a>`,
             * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
             * no filter for modifying the opening and closing `<li>` for a menu item.
             *
             * @since 3.0.0
             *
             * @param string $item_output The menu item's starting HTML output.
             * @param object $item        Menu item data object.
             * @param int    $depth       Depth of menu item. Used for padding.
             * @param array  $args        An array of {@see wp_nav_menu()} arguments.
             */
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

    }

class Upside_Lite_Toolkit_Walker_Icon_Menu extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        /* Add icon menu */
        $mega_icon = get_post_meta($item->ID, 'menu-item-field-menuicon', true);
        if ( ! empty($mega_icon) ) {
            $item_output .= sprintf('<i class="%s"></i>', esc_attr($mega_icon));
        }


        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . '<span>'.apply_filters( 'the_title', $item->title, $item->ID ) . '</span>' . $args->link_after;

        $item_output .= '</a>';

        /* Add mega menu */
        if ( ! empty($mega_shortcode) ) {
            $item_output .= do_shortcode($mega_shortcode);
        }

        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}


