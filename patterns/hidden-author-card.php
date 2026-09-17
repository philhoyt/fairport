<?php
/**
 * Title: Author card
 * Slug: fairport/hidden-author-card
 * Inserter: no
 * Description: Avatar, "Written by" line, author name and biography in a tinted card.
 *
 * @package fairport
 */

?>
<!-- wp:group {"metadata":{"name":"Author card"},"className":"is-style-section-tint","style":{"spacing":{"padding":{"top":"var:preset|spacing|m","right":"var:preset|spacing|m","bottom":"var:preset|spacing|m","left":"var:preset|spacing|m"},"blockGap":"var:preset|spacing|m","margin":{"top":"var:preset|spacing|xl"}},"border":{"radius":"var:preset|spacing|xs"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group is-style-section-tint" style="border-radius:var(--wp--preset--spacing--xs);margin-top:var(--wp--preset--spacing--xl);padding-top:var(--wp--preset--spacing--m);padding-right:var(--wp--preset--spacing--m);padding-bottom:var(--wp--preset--spacing--m);padding-left:var(--wp--preset--spacing--m)">
	<!-- wp:avatar {"size":64} /-->

	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"700"}}} -->
		<p class="has-xs-font-size" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase"><?php esc_html_e( 'Written by', 'fairport' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:post-author-name {"isLink":true,"fontSize":"l","style":{"typography":{"fontFamily":"var:preset|font-family|display","fontWeight":"700"}}} /-->

		<!-- wp:post-author-biography {"fontSize":"s"} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
