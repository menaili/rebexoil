<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Induscity
 */
?>
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div><!-- #content -->

	<?php do_action( 'induscity_before_footer' ) ?>

	<footer id="colophon" class="site-footer">
		<?php do_action( 'induscity_footer' ) ?>
	</footer><!-- #colophon -->

	<?php do_action( 'induscity_after_footer' ) ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
