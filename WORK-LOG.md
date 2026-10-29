# Work log and handover status

The running record of what has been changed on soundcreationsltd.com, what is
live, and what is still open. **Read this before starting new work, and append
to it when you finish.** Newest entries at the top. Keep each entry short:
what changed, the commit, whether it is live, and what is left.

Owner contact for decisions: Agnes (website project lead).

---

## Current status (last updated 19 Oct 2026, 23:00 EAT)

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
- **PCEA Chuka case study is unlisted.** `/projects/pcea-chuka/` stays
  published (the old 2020 article 301s to it) but is hidden from every
  listing, the sitemap and Google via Settings -> "Unlisted projects"
  (`pcea-chuka`, `includes/unlisted.php`). The "Chuka, Kenya" location term is
  unassigned. Do not re-list it unless Agnes asks.
- **Dealership wording:** the company holds dealership certificates, so
  "certified" wording may stay, backed by visible proof. Allen & Heath and Bose
  Professional list Sound Creations for Kenya (verified 19 Oct 2026). Shure
  appointed Hub Media as Africa distributor on 8 Jul 2026: say "dealer" for
  Shure unless a current Shure certificate is shown.
- **Compete on every relevant term**, including where VTECH Audio overlaps.
- **Separate logins:** Kenya uses the Google account infosoundcreations@gmail.com
  (Search Console, GA4 G-3DES5T0T6T, GTM GTM-WQVHFBJ, Business Profile). Never
  use the Rwanda logins for this site.
- **Never paste .htaccess from chat** (hidden characters caused 500 errors);
  deliver clean files to upload, one change at a time.

### Open items / next steps

1. **Server PHP is 8.0.30** (no security updates). Switch via cPanel MultiPHP
   Manager ("inherit") / PHP Selector or ask the host; never hand-edit the
   cPanel handler block in .htaccess.
2. **`php -l` has never been run on the Oct 2026 commits.** Run it across the tree.
3. **Search Console (retry from 20 Oct; a one-shot assistant task is set for
   20 Oct ~10:00 EAT):** request indexing for `/solutions/sound-isolation/`,
   `/solutions/professional-audio/`, `/solutions/installation/`, `/` and
   `/about/`, then the pages changed by CONTENT-ADDITIONS-2 (church, education,
   hospitality, acoustics, `/service/consultancy/`, `/service/integration/`, the
   8 brand pages) as daily quota allows. 19 Oct attempts hit Google errors and
   the daily quota; boardroom page was queued OK. Never submit `pcea-chuka`.
   Rerun Rich Results Test on professional-audio and installation (FAQPage
   present in live JSON-LD). Check the Pages report once processed.
4. **Owner answers (answered 19 Oct):** site visits, live streaming, mosques/
   worship spaces, installing client-bought equipment and repairing
   non-supplied equipment are all offered "depending on client needs" (never
   write "free"). Ranges (Bose conferencing, dB Technologies, Allen & Heath,
   Behringer) are supplied to order, not stocked. Still unknown: the "Aid"
   brand's manufacturer/website (Aid page names no product lines) and whether
   Rockfon Sonar / Mono Acoustic may be named (left out). Any boardroom,
   mosque/temple, sports or studio project to cite.
5. **Google Business Profile:** all 8 drafted replies in
   `docs/seo/GBP-REVIEW-REPLIES.md` were submitted 19 Oct (Brandon, Aalawy,
   Michael, Triad, TechGuru published; Dennis, Asifa, Moses pending Google
   review - confirm). 100+ older reviews still unanswered. Photos last added
   ~2,100 days ago and no posts: waiting on owner photos (use the shot list),
   then weekly posts. Set up a review-request routine for recent clients.
6. **Dealership certificates:** owner to send; add to /distribution/ and brand pages.
7. **Manufacturer listings show old numbers** (Allen & Heath +254 20 2572752/3,
   Bose +254 720 886 900): ask them to update to +254 715 754 758 if agreed.
8. **Brand pages:** done 19 Oct (partnership sections + "<Brand> in Kenya"
   sections for Shure, Behringer, Midas, Rockfon, Barrisol, Asona, Aid, Sommer
   Cable). Add certificate images when the owner sends them (item 6).
9. **AI visibility:** baseline 19 Oct (ChatGPT logged-out, Gemini) recorded
   below; Perplexity and Copilot not tested (sign-in). Re-test in ~4 weeks.
10. **Mobile speed not verified** (PageSpeed); regenerate thumbnails once for WebP.
11. **Rank Math hook/meta names** in Core were taken from docs, not verified.
12. **Before-and-after project photos** are a content task.

---

## Log

### 29 Oct 2026 (later) - Masterclass moved off the homepage to /masterclass/ - committed, needs upload

- Owner decision: keep the top announcement strip, but the event section must
  NOT sit on the homepage (it pushed "What we do" down). Removed from
  `front-page.php`; the event now has its own page.
- New `soundcreations/page-masterclass.php` (picked by slug): event section with
  the event name as the h1, then any text typed in the page editor. After the
  end date it shows a short "registration has closed" note + Contact button.
- Core 0.5.34 (`includes/event-schema.php`): creates the `masterclass` page once
  on the first wp-admin load after upload (flag `sc_core_event_page_v1`; never
  overwrites an existing page). Event JSON-LD now emits on that page, not `/`.
- Strip text links to the page (`sc_event_page_url()`, setting
  `event_page_path`, default `/masterclass/`); its Register link still goes
  straight to Pesapal.
- **Upload:** theme `front-page.php`, `page-masterclass.php` (new),
  `inc/event.php`, `inc/template-tags.php`; Core `includes/event-schema.php`,
  `includes/settings.php`, `sound-creations-core.php`. Then open wp-admin once
  so the page is created, and optionally add "Masterclass" to the Primary menu.
- `php -l` NOT run (no PHP in the agent sandbox); brace balance checked.

### 29 Oct 2026 - Featured event: Advancing Audio Masterclass 2027 - committed, needs upload

- Client (Terry, 28 Oct) asked for the masterclass link on the site. Built as a
  reusable, settings-driven **Featured event** block, not a one-off:
  - announcement strip above the utility band on every page (`sc_event_bar()`);
  - homepage section under the hero, anchor `#sc-event`: poster, dates, venue,
    fee, five mentors, Register button + Instagram button (`sc_event_feature()`);
  - `[sc_event]` shortcode for any page (e.g. a dedicated `/masterclass/` page).
- All copy in Settings -> **Featured event**; defaults (from the poster) live in
  `sc_default_settings()`, so it works on upload with no admin step. Register
  link: https://store.pesapal.com/advancingaudiomasterclass2027 (new tab,
  `noopener noreferrer`). Type `no` in "Show featured event" to hide; it **hides
  itself automatically after 28 Mar 2027** (`event_end_date`).
- Core 0.5.33: new `includes/event-schema.php` emits EducationEvent JSON-LD on
  the homepage only while the event is live (no organizer claimed: the poster names none).
- GA4: new `event_register_click` event (leads.js); mark as a key event if wanted.
- Poster bundled at `soundcreations/assets/img/events/` (900px WebP + JPG).
- **Upload:** theme `inc/event.php` (new), `functions.php`, `header.php`,
  `front-page.php`, `inc/template-tags.php`, `assets/css/main.css`,
  `assets/js/leads.js`, `assets/img/events/` (new folder); Core
  `includes/event-schema.php` (new), `includes/settings.php`,
  `sound-creations-core.php`.
- `php -l` NOT run (no PHP in the agent sandbox); brace balance checked by script.
  Verify: strip + section at mobile/desktop in dark and light themes; Register
  opens Pesapal in a new tab; Rich Results Test on `/` shows the Event.

### 19 Oct 2026 (late) — CONTENT-ADDITIONS-2 published + two template fixes — all live

- **Published in wp-admin** (from `docs/seo/CONTENT-ADDITIONS-2.md`, `b037293`):
  appended sections on church, education, hospitality, professional audio,
  acoustics, `/service/consultancy/`, `/service/integration/` and 8 brand pages
  (Shure, Behringer, Midas, Rockfon, Barrisol, Asona, Aid, Sommer Cable). New FAQ
  pairs added to the FAQ meta boxes (church's two were skipped as duplicates of
  ones already there; acoustics' 7th FAQ sits in the body under "More
  questions"). Prestige Plaza and COVO links use `/projects/prestige-plaza/`
  and `/projects/covo-bnd/`. Rockfon product names and Aid product lines left
  out (unverified). All checked on the live pages.
- **Homepage:** Settings -> "What we do: intro" replaced with the 65-word AV
  company paragraph. Old value, for rollback: "If it sounds good, it's Sound
  Creations. From acoustic design and system engineering to equipment,
  integration, commissioning and support, we deliver world-class technology and
  expertise across Africa and the Middle East."
- **About (post 22):** body now = old one-line intro + H2 "About Sound
  Creations" + the 113-word AI-ready company summary.
- **`ccb3b6e` single-sc_solution.php:** the professional-audio layout used to
  hide the whole body. It now renders the body from the first heading onward
  (the two old 2010s-era intro paragraphs above it stay hidden on purpose).
  On that page FAQs now come through the_content, not the direct render.
  Uploaded and verified live: new section shows, 6 FAQs, no duplicates.
- **`be380ce` page-about.php:** renders the About editor body (section
  `#about-company`) above Company Profiles when it has text. Uploaded and
  verified live.
- **Also earlier on 19 Oct, in wp-admin (no code):** partnership-proof
  sections on /distribution/ and the Bose, Allen & Heath, dB Technologies and
  FANE brand pages; LinkedIn setting -> https://www.linkedin.com/company/soundcreationsltd;
  extra FAQs for live streaming, mosques, client-bought equipment and repairs.
- **Not yet done:** `php -l` still not run on `ccb3b6e`/`be380ce` (no PHP in the
  assistant sandbox); both pages render without errors.

### 19 Oct 2026 — SEO/AEO/GEO phase 1 summary (evening)

- **Titles/meta:** 17 key pages' Rank Math titles and descriptions rewritten
  per KEYWORDS.md (live in wp-admin, no upload).
- **New pages (published in wp-admin):** `/solutions/sound-isolation/`,
  `/solutions/conferencing-boardroom-audio/`, `/projects/pcea-chuka/`
  (now unlisted). Unconfirmed claims were left out (see open item 4).
- **FAQs:** 27 Q&As in the FAQ meta boxes of church, acoustics, professional
  audio, installation, after-sales and distribution pages. Template fix
  `9657df6` makes them render on professional-audio and installation; FAQPage
  schema verified in live JSON-LD on both.
- **Code commits (all uploaded, Core 0.5.32 live):** `c85894b` JSON-LD
  description follows Rank Math; `2dae4e9` Chuka redirect -> case study;
  `9657df6` FAQ rendering; `2e590e1` unlisted projects.
- **Docs:** `docs/seo/CLIENT-KEYWORDS.md` (`9ed4d5b`, company keyword list
  mapped one target page per group), `CONTENT-DRAFTS.md`, `GBP-REVIEW-REPLIES.md`.
- **GA4 (property 363802499):** key events now generate_lead, whatsapp_click,
  phone_click, whatsapp_chat_open; event retention 2 -> 14 months; Search
  Console link confirmed. GTM container is empty and unused (site uses gtag
  directly); nothing published there.
- **Search Console:** `/wp-sitemap.xml` resubmitted (Success, 57 pages, no
  product sitemap). Last 3 months: 50 clicks, 1,869 impressions, avg pos 5.9,
  mostly branded queries.
- **AI visibility baseline (19 Oct):** ChatGPT (logged out) named Sound
  Creations 1st for Nairobi installers, church installers, Allen & Heath and
  Bose distributor questions, 3rd for acoustic consultants and soundproofing,
  absent for conference-room AV. Gemini: 1st for acoustic consultants, Allen &
  Heath, Bose; absent for installers, church sound, soundproofing, conference AV.

### 19 Oct 2026 — JSON-LD description follows Rank Math meta — committed, needs upload

- `includes/seo-graph.php`: new `sc_seo_rank_math_description()` and
  `sc_seo_schema_description()`. The WebPage node (and the Service node on
  solutions/services) now prefers Rank Math's per-post meta description
  (`rank_math_description`; posts-page homepage option as a fallback) before
  Core's old chain. `%variables%` are resolved with Rank Math's replacer or the
  value is skipped. Only used while Rank Math owns the meta.
- Why: titles/descriptions were rewritten in Rank Math today, but the homepage
  WebPage JSON-LD still carried the old description.
- Core 0.5.29 -> 0.5.30. `docs/seo/SCHEMA.md` field sources updated.
- **Upload:** `sound-creations-core/includes/seo-graph.php` and
  `sound-creations-core/sound-creations-core.php`.
- `php -l` NOT run (no PHP in the agent sandbox); bracket balance checked by
  script, hand-reviewed. Rank Math meta key / option / `replace_vars` names are
  from Rank Math docs, not verified on the installed version; all paths fall
  back to the old behaviour.
- **Verify:** view-source of `/` and one `/solutions/...` page: the ld+json
  WebPage `description` equals `<meta name="description">`; no `%` variables;
  Rich Results Test still parses.

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
