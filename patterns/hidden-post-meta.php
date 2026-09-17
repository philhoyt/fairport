<?php
/**
 * Title: Post meta
 * Slug: fairport/hidden-post-meta
 * Inserter: no
 * Description: Date, author and categories for a single post.
 *
 * @package fairport
 */

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|s","margin":{"bottom":"var:preset|spacing|l"}}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--l)">
	<!-- wp:post-date /-->

	<!-- wp:post-author-name {"isLink":true} /-->

	<!-- wp:post-terms {"term":"category"} /-->
</div>
<!-- /wp:group -->
