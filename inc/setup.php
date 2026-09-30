<?php
/**
 * Theme setup.
 *
 * @package fairport
 */

namespace Fairport\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since 1.0.0
 * @return void
 */
function setup() {
	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'fairport', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Add support for post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// The theme ships its own patterns in the patterns directory.
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );

/**
 * Enqueue scripts and styles for the front-end.
 *
 * Loads the main stylesheet with proper versioning from the build process.
 * Falls back to the theme version if the asset file doesn't exist.
 *
 * @since 1.0.0
 * @return void
 */
function enqueue_scripts_and_styles() {
	// Get style asset info.
	$style_asset_path = get_template_directory() . '/dist/css/style.asset.php';
	$style_asset      = array(
		'version' => wp_get_theme()->get( 'Version' ),
	);

	if ( file_exists( $style_asset_path ) ) {
		$style_asset = require $style_asset_path;
	}

	// Enqueue main stylesheet.
	wp_enqueue_style(
		'fairport-style',
		get_template_directory_uri() . '/dist/css/style.css',
		array(),
		$style_asset['version']
	);

	// The build writes style-rtl.css alongside; serve it on RTL sites.
	wp_style_add_data( 'fairport-style', 'rtl', 'replace' );

	if ( is_woocommerce_active() ) {
		$woo_asset_path = get_template_directory() . '/dist/css/woocommerce.asset.php';
		$woo_asset      = file_exists( $woo_asset_path ) ? require $woo_asset_path : $style_asset;

		wp_enqueue_style(
			'fairport-woocommerce',
			get_template_directory_uri() . '/dist/css/woocommerce.css',
			array( 'fairport-style' ),
			$woo_asset['version']
		);
		wp_style_add_data( 'fairport-woocommerce', 'rtl', 'replace' );
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts_and_styles' );

/**
 * Whether WooCommerce is active.
 *
 * Plugins load before the theme, so this is reliable from after_setup_theme on.
 *
 * @since 1.1.0
 * @return bool
 */
function is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

/**
 * Keep the store templates out of the post editor's template picker.
 *
 * Core offers every theme template file that declares no postTypes as a
 * template for any post or page, so "Page: Cart" or "Single Product" would be
 * listed under "Change template". WooCommerce reaches these templates by URL,
 * never by assignment. Only the picker queries with a post_type, so the Site
 * Editor still lists and edits them.
 *
 * @since 1.1.0
 * @param \WP_Block_Template[] $templates     Found templates.
 * @param array                $query         Template query arguments.
 * @param string               $template_type wp_template or wp_template_part.
 * @return \WP_Block_Template[]
 */
function hide_store_templates_from_picker( $templates, $query, $template_type ) {
	if ( 'wp_template' !== $template_type || empty( $query['post_type'] ) ) {
		return $templates;
	}

	$store_templates = array(
		'archive-product',
		'coming-soon',
		'order-confirmation',
		'page-cart',
		'page-checkout',
		'page-my-account',
		'product-search-results',
		'single-product',
		'taxonomy-product_attribute',
	);

	return array_values(
		array_filter(
			$templates,
			static function ( $template ) use ( $store_templates ) {
				return ! in_array( $template->slug, $store_templates, true );
			}
		)
	);
}
add_filter( 'get_block_templates', __NAMESPACE__ . '\\hide_store_templates_from_picker', 20, 3 );

/**
 * Mark the link of a button carrying the is-current class as the current page.
 *
 * The aria-current attribute is not part of the Button block, so writing it into saved
 * markup would fail block validation. Patterns such as the shop category row
 * mark the current button with a class and this adds the attribute on output.
 *
 * @since 1.1.0
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Parsed block.
 * @return string
 */
function mark_current_button( $block_content, $block ) {
	$class_name = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( ! in_array( 'is-current', explode( ' ', $class_name ), true ) ) {
		return $block_content;
	}

	$processor = new \WP_HTML_Tag_Processor( $block_content );
	if ( $processor->next_tag( array( 'class_name' => 'wp-block-button__link' ) ) ) {
		$processor->set_attribute( 'aria-current', 'page' );
	}

	return $processor->get_updated_html();
}
add_filter( 'render_block_core/button', __NAMESPACE__ . '\\mark_current_button', 10, 2 );

/**
 * Drop WooCommerce's classic upsell list from single products.
 *
 * WooCommerce's compatibility layer prints woocommerce_upsell_display after
 * the product blocks for classic themes. The single product pattern shows
 * upsells with an Upsells product collection instead, so without this they
 * would appear twice, the second time as an unstyled list.
 *
 * Only unhook when that pattern is about to render, so a child theme's own
 * single product template keeps WooCommerce's upsells.
 *
 * @since 1.1.0
 * @param array $parsed_block Block about to be rendered.
 * @return array
 */
function remove_classic_upsells( $parsed_block ) {
	if (
		isset( $parsed_block['blockName'], $parsed_block['attrs']['slug'] )
		&& 'core/pattern' === $parsed_block['blockName']
		&& 'fairport/hidden-single-product' === $parsed_block['attrs']['slug']
	) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	}

	return $parsed_block;
}
add_filter( 'render_block_data', __NAMESPACE__ . '\\remove_classic_upsells' );

/**
 * Add editor styles support and enqueue editor stylesheet.
 *
 * Enables theme support for editor styles and loads the editor-specific
 * stylesheet for the block editor.
 *
 * @since 1.0.0
 * @return void
 */
function add_editor_styles() {
	// Add theme support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'dist/css/editor.css' );

	// Cart, checkout and product blocks render in the editor too.
	if ( is_woocommerce_active() ) {
		add_editor_style( 'dist/css/woocommerce.css' );
	}
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\add_editor_styles' );

/**
 * Register the pattern category used by the full-page starter patterns.
 *
 * Section styles live in styles/blocks/*.json and need no registration.
 *
 * @since 1.0.0
 * @return void
 */
function register_pattern_categories() {
	register_block_pattern_category(
		'fairport_page',
		array(
			'label'       => _x( 'Pages', 'Block pattern category', 'fairport' ),
			'description' => __( 'A collection of full page layouts.', 'fairport' ),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\\register_pattern_categories' );

/**
 * Register block styles that need real CSS rather than theme.json properties.
 *
 * @since 1.0.0
 * @return void
 */
function register_block_styles() {
	register_block_style(
		'core/list',
		array(
			'name'         => 'plain-list',
			'label'        => __( 'Plain', 'fairport' ),
			'inline_style' => '.wp-block-list.is-style-plain-list { list-style: none; padding-inline-start: 0; }',
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\\register_block_styles' );
