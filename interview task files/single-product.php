<?php
/*
Template Name: Product Detail
*/
get_header();
if (have_posts()) {
    while (have_posts()) {
        the_post();
		$product_id = get_the_ID();
    // Get product details
    $product_title = get_the_title($product_id);
    
    // Check if product details are not empty
    if (!empty($product_title)) {
        $product_description = get_post_field('post_content', $product_id);
        $product_category = get_the_terms($product_id, 'product_category');
        $product_price = get_post_meta($product_id, '_product_price', true);
        $product_color = get_post_meta($product_id, '_product_color', true);
        $product_image = get_the_post_thumbnail($product_id, 'large');

        // Display product details
        ?>
        <div class="product-detail">
            <h2><?php echo esc_html($product_title); ?></h2>
            <?php echo $product_image; ?>
            <p><?php echo esc_html($product_description); ?></p>
            <p><strong>Category:</strong> <?php echo esc_html($product_category[0]->name); ?></p>
            <p><strong>Price:</strong> <?php echo esc_html($product_price); ?></p>
            <p><strong>Color:</strong> <?php echo esc_html($product_color); ?></p>
        </div>
        <?php
    } else {
        echo 'Product details are empty.';
    }
    }
} else {
    echo 'No product found.';
}

get_footer();
?>
