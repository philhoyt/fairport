<?php
/**
 * The WooCommerce stylesheet loads only alongside WooCommerce.
 *
 * @package fairport
 */

/**
 * Tests for Fairport\Setup\enqueue_scripts_and_styles().
 */
class Test_Enqueue extends WP_UnitTestCase {

	/**
	 * Start each test from an empty style queue.
	 */
	public function set_up() {
		parent::set_up();
		$GLOBALS['wp_styles'] = new WP_Styles();
	}

	/**
	 * Without WooCommerce only the main stylesheet is enqueued.
	 */
	public function test_without_woocommerce_only_main_stylesheet_loads() {
		if ( class_exists( 'WooCommerce' ) ) {
			$this->markTestSkipped( 'WooCommerce is loaded; this test covers the site without it.' );
		}

		\Fairport\Setup\enqueue_scripts_and_styles();

		$this->assertTrue( wp_style_is( 'fairport-style', 'enqueued' ) );
		$this->assertFalse( wp_style_is( 'fairport-woocommerce', 'registered' ) );
	}
}
