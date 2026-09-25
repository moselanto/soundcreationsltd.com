# Architecture

Full technical reference for the Sound Creations Ltd website. For a fast
orientation read [`ARCHITECTURE-ESSENTIALS.md`](ARCHITECTURE-ESSENTIALS.md) first.

---

## 1. Design principle

The site is a classic WordPress install, but the code is deliberately split so
that **the business is not held hostage by the theme**.

- Content model, editorial fields, business settings and SEO output live in the
  **Core plugin**. Change the theme and none of it is lost.
- Lead capture lives in its own **Enquiries plugin**, because lead loss is the
  single most expensive failure mode for a B2B distributor.
- The **theme** renders. It holds templates, design tokens, CSS/JS, and the
  site's hardening and performance layer.
- The **child theme** is the active theme and carries nothing but CSS overrides,
  so parent updates never collide with site-specific tweaks.

No page builder, no WooCommerce, no third-party form plugin. Every dependency
avoided is an attack surface and a performance cost avoided.

---

## 2. Package map

```
soundcreationsltd.com/
├── soundcreations/                 Parent theme (v0.10.x)
│   ├── functions.php               Thin bootstrap: constants + 6 requires
│   ├── style.css                   WordPress theme header only
│   ├── theme.json                  Block editor palette / typography
│   ├── inc/
│   │   ├── setup.php               Theme supports, nav menus, widget areas
│   │   ├── enqueue.php             Assets, critical CSS, preload, speculation rules
│   │   ├── template-tags.php       Reusable markup helpers (largest module)
│   │   ├── shortcodes.php          Regional presence map and other front-end shortcodes
│   │   ├── hardening.php           Security headers, throttling, comment removal
│   │   └── customizer.php          Customizer panels
│   ├── assets/css|js|img|fonts     Design tokens, styles, scripts, self-hosted fonts
│   ├── front-page.php              Homepage
│   ├── page-about.php              About page
│   ├── page-fane.php               FANE brand landing page
│   ├── page-contact.php            Contact (renders the contact form)
│   ├── page-request-a-consultation.php
│   ├── archive-sc_{brand,project,resource,solution}.php
│   ├── single-sc_{brand,product,project,service,solution}.php
│   ├── taxonomy.php  archive.php  single.php  page.php  index.php  404.php
│   ├── template-parts/             Shared partials
│   └── header.php  footer.php  searchform.php
│
├── soundcreations-child/           Active theme: style.css + one enqueue hook
│
├── sound-creations-core/           Plugin (v0.5.x)
│   ├── sound-creations-core.php    Bootstrap, activation, self-heal
│   ├── includes/
│   │   ├── post-types.php          7 public types + services + enquiry store
│   │   ├── taxonomies.php          7 shared taxonomies
│   │   ├── settings.php            'soundcreations_settings' admin screen
│   │   ├── fields.php              Editorial meta boxes per post type
│   │   ├── seed-catalog.php        Reference brand/product catalogue
│   │   ├── starter-setup.php       One-click site scaffolding
│   │   ├── setup-wizard.php        Guided first-run setup
│   │   ├── seo.php                 Meta, canonical, OG, Twitter, JSON-LD
│   │   └── brand-order.php         Manual ordering of brands
│   └── assets/                     Admin JS (media picker, gallery, brand order)
│
└── sound-creations-enquiries/      Plugin (v0.2.0)
    ├── sound-creations-enquiries.php  Bootstrap, capabilities, cron teardown
    ├── includes/
    │   ├── forms.php               7 form definitions + renderer + shortcode
    │   ├── handler.php             Validation, storage, notification
    │   ├── security.php            IP resolution, throttling, spam score, uploads, retention
    │   ├── admin.php               List columns + Enquiry Routing screen
    │   └── mail.php                Branded From identity for all site mail
    └── assets/forms.css
```

---

## 3. Content model

### 3.1 Public post types

Registered in `sc_core_register_post_types()` on `init`. All are public, have
archives (except Services), support REST, and share the same supports array
(`title, editor, thumbnail, excerpt, custom-fields, page-attributes`).

| Type | URL base | Purpose |
| --- | --- | --- |
| `sc_project` | `/projects/` | Completed installations — the primary proof asset |
| `sc_product` | `/products/` | Individual products (archive retired, see 3.4) |
| `sc_brand` | `/brands/` | Represented brands; archive is presented as "Products" |
| `sc_solution` | `/solutions/` | Engineered solution offerings |
| `sc_case_study` | `/case-studies/` | Long-form project write-ups |
| `sc_resource` | `/videos/` | Videos and downloadable technical resources |
| `sc_fane_resource` | `/fane-resources/` | FANE-specific technical material |
| `sc_service` | `/service/{slug}/` | The four "What we do" pillars; **no archive** |

### 3.2 Private post type

`sc_enquiry` — lead storage. `public => false`, `exclude_from_search => true`,
admin UI on. It is registered in **both** plugins: Core registers a baseline
version, and the Enquiries plugin registers a capability-restricted version at
`init` priority 20 if Core is inactive, so leads are never dropped because a
plugin was switched off.

### 3.3 Taxonomies

All hierarchical, public, REST-enabled, with an admin column:

| Taxonomy | Applies to |
| --- | --- |
| `sc_product_category` | Products |
| `sc_brand_tax` | Products, Projects |
| `sc_industry` | Projects, Solutions, Case Studies |
| `sc_application` | Products, Solutions |
| `sc_project_type` | Projects, Case Studies |
| `sc_location` | Projects, Case Studies |
| `sc_solution_area` | Solutions |

### 3.4 Legacy URL handling

Two content areas were renamed after launch. Both are handled with permanent
redirects on `template_redirect` rather than by breaking links:

- `/products/` (the `sc_product` archive) → `/brands/`, because the
  represented-products list now lives on the Brands archive.
- `/resources/` and `/resources/*` → `/videos/*`, a prefix-preserving regex
  rewrite so deep links survive.

The Brands archive also has its document `<title>` rewritten to "Products" via
`document_title_parts`, so the URL, the post type and the user-facing label
intentionally differ. Keep that in mind when debugging.

### 3.5 Editorial fields

`sc_core_field_groups()` in `fields.php` defines meta boxes per post type —
for example Projects carry `client`, `location`, `year`, `summary`, plus the
four narrative blocks (`challenge`, `solution`, `technology`, `result`), a
`scope` list and a media-library `gallery`. Products carry `brand_name`,
`model`, `availability`, `datasheet` and `specs`. Adding a field is a one-line
addition to this array; the renderer and save handler are generic.

---

## 4. Settings: one option, one source of truth

`settings.php` registers the **Sound Creations → Settings** screen, writing a
single option: `soundcreations_settings`.

It holds far more than contact details. Sections cover business details,
footer columns, homepage content (hero copy, CTA labels and URLs, process
steps, proof stats, section headings and eyebrows), homepage images, and About
page content. Field types are `text`, `textarea`, `wysiwyg`, `image` and
`heading`.

Read it via:

- `sc_setting( $key, $default )` — theme helper, used throughout templates.
- `sc_core_get( $key, $default )` — plugin-side, delegates to `sc_setting()`
  when the theme is loaded and falls back to the raw option otherwise.

**Never hardcode a phone number, address, headline or stat into a template.**
If an editor cannot change it, it is a bug.

---

## 5. SEO and structured data

`seo.php` (the largest single module in Core) owns all search output, in the
plugin so it survives theme changes and so no third-party SEO plugin is needed.

It provides:

- `sc_seo_trim()` — word-boundary truncation at ~158 characters, matching what
  Google actually renders.
- `sc_seo_type_description()` — generated descriptions per post type, with
  **separate archive and singular templates**. Archive templates carry no title
  placeholder, because substituting an empty title previously produced broken
  copy such as "A completed  installation" on `/projects/`.
- Canonical URLs, Open Graph and Twitter card tags, and JSON-LD structured data.

Descriptions are written around the real business geography — Kenya, Rwanda,
DR Congo and the UAE — rather than generic boilerplate.

---

## 6. The enquiry system

### 6.1 Forms

`sc_enq_forms()` defines seven forms as data. Each field is
`array( name, label, type, required, half, options, placeholder )`.

| Key | Form | Notes |
| --- | --- | --- |
| `consultation` | Request a Consultation | Consent checkbox required |
| `contact` | Send us a message | Consent checkbox required |
| `quote` | Request a Quote | Brand/product/model/quantity |
| `product` | Product Enquiry | Same shape as quote, different intent |
| `dealer` | Become a Dealer | Business profile + optional PDF upload |
| `fane` | FANE Partnership | OEM/cabinet-manufacturer oriented |
| `support` | Technical Support | Issue type and support category |

Shared option lists (countries, sectors, business types, issue types) are
defined once at the top of the function and reused.

### 6.2 Submission pipeline

Both `admin_post_nopriv_sc_enquiry` and `admin_post_sc_enquiry` route to
`sc_enq_handle()`. Order matters — the cheap checks come first so a bot cannot
make the server do expensive work:

1. **Resolve client IP** (`sc_enq_client_ip()`).
2. **Attempt throttle** — 12 attempts / 10 minutes per IP, counted on *every*
   attempt including failures.
3. **Nonce** verification (`sc_enquiry_submit`).
4. **Known form type** check.
5. **Honeypot** (`sc_website`) — silently returns success.
6. **Time trap** — submitted under 3 seconds after render is rejected.
7. **Stale render stamp** — older than 24 hours is rejected as a replay.
8. **User-Agent presence** check.
9. **Volume cap** — 5 submissions / hour per IP.
10. **Consent** check where the form requires it.
11. **Field validation and sanitisation** — `sanitize_textarea_field`,
    `sanitize_email` or `sanitize_text_field` by field type; required fields and
    email validity enforced.
12. **Spam score** — rejected at ≥ 5, redirected as success.
13. **Duplicate check** — byte-identical payload from the same IP within 3 hours.
14. **Upload handling** — see 6.4.
15. **Storage** — `wp_insert_post()` as `sc_enquiry`, with every field written to
    `_sc_{field}` meta plus `_sc_type`, `_sc_ip`, `_sc_source`.
16. **Notification** — `wp_mail()` to the routed recipient, plain text, with a
    header-sanitised `Reply-To`.
17. **Redirect** — back to the source page with `?sc_sent=1` or
    `?sc_error={rate|spam|validation}`, anchored to `#sc-form`.

### 6.3 Spam scoring

`sc_enq_spam_score()` returns an additive score; 5 or more is rejected. Signals:
link stuffing (2, plus 3 more at three or more links), BBCode/raw HTML (3),
known spam vocabulary (3), bulk Cyrillic/CJK in an English-language B2B form
(3), disposable email domains (4), a URL or `@` inside the name field (3), and a
long body with no spaces at all (3). Filterable via `sc_enq_spam_score`.

It is deliberately additive rather than a single hard rule, so no one false
positive can block a legitimate enquiry on its own.

### 6.4 Uploads

Only the Dealer form accepts a file. `sc_enq_handle_upload()` enforces: 5 MB
cap, `UPLOAD_ERR_OK`, `is_uploaded_file()`, an allowlist of PDF/DOC/DOCX/JPEG/PNG,
outright rejection of double extensions and executable tails
(`.php`, `.phtml`, `.phar`, `.js`, `.htm(l)`, `.htaccess`, `.sh`, `.exe`, `.svg`),
`wp_check_filetype_and_ext()`, an independent `finfo` content-type check, and a
randomly generated filename (`enquiry-YYYYMMDD-{16 chars}.{ext}`) so stored
files are not enumerable.

### 6.5 Routing and identity

`sc_enq_recipient()` resolves in order: per-type override → `default` override →
the central `soundcreations_settings['email']` → `info@soundcreationsltd.com`.
Overrides are managed in **Sound Creations → Enquiry Routing**.

`mail.php` filters `wp_mail_from` and `wp_mail_from_name` so every message the
site sends comes from the Sound Creations identity on the site domain, keeping
SPF/DKIM alignment intact.

### 6.6 Capabilities and retention

Enquiries hold PII, so the post type uses a dedicated capability set
(`edit_sc_enquiry`, `read_sc_enquiry`, …) mapped to administrators only —
rather than the default `post` capabilities, which would expose every lead to
any Contributor. `create_posts` is `do_not_allow` on purpose: enquiries may only
arrive through the public form. Capability sync is version-gated so the role
object is only rewritten when the list changes.

A daily `sc_enq_daily_purge` cron deletes enquiries older than 24 months
(filter: `sc_enq_retention_months`; return 0 to disable). The cron is
unscheduled on deactivation.

---

## 7. Theme layer

### 7.1 Bootstrap

`functions.php` stays thin: it defines `SC_THEME_VERSION`, `SC_THEME_DIR`,
`SC_THEME_URI`, defines `DISALLOW_FILE_EDIT`, then requires the six `/inc`
modules. All logic belongs in those modules.

`SC_THEME_VERSION` is the **filemtime of `assets/css/main.css`** — editing any
CSS automatically busts the cache for every enqueued asset.

### 7.2 Setup

`setup.php` registers theme supports (title-tag, post-thumbnails, HTML5,
custom-logo, align-wide, responsive-embeds, editor-styles), a 1200px content
width, three nav menus (`primary`, `footer_solutions`, `footer_business`) and
one footer widget area.

### 7.3 Assets and performance

`enqueue.php` carries the performance strategy:

- `main.css` and `content.css` enqueued normally; `tokens.css` and `fonts.css`
  are **inlined into `<head>`** to remove two render-blocking requests, with
  relative font URLs rewritten to absolute.
- `theme.js` and `map.js` load in the footer and are given `defer` via
  `script_loader_tag`.
- The primary self-hosted font is preloaded; the LCP hero image is preloaded per
  template (front page and About have different heroes — if the preload and the
  template's actual image drift apart, the browser high-priority-fetches an
  image that never paints).
- A tiny inline script applies the saved colour theme (dark by default) before
  first paint to avoid a flash.
- **Speculation Rules** prerender same-site links on moderate eagerness, with
  patterns derived from `home_url()` because the install lives in a
  subdirectory. `wp-admin`, `wp-login.php`, `wp-json`, `wp-comments-post.php`
  and any URL with a query string are excluded, and logged-in users are skipped
  entirely, so nothing with a side effect is ever speculatively fetched.

### 7.4 Templates

Archive and single templates exist per post type, each hand-written for its
content shape. `template-tags.php` holds the shared markup helpers and is by
some margin the biggest theme module; prefer extending it over duplicating
markup across templates.

`shortcodes.php` provides the regional presence map — four confirmed locations
(Nairobi head office, Kigali branch, DR Congo distribution and projects, Dubai
Middle East hub), rendered as percentage-positioned pins over a map image with a
parallel text list. The text list is the source of truth and stays correct
independently of the graphic.

---

## 8. Hardening and performance cleanup (theme)

`hardening.php` is conservative by design — nothing there removes functionality
the site relies on. It covers `wp_head` cleanup, emoji and oEmbed removal,
XML-RPC and pingback disabling, security response headers, user-enumeration
blocking, REST endpoint restrictions, generic login errors, file-editor
disabling, total comment removal, and a login brute-force throttle.

Full detail, including the reasoning behind each control and the known gaps,
is in [`SECURITY-AUDIT.md`](SECURITY-AUDIT.md).

---

## 9. Lifecycle

**Core activation** registers types and taxonomies, ensures the core pages
exist, flushes rewrite rules and stamps `sc_core_pages_seed` with
`SC_CORE_SEED_VERSION`.

**Self-heal:** on every `admin_init`, if the stored seed version does not match
the constant, Core re-registers types, re-ensures the core pages and re-flushes
rewrites. This means a deploy that bumps the seed version repairs the site
without anyone re-running Starter Setup — the mechanism to use when you add a
post type, change a rewrite slug or add a required page.

**Enquiries activation** syncs capabilities. Deactivation unschedules the purge
cron. Rewrite rules are flushed on Core deactivation.

---

## 10. Conventions and constraints

- **Subdirectory install.** The site runs at `/newwebsite/`. Always derive paths
  from `home_url()` / `SC_THEME_URI`. Hardcoded root-relative paths will not
  match.
- **PHP 8.0+, WordPress 6.4+.** Both plugins and the theme declare this.
- **WordPress coding standards**: tabs for indentation, Yoda conditions in
  places, full `ABSPATH` guard at the top of every PHP file, `@package` docblock.
- **Escape on output**: `esc_html()`, `esc_attr()`, `esc_url()`. The single
  deliberate exception is the inlined first-party critical CSS, marked with a
  `phpcs:ignore` and a reason.
- **Sanitise on input**: every `$_POST` value passes through a sanitiser chosen
  by field type before it is stored or mailed.
- **Filters over edits**: `sc_enq_trusted_proxies`, `sc_trusted_proxies`,
  `sc_enq_spam_score`, `sc_enq_retention_months` exist so deployment-specific
  behaviour does not require forking the code.
- **Comment your reasoning.** The existing code explains *why* a control exists,
  not just what it does. Match that.

---

## 11. Known technical debt

- `SC_CORE_VERSION` (`0.5.24`) lags the plugin header version (`0.5.25`).
- `sc_core_register_post_types()` registers `sc_enquiry` with `capability_type
  => 'post'`, while the Enquiries plugin registers it with restricted
  capabilities. Whichever runs first wins; when Core is active, the restricted
  registration is skipped. This should be consolidated into one definition.
- There is no automated test suite, linting or CI. Nothing enforces coding
  standards or catches a fatal before deploy.
- The Content-Security-Policy is intentionally narrow (`frame-ancestors`,
  `object-src`, `base-uri` only) because inline scripts and a third-party
  accelerator plugin make `script-src`/`style-src` unsafe to set today.
- `sc_product` single templates still exist and are reachable, while the archive
  is redirected — the type is half-retired rather than cleanly resolved.
