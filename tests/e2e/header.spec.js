/**
 * WooCommerce's block hooks insert the account and mini cart blocks after the
 * Navigation block, as its siblings. In 1.1.0 the navigation sat directly in
 * the header's space-between row, so the icons became items of that row and
 * were spread across the header. They must share a group with the menu that
 * is not the row holding the site title, and sit close to the menu.
 */
import { test, expect } from "@wordpress/e2e-test-utils-playwright";

test("account and mini cart sit beside the menu", async ({ page }) => {
	await page.setViewportSize({ width: 1280, height: 800 });
	await page.goto("/shop/");

	const layout = await page.evaluate(() => {
		const navigation = document.querySelector("header .wp-block-navigation");
		const account = document.querySelector("header .wp-block-woocommerce-customer-account");
		const miniCart = document.querySelector("header .wp-block-woocommerce-mini-cart");
		const group = navigation?.parentElement;
		const gap = (a, b) =>
			Math.round(b.getBoundingClientRect().left - a.getBoundingClientRect().right);
		return {
			found: Boolean(navigation && account && miniCart),
			sameGroup: account?.parentElement === group && miniCart?.parentElement === group,
			groupHoldsSiteTitle: Boolean(group?.querySelector(".wp-block-site-title, .wp-block-site-logo")),
			menuToAccount: navigation && account ? gap(navigation, account) : null,
			accountToCart: account && miniCart ? gap(account, miniCart) : null,
		};
	});

	expect(layout.found).toBe(true);
	expect(layout.sameGroup).toBe(true);
	expect(layout.groupHoldsSiteTitle).toBe(false);
	// The menu's own item gap is the m spacing preset (1.5rem).
	expect(layout.menuToAccount).toBeLessThanOrEqual(48);
	expect(layout.accountToCart).toBeLessThanOrEqual(48);
});
