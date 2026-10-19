# Structured data (JSON-LD) - soundcreationsltd.com

The single source of truth for what the site tells search engines about the
business. Code: `sound-creations-core/includes/seo-graph.php` (graph),
`seo-faq.php` (FAQPage), `seo.php` (descriptions, canonical, robots hand-off).
Last reviewed 19 Oct 2026.

## Ownership and duplicate prevention

- **Core prints exactly one `<script type="application/ld+json">` per page**,
  containing one `@graph`, from `sc_seo_graph()` on `wp_head` priority 1.
- **Rank Math prints no JSON-LD.** Its Schema module is switched off in
  wp-admin (owner decision, 14 Oct 2026) and, since commit `faeec28`, the
  `rank_math/json_ld` payload is emptied in code while
  `sc_seo_core_owns_schema` returns true. Rank Math still owns title, meta
  description, canonical, Open Graph and robots meta.
- No other plugin or theme file emits JSON-LD (checked by grep of the repo).
- Not emitted, by policy: Review, AggregateRating, Offer prices, stock,
  GTINs, invented branch addresses. The Google rating shown on the homepage
  is visible text only.

## Stable @ids

All are absolute and must never change once published.

| Entity | @id |
| --- | --- |
| Organization / ProfessionalService (Nairobi HQ) | `https://soundcreationsltd.com/#organization` |
| Logo ImageObject | `https://soundcreationsltd.com/#logo` |
| WebSite | `https://soundcreationsltd.com/#website` |
| OfferCatalog | `https://soundcreationsltd.com/#services` |
| Branch (only when an address is set) | `https://soundcreationsltd.com/#branch-kigali` / `-drc` / `-dubai` |
| WebPage | `{canonical}/#webpage` |
| BreadcrumbList | `{canonical}/#breadcrumb` |
| Primary image | `{canonical}/#primaryimage` |
| Service | `{canonical}/#service` (the same id the OfferCatalog references) |
| Brand | `{canonical}/#brand` |
| Product | `{canonical}/#product` |
| Project (CreativeWork) | `{canonical}/#project` |
| VideoObject | `{canonical}/#video` |
| Article | `{canonical}/#article` |
| ItemList (archives) | `{canonical}/#itemlist` |
| FAQPage | `{canonical}/#faq` |

## Current graph (= target graph after the 19 Oct fixes)

The Nairobi head office IS the Organization (typed
`["Organization","ProfessionalService"]`). A separate Nairobi LocalBusiness
node was removed earlier because it duplicated the same entity at the same
address. Other branches are `LocalBusiness` nodes with `parentOrganization`,
emitted only when a real address is saved.

```
WebSite #website --publisher--> Organization #organization
WebPage #webpage --isPartOf--> #website, --about--> #organization,
                 --breadcrumb--> #breadcrumb, --primaryImageOfPage--> #primaryimage
Service/Brand/Product/CreativeWork/VideoObject/Article --mainEntityOfPage/isPartOf--> #webpage
Service --provider--> #organization ; Product --seller--> #organization
Organization --hasOfferCatalog--> #services --itemOffered--> each solution's #service
Organization --subOrganization--> #branch-* (only when set)
FAQPage --mainEntityOfPage--> #webpage (only when the FAQ is visible)
```

## Per-template types

| Template / URL | Nodes added to the base (Organization, WebSite, WebPage, Breadcrumb) | WebPage subtype |
| --- | --- | --- |
| Front page `/` | (no breadcrumb) | WebPage |
| `/about/` | - | AboutPage |
| `/contact/`, `/request-a-quote/`, `/request-a-consultation/` | - | ContactPage |
| `/solutions/` and other archives | ItemList | CollectionPage |
| `/solutions/{slug}/` | Service | WebPage |
| `/service/{slug}/` | Service | WebPage |
| `/brands/{slug}/` | Brand | ItemPage |
| `/products/{slug}/` | Product (no offers, by policy) | ItemPage |
| `/projects/{slug}/` | CreativeWork | WebPage |
| `/videos/{slug}/` | VideoObject when a YouTube URL is set, otherwise Article | WebPage |
| Any singular with visible FAQs | FAQPage | - |
| Feeds, 404, admin | nothing | - |

## Field sources

| Property | Source |
| --- | --- |
| name | setting `company_name`, else Site Title |
| description | setting `org_description`, else `tagline` |
| slogan | setting `slogan` |
| telephone, contactPoint | setting `phone` |
| email | setting `email` |
| address.streetAddress | setting `address` (locality Nairobi, region Nairobi County, country KE) |
| geo | settings `geo_lat`, `geo_lng` (numeric only) |
| hasMap | setting `google_business` (http/https only) |
| openingHoursSpecification | parsed from settings `hours_week`, `hours_sat`; omitted if unparseable or "closed" |
| foundingDate | setting `founding_year` (4 digits; default 2004, confirmed by the business) |
| sameAs | settings `facebook`, `x`, `linkedin`, `youtube`, `instagram`, `tiktok` (http/https only, de-duplicated) |
| logo | Customizer `custom_logo`, else Site Icon 512px (`sc_seo_logo_url`) |
| areaServed | Kenya, Rwanda, DR Congo, UAE (Country) + East Africa (AdministrativeArea), from `sc_seo_areas_served()` |
| branches | settings `branch_{kigali,drc,dubai}_{address,phone,lat,lng}` |
| Service description | excerpt, else the page's meta-description chain (`sc_seo_description`) |
| Video thumbnail | featured image (if any), then `i.ytimg.com/vi/{id}/hqdefault.jpg` |
| FAQ | post meta `_sc_faq`, only on templates that render it (`sc_faq_is_rendered`) |

## Output conditions and safety rules

- A node with missing required data is omitted, not stubbed (branches,
  VideoObject, FAQPage, primary image).
- Breadcrumb items never point at a redirect: products sit under `/brands/`
  because `/products/` 301s there.
- FAQPage is emitted only when the current template prints the FAQ block.
  Unknown templates default to no FAQ schema.
- Filters: `sc_seo_graph` (whole node list), `sc_seo_core_owns_schema`,
  `sc_seo_logo_url`, `sc_faq_is_rendered`.

## Sample (homepage, abridged)

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": ["Organization", "ProfessionalService"],
      "@id": "https://soundcreationsltd.com/#organization",
      "name": "Sound Creations Ltd",
      "url": "https://soundcreationsltd.com/",
      "logo": {"@type": "ImageObject", "@id": "https://soundcreationsltd.com/#logo", "url": "<custom logo or site icon>"},
      "image": {"@id": "https://soundcreationsltd.com/#logo"},
      "telephone": "<setting phone>",
      "email": "<setting email>",
      "foundingDate": "2004",
      "address": {"@type": "PostalAddress", "streetAddress": "<setting address>", "addressLocality": "Nairobi", "addressRegion": "Nairobi County", "addressCountry": "KE"},
      "openingHoursSpecification": [
        {"@type": "OpeningHoursSpecification", "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"], "opens": "09:00", "closes": "17:30"},
        {"@type": "OpeningHoursSpecification", "dayOfWeek": ["Saturday"], "opens": "09:00", "closes": "13:30"}
      ],
      "areaServed": [{"@type": "Country", "name": "Kenya"}, {"@type": "Country", "name": "Rwanda"}],
      "sameAs": ["<settings social URLs>"],
      "contactPoint": [{"@type": "ContactPoint", "telephone": "<setting phone>", "contactType": "sales", "availableLanguage": ["English"]}],
      "hasOfferCatalog": {"@id": "https://soundcreationsltd.com/#services"}
    },
    {"@type": "WebSite", "@id": "https://soundcreationsltd.com/#website", "url": "https://soundcreationsltd.com/", "publisher": {"@id": "https://soundcreationsltd.com/#organization"}},
    {"@type": "WebPage", "@id": "https://soundcreationsltd.com/#webpage", "isPartOf": {"@id": "https://soundcreationsltd.com/#website"}, "about": {"@id": "https://soundcreationsltd.com/#organization"}}
  ]
}
```

(The real output inlines the OfferCatalog in the Organization node; it is
shown by reference here for brevity. Opening hours shown assume the current
settings strings parse as on the live footer.)
