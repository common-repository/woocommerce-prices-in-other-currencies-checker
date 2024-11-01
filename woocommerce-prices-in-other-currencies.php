<?php
/**
 * Plugin Name: Woocommerce Prices in Other Currencies
 * Plugin URI: http://www.chrislomas.co.uk/woocommerce-prices-in-other-currencies.zip
 * Description: This plugin detects products and product variations which are set to "Calculate prices in other currencies automatically" and lists them on the WordPress Dashboard in a custom widget.
 * Version: 1.0
 * Author: Chris Lomas
 * Author URI: http://www.chrislomas.co.uk
 * License: GPL2
 */

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function chrislomas_amoralia_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'chrislomas_wpoc_dashboard_widget',         // Widget slug.
                 'Woocommerce Price in Other Currencies',         // Title.
                 'chrislomas_wpoc_dashboard_widget_function' // Display function.
        );
}
add_action( 'wp_dashboard_setup', 'chrislomas_wpoc_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function chrislomas_wpoc_dashboard_widget_function() {
    global $wpdb;
    // Display whatever it is you want to show.
    $args = array( 'posts_per_page' => 99999, 'post_type' => 'product', 'meta_key' => '_wcml_custom_prices_status', 'meta_value' => '0', 'post_status' => 'publish' );
    $products = get_posts( $args );
    $args = array( 'posts_per_page' => 99999, 'post_type' => 'product_variation', 'meta_key' => '_wcml_custom_prices_status', 'meta_value' => '0', 'post_status' => 'publish' );
    $product_variations = get_posts( $args );
    ob_start();
    echo (count($myposts) == 0 ? '<span style="color:#00FF00">' : '<span style="color:#FF0000">').count($myposts)." products</span> have the auto-convert currency set:";
    echo "<ul>";
    foreach ( $products as $product ) :
    ?>
            <li>
                    <a href="/wp-admin/post.php?action=edit&post=<?php echo $product->post_parent; ?>"><?php echo $product->post_title; ?></a>
            </li>
    <?php endforeach;
    foreach ( $product_variations as $product_variation ) :
    ?>
            <li>
                    <a href="/wp-admin/post.php?action=edit&post=<?php echo $product_variation->post_parent; ?>"><?php echo $product_variation->post_title; ?></a>
            </li>
    <?php endforeach;
    echo "</ul>";
    echo ob_get_clean();
    wp_reset_postdata();
        
}
?>