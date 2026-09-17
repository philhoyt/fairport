#!/usr/bin/env node
/* eslint-disable no-console -- CLI progress for npm run previews */
/**
 * Captures the README preview images into .github/.
 *
 * Palette shots switch the active colour preset through
 * bin/preview-variation.php, which writes to the user global styles record
 * the same way the Styles panel does, and reset it afterwards.
 *
 * Usage:
 *   npm run previews -- http://fairport.local
 */

const { execFileSync } = require("child_process");
const path = require("path");
const puppeteer = require("puppeteer");

const base = (process.argv[2] || "http://fairport.local").replace(/\/$/, "");
const outDir = path.resolve(__dirname, "..", ".github");
const wp = path.join(__dirname, "wp.sh");

const shots = [
	{ file: "1-home.png", url: "/", width: 1440, height: 900, fullPage: true },
	{ file: "2-single.png", url: "/hello-world/", width: 1440, height: 900, fullPage: true },
	{ file: "3-about.png", url: "/about/", width: 1440, height: 900, fullPage: true },
	{ file: "4-mobile-home.png", url: "/", width: 390, height: 844, fullPage: false, mobile: true },
	{
		file: "5-forest-green.png",
		url: "/",
		width: 1440,
		height: 900,
		fullPage: false,
		presets: ["Forest Green", "Fraunces & Manrope"],
	},
	{
		file: "6-scarlet-red.png",
		url: "/about/",
		width: 1440,
		height: 900,
		fullPage: false,
		presets: ["Scarlet Red", "Manrope"],
	},
];

function applyPresets(names) {
	execFileSync(wp, ["eval-file", path.join(__dirname, "preview-variation.php"), ...names], {
		stdio: "ignore",
	});
}

(async () => {
	const browser = await puppeteer.launch();
	const page = await browser.newPage();

	for (const shot of shots) {
		applyPresets(shot.presets || ["reset"]);
		await page.setViewport({
			width: shot.width,
			height: shot.height,
			deviceScaleFactor: 2,
			isMobile: !!shot.mobile,
		});
		await page.goto(base + shot.url, { waitUntil: "networkidle2" });
		await page.evaluate(() => document.fonts.ready);
		const file = path.join(outDir, shot.file);
		await page.screenshot({ path: file, fullPage: !!shot.fullPage });
		console.log(`Saved ${path.relative(process.cwd(), file)}`);
	}

	applyPresets(["reset"]);
	await browser.close();
})();
