# AGENTS.md

Instructions for AI coding agents and new contributors working in this
repository. Read this before writing any code here.

Start with [`ARCHITECTURE-ESSENTIALS.md`](ARCHITECTURE-ESSENTIALS.md) to find the
right file, [`ARCHITECTURE.md`](ARCHITECTURE.md) before changing how something
works, and [`SECURITY-AUDIT.md`](SECURITY-AUDIT.md) before touching forms,
uploads, authentication, headers or anything holding PII.

---

## 1. What this repository is

The first-party WordPress code for the Sound Creations Ltd website
(<https://soundcreationsltd.com/newwebsite/>) — a B2B professional audio,
acoustics, distribution and integration company operating from Nairobi, Kigali,
DR Congo and Dubai.

Four packages, and the boundary between them is the single most important rule
in the codebase:

```
soundcreations/              Parent theme    — presentation only
soundcreations-child/        Child theme     — active theme; CSS overrides only
sound-creations-core/        Plugin          — content model, settings, SEO
sound-creations-enquiries/   Plugin          — forms, anti-spam, leads, mail
```

WordPress core, third-party plugins, uploads and the database are **not** in
this repository. Do not add them.

## 2. The rules that are not negotiable

1. **Business logic goes in a plugin. Presentation goes in the theme.**
   Registering a post type, taxonomy, editorial field, business setting or SEO
   tag from the theme is wrong, even when it is convenient. If a re-theme would
   destroy it, it belongs in a plugin.
2. **Never hardcode editable content.** Phone numbers, addresses, opening hours,
   headlines, CTA labels, proof statistics and hero images all live in
   `soundcreations_settings`. Read them with `sc_setting()` in the theme or
   `sc_core_get()` in Core. If an editor cannot change it from the admin, that
   is a bug.
3. **The site runs in a subdirectory (`/newwebsite/`).** Never write a
   root-relative path like `/wp-admin/*` or `/assets/...`. Derive paths from
   `home_url()`, `SC_THEME_URI` or `SC_THEME_DIR`.
4. **Sanitise on input, escape on output. Every time.**
5. **Never weaken a security control to make something work.** If a control is
   in your way, read `SECURITY-AUDIT.md` for why it exists, then solve the
   problem another way or raise it explicitly. Do not quietly widen an upload
   allowlist, raise a rate limit, relax a capability or drop a header.
6. **Never log, email or display an enquirer's PII outside the admin.**
7. **No new dependencies without a stated reason.** No page builder, no
   WooCommerce, no third-party form plugin, no SEO plugin. Each was rejected
   deliberately; see [`PRD.md`](PRD.md) section 7.

## 3. Coding standards

Match the existing code exactly — it is consistent, and consistency here is
worth more than any individual preference.

- **WordPress Coding Standards** for PHP. Tabs for indentation, not spaces.
- Every PHP file opens with a docblock carrying `@package` (`SoundCreations`,
  `SoundCreationsChild`, `SoundCreationsCore` or `SoundCreationsEnquiries`) and
  an `ABSPATH` guard:
  ```php
  if ( ! defined( 'ABSPATH' ) ) {
      exit;
  }
  ```
- Prefix everything global. `sc_` for the theme, `sc_core_` for Core, `sc_enq_`
  for Enquiries. Post types use `sc_`, taxonomies `sc_`, meta keys `_sc_`.
- Text domains: `soundcreations` in the theme, `sc-core` and `sc-enquiries` in
  the plugins. Wrap user-facing strings.
- Escape at the point of output: `esc_html()`, `esc_attr()`, `esc_url()`,
  `esc_html__()`, `esc_attr__()`. There is exactly one deliberate unescaped echo
  in the codebase (inlined first-party critical CSS), and it carries a
  `phpcs:ignore` with a stated reason. If you need another, justify it the same way.
- Use `wp_safe_redirect()`, never `wp_redirect()`.
- PHP 8.0+ and WordPress 6.4+ are the floor. Do not use anything newer without
  raising the declared requirement in every package header.

### Comment your reasoning, not your syntax

This codebase explains **why**, often at length — why spam gets a success
response, why forwarded IP headers are distrusted, why the CSP sets no
`script-src`, why the archive SEO templates carry no title placeholder. Match
that standard. A comment that restates the code is noise; a comment that records
the decision behind it is the most valuable thing in the file.

## 4. Where to make a change

| Task | File |
| --- | --- |
| New or changed post type / taxonomy | `sound-creations-core/includes/post-types.php`, `taxonomies.php` |
| New editor field | `sound-creations-core/includes/fields.php` — add to `sc_core_field_groups()`; the renderer and save handler are generic |
| New admin-editable setting | `sound-creations-core/includes/settings.php` — add to `sc_core_settings_fields()` |
| SEO / structured data | `sound-creations-core/includes/seo.php` |
| New or changed form field | `sound-creations-enquiries/includes/forms.php` — forms are data, not markup |
| Submission logic | `sound-creations-enquiries/includes/handler.php` |
| Anti-abuse, uploads, retention | `sound-creations-enquiries/includes/security.php` |
| Notification routing | `sound-creations-enquiries/includes/admin.php` |
| Page markup | The matching template in `soundcreations/` |
| Reusable markup | `soundcreations/inc/template-tags.php` — extend it rather than duplicating markup across templates |
| Styles | `soundcreations/assets/css/` — `tokens.css` for design tokens, `main.css` for base, `content.css` for editorial |
| Asset loading, preload, inlining | `soundcreations/inc/enqueue.php` |
| Security headers, throttling | `soundcreations/inc/hardening.php` |
| Site-specific CSS override | `soundcreations-child/style.css` |

`functions.php` stays thin: constants and `require_once` lines only. New theme
logic goes in a new `/inc` module.

## 5. Gotchas that will catch you out

- **Theme version is a filemtime.** `SC_THEME_VERSION` is the modification time
  of `assets/css/main.css`. Any CSS edit cache-busts every asset. Do not replace
  this with a hardcoded string.
- **Brands archive is titled "Products".** The post type is `sc_brand`; a
  `document_title_parts` filter relabels it. The old `/products/` archive 301s
  to `/brands/`, and `/resources/*` 301s to `/videos/*`. Do not "fix" these.
- **`sc_enquiry` is registered in both plugins.** Core registers a baseline
  version; Enquiries registers a capability-restricted version at `init`
  priority 20 only if the type does not already exist. Known debt — see
  `ARCHITECTURE.md` section 11. Do not make it worse.
- **The LCP preload and the template must agree.** `enqueue.php` preloads a
  specific hero image per template. If you change a hero image in a template,
  change the preload too, or the browser high-priority-fetches an image that
  never paints while the real one waits behind it.
- **Speculation Rules exclude anything with side effects.** If you add an
  endpoint with side effects reachable by a plain link, add it to the exclusion
  list in `enqueue.php`.
- **Rate limits are keyed on `wp_salt( 'nonce' )`.** Rotating salts resets every
  counter and lockout.
- **Comments are dead site-wide** — closed, hidden, REST-stripped, feed-blocked,
  admin-removed. Do not add comment-dependent code.

## 6. Changing the content model

Adding a post type, changing a rewrite slug or adding a required page needs a
rewrite flush, and nobody should have to re-run Starter Setup by hand.

Bump `SC_CORE_SEED_VERSION` in `sound-creations-core.php`. The self-heal routine
on `admin_init` compares it against the stored `sc_core_pages_seed` option and,
on mismatch, re-registers types and taxonomies, re-ensures core pages and
flushes rewrite rules once. That is the mechanism. Use it.

## 7. Verifying your work

There is no test suite, no linter and no CI in this repository (tracked as the
top open item in `SECURITY-AUDIT.md`). Until that exists, verification is manual
and you are responsible for it:

- `php -l` every file you touched. A fatal here takes the site down.
- Save **Settings → Permalinks** after any rewrite change, and load the affected
  URLs plus the redirected legacy ones.
- After a form change: submit it successfully, submit it with a required field
  empty, confirm the email arrives at the routed address with a working
  Reply-To, and confirm the enquiry appears under **Enquiries**.
- After a template change: check the page at mobile and desktop widths, in both
  the dark and light themes.
- After a CSS change: confirm the version constant moved and the browser is
  serving the new file.
- Never test anti-spam or rate limiting by disabling it. Test through it.

If you add CI, the minimum useful gate is `php -l` across the tree plus PHPCS
with the WordPress ruleset, on every pull request.

## 8. Commits and pull requests

- One logical change per commit. Do not mix a refactor with a behaviour change.
- Write the subject in the imperative, under about 70 characters
  (`Add consent gate to the FANE partnership form`).
- Use the body to explain **why**, and name any decision a future reader would
  otherwise have to reverse-engineer.
- Never commit credentials, API keys, database dumps, uploads or `wp-config.php`.
- If a change affects security posture, the content model or the enquiry
  pipeline, update the matching document in the same commit. Documentation that
  drifts from the code is worse than none.

## 9. When you are unsure

State the uncertainty rather than guessing. Specifically: do not invent a
setting key, a meta key, a capability or a hook name — read the file and use the
real one. Do not silently change how a security control behaves. Do not delete
code you do not understand, particularly a redirect or a validation step: most
of the odd-looking code here exists because something broke in production once,
and the comment above it usually says so.
