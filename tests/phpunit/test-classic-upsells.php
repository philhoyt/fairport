<?php
/**
 * The classic upsell list is dropped only where the theme shows upsells.
 *
 * @package fairport
 */

/**
 * Tests for Fairport\Setup\remove_classic_upsells().
 */
class Test_Classic_Upsells extends WP_UnitTestCase {

	/**
	 * Hook the classic upsell display the way WooCommerce does.
	 */
	public function set_up() {
		parent::set_up();
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	}

	/**
	 * Run render_block_data for a pattern block with the given slug.
	 *
	 * @param string $slug Pattern slug.
	 */
	private function render_pattern_data( $slug ) {
		$block = array(
			'blockName'    => 'core/pattern',
			'attrs'        => array( 'slug' => $slug ),
			'innerBlocks'  => array(),
			'innerHTML'    => '',
			'innerContent' => array(),
		);
		apply_filters( 'render_block_data', $block, $block, null );
	}

	/**
	 * The theme's single product pattern unhooks the classic list.
	 */
	public function test_single_product_pattern_unhooks_upsells() {
		$this->render_pattern_data( 'fairport/hidden-single-product' );

		$this->assertFalse( has_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display' ) );
	}

	/**
	 * Any other pattern, such as a child theme's, keeps them.
	 */
	public function test_other_patterns_keep_upsells() {
		$this->render_pattern_data( 'buckland/product-aside' );

		$this->assertSame( 15, has_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display' ) );
	}
}
