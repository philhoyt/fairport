<?php
/**
 * Title: Single product
 * Slug: fairport/hidden-single-product
 * Inserter: no
 * Description: Breadcrumbs, gallery beside the product summary and add-to-cart form, a tint band with the description, details and reviews tabs, then upsells and related products.
 *
 * @package fairport
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|m","bottom":"var:preset|spacing|xxl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--m);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:woocommerce/breadcrumbs {"align":"wide","fontSize":"xs","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|l"}}}} /-->

	<!-- wp:woocommerce/store-notices /-->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|l","left":"var:preset|spacing|xl"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"width":"52%"} -->
		<div class="wp-block-column" style="flex-basis:52%">
			<!-- wp:woocommerce/product-gallery {"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
			<div class="wp-block-woocommerce-product-gallery wc-block-product-gallery"><!-- wp:woocommerce/product-gallery-large-image -->
			<div class="wp-block-woocommerce-product-gallery-large-image wc-block-product-gallery-large-image__inner-blocks"><!-- wp:woocommerce/product-image {"showProductLink":false,"showSaleBadge":false} -->
			<div class="is-loading"></div>
			<!-- /wp:woocommerce/product-image -->

			<!-- wp:woocommerce/product-gallery-large-image-next-previous -->
			<div class="wp-block-woocommerce-product-gallery-large-image-next-previous"></div>
			<!-- /wp:woocommerce/product-gallery-large-image-next-previous --></div>
			<!-- /wp:woocommerce/product-gallery-large-image -->

			<!-- wp:woocommerce/product-gallery-thumbnails {"thumbnailSize":"15%"} /--></div>
			<!-- /wp:woocommerce/product-gallery -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:post-terms {"term":"product_cat","separator":" · ","fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"700"}}} /-->

			<!-- wp:post-title {"level":1,"fontSize":"xxl","style":{"spacing":{"margin":{"top":"var:preset|spacing|xs","bottom":"var:preset|spacing|s"}}},"__woocommerceNamespace":"woocommerce/product-query/product-title"} /-->

			<!-- wp:woocommerce/product-rating {"isDescendentOfSingleProductTemplate":true,"fontSize":"xs"} /-->

			<!-- wp:woocommerce/product-price {"isDescendentOfSingleProductTemplate":true,"fontSize":"xl"} /-->

			<!-- wp:post-excerpt {"excerptLength":100,"style":{"spacing":{"margin":{"top":"var:preset|spacing|m"}}},"__woocommerceNamespace":"woocommerce/product-query/product-summary"} /-->

			<!-- wp:woocommerce/add-to-cart-form /-->

			<!-- wp:woocommerce/product-meta -->
			<div class="wp-block-woocommerce-product-meta">
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|m"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
				<div class="wp-block-group">
					<!-- wp:woocommerce/product-sku {"fontSize":"xs"} /-->

					<!-- wp:post-terms {"term":"product_tag","prefix":"<?php echo esc_attr_x( 'Tags: ', 'Product tags prefix.', 'fairport' ); ?>","fontSize":"xs"} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:woocommerce/product-meta -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-section-tint","style":{"spacing":{"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xxl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-tint" style="padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xxl)">
	<!-- wp:woocommerce/product-details {"align":"wide"} /-->

	<!-- wp:woocommerce/product-collection {"queryId":1,"query":{"perPage":3,"pages":1,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","onbackorder","outofstock"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":3,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/upsells","hideControls":["inherit","filterable"],"queryContextIncludes":["collection"],"align":"wide"} -->
	<div class="wp-block-woocommerce-product-collection alignwide">
		<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|l"}}}} -->
		<h2 class="wp-block-heading has-text-align-center" style="margin-top:var(--wp--preset--spacing--xxl);margin-bottom:var(--wp--preset--spacing--l)"><?php esc_html_e( 'You may also like', 'fairport' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:woocommerce/product-template {"style":{"spacing":{"blockGap":"var:preset|spacing|l"}}} -->
			<!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"style":{"border":{"radius":"var:preset|spacing|xs"}}} -->
				<!-- wp:woocommerce/product-sale-badge {"isDescendentOfQueryLoop":true,"align":"right"} /-->
			<!-- /wp:woocommerce/product-image -->

			<!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"fontSize":"m","style":{"spacing":{"margin":{"top":"var:preset|spacing|s","bottom":"var:preset|spacing|xs"}},"typography":{"lineHeight":"1.3"}},"__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

			<!-- wp:woocommerce/product-price {"textAlign":"center","isDescendentOfQueryLoop":true,"fontSize":"s"} /-->

			<!-- wp:woocommerce/product-button {"textAlign":"center","isDescendentOfQueryLoop":true,"fontSize":"xs","style":{"spacing":{"margin":{"top":"var:preset|spacing|s"}}}} /-->
		<!-- /wp:woocommerce/product-template -->
	</div>
	<!-- /wp:woocommerce/product-collection -->

	<!-- wp:woocommerce/product-collection {"queryId":2,"query":{"perPage":3,"pages":1,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","onbackorder","outofstock"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":3,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/related","hideControls":["inherit"],"queryContextIncludes":["collection"],"align":"wide"} -->
	<div class="wp-block-woocommerce-product-collection alignwide">
		<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|l"}}}} -->
		<h2 class="wp-block-heading has-text-align-center" style="margin-top:var(--wp--preset--spacing--xxl);margin-bottom:var(--wp--preset--spacing--l)"><?php esc_html_e( 'Related products', 'fairport' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:woocommerce/product-template {"style":{"spacing":{"blockGap":"var:preset|spacing|l"}}} -->
			<!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"style":{"border":{"radius":"var:preset|spacing|xs"}}} -->
				<!-- wp:woocommerce/product-sale-badge {"isDescendentOfQueryLoop":true,"align":"right"} /-->
			<!-- /wp:woocommerce/product-image -->

			<!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"fontSize":"m","style":{"spacing":{"margin":{"top":"var:preset|spacing|s","bottom":"var:preset|spacing|xs"}},"typography":{"lineHeight":"1.3"}},"__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

			<!-- wp:woocommerce/product-price {"textAlign":"center","isDescendentOfQueryLoop":true,"fontSize":"s"} /-->

			<!-- wp:woocommerce/product-button {"textAlign":"center","isDescendentOfQueryLoop":true,"fontSize":"xs","style":{"spacing":{"margin":{"top":"var:preset|spacing|s"}}}} /-->
		<!-- /wp:woocommerce/product-template -->
	</div>
	<!-- /wp:woocommerce/product-collection -->
</div>
<!-- /wp:group -->
