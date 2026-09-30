/**
 * Store pages render from Fairport's templates, carry the WooCommerce
 * stylesheet and print no PHP notices. Seed data comes from bin/seed-store.php.
 */
import { execFileSync } from "child_process";
import { test, expect } from "@wordpress/e2e-test-utils-playwright";

// PHP errors as WordPress prints them with WP_DEBUG_DISPLAY (html_errors off):
// "Warning: message in /path/file.php on line 12".
const PHP_NOTICE = /(Warning|Notice|Deprecated|Fatal error): .+ in \/\S+\.php on line \d+/;

/**
 * Run WP-CLI in the wp-env tests environment.
 *
 * @param {string[]} args WP-CLI arguments.
 */
const wpCli = (args) =>
	execFileSync("npx", ["wp-env", "run", "tests-cli", "wp", ...args], {
		stdio: "ignore",
	});

/**
 * Load a store page as a visitor and check what every store page shares.
 *
 * @param {import('@playwright/test').Page} page Page.
 * @param {string}                          path URL path.
 */
async function visitStorePage(page, path) {
	const response = await page.goto(path);
	expect(response.status()).toBeLessThan(400);
	expect(await page.content()).not.toMatch(PHP_NOTICE);
	await expect(page.locator("link#fairport-woocommerce-css")).toHaveCount(1);
}

test.describe("store pages", () => {
	test.use({ storageState: { cookies: [], origins: [] } });

	let productIds;

	test.beforeAll(async ({ requestUtils }) => {
		const products = await (
			await requestUtils.request.get("/wp-json/wc/store/v1/products?per_page=20")
		).json();
		productIds = Object.fromEntries(products.map((p) => [p.sku, p.id]));
	});

	test("shop and category archives", async ({ page }) => {
		await visitStorePage(page, "/shop/");
		await expect(page.locator(".is-style-section-secondary h1")).toHaveText("Shop");
		await expect(page.locator('.wp-block-button.is-current a[aria-current="page"]')).toHaveText(
			"All products"
		);
		await expect(page.locator(".wp-block-woocommerce-product-template li")).toHaveCount(3);

		await visitStorePage(page, "/product-category/gear/");
		await expect(page.locator(".wp-block-button.is-current a")).toHaveText("Gear");
	});

	test("single product", async ({ page }) => {
		await visitStorePage(page, "/product/coalition-tee/");
		await expect(page.locator("h1")).toHaveText("Coalition Tee");
		await expect(page.locator("table.variations select")).toBeVisible();
		await expect(page.locator(".woocommerce-tabs")).toBeVisible();
		await expect(page.locator(".up-sells")).toHaveCount(0);
	});

	test("product search", async ({ page }) => {
		// Two matches (tee and bottle): WooCommerce redirects a search with a
		// single result straight to that product.
		await visitStorePage(page, "/?s=coalition&post_type=product");
		await expect(page.locator('.wp-block-search input[name="post_type"]')).toHaveValue("product");
		await expect(page.locator(".wp-block-woocommerce-product-template li")).toHaveCount(2);
	});

	test("cart and checkout", async ({ page }) => {
		await page.goto(`/?add-to-cart=${productIds["FP-TEST-2"]}`);

		await visitStorePage(page, "/cart/");
		await expect(page.locator(".is-style-section-secondary h1")).toHaveText("Cart");
		await expect(page.locator(".wp-block-woocommerce-cart")).toBeVisible();

		await visitStorePage(page, "/checkout/");
		await expect(page.getByText("Secure checkout")).toBeVisible();
		await expect(page.locator(".wp-block-woocommerce-checkout")).toBeVisible();
	});

	test("my account", async ({ page }) => {
		await visitStorePage(page, "/my-account/");
		await expect(page.locator("form.woocommerce-form-login")).toBeVisible();
	});

	test("store-only coming soon keeps the site header", async ({ page }) => {
		wpCli(["option", "update", "woocommerce_coming_soon", "yes"]);
		wpCli(["option", "update", "woocommerce_store_pages_only", "yes"]);
		try {
			await visitStorePage(page, "/shop/");
			await expect(page.locator("h1")).toHaveText("The shop is opening soon");
			await expect(page.locator("header .wp-block-navigation").first()).toBeVisible();
		} finally {
			wpCli(["option", "update", "woocommerce_coming_soon", "no"]);
		}
	});
});
