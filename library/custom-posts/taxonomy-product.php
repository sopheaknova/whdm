<?php
add_action('init', 'sp_product_category_init', 0);
function sp_product_category_init() {
	register_taxonomy(
		'sp_product_category',
		array( 'sp_product' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Product Category', 'sptheme_admin' ),
				'singular_name' => __( 'Product Category', 'sptheme_admin' ),
				'search_items' =>  __( 'Search Product Category', 'sptheme_admin' ),
				'all_items' => __( 'All Products Category', 'sptheme_admin' ),
				'parent_item' => __( 'Parent Product Category', 'sptheme_admin' ),
				'parent_item_colon' => __( 'Parent Product Category:', 'sptheme_admin' ),
				'edit_item' => __( 'Edit Product Category', 'sptheme_admin' ),
				'update_item' => __( 'Update Product Category', 'sptheme_admin' ),
				'add_new_item' => __( 'Add New Product Category', 'sptheme_admin' ),
				'new_item_name' => __( 'Product Category', 'sptheme_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'product_category' )
		)
	);
}