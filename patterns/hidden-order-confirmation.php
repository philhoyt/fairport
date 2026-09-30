<?php
/**
 * Title: Order confirmation
 * Slug: fairport/hidden-order-confirmation
 * Inserter: no
 * Description: Order status in a secondary band, then the order summary, totals, downloads, addresses and any additional fields.
 *
 * @package fairport
 */

?>
<!-- wp:group {"align":"full","className":"is-style-section-secondary","style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-secondary" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)">
	<!-- wp:woocommerce/order-confirmation-status {"align":"wide","className":"has-text-align-center","fontSize":"l"} /-->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xxl"},"blockGap":"var:preset|spacing|xl"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:woocommerce/order-confirmation-summary {"align":"wide","fontSize":"s"} /-->

	<!-- wp:woocommerce/order-confirmation-create-account {"align":"wide","className":"is-style-section-tint","style":{"border":{"radius":"var:preset|spacing|xs"},"spacing":{"padding":{"top":"var:preset|spacing|m","right":"var:preset|spacing|l","bottom":"var:preset|spacing|m","left":"var:preset|spacing|l"}}}} -->
	<div class="wp-block-woocommerce-order-confirmation-create-account alignwide is-style-section-tint" style="border-radius:var(--wp--preset--spacing--xs);padding-top:var(--wp--preset--spacing--m);padding-right:var(--wp--preset--spacing--l);padding-bottom:var(--wp--preset--spacing--m);padding-left:var(--wp--preset--spacing--l)">
		<!-- wp:heading {"level":3,"fontSize":"l"} -->
		<h3 class="wp-block-heading has-l-font-size">
			<?php
			printf(
				/* translators: %s: site name. */
				esc_html__( 'Create an account with %s', 'fairport' ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</h3>
		<!-- /wp:heading -->

		<!-- wp:list {"className":"is-style-checkmark-list","fontSize":"s"} -->
		<ul class="wp-block-list is-style-checkmark-list has-s-font-size">
			<!-- wp:list-item -->
			<li><?php esc_html_e( 'Faster future purchases', 'fairport' ); ?></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><?php esc_html_e( 'Securely save payment info', 'fairport' ); ?></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><?php esc_html_e( 'Track orders and view shopping history', 'fairport' ); ?></li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
	</div>
	<!-- /wp:woocommerce/order-confirmation-create-account -->

	<!-- wp:woocommerce/order-confirmation-totals-wrapper {"align":"wide"} -->
		<!-- wp:heading {"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Order details', 'fairport' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:woocommerce/order-confirmation-totals {"lock":{"remove":true},"fontSize":"s"} /-->
	<!-- /wp:woocommerce/order-confirmation-totals-wrapper -->

	<!-- wp:woocommerce/order-confirmation-downloads-wrapper {"align":"wide"} -->
		<!-- wp:heading {"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Downloads', 'fairport' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:woocommerce/order-confirmation-downloads {"lock":{"remove":true},"fontSize":"s"} /-->
	<!-- /wp:woocommerce/order-confirmation-downloads-wrapper -->

	<!-- wp:columns {"align":"wide","className":"wc-block-order-confirmation-address-wrapper","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|l","left":"var:preset|spacing|xl"}}}} -->
	<div class="wp-block-columns alignwide wc-block-order-confirmation-address-wrapper">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:woocommerce/order-confirmation-shipping-wrapper {"align":"wide"} -->
				<!-- wp:heading {"fontSize":"xl"} -->
				<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Shipping address', 'fairport' ); ?></h2>
				<!-- /wp:heading -->

				<!-- wp:woocommerce/order-confirmation-shipping-address {"lock":{"remove":true},"fontSize":"s"} /-->
			<!-- /wp:woocommerce/order-confirmation-shipping-wrapper -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:woocommerce/order-confirmation-billing-wrapper {"align":"wide"} -->
				<!-- wp:heading {"fontSize":"xl"} -->
				<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Billing address', 'fairport' ); ?></h2>
				<!-- /wp:heading -->

				<!-- wp:woocommerce/order-confirmation-billing-address {"lock":{"remove":true},"fontSize":"s"} /-->
			<!-- /wp:woocommerce/order-confirmation-billing-wrapper -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:woocommerce/order-confirmation-additional-fields-wrapper {"align":"wide"} -->
		<!-- wp:heading {"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php esc_html_e( 'Additional information', 'fairport' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:woocommerce/order-confirmation-additional-fields {"fontSize":"s"} /-->
	<!-- /wp:woocommerce/order-confirmation-additional-fields-wrapper -->

	<!-- wp:woocommerce/order-confirmation-additional-information {"align":"wide"} /-->
</div>
<!-- /wp:group -->
