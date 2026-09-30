/**
 * Every Fairport pattern, template and part must parse as valid in the Site
 * Editor, with WooCommerce's block scripts loaded. The theme's own
 * validate:blocks cannot check WooCommerce blocks' saved wrapper markup; this
 * is the check that caught five invalid blocks in 1.1.0.
 */
import { test, expect } from "@wordpress/e2e-test-utils-playwright";

test("patterns, templates and parts are valid in the Site Editor", async ({ admin, page }) => {
	await admin.visitSiteEditor();

	// WooCommerce registers its blocks after the editor boots; parsing before
	// that would turn them into core/missing and misreport the theme.
	await page.waitForFunction(
		() =>
			[
				"woocommerce/product-collection",
				"woocommerce/product-gallery",
				"woocommerce/product-meta",
			].every((name) => window.wp?.blocks?.getBlockType(name)),
		null,
		{ timeout: 60_000 }
	);

	const result = await page.evaluate(async () => {
		const { apiFetch, blocks } = window.wp;
		const [patterns, templates, parts] = await Promise.all([
			apiFetch({ path: "/wp/v2/block-patterns/patterns" }),
			apiFetch({ path: "/wp/v2/templates?context=edit&per_page=100" }),
			apiFetch({
				path: "/wp/v2/template-parts?context=edit&per_page=100",
			}),
		]);

		const docs = [
			...patterns
				.filter((p) => p.name.startsWith("fairport/"))
				.map((p) => [`pattern ${p.name}`, p.content]),
			...templates
				.filter((t) => t.theme === "fairport" && t.source === "theme")
				.map((t) => [`template ${t.slug}`, t.content.raw]),
			...parts
				.filter((t) => t.theme === "fairport" && t.source === "theme")
				.map((t) => [`part ${t.slug}`, t.content.raw]),
		];

		const patternNames = new Set(patterns.map((p) => p.name));
		const partSlugs = new Set(parts.map((p) => p.slug));
		const invalid = [];
		const unregistered = [];
		const unresolved = [];

		const issueText = (block) =>
			(block.validationIssues || [])
				.filter((issue) => !String(issue.args?.[0]).startsWith("Block validation failed"))
				.map((issue) =>
					issue.args
						.map((arg) => (typeof arg === "object" ? JSON.stringify(arg) : String(arg)))
						.join(" | ")
				)
				.join(" ;; ")
				.slice(0, 400);

		const walk = (list, doc, trail) => {
			for (const block of list) {
				const name = block.name === "core/missing" ? block.attributes.originalName : block.name;
				const path = [...trail, name].join(" > ");
				if (block.name === "core/missing") {
					unregistered.push(`${doc}: ${path}`);
				} else if (block.isValid === false) {
					invalid.push(`${doc}: ${path} :: ${issueText(block)}`);
				}
				if (name === "core/pattern" && !patternNames.has(block.attributes.slug)) {
					unresolved.push(`${doc}: pattern ${block.attributes.slug}`);
				}
				if (name === "core/template-part" && !partSlugs.has(block.attributes.slug)) {
					unresolved.push(`${doc}: part ${block.attributes.slug}`);
				}
				walk(block.innerBlocks, doc, [...trail, name]);
			}
		};

		// parse() logs every validation failure to the console; the issues
		// are collected and reported below, so keep the run log readable.
		const { error, warn } = window.console;
		window.console.error = () => {};
		window.console.warn = () => {};
		try {
			for (const [doc, content] of docs) {
				walk(blocks.parse(content), doc, []);
			}
		} finally {
			window.console.error = error;
			window.console.warn = warn;
		}

		return { documents: docs.length, invalid, unregistered, unresolved };
	});

	expect(result.documents).toBeGreaterThan(40);
	expect(result.unregistered).toEqual([]);
	expect(result.unresolved).toEqual([]);
	expect(result.invalid).toEqual([]);
});
