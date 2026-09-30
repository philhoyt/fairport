<?php
/**
 * Store templates stay out of the post editor's template picker.
 *
 * @package fairport
 */

/**
 * Tests for Fairport\Setup\hide_store_templates_from_picker().
 */
class Test_Template_Picker extends WP_UnitTestCase {

	/**
	 * A theme template object with the given slug.
	 *
	 * @param string $slug Template slug.
	 * @return WP_Block_Template
	 */
	private function template( $slug ) {
		$template        = new WP_Block_Template();
		$template->slug  = $slug;
		$template->theme = 'fairport';
		return $template;
	}

	/**
	 * The REST picker query (with a post_type) drops store templates.
	 */
	public function test_post_type_query_drops_store_templates() {
		$templates = \Fairport\Setup\hide_store_templates_from_picker(
			array( $this->template( 'page-cart' ), $this->template( 'single-product' ), $this->template( 'page-no-title' ) ),
			array( 'post_type' => 'page' ),
			'wp_template'
		);

		$this->assertSame( array( 'page-no-title' ), wp_list_pluck( $templates, 'slug' ) );
	}

	/**
	 * Without a post_type (Site Editor, WP_Theme::get_post_templates()) store
	 * templates stay listed but are limited to no post types.
	 */
	public function test_query_without_post_type_keeps_store_templates_with_no_post_types() {
		$templates = \Fairport\Setup\hide_store_templates_from_picker(
			array( $this->template( 'page-checkout' ), $this->template( 'page-no-title' ) ),
			array(),
			'wp_template'
		);

		$this->assertSame( array( 'page-checkout', 'page-no-title' ), wp_list_pluck( $templates, 'slug' ) );
		$this->assertSame( array(), $templates[0]->post_types );
		$this->assertNull( $templates[1]->post_types );
	}

	/**
	 * Template parts pass through untouched.
	 */
	public function test_template_parts_are_untouched() {
		$part      = $this->template( 'page-cart' );
		$templates = \Fairport\Setup\hide_store_templates_from_picker( array( $part ), array( 'post_type' => 'page' ), 'wp_template_part' );

		$this->assertSame( array( $part ), $templates );
	}

	/**
	 * The page template list the editor builds offers no store template.
	 */
	public function test_page_templates_offer_no_store_templates() {
		$slugs = array_keys( wp_get_theme()->get_page_templates( null, 'page' ) );

		$this->assertContains( 'page-no-title', $slugs );
		foreach ( array( 'archive-product', 'page-cart', 'page-checkout', 'page-my-account', 'single-product', 'order-confirmation', 'coming-soon' ) as $store_slug ) {
			$this->assertNotContains( $store_slug, $slugs );
		}
	}
}
