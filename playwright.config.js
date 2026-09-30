/**
 * Playwright config: the @wordpress/scripts defaults (wp-env web server on
 * 8889, admin login in global setup, artifacts/) with the theme's spec folder.
 */
const baseConfig = require("@wordpress/scripts/config/playwright.config.js");

module.exports = {
	...baseConfig,
	testDir: "./tests/e2e",
};
