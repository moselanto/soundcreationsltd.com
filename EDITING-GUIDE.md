# Sound Creations Website — Editing Guide

**Where to change what.** Updated 25 September 2026.

This is the map of the site for non-developers. Almost everything you will want
to change is in one of four places:

| Place | What lives there |
| --- | --- |
| **Sound Creations → Settings** | Text, contact details, footer, homepage/About copy, images, profile PDF |
| **Appearance → Customize → Site Identity** | The logo |
| **Appearance → Menus** | The navigation menu |
| **The content menus** (Projects, Brands, Solutions, Services, Videos) | Real entries that feed the grids and archive pages |

**After saving, always hard-refresh the live page** (Ctrl+F5 / Cmd+Shift+R, or a
private tab). The site caches aggressively for speed.

---

## 1. The logo (header and footer)

**Appearance → Customize → Site Identity → Logo → Select logo → Publish.**

One upload drives both header and footer.

- Upload a **light/white** version — the site is dark, so a dark logo will not show.
- With no logo set, the site falls back to the "SOUND CREATIONS" text wordmark.

## 2. Top utility bar (phone, email, hours, region, social)

**Sound Creations → Settings → Business details**

- Phone (display) and Phone (tel: digits — clickable number, digits only)
- Email
- Regional presence line (Kenya • Rwanda • DR Congo • UAE)
- Hours — weekdays / Saturday / Sunday
- Facebook, X, LinkedIn, YouTube, Instagram URLs, and WhatsApp number

**Each social icon only appears if its URL is filled in.** Leave a field blank to
hide that icon. The WhatsApp number also powers the floating "Chat with us"
button and the mobile action bar; the greeting message has its own field.

## 3. Navigation menu

**Appearance → Menus** — build a menu and assign it to the **Primary** location.
Until you do, a sensible default menu shows automatically.

## 4. Homepage

### Hero (big video area)
- **Video:** Business details → "Hero background video URL (MP4)"
- **Poster image:** Homepage images → "Hero: poster image"
- **Eyebrow, headline, intro:** Homepage content → Hero fields
- **The two buttons:** Homepage content → button label and link fields

### Lower sections
**Sound Creations → Settings → Homepage content**

- "What we do" eyebrow, heading, intro
- Process steps — one per line: `Title | Description`
- Solutions eyebrow and heading; partners strip label
- Featured projects eyebrow and heading
- The four proof stats (number + label each)
- Closing call-to-action heading and text

### Homepage images
**Homepage images** — the four "What we do" photos, three Solutions photos, and
the closing CTA background.

### Not in Settings
The **Solutions cards** and **Featured Projects** grids pull from real entries in
the Solutions and Projects menus. Add, edit or reorder those and the homepage
updates automatically.

## 5. About page

**Sound Creations → Settings → About page content**

- Hero eyebrow, headline, intro paragraph, hero photo
- "Our Work Process" eyebrow and steps — `Title | Description | /link-path`
- "Our Brands" eyebrow and heading

### Company Profile download
**Settings → Profiles** — profiles eyebrow, Company Profile PDF URL, description.

> **Changed September 2026:** the Acoustic Profile card was removed. Company
> Profile is now the only download and fills the full width of the row. Its
> settings fields were removed from the admin at the same time.

> If the card reads "PDF available soon", the Company Profile PDF URL is empty.

## 6. FANE Africa page

**Sound Creations → Settings** (FANE fields)

- Headline, intro paragraph, hero product image
- Heritage heading (timeline text itself is in the theme — see section 13)
- "The FANE difference" heading and body
- Dealer CTA heading and text
- Catalogue PDF URL — blank hides the "Download Catalogue" button
- FANE social links (Facebook, Instagram, YouTube, TikTok, X, LinkedIn,
  WhatsApp). Only filled fields appear; there is no fallback to the
  company-wide social accounts.

> **Changed September 2026:** the "Engineered in the UK. Trusted worldwide."
> eyebrow was removed; the "Become a FANE Dealer" band moved to sit directly
> under the hero; the "The FANE component range" product carousel was removed
> entirely. Page order is now: Hero → Become a FANE Dealer → Heritage →
> The FANE difference → Follow FANE.

## 7. Contact and Consultation pages

**Sound Creations → Settings** — contact eyebrow, headline, intro, offices
heading, CTA heading and text, and the consultation page headline.

Address, phone, email and opening hours all come from **Business details** —
change them once there and they update everywhere.

## 8. Footer

**Sound Creations → Settings → Footer.** Three columns:

| Column | Where to edit |
| --- | --- |
| **1. Brand** | Logo = Site Identity. Slogan = Business details → "Slogan (footer)". Social icons = Business details URLs. |
| **2. Open Hours** | Footer → open-hours heading, and open hours (one line per row) |
| **3. Contact** | Footer → address (one line per row). Phone and email from Business details. |

> **Changed September 2026:** the **Explore** and **Solutions** link columns were
> removed, and **Open Hours** was promoted out of Contact into its own column.
> Four columns became three, rebalanced to match.
>
> The saved Explore and Solutions links were NOT deleted — the settings remain
> registered, so those columns can be reinstated with their content intact.

> **Slogan:** set to stay on one line on desktop. Making it much longer than
> "If it sounds good, it's Sound Creations" may cause overflow rather than
> wrapping; the sizing would need adjusting to match.

## 9. Legal links (footer bottom bar)

Two WordPress Pages, with these exact slugs:

- `privacy-policy` → Privacy Policy
- `terms` → Terms & Conditions

> **Changed September 2026:** the **Warranty** link was removed.

## 10. Enquiry forms and leads

### Where enquiries go
**Enquiries** in the wp-admin menu. Every submission is stored here **before**
any email is sent, so a mail failure cannot lose a lead. Administrators only,
because they hold customer personal data (name, email, phone, IP). Enquiries are
deleted automatically after 24 months.

### Where notification emails go
**Sound Creations → Enquiry Routing** — a recipient per form type, or just the
Default. If Default is blank it falls back to the central email in Business
details. Staff can hit Reply; the enquirer's address is the reply-to.

Seven forms: Contact/General, Consultation, Quote, Product Enquiry, Dealer
Application, FANE Partnership, Technical Support.

### Changing what a form asks
Form fields live in the theme code, not Settings. See section 13.

## 11. Content entries

| Menu | Appears at | Key fields |
| --- | --- | --- |
| **Projects** | /projects/ | Client/venue, Location, Year, Summary, Challenge, Solution, Technology, Result, Scope, Brands used, Gallery |
| **Brands** | /brands/ (titled "Products") | Country of origin, Category, Tagline, Brand website |
| **Products** | individual pages only | Brand, Model/SKU, Availability, Datasheet URL, Specifications |
| **Solutions** | /solutions/ | Summary, What is included, Key outcome |
| **Services** | /service/{name}/ | Standard page content |
| **Videos** | /videos/ | YouTube video URL, Download file URL |
| **FANE Resources** | /fane-resources/ | FANE-specific technical material |
| **Case Studies** | /case-studies/ | Long-form write-ups |

**Project formatting:** blank line between paragraphs in Challenge / Solution /
Result; one item per line in Technology renders as a checklist; gallery
selection order is display order.

**Brands** have a manual display order — drag them into place.

**Categorising:** Product Category, Brand, Industry, Application, Project Type,
Location, Solution Area. These power the filtered views.

## 12. Search engine listings (SEO)

Meta descriptions, titles, social share previews and structured data are
generated automatically from your content — there is no SEO plugin to configure.
The most useful thing you can do is fill in the **one-line summary** and
**excerpt** fields, since those feed the descriptions Google shows.

## 13. Not editable from the admin (developer changes)

- Colours, fonts, spacing, layout
- Section order on a page, or removing a section
- FANE heritage timeline text (1958, 1960s–70s, …)
- FANE difference labels (Core, Voice Coil, Basket, Magnet System, Complete Driver)
- The regional presence map and its four locations
- Which questions each enquiry form asks, and the dropdown options
- Anything structural

## 14. Changes made in September 2026

| Change | Effect |
| --- | --- |
| All page headings set to 30px | Site-wide |
| Acoustic Profile removed from About | Company Profile is the only download |
| FANE hero eyebrow removed | "Engineered in the UK. Trusted worldwide." gone |
| FANE dealer CTA moved | Now directly below the hero |
| FANE product carousel removed | "Explore FANE Products" → products page; "Discover Our Technology" → FANE website |
| FANE dealer band restyled | Was a solid red block, now blends with the page |
| Footer Explore + Solutions columns removed | Footer is three columns |
| Open Hours promoted to its own footer column | Moved out of Contact |
| Warranty link removed | Privacy Policy and Terms remain |
| Footer rebalanced, slogan enlarged | Slogan reads on one line |

## Quick troubleshooting

**Changed something and nothing happened.** Hard-refresh or use a private tab.
If it persists, the setting may be a different field than expected.

**A page shows 404.** Go to **Settings → Permalinks** and click Save (change
nothing). That rebuilds the URL rules.

**An icon or button disappeared.** Most hide themselves when their field is
blank. Check the matching field in Settings.
