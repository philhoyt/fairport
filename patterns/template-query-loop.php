<?php
/**
 * Title: Posts list
 * Slug: fairport/template-query-loop
 * Categories: query, posts
 * Block Types: core/query
 * Description: Post list with featured image, title, excerpt, meta and pagination.
 *
 * @package fairport
 */

?>
<!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"layout":{"type":"constrained","contentSize":null}} -->
<div class="wp-block-query">
	<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|xl"}},"layout":{"type":"default"}} -->
	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|s"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group">
		<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|m"}}}} /-->

		<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"xl"} /-->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|s"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
		<div class="wp-block-group">
			<!-- wp:post-date /-->

			<!-- wp:post-author-name {"isLink":true} /-->

			<!-- wp:post-terms {"term":"category"} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:post-excerpt {"moreText":"<?php echo esc_attr_x( 'Read more', 'Post excerpt link text.', 'fairport' ); ?>","excerptLength":32} /-->
	</div>
	<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-pagination {"style":{"spacing":{"margin":{"top":"var:preset|spacing|xl"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
	<!-- wp:query-pagination-previous /-->

	<!-- wp:query-pagination-numbers /-->

	<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
	<!-- wp:paragraph -->
	<p><?php echo esc_html_x( 'No posts were found.', 'Message shown when a query returns nothing.', 'fairport' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
