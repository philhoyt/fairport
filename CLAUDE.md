# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Development
npm run start          # Dev server with hot reload
npm run build          # Production build

# Linting
npm run lint:js        # ESLint
npm run lint:scss      # Stylelint (SCSS)
npm run lint:scss:fix  # Auto-fix SCSS lint issues
npm run lint:php       # PHP CodeSniffer (composer lint)
npm run lint:php:fix   # Auto-fix PHP lint issues (composer lint-fix)
composer analyse       # PHPStan static analysis (level 5, WordPress stubs)

# Formatting
npm run format         # Format JS/JSON/MD via wp-scripts
npm run format:check   # Check formatting without writing

# Utilities
npm run screenshot     # Capture screenshot.png of the local site (Puppeteer)
npm run packages-update # Update @wordpress/* packages
```

## Architecture

This is **Fairport**, a block theme built for the WordPress Theme Directory. It distils the bespoke Cheat Canyon Climbers Coalition theme (big photo mastheads with a colour overlay, serif/sans type, three-up signposts, call to action bands) into a general-release theme. `docs/design-notes.md` records what was carried over, what changed for a mass release, and why. There are no PHP page templates — `templates/` and `parts/` hold thin block-based `.html` shells, while the meaningful block markup lives in PHP patterns under `patterns/` (see [Patterns](#patterns)).

### Build Pipeline

`src/` → webpack (`@wordpress/scripts`) → `dist/`

- `src/styles/style.scss` → `dist/css/style.css` (front-end)
- `src/styles/editor.scss` → `dist/css/editor.css` (editor-only)

Webpack (`webpack.config.js`) extends the default `@wordpress/scripts` config, separating CSS into a `css/` subdirectory and generating `*.asset.php` manifest files used by `inc/setup.php` for versioned asset enqueueing. `src/scripts/` is reserved as the entry point for theme JS — add an entry to `webpack.config.js` when the first script lands.

Blocks live under `src/blocks/<name>/` and are discovered automatically: `wp-scripts` globs `src/` for `block.json` and builds an entry point per script field, so no manual entry is needed. `webpack.config.js` **merges** its two CSS entries into that discovered set rather than replacing it — replacing `entry` silently disables block discovery.

`start` and `build` pass `--experimental-modules`, which is required for the `block.json` `viewScriptModule` field (i.e. any Interactivity API block). That flag makes `@wordpress/scripts` export an **array** of two configs — `[scripts, modules]` — instead of one object, which is why `webpack.config.js` destructures both and customises them separately. The `splitChunks` override is deliberately applied only to the scripts config; the Interactivity router arrives via a dynamic `import()` and needs chunking left alone.

`wp-scripts` copies only PHP files referenced directly from `block.json`, so `webpack.config.js` adds a `CopyWebpackPlugin` pattern for `**/parts/*.php`. Put a block's sub-partials in `src/blocks/<name>/parts/` and they will be copied to `dist/` alongside `render.php`.

### SCSS Structure

```
src/styles/
├── tools/_context.scss     # front/editor separation mixin
├── base/global/            # global resets/base styles
└── modules/                # feature-specific partials
```

The `_context.scss` mixin controls whether styles apply on the front-end or in the editor:

```scss
@use "../tools/context";
@include context.is(front) {
	/* front-end only */
}
@include context.is(editor) {
	/* editor only */
}
```

### Theme Identity

- **Text domain**: `fairport`
- **PHP namespace**: `Fairport\Setup`
- **Pattern namespace**: `fairport/{name}`; pattern category `fairport_page` for full-page starters
- **Colors/spacing/typography**: defined in `theme.json` (not hardcoded CSS)
- **WordPress CSS custom properties**: `--wp--preset--color--*`, `--wp--preset--spacing--*`, `--wp--custom--*`

### Design System

| Token            | Default (Harbor) | Use                                                   |
| ---------------- | ---------------- | ----------------------------------------------------- |
| `primary`        | `#c2321f`        | Buttons, body links, accent band. 5.34:1 with `base`. |
| `secondary`      | `#12314f`        | Dark bands, footer, every cover overlay.              |
| `tertiary`       | `#1f6a8c`        | Focus rings, caret.                                   |
| `base`           | `#fbfaf8`        | Page ground; text on dark bands.                      |
| `contrast`       | `#16171a`        | Body ink.                                             |
| `contrast-light` | `#efece7`        | Tint band, hairlines.                                 |

**`primary` is never placed on `secondary`** (2.39:1). On dark bands use `base` text and outline buttons.

Colour presets in `styles/colors/` (Navy Blue = the theme.json default, Forest Green, Scarlet Red) keep the same slugs and are named by the band colour (`secondary`) that dominates the page. Typography presets in `styles/typography/` redefine the `display`/`body` font slugs, so patterns and theme.json styles follow without edits. Section styles in `styles/blocks/` (`section-secondary`, `section-tint`, `section-accent`) restyle a Group/Columns and everything inside it; patterns use those classes instead of per-block colours. Covers use `overlayColor: "secondary"` because the overlay is an attribute, not a style.

Fonts are self-hosted variable woff2 in `assets/fonts/{bitter,inter,fraunces,manrope}/` with their OFL licences, registered through `theme.json` `fontFace`: **`display`** (Bitter) for headings, **`body`** (Inter) for everything else; Fraunces and Manrope are registered under their own slugs and take over the roles in the typography presets. Adding a font: fetch the latin variable woff2 from the Google Fonts CSS API with a Chrome user agent, and the OFL from `github.com/google/fonts/ofl/<name>/OFL.txt`; credit it in `readme.txt`.

Placeholder artwork in `assets/images/*.svg` is generated (topographic contours), CC0, and referenced from patterns with `get_theme_file_uri()`. Never resolve images from the media library inside a pattern.

**Spacing slugs must not contain digits.** WordPress kebab-cases preset slugs, so a slug `2xl` is emitted as `--wp--preset--spacing--2-xl` and every `var(--wp--preset--spacing--2xl)` in a pattern silently resolves to nothing. The scale is `xs s m l xl xxl xxxl`.

### Navigation

Core's dropdown is a 200px-wide white box with a hard border, square corners and no shadow. `src/styles/modules/_navigation.scss` replaces that with a content-sized surface and gives the bar an underline indicator. Values live in `settings.custom.navigation` in theme.json.

Three things about the core markup that are easy to get wrong:

- **`__container` is not a direct child of `.wp-block-navigation`.** Core nests it inside the responsive-container wrappers, so a `>` combinator straight off the block silently matches nothing. Top-level items are `.wp-block-navigation .wp-block-navigation__container > .wp-block-navigation-item`.
- **The open mobile overlay carries the bar's justification.** The header justifies the nav right, which core passes through as `items-justified-right`; in the full-screen column that resolves to `align-items: flex-end`. The module resets `--navigation-layout-align`, `--navigation-layout-justify` and `--navigation-layout-justification-setting` on the open container.
- **Core marks the open overlay's background and padding `!important`,** so those two declarations need the same weight.

### Templates

`main` is a constrained Group; `post-content` and any wrapper Group inside it carry `"align":"full"` so full-bleed bands can escape (without it the constrained `main` caps them at content width). `page.html` opens with `hidden-page-header` (a cover that uses the featured image, or a solid `secondary` band when there is none). `page-no-title.html` is a custom template for pages that start with a hero pattern. There is no `front-page.html`; the Home starter pattern is offered when creating a page.

### Key Files

| File                   | Purpose                                                                             |
| ---------------------- | ----------------------------------------------------------------------------------- |
| `style.css`            | Theme header — name, version, text domain, `Requires`/`Tested up to` metadata       |
| `readme.txt`           | Theme Directory readme: description, FAQ, changelog, font and image copyright       |
| `theme.json`           | All theme settings: color palette, typography, layout widths, spacing, border radii |
| `styles/`              | Style variations (root) and section styles (`blocks/`)                              |
| `docs/design-notes.md` | What was carried over from the CCC theme and what changed for release               |
| `bin/wp.sh`            | WP-CLI against the `fairport` Local site (socket symlink in `~/.local-sockets/`)    |
| `inc/setup.php`        | Theme setup hooks, asset enqueueing using `*.asset.php` manifests                   |
| `functions.php`        | Minimal entry point — includes `inc/setup.php`                                      |
| `patterns/`            | PHP patterns holding the theme's block markup (the pattern paradigm)                |
| `webpack.config.js`    | Build config extending `@wordpress/scripts` defaults                                |
| `phpcs.xml`            | PHP CodeSniffer ruleset (WordPress standard + PHPCompatibilityWP)                   |
| `phpstan.neon`         | PHPStan config (level 5, WordPress stubs)                                           |

### Conventions

- Tabs for indentation (PHP, JS, SCSS, HTML); spaces for JSON/YAML
- Theme layout uses CSS Grid on `.wp-site-blocks` (header/main/footer)
- Core block patterns are disabled; custom patterns go in `patterns/`
- Admin bar height is exposed as a CSS custom property for layout offset calculations

### Patterns

This theme follows the **pattern-paradigm** used by Twenty Twenty-Five: templates and template-parts under `templates/` and `parts/` are thin shells; the meaningful block markup lives in PHP patterns under `patterns/` and is composed via `<!-- wp:pattern {"slug":"fairport/…"} -->`.

**Why patterns instead of inline block markup in templates?**

- **i18n works.** Pattern files are PHP, so user-facing strings can use `esc_html__()`, `esc_html_e()`, `esc_attr_x()` directly — even inside block JSON attributes like `label` or `ariaLabel`. `make-pot` extracts them with no special handling.
- **Reuse.** The same query-loop / comments / post-nav pattern is referenced from multiple templates instead of duplicated.
- **Inserter UX.** Patterns with `Block Types:` headers surface as starter options when a user inserts the matching block.

**Pattern header conventions used here**

| Header         | Purpose                                                                            |
| -------------- | ---------------------------------------------------------------------------------- |
| `Title:`       | Display name in the inserter                                                       |
| `Slug:`        | `fairport/{name}` — must match the namespace                                       |
| `Categories:`  | Inserter grouping (`header`, `footer`, `query`, `text`)                            |
| `Block Types:` | Marks the pattern as a starter for that block (e.g. `core/query`, `core/comments`) |
| `Inserter: no` | Suppresses the pattern from the inserter UI                                        |

**Naming conventions**

- `header.php` / `footer.php` — site-wide template-part patterns
- `page-*.php` — full-page starters (`Block Types: core/post-content`, `Post Types: page, wp_template`, category `fairport_page`); they compose the building blocks with `wp:pattern` refs
- `banner-*.php`, `cta-*.php`, `cards-*.php`, `social-band.php`, `team-member.php` — the building blocks, in core categories (`banner`, `call-to-action`, `featured`, `team`)
- `template-*.php` — major-region patterns that compose a template (`template-query-loop`)
- `hidden-*.php` — internal building blocks referenced only from templates or other patterns; not shown in the inserter
- Other names (`comments.php`, `post-navigation.php`) — reusable building blocks that may also surface in the inserter

### Translations

User-facing strings live in `patterns/*.php` wrapped in `esc_html__()`, `esc_html_e()`, `esc_html_x()`, or `esc_attr_x()` with the `fairport` text domain. To regenerate `languages/fairport.pot`:

```bash
wp i18n make-pot . languages/fairport.pot --include="templates,parts,patterns,inc,functions.php,theme.json,styles" --domain=fairport
```

The `--include` paths cover both PHP source and any patterns/templates that might pick up additional strings as the theme grows.

### Gotchas

- **Theme patterns are cached against the theme version.** Adding a file to `patterns/` does not register it until the cache clears — bump `Version:` in `style.css`, or `bin/wp.sh cache flush` and delete `wp_theme_files_patterns*` options.
- **Site Editor customisations override theme files.** If a template on the dev site doesn't match `templates/`, check `bin/wp.sh post list --post_type=wp_template,wp_template_part`. `wp_template` posts can't be trashed — back up, then `--force`.
- **`context.is()` takes one argument.** For styles that apply to both the front-end and the editor, put them outside the mixin entirely.
- **`dist/` is committed on purpose.** The directory zip, GitHub installs and Playground have no build step. Run `npm run build` and commit the result with any SCSS change; the 0-byte `dist/css/*.js` stubs are ignored.
