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
		<!-- wp:group {"style":{"spacing":{"blockGap":"0.35em"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"fontSize":"xs"} -->
			<p class="has-xs-font-size">©</p>
			<!-- /wp:paragraph -->

			<!-- wp:site-title {"level":0,"isLink":false,"fontSize":"xs"} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"fontSize":"xs"} -->
		<p class="has-xs-font-size"><?php esc_html_e( 'Questions about your order? Reply to your order confirmation email and we will get back to you.', 'fairport' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
