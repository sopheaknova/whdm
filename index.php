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
		<table class="order-list">
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

				<?php 
					$reminder = 2592000; // 90 days = 7776000;
					$expire_h = get_post_meta( $post->ID, 'sp_order_expire_date_h', true );
					$expire_d = get_post_meta( $post->ID, 'sp_order_expire_date_d', true );
					$before_reminder_h = strtotime($expire_h) - $reminder;
					$before_reminder_d = strtotime($expire_d) - $reminder;
					$status_h = get_post_meta( $post->ID, 'sp_order_status_h', true );
					$status_d = get_post_meta( $post->ID, 'sp_order_status_d', true );
					$now = strtotime('now');
					
					if ( $status_h == "on" ) :
						$reminder_h = $before_reminder_h - $now;
					elseif ($status_h == "off" && $status_d == "on" ) :
						$reminder_d = $before_reminder_d - $now;
					endif;
				?>
			
				<tr>
					<td><?php echo $count?></td>
					<td>
						<a class="sp-info-client" href="<?php echo esc_url( get_permalink(get_post_meta( $post->ID, 'sp_order_client_name', true )) ); ?>"><?php echo get_the_title( get_post_meta( $post->ID, 'sp_order_client_name', true ) ); ?></a>
					</td>
					<td><h5><a href="<?php echo admin_url( 'post.php?post=' . $post->ID ) . '&action=edit'; ?>"><?php the_title(); ?></a></h5>
						<?php if ($status_h == "on" ) : ?>
						<span><?php echo get_post_meta( $post->ID, 'sp_order_domain_name_h', true ); ?></span>
						<?php endif ?>
						 
						
						<?php if ($status_d == "on" ) : ?>
						<div class="addon-domain">	
							<h6>Addon domain:</h6> 	
							<span><?php echo get_post_meta( $post->ID, 'sp_order_domain_name_d', true ); ?> </span>
							<span class="addon-expire">Expire on: <?php echo date("j F, Y", strtotime(get_post_meta( $post->ID, 'sp_order_expire_date_d', true ))); ?> </span>
						</div>
						<?php endif; ?>
					</td>
					<td><?php 
							if ( $status_h == "on" ) :
							 	echo date("j F, Y", strtotime(get_post_meta( $post->ID, 'sp_order_register_date_h', true )));
							endif;
				    	?>
				    </td>
					<td><?php
							if ( $status_h == "on" ) :
							 	echo  date("j F, Y", strtotime(get_post_meta( $post->ID, 'sp_order_expire_date_h', true )));
							endif; 
						?>
						<br>

						<?php
							if ($reminder_h <= $reminder) :
								echo '<i style="color:red">Renewal</i>';
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
	        	$('.sp-info-client').magnificPopup({
					type: 'ajax',
					overflowY: 'scroll'
			});
        });
    	</script>
	<?php do_action( 'sp_end_content_wrap_html' ); ?>
<?php get_footer(); ?>