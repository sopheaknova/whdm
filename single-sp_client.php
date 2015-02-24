
    <div id="custom-content" class="white-popup-block">
    	<?php
			// Start the Loop.
			while ( have_posts() ) : the_post(); ?> 
			<h2><?php the_title(); ?></h2>
			<ul>
					<li><strong>Address: </strong><?php echo get_post_meta( $post->ID, 'sp_client_address', true ); ?></li>
					<li><strong>Contact: </strong><?php echo get_post_meta( $post->ID, 'sp_client_contact_name', true ); ?></li>
					<li><strong>Tel: </strong><?php echo get_post_meta( $post->ID, 'sp_client_telephone', true ); ?></li>
					<li><strong>Mobile: </strong><?php echo get_post_meta( $post->ID, 'sp_client_phone', true ); ?></li>
					<li><strong>Email: </strong><?php echo get_post_meta( $post->ID, 'sp_client_email', true ); ?></li>
			</ul>
		<?php	endwhile;	
		?>
    </div><!-- #main -->
