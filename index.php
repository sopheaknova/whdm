<?php
/**
 * The main template file.
 */
?>

<?php get_header(); ?>
	<?php do_action( 'sp_start_content_wrap_html' ); ?>

	<!-- <h2>Welcome to <?php echo strtoupper(wp_get_theme()->get( 'Name' )); ?></h2>
	<ul>
	    <li>Theme name: <?php echo SP_THEME_NAME; ?></li>
	    <li>Theme version: <?php echo SP_THEME_VERSION; ?></li>
	    <li>Text domain: <?php echo SP_TEXT_DOMAIN; ?></li>
	</ul> -->

	<h2>Order List</h2>
		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Client Name</th>
					<th>Products</th>
					<th>Register Date</th>
					<th>Expire Date</th>
				</tr>
			</thead>
			<tbody>
			<?php
	    	$args = array(
					'post_type'			=> 'sp_order',
					'posts_per_page'	=>	-1,
					'order'				=> 	'ASC'
					
				);
			$custom_query = new WP_Query( $args );
			$count = 1;
			if( $custom_query->have_posts() ) :
				while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
			
				<tr>
					<td><?php echo $count?></td>
					<td><a class="sp_info_client" href="<?php echo esc_url( get_permalink(get_post_meta( $post->ID, 'sp_order_client_name', true )) ); ?>"><?php echo get_the_title( get_post_meta( $post->ID, 'sp_order_client_name', true ) ); ?></a>
					</td>
					<td><h6><?php the_title(); ?></h6>
						<?php if (get_post_meta( $post->ID, 'sp_order_status_h', true ) == "on" ) : ?>
						<i><?php echo get_post_meta( $post->ID, 'sp_order_domain_name_h', true ); ?></i></br>
						<?php endif ?>
						 
						<i><?php 
							if (get_post_meta( $post->ID, 'sp_order_status_d', true ) == "on" ) :
								echo get_post_meta( $post->ID, 'sp_order_domain_name_d', true );
							endif;
						?></i>
					</td>
					<td><?php 
							if ((get_post_meta( $post->ID, 'sp_order_status_h', true ) == "on" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "on" ) || (get_post_meta( $post->ID, 'sp_order_status_h', true ) == "on" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "off" )) :

							 	echo get_post_meta( $post->ID, 'sp_order_register_date_h', true );
							elseif (get_post_meta( $post->ID, 'sp_order_status_h', true ) == "off" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "on" ) :

								echo get_post_meta( $post->ID, 'sp_order_register_date_d', true );
							endif;
				    	?>
				    </td>
					<td><?php
							if ((get_post_meta( $post->ID, 'sp_order_status_h', true ) == "on" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "on" ) || (get_post_meta( $post->ID, 'sp_order_status_h', true ) == "on" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "off" )) :

							 	echo get_post_meta( $post->ID, 'sp_order_expire_date_h', true );
							elseif (get_post_meta( $post->ID, 'sp_order_status_h', true ) == "off" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "on" ) :

								echo get_post_meta( $post->ID, 'sp_order_expire_date_d', true );
							endif; 
						?>
						</br>

						<?php
							$onemonth = 2592000;
							$expire_h = get_post_meta( $post->ID, 'sp_order_expire_date_h', true );
							$expire_d = get_post_meta( $post->ID, 'sp_order_expire_date_d', true );
							$before_onemonth_h = strtotime($expire_h) - $onemonth;
							$before_onemonth_d = strtotime($expire_d) - $onemonth;

							$now = strtotime('now');
							if ((get_post_meta( $post->ID, 'sp_order_status_h', true ) == "on" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "on" ) || (get_post_meta( $post->ID, 'sp_order_status_h', true ) == "on" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "off" )) :
								$result_onemonth = $before_onemonth_h - $now;
							elseif (get_post_meta( $post->ID, 'sp_order_status_h', true ) == "off" && get_post_meta( $post->ID, 'sp_order_status_d', true ) == "on" ) :
								$result_onemonth = $before_onemonth_d - $now;
							endif;

							if ($result_onemonth <= $onemonth) :
								echo '<i style="color:red">Out Of Date Before 30 Days</i>';
							endif;
						?>
					</td>
				</tr>
			<?php $count++;
			endwhile; wp_reset_postdata();
			endif; ?>
			</tbody>
		</table>
		<script type="text/javascript">
        	jQuery(document).ready(function ($){
	        	$('.sp_info_client').magnificPopup({
					type: 'ajax',
					overflowY: 'scroll'
				});
        });
    	</script>
	<?php do_action( 'sp_end_content_wrap_html' ); ?>
<?php get_footer(); ?>