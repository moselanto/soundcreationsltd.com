# Product Requirements — Sound Creations Ltd Website

**Status:** live at <https://soundcreationsltd.com/newwebsite/>
**Owner:** Sound Creations Ltd
**Scope:** the corporate website, its content model and its lead-capture system.

This document records what the site is for, who it serves, what it must do, and
which decisions were made deliberately. It describes the product as built; where
something is not yet built it is called out as such.

---

## 1. Context

Sound Creations Ltd is a B2B professional audio, acoustics, distribution and
integration company. It operates from a head office and technical base in
Nairobi (Mpaka Plaza, Mpaka Road, Westlands), a branch in Kigali, distribution
and project delivery across DR Congo, and a Middle East hub in Dubai.

The business has four revenue pillars, which are also the site's "What we do"
sections:

1. **Consultancy** — acoustic and system design advice.
2. **Distribution & Dealership** — authorised distribution of represented brands.
3. **Integration** — installing, commissioning and calibrating systems.
4. **After-Sale Services** — support, maintenance, spares, warranty, training.

A distinct fifth thread runs alongside these: the **FANE** relationship, which
targets OEM loudspeaker manufacturers and cabinet builders and has its own
landing page, resource type and enquiry form.

## 2. The problem

Buyers in this market — integrators, consultants, churches, hospitality groups,
corporates, government institutions, rental companies and OEMs — do not buy from
a catalogue. They buy on evidence of delivery and on the credibility of the
brands a distributor is trusted to represent.

The website therefore has to do three things a product listing cannot:

1. **Prove competence** through completed installations with real technical detail.
2. **Establish authority** through the brands represented and the regional footprint.
3. **Convert a qualified visitor into a routed, complete enquiry** — not a
   two-line "contact us" message that takes three emails to make actionable.

## 3. Audiences and their jobs

| Audience | What they came to do | What the site gives them |
| --- | --- | --- |
| Integrators & consultants | Check credibility, find spec detail | Projects with challenge/solution/technology/result, product specs, datasheets |
| End clients (worship, hospitality, corporate, education, government) | Find someone who has done this before, in their sector | Solutions, projects filtered by industry and project type, consultation form |
| Prospective dealers | Understand the distribution offer and apply | Brands, Dealer application form with company-profile upload |
| OEM / cabinet manufacturers | Evaluate the FANE relationship | FANE landing page, FANE resources, FANE partnership form |
| Existing customers | Get support | Technical Support form with issue and support-type routing |
| Editors at Sound Creations | Update copy and publish work without a developer | Admin settings screen, structured content types with guided fields |

## 4. Goals

- **Primary:** generate qualified, complete, correctly routed B2B enquiries.
- Establish Sound Creations as the regional authority in professional audio and
  acoustics across East Africa and the Middle East.
- Present completed projects as first-class technical content, not thumbnails.
- Let non-technical staff maintain nearly all copy and content unaided.
- Rank for solution-, sector- and geography-led search, without an SEO plugin.
- Load fast on the connections and devices the region actually uses.

### Non-goals

- **No e-commerce.** Pricing is quotation-based; a cart would misrepresent how
  the business sells. No WooCommerce.
- **No page builder.** No Elementor. Templates are hand-built for performance,
  control and a smaller attack surface.
- **No public community features.** Comments are removed entirely site-wide.
- **No user accounts** for visitors. The only logins are staff.

## 5. Functional requirements

### 5.1 Content

- **R1.1** Publish Projects with client/venue, location, year, a one-line
  summary, four narrative sections (Challenge, Solution, Technology, Result),
  a scope-of-work list, brands used and a photo gallery.
- **R1.2** Publish Brands with origin, category, tagline and brand website, in a
  manually controlled display order.
- **R1.3** Publish Products with brand, model/SKU, availability, key
  specifications and a datasheet link.
- **R1.4** Publish Solutions with a summary, what-is-included list and key outcome.
- **R1.5** Publish the four Services as individual pages at `/service/{slug}/`.
- **R1.6** Publish Videos and downloadable technical resources, including
  YouTube links in watch, short-link or Shorts form.
- **R1.7** Publish FANE-specific resources separately from general resources.
- **R1.8** Classify content by product category, brand, industry, application,
  project type, location and solution area.
- **R1.9** Preserve existing URLs when content areas are renamed. `/products/`
  redirects to `/brands/`; `/resources/*` redirects to `/videos/*`.

### 5.2 Editability

- **R2.1** Contact details, opening hours, regional presence line, social links
  and WhatsApp details are editable in one admin screen and used everywhere.
- **R2.2** Homepage hero copy, CTA labels and destinations, process steps,
  section headings and eyebrows, proof statistics and all homepage imagery are
  editable without touching code.
- **R2.3** About page copy and statistics are editable in the same screen.
- **R2.4** Footer columns (about text, explore links, solutions links, address,
  opening hours) are editable as simple line-per-row text.
- **R2.5** A one-click Starter Setup and a guided setup wizard scaffold a new
  install, and a self-healing routine repairs pages and rewrite rules after a
  deploy without anyone re-running setup.

### 5.3 Enquiries

- **R3.1** Seven distinct forms, each asking for what that conversation actually
  needs: Consultation, Contact, Quote, Product Enquiry, Dealer Application,
  FANE Partnership, Technical Support.
- **R3.2** Every submission is stored in the database before any email is sent,
  so a mail failure never loses a lead.
- **R3.3** Every submission is emailed to a recipient chosen per form type, with
  a Reply-To set to the enquirer so staff can simply hit reply.
- **R3.4** Routing is configurable in the admin, with a sensible fallback chain.
- **R3.5** The Dealer form accepts an optional company profile (PDF/DOC/DOCX/
  image, 5 MB).
- **R3.6** Forms that collect consent must not submit without it.
- **R3.7** The visitor gets clear success and error feedback in place, anchored
  back to the form.
- **R3.8** Spam must not reach staff. A noisy queue trains people to ignore it,
  which is worse than no queue.
- **R3.9** Rejected spam is answered with a success response so bots do not retry.

### 5.4 Discovery

- **R4.1** Every page emits a meaningful meta description — generated per content
  type where no body copy exists, never falling back to a single site tagline
  across every listing page.
- **R4.2** Canonical URLs, Open Graph and Twitter card tags on all content.
- **R4.3** JSON-LD structured data describing the organisation and its content.
- **R4.4** SEO output lives in a plugin, so a theme change cannot silently
  destroy search visibility.

### 5.5 Presentation

- **R5.1** Dark-first design, with a visitor-selectable light theme persisted in
  local storage and applied before first paint.
- **R5.2** Responsive across phone, tablet and desktop.
- **R5.3** An interactive regional presence map covering Nairobi, Kigali, DR
  Congo and Dubai, with a text list that remains accurate independently of the
  graphic.
- **R5.4** A hero video with a poster image, preloaded so the poster is the LCP
  element rather than a late-arriving video frame.

## 6. Non-functional requirements

| Area | Requirement |
| --- | --- |
| Performance | Critical CSS inlined; fonts self-hosted and preloaded; scripts deferred; LCP image preloaded per template; same-site navigation prerendered via Speculation Rules |
| Security | See [`SECURITY-AUDIT.md`](SECURITY-AUDIT.md). Baseline security headers, login throttling, no user enumeration, no XML-RPC, no file editor, PII restricted to administrators |
| Privacy | Enquiry PII (name, email, phone, IP) auto-deleted after 24 months by default |
| Accessibility | Semantic HTML, labelled form fields, `aria-label` on map pins, keyboard-reachable list items |
| Compatibility | WordPress 6.4+, PHP 8.0+ |
| Maintainability | Business logic in plugins, presentation in the theme, child theme for overrides |
| Deployment | Runs in a subdirectory (`/newwebsite/`); no code may assume a root install |

## 7. Decisions and rationale

| Decision | Why |
| --- | --- |
| Custom theme, no page builder | Builders add weight, lock-in and attack surface for a site with a small, well-understood set of layouts |
| Content model in a plugin, not the theme | A re-theme must never destroy the content model, the settings or the SEO output |
| Own enquiry system instead of a form plugin | Needed per-type routing, private capability-restricted storage, sector-specific fields and layered anti-spam — and wanted no third-party plugin holding every lead |
| Store the lead, then mail it | Email is the unreliable step; storage is not |
| Spam answered with "success" | A bot that sees failure retries; one that sees success moves on |
| Additive spam scoring, not hard rules | One false positive should never be able to block a real enquiry alone |
| Own SEO instead of a plugin | Generated per-type descriptions grounded in the real business geography beat generic plugin defaults, at a fraction of the weight |
| Comments removed entirely | The site never uses them, and they are a permanent spam and moderation cost |
| Dark-first | Matches the pro-audio and live-production visual language the audience works in |
| 24-month PII retention | Longer than any live sales cycle, short enough that the site is not an indefinite PII store |

## 8. Success measures

- Volume and, more importantly, **completeness** of enquiries — fewer follow-up
  rounds needed before a quote can be prepared.
- Share of enquiries arriving through the specific form for their intent rather
  than the generic contact form.
- Spam reaching the staff inbox, as close to zero as possible.
- Organic visibility on solution, sector and geography queries.
- Core Web Vitals, particularly LCP on the homepage and About page.
- Editor self-sufficiency: content and copy changes shipped without a developer.

## 9. Open items

These are known and deliberate, not oversights:

- **Real billing / commercial tiers** are out of scope for this site.
- **Automated testing and CI** do not exist yet; nothing gates a bad deploy.
- **The Content-Security-Policy is narrow** — inline scripts and a third-party
  accelerator plugin block a strict `script-src`/`style-src` today.
- **`sc_product` is half-retired**: single product pages remain, the archive is
  redirected. The end state needs a decision.
- **Error monitoring** is not wired up; failures are not tracked durably.
