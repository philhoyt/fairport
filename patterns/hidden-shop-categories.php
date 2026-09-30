<?php
/**
 * Title: Shop categories
 * Slug: fairport/hidden-shop-categories
 * Inserter: no
 * Description: A row of buttons, one per product category with products, plus "All products". The current one is filled.
 *
 * @package fairport
 */

if ( ! taxonomy_exists( 'product_cat' ) ) {
	return;
}

$fairport_terms = get_terms(
	array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'orderby'    => 'name',
	)
);

// One category is no choice at all, so show nothing.
if ( is_wp_error( $fairport_terms ) || count( $fairport_terms ) < 2 ) {
	return;
}

$fairport_queried = get_queried_object();
$fairport_current = ( $fairport_queried instanceof WP_Term && 'product_cat' === $fairport_queried->taxonomy ) ? $fairport_queried->term_id : 0;
$fairport_shop    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

// The current button carries is-current rather than aria-current, which the
// Button block cannot save; inc/setup.php adds aria-current on output.

$fairport_links = array(
	array(
		'label'   => __( 'All products', 'fairport' ),
		'url'     => $fairport_shop,
		// Only the shop itself: a tag or attribute archive is not "all products".
		'current' => ! ( $fairport_queried instanceof WP_Term ),
	),
);
foreach ( $fairport_terms as $fairport_term ) {
	$fairport_url = get_term_link( $fairport_term );
	if ( is_wp_error( $fairport_url ) ) {
		continue;
	}
	$fairport_links[] = array(
		'label'   => $fairport_term->name,
		'url'     => $fairport_url,
		'current' => $fairport_current === $fairport_term->term_id,
	);
}
?>
<!-- wp:buttons {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|xs","margin":{"bottom":"var:preset|spacing|l"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons alignwide" style="margin-bottom:var(--wp--preset--spacing--l)">
	<?php foreach ( $fairport_links as $fairport_link ) : ?>
		<?php if ( $fairport_link['current'] ) : ?>
	<!-- wp:button {"className":"is-current","fontSize":"xs"} -->
	<div class="wp-block-button has-custom-font-size is-current has-xs-font-size"><a class="wp-block-button__link has-xs-font-size has-custom-font-size wp-element-button" href="<?php echo esc_url( $fairport_link['url'] ); ?>"><?php echo esc_html( $fairport_link['label'] ); ?></a></div>
	<!-- /wp:button -->
		<?php else : ?>
	<!-- wp:button {"className":"is-style-outline","fontSize":"xs"} -->
	<div class="wp-block-button has-custom-font-size is-style-outline has-xs-font-size"><a class="wp-block-button__link has-xs-font-size has-custom-font-size wp-element-button" href="<?php echo esc_url( $fairport_link['url'] ); ?>"><?php echo esc_html( $fairport_link['label'] ); ?></a></div>
	<!-- /wp:button -->
		<?php endif; ?>
	<?php endforeach; ?>
</div>
<!-- /wp:buttons -->
