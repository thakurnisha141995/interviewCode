<?php
/*
Template Name: Product Categories
*/

get_header();

// Display product categories here
$terms = get_terms('product_category');

if (!empty($terms) && !is_wp_error($terms)) {
    echo '<ul>';
    foreach ($terms as $term) {
        // Get the link to the custom template (page-products.php) with the category and other filters
        $template_link = get_permalink(get_page_by_path('products'));

        // Add category and other filters as query parameters
        $category_link = add_query_arg(
            array(
                'product_category' => $term->slug,
               
            ),
            $template_link
        );

        echo '<li><a href="' . esc_url($category_link) . '" target="_blank">' . $term->name . '</a></li>';
    }
    echo '</ul>';
} else {
    echo 'No product categories found.';
}

get_footer();
