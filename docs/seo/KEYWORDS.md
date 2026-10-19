# Keyword master database and URL map (Deliverables C and D draft)

Site: <https://soundcreationsltd.com/> (Kenya). Research date 19 Oct 2026.
Companion: [COMPETITORS.md](COMPETITORS.md).

## Data sources and limits (read before using the numbers)

- **Search volume: not available for every keyword.** No Google Ads Keyword
  Planner, Search Console or third-party volume tool was accessible. The
  Google autocomplete endpoint (suggestqueries.google.com, gl=ke) and Google
  Trends could not be fetched by the research tools. Every "Volume" cell is
  therefore `n/a`; the "Demand signal" column is a qualitative judgement
  from how many Kenyan pages target the phrase. Pull real numbers from
  Keyword Planner (location: Kenya) and Search Console before final
  prioritisation.
- **Current SC ranking**: "appears" means the SC page was returned by the
  research search engine for that query on 19 Oct 2026. It is **not** a
  measured Google.co.ke position. `n/o` = not observed.
- **Phrasing**: Kenyan variants were taken from competitor titles, product
  listings and on-page FAQ wording observed during research (e.g. "PA system
  price in Kenya", "Public Address System for Schools", "soundproofing in
  Nairobi", "church line arrays in Kenya").
- **No product pages.** The company does not want products showcased
  (WORK-LOG standing decision). Product/model keywords map to brand pages
  under /brands/{brand}/ or to solution pages, never to /product/ URLs.
- **Dealership wording**: only Allen & Heath and Bose Professional list Sound
  Creations as their Kenya contact on the manufacturer site (verified 19 Oct
  2026). Shure appointed Hub Media for African markets (8 Jul 2026). Use
  "authorised distributor" only for A&H and Bose Professional; use
  "supplier/dealer" for the rest until manufacturer confirmation.
- **Priority score** (1-10, judgement): commercial value x fit with SC
  strengths x winnability, minus product-showcase risk.

Legend - Intent: C commercial, T transactional, I informational, N navigational.
Funnel: TOFU awareness, MOFU consideration, BOFU decision.
Persona: CH church leadership/tech team; FM facility/estates manager; AR
architect/QS/consultant; CO corporate IT/admin; ED school bursar/principal;
HO hotel/venue owner; IN integrator/reseller; EV event producer.

## Live URL inventory (observed)

| URL | Title observed | H1 observed |
| --- | --- | --- |
| / | Audio Visual & Acoustic Solutions in Kenya \| Sound Creations Ltd | (none surfaced; H2 "Audio, acoustics and AV solutions across Kenya and Africa") |
| /solutions/ | Solutions \| Sound Creations Ltd | Engineered solutions. Exceptional experiences. |
| /solutions/professional-audio/ | Professional Sound & PA Systems in Kenya \| Sound Creations Ltd | Professional Audio |
| /solutions/acoustics/ | Acoustic Treatment & Soundproofing in Kenya | Acoustics |
| /solutions/acoustic-panels-ceilings/ | Acoustic Panels & Ceilings in Kenya \| Sound Creations Ltd | Acoustic Panels and Ceilings |
| /solutions/installation/ | Sound System & AV Installation in Kenya \| Sound Creations Ltd | Installation |
| /solutions/system-integration/ | System Integration \| Sound Creations Ltd | System Integration (same body copy as /installation/ - duplicate) |
| /solutions/church-worship-sound-systems/ | Church Sound Systems & Acoustics in Kenya \| Sound Creations Ltd | Church and Worship Sound Systems |
| /solutions/hospitality-commercial-audio/ | Hotel, Club & Venue Sound Systems in Kenya \| Sound Creations Ltd | Hospitality and Venue Sound Systems |
| School and Auditorium solution page | exists on /solutions/ grid; URL not surfaced by search - confirm slug in wp-admin | School and Auditorium Sound Systems |
| /distribution/ | Pro Audio & Acoustics Distributor in Kenya \| Sound Creations Ltd | Distribution and Dealership |
| /service/consultancy/ | Consultancy in Kenya | CONSULTANCY |
| /service/distribution-dealership/ | Distribution & Dealership – Sound creations ltd | Distribution & Dealership |
| /service/intergration/ (typo slug) | Intergration – Sound creations ltd | INTEGRATION |
| /service/after-sale-services/ (inferred from /service/ listing; confirm) | After sale Services | legacy warranty text |
| /brands/ | Brands \| Sound Creations Ltd (document title filtered to "Products") | Professional audio, acoustic and AV brands. |
| /projects/ + 8 singles (/projects/pcea-kahawa-farmers/, /projects/rpf-rubavu-hall/, /projects/sarit-expo-centre/, /projects/west-nairobi-school/, /projects/citam-buruburu/, /projects/all-saints-cathedral/, Playza, COVO NBO) | Projects – Sound creations ltd | Real solutions. Real impact. |
| /about/ | About Us \| Audio Visual Company in Nairobi \| Sound Creations Ltd | If it sounds good, it's Sound Creations |
| /contact/ | Contact – Sound creations ltd | Let's talk about your project. |
| /request-a-consultation/ | Request a Consultation \| Sound Creations Ltd | Request a Consultation |
| /fane/ | FANE Loudspeakers in Kenya & Africa \| Sound Creations Ltd | Engineering sound since 1958. |
| /videos/ | Videos \| Sound Creations Ltd | Videos & resources. |
| /testimonials/ | live (4 Google reviews) | n/o |
| /the-team/ | The Team – Sound Creations Ltd | n/o |
| Legacy, still indexed | /acoustic-solutions/, /audio-solutions/, /design-and-consulting/, /our-services/, /audio-products/, /shure-microphones/, /product/dbtechnologies-opera-15/, /product/db-technologies-b-hype-10/, blog posts (PCEA Chuka, All Saints Trinity, CITAM, church LED, corporate sound, A&H Calvary Chapel) | old theme titles "– Sound creations ltd" |

Individual brand single URLs (/brands/{slug}/) were not surfaced by search;
confirm slugs in wp-admin. The sitemap (/wp-sitemap.xml) could not be fetched
(WORK-LOG open item 4).

## Keyword master table

Columns: keyword | variants | intent | persona | funnel | geo | commercial value | volume (source) | demand signal | competition (qualitative) | SC ranking observed | target URL | priority | content gap | action

### A. Core AV company / integration

| Keyword | Variants | Int | Persona | Fun | Geo | Value | Vol | Demand | Competition | SC observed | Target URL | Pri | Gap | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| audio visual company Kenya | AV company Kenya, audio visual solutions Kenya | C | FM, CO, AR | MOFU | Kenya | High | n/a | High (many "best AV company" titles) | High; event-hire firms dominate | Homepage appears | / | 8 | No H1 with the phrase; no named-client strip above fold | Add H1; keep title |
| audio visual company Nairobi | AV companies in Nairobi | C | all | MOFU | Nairobi | High | n/a | High | High (StagePass, PS AV, Premier, VTECH) | /about/ appears | / (primary), /about/ (secondary) | 7 | About title targets it; homepage does not mention "Nairobi" in title | Homepage title test; keep About |
| AV system integrator Kenya | AV integration company, systems integrator Kenya | C | AR, FM, IN | BOFU | Kenya | High | n/a | Medium | Medium (AVCS, Proscene, GZEP) | n/o | /solutions/installation/ | 8 | /system-integration/ duplicates /installation/ | Consolidate: 301 /solutions/system-integration/ to /solutions/installation/ (owner approval) |
| sound and acoustic solutions Kenya | acoustics and sound company | C | AR | MOFU | Kenya | High | n/a | Low | Low | Homepage appears | / | 6 | - | Keep |
| AV consultant Kenya | audio visual consultant Nairobi, AV design consultancy | C | AR, QS | MOFU | Kenya | High | n/a | Low | Low-Med (MMPA, LINSPACE from SA) | n/o | /service/consultancy/ | 8 | Legacy title "Consultancy in Kenya"; mentions EASE, SMAART but no process/deliverables for architects | Expand: deliverables (acoustic report, RT60/NC criteria, BOQ, drawings) |

### B. Pro audio, sound systems, PA

| Keyword | Variants | Int | Persona | Fun | Geo | Value | Vol | Demand | Competition | SC observed | Target URL | Pri | Gap | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| sound system installation Kenya | sound system installers Nairobi, PA installation | C/T | FM, CH, HO | BOFU | Kenya | High | n/a | High | High (VTECH, HiFix, Pro-Logic, GZEP) | /solutions/installation/ appears first in research index | /solutions/installation/ | 10 | H1 is just "Installation"; short body; no process/timeline/FAQ | Expand page, H1 change |
| PA system Kenya | public address system Kenya, PA systems | C | ED, CH | MOFU | Kenya | Med-High | n/a | High | High (retailers) | n/o | /solutions/professional-audio/ | 7 | Retail intent dominates | Target "installed PA system" angle |
| PA system price in Kenya | public address system price, how much is a PA system in Kenya | T/I | CH, ED | MOFU | Kenya | Med | n/a | High (Skywave "public address system price" page, Jumia, Kilimall) | High, retail | n/o | Guide section on /solutions/professional-audio/ (FAQ) | 5 | No pricing guidance | Answer "what drives cost" FAQ; no product prices |
| line array system Kenya | church line arrays in Kenya, line array price Kenya | C | CH, EV | MOFU | Kenya | High | n/a | Medium (Thunder Sound listicle) | Medium | n/o | /solutions/professional-audio/ + /brands/ dB Technologies | 7 | No line-array explanation | Add section; link CITAM (dB T-Series) |
| professional sound system Kenya | pro audio Kenya | C | all | MOFU | Kenya | High | n/a | Medium | Medium | /solutions/professional-audio/ title targets it | /solutions/professional-audio/ | 8 | Body is sector teasers; thin | Expand |
| public address system for schools Kenya | school PA system Kenya | C | ED | MOFU | Kenya | Med | n/a | Medium (Skywave PACG002, VTECH sector) | Medium | n/o | School & auditorium solution page | 6 | - | Add PA/bell/paging section |
| background music system hotel Kenya | BGM system, multi-zone audio Kenya | C | HO | BOFU | Kenya | Med-High | n/a | Low | Low-Med (Newtech) | /solutions/hospitality-commercial-audio/ appears | same | 8 | Good page; add zone diagram, FAQ | Keep & improve |
| club sound system Kenya | nightclub sound system Nairobi | C | HO | BOFU | Nairobi | Med | n/a | Low | Low | hospitality page appears | same | 7 | COVO, Ciel Lounge (LinkedIn 21 Sep 2026) | Add Ciel Lounge as project if approved |
| live sound / concert sound | concert sound Kenya | C | EV | MOFU | Kenya | Low-Med | n/a | Med | High (hire firms) | legacy /audio-solutions/ | /solutions/professional-audio/ | 3 | SC is not a hire company | Do not chase hire terms |

### C. Churches and worship

| Keyword | Variants | Int | Persona | Fun | Geo | Value | Vol | Demand | Competition | SC observed | Target URL | Pri | Gap | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| church sound system Kenya | sound system for church in Kenya, church PA system Kenya | C | CH | MOFU-BOFU | Kenya | High | n/a | High | High (Sound Hire Nairobi x3 pages, VTECH, HomeTech, Rehoboth) | appears first in research index | /solutions/church-worship-sound-systems/ | 10 | Has FAQ; lacks named project cards inline with numbers, cost drivers, mosque mention | Expand |
| church sound system installation Nairobi | church sound installers Nairobi | T | CH | BOFU | Nairobi | High | n/a | Med | Med | as above | same | 9 | - | Add "Nairobi" in intro/H2 |
| church acoustics Kenya | church echo problem, acoustic treatment for church | C/I | CH, AR | MOFU | Kenya | High | n/a | Low | Low (Level Acoustics mentions churches) | n/o | church page + /solutions/acoustics/ | 9 | PCEA Chuka RT60 case is on a legacy post | Rebuild Chuka as /projects/ case study |
| best PA system for church | church speakers Kenya, church mixer | I/C | CH | MOFU | Kenya | Med | n/a | Med (Skywave "Best PA system for a church") | Retail | n/o | church page (FAQ) | 6 | - | FAQ: choosing system by congregation size |
| church live stream audio | church streaming setup Kenya | I | CH | TOFU | Kenya | Med | n/a | Low | Low (VTECH blog) | n/o | church page section | 5 | Mentioned as bullet only | Short section |
| mosque sound system Kenya | masjid PA system, Mombasa | C | mosque committee | MOFU | Kenya/Mombasa | Med | n/a | Low (Skywave "Mosque Public Address") | Low | n/o | church page renamed scope "worship" or section | 5 | Paxt article cites Burhani Masjid Mombasa; not on site | Add only if owner confirms project |
| church LED screen | - | C | CH | MOFU | Kenya | Med | n/a | Med | VTECH | legacy blog post | keep blog post | 3 | Visual is not core | Keep |

### D. Architectural acoustics and soundproofing (treatment vs isolation kept separate)

Treatment = controlling reflections/reverberation inside a room (panels,
ceilings, diffusers). Isolation (soundproofing) = stopping sound passing
between spaces (mass, decoupling, seals, acoustic doors). Do not target both
with one page.

| Keyword | Variants | Int | Persona | Fun | Geo | Value | Vol | Demand | Competition | SC observed | Target URL | Pri | Gap | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| acoustic treatment Kenya (TREATMENT) | room acoustics, echo reduction | C | AR, CH, FM | MOFU | Kenya | High | n/a | Med | Med (Level Acoustics, VTECH, Neo) | /solutions/acoustics/ | /solutions/acoustics/ | 9 | Title mixes "& Soundproofing" | Retitle to treatment; move isolation to new page |
| acoustic consultants Nairobi (TREATMENT+DESIGN) | acoustic engineer Kenya, acoustic consultancy | C | AR, QS | BOFU | Nairobi | High | n/a | Low | Low (SA firms, Neo) | /design-and-consulting/ (legacy) appears | /service/consultancy/ or new /solutions/acoustics/ section | 9 | Legacy page has the strongest process copy (Inception, Schematic Design) on an old URL | Consolidate legacy into consultancy page |
| acoustic panels Kenya (TREATMENT) | acoustic panels Nairobi, acoustic wall panels price | C/T | FM, HO | BOFU | Kenya | Med-High | n/a | High | High (Level Acoustics guide, Kenworks, Insulation Kenya, Techandmat) | /solutions/acoustic-panels-ceilings/ appears | same | 8 | No guidance on NRC, coverage, fabric vs timber | Expand with selection guide |
| acoustic ceiling Kenya (TREATMENT) | Rockfon ceiling Kenya, acoustic ceiling tiles Nairobi | C | AR, FM | BOFU | Kenya | High | n/a | Med | Med (Interiors by Violet, Soundproofing Kenya) | same | same + /brands/ Rockfon | 8 | PCEA Kahawa/Chuka Rockfon proof not linked | Add project links |
| soundproofing in Nairobi (ISOLATION) | soundproofing Kenya, soundproof room Nairobi | C/T | HO, FM | BOFU | Nairobi | High | n/a | High | High (Soundproofing Kenya, Customsound, Pro-Logic, Level Acoustics) | /solutions/acoustics/ title | NEW /solutions/sound-isolation/ | 9 | No isolation page; Sarit Expo and RPF doors are isolation proof | Create |
| soundproof partitions / acoustic doors Kenya (ISOLATION) | acoustic dividing doors, operable walls | C | AR, HO | BOFU | Kenya | High | n/a | Low | Med (fit-out firms) | n/o | NEW /solutions/sound-isolation/ | 7 | Sarit Expo dividing doors | Section on new page |
| noise complaints neighbours bar Nairobi (ISOLATION) | stop sound leaking club | I/C | HO | TOFU | Nairobi | Med | n/a | Low | Low | hospitality FAQ | /solutions/sound-isolation/ + hospitality | 6 | - | FAQ |
| studio acoustic treatment Kenya | recording studio soundproofing | C | studio | MOFU | Kenya | Low-Med | n/a | Med | Level Acoustics strong | n/o | /solutions/acoustics/ (mention) | 4 | Consumer/foam market | Low priority |
| reverberation time / RT60 | echo in hall, speech intelligibility | I | AR | TOFU | - | Med (authority) | n/a | Low | Low | legacy posts | NEW guide or /solutions/acoustics/ FAQ | 6 | - | AEO answer |

### E. Corporate conferencing and boardroom

| Keyword | Variants | Int | Persona | Fun | Geo | Value | Vol | Demand | Competition | SC observed | Target URL | Pri | Gap | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| conference room AV Kenya | boardroom AV Nairobi, meeting room audio | C | CO, FM | BOFU | Nairobi | High | n/a | High | High (VTECH, Granular IT, BoardTac, Perlogy, GZEP) | n/o | NEW /solutions/conferencing-boardroom-audio/ | 8 | No corporate page (only a teaser on professional-audio) | Create, audio-led |
| conference system Kenya | delegate microphone system, conference microphones | C | CO, gov | BOFU | Kenya | High | n/a | Med | Med (Stepman Bosch/Taiden) | n/o | same new page | 7 | - | Section |
| Bose Professional conferencing Kenya | Bose ceiling speakers, Bose videobar Kenya | C | CO, IN | BOFU | Kenya | High | n/a | Low | Low (consumer Bose resellers) | n/o | /brands/ Bose Professional + new conferencing page | 9 | Bose lists SC as Kenya office | Build |
| boardroom acoustics | echo in boardroom, conference room acoustic panels | C | CO | MOFU | Nairobi | Med | n/a | Low | Low-Med | n/o | conferencing page + acoustics | 6 | - | Cross-link |
| video conferencing installation Kenya | Teams room Kenya | C | CO | BOFU | Kenya | Med | n/a | High | High (UC integrators) | n/o | conferencing page (secondary) | 4 | Display/UC not core | Mention, do not lead |

### F. Education, hospitality, venues

| Keyword | Variants | Int | Persona | Fun | Geo | Value | Vol | Demand | Competition | SC observed | Target URL | Pri | Gap | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| school hall sound system Kenya | auditorium sound system Kenya, school PA | C | ED | MOFU | Kenya | High | n/a | Med | Med | West Nairobi School project appears | School & auditorium solution page | 8 | Confirm URL; add West Nairobi School detail | Expand |
| auditorium acoustics Kenya | lecture hall acoustics | C | ED, AR | MOFU | Kenya | High | n/a | Low | Low | n/o | school page + /solutions/acoustics/ | 7 | - | Section |
| hotel sound system Kenya | hotel audio visual solutions Kenya | C | HO | BOFU | Kenya | High | n/a | Med | Med (VTECH sector page) | hospitality page appears | /solutions/hospitality-commercial-audio/ | 8 | - | Keep & improve |
| event venue / expo hall acoustics | conference centre acoustics Nairobi | C | HO, AR | BOFU | Nairobi | High | n/a | Low (servicecenter.co.ke listicle) | Low | Sarit Expo project | hospitality page + /projects/sarit-expo-centre/ | 7 | - | Link |
| restaurant acoustic treatment Nairobi | noisy restaurant fix | C | HO | MOFU | Nairobi | Med | n/a | Low | Low | n/o | hospitality page FAQ | 5 | - | FAQ |

### G. Brands and dealership (brand pages, not product pages)

| Keyword | Variants | Int | Persona | Fun | Geo | Value | Vol | Demand | Competition | SC observed | Target URL | Pri | Manufacturer evidence | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Allen & Heath Kenya | Allen & Heath distributor Kenya, Allen & Heath mixer price Kenya, SQ5/Avantis Kenya | C/T | IN, CH | BOFU | Kenya | High | n/a | Med | Med (Eclipse Sounds, Audiocom product listings) | manufacturer page lists SC | /brands/allen-heath/ (confirm slug) | 10 | **Verified**: allen-heath.com Kenya page lists SC + Paxt | "Authorised Allen & Heath distributor in Kenya"; link CITAM (Avantis); model names in text only |
| Bose Professional Kenya | Bose Professional distributor Kenya, Bose installed sound | C | IN, CO, HO | BOFU | Kenya | High | n/a | Low (consumer Bose dominates) | Low for "Professional" | manufacturer page lists SC | /brands/bose-professional/ | 10 | **Verified**: boseprofessional.com Global Sales Offices, Kenya = SC | Build page; separate from consumer Bose |
| dB Technologies Kenya | dBTechnologies distributor Kenya, dB Technologies line array | C | IN, CH, HO | BOFU | Kenya | High | n/a | Low | Low (Shopit empty page) | legacy /product/ pages indexed | /brands/db-technologies/ | 9 | Kenya listed in dB network; name not rendered; ProSoundWeb 2010 "Kenyan distributor Sound Creations" | Say "supplier since 2009" (stated on SC's own All Saints post) until dB confirms |
| Shure Kenya | Shure microphones Kenya, Shure wireless Kenya, Shure dealer Kenya | C/T | CH, CO | BOFU | Kenya | High | n/a | High | High (Shopit, Skywave, Eclipse, Credible) | /shure-microphones/ legacy | /brands/shure/ | 6 | Shure appointed Hub Media (Jul 2026); SC not verified | "Shure supplier"; no distributor claim; 301 legacy page |
| Midas Kenya / Behringer Kenya | Midas M32 Kenya, Behringer X32 Kenya | C/T | CH, EV | BOFU | Kenya | Med | n/a | Med | High (retailers) | n/o | /brands/midas/, /brands/behringer/ | 5 | Not verified (Music Tribe uses super-partner model) | Supplier wording only |
| Rockfon Kenya | Rockfon ceiling tiles Kenya, Rockfon Arctic | C | AR, FM | BOFU | Kenya | High | n/a | Low | Low (fit-outers mention Rockfon) | n/o | /brands/rockfon/ | 8 | Rockfon distributor finder not rendered; not verified | Link PCEA Kahawa + Chuka |
| Barrisol Kenya | stretch ceiling Kenya | C | AR | BOFU | Kenya | Med | n/a | Low | Low | n/o | /brands/barrisol/ | 6 | Not verified | Brand page |
| Asona Kenya | seamless acoustic plaster Kenya | C | AR | BOFU | Kenya | Med | n/a | Low | Very low | n/o | /brands/asona/ | 6 | Not verified | Brand page |
| Aid acoustic panels | - | C | FM | BOFU | Kenya | Low-Med | n/a | Low | Low | n/o | /brands/aid/ | 4 | Not verified | Brand page |
| FANE speakers Kenya | FANE drivers Kenya, FANE dealer Africa | C/T | IN | BOFU | East Africa | Med | n/a | Low | Very low | /fane/ appears | /fane/ | 7 | Not verified on fane-acoustics site in this research | Keep dealer-recruitment angle |
| Sommer Cable Kenya | speaker cable Kenya | C | IN | BOFU | Kenya | Low | n/a | Low | Low | n/o | /brands/sommer-cable/ | 3 | Not verified | Brand page |

### H. Technical services and after-sales

| Keyword | Variants | Int | Persona | Fun | Geo | Value | Vol | Demand | Competition | SC observed | Target URL | Pri | Gap | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| sound system maintenance Kenya | AV maintenance contract, AMC sound system | C | FM, CH | BOFU | Kenya | High (recurring) | n/a | Med | Med (VTECH, GZEP AMC) | n/o | /service/after-sale-services/ | 8 | Legacy warranty list (includes "Buddhist prayer machines") | Rewrite |
| amplifier / speaker repair Nairobi | sound system repair Nairobi | T | all | BOFU | Nairobi | Low-Med | n/a | High | High (consumer repair shops) | n/o | after-sales page (mention) | 4 | Consumer intent | Mention brands serviced only |
| system commissioning and tuning | sound system calibration Kenya | C | IN, AR | BOFU | Kenya | Med | n/a | Low | Low | /solutions/installation/ bullet | /solutions/installation/ | 6 | One bullet | Section with SMAART/EASE |
| sound engineer training Kenya | church sound team training, mixer training | C/I | CH | MOFU | Kenya | Med | n/a | Low | Low (Sauty training) | legacy /service/trainings/ (SynAudCon text) | church page + after-sales | 5 | Legacy trainings page | Consolidate |
| genuine spare parts warranty | original Shure Kenya, counterfeit | I/C | CH, IN | MOFU | Kenya | Med | n/a | Low | Low | n/o | after-sales + brand pages | 6 | Paxt article quotes SC on counterfeits | Section |

### I. Geography

Nairobi is the primary target. Upcountry: evidence found only for
**Mombasa** (Paxt article: Burhani Masjid, Old Town Mombasa; Decibel Audio
has a Mombasa shop) and **Meru/Chuka** (PCEA Chuka legacy post). No SC
evidence found for Kisumu, Nakuru or Eldoret (Debex is a Nakuru competitor).
Do not create city landing pages without real projects there.

| Keyword | Target URL | Pri | Note |
| --- | --- | --- | --- |
| ... Nairobi (sound system installation Nairobi, acoustic panels Nairobi, soundproofing in Nairobi) | existing solution pages, Nairobi named in intro + H2 | 9 | Westlands showroom, Mpaka Plaza |
| ... Westlands | /contact/ and GBP | 5 | Local pack |
| ... Mombasa | none yet | 3 | Only if owner confirms Mombasa projects |
| ... East Africa / Kigali / DRC | /about/ | 4 | Rwanda queries belong to soundcreationsltd.rw |

## Keyword-to-URL map (Deliverable D draft)

Titles <= 60 characters and metas <= 155 characters (counted). Actions:
keep&improve / expand / consolidate / create.

| URL | Intent | Primary keyword | Secondary cluster | Title/H1 observed | Gaps | Recommended title | Recommended meta | H1 | Internal links | Schema needs | Action |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| / | N/C | audio visual company Kenya | A, B, D | T: Audio Visual & Acoustic Solutions in Kenya \| Sound Creations Ltd; no H1 seen | H1 missing; Nairobi absent | Sound, Acoustics & AV Company in Nairobi, Kenya | Sound Creations designs, supplies and installs sound systems and acoustic treatment for churches, venues and offices across Kenya since 2004. | Sound, acoustics and AV solutions in Kenya | All solution pages, /projects/, /brands/, /request-a-consultation/ | Organization + LocalBusiness (address, geo, hours, sameAs) - verify seo.php output | keep&improve |
| /solutions/installation/ | C/T | sound system installation Kenya | A, H | T: Sound System & AV Installation in Kenya; H1: Installation | Thin; duplicate of /system-integration/ | Sound System Installation in Kenya \| Sound Creations | Turnkey sound system and acoustic installation in Kenya: site survey, design, installation, commissioning, training and support from our Nairobi team. | Sound system installation in Kenya | Church, hospitality, school pages; CITAM, COVO projects | Service (areaServed Kenya), FAQPage only if visible FAQs | expand |
| /solutions/system-integration/ | C | AV system integrator Kenya | A | duplicate body of /installation/ | Duplicate content | - | - | - | - | - | consolidate (301 to /solutions/installation/, owner approval) |
| /solutions/professional-audio/ | C | professional sound system Kenya | B | T: Professional Sound & PA Systems in Kenya; H1: Professional Audio | Teasers only | Professional PA & Sound Systems in Kenya | Line arrays, PA systems, mixers and microphones designed around your room, for churches, venues, schools and offices across Kenya. | Professional sound and PA systems in Kenya | /brands/ dB, A&H, Bose; CITAM, COVO | Service | expand |
| /solutions/church-worship-sound-systems/ | C | church sound system Kenya | C, D | T: Church Sound Systems & Acoustics in Kenya; H1: Church and Worship Sound Systems | Cost-driver FAQ, Chuka RT60 proof, Nairobi mention | Church Sound Systems & Acoustics in Kenya | Church PA systems, mixers, microphones and acoustic treatment for Kenyan churches, from growing congregations to cathedrals. Free site visit in Nairobi. | Church sound systems and acoustics in Kenya | CITAM, All Saints, PCEA Kahawa, (rebuilt) PCEA Chuka; /solutions/acoustics/; A&H, dB brand pages | Service + FAQPage (visible FAQs) | expand |
| /solutions/acoustics/ | C | acoustic treatment Kenya | D (treatment) | T: Acoustic Treatment & Soundproofing in Kenya; H1: Acoustics | Mixes treatment and isolation | Acoustic Treatment & Room Acoustics in Kenya | Acoustic design, measurement and treatment to cut echo and improve speech clarity in churches, halls, studios and offices across Kenya. | Acoustic treatment and room acoustics in Kenya | panels-ceilings, new sound-isolation, PCEA, RPF, West Nairobi | Service | keep&improve (retitle) |
| NEW /solutions/sound-isolation/ | C | soundproofing in Nairobi | D (isolation) | - | Missing | Soundproofing & Sound Isolation in Nairobi, Kenya | Stop sound passing between rooms and to neighbours: acoustic doors, partitions, floating floors and isolation design by Sound Creations, Nairobi. | Soundproofing and sound isolation in Kenya | Sarit Expo, RPF Rubavu, hospitality page, /solutions/acoustics/ | Service | create |
| /solutions/acoustic-panels-ceilings/ | C/T | acoustic panels Kenya | D, G | T: Acoustic Panels & Ceilings in Kenya; H1: Acoustic Panels and Ceilings | Selection guidance, project proof | Acoustic Panels & Acoustic Ceilings in Kenya | Acoustic wall panels and ceilings supplied and installed in Kenya, including Rockfon, Barrisol, Asona and Aid. Get advice on how much treatment you need. | Acoustic panels and ceilings in Kenya | Rockfon, Barrisol, Asona, Aid brand pages; PCEA Kahawa | Service | keep&improve |
| NEW /solutions/conferencing-boardroom-audio/ | C | conference room AV Kenya | E | - | Missing | Boardroom & Conference Room Audio in Kenya | Clear meeting-room audio for Kenyan offices: ceiling microphones, Bose Professional conferencing, DSP and boardroom acoustics, installed and supported. | Boardroom and conference room audio in Kenya | /brands/ Bose Professional, /solutions/acoustics/, /solutions/installation/ | Service | create |
| School & auditorium page (confirm slug) | C | school hall sound system Kenya | F | H1: School and Auditorium Sound Systems | URL unconfirmed | School Hall & Auditorium Sound Systems Kenya | Sound, acoustics and lighting designed together for school halls, chapels and auditoriums in Kenya. See our West Nairobi School project. | School hall and auditorium sound systems | West Nairobi School, /solutions/acoustics/ | Service | expand |
| /solutions/hospitality-commercial-audio/ | C | hotel sound system Kenya | F, D | T: Hotel, Club & Venue Sound Systems in Kenya | Strong; add sound-isolation link | Hotel, Club & Venue Sound Systems in Kenya | Multi-zone background music, club sound and venue acoustics for hotels, restaurants, clubs and event venues across Kenya. | Hotel, club and venue sound systems in Kenya | Playza, COVO, Sarit; sound-isolation page | Service + FAQPage | keep&improve |
| /distribution/ | C | pro audio distributor Kenya | G | T: Pro Audio & Acoustics Distributor in Kenya | Unverified "exclusive" elsewhere | Pro Audio & Acoustics Distributor in Kenya | Authorised Kenya distributor for Allen & Heath and Bose Professional, and supplier of dB Technologies, Shure, Rockfon and more. Trade enquiries welcome. | Pro audio and acoustics distribution in Kenya | All brand pages, /fane/ | Organization | keep&improve |
| /service/distribution-dealership/ | C | (duplicate of /distribution/) | G | old "– Sound creations ltd" title; "exclusive" claim | Duplicate | - | - | - | - | - | consolidate into /distribution/ (owner approval) |
| /service/consultancy/ | C | acoustic consultants Nairobi | A, D | T: Consultancy in Kenya | Thin deliverables | Acoustic & AV Design Consultancy in Nairobi | Acoustic surveys, RT60 and noise criteria, system design and BOQs for architects and project teams in Kenya, using EASE and SMAART. | Acoustic and AV design consultancy | /solutions/acoustics/, projects | Service | expand (merge /design-and-consulting/ copy) |
| /service/after-sale-services/ (confirm) | C | sound system maintenance Kenya | H | legacy | Outdated warranty text | Sound System Maintenance & Support in Kenya | Maintenance contracts, servicing, genuine spare parts and warranty support for sound and acoustic systems across Kenya, from our Nairobi team. | Maintenance, support and after-sales | brand pages, installation | Service | expand (rewrite) |
| /brands/ | C | pro audio brands Kenya | G | H1: Professional audio, acoustic and AV brands. | "11+ Global Brands" vs 12 listed; product grid hidden | Pro Audio & Acoustic Brands in Kenya \| Sound Creations | The professional audio, acoustic and AV brands Sound Creations supplies, installs and supports in Kenya, from Allen & Heath to Rockfon. | Professional audio and acoustic brands | each brand page, /distribution/ | ItemList (optional) | keep&improve |
| /brands/allen-heath/ (confirm) | C | Allen & Heath Kenya | G | n/o | Distributor proof | Allen & Heath Distributor in Kenya \| Sound Creations | Authorised Allen & Heath distributor in Kenya. Digital and analogue mixing consoles supplied, installed and supported, as at CITAM Buruburu. | Allen & Heath in Kenya | CITAM, church page, /distribution/ | Brand page; no Product schema | expand |
| /brands/bose-professional/ (confirm) | C | Bose Professional Kenya | G, E | n/o | Separate from consumer Bose | Bose Professional Distributor in Kenya | Sound Creations is Bose Professional's Kenya contact: installed loudspeakers, DSP and conferencing for offices, hotels and worship spaces. | Bose Professional in Kenya | conferencing page, hospitality | - | expand |
| /brands/db-technologies/ (confirm) | C | dB Technologies Kenya | G, B | n/o | - | dB Technologies Speakers & Line Arrays Kenya | dB Technologies line arrays and active loudspeakers designed and installed in Kenya since 2009, including CITAM Buruburu and COVO NBO. | dB Technologies in Kenya | CITAM, COVO, professional-audio | - | expand |
| /brands/shure/ (confirm) | C | Shure microphones Kenya | G | legacy /shure-microphones/ also indexed | No distributor claim allowed | Shure Microphones & Wireless Systems in Kenya | Shure wired and wireless microphones specified and installed for churches, conferences and schools in Kenya, with setup and frequency planning. | Shure microphones in Kenya | church, conferencing | - | expand; 301 /shure-microphones/ (owner approval) |
| /brands/rockfon/ (confirm) | C | Rockfon Kenya | G, D | n/o | - | Rockfon Acoustic Ceilings in Kenya \| Sound Creations | Rockfon stone wool acoustic ceilings designed and installed in Kenya, as at PCEA Kahawa Farmers and PCEA Chuka churches. | Rockfon acoustic ceilings in Kenya | PCEA projects, panels-ceilings | - | expand |
| /projects/ | C | sound and acoustic projects Kenya | all | T: Projects – Sound creations ltd (old suffix) | Title template | Sound & Acoustic Projects in Kenya \| Sound Creations | Church, school, venue and nightclub sound and acoustic projects by Sound Creations in Kenya and Rwanda, with the challenge, solution and result. | Our projects | each solution page | CollectionPage | keep&improve |
| /projects/{slug}/ | C | project name + sound/acoustics | - | e.g. "PCEA Kahawa Farmers Church – Sound & AV Installation" | Inconsistent suffixes | {Project}: {scope} \| Sound Creations | One-line challenge/result. | Project name | solution + brand pages | Article or CreativeWork (no Review) | keep&improve |
| NEW /projects/pcea-chuka/ | C | church acoustics Kenya | C, D | legacy post /acoustics-treatment-at-p-c-e-a-in-chuka-town/ | Strong data on legacy URL | PCEA Chuka Church Acoustics: RT60 3.3s to 1.1s | How 740 m2 of Rockfon Arctic cut reverberation at PCEA Chuka from 3.3 to 1.1 seconds and restored speech clarity. | PCEA Chuka church acoustic treatment | church, acoustics, Rockfon | - | create (owner decides on legacy post redirect) |
| /about/ | N | audio visual company Nairobi | A | T: About Us \| Audio Visual Company in Nairobi | Good | keep | keep | keep | /the-team/, /projects/ | Organization | keep |
| /contact/ | N/T | Sound Creations contact | I | T: Contact – Sound creations ltd | Old suffix | Contact Sound Creations \| Westlands, Nairobi | Visit Sound Creations at Mpaka Plaza, Mpaka Road, Westlands, Nairobi, or call +254 715 754 758. Open Mon-Fri 9-5:30, Sat 9-1:30. | Contact us | consultation | LocalBusiness | keep&improve |
| /request-a-consultation/ | T | free site visit sound system | all | good | - | keep | keep | keep | - | - | keep |
| /fane/ | C | FANE speakers Kenya | G | T: FANE Loudspeakers in Kenya & Africa | Product pages still reachable | keep | keep | keep | /brands/ | - | keep |
| /videos/ | I | - | H | 3 videos | thin | keep | - | keep | - | VideoObject per video | keep |
| /testimonials/ | N | Sound Creations reviews | - | live | - | Sound Creations Reviews & Client Testimonials | - | What our clients say | homepage | none (no self-served Review schema, per WORK-LOG) | keep |

Character counts were checked for the recommended titles (all <= 60) and
metas (all <= 155) at the time of writing; recheck after any edit.

## AEO buyer questions (and which page answers them)

1. How much does a church sound system cost in Kenya? - church page (cost drivers, not prices)
2. Why does our church sound echoey even with good speakers? - church page (exists) + /solutions/acoustics/
3. What is the difference between acoustic treatment and soundproofing? - /solutions/acoustics/ and /solutions/sound-isolation/
4. How long does a church or hall sound installation take? - /solutions/installation/
5. Do you offer a free site visit in Nairobi? - /request-a-consultation/ + installation
6. What size PA system do I need for 200 / 500 / 1,000 people? - /solutions/professional-audio/
7. Line array or point-source speakers for a church? - /solutions/professional-audio/
8. What reverberation time should a church or lecture hall have? - /solutions/acoustics/ (cite PCEA Chuka 1.1 s result)
9. Are acoustic panels or an acoustic ceiling better for a large hall? - /solutions/acoustic-panels-ceilings/
10. How much acoustic treatment does a room need? - /solutions/acoustic-panels-ceilings/
11. Can you stop sound from our bar or club leaking to neighbours? - /solutions/sound-isolation/ + hospitality
12. Can different hotel areas play different music at different volumes? - hospitality (exists)
13. How do I fix echo in a boardroom on Teams/Zoom calls? - new conferencing page
14. Is Sound Creations an authorised Allen & Heath / Bose Professional distributor in Kenya? - brand pages (link manufacturer listing)
15. How do I know my Shure microphone is genuine in Kenya? - /brands/shure/ + after-sales (refer to Shure authorised channel)
16. Can you work with the equipment we already have? - church (exists) + installation
17. Do you train our church sound team / volunteers? - church (exists) + after-sales
18. Do you offer maintenance contracts after installation? - after-sales
19. Do you supply equipment to other installers and resellers? - /distribution/
20. Do you work with architects at design stage? What do we receive? - /service/consultancy/
21. Do you install outside Nairobi? - /about/ or installation (state only verified areas)
22. Can you design sound for a school hall that is also used for worship? - school page (West Nairobi School)
23. What does a Rockfon acoustic ceiling do in a church? - /brands/rockfon/ + PCEA projects

## Next actions (for the dev/content backlog)

1. Owner: confirm positioning vs VTECH (same building, same SERPs).
2. Owner: approve consolidation of legacy duplicates (list in COMPETITORS.md opportunity 7) and the no-product treatment of /product/ URLs.
3. Owner: remove/replace "certified exclusive dealers" wording unless manufacturer confirmation exists; check the +254 728135246 number on /shure-microphones/.
4. Content: create sound-isolation, conferencing, PCEA Chuka case study; expand installation, church, consultancy, after-sales, brand pages.
5. Data: pull Kenya volumes from Keyword Planner and positions from Search Console, then re-score the Pri column.
