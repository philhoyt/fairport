# Fairport

A WordPress block theme for clubs, coalitions and small non-profits, built for the WordPress Theme Directory.

Big photo mastheads with a single colour overlay, a serif and sans type pairing (Bitter and Inter), three-up signposts and ready-made call to action bands. Three section styles and three colour palettes let you restyle every band from Global Styles without touching a block.

[**Try it in WordPress Playground**](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/philhoyt/fairport/main/.github/blueprint.json) — a throwaway site with the latest release installed, a Home and About page built from the starter patterns, and `WP_DEBUG` on.

See [`readme.txt`](readme.txt) for the directory listing.

## Requirements

- WordPress 6.6+ (section styles)
- PHP 7.4+
- Node.js 20+ and Composer for development

## Development

```bash
npm install && composer install
npm run start        # dev build with watch
npm run build        # production build → dist/
npm run lint:scss && npm run lint:php
```

`bin/wp.sh` wraps WP-CLI for the `fairport` Local site. `npm run screenshot -- http://fairport.local` regenerates `screenshot.png`.

## Releasing

Bump the version in `style.css`, `readme.txt` (`Stable tag` and a changelog entry) and `package.json`, commit, then push a `v`-prefixed tag:

```bash
git tag v0.9.0 && git push origin main --tags
```

The release workflow builds `dist/`, checks the three version strings against the tag, packages `fairport.zip` with `wp dist-archive` (honouring `.distignore`), and attaches it to a GitHub release. Tags under `v1.0.0` are marked pre-release. The Playground blueprint always installs `releases/latest/download/fairport.zip`.

To build the zip locally:

```bash
npm run build
wp dist-archive . --format=zip
```

## License

GPL-2.0-or-later. Bundled fonts are SIL OFL 1.1 (licences in `assets/fonts/`); placeholder artwork in `assets/images/` is CC0.
