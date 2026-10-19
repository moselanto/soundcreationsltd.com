# Technical SEO and structured-data audit - soundcreationsltd.com

Date: 19 Oct 2026. Scope: soundcreationsltd.com only (not soundcreationsltd.rw).
Method: rendered-page crawl of the live site (via a text reader, see the
limitations below), robots.txt, the WordPress core sitemap index and every
child sitemap, and a line-by-line review of `sound-creations-core/includes/seo*.php`,
`post-types.php`, `settings.php` and the theme templates.

Page titles and H1 copy were deliberately NOT changed for keywords; a separate
keyword study is running. Only technical defects were fixed.

## Limitations - read before relying on this

- **Raw HTML `<head>` could not be fetched from the audit environment.** The
  sandbox has no internet and the page reader returns rendered text only. So
  the live JSON-LD, meta description, canonical and robots tags were **not**
  observed directly. Everything about live schema output below is derived from
  the code plus the owner's recorded Rank Math settings, and is marked
  *hypothesis* where it matters. Step 1 of the validation checklist closes this.
- **`php -l` was not run** on any changed file (no PHP available). Brace and
  parenthesis balance was checked mechanically and every edit was reviewed by
  hand, but lint before or immediately after deploy.

## Who owns what in the `<head>`

| Feature | Owner | Evidence |
| --- | --- | --- |
| `<title>` | Rank Math | Live titles such as "Solutions \| Sound Creations Ltd" and "Brands \| Sound Creations Ltd" do not match Core's `sc_title_archive_map()`; Rank Math short-circuits `document_title_parts` via `pre_get_document_title`. |
| Meta description, canonical, OG/Twitter | Rank Math | `sc_seo_rank_math_owns_meta()` makes Core print only the graph when Rank Math is active (owner decision, 14 Oct 2026). |
| Robots meta | Rank Math, fed by Core | Core's thin-archive decision is passed through `wp_robots` and `rank_math/frontend/robots`. |
| Sitemap | WordPress core | `/wp-sitemap.xml` is a core sitemap index; `/sitemap_index.xml` 404s, so Rank Math's sitemap module is off. |
| JSON-LD | Core (`seo-graph.php`, `seo-faq.php`) | Single `@graph`. Rank Math schema module is off; now also enforced in code (commit `faeec28`). |

## Findings register

Priority: P0 = harmful now, P1 = defect with real search impact, P2 = worth
fixing, P3 = polish. Type: **Defect** (confirmed) or **Hypothesis** (needs a
live check).

| ID | URL / file | Observed | Evidence | Impact | Fix | Pri | Type | Status | Verification |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| T-01 | all pages / `seo-graph.php` | Duplicate-schema protection depended only on a wp-admin toggle (Rank Math Schema module off). | Code: no guard against Rank Math `json_ld` output. | If the module is ever re-enabled (update, import, click), every page gets two Organization nodes with different `@id`s and two BreadcrumbLists. | Empty `rank_math/json_ld` while Core owns schema; filter `sc_seo_core_owns_schema`. | P1 | Defect (latent) | **Fixed `faeec28`** | View source: exactly one `application/ld+json` block, no `rank-math-schema` class. |
| T-02 | any page with FAQ pairs / `seo-faq.php` | FAQPage schema emitted on every singular with `_sc_faq` meta, but the visible block only renders through `the_content`, which About, FANE, Contact, Consultation never call and Solutions/Videos call only with body text. | Template review (grep of `the_content`). | Invisible FAQ markup = structured-data spam policy breach, manual-action risk. No live page was seen carrying FAQs, so latent. | `sc_faq_is_rendered()` gates the node on the chosen template. | P1 | Defect (latent) | **Fixed `fb64e15`** | Add a test FAQ to /about/: no FAQPage in the graph. Add it to a brand page: FAQ visible and in the graph. |
| T-03 | /videos/* / `seo-graph.php` | VideoObject `thumbnailUrl` = YouTube `maxresdefault.jpg`. | Code. | 404 for non-HD uploads; unfetchable thumbnail makes the video ineligible. | Use `hqdefault.jpg`. | P1 | Defect | **Fixed `29f1557`** | Rich Results Test on each /videos/ page: Video detected, no thumbnail error. |
| T-04 | /products/* / `seo-graph.php`, `single-sc_product.php` | Breadcrumb (visible and schema) second item = `/products/`, which 301s to `/brands/`. | `sc_core_redirect_legacy_paths`, templates. | Redirecting URL in BreadcrumbList; inconsistent trail. | Both trails now Home / Brands / Product. | P1 | Defect | **Fixed `6f0d066`** | Rich Results Test on /products/fane-cd140/: breadcrumb item 2 = /brands/. |
| T-05 | all pages / `seo-graph.php` | Organization `logo` is the 512px Site Icon (favicon). | Code. | Weak logo for brand/knowledge-panel surfaces. | Prefer Customizer `custom_logo`, fall back to Site Icon. | P1 | Defect | **Fixed `5ce401c`** - takes effect once a logo is set under Appearance > Customize > Site Identity. | Graph `#logo` URL = the uploaded logo. |
| T-06 | /solutions/*, /service/* / `seo-graph.php` | Service node had no `description` (templates have no excerpt). | Code; live pages render from PHP templates. | Thin Service entity. | Fall back to `sc_seo_description()`. | P2 | Defect | **Fixed `7cca035`** | Schema validator shows Service.description. |
| T-07 | sitemap `wp-sitemap-posts-sc_product-1.xml` | 5 FANE product pages listed and indexable while products are "not showcased". | Live sitemap. | Contradicts the owner decision; product pages are reachable and promoted to Google. | Owner decision (19 Oct 2026, products not showcased): `noindex,follow` on product singles via `wp_robots` and `rank_math/frontend/robots`; `sc_product` removed from the core sitemap and Rank Math sitemap entries. Pages stay online. Reversible via `sc_core_index_products`. | P2 | Defect vs. policy | **Fixed `1d797b8`** | View source of /products/fane-cd140/: robots meta contains `noindex`; /wp-sitemap.xml no longer lists `wp-sitemap-posts-sc_product-1.xml`. |
| T-08 | /brands/ | Visible breadcrumb label "Products", title "Brands \| ...", Core title filter says "Products", schema crumb says "Brands". | Live page, `post-types.php`. | Inconsistent naming of one page. | Pick one label (keyword study). | P2 | Defect | Open (deferred to keyword study) | - |
| T-09 | archives | Core archive title templates (`sc_title_archive_map`) are dead while Rank Math owns titles. | Live titles. | Confusing code; titles are short but not broken. | Set titles in Rank Math after the keyword study, or let Core own titles. | P2 | Defect | Open | - |
| T-10 | /service/* | Visible trail Home / Services (`/#services`) / X; schema trail Home / X (no Services archive). | Template vs code. | Minor mismatch; a fragment URL should not be a breadcrumb item, so schema is the safer one. | None now. | P3 | Defect | Open (accepted) | - |
| T-11 | /wp-sitemap.xml | Direct fetch from the audit tool failed; a proxy reader fetched it fine. | Tool output. | Could be bot/WAF filtering by user agent. | Check Search Console > Sitemaps status. | P1 | Hypothesis | Open - needs GSC | GSC shows "Success" for /wp-sitemap.xml. |
| T-12 | all pages | Live Rank Math meta description may differ from the `description` Core puts on the WebPage node. | Code (`sc_seo_description()` vs Rank Math). | Mild inconsistency, no penalty. | Optionally read Rank Math's description when active. | P3 | Hypothesis | Open | View source. |
| T-13 | all pages | Organization `@type` is `["Organization","ProfessionalService"]` at `#organization`; no separate Nairobi LocalBusiness. | Code. | Correct by design (one entity, no duplicate at the same address). | None. | - | Pass | - | - |
| T-14 | /projects/* | CreativeWork has `about` = the Organization. | Code. | Semantically loose (a project is about the venue); harmless. | Later: `about`/`contentLocation` = venue Place. | P3 | Defect | Open | - |
| T-15 | headings | Every template emits exactly one H1; front page uses a visually hidden H1 when the hero headline is blank. | Template grep. | - | None. | - | Pass | - | - |
| T-16 | robots.txt | Sitemap line present; `/wp-json/`, search, feeds blocked; SEO crawlers blocked. Two `User-agent: *` groups (WordPress default + custom). | Live file. | Harmless (Google merges groups). | Optional tidy. | P3 | Defect | Open | - |
| T-17 | images | Brand logos and project cards carry descriptive alt text on the pages sampled. | Live render. | - | None. | - | Pass | - | - |
| T-18 | hreflang | Single English site; the Rwanda site is a separate domain. | - | Not needed. | None. | - | Pass | - | - |
| T-19 | settings | `google_rating` / `google_review_count` used only for visible text; no Review/AggregateRating schema. | Code + WORK-LOG. | Correct (self-serving review markup avoided). | None. | - | Pass | - | - |
| T-20 | `seo.php` | Rank Math hook names (`rank_math/frontend/robots`, `.../canonical`, `rank_math/sitemap/entry`, and now `rank_math/json_ld`) not checked against the installed version. | WORK-LOG open item 6. | If a name is wrong the filter silently does nothing. | Confirm on the server. | P2 | Hypothesis | Open | View source on a filtered /brands/?f_brand= URL shows noindex. |

## What was fixed (all on `main`)

| Commit | Subject |
| --- | --- |
| `faeec28` | Suppress Rank Math JSON-LD while Core owns the graph |
| `fb64e15` | Emit FAQPage schema only where the FAQ block is visible |
| `29f1557` | Use hqdefault YouTube thumbnails in VideoObject |
| `6f0d066` | Point product breadcrumbs at Brands, not the redirected archive |
| `5ce401c` | Prefer the Customizer logo over the favicon in schema |
| `7cca035` | Give Service nodes a description on template pages |
| `1d797b8` | Keep product pages out of Google while products are hidden (T-07) |
| `d2e7337` | Redirect legacy URLs from the pre-redesign site (see LEGACY-REDIRECTS.md) |

Files to upload: `sound-creations-core/includes/seo-graph.php`,
`sound-creations-core/includes/seo-faq.php`,
`sound-creations-core/sound-creations-core.php` (version bump),
`soundcreations/single-sc_product.php`.

## What remains

- T-07: fixed in `1d797b8`; upload `sound-creations-core/includes/seo.php` and verify.
- T-08, T-09: title and label alignment, after the keyword study.
- T-11, T-20: confirm in Search Console and on the server.
- Upload a real logo in the Customizer so T-05 takes effect.
- Fill `branch_kigali_*`, `branch_drc_*`, `branch_dubai_*` settings only with
  verified addresses; branch nodes stay silent until then.

## Validation steps (after upload)

1. `php -l` the four uploaded files. Load the homepage, a solution, a product,
   a video page and wp-admin.
2. View source of the homepage: exactly one `<script type="application/ld+json">`;
   no `rank-math-schema` class; one meta description, one canonical, one robots tag.
3. <https://validator.schema.org/> on /, /solutions/acoustics/, /service/consultancy/,
   /brands/shure/, /projects/sarit-expo-centre/, /videos/sound-masking/,
   /products/fane-cd140/: no errors; all nodes share the `https://soundcreationsltd.com/#organization` id.
4. Google Rich Results Test on the same URLs: Breadcrumb valid everywhere,
   Video valid on /videos/*, no FAQ detected unless an FAQ is visible. A
   "missing offers" warning on product pages is expected (no prices by policy).
5. Search Console > URL Inspection > Test live URL for / and /solutions/acoustics/;
   Search Console > Sitemaps: /wp-sitemap.xml status "Success".
6. Search Console > Enhancements (Breadcrumbs, Videos) a few days later.
