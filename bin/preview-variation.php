<?php
/**
 * Apply theme style variations to the user global styles record for previewing.
 *
 * Usage: bin/wp.sh eval-file bin/preview-variation.php "Forest Green" "Fraunces & Manrope"
 *        bin/wp.sh eval-file bin/preview-variation.php reset
 *
 * @package fairport
 */

$fairport_id = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();

if ( in_array( 'reset', $args, true ) ) {
	// Core expects valid JSON here; an empty string logs a decode notice on every request.
	wp_update_post(
		array(
			'ID'           => $fairport_id,
			'post_content' => wp_json_encode(
				array(
					'version'                     => 3,
					'isGlobalStylesUserThemeJSON' => true,
				)
			),
		)
	);
	WP_CLI::success( 'Global styles reset.' );
	return;
}

$fairport_merged = array(
	'version'                     => 3,
	'isGlobalStylesUserThemeJSON' => true,
);
foreach ( WP_Theme_JSON_Resolver::get_style_variations() as $fairport_variation ) {
	if ( in_array( $fairport_variation['title'], $args, true ) ) {
		$fairport_merged = array_replace_recursive( $fairport_merged, array_intersect_key( $fairport_variation, array_flip( array( 'settings', 'styles' ) ) ) );
	}
}
wp_update_post(
	array(
		'ID'           => $fairport_id,
		'post_content' => wp_json_encode( $fairport_merged ),
	)
);
WP_CLI::success( 'Applied: ' . implode( ' + ', $args ) );
