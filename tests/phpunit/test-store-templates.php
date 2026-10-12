<?php
/**
 * Store templates and checkout parts are theme files only while WooCommerce
 * is active.
 *
 * @package fairport
 */

/**
 * Tests for the WooCommerce-inactive template filters in Fairport\Setup.
 */
class Test_Store_Templates extends WP_UnitTestCase {

	/**
	 * A template object with the given slug and source.
	 *
	 * @param string $slug   Template slug.
	 * @param string $source theme or custom.
	 * @return WP_Block_Template
	 */
	private function template( $slug, $source = 'theme' ) {
		$template         = new WP_Block_Template();
		$template->slug   = $slug;
		$template->theme  = 'fairport';
		$template->source = $source;
		return $template;
	}

	/**
	 * Theme-file store templates and checkout parts are recognised; other
	 * templates and customised copies are not.
	 */
	public function test_store_template_files_are_recognised() {
		$this->assertTrue( \Fairport\Setup\is_store_template_file( $this->template( 'page-cart' ), 'wp_template' ) );
		$this->assertTrue( \Fairport\Setup\is_store_template_file( $this->template( 'checkout-header' ), 'wp_template_part' ) );
		$this->assertFalse( \Fairport\Setup\is_store_template_file( $this->template( 'page' ), 'wp_template' ) );
		$this->assertFalse( \Fairport\Setup\is_store_template_file( $this->template( 'checkout-header' ), 'wp_template' ) );
		$this->assertFalse( \Fairport\Setup\is_store_template_file( $this->template( 'page-cart', 'custom' ), 'wp_template' ) );
	}

	/**
	 * Removing store files keeps everything else, in order, re-indexed.
	 */
	public function test_store_files_are_removed_from_a_list() {
		$templates = \Fairport\Setup\remove_store_template_files(
			array( $this->template( 'single-product' ), $this->template( 'page' ), $this->template( 'page-cart', 'custom' ), $this->template( 'index' ) ),
			'wp_template'
		);

		$this->assertSame( array( 'page', 'page-cart', 'index' ), wp_list_pluck( $templates, 'slug' ) );
		$this->assertSame( array( 0, 1, 2 ), array_keys( $templates ) );

		$parts = \Fairport\Setup\remove_store_template_files(
			array( $this->template( 'checkout-footer' ), $this->template( 'footer' ) ),
			'wp_template_part'
		);

		$this->assertSame( array( 'footer' ), wp_list_pluck( $parts, 'slug' ) );
	}

	/**
	 * The slug lists name every store template file and both checkout parts.
	 */
	public function test_slug_lists_match_the_theme_files() {
		foreach ( \Fairport\Setup\store_template_slugs( 'wp_template' ) as $slug ) {
			$this->assertFileExists( get_template_directory() . '/templates/' . $slug . '.html' );
		}
		foreach ( \Fairport\Setup\store_template_slugs( 'wp_template_part' ) as $slug ) {
			$this->assertFileExists( get_template_directory() . '/parts/' . $slug . '.html' );
		}
		$this->assertCount( 9, \Fairport\Setup\store_template_slugs( 'wp_template' ) );
	}

	/**
	 * The test suite loads no plugins, so WooCommerce is inactive here and the
	 * hooked filters drop the theme's store files and refuse them by id.
	 */
	public function test_store_files_are_hidden_while_woocommerce_is_inactive() {
		$this->assertFalse( class_exists( 'WooCommerce' ), 'The PHPUnit site runs without WooCommerce.' );

		$slugs = wp_list_pluck( get_block_templates( array(), 'wp_template' ), 'slug' );
		$this->assertContains( 'page', $slugs );
		$this->assertContains( 'page-no-title', $slugs );
		foreach ( \Fairport\Setup\store_template_slugs( 'wp_template' ) as $store_slug ) {
			$this->assertNotContains( $store_slug, $slugs );
		}

		$parts = wp_list_pluck( get_block_templates( array(), 'wp_template_part' ), 'slug' );
		$this->assertContains( 'footer', $parts );
		$this->assertNotContains( 'checkout-header', $parts );
		$this->assertNotContains( 'checkout-footer', $parts );

		$this->assertNull( get_block_template( 'fairport//page-cart' ) );
		$this->assertNull( get_block_template( 'fairport//checkout-header', 'wp_template_part' ) );
		$this->assertInstanceOf( 'WP_Block_Template', get_block_template( 'fairport//page' ) );
	}

	/**
	 * A page slugged like a store page resolves to the page template, not to
	 * page-cart.html, while WooCommerce is inactive.
	 */
	public function test_store_page_slugs_use_the_page_template_while_woocommerce_is_inactive() {
		$page_id = self::factory()->post->create(
			array(
				'post_type'   => 'page',
				'post_name'   => 'cart',
				'post_status' => 'publish',
			)
		);

		$this->go_to( get_permalink( $page_id ) );
		$resolved = resolve_block_template( 'page', array( 'page-cart.php', 'page.php' ), '' );

		$this->assertInstanceOf( 'WP_Block_Template', $resolved );
		$this->assertSame( 'page', $resolved->slug );
	}

	/**
	 * A customised copy of a store template is the user's content and stays.
	 */
	public function test_customised_store_template_is_kept_while_woocommerce_is_inactive() {
		$custom = $this->template( 'page-cart', 'custom' );
		$kept   = \Fairport\Setup\hide_store_templates_without_woocommerce( array( $custom, $this->template( 'page-cart' ) ), array(), 'wp_template' );

		$this->assertSame( array( $custom ), $kept );
		$this->assertSame( $custom, \Fairport\Setup\hide_store_template_without_woocommerce( $custom, 'fairport//page-cart', 'wp_template' ) );
		$this->assertNull( \Fairport\Setup\hide_store_template_without_woocommerce( null, 'fairport//page-cart', 'wp_template' ) );
	}
}
