<?php

/**
 * ----------------------------------------------------------------------------------------
 * Load Post type and Toxonomy
 * ----------------------------------------------------------------------------------------
 */

//Custom post WordPress admin menu position - 30, 33, 39, 42, 45, 48
if ( ! isset( $cp_menu_position ) )
	$cp_menu_position = array(
			'menu_client'	=> 30,
			'menu_product'	=> 33,
			'menu_order'	=> 39,
		);

//All custom posts
load_template( SP_BASE_DIR . '/library/custom-posts/cp-client.php' );
load_template( SP_BASE_DIR . '/library/custom-posts/cp-product.php' );
load_template( SP_BASE_DIR . '/library/custom-posts/cp-order.php' );

//Taxonomies
load_template( SP_BASE_DIR . '/library/custom-posts/taxonomy-product.php' );
