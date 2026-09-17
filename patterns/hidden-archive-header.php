<?php
/**
 * Title: Archive header
 * Slug: fairport/hidden-archive-header
 * Inserter: no
 * Description: Secondary band with the archive title and description.
 *
 * @package fairport
 */

?>
<!-- wp:group {"align":"full","className":"is-style-section-secondary","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|xxl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-secondary" style="padding-top:var(--wp--preset--spacing--xxl);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:query-title {"type":"archive","textAlign":"center","showPrefix":false} /-->

	<!-- wp:term-description {"textAlign":"center"} /-->
</div>
<!-- /wp:group -->
