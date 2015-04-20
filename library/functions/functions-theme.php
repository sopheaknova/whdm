<?php

/**
 * ----------------------------------------------------------------------------------------
 * Makes some changes to the <title> tag, by filtering the output of wp_title()
 * ----------------------------------------------------------------------------------------
 */
if( !function_exists('sp_filter_wp_title')) {

	function sp_filter_wp_title( $title, $separator ) {

		if ( is_feed() ) return $title;

		global $paged, $page;

		if ( is_search() ) {
			$title = sprintf(__('Search results for %s', SP_TEXT_DOMAIN), '"' . get_search_query() . '"');

			if ( $paged >= 2 )
				$title .= " $separator " . sprintf(__('Page %s', SP_TEXT_DOMAIN), $paged);

			$title .= " $separator " . get_bloginfo('name', 'display');

			return $title;
		}

		$title .= get_bloginfo('name', 'display');
		$site_description = get_bloginfo('description', 'display');

		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $separator " . $site_description;

		if ( $paged >= 2 || $page >= 2)
			$title .= " $separator " . sprintf(__('Page %s', SP_TEXT_DOMAIN), max($paged, $page) );

		return $title;

	}
	add_filter('wp_title', 'sp_filter_wp_title', 10, 2);

}

/**
 * ----------------------------------------------------------------------------------------
 * Customizable size of gallery thumbnail wp core
 * ----------------------------------------------------------------------------------------
 */
function sp_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
	'columns' => '3',
	'size' => 'medium',
	), $atts );
	 
	$out['columns'] = $atts['columns'];
	$out['size'] = $atts['size'];
	 
	return $out;
 
}
add_filter( 'shortcode_atts_gallery', 'sp_gallery_atts', 10, 3 );

/**
 * ----------------------------------------------------------------------------------------
 * Excerpt ending
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_excerpt_more' ) ) {

	add_filter( 'excerpt_more', 'sp_excerpt_more' );

	function sp_excerpt_more( $more ) {
		global $post;
   		$out = ' &#46;&#46;&#46;';
   		$out .= '<a class="more" href="'. get_permalink($post->ID) . '">' . __( 'Read More', SP_TEXT_DOMAIN ) . '</a>';

   		return $out;
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Excerpt length
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_excerpt_length' ) ) {

	add_filter( 'excerpt_length', 'sp_excerpt_length', 999 );

	function sp_excerpt_length( $length ) {
		return ot_get_option('excerpt-length',$length);
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Start content wrap
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_start_content_wrap') ) {

	add_action( 'sp_start_content_wrap_html', 'sp_start_content_wrap' );

	function sp_start_content_wrap() {
		echo '<section id="content"><div class="container clearfix">';
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * End content wrap
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_end_content_wrap') ) {

	add_action( 'sp_end_content_wrap_html', 'sp_end_content_wrap' );

	function sp_end_content_wrap() {
		echo '</div></section> <!-- #content .container .clearfix -->';
	}

}

/**
 * ----------------------------------------------------------------------------------------
 * Displays a page pagination
 * ----------------------------------------------------------------------------------------
 */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme_admin') . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', SP_TEXT_DOMAIN) . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', SP_TEXT_DOMAIN) . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme_admin') . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}

/**
 * ----------------------------------------------------------------------------------------
 * Comment Template
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_comment_template' ) ) {

	function sp_comment_template( $comment, $args, $depth ) {
		global $retina;
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>

		<li id="comment-<?php comment_ID(); ?>" class="comment clearfix">

			<?php $av_size = isset($retina) && $retina === 'true' ? 96 : 48; ?>
			
			<div class="user"><?php echo get_avatar( $comment, $av_size, $default=''); ?></div>

			<div class="message">
				
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => 3 ) ) ); ?>

				<div class="info">
					<h4><?php echo (get_comment_author_url() != '' ? comment_author_link() : comment_author()); ?></h4>
					<span class="meta"><?php echo comment_date('F jS, Y \a\t g:i A'); ?></span>
				</div>

				<?php comment_text(); ?>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="await"><?php _e( 'Your comment is awaiting moderation.', 'goodwork' ); ?></em>
				<?php endif; ?>

			</div>

		</li>

		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'goodwork' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'goodwork'), ' ' ); ?></p></li>
		<?php
				break;
		endswitch;
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Ajaxify Comments
 * ----------------------------------------------------------------------------------------
 */

add_action('comment_post', 'ajaxify_comments',20, 2);
function ajaxify_comments($comment_ID, $comment_status){
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//If AJAX Request Then
		switch($comment_status){
			case '0':
				//notify moderator of unapproved comment
				wp_notify_moderator($comment_ID);
			case '1': //Approved comment
				echo "success";
				$commentdata=&get_comment($comment_ID, ARRAY_A);
				$post=&get_post($commentdata['comment_post_ID']); 
				wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
			break;
			default:
				echo "error";
		}
		exit;
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Get thumbnail post
 * ----------------------------------------------------------------------------------------
 */
if( !function_exists('sp_post_thumbnail') ) {

	function sp_post_thumbnail( $size = 'thumbnail'){
			global $post;
			$thumb = '';

			//get the post thumbnail;
			$thumb_id = get_post_thumbnail_id($post->ID);
			$thumb_url = wp_get_attachment_image_src($thumb_id, $size);
			$thumb = $thumb_url[0];
			if ($thumb) return $thumb;
	}		

}

/**
 * ----------------------------------------------------------------------------------------
 * Get images attached info by attached id
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_get_post_attachment') ) {

	function sp_get_post_attachment( $attachment_id ) {

		$attachment = get_post( $attachment_id );
		return array(
			'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href' => get_permalink( $attachment->ID ),
			'src' => $attachment->guid,
			'title' => $attachment->post_title
		);
	}

}

/**
 * ----------------------------------------------------------------------------------------
 * Switch column number to grid base class
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_column_class' ) ) {
	function sp_column_class( $column = 'none' ){
		switch ( $column ) {
			case 2:
				$out = 'two-fourth';
				break;
			case 3:
				$out = 'one-third';
				break;
			case 4:
				$out = 'one-fourth';
				break;	
			default:
				$out = 'column-none';	
		}

		return $out;
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Print HTML with meta information for the current post-date/time and author
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_meta_posted_on') ) {

	function sp_meta_posted_on() {
		printf( __( '<i class="icon icon-calendar-1"></i><a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s"> %4$s</time></a><span class="by-author"> by </span><span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span><span class="posted-in"> in </span><i class="icon icon-tag"> </i> %8$s ', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', SP_TEXT_DOMAIN ), get_the_author() ) ),
			get_the_author(),
			get_the_category_list( ', ' )
		);
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) )  : ?>
				<span class="with-comments"><?php _e( ' with ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '<i class="icon icon-comment-1"></i> % Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open() ?>
		<?php edit_post_link( __( 'Edit', SP_TEXT_DOMAIN ), '<span class="sep"> | </span><span class="edit-link">', '</span>' );
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Embeded add video from youtube, vimeo and dailymotion
 * ----------------------------------------------------------------------------------------
 */
function sp_get_video_img($url) {
	
	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video_id =  $my_array_of_vars['v'] ;
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video_id = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video_id = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		$output .=$hash[0]['thumbnail_large'];
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='http://www.dailymotion.com/thumbnail/video/'.$video_id;
	}

	return $output;
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Embeded add video from youtube, vimeo and dailymotion
 * ----------------------------------------------------------------------------------------
 */
function sp_add_video ($url, $width = 620, $height = 349) {

	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video =  $my_array_of_vars['v'] ;
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe src="http://player.vimeo.com/video/'.$video.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
	}

	return $output;
}

/**
 * ----------------------------------------------------------------------------------------
 * Embeded soundcloud
 * ----------------------------------------------------------------------------------------
 */

function sp_soundcloud($url , $autoplay = 'false' ) {
	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true"></iframe>';
}

function sp_portfolio_grid( $col = 'list', $posts_per_page = 5 ) {
	
	$temp ='';
	$output = '';
	
	$args = array(
			'posts_per_page' => (int) $posts_per_page,
			'post_type' => 'portfolio',
			);
			
	$post_list = new WP_Query($args);
		
	ob_start();
	if ($post_list && $post_list->have_posts()) {
		
		$output .= '<ul class="portfolio ' . $col . '">';
		
		while ($post_list->have_posts()) : $post_list->the_post();
		
		$output .= '<li>';
		$output .= '<div class="two-fourth"><div class="post-thumbnail">';
		$output .= '<a href="'.get_permalink().'"><img src="' . sp_post_thumbnail('portfolio-2col') . '" /></a>';
		$output .= '</div></div>';
		
		$output .= '<div class="two-fourth last">';
		$output .= '<a href="'.get_permalink().'" class="port-'. $col .'-title">' . get_the_title() .'</a>';
		$output .= '</div>';	
		
		$output .= '</li>';	
		endwhile;
		
		$output .= '</ul>';
		
	}
	$temp = ob_get_clean();
	$output .= $temp;
	
	wp_reset_postdata();
	
	return $output;
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Get Most Racent posts from Category
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_last_posts_cat' ) ) {
	function sp_last_posts_cat( $post_num = 5 , $thumb = true , $category = 1 ) {

		global $post;
		
		$out = '';
		if ( is_singular() ) :
			$args = array( 'cat' => $category, 'posts_per_page' => (int) $post_num, 'post__not_in' => array($post->ID) );	
		else : 
			$args = array( 'cat' => $category, 'posts_per_page' => (int) $post_num, 'post__not_in' => get_option( 'sticky_posts' ) );
		endif;
		

		$custom_query = new WP_Query( $args );

		$out .= '<section class="custom-posts clearfix">';
		if( $custom_query->have_posts() ) :
			while ( $custom_query->have_posts() ) : $custom_query->the_post();

			$out .= '<article>';
			$out .= '<a href="' . get_permalink() . '" class="clearfix">';
			if ( $thumb ) :
				if ( has_post_thumbnail() ) {
					$out .= get_the_post_thumbnail();
				} else {
					$out .= '<img class="wp-image-placeholder" src="' . SP_ASSETS .'/images/placeholder/thumbnail-300x225.gif">';	
				}
			endif;
			$out .= '<h5>' . get_the_title() . '</h5>';
			$out .= '<span class="time">' . get_the_time('j M, Y') . '</span>';
			$out .= '</a>';
			$out .= '</article>';

			endwhile; wp_reset_postdata();
		endif;
		$out .= '<a href="' . esc_url(get_category_link( $category )) . '" class="more">' . __('More news', SP_TEXT_DOMAIN) .'</a>';
		$out .= '</section>';

		return $out;
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Email Notification
 * ----------------------------------------------------------------------------------------
 */

add_action( 'wp', 'sp_create_send_email_schedule' );
add_action( 'sp_create_send_email', 'sp_create_email');
add_filter( 'cron_schedules', 'sp_add_corn_schedule' ); 
add_filter( 'wp_mail_content_type','set_content_type' );

function sp_create_send_email_schedule(){
	$timestamp = wp_next_scheduled( 'sp_create_send_email');
	wp_clear_scheduled_hook( 'per_minute' );
	
	if( $timestamp == false ){
		wp_schedule_event( time(), 'weekly', 'sp_create_send_email');
	}
}

function set_content_type(){
	return "text/html";
}

function sp_create_email(){
	global $post;
	$reminder = ot_get_option( 'second' ); // 90 days = 7776000;
	$args = array(
			'post_type'			=> 'sp_order',
			'posts_per_page'	=>	-1,
			'order'				=> 	'ASC',
			'meta_query' => array(
								array(
									'key'     => 'sp_order_expire_date_h',
									'value'   => date('Y-m-d h:i', time() + $reminder ),
									'type'	  => 'datetime',
									'compare' => '<=',
								),
							),
			
		);
	$custom_query = new WP_Query( $args );
	if( $custom_query->have_posts() ) :
		while ( $custom_query->have_posts() ) : $custom_query->the_post();
			$product_id   		 = get_post_meta( $post->ID, 'sp_order_hosting_package_h', true );
			$order_name 		 = get_the_title();
			$unit_price   		 = get_post_meta( $product_id, 'sp_product_price', true );
			$qty 		  		 = get_post_meta( $post->ID, 'sp_order_period_h', true );
			$date_expire  		 = get_post_meta( $post->ID, 'sp_order_expire_date_h', true );
			$client_name  	     = sp_get_contact_client( get_post_meta( $post->ID, 'sp_order_client_name', true ) );
			$domain_name  		 = get_post_meta( $post->ID, 'sp_order_domain_name_h', true );
			$client_email 	     = sp_get_email_client( get_post_meta( $post->ID, 'sp_order_client_name', true ) );
			$extra_products 	 = get_post_meta($post->ID, 'sp_extra_product', true);
			$total_extra_product = '';
			$total_item        	 = $qty * $unit_price ;
			

					$to_client = $client_email;
					$reply      = ot_get_option( 'email-reply' );
					$to_company = ot_get_option( 'email-company' );
					$cc = ot_get_option( 'email-staff' );
					$subject = 'Website Renewal Notice';
					$message = '<html>
								<body style="width: 600px; margin: 0 auto;">
								<div style="float:right;">
									<i style="font-size: 12px; color:#999;">'.$client_name.', you have website about to expire.<i>
									<p style="font-size: 12px; margin-top:0; color:#999;">24/7 Support: <strong>+855 23 223 577<strong></p>
								</div>
								<div style="max-width: 100%; padding: 30px; background:#f96f00; margin-bottom:20px; clear:both;">
									<h1 style="font-size: 28px; margin:0; color:#ffffff;">Expiration Notice</h1>
									<p style="font-size: 18px; margin:0; color:#ffffff;">You are at risk of losing the items listed below.</p>
								</div>
								<b>Dear '.$client_name. ',</b>

								<br />
								        <p>Your domain names '.$domain_name.' and hosting that renew manually will expire on <strong style="color: red;">'.date("j F, Y", strtotime($date_expire) - 604800 ).'</strong>. So please do reply to confirm to renew</p><br />
								        <table cellpadding="5" style="width: 100%;">
								        	<tbody>
								        		<tr>
									        		<td style="border-top: 1px solid #ccc;">Description</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">Price/Year</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">Year</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">Price</td>
									        	</tr>
									        	<tr style="color: #999;">
									        		<td style="border-top: 1px solid #ccc;">'.$order_name.'</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">'.$unit_price.'.00</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">'.$qty.'</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">'.$total_item.'.00 USD</td>
									        	</tr>';

									if ( !empty($extra_products) ) : 
									    foreach ($extra_products as $extra_product ) {
									    	
									    	$extra_product_price 		= get_post_meta( $extra_product['sp_order_extra_product'], 'sp_product_price', true );
									    	$total_extra_product_price 	= $qty * $extra_product_price ;
									    	$total_extra_product 	   += $total_extra_product_price;

										$message .='<tr style="color: #999;">
									        		<td style="border-top: 1px solid #ccc;">'. $extra_product['title'] .'</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">'.$extra_product_price.'.00</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">'.$qty.'</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">'.$total_extra_product_price.'.00 USD</td>
									        	</tr>';
										}
									endif;

									$sub_total = $total_extra_product + $total_item ;
									if ( get_post_meta( $post->ID, 'sp_order_tax', true ) == "on" ) :
										$tax = $sub_total * 0.10 ;
									endif;
									$grand_total = $sub_total + $tax ;

									$message .='<tr>
									        		<td style="border-top: 1px solid #ccc;"></td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;"></td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">Sub-Total</td>
									        		<td style="border-top: 1px solid #ccc; text-align: right;">'.$sub_total.'.00 USD</td>
									        	</tr>
									        	<tr>
									        		<td></td>
									        		<td></td>
									        		<td style="text-align: right;">VAT 10%</td>
									        		<td style="text-align: right;">'.$tax.' USD</td>
									        	</tr>
									        	<tr>
									        		<td></td>
									        		<td></td>
									        		<td style="text-align: right;">Grand-Total</td>
									        		<td style="text-align: right;">'.$grand_total.' USD</td>
									        	</tr>
								        	<tbody>
								        </table>
								        <p>Kindly Regards</p>
								        <p>NOVA (Cambodia) Co., Ltd<br />
								        <strong>P.</strong> +855 15 777 570<br />
								        <strong>E.</strong> sokheng.lay@novacambodia.com</p><br />
								        <img style="max-width:100%;" src="' . SP_ASSETS .'/images/nova-signature.gif">
								</body>
								</html>';
					$headers[] = 'From: Nova Cambodia <'.$reply.'>';
					wp_mail( $to_client, $subject, $message, $headers );

					if ( ot_get_option( 'send-email' ) == "on" ) :
						$headers[] = 'CC:' . $cc; 
						wp_mail( $to_company, $subject, $message, $headers );
					endif;

		endwhile; wp_reset_postdata();
	?>
	<?php else : ?>
		<h5>There are no product order will expire.</h5>
	<?php	
	endif; 
}

function sp_add_corn_schedule( $schedules ) {
  /*$schedules['per_minute'] = array(
    'interval' => 60, // Every minute
    'display' => __( 'In every minute', SP_TEXT_DOMAIN )
  );*/
  $schedules['weekly'] = array(
    'interval' => 7 * 24 * 60 * 60, //7 days * 24 hours * 60 minutes * 60 seconds 
    'display' => __( 'Once Weekly', SP_TEXT_DOMAIN )
  );
  return $schedules;
}

function sp_get_email_client( $post_id ) {
	global $post;
	$email_client = get_post_meta( $post_id, 'sp_client_email', true );
	
	return $email_client;
}

function sp_get_contact_client( $post_id ) {
	global $post;
	$contact_client = get_post_meta( $post_id, 'sp_client_contact_name', true );
	
	return $contact_client;
}
