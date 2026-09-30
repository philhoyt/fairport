<?php
/**
 * Buttons marked is-current announce themselves as the current page.
 *
 * @package fairport
 */

/**
 * Tests for Fairport\Setup\mark_current_button().
 */
class Test_Current_Button extends WP_UnitTestCase {

	/**
	 * Render a Button block with the given class name.
	 *
	 * @param string $class_name Button className attribute.
	 * @return string
	 */
	private function render_button( $class_name ) {
		$attrs = $class_name ? ',"className":"' . $class_name . '"' : '';
		$html  = '<!-- wp:button {"fontSize":"xs"' . $attrs . '} --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="https://example.com/">Shop</a></div><!-- /wp:button -->';
		return render_block( parse_blocks( $html )[0] );
	}

	/**
	 * The is-current class adds aria-current to the link.
	 */
	public function test_is_current_adds_aria_current() {
		$processor = new WP_HTML_Tag_Processor( $this->render_button( 'is-current' ) );
		$processor->next_tag( array( 'class_name' => 'wp-block-button__link' ) );

		$this->assertSame( 'page', $processor->get_attribute( 'aria-current' ) );
	}

	/**
	 * Other buttons, including outline ones, are left alone.
	 */
	public function test_other_buttons_have_no_aria_current() {
		foreach ( array( '', 'is-style-outline' ) as $class_name ) {
			$this->assertStringNotContainsString( 'aria-current', $this->render_button( $class_name ) );
		}
	}
}
