<?php
/**
 * Title: Checkout header
 * Slug: fairport/hidden-checkout-header
 * Inserter: no
 * Description: Pared-back header for the checkout: logo and site title, a "Secure checkout" label and a link back to the cart, with no navigation to lead shoppers away.
 *
 * @package fairport
 */

?>
<!-- wp:group {"className":"site-header","style":{"border":{"bottom":{"color":"var:preset|color|contrast-light","style":"solid","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|s","bottom":"var:preset|spacing|s"}}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group site-header has-base-background-color has-background" style="border-bottom-color:var(--wp--preset--color--contrast-light);border-bottom-style:solid;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--s);padding-bottom:var(--wp--preset--spacing--s)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|s"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
		<div class="wp-block-group">
			<!-- wp:site-logo {"width":56} /-->
			<!-- wp:site-title {"level":0} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|m"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"700"}}} -->
			<p class="has-xs-font-size" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase"><?php esc_html_e( 'Secure checkout', 'fairport' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:woocommerce/cart-link {"content":"<?php echo esc_attr_x( 'Back to cart', 'Checkout header link to the cart.', 'fairport' ); ?>","fontSize":"xs"} /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
