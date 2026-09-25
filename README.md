# Sound Creations Ltd — Website

Source for the Sound Creations Ltd website: <https://soundcreationsltd.com/newwebsite/>

Sound Creations Ltd is a B2B professional audio, acoustics, distribution and
integration company headquartered in Nairobi, Kenya, with a branch in Kigali,
project delivery across DR Congo, and a Middle East hub in Dubai.

This repository holds the **first-party WordPress code only** — one custom theme,
one child theme and two custom plugins. WordPress core, third-party plugins,
uploads and the database are not tracked here.

---

## What is in this repository

| Path | Type | Purpose |
| --- | --- | --- |
| `soundcreations/` | Theme | The custom parent theme. Dark-first, editorial, hand-built — no page builder, no WooCommerce. |
| `soundcreations-child/` | Child theme | Thin override layer for site-specific CSS tweaks. |
| `sound-creations-core/` | Plugin | Content types, taxonomies, editorial fields, the central business-settings store, SEO/structured data, and starter setup. |
| `sound-creations-enquiries/` | Plugin | The full B2B enquiry system: seven forms, validation, anti-spam, private lead storage, routing and notification. |

The split is deliberate. **Anything the business would lose if the theme changed
lives in a plugin**: content types, settings, SEO. The theme only presents.

---

## Requirements

- WordPress 6.4 or newer
- PHP 8.0 or newer
- HTTPS (HSTS is emitted when SSL is detected)

## Installation

1. Copy `soundcreations/` and `soundcreations-child/` into `wp-content/themes/`.
2. Copy `sound-creations-core/` and `sound-creations-enquiries/` into `wp-content/plugins/`.
3. Activate **Sound Creations Core** first — it registers the post types and
   creates the core pages on activation.
4. Activate **Sound Creations Enquiries** — it grants the enquiry capabilities to
   the administrator role and schedules the data-retention cron.
5. Activate the **Sound Creations Child** theme.
6. Go to **Sound Creations → Settings** and fill in the business details
   (company name, phone, email, address, hours, social links). Almost all
   front-end copy on the homepage, About page and footer is read from here.
7. Go to **Settings → Permalinks** and save once if any URL 404s.

## Day-to-day editing

Nearly everything an editor needs is in the WordPress admin:

- **Sound Creations → Settings** — contact details, homepage copy, hero media,
  proof stats, About page copy, footer columns.
- **Projects / Products / Brands / Solutions / Services / Videos / FANE
  Resources** — the content types, each with its own editorial field group.
- **Enquiries** — every lead ever submitted, visible to administrators only.
- **Sound Creations → Enquiry Routing** — which address each form type notifies.

## Documentation

| Document | Read it when |
| --- | --- |
| [`ARCHITECTURE-ESSENTIALS.md`](ARCHITECTURE-ESSENTIALS.md) | You have five minutes and need to find the right file. |
| [`ARCHITECTURE.md`](ARCHITECTURE.md) | You are changing how something works. |
| [`PRD.md`](PRD.md) | You are deciding what to build, or why something exists. |
| [`SECURITY-AUDIT.md`](SECURITY-AUDIT.md) | You are touching forms, uploads, auth, headers or PII. |
| [`AGENTS.md`](AGENTS.md) | You (or an AI agent) are about to write code here. |

## Licence

GPL-2.0-or-later, matching WordPress.
