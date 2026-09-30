<?php
/**
 * Seed a small WooCommerce catalogue for the theme's tests.
 *
 * Run inside wp-env (the afterStart lifecycle script does this):
 *   wp eval-file wp-content/themes/fairport/bin/seed-store.php
 *
 * Safe to rerun: pages are created only when missing, and each product is
 * skipped when its SKU already exists. Dev only; bin/ is not in the theme zip.
 *
 * @package fairport
 */

if ( ! class_exists( 'WooCommerce' ) || ! class_exists( 'WP_CLI' ) ) {
	return;
}

// Shop, Cart, Checkout and My Account pages. A Cart or Checkout page without
// its block (an older shortcode page, say) is replaced, because the theme's
// cart and checkout styles target the blocks.
foreach ( array( 'cart', 'checkout' ) as $fairport_page ) {
	$fairport_page_id = wc_get_page_id( $fairport_page );
	if ( $fairport_page_id > 0 && ! has_block( 'woocommerce/' . $fairport_page, $fairport_page_id ) ) {
		wp_delete_post( $fairport_page_id, true );
		delete_option( 'woocommerce_' . $fairport_page . '_page_id' );
	}
}
WC_Install::create_pages();

// Visitors see the shop, not the coming soon page.
update_option( 'woocommerce_coming_soon', 'no' );

/**
 * Get or create a product category.
 *
 * @param string $name Category name.
 * @return int Term ID.
 */
function fairport_seed_category( $name ) {
	$term = term_exists( $name, 'product_cat' );
	if ( ! $term ) {
		$term = wp_insert_term( $name, 'product_cat' );
	}
	return (int) $term['term_id'];
}

$fairport_gear   = fairport_seed_category( 'Gear' );
$fairport_prints = fairport_seed_category( 'Prints' );

if ( ! wc_get_product_id_by_sku( 'FP-TEST-1' ) ) {
	$fairport_product = new WC_Product_Simple();
	$fairport_product->set_name( 'Trail Map Print' );
	$fairport_product->set_sku( 'FP-TEST-1' );
	$fairport_product->set_regular_price( '30' );
	$fairport_product->set_short_description( 'A print of the canyon trail map.' );
	$fairport_product->set_description( 'Printed on heavy matte stock.' );
	$fairport_product->set_category_ids( array( $fairport_prints ) );
	$fairport_product->set_status( 'publish' );
	$fairport_product->save();
}

if ( ! wc_get_product_id_by_sku( 'FP-TEST-2' ) ) {
	$fairport_product = new WC_Product_Simple();
	$fairport_product->set_name( 'Canyon Water Bottle' );
	$fairport_product->set_sku( 'FP-TEST-2' );
	$fairport_product->set_regular_price( '24' );
	$fairport_product->set_sale_price( '19' );
	$fairport_product->set_short_description( 'Steel bottle with the coalition mark.' );
	$fairport_product->set_category_ids( array( $fairport_gear ) );
	$fairport_product->set_status( 'publish' );
	$fairport_product->save();
}

if ( ! wc_get_product_id_by_sku( 'FP-TEST-3' ) ) {
	// Global Size attribute. wc_create_attribute() registers the attribute but
	// not its taxonomy for this request, so register it before adding terms.
	$fairport_attribute_id = wc_attribute_taxonomy_id_by_name( 'size' );
	if ( ! $fairport_attribute_id ) {
		$fairport_attribute_id = wc_create_attribute(
			array(
				'name'         => 'Size',
				'slug'         => 'size',
				'has_archives' => true,
			)
		);
	}
	if ( ! taxonomy_exists( 'pa_size' ) ) {
		register_taxonomy( 'pa_size', array( 'product' ) );
	}

	$fairport_sizes    = array(
		'small'  => '25',
		'medium' => '25',
		'large'  => '27',
	);
	$fairport_term_ids = array();
	foreach ( array_keys( $fairport_sizes ) as $fairport_size ) {
		$fairport_term = term_exists( $fairport_size, 'pa_size' );
		if ( ! $fairport_term ) {
			$fairport_term = wp_insert_term( ucfirst( $fairport_size ), 'pa_size', array( 'slug' => $fairport_size ) );
		}
		$fairport_term_ids[] = (int) $fairport_term['term_id'];
	}

	$fairport_attribute = new WC_Product_Attribute();
	$fairport_attribute->set_id( $fairport_attribute_id );
	$fairport_attribute->set_name( 'pa_size' );
	$fairport_attribute->set_options( $fairport_term_ids );
	$fairport_attribute->set_visible( true );
	$fairport_attribute->set_variation( true );

	$fairport_product = new WC_Product_Variable();
	$fairport_product->set_name( 'Coalition Tee' );
	$fairport_product->set_sku( 'FP-TEST-3' );
	$fairport_product->set_short_description( 'Organic cotton tee.' );
	$fairport_product->set_category_ids( array( $fairport_gear ) );
	$fairport_product->set_attributes( array( $fairport_attribute ) );
	$fairport_product->set_status( 'publish' );
	$fairport_parent_id = $fairport_product->save();
	wp_set_object_terms( $fairport_parent_id, $fairport_term_ids, 'pa_size' );

	foreach ( $fairport_sizes as $fairport_size => $fairport_price ) {
		$fairport_variation = new WC_Product_Variation();
		$fairport_variation->set_parent_id( $fairport_parent_id );
		$fairport_variation->set_attributes( array( 'pa_size' => $fairport_size ) );
		$fairport_variation->set_regular_price( $fairport_price );
		$fairport_variation->set_stock_status( 'instock' );
		$fairport_variation->set_status( 'publish' );
		$fairport_variation->save();
	}
	WC_Product_Variable::sync( $fairport_parent_id );
}

WP_CLI::log( 'WooCommerce ' . WC()->version . ', ' . count( wc_get_products( array( 'limit' => -1 ) ) ) . ' products.' );
