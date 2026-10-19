# Work log and handover status

The running record of what has been changed on soundcreationsltd.com, what is
live, and what is still open. **Read this before starting new work, and append
to it when you finish.** Newest entries at the top. Keep each entry short:
what changed, the commit, whether it is live, and what is left.

Owner contact for decisions: Agnes (website project lead).

---

## Current status (last updated 19 Oct 2026)

### Standing decisions — do not reverse without the owner's confirmation

- **Products are not showcased.** The company has said it does not want
  individual products shown. The product directory on `/brands/` is hidden by
  default (setting `products_dir_enabled`; type `yes` to show). Do not enable
  it, link to it, or promote products until Agnes confirms the company has
  approved it. Individual product pages (e.g. FANE drivers) stay reachable
  by direct URL but are `noindex,follow` and out of the sitemap (`1d797b8`).
- **No invented content.** No sample testimonials, fake projects or
  placeholder addresses. Empty states hide the section instead.
- **Pre-redesign URLs are 301'd** (owner decision 19 Oct 2026): every old
  page Google crawled goes to its best new equivalent, per
  `docs/seo/LEGACY-REDIRECTS.md` (implemented in `d2e7337`). Change targets in
  that doc and the map in `includes/legacy-redirects.php` together.
- **Commits go directly to `main`** (owner's instruction), one logical change
  per commit.

### Open items / next steps

1. **Server PHP is 8.0.30**, which no longer gets security updates. The
   WordPress dashboard recommends PHP 8.3+, Site Health reports a critical
   issue, and the Better Search Replace plugin needs PHP 8.1+. Upgrade PHP at
   the host (check the code still runs; the declared floor is PHP 8.0).
2. **`php -l` has never been run on the Oct 2026 commits** (no PHP in the
   agent sandbox). Run it across the tree before or right after any deploy.
3. **Testimonials page is live but empty.** Add real client quotes under
   Testimonials in wp-admin (ideally local projects: PCEA Kahawa, RPF Rubavu).
4. **Sitemap**: `/wp-sitemap.xml` (WordPress core) is live (Rank Math's
   sitemap is off, so `/sitemap_index.xml` 404s, which is fine). Submit
   `/wp-sitemap.xml` in Google Search Console and confirm "Success"; some
   fetchers fail on it, so check for bot/WAF filtering if GSC errors.
5. **Mobile speed not verified.** Run PageSpeed Insights on the homepage
   (mobile), confirm WEBP under Tools -> Site Health -> Info -> Media
   Handling, then regenerate thumbnails once.
6. **Rank Math hook names** used in `seo.php` (`rank_math/sitemap/entry`,
   `rank_math/frontend/robots`, `rank_math/frontend/canonical`, and
   `rank_math/json_ld` in `seo-graph.php`) were written
   from documentation, not checked against the installed version.
7. **Before-and-after project photos** suggested by the external review are a
   content task, not code.

---

## Log

### 19 Oct 2026 — Legacy 301/410 redirects + product pages noindexed — committed, needs upload

| Commit | Change |
| --- | --- |
| `d2e7337` | New `sound-creations-core/includes/legacy-redirects.php` (required from `sound-creations-core.php`): implements the 70-row map, pattern rules and `?service=`/`?portfolio=` rows from `docs/seo/LEGACY-REDIRECTS.md`. `template_redirect` priority 1; exact rows fire even when WordPress guessed content; patterns only on 404; 410 rows render the 404 template with status 410; WordPress 404 slug-guessing off for mapped paths; mapped posts/pages out of sitemaps. Existing `/products/`, `/resources/`, `/sitenew/*`, `/newwebsite/*`, `testimonials-v-N` redirects untouched (none removed). |
| `1d797b8` | `includes/seo.php`: `sc_product` singles `noindex,follow` (wp_robots + Rank Math robots) and removed from the core sitemap and Rank Math sitemap entries (audit T-07). Reverse with the `sc_core_index_products` filter. |
| this commit | Docs (LEGACY-REDIRECTS, TECHNICAL-AUDIT T-07, ARCHITECTURE 3.4) and Core 0.5.28 -> 0.5.29. |

Why: Google still indexes ~70 old-site URLs (mostly 404; `/service/` served
a video and `/sitenew/` a duplicate homepage), and product pages were being
promoted although products are not showcased.

Deviation: `/author/moses/` (and any `/author/*`) answers **410**, not a
301 to `/about/`. `security.php` already 410s existing authors; redirecting
only unknown authors would reveal which usernames exist.

**Upload (all three, same time):**
- `sound-creations-core/includes/legacy-redirects.php` (new)
- `sound-creations-core/includes/seo.php`
- `sound-creations-core/sound-creations-core.php`

`php -l` was **not** run (no PHP in the agent sandbox); bracket balance was
checked by script and every line reviewed by hand. Lint first, or upload
with cPanel open so `sound-creations-core.php` can be reverted at once if
the site shows a critical error. No rewrite flush needed.

**Verify after upload:**
1. Plugins screen shows Sound Creations Core 0.5.29; homepage, a solution,
   a project, `/service/integration/` and wp-admin load normally.
2. `curl -sI https://soundcreationsltd.com/sitenew/` -> `301`, `Location: https://soundcreationsltd.com/`.
3. `curl -sI .../service/` -> `301` to `/solutions/`; `.../service/intergration/` -> `/service/integration/`.
4. `curl -sI` on `/our-services/`, `/audio-solutions/`, `/acoustic-solutions/`,
   `/shure-microphones/`, `/sound-creations-ltd-audio-visual-integration-at-citam-buruburu/`,
   `/2021/`, `/category/video/`, `/product-category/uncategorized/`,
   `/product/behringer-u-phoria-umc202hd-usb-audio-interface/` -> `301` with
   the `Location` in the map (one hop: curl the Location and expect `200`).
   Run every path in the doc's section 5 the same way.
5. Pattern: `/product/shure-sm58-test/` -> `/brands/shure/`; `/2019/05/` -> `/projects/`.
6. Query string kept: `/our-services/?utm_source=x` -> `/solutions/?utm_source=x`.
7. `curl -sI .../many-types-of-construction-equipment-are-designed/` and
   `.../product-category/surgery/` -> `HTTP/... 410`; `/author/moses/` -> `410`.
8. `curl -sI "https://soundcreationsltd.com/?portfolio=mdas"` -> `301` to `/brands/midas/`.
9. Live pages are not redirected: `/solutions/`, `/brands/`, `/projects/`, `/videos/`, `/products/` (still 301 to `/brands/`), `/resources/` (still 301 to `/videos/`).
10. View source of `/products/fane-cd140/`: robots meta contains `noindex` (and `follow`).
11. `/wp-sitemap.xml` no longer lists `wp-sitemap-posts-sc_product-1.xml`, and no sitemap lists an old-site URL.
12. Search Console: inspect `/sitenew/` and `/service/`, then request a
    re-crawl; re-run the Wayback CDX query and add any new paths to the doc.

### 19 Oct 2026 — Technical SEO + schema audit, 6 fixes — committed, needs plugin + 1 theme file upload

- Full report: `docs/seo/TECHNICAL-AUDIT.md`; schema reference: `docs/seo/SCHEMA.md`.
- `faeec28` Rank Math JSON-LD emptied in code while Core owns the graph
  (was only a wp-admin toggle). `fb64e15` FAQPage only where the FAQ block
  is visible. `29f1557` VideoObject thumbnails use hqdefault (maxresdefault
  404s on non-HD uploads). `6f0d066` product breadcrumbs go to /brands/, not
  the redirecting /products/ (visible + schema). `5ce401c` schema logo uses
  the Customizer logo when set (was the favicon). `7cca035` Service nodes
  get a description. Core version 0.5.28.
- Upload: `sound-creations-core/` (seo-graph.php, seo-faq.php,
  sound-creations-core.php) and `soundcreations/single-sc_product.php`.
- Raw `<head>` could not be fetched from the agent environment: confirm in
  view-source that there is exactly one ld+json block. php -l not run.
- Sitemap: `/wp-sitemap.xml` (WordPress core) is live and lists pages,
  projects, products, brands, solutions, videos, services; Rank Math's
  sitemap is off. It still lists the 5 FANE product pages - owner decision
  whether to noindex them (products are not showcased).
- Set a logo under Appearance > Customize > Site Identity for the schema fix
  to take effect.

### 19 Oct 2026 — Compact homepage testimonials strip (CSS only) — committed, needs main.css upload

- `main.css` only, scoped to `.sc-home-quotes`: less section padding,
  smaller heading, tighter cards, inline quote mark, 36px avatars, smaller
  arrows, reviews clamped to 4 lines (5 on phones) on the homepage only.
  The /testimonials/ page keeps full-length cards.

### 19 Oct 2026 — Homepage testimonials strip + Google rating line — committed, needs deploy

- `front-page.php`: new "What our clients say" section after the proof stats,
  before the closing CTA. Reuses the testimonials carousel (max 6), with a
  "Read all reviews" link to /testimonials/. Hidden when no testimonial is
  published.
- Rating line ("4.5 out of 5 from 143 Google reviews", partial gold stars)
  reads new settings `google_rating` / `google_review_count` (Locations and
  local SEO section) and links to `google_business`. Blank rating hides it.
  These must be filled in wp-admin; values seen on Google on 19 Oct: 4.5, 143.
- New settings: `home_testimonials_eyebrow`, `home_testimonials_title`,
  `home_testimonials_link_label` (defaults: Testimonials / What our clients
  say / Read all reviews).
- No Review/AggregateRating schema on purpose: Google ignores self-served
  reviews of a LocalBusiness and it can be treated as spam markup.
- Upload together with the carousel commit (template-tags.php, main.css,
  theme.js) plus front-page.php and sound-creations-core/includes/settings.php.

### 19 Oct 2026 — Testimonials page redesigned as a carousel — committed, needs theme deploy

- `sc_testimonials_grid()` (template-tags.php): 3 cards per row on desktop,
  2 on tablet, 1 with a peek on phones; the rest scroll left/right. Cards
  have a quote mark, initial avatar (or photo), name in title case, meta.
- `main.css`: native CSS scroll-snap track, arrow buttons, hover lift,
  reduced-motion support. Works without JS (swipe/trackpad/keyboard).
- `theme.js`: arrow buttons page through cards, disable at the ends and
  hide when all cards fit. No inline script, no CSP change.
- No star ratings shown: individual Google star ratings were not verified.
- Not live until the updated `soundcreations` theme files are uploaded.

### 19 Oct 2026 — Four Google reviews published as testimonials

- Published in wp-admin > Testimonials (verbatim text, reviewer name as
  title, "Google review" as Organisation): Brandon Tengeya, Aalawy Balala,
  MICHAEL ODIDA, TRIAD KUOLO. Verified live at /testimonials/.
- Moses Njeru Munyi's review was shortlisted but excluded at the owner's
  request. Do not add it.
- Source: Google Business Profile (4.5/5, 143 reviews at the time).
- Open item 3 (empty testimonials page) is resolved.

### 19 Oct 2026 — .htaccess step 4 live: more sensitive files blocked

- Owner confirmed the site works. Root reference copy updated to match.
- Step 5 prepared as a download: a minimal `wp-content/uploads/.htaccess`
  (FilesMatch + Require all denied only; the earlier version with Options
  and php_flag lines is withdrawn). Reference: docs/server/htaccess-uploads.txt.
- Remaining after step 5: HTTPS-before-/newwebsite/ reorder (optional),
  PHP 8.4 switch via cPanel MultiPHP Manager or the host (not .htaccess).

### 19 Oct 2026 — .htaccess step 3 live: AVIF, TTF/OTF, PDF, wider compression

- Owner confirmed the site works. Reference copy updated to match.
- Step 4 prepared as a download: block more sensitive files (wp-config
  sample, .user.ini/php.ini, backup/archive extensions, composer/npm files).

### 19 Oct 2026 — .htaccess step 2 live: images 180 days, not immutable

- Owner confirmed the site reloads fine. Reference copy updated to match.
- Step 3 prepared as a download: AVIF, TTF/OTF and PDF caching, MIME types
  and a wider DEFLATE list (same directive types already in use).

### 19 Oct 2026 — .htaccess step 1 live: ExpiresDefault removed

- ROOT CAUSE of the earlier 500 errors: copying .htaccess text out of the
  chat adds hidden characters the server rejects. The content itself was
  fine. NEVER have the owner paste .htaccess from chat; deliver it as a
  clean ASCII/LF file (Content Library download) to upload and rename, or
  as a single in-place deletion in File Manager.
- Live file = `docs/server/htaccess-root.txt` (28 Sep file minus
  `ExpiresDefault`, curly quotes in the cPanel comment made plain ASCII).
  Confirmed working by the owner.
- Step 2 prepared as a download (images 180 days, not immutable; CSS/JS/
  fonts stay 1 year immutable). Apply one step at a time, test after each.

### 19 Oct 2026 — Both new .htaccess versions caused 500; live file is the 28 Sep one

- The full AND the conservative 19 Oct .htaccess both gave a site-wide 500.
  Only the 28 Sep file works. Cause not identified yet; it may be how the
  file is pasted (copying from chat) rather than a directive.
- `docs/server/htaccess-root.txt` is now an exact copy of the working
  28 Sep file. Do NOT paste anything else on the server until the cPanel
  error log (Metrics > Errors) shows the exact failing line.
- Next step: change the working file one small edit at a time, testing
  after each, starting with removing `ExpiresDefault`.

### 19 Oct 2026 — Conservative .htaccess revision — owner to paste

- The full 19 Oct .htaccess caused a 500 on this server; the 28 Sep file
  works. Exact failing directive not identified (candidates: ea-php84
  handler, Brotli block, AddDefaultCharset/AddCharset, [S=3] rewrite rules).
- `docs/server/htaccess-root.txt` is now a conservative revision that only
  uses directive types the 28 Sep file already ran: HTTPS-first redirect
  order, no ExpiresDefault (dynamic JSON/XML not cached), images 180 days
  without immutable, AVIF/fonts/PDF, wider DEFLATE list, more blocked files.
  Handler stays ea-php80.
- Do not re-add Brotli, charset directives or wp-includes rewrite blocks
  without testing them one at a time on this server.
- The uploads `.htaccess` (docs/server/htaccess-uploads.txt) is on hold
  until the root file is confirmed stable; if added, drop the `Options` line
  first if images 500.

### 19 Oct 2026 — ea-php84 handler caused a 500 error — reverted to ea-php80

- Pasting the `ea-php84` handler gave a site-wide 500 error. Most likely
  cause: there is no EasyApache `ea-php84` package on this server; the 8.4
  shown in cPanel comes from the CloudLinux PHP Selector.
- Reference copy reverted to `ea-php80`. Do NOT hand-edit the cPanel handler
  block. Switch PHP via MultiPHP Manager ("inherit") + PHP Selector, or ask
  the host.

### 19 Oct 2026 — PHP 8.0 -> 8.4 handler — SUPERSEDED (see entry above)

- cPanel PHP Selector shows all five soundcreationsltd.com domains on PHP 8.4
  (account default), but the root `.htaccess` handler forced `ea-php80`, so
  WordPress still ran 8.0.30.
- `docs/server/htaccess-root.txt` handler now `ea-php84`. Preferred route:
  cPanel > MultiPHP Manager > set the domain to PHP 8.4, which rewrites the
  block itself. Only hand-paste if `ea-php84` is listed there.
- After switching: confirm Tools > Site Health > Info > Server shows 8.4,
  then test homepage, wp-admin, a form and the WhatsApp button. Roll back to
  `ea-php80` if anything shows a 500 error.

### 19 Oct 2026 — Improved .htaccess — committed as reference, owner to paste on server

- Master copies: `docs/server/htaccess-root.txt` (domain root) and
  `docs/server/htaccess-uploads.txt` (new file for `wp-content/uploads/`).
- Root: HTTPS before legacy redirects (one hop); removed `ExpiresDefault`
  that was caching JSON/XML/sitemaps/feeds for a month; images 180 days
  without `immutable`; Brotli + more types; WordPress-documented
  wp-includes blocks; more sensitive-file patterns; SVG CSP; UTF-8.
- Uploads: blocks PHP/script execution in the uploads folder.
- Not live until pasted via cPanel File Manager. Back up the current file
  first. Check after: homepage, wp-admin, a form submission, `/newwebsite/`
  redirect, an image and the WhatsApp button.

### 19 Oct 2026 — Hide product directory (commit `4dfab9a`) — committed, needs deploy

- `soundcreations/archive-sc_brand.php`: directory only renders when
  `products_dir_enabled` is `yes`.
- `sound-creations-core/includes/settings.php`: new field under
  "Products page - product directory".
- Reason: company does not want products showcased yet.

### 19 Oct 2026 — External site review fixes — deployed and checked live

Source: an AI-generated review of the site pasted by the owner (legacy
`/sitenew/` URLs, placeholder testimonials, mobile speed, product navigation,
homepage case studies).

| Commit | Change | Live check (19 Oct) |
| --- | --- | --- |
| `515c930` | 301 `/sitenew/*`, `/newwebsite/*` to root; `/testimonials-v-N/` to `/testimonials/`; legacy paths dropped from sitemaps. Only fires on 404. | Working: `/sitenew/`, `/testimonials-v-4/`, `/newwebsite/contact/` all resolve. |
| `b009dda` | Private `sc_testimonial` post type, seeded Testimonials page (`page-testimonials.php`), noindex until a quote exists. `SC_CORE_SEED_VERSION` 9 -> 10. | Page live, no quotes yet. |
| `05ada20` | `leads.js` deferred; WhatsApp chat card starts on idle or first interaction; footer logos lazy. LCP hero images untouched. | Not verifiable from page text. |
| `f2daa8c` | `includes/media.php`: WebP sub-sizes for new JPEG/PNG uploads; `responsive-img.php` maps WebP sizes. | Not verified; thumbnails need regenerating. |
| `7d1fa35` | `includes/product-filters.php`: Brand / Application / Product type filters on `/brands/`; filtered views noindex with canonical to unfiltered page. | Was live with 5 FANE products; now hidden by `4dfab9a`. |
| `08cd5f8` | Homepage projects carousel replaced with "Our Work" grid (6 projects, type, location, View all link); settings-driven labels. | Live: 6 projects incl. RPF Rubavu (Rwanda). |

### Earlier (before this log)

The site moved from the `/newwebsite/` subdirectory to the domain root. The
`/products/` -> `/brands/` and `/resources/` -> `/videos/` redirects predate
this log; see `ARCHITECTURE.md`.

The separate Rwanda site (soundcreationsltd.rw, repo
`moselanto/soundcreationsltd.rw`) has its own history and is not covered here.
