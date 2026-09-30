<?php
/**
 * Title: Checkout footer
 * Slug: fairport/hidden-checkout-footer
 * Inserter: no
 * Description: Quiet tint footer for the checkout: copyright and a line on where to turn with order questions.
 *
 * @package fairport
 */

?>
<!-- wp:group {"className":"is-style-section-tint","style":{"spacing":{"padding":{"top":"var:preset|spacing|l","bottom":"var:preset|spacing|l"},"margin":{"top":"var:preset|spacing|xxl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-section-tint" style="margin-top:var(--wp--preset--spacing--xxl);padding-top:var(--wp--preset--spacing--l);padding-bottom:var(--wp--preset--spacing--l)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"fontSize":"xs"} -->
		<p class="has-xs-font-size">
			<?php
			printf(
				/* translators: 1: current year, 2: site name. */
				esc_html__( '&copy; %1$s %2$s', 'fairport' ),
				esc_html( gmdate( 'Y' ) ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"fontSize":"xs"} -->
		<p class="has-xs-font-size"><?php esc_html_e( 'Questions about your order? Reply to your order confirmation email and we will get back to you.', 'fairport' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
