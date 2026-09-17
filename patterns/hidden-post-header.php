<?php
/**
 * Title: Post header
 * Slug: fairport/hidden-post-header
 * Inserter: no
 * Description: Masthead for single posts: category eyebrow, title, date and author over the featured image.
 *
 * @package fairport
 */

?>
<!-- wp:cover {"useFeaturedImage":true,"dimRatio":60,"overlayColor":"secondary","isUserOverlayColor":true,"minHeight":420,"align":"full","className":"is-page-header","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull is-page-header" style="min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-60 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|s"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:post-terms {"term":"category","textAlign":"center","fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.12em","fontWeight":"700"}}} /-->

		<!-- wp:post-title {"textAlign":"center","level":1} /-->

		<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
		<div class="wp-block-group">
			<!-- wp:post-date /-->

			<!-- wp:post-author-name {"isLink":true,"className":"dot-before"} /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div></div>
<!-- /wp:cover -->
