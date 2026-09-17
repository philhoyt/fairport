<?php
/**
 * Title: Team member
 * Slug: fairport/team-member
 * Categories: team, about
 * Viewport Width: 1400
 * Description: Portrait beside a name, role and short bio. Stack several for a board or staff page.
 *
 * @package fairport
 */

$fairport_image = get_theme_file_uri( 'assets/images/portrait.svg' );
?>
<!-- wp:columns {"verticalAlignment":"top","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|m","left":"var:preset|spacing|l"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-top">
	<!-- wp:column {"verticalAlignment":"top","width":"25%"} -->
	<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:25%">
		<!-- wp:image {"sizeSlug":"large","linkDestination":"none","aspectRatio":"1","scale":"cover","style":{"border":{"radius":"var:preset|spacing|xs"}}} -->
		<figure class="wp-block-image size-large has-custom-border"><img src="<?php echo esc_url( $fairport_image ); ?>" alt="" style="border-radius:var(--wp--preset--spacing--xs);aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /wp:image -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"verticalAlignment":"top"} -->
	<div class="wp-block-column is-vertically-aligned-top">
		<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"bottom":"0"}}}} -->
		<h3 class="wp-block-heading" style="margin-bottom:0"><?php esc_html_e( 'Alex Rivera', 'fairport' ); ?></h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"700"},"spacing":{"margin":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|s"}}}} -->
		<p class="has-xs-font-size" style="margin-top:var(--wp--preset--spacing--xs);margin-bottom:var(--wp--preset--spacing--s);font-weight:700;letter-spacing:0.08em;text-transform:uppercase"><?php esc_html_e( 'President', 'fairport' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p><?php esc_html_e( 'Two or three sentences about this person: how they got here, what they look after, and the thing they would talk about all day if you let them.', 'fairport' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
