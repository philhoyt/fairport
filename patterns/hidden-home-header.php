<?php
/**
 * Title: Blog header
 * Slug: fairport/hidden-home-header
 * Inserter: no
 * Description: Secondary band with the posts page title.
 *
 * @package fairport
 */

$fairport_posts_page = (int) get_option( 'page_for_posts' );
$fairport_title      = $fairport_posts_page ? get_the_title( $fairport_posts_page ) : '';
if ( '' === $fairport_title ) {
	$fairport_title = _x( 'Blog', 'Posts page heading', 'fairport' );
}
?>
<!-- wp:group {"align":"full","className":"is-style-section-secondary","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|xxl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-secondary" style="padding-top:var(--wp--preset--spacing--xxl);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:heading {"textAlign":"center","level":1} -->
	<h1 class="wp-block-heading has-text-align-center"><?php echo esc_html( $fairport_title ); ?></h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->
