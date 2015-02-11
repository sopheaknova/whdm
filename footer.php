	<footer id="footer">
        <div class="container clearfix">
        	<nav id="footer-nav" class="clearfix">
	        	<?php echo sp_footer_navigation(); ?>
        	</nav>
            <p class="copyright">
                <?php if ( ot_get_option( 'copyright' ) ): ?>
                    <?php echo ot_get_option( 'copyright' ); ?>
                <?php else: ?>
                    <?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'All Rights Reserved.', SP_TEXT_DOMAIN ); ?>
                <?php endif; ?>
            </p><!--/.copyright-->
            
        </div><!-- .container .clearfix -->
    </footer><!-- #footer -->

	</div> <!-- end #content-container -->
</div> <!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>