# Architecture Essentials

The five-minute version. For the full picture see [`ARCHITECTURE.md`](ARCHITECTURE.md).

## The one rule

**Business logic lives in plugins. Presentation lives in the theme.**

If the site were re-themed tomorrow, the content types, editorial fields,
business settings, SEO output and the entire enquiry system would survive
untouched. That is the whole reason for the four-package split.

## The four packages

```
soundcreations/              Parent theme    — templates, CSS, JS, hardening
soundcreations-child/        Child theme     — active theme; CSS overrides only
sound-creations-core/        Plugin          — content model, settings, SEO
sound-creations-enquiries/   Plugin          — forms, anti-spam, leads, mail
```

## Where things live

| I need to change... | Go to |
| --- | --- |
| A page's markup | `soundcreations/` — `front-page.php`, `page-about.php`, `single-sc_*.php`, `archive-sc_*.php` |
| A reusable markup helper | `soundcreations/inc/template-tags.php` |
| Styles | `soundcreations/assets/css/` (`tokens.css`, `fonts.css`, `main.css`, `content.css`) |
| Which CSS/JS loads, preloads, inlining, prerender | `soundcreations/inc/enqueue.php` |
| Security headers, login throttle, comment blocking | `soundcreations/inc/hardening.php` |
| A post type or taxonomy | `sound-creations-core/includes/post-types.php`, `taxonomies.php` |
| An editor field on a content type | `sound-creations-core/includes/fields.php` |
| Admin-editable site copy or contact details | `sound-creations-core/includes/settings.php` |
| Meta description, Open Graph, JSON-LD | `sound-creations-core/includes/seo.php` |
| A form's fields | `sound-creations-enquiries/includes/forms.php` |
| Submission validation and storage | `sound-creations-enquiries/includes/handler.php` |
| Rate limiting, spam scoring, upload rules, retention | `sound-creations-enquiries/includes/security.php` |
| Where a form's notification is emailed | `sound-creations-enquiries/includes/admin.php` (or the admin UI) |

## The content model at a glance

Public post types (all with archives unless noted):

`sc_project` · `sc_product` · `sc_brand` · `sc_solution` · `sc_case_study` ·
`sc_resource` (labelled "Videos") · `sc_fane_resource` · `sc_service` (no archive)

Private post type: `sc_enquiry` — lead storage, admin-only, excluded from search.

Taxonomies: `sc_product_category`, `sc_brand_tax`, `sc_industry`,
`sc_application`, `sc_project_type`, `sc_location`, `sc_solution_area`.

Two legacy URL spaces are 301-redirected: `/products/` → `/brands/` and
`/resources/` → `/videos/`.

## Settings are the source of truth for copy

One option, `soundcreations_settings`, holds business details plus most
homepage, About and footer copy. Templates read it through `sc_setting()`;
the Core plugin reads it through `sc_core_get()`. Do not hardcode a phone
number, address or headline into a template.

## The enquiry path

```
Form (shortcode or auto-appended)
  → POST to admin-post.php?action=sc_enquiry
    → IP throttle → nonce → honeypot → time trap → UA check → volume cap
      → field validation → spam score → duplicate check → upload check
        → stored as sc_enquiry post + meta
        → wp_mail() to the routed recipient, Reply-To set to the sender
          → redirect back with ?sc_sent=1 or ?sc_error=<code>
```

Spam and duplicates are redirected as **success**, deliberately, so bots do not
retry — but nothing is stored or mailed.

## Things that will surprise you

- The install lives in a **subdirectory** (`/newwebsite/`). Never hardcode a
  root-relative path like `/wp-admin/*`; derive it from `home_url()`.
- The theme version constant is the **filemtime of `main.css`**, so any CSS edit
  cache-busts every asset automatically.
- `DISALLOW_FILE_EDIT` is defined in **both** the theme and its hardening module.
- The Brands archive is titled "Products" on the front end via a
  `document_title_parts` filter. The post type is still `sc_brand`.
- Comments are dead site-wide: closed, hidden, REST-stripped, feed-blocked and
  removed from the admin.
