<?php
/**
 * Title: Page header
 * Slug: fairport/hidden-page-header
 * Inserter: no
 * Description: Masthead for pages and posts. Uses the featured image as the cover; falls back to a solid secondary band.
 *
 * @package fairport
 */

?>
<!-- wp:cover {"useFeaturedImage":true,"dimRatio":60,"overlayColor":"secondary","isUserOverlayColor":true,"minHeight":360,"align":"full","className":"is-page-header","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull is-page-header" style="min-height:360px"><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-60 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:post-title {"textAlign":"center","level":1} /-->
</div></div>
<!-- /wp:cover -->
