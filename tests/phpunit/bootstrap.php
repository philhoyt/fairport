<?php
/**
 * PHPUnit bootstrap file.
 *
 * Loads the WordPress test suite when running integration tests, and
 * registers this directory as a theme root so the suite activates Fairport.
 * For unit tests (tests/phpunit/unit/) no WordPress bootstrap is needed.
 *
 * @package fairport
 */

declare( strict_types=1 );

$wp_tests_dir = getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';

if ( ! file_exists( $wp_tests_dir . '/includes/functions.php' ) ) {
	// Unit test suite — no WordPress bootstrap needed.
	return;
}

// Required by the WP Core test bootstrap — points to the installed polyfills library.
define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', dirname( __DIR__, 2 ) . '/vendor/yoast/phpunit-polyfills' );

require_once $wp_tests_dir . '/includes/functions.php';

$fairport_theme_dir  = dirname( __DIR__, 2 );
$fairport_theme_root = dirname( $fairport_theme_dir );
$fairport_theme_slug = basename( $fairport_theme_dir );

/**
 * Point the test suite at this theme.
 *
 * The parent directory is registered as an extra theme root, and the
 * stylesheet/template options are forced to this theme's slug.
 */
tests_add_filter(
	'setup_theme',
	static function () use ( $fairport_theme_root, $fairport_theme_slug ) {
		register_theme_directory( $fairport_theme_root );
		add_filter( 'pre_option_template', static fn() => $fairport_theme_slug );
		add_filter( 'pre_option_stylesheet', static fn() => $fairport_theme_slug );
	}
);

require $wp_tests_dir . '/includes/bootstrap.php';
