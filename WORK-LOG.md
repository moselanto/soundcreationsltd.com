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
