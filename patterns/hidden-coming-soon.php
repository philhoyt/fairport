<?php
/**
 * Title: Coming soon
 * Slug: fairport/hidden-coming-soon
 * Inserter: no
 * Description: WooCommerce's coming soon page. With only the store pages hidden it keeps the site header and footer; with the whole site hidden it is a standalone page with a log in link.
 *
 * @package fairport
 */

$fairport_store_only = 'yes' === get_option( 'woocommerce_store_pages_only', 'no' );
?>
<?php if ( $fairport_store_only ) : ?>
<!-- wp:woocommerce/coming-soon {"storeOnly":true,"className":"woocommerce-coming-soon-store-only"} -->
<div class="wp-block-woocommerce-coming-soon woocommerce-coming-soon-store-only">
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|xxl"}}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<main class="wp-block-group" style="padding-top:var(--wp--preset--spacing--xxl);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:heading {"textAlign":"center","level":1} -->
	<h1 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'The shop is opening soon', 'fairport' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","fontSize":"l"} -->
	<p class="has-text-align-center has-l-font-size"><?php esc_html_e( 'We are getting everything ready. Until it opens, the rest of the site is here as usual.', 'fairport' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|l"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--l)">
		<!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the home page', 'fairport' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
</div>
<!-- /wp:woocommerce/coming-soon -->
<?php else : ?>
<!-- wp:woocommerce/coming-soon {"className":"woocommerce-coming-soon-default"} -->
<div class="wp-block-woocommerce-coming-soon woocommerce-coming-soon-default">
<!-- wp:group {"tagName":"main","className":"is-style-section-secondary","style":{"dimensions":{"minHeight":"100vh"},"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
<main class="wp-block-group is-style-section-secondary" style="min-height:100vh;padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)">
	<!-- wp:site-logo {"width":72,"align":"center"} /-->

	<!-- wp:site-title {"level":0,"textAlign":"center","fontSize":"l"} /-->

	<!-- wp:heading {"textAlign":"center","level":1,"style":{"spacing":{"margin":{"top":"var:preset|spacing|l"}}}} -->
	<h1 class="wp-block-heading has-text-align-center" style="margin-top:var(--wp--preset--spacing--l)"><?php esc_html_e( 'Something new is on the way', 'fairport' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","fontSize":"l"} -->
	<p class="has-text-align-center has-l-font-size"><?php esc_html_e( 'We are putting the finishing touches on the site. Check back soon.', 'fairport' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|l"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--l)">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Log in', 'fairport' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</main>
<!-- /wp:group -->
</div>
<!-- /wp:woocommerce/coming-soon -->
<?php endif; ?>
