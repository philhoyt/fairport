---
paths:
 - "**/*.php"
 - "**/*.js"
 - "**/*.jsx"
 - "**/*.scss"
 - "**/*.css"
 - "**/block.json"
 - "**/composer.json"
 - "**/package.json"
 - "templates/**"
 - "parts/**"
 - "patterns/**"
 - "styles/**"
 - "theme.json"
---

# Project: Fairport

- Type: block theme (WordPress Theme Directory release)
- Slug: `fairport`
- Text domain: `fairport`
- PHP namespace: `Fairport\Setup`
- PHP minimum: 7.4
- WP minimum: 6.6 (section styles); tested up to 7.1
- Distribution: WordPress.org theme directory
- Main file: `style.css`
- Pattern namespace: `fairport/{name}`; page starters in category `fairport_page`
- Build: `src/styles/*.scss` → `dist/css/` via `@wordpress/scripts`; `dist/` must ship
- Local site: `fairport.local` (symlinked); WP-CLI via `bin/wp.sh`
