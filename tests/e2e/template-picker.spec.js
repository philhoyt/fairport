/**
 * The post editor offers no store template ("Page: Cart", "Single Product")
 * in its template list. Both sources the editor uses are checked.
 */
import { test, expect } from "@wordpress/e2e-test-utils-playwright";

const STORE_TEMPLATES = [
	"archive-product",
	"coming-soon",
	"order-confirmation",
	"page-cart",
	"page-checkout",
	"page-my-account",
	"product-search-results",
	"single-product",
	"taxonomy-product_attribute",
];

test("store templates are not offered for pages", async ({ admin, page, requestUtils }) => {
	const viaRest = await requestUtils.rest({
		path: "/wp/v2/templates",
		params: { post_type: "page", per_page: 100 },
	});
	const restSlugs = viaRest.map((template) => template.slug);
	expect(restSlugs).toContain("page-no-title");
	expect(restSlugs.filter((slug) => STORE_TEMPLATES.includes(slug))).toEqual([]);

	await admin.createNewPost({ postType: "page" });
	const editorSlugs = await page.evaluate(() =>
		Object.keys(window.wp.data.select("core/editor").getEditorSettings().availableTemplates)
	);
	expect(editorSlugs).toContain("page-no-title");
	expect(editorSlugs.filter((slug) => STORE_TEMPLATES.includes(slug))).toEqual([]);
});
