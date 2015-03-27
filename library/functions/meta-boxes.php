<?php

/*  Initialize the meta boxes.
/* ------------------------------------ */
add_action( 'admin_init', '_custom_meta_boxes' );

function _custom_meta_boxes() {

	$prefix = 'sp_';
  
/*  Custom meta boxes
/* ------------------------------------ */
$page_layout_options = array(
	'id'          => 'page-options',
	'title'       => 'Page Options',
	'desc'        => '',
	'pages'       => array( 'page', 'post' ),
	'context'     => 'normal',
	'priority'    => 'default',
	'fields'      => array(
		array(
			'label'		=> 'Primary Sidebar',
			'id'		=> $prefix . 'sidebar_primary',
			'type'		=> 'sidebar-select',
			'desc'		=> 'Overrides default'
		),
		array(
			'label'		=> 'Layout',
			'id'		=> $prefix . 'layout',
			'type'		=> 'radio-image',
			'desc'		=> 'Overrides the default layout option',
			'std'		=> 'inherit',
			'choices'	=> array(
				array(
					'value'		=> 'inherit',
					'label'		=> 'Inherit Layout',
					'src'		=> SP_ASSETS . '/images/admin/layout-off.png'
				),
				array(
					'value'		=> 'col-1c',
					'label'		=> '1 Column',
					'src'		=> SP_ASSETS . '/images/admin/col-1c.png'
				),
				array(
					'value'		=> 'col-2cl',
					'label'		=> '2 Column Left',
					'src'		=> SP_ASSETS . '/images/admin/col-2cl.png'
				),
				array(
					'value'		=> 'col-2cr',
					'label'		=> '2 Column Right',
					'src'		=> SP_ASSETS . '/images/admin/col-2cr.png'
				)
			)
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: video
/* ---------------------------------------------------------------------- */
$post_format_video = array(
	'id'          => 'format-video',
	'title'       => 'Format: Video',
	'desc'        => 'These settings enable you to embed videos into your posts.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Video URL',
			'id'		=> $prefix . 'video_url',
			'type'		=> 'text',
			'desc'		=> 'Enter Video Embed URL from youtube, vimeo or dailymotion'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Audio
/* ---------------------------------------------------------------------- */
$post_format_audio = array(
	'id'          => 'format-audio',
	'title'       => 'Format: Audio',
	'desc'        => 'These settings enable you to embed audio into your posts. You must provide both .mp3 and .ogg/.oga file formats in order for self hosted audio to function accross all browsers.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Audio URL',
			'id'		=> $prefix . 'audio_url',
			'type'		=> 'upload',
			'desc'		=> 'You can get sound or audio URL from soundcloud'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Gallery
/* ---------------------------------------------------------------------- */
$post_format_gallery = array(
	'id'          => 'format-gallery',
	'title'       => 'Format: Gallery',
	'desc'        => 'Standard post galleries.</i>',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Upload photo',
			'id'		=> $prefix . 'post_gallery',
			'type'		=> 'gallery',
			'desc'		=> 'Upload photos'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Chat
/* ---------------------------------------------------------------------- */
$post_format_chat = array(
	'id'          => 'format-chat',
	'title'       => 'Format: Chat',
	'desc'        => 'Input chat dialogue.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Chat Text',
			'id'		=> $prefix . 'chat',
			'type'		=> 'textarea',
			'rows'		=> '2'
		)
	)
);
/* ---------------------------------------------------------------------- */
/*	Post Format: Link
/* ---------------------------------------------------------------------- */
$post_format_link = array(
	'id'          => 'format-link',
	'title'       => 'Format: Link',
	'desc'        => 'Input your link.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Link Title',
			'id'		=> $prefix . 'link_title',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Link URL',
			'id'		=> $prefix . 'link_url',
			'type'		=> 'text'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: quote
/* ---------------------------------------------------------------------- */
$post_format_quote = array(
	'id'          => 'format-quote',
	'title'       => 'Format: Quote',
	'desc'        => 'Input your quote.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Quote',
			'id'		=> $prefix . 'quote',
			'type'		=> 'textarea',
			'rows'		=> '2'
		),
		array(
			'label'		=> 'Quote Author',
			'id'		=> $prefix . 'quote_author',
			'type'		=> 'text'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Client post type
/* ---------------------------------------------------------------------- */
$post_type_client = array(
	'id'          => 'client-setting',
	'title'       => 'Contact meta',
	'desc'        => '',
	'pages'       => array( 'sp_client' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Address',
			'id'		=> $prefix . 'client_address',
			'type'		=> 'textarea',
			'desc'		=> 'Enter address of client',
			'rows'      => '2',
		),
		array(
			'label'		=> 'Contact Name',
			'id'		=> $prefix . 'client_contact_name',
			'type'		=> 'text',
			'desc'		=> 'Enter contact name of Client'
		),
		array(
			'label'		=> 'Email',
			'id'		=> $prefix . 'client_email',
			'type'		=> 'text',
			'desc'		=> 'Enter email of client'
		),
		array(
			'label'		=> 'Phone',
			'id'		=> $prefix . 'client_phone',
			'type'		=> 'text',
			'desc'		=> 'Enter phone of client'
		),
		array(
			'label'		=> 'Telephone',
			'id'		=> $prefix . 'client_telephone',
			'type'		=> 'text',
			'desc'		=> 'Enter telephone of client'
		)

	)
);

/* ---------------------------------------------------------------------- */
/*	Product post type
/* ---------------------------------------------------------------------- */
$post_type_product = array(
	'id'          => 'product-setting',
	'title'       => 'Product meta',
	'desc'        => '',
	'pages'       => array( 'sp_product' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Price',
			'id'		=> $prefix . 'product_price',
			'type'		=> 'text',
			'desc'		=> 'Enter price of product',
		),
	)
);

/* ---------------------------------------------------------------------- */
/*	Order post type
/* ---------------------------------------------------------------------- */
$post_type_order_client = array(
	'id'          => 'order-client',
	'title'       => 'Client meta',
	'desc'        => '',
	'pages'       => array( 'sp_order' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Client Name',
			'id'		=> $prefix . 'order_client_name',
			'type'		=> 'custom-post-type-select',
			'post_type' => 'sp_client',
		),
		array(
			'label'		=> 'Is Tax?',
			'id'		=> $prefix . 'order_tax',
			'std'       => 'off',
			'type'		=> 'on-off'
		),
	)
);
	   
$post_type_order_product_meta = array(
	'id'          => 'order-product-meta',
	'title'       => 'Product meta',
	'desc'        => '',
	'pages'       => array( 'sp_order' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Status',
			'id'		=> $prefix . 'order_status_h',
			'std'       => 'off',
			'type'		=> 'on-off'
		),
		array(
			'label'		=> 'Hosting Package',
			'id'		=> $prefix . 'order_hosting_package_h',
			'type'		=> 'custom-post-type-select',
			//'taxonomy' => 'sp_product_category',
			'post_type'	=> 'sp_product',
			'condition' => 'sp_order_status_h:is(on)'
		),
		array(
			'label'		=> 'Domain Name',
			'id'		=> $prefix . 'order_domain_name_h',
			'type'		=> 'text',
			'desc'		=> 'Enter domain name of product',
			'condition' => 'sp_order_status_h:is(on)'
		),
		array(
			'label'		=> 'Register Date',
			'id'		=> $prefix . 'order_register_date_h',
			'type'		=> 'date-picker',
			'desc'		=> 'Select register date of product',
			'condition' => 'sp_order_status_h:is(on)'
		),
		array(
			'label'		=> 'Expire Date',
			'id'		=> $prefix . 'order_expire_date_h',
			'type'		=> 'date-picker',
			'desc'		=> 'Select expire date of product',
			'condition' => 'sp_order_status_h:is(on)'
		),
		array(
			'label'		=> 'Period',
			'id'		=> $prefix . 'order_period_h',
			'type'		=> 'select',
			'desc'		=> 'Select period type(1 Year to 10 Year)',
			'choices'	=> array( 
	          array(
	            'value'       => '',
	            'label'       => 'none',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '1',
	            'label'       => '1 Year',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '2',
	            'label'       => '2 Years',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '3',
	            'label'       => '3 Years',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '4',
	            'label'       => '4 Years',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '5',
	            'label'       => '5 Years',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '6',
	            'label'       => '6 Years',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '7',
	            'label'       => '7 Years',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '8',
	            'label'       => '8 Years',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '9',
	            'label'       => '9 Years',
	            'src'         => ''
	          ),
	          array(
	            'value'       => '10',
	            'label'       => '10 Years',
	            'src'         => ''
	          )
	        ),
			'condition'   => 'sp_order_status_h:is(on)'
		),
		array(
			'label'		=> 'Extra Product',
			'id'		=> $prefix . 'extra_product',
			'type'		=> 'list-item',
			'desc'		=> 'Add extra product link of each order',
			'settings'	=> array( 
		        array(
					'label'		=> 'Hosting Package',
					'id'		=> $prefix . 'order_extra_product',
					'type'		=> 'custom-post-type-select',
					'post_type'	=> 'sp_product',

			    ),
			'condition' => 'sp_order_status_h:is(on)'
	        )  
		)
	)
);
// $post_type_order_additional_domain = array(
// 	'id'          => 'order-additional-domain',
// 	'title'       => 'Additional Domain meta',
// 	'desc'        => '',
// 	'pages'       => array( 'sp_order' ),
// 	'context'     => 'normal',
// 	'priority'    => 'high',
// 	'fields'      => array(
// 		array(
// 			'label'		=> 'Status',
// 			'id'		=> $prefix . 'order_status_d',
// 			'std'       => 'off',
// 			'type'		=> 'on-off'
// 		),
// 		array(
// 			'label'		=> 'Domain Type',
// 			'id'		=> $prefix . 'order_domain_type_d',
// 			'type'		=> 'custom-post-type-select',
// 			//'taxonomy' => 'sp_product_category',
// 			'post_type'	=> 'sp_product',
// 			'condition' => 'sp_order_status_d:is(on)'
// 		),

// 		array(
// 			'label'		=> 'Domain Name',
// 			'id'		=> $prefix . 'order_domain_name_d',
// 			'type'		=> 'text',
// 			'desc'		=> 'Enter domain name of product',
// 			'condition' => 'sp_order_status_d:is(on)'
// 		),
// 		array(
// 			'label'		=> 'Register Date',
// 			'id'		=> $prefix . 'order_register_date_d',
// 			'type'		=> 'date-picker',
// 			'desc'		=> 'Select register date of product',
// 			'condition' => 'sp_order_status_d:is(on)'
// 		),
// 		array(
// 			'label'		=> 'Expire Date',
// 			'id'		=> $prefix . 'order_expire_date_d',
// 			'type'		=> 'date-picker',
// 			'desc'		=> 'Select expire date of product',
// 			'condition' => 'sp_order_status_d:is(on)'
// 		),
// 		array(
// 			'label'		=> 'Period',
// 			'id'		=> $prefix . 'order_period_d',
// 			'type'		=> 'select',
// 			'desc'		=> 'Select period type(1 Year to 10 Year)',
// 			'choices'	=> array( 
// 	          array(
// 	            'value'       => '',
// 	            'label'       => 'none',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '1',
// 	            'label'       => '1 Year',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '2',
// 	            'label'       => '2 Years',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '3',
// 	            'label'       => '3 Years',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '4',
// 	            'label'       => '4 Years',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '5',
// 	            'label'       => '5 Years',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '6',
// 	            'label'       => '6 Years',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '7',
// 	            'label'       => '7 Years',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '8',
// 	            'label'       => '8 Years',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '9',
// 	            'label'       => '9 Years',
// 	            'src'         => ''
// 	          ),
// 	          array(
// 	            'value'       => '10',
// 	            'label'       => '10 Years',
// 	            'src'         => ''
// 	          )
// 	        ),
// 			'condition'   => 'sp_order_status_d:is(on)'
// 		),
// 	)
// );

/*  Register meta boxes
/* ------------------------------------ */
	ot_register_meta_box( $page_layout_options );
	ot_register_meta_box( $post_format_audio );
	ot_register_meta_box( $post_format_chat );
	ot_register_meta_box( $post_format_gallery );
	ot_register_meta_box( $post_format_link );
	ot_register_meta_box( $post_format_quote );
	ot_register_meta_box( $post_format_video );
	ot_register_meta_box( $post_type_client );
	ot_register_meta_box( $post_type_product );
	ot_register_meta_box( $post_type_order_client );
	ot_register_meta_box( $post_type_order_product_meta );
	//ot_register_meta_box( $post_type_order_additional_domain );
}