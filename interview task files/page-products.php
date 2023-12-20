<?php
/*
Template Name: Products
*/

get_header();

// Check if a category is selected
$category_slug = get_query_var('product_category');

if ($category_slug) {
    // Get category ID from slug
    $category = get_term_by('slug', $category_slug, 'product_category');

    // Display category name
    echo '<h2>' . $category->name . '</h2>';

    // Get unique price and color values from products in the selected category
    $price_values = get_post_meta_query_values('_product_price', $category->term_id);
    $color_values = get_post_meta_query_values('_product_color', $category->term_id);

    // Get selected filters
    $selected_price = isset($_GET['price']) ? sanitize_text_field($_GET['price']) : '';
    $selected_color = isset($_GET['color']) ? sanitize_text_field($_GET['color']) : '';

    // Display filter form
    ?>
    <form id="product-filters-form">
        <label for="price">Price:</label>
        <select name="price" id="price">
            <option value="">Select Price</option>
            <?php foreach ($price_values as $value) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($selected_price, $value); ?>><?php echo esc_html($value); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="color">Color:</label>
        <select name="color" id="color">
            <option value="">Select Color</option>
            <?php foreach ($color_values as $value) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($selected_color, $value); ?>><?php echo esc_html($value); ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Apply Filters">
    </form>
    <?php

    // Display products from the selected category with filters
    $args = array(
        'post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_category',
                'field'    => 'id',
                'terms'    => $category->term_id,
            ),
        ),
    );

    // Apply price filter and color filter (similar to your code)

    $query = new WP_Query($args);

    if ($query->have_posts()) : 
	$query->the_post();
	$product_id = get_the_ID();
    $product_title = get_the_title();
    $product_permalink = get_permalink();?>
        <div class="products-wrapper">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="product-item">
                    <h3 class="product-title"><a href="<?php echo esc_url($product_permalink); ?>"><?php echo esc_html($product_title); ?></a></h3>
                    
                        
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="no-products">No products found with the selected filters.</p>
    <?php endif;

} else {
    echo 'Please select a category.';
}

// Function to get unique meta values from posts in a specific category
function get_post_meta_query_values($meta_key, $category_id) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_category',
                'field'    => 'id',
                'terms'    => $category_id,
            ),
        ),
        'meta_key'       => $meta_key,
    );

    $query = new WP_Query($args);

    $values = array();

    while ($query->have_posts()) : $query->the_post();
        $meta_value = get_post_meta(get_the_ID(), $meta_key, true);
        if ($meta_value) {
            $values[] = $meta_value;
        }
    endwhile;

    wp_reset_postdata();

    // Remove duplicates and sort
    $values = array_unique($values);
    sort($values);

    return $values;
}
?>


<script>
   document.getElementById('product-filters-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const price = document.getElementById('price').value;
    const color = document.getElementById('color').value;

    // Get the current URL
    let url = window.location.href;

    // Remove existing parameters related to filters
    url = url.replace(/([?&])price=[^&]*(&|$)/, '$1').replace(/([?&])color=[^&]*(&|$)/, '$1');

    // Add new parameters
    if (price) {
        url += `${url.includes('?') ? '&' : '?'}price=${encodeURIComponent(price)}`;
    }

    if (color) {
        url += `${url.includes('?') ? '&' : '?'}color=${encodeURIComponent(color)}`;
    }

    // Update the URL
    window.location.href = url;
});

</script>
