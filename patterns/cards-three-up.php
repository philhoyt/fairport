<?php
/**
 * Title: Three signposts
 * Slug: fairport/cards-three-up
 * Categories: featured, columns
 * Viewport Width: 1400
 * Description: Three linked image cards, each with a heading and one line of copy.
 *
 * @package fairport
 */

$fairport_cards = array(
	array(
		'image' => get_theme_file_uri( 'assets/images/card-1.svg' ),
		'title' => __( 'Get involved', 'fairport' ),
		'text'  => __( 'Join the people who keep this place running.', 'fairport' ),
	),
	array(
		'image' => get_theme_file_uri( 'assets/images/card-2.svg' ),
		'title' => __( 'Explore', 'fairport' ),
		'text'  => __( 'Photos, stories and field notes from the ground.', 'fairport' ),
	),
	array(
		'image' => get_theme_file_uri( 'assets/images/card-3.svg' ),
		'title' => __( 'Support', 'fairport' ),
		'text'  => __( 'Every contribution goes straight back into the work.', 'fairport' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|xxl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--xxl);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|xl"}}}} -->
	<div class="wp-block-columns alignwide">
		<?php foreach ( $fairport_cards as $fairport_card ) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"custom","aspectRatio":"4/3","scale":"cover","style":{"border":{"radius":"var:preset|spacing|xs"}}} -->
			<figure class="wp-block-image size-large has-custom-border"><a href="#"><img src="<?php echo esc_url( $fairport_card['image'] ); ?>" alt="" style="border-radius:var(--wp--preset--spacing--xs);aspect-ratio:4/3;object-fit:cover"/></a></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"textAlign":"center","level":2,"fontSize":"xl","style":{"spacing":{"margin":{"top":"var:preset|spacing|m","bottom":"var:preset|spacing|xs"}}}} -->
			<h2 class="wp-block-heading has-text-align-center has-xl-font-size" style="margin-top:var(--wp--preset--spacing--m);margin-bottom:var(--wp--preset--spacing--xs)"><a href="#"><?php echo esc_html( $fairport_card['title'] ); ?></a></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center"><?php echo esc_html( $fairport_card['text'] ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
