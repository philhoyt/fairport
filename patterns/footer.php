<?php
/**
 * Title: Footer
 * Slug: fairport/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Dark site footer with site title, tagline, two link columns, social links and copyright.
 *
 * @package fairport
 */

?>
<!-- wp:group {"className":"site-footer is-style-section-secondary","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxl","bottom":"var:preset|spacing|xl"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group site-footer is-style-section-secondary" style="padding-top:var(--wp--preset--spacing--xxl);padding-bottom:var(--wp--preset--spacing--xl)">

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|xl"}}}} -->
	<div class="wp-block-columns alignwide">

		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column" style="flex-basis:40%">
			<!-- wp:site-title {"level":2,"fontSize":"l"} /-->

			<!-- wp:site-tagline /-->

			<!-- wp:social-links {"iconColor":"base","iconColorValue":"#fbfaf8","size":"has-normal-icon-size","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|s"},"margin":{"top":"var:preset|spacing|m"}}},"className":"is-style-logos-only"} -->
			<ul class="wp-block-social-links has-normal-icon-size has-icon-color is-style-logos-only" style="margin-top:var(--wp--preset--spacing--m)">
				<!-- wp:social-link {"url":"https://www.instagram.com/","service":"instagram","label":"<?php echo esc_attr_x( 'Instagram', 'social link label', 'fairport' ); ?>"} /-->
				<!-- wp:social-link {"url":"https://www.facebook.com/","service":"facebook","label":"<?php echo esc_attr_x( 'Facebook', 'social link label', 'fairport' ); ?>"} /-->
				<!-- wp:social-link {"url":"https://www.youtube.com/","service":"youtube","label":"<?php echo esc_attr_x( 'YouTube', 'social link label', 'fairport' ); ?>"} /-->
			</ul>
			<!-- /wp:social-links -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":2,"fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"700"}}} -->
			<h2 class="wp-block-heading has-xs-font-size" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase"><?php esc_html_e( 'Explore', 'fairport' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:list {"className":"is-style-plain-list","fontSize":"s"} -->
			<ul class="wp-block-list is-style-plain-list has-s-font-size">
				<!-- wp:list-item -->
				<li><a href="#"><?php esc_html_e( 'About', 'fairport' ); ?></a></li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li><a href="#"><?php esc_html_e( 'Blog', 'fairport' ); ?></a></li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li><a href="#"><?php esc_html_e( 'Events', 'fairport' ); ?></a></li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li><a href="#"><?php esc_html_e( 'Contact', 'fairport' ); ?></a></li>
				<!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":2,"fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"700"}}} -->
			<h2 class="wp-block-heading has-xs-font-size" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase"><?php esc_html_e( 'Get involved', 'fairport' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:list {"className":"is-style-plain-list","fontSize":"s"} -->
			<ul class="wp-block-list is-style-plain-list has-s-font-size">
				<!-- wp:list-item -->
				<li><a href="#"><?php esc_html_e( 'Become a member', 'fairport' ); ?></a></li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li><a href="#"><?php esc_html_e( 'Volunteer', 'fairport' ); ?></a></li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li><a href="#"><?php esc_html_e( 'Donate', 'fairport' ); ?></a></li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li><a href="#"><?php esc_html_e( 'Newsletter', 'fairport' ); ?></a></li>
				<!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:separator {"align":"wide","className":"is-style-wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|m"}}}} -->
	<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide" style="margin-top:var(--wp--preset--spacing--xl);margin-bottom:var(--wp--preset--spacing--m)"/>
	<!-- /wp:separator -->

	<!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"fontSize":"xs"} -->
		<p class="has-xs-font-size">
			<?php
			printf(
				/* translators: 1: current year, 2: site name. */
				esc_html__( '&copy; %1$s %2$s', 'fairport' ),
				esc_html( gmdate( 'Y' ) ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"fontSize":"xs"} -->
		<p class="has-xs-font-size">
			<?php
			printf(
				/* translators: %s: WordPress. */
				esc_html__( 'Proudly powered by %s', 'fairport' ),
				'<a href="' . esc_url( __( 'https://wordpress.org', 'fairport' ) ) . '" rel="nofollow">WordPress</a>'
			);
			?>
		</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
