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
  approved it. Individual product pages (e.g. FANE drivers) are still
  reachable by direct URL; hiding those too is an open question.
- **No invented content.** No sample testimonials, fake projects or
  placeholder addresses. Empty states hide the section instead.
- **Pre-redesign blog posts** at the root (e.g. `/audio-solutions/`,
  `/yu-mwaminifu-concert-by-james-kahero/`) are left alone on purpose.
  Redirecting or deleting them is an owner decision that has not been made.
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
4. **Sitemap could not be fetched** (`/wp-sitemap.xml` failed,
   `/sitemap_index.xml` 404). Check Rank Math -> Sitemap Settings, then submit
   it in Google Search Console.
5. **Mobile speed not verified.** Run PageSpeed Insights on the homepage
   (mobile), confirm WEBP under Tools -> Site Health -> Info -> Media
   Handling, then regenerate thumbnails once.
6. **Rank Math hook names** used in `seo.php` (`rank_math/sitemap/entry`,
   `rank_math/frontend/robots`, `rank_math/frontend/canonical`) were written
   from documentation, not checked against the installed version.
7. **Before-and-after project photos** suggested by the external review are a
   content task, not code.

---

## Log

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
