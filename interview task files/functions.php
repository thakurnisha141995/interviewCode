<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';


// Register Custom Post Type
function custom_post_type_products() {

    $labels = array(
        'name'                  => _x( 'Products', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Products', 'text_domain' ),
        'name_admin_bar'        => __( 'Product', 'text_domain' ),
        'archives'              => __( 'Product Archives', 'text_domain' ),
        'attributes'            => __( 'Product Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Product:', 'text_domain' ),
        'all_items'             => __( 'All Products', 'text_domain' ),
        'add_new_item'          => __( 'Add New Product', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Product', 'text_domain' ),
        'edit_item'             => __( 'Edit Product', 'text_domain' ),
        'update_item'           => __( 'Update Product', 'text_domain' ),
        'view_item'             => __( 'View Product', 'text_domain' ),
        'view_items'            => __( 'View Products', 'text_domain' ),
        'search_items'          => __( 'Search Product', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Items list', 'text_domain' ),
        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Product', 'text_domain' ),
        'description'           => __( 'Products for your site', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'comments' ),
        'taxonomies'            => array( 'product_category', 'post_tag', 'product_color' ), // Added 'product_color' taxonomy
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'product', $args );

}
add_action( 'init', 'custom_post_type_products', 0 );

// Add taxonomy for Product Categories
function custom_taxonomy_product_category() {

    $labels = array(
        'name'                       => _x( 'Product Categories', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Product Category', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Product Categories', 'text_domain' ),
        'all_items'                  => __( 'All Categories', 'text_domain' ),
        'parent_item'                => __( 'Parent Category', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Category:', 'text_domain' ),
        'new_item_name'              => __( 'New Category Name', 'text_domain' ),
        'add_new_item'               => __( 'Add New Category', 'text_domain' ),
        'edit_item'                  => __( 'Edit Category', 'text_domain' ),
        'update_item'                => __( 'Update Category', 'text_domain' ),
        'view_item'                  => __( 'View Category', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Categories', 'text_domain' ),
        'search_items'               => __( 'Search Categories', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No categories', 'text_domain' ),
        'items_list'                 => __( 'Categories list', 'text_domain' ),
        'items_list_navigation'      => __( 'Categories list navigation', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'product_category', array( 'product' ), $args );

}
add_action( 'init', 'custom_taxonomy_product_category', 0 );

// Add custom meta boxes for the 'product' post type
function custom_product_meta_boxes() {
    add_meta_box('product_color', 'Product Color', 'product_color_callback', 'product', 'normal', 'default');
    add_meta_box('product_price', 'Product Price', 'product_price_callback', 'product', 'normal', 'default');
}


function product_color_callback($post) {
    $color = get_post_meta($post->ID, '_product_color', true);
    ?>
    <label for="product_color">Color:</label>
    <input type="text" id="product_color" name="product_color" value="<?php echo esc_attr($color); ?>">
    <?php
}


function product_price_callback($post) {
    $price = get_post_meta($post->ID, '_product_price', true);
    ?>
    <label for="product_price">Price:</label>
    <input type="number" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>">
    <?php
}

// Save custom meta box data when the post is saved
function save_custom_product_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $color = sanitize_text_field($_POST['product_color']);
    $price = sanitize_text_field($_POST['product_price']);

    update_post_meta($post_id, '_product_color', $color);
    update_post_meta($post_id, '_product_price', $price);
}

// Hook functions into WordPress
add_action('add_meta_boxes', 'custom_product_meta_boxes');
add_action('save_post', 'save_custom_product_meta');





