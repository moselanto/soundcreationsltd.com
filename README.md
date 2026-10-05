<div align="center">

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="soundcreations/assets/img/logo-white.png">
  <img src="soundcreations/assets/img/logo-color.webp" alt="Sound Creations Ltd" width="280">
</picture>

# Sound Creations Ltd

### Custom WordPress platform for [soundcreationsltd.com](https://soundcreationsltd.com/)

Professional audio, acoustics, lighting, distribution and AV integration across East Africa and the Middle East. Headquartered in Nairobi, with offices in Kigali, Kinshasa and Dubai.

![WordPress](https://img.shields.io/badge/WordPress-6.4%2B-21759B?logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php&logoColor=white)
![No page builder](https://img.shields.io/badge/Build-hand--coded%2C%20no%20page%20builder-111114)
![Schema](https://img.shields.io/badge/SEO-unified%20JSON--LD%20%40graph-4C2A85)
![Parent theme](https://img.shields.io/badge/Theme-v0.10.11-624489)
![Child theme](https://img.shields.io/badge/Child-v0.1.0-46305F)
![Core](https://img.shields.io/badge/SC%20Core-v0.5.25-BA0B0B)
![Enquiries](https://img.shields.io/badge/SC%20Enquiries-v0.2.0-BA0B0B)
![Security](https://img.shields.io/badge/Security-audited-2e7d32)
![License](https://img.shields.io/badge/License-GPLv2%2B-blue)
![Status](https://img.shields.io/badge/Status-Live-brightgreen)

[Live site](https://soundcreationsltd.com/) · [Solutions](https://soundcreationsltd.com/solutions/) · [Brands](https://soundcreationsltd.com/brands/) · [Projects](https://soundcreationsltd.com/projects/) · [FANE Africa](https://soundcreationsltd.com/fane/) · [Videos](https://soundcreationsltd.com/videos/) · [Request a consultation](https://soundcreationsltd.com/request-a-consultation/) · [Rwanda site](https://soundcreationsltd.rw/)

</div>

---

![Sound Creations Ltd homepage](docs/screenshots/home-desktop.jpg)

## Contents

- [Overview](#overview)
- [Screenshots](#screenshots)
- [What the site delivers](#what-the-site-delivers)
- [Architecture](#architecture)
- [Content model](#content-model)
- [Enquiry system](#enquiry-system)
- [SEO and structured data](#seo-and-structured-data)
- [Performance and security](#performance-and-security)
- [Project structure](#project-structure)
- [Requirements and installation](#requirements-and-installation)
- [Day-to-day editing](#day-to-day-editing)
- [Documentation](#documentation)
- [Group sites](#group-sites)
- [Business](#business)

## Overview

Sound Creations Ltd is a B2B professional audio, acoustics, distribution and integration company, founded in Nairobi in 1989 and incorporated as Sound Creations Ltd in 2004. It designs, supplies, installs and supports sound, lighting and acoustic systems for houses of worship, conference and exhibition centres, schools, government, hospitality and live events, and distributes leading global brands including **FANE**, **dB Technologies**, **Shure**, **Bose Professional** and **Allen &amp; Heath**.

This repository holds the **first-party WordPress code only**: one custom theme, one child theme and two custom plugins. WordPress core, third-party plugins, uploads and the database are not tracked here.

| Package | Folder | Version | Role |
| --- | --- | --- | --- |
| **Sound Creations** (parent theme) | [`soundcreations/`](soundcreations) | 0.10.11 | Dark-first, editorial, hand-built presentation layer: templates, design tokens, CSS, JS, loader, hardening |
| **Sound Creations Child** | [`soundcreations-child/`](soundcreations-child) | 0.1.0 | **Active theme.** Update-safe layer for site-specific CSS overrides |
| **Sound Creations Core** (plugin) | [`sound-creations-core/`](sound-creations-core) | 0.5.25 | Content types, taxonomies, editorial fields, central business-settings store, SEO and structured data, starter setup |
| **Sound Creations Enquiries** (plugin) | [`sound-creations-enquiries/`](sound-creations-enquiries) | 0.2.0 | Full B2B enquiry system: seven forms, validation, anti-spam, private lead storage, routing and notifications |

> **The one rule:** business logic lives in plugins, presentation lives in the theme. If the site were re-themed tomorrow, the content types, editorial fields, business settings, SEO output and the entire enquiry system would survive untouched.

## Screenshots

### Desktop

| Solutions | Acoustics solution page |
| --- | --- |
| ![Solutions](docs/screenshots/solutions.jpg) | ![Acoustics](docs/screenshots/acoustics.jpg) |
| **Partner brands** | **FANE Africa** |
| ![Brands](docs/screenshots/brands.jpg) | ![FANE Africa](docs/screenshots/fane-africa.jpg) |
| **Projects** | **Project case study: Sarit Expo Centre** |
| ![Projects](docs/screenshots/projects.jpg) | ![Sarit Expo Centre](docs/screenshots/project-sarit-expo.jpg) |
| **Integration service** | **Videos and resources** |
| ![Integration](docs/screenshots/service-integration.jpg) | ![Videos](docs/screenshots/videos.jpg) |
| **About** | **Contact with four regional offices** |
| ![About](docs/screenshots/about.jpg) | ![Contact](docs/screenshots/contact.jpg) |

| Homepage: what we do | Homepage: solutions and partner brands |
| --- | --- |
| ![Homepage services](docs/screenshots/home-services.jpg) | ![Homepage solutions and brands](docs/screenshots/home-solutions-brands.jpg) |
| **Homepage: featured projects and proof stats** | **Request a consultation** |
| ![Homepage projects and stats](docs/screenshots/home-projects-stats.jpg) | ![Consultation](docs/screenshots/consultation.jpg) |

### Mobile

<p align="center">
  <img src="docs/screenshots/home-mobile.jpg" alt="Mobile homepage" width="240">
  &nbsp;&nbsp;
  <img src="docs/screenshots/projects-mobile.jpg" alt="Mobile projects page" width="240">
  &nbsp;&nbsp;
  <img src="docs/screenshots/fane-mobile.jpg" alt="Mobile FANE Africa page" width="240">
  <br>
  <sub>Mobile-first layout with a sticky Call / WhatsApp / Consultation bar</sub>
</p>

<sub>Screenshots captured from the live site on 5 October 2026.</sub>

## What the site delivers

### Brands we represent

<p align="center">
  <img src="soundcreations/assets/img/brands/logos/fane.png" height="34" alt="FANE">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/db-technologies.png" height="34" alt="dB Technologies">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/shure.png" height="34" alt="Shure">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/bose-professional.png" height="34" alt="Bose Professional">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/allen-heath.png" height="34" alt="Allen &amp; Heath">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/midas.png" height="34" alt="Midas">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/nexo.png" height="34" alt="NEXO">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/biamp.png" height="34" alt="Biamp">
</p>

<p align="center">
  <img src="soundcreations/assets/img/brands/logos/behringer.png" height="30" alt="Behringer">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/chamsys.png" height="30" alt="ChamSys">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/asona.png" height="30" alt="Asona">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/barrisol.png" height="30" alt="Barrisol">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/rockfon.png" height="30" alt="Rockfon">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/somer-cable.png" height="30" alt="Somer Cable">&nbsp;&nbsp;
  <img src="soundcreations/assets/img/brands/logos/aid.png" height="30" alt="AID">
</p>

### Key features

**Presentation (theme)**
- **Dark-first, engineering-led design** in brand purple `#624489`, deep purple `#46305F` and action red `#BA0B0B`, with self-hosted Inter and Space Grotesk fonts and a light/dark toggle
- **Video hero** with a preloaded poster image and a branded **wavefront loader** with a minimum display time
- **Solutions**: Professional Audio, Acoustics and Sound &amp; Acoustic Integration, each with photos, related projects and visible FAQs
- **Services**: Consultancy, Distribution &amp; Dealership, Integration and After-Sale Services
- **Projects** with category filters and search: All Saints Cathedral, CITAM Buruburu, Sarit Expo Centre, West Nairobi School, PCEA Kahawa Farmers, Prestige Plaza, COVO NBO, RPF Rubavu Hall and more
- **Brands** hub with partner cards and logos, plus a dedicated **FANE Africa** page with dealer call-to-action
- **Videos** with real players and `VideoObject` schema
- **Four regional offices** (Nairobi, Kigali, Kinshasa, Dubai) on the contact page, floating WhatsApp chat and a mobile call / WhatsApp / consultation bar

**Business platform (plugins)**

| Module | What it does |
| --- | --- |
| **Central settings store** | One option, `soundcreations_settings`, holds contact details, hero media, proof stats and most homepage, About and footer copy. Change it once, it updates everywhere |
| **Content types** | Projects, products, brands, solutions, services, case studies, videos and FANE resources, each with its own editorial field group |
| **Starter setup** | One-click wizard creates the core pages, seeds the brand catalogue and sets menus on activation |
| **Enquiry forms** | Seven B2B forms with conditional fields: consultation, quote, product, dealer, FANE, support and contact |
| **Lead storage and routing** | Every enquiry stored privately in wp-admin; each form type routed to its own inbox under **Sound Creations > Enquiry Routing** |
| **Anti-spam and abuse controls** | Signal-based spam scoring, disposable-domain and MX checks, hashed-IP rate limiting, upload hardening and data-retention cron |

## Architecture

### Package map

```mermaid
flowchart TB
    subgraph PRES["Presentation"]
        P["soundcreations<br/>Parent theme<br/>templates · CSS · JS · hardening"]
        C["soundcreations-child<br/>Active theme<br/>CSS overrides only"]
    end
    subgraph LOGIC["Business logic (survives a re-theme)"]
        CORE["Sound Creations Core<br/>content model · settings · SEO"]
        ENQ["Sound Creations Enquiries<br/>forms · anti-spam · leads · mail"]
    end
    C -- "extends" --> P
    P -- "sc_setting()" --> CORE
    P -- "renders forms" --> ENQ
    CORE --> DB[("WordPress database")]
    ENQ --> DB
    ENQ -- "notifications" --> MAIL["Sales and support inboxes"]
```

### Enquiry pipeline

```mermaid
sequenceDiagram
    autonumber
    participant V as Visitor
    participant F as Form (theme)
    participant H as Handler
    participant S as Security layer
    participant DB as sc_enquiry (private)
    participant T as Routed inbox
    V->>F: Consultation / quote / dealer / FANE / support form
    F->>H: POST with nonce
    H->>S: Rate limit (hashed IP), honeypot, spam score, MX check
    alt Rejected
        S-->>V: Friendly error, rejection logged
    else Accepted
        H->>DB: Store lead (admin-only)
        H->>T: Email to the inbox set in Enquiry Routing
        H-->>V: Confirmation message
    end
```

### Page request and SEO output

```mermaid
flowchart LR
    R["Request"] --> T["Theme template<br/>front-page · single-sc_* · archive-sc_*"]
    T --> TT["template-tags.php<br/>shared markup helpers"]
    T --> S["Settings store<br/>soundcreations_settings"]
    T --> SEO["Core SEO<br/>titles · meta · Open Graph"]
    SEO --> G["Unified JSON-LD @graph<br/>Organization · LocalBusiness · WebSite<br/>Service · Product · FAQPage · VideoObject"]
    T --> A["enqueue.php<br/>inlined critical CSS · preloads · deferred JS"]
    A --> H["hardening.php<br/>security headers · cleanup"]
```

### Release pipeline

```mermaid
flowchart LR
    A["Edit code"] --> B["Commit to GitHub<br/>moselanto/soundcreationsltd.com"]
    B --> C["Upload changed theme /<br/>plugin folders to hosting"]
    C --> D["Live on<br/>soundcreationsltd.com"]
    B -. "port shared fixes deliberately" .-> RW["moselanto/soundcreationsltd.rw<br/>(Rwanda site)"]
```

> **Deployment note:** commits to this repo do **not** deploy automatically. Upload the changed theme or plugin folders to hosting for updates to go live. The Rwanda site runs a copy of this code in its own repository, so shared fixes must be ported in both directions deliberately.

## Content model

```mermaid
erDiagram
    BRAND ||--o{ PRODUCT : "makes"
    PRODUCT_CATEGORY ||--o{ PRODUCT : "groups"
    SOLUTION_AREA ||--o{ SOLUTION : "groups"
    SOLUTION ||--o{ PROJECT : "delivered in"
    INDUSTRY ||--o{ PROJECT : "sector"
    LOCATION ||--o{ PROJECT : "where"
    PROJECT ||--o| CASE_STUDY : "written up as"
    SERVICE ||--o{ ENQUIRY : "requested via"
```

| Post type | Purpose | Archive |
| --- | --- | --- |
| `sc_project` | Installation project with photos, location, scope and brands used | Yes |
| `sc_product` | Product with specs and manufacturer link | Redirects to `/brands/` |
| `sc_brand` | Partner brand page and logo | Yes |
| `sc_solution` | Professional Audio, Acoustics, Integration | Yes |
| `sc_case_study` | Long-form project story | Yes |
| `sc_resource` | Videos (labelled "Videos") | Yes, at `/videos/` |
| `sc_fane_resource` | FANE datasheets and resources | Yes |
| `sc_service` | Consultancy, Distribution, Integration, After-Sale | No |
| `sc_enquiry` | **Private** lead storage, admin-only, excluded from search | No |

Taxonomies: `sc_product_category`, `sc_brand_tax`, `sc_industry`, `sc_application`, `sc_project_type`, `sc_location`, `sc_solution_area`. Legacy URLs are 301-redirected: `/products/` to `/brands/` and `/resources/` to `/videos/`.

## Enquiry system

| Form | Used for |
| --- | --- |
| Consultation | New installations and upgrades: venue, application, budget and timeline |
| Quote | Equipment and system quotations |
| Product | Questions about a specific product |
| Dealer | Distribution and dealership applications |
| FANE | FANE driver enquiries and dealer requests |
| Support | Warranty, servicing and technical support |
| Contact | General enquiries |

All forms share one handler: nonce check, validation, signal-based spam scoring, rate limiting with hashed IPs (no raw IPs stored), safe upload rules, private storage, per-form routing and a scheduled retention clean-up.

## SEO and structured data

- **Keyword-led title templates** for every page type (solutions, services, brands, projects, videos) targeting searches such as *sound systems Kenya, AV installation Nairobi, acoustic treatment Kenya, church sound system, conference systems* and *FANE Africa*.
- **One unified JSON-LD `@graph`** connecting `Organization`, `LocalBusiness`, `WebSite` + `SearchAction`, `BreadcrumbList`, `Service`, `OfferCatalog`, `Product` + `Offer`, `Brand`, `FAQPage`, `VideoObject`, `ItemList` and `OpeningHoursSpecification`, with `areaServed` covering Kenya, Rwanda, the DRC and the UAE.
- **FAQ engine** that outputs visible FAQs and matching `FAQPage` schema from the same source.
- Open Graph and Twitter meta, one H1 per page and the WordPress XML sitemap at `/wp-sitemap.xml`.

## Performance and security

**Performance**
- Hand-coded templates with no page builder and no WooCommerce
- Design tokens plus a small set of stylesheets (`tokens.css`, `fonts.css`, `main.css`, `content.css`), deferred vanilla JavaScript and self-hosted WOFF2 fonts
- Preloaded hero poster for LCP, WebP images with set dimensions and lazy loading

**Security** (see [`SECURITY-AUDIT.md`](SECURITY-AUDIT.md))
- Reduced attack surface: XML-RPC and user enumeration closed, comments blocked, login throttling
- Security headers: `X-Frame-Options`, `Referrer-Policy`, `Content-Security-Policy` frame-ancestors, `Permissions-Policy` and HSTS when HTTPS is detected
- Escaped output, sanitised input, nonce-protected forms, upload hardening, PII retention limits and admin-only lead access

## Project structure

```text
.
├── README.md
├── ARCHITECTURE-ESSENTIALS.md   # Five-minute map of where things live
├── ARCHITECTURE.md              # Full technical architecture
├── EDITING-GUIDE.md             # Guide for content editors
├── PRD.md                       # Product requirements and decisions
├── SECURITY-AUDIT.md            # Security review and checklist
├── AGENTS.md                    # Conventions for anyone (or any AI agent) writing code here
├── docs/screenshots/            # README images captured from the live site
├── soundcreations/              # Parent theme
│   ├── front-page.php           # Homepage: hero, what we do, solutions, brands, projects, stats
│   ├── archive-sc_*.php         # Brands, projects, resources, solutions
│   ├── single-sc_*.php          # Brand, product, project, resource, service, solution
│   ├── page-about.php  page-fane.php  page-contact.php  page-request-a-consultation.php
│   ├── template-parts/          # Contact and consultation page parts
│   ├── inc/                     # setup, enqueue, customizer, shortcodes, template-tags, hardening
│   ├── assets/{css,js,fonts,img}/
│   └── theme.json  style.css  functions.php
├── soundcreations-child/        # Active child theme (CSS overrides only)
├── sound-creations-core/        # Plugin: content model, settings, SEO
│   └── includes/                # post-types, taxonomies, fields, settings, seo, seo-graph,
│                                # seo-titles, seo-faq, seed-catalog, setup-wizard, security
└── sound-creations-enquiries/   # Plugin: B2B enquiry system
    └── includes/                # forms, handler, antispam, security, mail, admin
```

## Requirements and installation

| Component | Version |
| --- | --- |
| WordPress | 6.4 or later |
| PHP | 8.0 or later |
| HTTPS | Required (HSTS is emitted when SSL is detected) |

1. Copy `soundcreations/` and `soundcreations-child/` into `wp-content/themes/`.
2. Copy `sound-creations-core/` and `sound-creations-enquiries/` into `wp-content/plugins/`.
3. Activate **Sound Creations Core** first. It registers the post types and creates the core pages.
4. Activate **Sound Creations Enquiries**. It grants enquiry capabilities to administrators and schedules the data-retention cron.
5. Activate the **Sound Creations Child** theme.
6. Fill in **Sound Creations > Settings**: company name, phone, email, address, hours and social links. Most homepage, About and footer copy is read from here.
7. Re-save **Settings > Permalinks** once if any URL returns a 404.

## Day-to-day editing

| Where | What you can change |
| --- | --- |
| **Sound Creations > Settings** | Contact details, homepage copy, hero media, proof stats, About copy, footer columns |
| **Projects / Products / Brands / Solutions / Services / Videos / FANE Resources** | Content, each with its own editorial field group |
| **Enquiries** | Every lead ever submitted (administrators only) |
| **Sound Creations > Enquiry Routing** | Which address each form type notifies |

Full walkthrough: [`EDITING-GUIDE.md`](EDITING-GUIDE.md).

## Documentation

| Document | Read it when |
| --- | --- |
| [`ARCHITECTURE-ESSENTIALS.md`](ARCHITECTURE-ESSENTIALS.md) | You have five minutes and need to find the right file |
| [`ARCHITECTURE.md`](ARCHITECTURE.md) | You are changing how something works |
| [`EDITING-GUIDE.md`](EDITING-GUIDE.md) | You are editing content in wp-admin |
| [`PRD.md`](PRD.md) | You are deciding what to build, or why something exists |
| [`SECURITY-AUDIT.md`](SECURITY-AUDIT.md) | You are touching forms, uploads, auth, headers or personal data |
| [`AGENTS.md`](AGENTS.md) | You (or an AI agent) are about to write code here |

## Group sites

| Site | Repository | Notes |
| --- | --- | --- |
| [soundcreationsltd.com](https://soundcreationsltd.com/) | this repository | Group site, Nairobi HQ |
| [soundcreationsltd.rw](https://soundcreationsltd.rw/) | [moselanto/soundcreationsltd.rw](https://github.com/moselanto/soundcreationsltd.rw) | Independent Rwanda site: authorised Yamaha distributor, runs a copy of this code with a Rwanda child theme |

## Business

**Sound Creations Ltd**
Mpaka Plaza, Mpaka Road, Westlands, Nairobi, Kenya
Phone and WhatsApp: [+254 715 754 758](tel:+254715754758) · Email: [info@soundcreationsltd.com](mailto:info@soundcreationsltd.com)
Hours: Mon - Fri 9:00 AM - 5:30 PM · Sat 9:00 AM - 1:30 PM · Sun closed

| Office | Location |
| --- | --- |
| Nairobi, Kenya (HQ) | Mpaka Plaza, Mpaka Road, Westlands |
| Kigali, Rwanda | KN1 Rd, Muhima (near BTN) |
| Kinshasa, DR Congo | Kinshasa |
| Dubai, UAE | Dubai |

## Credits

Designed, developed and maintained by **[Pimofy Digital](https://github.com/moselanto)**, Nairobi.
Fonts: Inter and Space Grotesk (SIL Open Font License). Brand logos and trademarks belong to their respective owners.

## License

GNU General Public License v2 or later, matching WordPress. See the [license text](http://www.gnu.org/licenses/gpl-2.0.html).

<div align="center"><sub><i>If it sounds good, it's Sound Creations.</i></sub></div>
