#!/usr/bin/env node
/* eslint-disable no-console -- CLI report for npm run validate:blocks */
/**
 * Validates the block markup in patterns, templates and parts the way the
 * editor does, so hand-written serialised HTML that would drop a block into
 * recovery mode is caught before it ships.
 *
 * Patterns are PHP, so their rendered content is read from WordPress through
 * WP-CLI (bin/wp.sh); templates and parts are read from disk. Each document is
 * run through @wordpress/blocks' parse(), which registers the core blocks and
 * compares the saved markup against what each block's save() would produce.
 * A block name that is not registered fails the run; WooCommerce's blocks are
 * registered from the site so templates that use them can be checked too.
 *
 * Usage:
 *   npm run validate:blocks
 *   npm run validate:blocks -- --from=/path/documents.json   # {"name": "block markup", ...}
 */

const { execFileSync } = require("child_process");
const fs = require("fs");
const path = require("path");
const { JSDOM, VirtualConsole } = require("jsdom");

const root = path.resolve(__dirname, "..");

// @wordpress/blocks and the core block library expect browser globals.
// A silent virtual console: jsdom cannot parse the editor UI package's modern
// CSS and would otherwise print a stack trace for every stylesheet it injects.
const dom = new JSDOM("<!doctype html><html><body></body></html>", {
	url: "http://localhost/",
	virtualConsole: new VirtualConsole(),
});
for (const key of [
	"window",
	"document",
	"navigator",
	"HTMLElement",
	"Node",
	"Element",
	"DOMParser",
	"MutationObserver",
	"getComputedStyle",
	"CSS",
]) {
	if (!(key in globalThis) && key in dom.window) {
		globalThis[key] = dom.window[key];
	}
}
globalThis.matchMedia =
	globalThis.matchMedia ||
	(() => ({
		matches: false,
		addListener() {},
		removeListener() {},
		addEventListener() {},
		removeEventListener() {},
	}));

const { parse, getBlockType, registerBlockType } = require("@wordpress/blocks");
const { registerCoreBlocks } = require("@wordpress/block-library");

registerCoreBlocks();

const wp = (php) =>
	execFileSync(path.join(root, "bin", "wp.sh"), ["eval", php], {
		encoding: "utf8",
		stdio: ["ignore", "pipe", "ignore"],
	});
const json = (out) => JSON.parse(out.slice(out.indexOf("{")));

// WooCommerce blocks are registered from the running site's block registry
// (names and attributes only), so a misspelt block name is still caught. Their
// save() output lives in WooCommerce's JS, which is not loaded here: a Woo
// block's own wrapper markup is not compared, only the core blocks inside it.
// The Site Editor is the check for that wrapper markup.
const WOO = "woocommerce/";
const wooBlocks = json(
	wp(
		'$out = array(); foreach ( WP_Block_Type_Registry::get_instance()->get_all_registered() as $name => $type ) { if ( 0 === strpos( $name, "' +
			WOO +
			'" ) ) { $out[ $name ] = (object) $type->attributes; } } echo wp_json_encode( (object) $out );'
	)
);
for (const [name, attributes] of Object.entries(wooBlocks)) {
	registerBlockType(name, {
		apiVersion: 3,
		title: name,
		category: "widgets",
		attributes,
		save: () => null,
	});
}

// Collect the documents to validate.
const docs = [];
const fromArg = process.argv.find((arg) => arg.startsWith("--from="));

if (fromArg) {
	const data = JSON.parse(fs.readFileSync(fromArg.slice(7), "utf8"));
	for (const [name, content] of Object.entries(data)) {
		docs.push({ name, content });
	}
}

const patterns = fromArg
	? {}
	: json(
			wp(
				'$out = array(); foreach ( WP_Block_Patterns_Registry::get_instance()->get_all_registered() as $p ) { if ( 0 === strpos( $p["name"], "fairport/" ) ) { $out[ $p["name"] ] = $p["content"]; } } echo wp_json_encode( (object) $out );'
			)
		);
for (const [name, content] of Object.entries(patterns)) {
	docs.push({ name: `pattern ${name}`, content });
}
for (const dir of fromArg ? [] : ["templates", "parts"]) {
	for (const file of fs.readdirSync(path.join(root, dir))) {
		if (file.endsWith(".html")) {
			docs.push({
				name: `${dir}/${file}`,
				content: fs.readFileSync(path.join(root, dir, file), "utf8"),
			});
		}
	}
}

// parse() reports validation detail through console.error/warn; capture it.
let captured = [];
const origError = console.error;
const origWarn = console.warn;
// The validation logger calls console.error( format, ...args ) with %s/%o
// placeholders; the last two substitutions are the generated and saved markup.
const capture = (...args) => {
	if (typeof args[0] !== "string" || !args[0].startsWith("Block validation")) {
		return;
	}
	const values = args.slice(1);
	if (args[0].startsWith("Block validation failed")) {
		const name = values[0];
		const generated = values[values.length - 2];
		const saved = values[values.length - 1];
		captured.push(`${name}\n    expected: ${generated}\n    found:    ${saved}`);
		return;
	}
	captured.push(args[0].replace(/%[so]/g, () => String(values.shift())));
};
const origInfo = console.info;
const origLog = console.log;
console.error = capture;
console.warn = capture;
console.info = () => {};
console.log = () => {};

let problems = 0;
let checked = 0;
let shallow = 0;
let skipped = 0;

function walk(blocks, doc, trail) {
	for (const block of blocks) {
		checked++;
		// parse() turns an unregistered name into core/missing, which is
		// "valid", so a typo would otherwise pass. Other plugins' blocks (only
		// seen with --from) are skipped: there is nothing here to check them by.
		const name = block.name === "core/missing" ? block.attributes.originalName : block.name;
		const label = [...trail, name].join(" > ");
		const namespace = name.includes("/") ? name.split("/")[0] : "core";
		if (block.name === "core/missing" && !["core", "woocommerce"].includes(namespace)) {
			skipped++;
		} else if (!getBlockType(name)) {
			problems++;
			origError(`\n✖ ${doc.name}\n  ${label}: unknown block type`);
		} else if (name.startsWith(WOO)) {
			shallow++;
		} else if (block.isValid === false) {
			problems++;
			const detail = captured
				.filter((line) => line.includes(block.name))
				.map(
					(line) =>
						"    " +
						line
							.replace(/\n\s*/g, "\n    ")
							.replace(/[ \t]+/g, " ")
							.slice(0, 900)
				)
				.join("\n");
			origError(`\n✖ ${doc.name}\n  ${label}: invalid — would enter recovery mode\n${detail}`);
		}
		walk(block.innerBlocks, doc, [...trail, name]);
	}
}

for (const doc of docs) {
	captured = [];
	const blocks = parse(doc.content);
	walk(blocks, doc, []);
}

console.error = origError;
console.warn = origWarn;
console.info = origInfo;
console.log = origLog;

console.log(`\nChecked ${checked} blocks across ${docs.length} documents.`);
if (shallow) {
	console.log(
		`${shallow} WooCommerce block(s): name checked, own markup not compared (open the template in the Site Editor).`
	);
}
if (skipped) {
	console.log(`${skipped} block(s) from other plugins skipped.`);
}
if (problems) {
	console.log(`${problems} invalid block(s).`);
	process.exit(1);
}
console.log("All blocks valid.");
