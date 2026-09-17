<?php
/**
 * Title: About
 * Slug: fairport/page-about
 * Categories: fairport_page
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport Width: 1400
 * Description: About page: title banner, intro, a call to action band and a team list. Use with the "Page (No Title)" template.
 *
 * @package fairport
 */

?>
<!-- wp:pattern {"slug":"fairport/banner-page-title"} /-->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|xxl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--xxl);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:paragraph {"fontSize":"l"} -->
	<p class="has-l-font-size"><?php esc_html_e( 'Start with the mission in one paragraph: what you do, where you do it, and who it is for. Keep it plain. The rest of the page can carry the detail.', 'fairport' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph -->
	<p><?php esc_html_e( 'Then a little history. When did this start, what changed along the way, and what is the next thing you are working toward? A few sentences is plenty.', 'fairport' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"fairport/cta-band"} /-->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|xxl"},"blockGap":"var:preset|spacing|xl"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--xxl);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:heading {"textAlign":"center","level":2} -->
	<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Board of directors', 'fairport' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:pattern {"slug":"fairport/team-member"} /-->

	<!-- wp:pattern {"slug":"fairport/team-member"} /-->

	<!-- wp:pattern {"slug":"fairport/team-member"} /-->
</div>
<!-- /wp:group -->
