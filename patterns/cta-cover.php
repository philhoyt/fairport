<?php
/**
 * Title: Statement over a photo
 * Slug: fairport/cta-cover
 * Categories: call-to-action, banner
 * Viewport Width: 1400
 * Description: Eyebrow, one big statement and an outline button on a photo band with a colour overlay.
 *
 * @package fairport
 */

$fairport_image = get_theme_file_uri( 'assets/images/masthead-2.svg' );
?>
<!-- wp:cover {"url":"<?php echo esc_url( $fairport_image ); ?>","dimRatio":55,"overlayColor":"secondary","isUserOverlayColor":true,"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $fairport_image ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-60 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:paragraph {"align":"center","fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.12em","fontWeight":"700"}}} -->
	<p class="has-text-align-center has-xs-font-size" style="font-weight:700;letter-spacing:0.12em;text-transform:uppercase"><?php esc_html_e( 'Our mission', 'fairport' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"textAlign":"center","level":2,"fontSize":"xxl"} -->
	<h2 class="wp-block-heading has-text-align-center has-xxl-font-size"><?php esc_html_e( 'To protect, care for and open up the places we love, for everyone who comes after us.', 'fairport' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|l"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--l)">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'About the organisation', 'fairport' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div></div>
<!-- /wp:cover -->
