<?php
/**
 * Title: Page title banner
 * Slug: fairport/banner-page-title
 * Categories: banner
 * Viewport Width: 1400
 * Description: Photo masthead with a colour overlay and a single page title.
 *
 * @package fairport
 */

$fairport_image = get_theme_file_uri( 'assets/images/masthead-3.svg' );
?>
<!-- wp:cover {"url":"<?php echo esc_url( $fairport_image ); ?>","dimRatio":60,"overlayColor":"secondary","isUserOverlayColor":true,"minHeight":420,"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull" style="min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-60 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $fairport_image ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
	<!-- wp:heading {"textAlign":"center","level":1} -->
	<h1 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'About us', 'fairport' ); ?></h1>
	<!-- /wp:heading -->
</div></div>
<!-- /wp:cover -->
