# Legacy URL inventory and redirect map: soundcreationsltd.com

Compiled 2026-10-19. **Implemented 2026-10-19 in commit `d2e7337`** (`sound-creations-core/includes/legacy-redirects.php`, Core 0.5.29); see the Implementation column and section 4. Not live until that file and `sound-creations-core.php` are uploaded.

## 1. Method and sources

| Source | What was done | URLs contributed |
|---|---|---|
| Wayback Machine CDX API (`/cdx/search/cdx?url=soundcreationsltd.com/*` and `www.`, `from=2015`) | Tried over https, over http, through the `timemap` endpoint and through r.jina.ai. Every attempt failed: service_error, blocked, or no DNS in the sandbox. | 0. **Gap: re-run the CDX query from a normal machine and diff it against this table.** |
| Wayback availability API (`archive.org/wayback/available`) | Confirmed snapshots of `/` (2026-06-13) and `/our-services/` (2021-11-27). The 2021 snapshot was read for content and phone numbers. | 1 confirmation, no new URLs |
| Web search (`site:soundcreationsltd.com` plus variations: blog post titles, product, product-category, category, tag, author, page/2, service, sitenew, newwebsite, testimonials-v, portfolio) | Search-index results were collected and de-duplicated. Hosts `rwanda.soundcreationsltd.com` and `soundcreationsltd.rw` were excluded because they are out of scope. | 62 paths |
| URLs already known (given in the brief) | 10 named pages/posts plus 2 /product/ pages | 12 (all also found by search) |
| Probes named in the brief (`/sitenew/`, `/newwebsite/`, `/testimonials-v/`) | Fetched directly | 3 |
| prlog.ru third-party snapshot of the old homepage | Old non-pretty links (`?page_id=`, `?p=`, `?service=`, `?portfolio=`) | 24 query-string URLs (Appendix A) |

The table below lists **70 unique legacy paths**, plus the 24 query-string URLs in Appendix A.

**How live status was checked:** each path was fetched with `web_fetch` and `force_fresh: true`, and some were also fetched through r.jina.ai. Without `force_fresh` the fetch tool returns stale cached copies of the old WordPress pages, so cached results were not used. The fetch tool follows redirects and still reports the URL that was requested, so **it cannot tell a 301 apart from a 200 alias**. Status codes:

- `404`: verified Not Found on 2026-10-19.
- `200*`: the old URL returns the **new** page's content. This is either an existing 301 or WordPress serving the new page at the old slug. Confirm with `curl -sI`. If there is no `Location:` header, add the 301.
- `200!`: the old URL returns the **wrong or duplicate** content and needs fixing.
- `n/v`: not individually verified because of fetch-tool errors or time. These are expected to be 404 because every sibling URL in the same group was 404.

### Status counts (70 paths)

| Status | Count |
|---|---|
| 404 (verified) | 42 |
| 200* (serves the matching new content at the old URL; confirm 301) | 5 |
| 200! (wrong or duplicate content) | 2 |
| 301 observed | 0 (the fetch tool cannot see hops; see 200*) |
| n/v (expected 404) | 21 |

### Old phone numbers

No live legacy URL shows **+254 728135246**. Every old URL is either 404 or serves new templates that show only +254 715 754 758. The old WordPress pages (search-index copies and the 2021 Wayback snapshot) showed **(+254) 715754758**, which is current, and the landline **+254 020 2572752**. That landline also appears on Allen & Heath's distributor listing (`+254 20 2572752/3`). Treat it as an off-site citation to correct; it is not a redirect issue. The 2021 snapshot shows the old address as "Mpaka Road, Mpaka Plaza Westlands Nairobi", which is still consistent.

## 2. Redirect table

Priority: **H** = indexed page with real traffic or link value, or wrong content live now. **M** = topical content with a clear match. **L** = archives, news and thin pages.

| # | Old path | Source | Current status | New target | Reason | Priority | Implementation |
|---|---|---|---|---|---|---|---|
| 1 | /our-services/ | known, search, wayback | 404 | /solutions/ | Old services hub; /solutions/ is the new hub | H | implemented `d2e7337` |
| 2 | /audio-solutions/ | known, search | 200* (Professional Audio content) | /solutions/professional-audio/ | Same topic; make the 301 explicit so there is one canonical URL | H | implemented `d2e7337` |
| 3 | /acoustic-solutions/ | known, search | 200* (Acoustics content) | /solutions/acoustics/ | Same topic | H | implemented `d2e7337` |
| 4 | /design-and-consulting/ | known | 404 | /solutions/consultation-design/ | Same service | H | implemented `d2e7337` |
| 5 | /shure-microphones/ | known | 404 | /brands/shure/ | Brand page | H | implemented `d2e7337` |
| 6 | /audio-products/ | known, search | 404 | /brands/ | Old product landing; products are not showcased | M | implemented `d2e7337` |
| 7 | /service/ | search | 200! serves the video "Service Maintenance for Broadcast mixers" | /solutions/ | Old services archive. WordPress is guessing a video single, so the wrong page is live | H | implemented `d2e7337` |
| 8 | /service/intergration/ | search | 404 | /service/integration/ | Misspelt old slug | H | implemented `d2e7337` |
| 9 | /service/trainings/ | search | 404 | /solutions/support-training/ | Old SynAudCon training service | M | implemented `d2e7337` |
| 10 | /the-team/ | search | 404 | /about/ | Company or people page | M | implemented `d2e7337` |
| 11 | /video/ | search | 404 | /videos/ | Same video library | M | implemented `d2e7337` |
| 12 | /multimedia/ | search | 404 | /projects/ | Old blog listing (CITAM, Absen posts) | L | implemented `d2e7337` |
| 13 | /dj/ | search | 404 | /brands/ | DJ product landing (Reloop); no matching brand | L | implemented `d2e7337` |
| 14 | /blog-carousel/ | search | 404 | /projects/ | Theme blog listing | L | implemented `d2e7337` |
| 15 | /absen-display-products/ | search | 404 | /solutions/lighting-led-screens/ | LED screens topic; Absen is not a current brand | M | implemented `d2e7337` |
| 16 | /sitenew/ | brief probe | 200! duplicate of homepage | / | Staging duplicate of the homepage that is indexable | H | implemented `d2e7337` |
| 17 | /newwebsite/ | brief probe | n/v | / | Staging slug | L | implemented `d2e7337` |
| 18 | /testimonials-v/ | brief probe | 404 | /testimonials/ | Old testimonials variant | L | implemented `d2e7337` |
| 19 | /acoustics-treatment-at-p-c-e-a-in-chuka-town/ | known, search | 404 | /solutions/church-worship-sound-systems/ | Church acoustic case study. A different venue from PCEA Kahawa, so it does not go to a project page. **FLAGGED** | H | implemented `d2e7337` |
| 20 | /all-saints-cathedral-trinity-center-project/ | known, search | 404 | /projects/all-saints-cathedral/ | Same venue. **FLAGGED** (merge content) | H | implemented `d2e7337` |
| 21 | /yu-mwaminifu-concert-by-james-kahero/ | known, search | 404 | /projects/sarit-expo-centre/ | Concert held at Sarit Expo Centre (same venue) | M | implemented `d2e7337` |
| 22 | /allen-heath-empowers-a-larger-vision/ | known, search | 404 | /brands/allen-heath/ | Allen & Heath brand story (Calvary Chapel) | M | implemented `d2e7337` |
| 23 | /sound-creations-ltd-audio-visual-integration-at-citam-buruburu/ | search | 200* (CITAM project) | /projects/citam-buruburu/ | Same project | H | implemented `d2e7337` |
| 24 | /upgrading-a-church-audio-visual-system/ | search | 200* (church solution) | /solutions/church-worship-sound-systems/ | Church AV guide. **FLAGGED** | M | implemented `d2e7337` |
| 25 | /building-worship-center-for-quality-sound-acoustics/ | search | 200* (church solution) | /solutions/church-worship-sound-systems/ | Worship-centre design article | M | implemented `d2e7337` |
| 26 | /why-your-church-should-buy-a-led-screen-and-how-to-choose-the-right-one/ | search | 404 | /solutions/lighting-led-screens/ | LED screen buyer guide. **FLAGGED** | M | implemented `d2e7337` |
| 27 | /dbtechnologies-new-three-way-line-array/ | search | 404 | /brands/db-technologies/ | dB Technologies VIO L212 news | M | implemented `d2e7337` |
| 28 | /the-it-professionals-guide-to-great-corporate-sound/ | search | 404 | /solutions/professional-audio/ | Corporate and conferencing sound | L | implemented `d2e7337` |
| 29 | /peripheral-vision-appointed-distributor-for-absen-in-sa-for-professional-av/ | search | 404 | /solutions/lighting-led-screens/ | Third-party LED news | L | implemented `d2e7337` |
| 30 | /parise-joins-chauvet-as-emea-bdm/ | search | 404 | /solutions/lighting-led-screens/ | Chauvet lighting news | L | implemented `d2e7337` |
| 31 | /chauvetdj-gigbar-move/ | search | 404 | /solutions/lighting-led-screens/ | Lighting product news | L | implemented `d2e7337` |
| 32 | /kigali-up-2018/ | search | 404 | /solutions/professional-audio/ | Live-event sound (Rwanda). See flagged item 5 | L | implemented `d2e7337` |
| 33 | /korg-will-provide-ikaossilator-for-ios/ | search | 404 | /brands/ | Off-brand app news | L | implemented `d2e7337` |
| 34 | /dj-angelo-launches-reloop-dj-brand/ | search | 404 | /brands/ | Reloop launch news; no matching brand | L | implemented `d2e7337` |
| 35 | /many-types-of-construction-equipment-are-designed/ | search | 404 | 410 | Theme lorem-ipsum demo post ("Blackpool polices hunt...") | L | implemented `d2e7337` |
| 36 | /reasons-to-explan-fast-business-builder/ | search | 404 | 410 | Theme lorem-ipsum demo post | L | implemented `d2e7337` |
| 37 | /2020/ | search | 404 | /projects/ | Date archive | L | implemented `d2e7337` |
| 38 | /2021/ | search | 404 | /projects/ | Date archive | L | implemented `d2e7337` |
| 39 | /2022/ | search | n/v | /projects/ | Date archive | L | implemented `d2e7337` |
| 40 | /2022/01/ | search | n/v | /projects/ | Date archive | L | implemented `d2e7337` |
| 41 | /2022/03/ | search | n/v | /projects/ | Date archive | L | implemented `d2e7337` |
| 42 | /2022/06/ | search | n/v | /projects/ | Date archive | L | implemented `d2e7337` |
| 43 | /2022/09/ | search | n/v | /projects/ | Date archive | L | implemented `d2e7337` |
| 44 | /2025/ | search | n/v | /projects/ | Date archive (CITAM post) | L | implemented `d2e7337` |
| 45 | /author/moses/ | search | 404 | /about/ | Author archive | L | implemented `d2e7337` as **410** (not /about/; see 4) |
| 46 | /author/moses/page/2/ | search | n/v | /about/ | Author archive page 2 | L | implemented `d2e7337` as **410** (not /about/; see 4) |
| 47 | /category/multimedia/ | search | 404 | /projects/ | Blog category | L | implemented `d2e7337` |
| 48 | /category/projects/ | search | 404 | /projects/ | Same topic | M | implemented `d2e7337` |
| 49 | /category/business-strategy/ | search | 404 | /solutions/ | Blog category | L | implemented `d2e7337` |
| 50 | /category/video/ | search | 404 | /videos/ | Same topic | L | implemented `d2e7337` |
| 51 | /tag/tower/ | search | 404 | /projects/ | Theme demo tag | L | implemented `d2e7337` |
| 52 | /product-category/uncategorized/ | search | n/v | /brands/behringer/ | Every listed item is Behringer | M | implemented `d2e7337` |
| 53 | /product-category/audio/ | search | 404 | /brands/ | Mixed-brand audio catalogue | M | implemented `d2e7337` |
| 54 | /product-category/audio/page/2/ | search | n/v | /brands/ | Mixed brands (Shure, Leem, Soundking) | L | implemented `d2e7337` |
| 55 | /product-category/audio/page/3/ | search | n/v | /brands/ | Studiomaster; no brand page | L | implemented `d2e7337` |
| 56 | /product-category/musical-instruments/ | search | n/v | /brands/ | Ibanez/Korg/Tama; no brand pages | L | implemented `d2e7337` |
| 57 | /product-category/musical-instruments/page/2/ | search | n/v | /brands/ | As above | L | implemented `d2e7337` |
| 58 | /product-category/musical-instruments/page/3/ | search | n/v | /brands/ | As above | L | implemented `d2e7337` |
| 59 | /product-category/video/ | search | 404 | /brands/ | AVer/NEC cameras and projectors; no brand pages | L | implemented `d2e7337` |
| 60 | /product-category/axes-picks/ | search | n/v | 410 | Theme demo category (clothing items) | L | implemented `d2e7337` |
| 61 | /product-category/spirit-levels/ | search | n/v | 410 | Theme demo category | L | implemented `d2e7337` |
| 62 | /product-category/surgery/ | search | n/v | 410 | Theme demo category | L | implemented `d2e7337` |
| 63 | /product/behringer-u-phoria-umc202hd-usb-audio-interface/ | known, search | 404 | /brands/behringer/ | Behringer product | M | implemented `d2e7337` |
| 64 | /product/behringer-nekkst-k10s-10-inch-powered-studio-subwoofer/ | search | 404 | /brands/behringer/ | Behringer product | M | implemented `d2e7337` |
| 65 | /product/leem-smp1020u-powered-mixing-console/ | known, search | 404 | /brands/ | Leem; no brand page | L | implemented `d2e7337` |
| 66 | /product/focusrite-scarlett-2i2-3rd-gen-usb-audio-interface/ | search | 404 | /brands/ | Focusrite; no brand page | L | implemented `d2e7337` |
| 67 | /product/m-audio-keystation-49-mk3/ | search | n/v | /brands/ | M-Audio; no brand page | L | implemented `d2e7337` |
| 68 | /product/ibanez-btb20th5-brl-standard-blue-reef-gradation/ | search | n/v | /brands/ | Ibanez; no brand page | L | implemented `d2e7337` |
| 69 | /product/irig-stream-ultracompact-2x2-audio-interface-for-computers-smartphones-and-tablets/ | search | n/v | /brands/ | IK Multimedia; no brand page | L | implemented `d2e7337` |
| 70 | /product/irig-hd-2-guitar-interface-for-ios-mac-and-pc/ | search | n/v | /brands/ | IK Multimedia; no brand page | L | implemented `d2e7337` |

### Pattern rules (catch-alls for URLs the CDX run may add)

Apply these after the exact map, in this order:

1. `/product/behringer-*` -> /brands/behringer/
2. `/product/(db-technologies|dbtechnologies|db-)*` -> /brands/db-technologies/
3. `/product/shure-*` -> /brands/shure/
4. `/product/(allen-heath|allen-and-heath)*` -> /brands/allen-heath/
5. `/product/midas-*` -> /brands/midas/
6. `/product/(bose)*` -> /brands/bose-professional/
7. `/product/sommer*` -> /brands/sommer-cable/
8. `/product/*`, `/product-category/*`, `/shop/*`, `/cart/*` and `/checkout/*` -> /brands/ (never /products/)
9. `/YYYY/`, `/YYYY/MM/`, `/YYYY/MM/DD/` -> /projects/
10. `/category/*`, `/tag/*` -> /projects/ (see exceptions in the exact map)
11. `/author/*` -> /about/
12. `*/page/N/` -> the target of the same path without `/page/N/`
13. `/portfolio/*` -> /projects/ (unverified; these are the pretty-permalink form of `?portfolio=`)

## 3. Flagged content (should become new pages, not just redirects)

1. **PCEA Chuka acoustic case study** (`/acoustics-treatment-at-p-c-e-a-in-chuka-town/`, May 2020). Unique, measured data: a T-shaped sanctuary with terrazzo floor, stone walls and an exposed corrugated roof. RT60 was **3.77 s at 125 Hz** and **3.32 s at mid frequencies (500-1,000 Hz)** against a 1.22 s target. Sound Creations installed **740 m² of Rockfon Artic** suspended at least 200 mm below the existing ceiling, and measured RT60 afterwards at **1.1 s**. The article also mentions an SDA Lavington reference visit and a client quote. Recommendation: create `/projects/pcea-chuka/` (Rockfon brand, Acoustics and Church solutions). Interim target: /solutions/church-worship-sound-systems/. Once the page exists, change the redirect to /projects/pcea-chuka/.
2. **All Saints Cathedral Trinity Centre** (`/all-saints-cathedral-trinity-center-project/`). A 2,000 m² auditorium seating 1,400 plus a 600-seat balcony. The system used 12 dB T12, 10 Flexsys F8, 2 S30N, 2 S10 and 6 DVX DM15, with an Allen & Heath iLive T112 and IDR64, DVA Network zoning, Sommer, Shure and Samson. The current /projects/all-saints-cathedral/ page is thin. Recommendation: merge this detail into that project page. The redirect target stays the same.
3. **Yu Mwaminifu concert (SOW Kenya, Sarit Expo Centre, Dec 2021).** A live-recording concert with technical sponsorship. Candidate for a short project or event entry. Interim target: /projects/sarit-expo-centre/.
4. **"Upgrading a Church Audio-Visual System"** (Vincent Kasule) and **"Why Your Church Should Buy a LED Screen"**. Evergreen buyer-guide content that fits the AEO/FAQ plan. Consider rewriting both as original guides; do not republish the old text verbatim. Interim targets: the church solution page and /solutions/lighting-led-screens/.
5. **Kigali UP 2018** (dB T8/T12, KS10, S30, Shure Axient AD4Q, Yamaha CL5). This is a Rwanda project and fits soundcreationsltd.rw better. Interim target: /solutions/professional-audio/. A cross-domain 301 is possible if the .rw site publishes a matching page.
6. **`/service/` currently serves a video single** and **`/sitenew/` serves a duplicate homepage at 200**. These are live correctness bugs. Fix them first.

## 4. Implementation notes

**Status (19 Oct 2026): implemented in `d2e7337`.** How the code follows these notes:

- `sc_core_legacy_redirects()` runs on `template_redirect` priority 1, before `sc_core_redirect_legacy_paths()` (9) and `redirect_canonical()` (10). WordPress's 404 slug guess is switched off for every mapped path (`do_redirect_guess_404_permalink`).
- Exact rows fire even when WordPress resolved some content (fixes `/service/` and `/sitenew/`), except when the request is itself a current destination in this map, or resolves to a live Core post or `sc_*` taxonomy term at its own address (so a real `/product-category/<term>/` is never hijacked). Pattern rules fire only on a 404.
- The incoming query string is preserved; targets are single-hop and never `/products/`.
- 410 rows: `set_404()`, `status_header( 410 )`, `nocache_headers()`, then the theme's normal 404 template.
- `/product/<slug>` uses the brand-prefix rules above (plus `fane` and `rockfon`) and only targets a brand page that is published, else `/brands/`.
- **Deviation:** rows 45-46 and the `/author/*` pattern answer **410**, not `/about/`. `security.php` already 410s every author archive whose user exists (username-enumeration guard); redirecting only the unknown ones would make the response reveal which usernames are real.
- Appendix A: `?service=` and `?portfolio=` rows are implemented, only when the request resolves to the front page, and the legacy parameter is dropped. `?p=`, `?page_id=` and `?paged=` are deliberately left to WordPress.
- Published posts/pages whose own address is a mapped path are dropped from the core sitemap and Rank Math sitemap entries.
- The map is filterable (`sc_core_legacy_redirect_map`), e.g. to retarget row 19 to `/projects/pcea-chuka/` once that page exists.
- `php -l` was not run (no PHP in the agent sandbox). Lint before or right after upload.

Original notes:

- **Normalisation:** match on the lowercased path; ignore a trailing slash (`/our-services` and `/our-services/` both match); drop query strings except for Appendix A; redirect `http://` and `www.` to `https://soundcreationsltd.com` first, as one hop. `https://www.soundcreationsltd.com/our-services/` currently returns 404, so check whether www 301s to the apex. Targets always end with a slash.
- Use **301** for everything except the `410` rows. Make each redirect a single hop: no target may itself redirect, so never use /products/, which 301s to /brands/.
- Run the exact map before the pattern rules, and run both before WordPress's `redirect_guess_404_permalink`. That guess is what sends `/service/` to a video page.
- After deployment, run `curl -sI` against every old path and expect `301` plus the listed `Location`. Then re-run the Wayback CDX query and append any new paths.

## 5. Machine-readable map

Paths only, lowercase, trailing slash normalised (match with or without it). `410` means respond 410 Gone.

```
/our-services/ => /solutions/
/audio-solutions/ => /solutions/professional-audio/
/acoustic-solutions/ => /solutions/acoustics/
/design-and-consulting/ => /solutions/consultation-design/
/shure-microphones/ => /brands/shure/
/audio-products/ => /brands/
/service/ => /solutions/
/service/intergration/ => /service/integration/
/service/trainings/ => /solutions/support-training/
/the-team/ => /about/
/video/ => /videos/
/multimedia/ => /projects/
/dj/ => /brands/
/blog-carousel/ => /projects/
/absen-display-products/ => /solutions/lighting-led-screens/
/sitenew/ => /
/newwebsite/ => /
/testimonials-v/ => /testimonials/
/acoustics-treatment-at-p-c-e-a-in-chuka-town/ => /solutions/church-worship-sound-systems/
/all-saints-cathedral-trinity-center-project/ => /projects/all-saints-cathedral/
/yu-mwaminifu-concert-by-james-kahero/ => /projects/sarit-expo-centre/
/allen-heath-empowers-a-larger-vision/ => /brands/allen-heath/
/sound-creations-ltd-audio-visual-integration-at-citam-buruburu/ => /projects/citam-buruburu/
/upgrading-a-church-audio-visual-system/ => /solutions/church-worship-sound-systems/
/building-worship-center-for-quality-sound-acoustics/ => /solutions/church-worship-sound-systems/
/why-your-church-should-buy-a-led-screen-and-how-to-choose-the-right-one/ => /solutions/lighting-led-screens/
/dbtechnologies-new-three-way-line-array/ => /brands/db-technologies/
/the-it-professionals-guide-to-great-corporate-sound/ => /solutions/professional-audio/
/peripheral-vision-appointed-distributor-for-absen-in-sa-for-professional-av/ => /solutions/lighting-led-screens/
/parise-joins-chauvet-as-emea-bdm/ => /solutions/lighting-led-screens/
/chauvetdj-gigbar-move/ => /solutions/lighting-led-screens/
/kigali-up-2018/ => /solutions/professional-audio/
/korg-will-provide-ikaossilator-for-ios/ => /brands/
/dj-angelo-launches-reloop-dj-brand/ => /brands/
/many-types-of-construction-equipment-are-designed/ => 410
/reasons-to-explan-fast-business-builder/ => 410
/2020/ => /projects/
/2021/ => /projects/
/2022/ => /projects/
/2022/01/ => /projects/
/2022/03/ => /projects/
/2022/06/ => /projects/
/2022/09/ => /projects/
/2025/ => /projects/
/author/moses/ => /about/
/author/moses/page/2/ => /about/
/category/multimedia/ => /projects/
/category/projects/ => /projects/
/category/business-strategy/ => /solutions/
/category/video/ => /videos/
/tag/tower/ => /projects/
/product-category/uncategorized/ => /brands/behringer/
/product-category/audio/ => /brands/
/product-category/audio/page/2/ => /brands/
/product-category/audio/page/3/ => /brands/
/product-category/musical-instruments/ => /brands/
/product-category/musical-instruments/page/2/ => /brands/
/product-category/musical-instruments/page/3/ => /brands/
/product-category/video/ => /brands/
/product-category/axes-picks/ => 410
/product-category/spirit-levels/ => 410
/product-category/surgery/ => 410
/product/behringer-u-phoria-umc202hd-usb-audio-interface/ => /brands/behringer/
/product/behringer-nekkst-k10s-10-inch-powered-studio-subwoofer/ => /brands/behringer/
/product/leem-smp1020u-powered-mixing-console/ => /brands/
/product/focusrite-scarlett-2i2-3rd-gen-usb-audio-interface/ => /brands/
/product/m-audio-keystation-49-mk3/ => /brands/
/product/ibanez-btb20th5-brl-standard-blue-reef-gradation/ => /brands/
/product/irig-stream-ultracompact-2x2-audio-interface-for-computers-smartphones-and-tablets/ => /brands/
/product/irig-hd-2-guitar-interface-for-ios-mac-and-pc/ => /brands/
```

## Appendix A: query-string legacy URLs (old non-pretty permalinks)

Source: prlog.ru snapshot of the old homepage links. Live status was not verified. WordPress resolves `?p=` and `?page_id=` itself only if those post IDs still exist. These are low priority; implement them only if Search Console reports them.

```
/?page_id=76 => /brands/
/?page_id=915 => /solutions/
/?page_id=1010 => /solutions/
/?page_id=2372 => /projects/
/?page_id=256 => /contact/
/?service=residential-design => /solutions/
/?service=hospitally-design => /solutions/hospitality-commercial-audio/
/?service=office-design => /solutions/system-integration/
/?service=commercial-design => /solutions/hospitality-commercial-audio/
/?portfolio=microphone => /brands/db-technologies/
/?portfolio=apartment-renovation => /brands/shure/
/?portfolio=behringer-x32 => /brands/allen-heath/
/?portfolio=shure-headphones => /brands/shure/
/?portfolio=behringer-klark => /brands/
/?portfolio=tiange-sound-proof-acoustic => /solutions/acoustic-panels-ceilings/
/?portfolio=dlp-projector => /solutions/lighting-led-screens/
/?portfolio=plm-series => /brands/
/?portfolio=nec-projector => /solutions/lighting-led-screens/
/?portfolio=behringer-mixer => /brands/behringer/
/?portfolio=mdas => /brands/midas/
/?portfolio=restaurant-in-texas => /brands/db-technologies/
/?portfolio=avantis-mixer => /brands/allen-heath/
/?portfolio=shure-microphones => /brands/shure/
/?portfolio=tama-drumsets => /brands/
/?portfolio=vimeo-video => /videos/
/?paged=2 => /projects/
/?p=2510 => /solutions/professional-audio/
/?p=2342 => /solutions/professional-audio/
/?p=2549 => /projects/sarit-expo-centre/
/?p=2296 => /solutions/hospitality-commercial-audio/
/?p=2571 => /solutions/education-auditorium-sound-systems/
```

Notes on the `?portfolio=` labels: the old link text did not match the slugs. For example, `microphone` was labelled "dB Technologies VIO", `apartment-renovation` was "SHURE MICROPHONES", `behringer-x32` was "Allen & Heath" and `restaurant-in-texas` was "SPEAKERS (DB TECHNOLOGIES)". Targets follow the link text. `?p=2510` is "Chris Martin Concert - BIGDEAL", `?p=2342` is "Make room 2019", `?p=2549` is "Sarit Expo Hall", `?p=2296` is "The Wine Shop" and `?p=2571` is "Signature Auditorium".
