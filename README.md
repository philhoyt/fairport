# Fairport

A WordPress block theme for clubs, coalitions and small non-profits, built for the WordPress Theme Directory.

Big photo mastheads with a single colour overlay, a serif and sans type pairing (Bitter and Inter), three-up signposts and ready-made call to action bands. Three section styles and three colour palettes let you restyle every band from Global Styles without touching a block.

See [`docs/design-notes.md`](docs/design-notes.md) for where the design came from and what changed for a general release, and [`readme.txt`](readme.txt) for the directory listing.

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

## Packaging

`dist/` is committed, so a fresh clone installs as-is. To cut a zip:

```bash
npm run build
wp dist-archive . --format=zip
```

`.distignore` keeps `src/`, tooling and docs out of the zip.

## License

GPL-2.0-or-later. Bundled fonts are SIL OFL 1.1 (licences in `assets/fonts/`); placeholder artwork in `assets/images/` is CC0.
