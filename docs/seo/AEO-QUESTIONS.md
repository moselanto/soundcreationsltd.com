# AEO question map: Terry's "WEB AEO" document (received 10 Nov 2026)

Source: "Question-Based SEO, AEO & GEO Keywords for Website" (Terry Kiio,
Marketing Manager), 12 groups, about 110 questions. This file maps every group
to one target page, marks what the live site already answers, and gives
answers ready to paste in for the most important gaps.

Rules for these answers (same as every other SEO doc here):
- Answer first, in 40-80 words, so AI assistants can quote it.
- Only facts the owner has confirmed or that are already on the site. **No
  prices** (company decision): cost questions are answered with what the cost
  depends on, plus "we quote after a site visit".
- **Products are not showcased**: "which model is best" questions are answered
  at the level of the application and the product range, never with a product page.
- Anything not confirmed is marked **[CONFIRM]** and must not be published
  until Agnes or Moses confirms it.

Status key: **Live** = already answered on the site · **Gap** = add (answer below)
· **Owner** = needs a fact or decision first · **Code** = needs a template change

## Status (updated 10 Nov 2026)

| Item | Status |
| --- | --- |
| B1 FAQ box 10 slots, B2 FAQs on About | **Live** (Core 0.5.39, `9fb4f33`) |
| A2, A3, A24, A25 (Professional Audio) | **Live** |
| A4-A7 (Church) | **Live** |
| A13-A14 (Conferencing) | **Live** |
| A15-A17 (`/solutions/hospitality-commercial-audio/`) | **Live** |
| A19-A20 (`/solutions/education-auditorium-sound-systems/`) | **Live** |
| A21-A23 (Acoustics) | **Live** |
| A27 on Allen & Heath, Bose Professional, FANE, Shure, dB Technologies | **Live** |
| A33-A35 (After-Sale) | **Live** |
| A36-A42 (About) | **Live** |
| Single-item FAQ on `/distribution/` | **Live** |
| A1, A18 | Skipped: near-duplicates of existing FAQs |
| A26 | Waiting: Professional Audio is full (10/10); put it on a live-sound/lighting page |
| A8-A12 mosque page, A28-A31 architects/contractors page | Waiting for the owner's go-ahead |
| A32 servicing interval, B4-B6 | Waiting for owner answers |


---

## 0. Blockers to clear first

| # | Blocker | Fix |
| --- | --- | --- |
| B1 | The FAQ box allows only **6 questions per page** (`sc_faq_slots()`), and several target pages are already full (church, distribution, conferencing). | Code: raise it to 10 in `sound-creations-core/includes/seo-faq.php`. Nothing else changes. |
| B2 | **About** and **Contact** do not show FAQs (the template never prints them, so the FAQPage schema is also held back, which is correct). Group 12 needs About. | Code: print `sc_faq_render()` on `page-about.php` and add it to the `sc_faq_is_rendered()` template list. |
| B3 | There is **no mosque page**: mosque questions currently sit in one church FAQ. | Content: new solution page `/solutions/mosque-sound-systems/` (capability only; the owner confirmed mosques are served, but no mosque project is published). |
| B4 | **Lighting**: Terry's signature lists Chauvet Lighting; the site has no lighting brand page. | Owner: confirm the lighting brands and whether lighting is supplied *and* installed. |
| B5 | **Ortega Guitars and Meinl** (group 9) are not on the site. Musical instruments are a new category. | Owner: confirm that Sound Creations is a dealer, then decide whether to add brand pages. |
| B6 | Brands in Terry's signature with no brand page: **DiGiCo, Nexo, Nord, Chauvet**. | Owner: confirm current dealerships. |

---

## 1. Group-by-group map

| Group | Target page | Already live | Gaps to add |
| --- | --- | --- | --- |
| 1. General AV | Homepage (How to buy), `/solutions/professional-audio/`, `/distribution/` | Who installs (homepage intro), PA cost, which PA, brands, buy a single item (FAQ added 10 Nov) | How to choose a sound system; what to consider before installing; pro audio vs AV (answers A1-A3) |
| 2. Churches | `/solutions/church-worship-sound-systems/` (FAQ box full: **B1**) | Cost, best PA, echo, live streaming, volunteer training, mosques | Feedback, even coverage, preaching and choir mics, full equipment list (A4-A7) |
| 3. Mosques | **New page (B3)** | One church FAQ only | Every question in the group (A8-A12) |
| 4. Corporate / conference | `/solutions/conferencing-boardroom-audio/` | Video-call echo, ceiling vs table mics, Teams/Zoom, upgrades, Bose, room acoustics | Equipment for a modern room, multi-room audio/video, cost (A13-A14) |
| 5. Hotels and venues | Hospitality solution page | Section added 19 Oct | Conference hall, ballroom, restaurants/lounges, upgrading (A15-A17) |
| 6. Schools / auditoriums | Education solution page | Section added 19 Oct | Assembly hall, lecture hall, auditorium design (A18-A20) |
| 7. Acoustics | `/solutions/acoustics/`, `/solutions/sound-isolation/` | Treatment vs soundproofing, RT60, how much treatment, soundproofing cost | Echo in a large hall, panels for auditoriums, when to include acoustics in a build (A21-A23) |
| 8. Lighting and live sound | `/solutions/professional-audio/` (+ a lighting page after **B4**) | Live music and speech FAQ | Live sound setup, monitors, sub vs full-range (A24-A26); lighting **Owner** |
| 9. Brands | Brand pages (Bose, Shure, Allen & Heath, dB Technologies, FANE) | "<Brand> in Kenya" sections (19 Oct) | One "Where can I buy X in Kenya?" FAQ per brand page (A27); model questions answered at range level only; Ortega/Meinl **Owner (B5)** |
| 10. Architects / contractors | **New page** `/solutions/av-design-for-architects-and-contractors/` or `/service/consultancy/` | Distribution FAQ "Do you supply contractors" | Every question in the group (A28-A31) |
| 11. Buying and support | `/service/after-sale-services/`, `/solutions/installation/` | Warranty, faults, spares, non-supplied repairs, installation scope | Servicing frequency, feedback/distortion, upgrades, choosing a supplier (A32-A35) |
| 12. About Sound Creations | `/about/` (**B2**) | Company summary in the About body | Seven entity FAQs (A36-A42), once B2 is in place |

---

## 2. Ready-to-paste answers for the gaps

### General (homepage / professional audio)

**A1. How do I choose the right sound system for my facility?**
Start with the room, not the equipment: its size, shape, ceiling height and
finishes, how many people it holds, and whether it is used for speech, music
or both. Sound Creations begins with a site visit and an acoustic assessment,
then designs the system around the room and recommends equipment from the
brands we supply, so you pay for coverage and clarity rather than extra boxes.

**A2. What should I consider before installing a commercial sound system?**
Agree on what the system must do (speech, music, live streaming, background
music), how the room sounds today, where loudspeakers and cables can go, who
will operate it, and who will support it after handover. Fixing echo first
often matters more than buying bigger speakers. Our team covers design,
supply, installation, commissioning, training and after-sale support.

**A3. What is the difference between professional audio and audiovisual systems?**
Professional audio covers sound only: microphones, mixers, processors,
amplifiers and loudspeakers. An audiovisual (AV) system brings sound, video,
displays, conferencing and control together so they work as one. Sound
Creations designs and installs both, from a church PA to an integrated
boardroom or conference-centre system.

### Churches (needs B1)

**A4. How can I reduce microphone feedback in a church?**
Feedback happens when a microphone picks up the loudspeakers it feeds. The
lasting fixes are loudspeakers aimed at the congregation rather than the
stage, suitable microphones held close to the mouth, correct gain and
processing, and acoustic treatment where the room is very reflective. We
diagnose feedback on site and correct the design, not just the volume.

**A5. How do I distribute sound evenly throughout a church?**
Even coverage comes from loudspeaker choice and placement: a main system for
the front, and delay or fill loudspeakers for balconies, overflow areas and
the back of long halls, time-aligned with a processor. We map coverage during
design and verify it with measurements at commissioning.

**A6. Which microphones are best for preaching and singing?**
For preaching, a headset or lapel microphone keeps the voice steady as the
speaker moves; for worship leaders and choirs, handheld vocal microphones and
choir microphones placed for the group. The right mix depends on the room and
the service format, and we recommend it during design.

**A7. What equipment is needed for a complete church sound system?**
A typical system has microphones (wired or wireless), a digital mixer, a
processor (DSP), amplification, main loudspeakers with fills or delays where
needed, monitors for musicians, and a feed for live streaming. Large or very
reflective churches often also need acoustic treatment. We design the full
system around your building and services.

### Mosques (new page, B3)

**A8. How can I achieve clear Qur'an recitation and khutbah audio in a mosque?**
Clarity in a mosque depends on controlling reverberation from hard floors,
domes and high ceilings, and on loudspeakers that put sound where worshippers
sit rather than on the walls. We assess the space, then design the
loudspeaker layout, processing and, where needed, acoustic treatment for
clear recitation, khutbah and announcements.

**A9. Should a mosque use a distributed loudspeaker system?**
In many mosques, yes. Several smaller loudspeakers close to the listeners
give more even, intelligible sound in large or tall prayer halls than a few
loud speakers at the front. The best layout depends on the hall's shape and
on the women's and overflow areas, which we cover in the design.

**A10. How can I reduce echo and reverberation in a mosque?**
By combining acoustic treatment that suits the interior (absorptive panels,
ceiling treatment and soft finishes chosen with the architecture) with a sound
system that does not over-excite the room. We measure reverberation (RT60)
before and after, so the improvement can be checked.

**A11. What is the role of a digital mixer and DSP in a mosque sound system?**
The mixer balances the imam's and muezzin's microphones; the DSP (digital
signal processor) applies equalisation, delay and feedback control and keeps
levels consistent, so the system sounds the same at every prayer with little
operator effort.

**A12. Who provides professional audio visual solutions for mosques in Kenya?**
Sound Creations, based at Mpaka Plaza, Westlands, Nairobi since 2004, designs,
supplies, installs and supports sound systems and acoustic treatment for
mosques and other places of worship, from the first site visit to handover.

### Corporate (conferencing page)

**A13. What equipment is needed for a modern conference room?**
Usually: ceiling or table microphones, loudspeakers, a DSP with echo
cancellation, a display or projector, a camera, a connection for laptops and
video-conferencing platforms, and simple control. Room acoustics affect call
quality as much as the equipment, so we look at both.

**A14. How can I distribute audio and video across multiple meeting rooms?**
With networked audio and video distribution, a central processor and
room-by-room control, so rooms can work alone or be joined for larger events.
We design the system around how your rooms are booked and used.

### Hotels and venues (hospitality page)

**A15. Which sound system is best for a hotel conference hall?**
One that works for both speeches and events: even speech coverage, wireless
microphones, inputs for presenters and bands, and zoning so the hall can be
divided. The design depends on the hall's size and on partition walls, which
we assess on site.

**A16. Which speakers are suitable for hotel restaurants and lounges?**
Discreet ceiling or wall loudspeakers that cover the space evenly at low
volume, with zones so each area can have its own music and level. We match
the loudspeakers to the interior design.

**A17. What should I consider when upgrading a hotel's existing AV system?**
What still works and can be kept, what guests and event clients now expect
(wireless presenting, video conferencing, streaming), and how staff operate
it. We can upgrade in stages instead of replacing everything.

### Schools and auditoriums (education page)

**A18. Which sound system is suitable for a school assembly hall?**
A system built for clear speech first: loudspeakers that cover every row,
reliable wireless microphones and simple controls for staff. Assembly halls
are often echoey, so acoustic treatment is part of the design. West Nairobi
School is among our completed education projects.

**A19. What equipment is needed for a university lecture hall?**
Lecturer microphones, loudspeakers for even speech coverage, a projector or
displays, inputs for laptops, lecture-capture or streaming where needed, and
easy control. We integrate the sound and the display equipment so they work
together.

**A20. What should I consider when designing an auditorium sound system?**
The room's acoustics, seating layout and balconies, the mix of speech and
performance, stage monitoring, and future uses. Planning acoustics and sound
together, ideally early in the building design, avoids expensive fixes later.

### Acoustics

**A21. How can I reduce echo in a large hall?**
Measure the reverberation time (RT60), then add the right amount of absorption
on the right surfaces (walls, ceiling, rear wall) and break up parallel
surfaces. Turning the sound system up makes echo worse. We measure, design the
treatment and verify the result.

**A22. Which acoustic panels are suitable for auditoriums?**
It depends on the frequencies to control and on the interior finish: fabric
panels, wood or perforated panels, acoustic ceilings and stretch-ceiling
systems are all used. Sound Creations works with acoustic brands including
Rockfon, Barrisol and Asona, and selects materials to the measured need.

**A23. When should acoustic treatment be included in a building project?**
At the design stage, before finishes are fixed. Acoustics planned with the
architect cost less and look better than panels added after the building is
in use. We work with architects and contractors from the early drawings.

### Live sound

**A24. What equipment is required for a professional live sound setup?**
Microphones and DI boxes, a mixing console, processing, a main PA with
subwoofers, stage monitors, and the cabling and power to connect them. Scale
depends on the venue and audience.

**A25. How do I choose stage monitors for a live performance?**
By stage size, volume and the performers' needs: wedge monitors for most
stages, side fills for larger ones, and in-ear monitoring where stage volume
must be kept low.

**A26. What is the difference between a subwoofer and a full-range speaker?**
A full-range loudspeaker reproduces most of the audible range; a subwoofer
reproduces only the lowest frequencies (bass). Live music and events usually
combine both; speech-only rooms often do not need subwoofers.

### Brands (one per brand page)

**A27 (template). Where can I buy genuine <Brand> products in Kenya?**
From Sound Creations, Mpaka Plaza, Mpaka Road, Westlands, Nairobi. Send us the
model on WhatsApp or call +254 715 754 758 for a price and availability, or
visit the showroom.
- Allen & Heath and Bose Professional: may add "listed by the manufacturer
  for Kenya" (verified 19 Oct 2026).
- FANE: may add "the authorised FANE partner for East Africa".
- Shure: say **dealer**, not distributor (standing decision).

### Architects and contractors (new page)

**A28. How early should AV planning begin in a building project?**
At concept or early design stage, alongside structure and services, so that
cable routes, power, ceiling voids, loudspeaker positions and acoustic
finishes are designed in rather than added later.

**A29. What information is required before designing a building's sound system?**
Drawings (plans, sections, reflected ceiling plans), the room uses and
capacities, finish schedules, and the client's requirements for sound, video
and control. A site visit follows once the structure is up.

**A30. How can AV systems be integrated into interior design?**
By choosing loudspeakers, panels and displays with the interior designer:
recessed or colour-matched loudspeakers, acoustic finishes that double as
décor, and concealed cabling.

**A31. How can contractors coordinate acoustic treatment with ceiling and wall finishes?**
By agreeing on the acoustic specification before ceilings and walls are
built, then sequencing installation with the finishing trades. We provide
acoustic design and work on site with contractors.

### Buying and support

**A32. How often should professional audio systems be serviced?**
[CONFIRM the interval the company recommends.] A periodic check of
microphones, cables, amplifiers and settings prevents most failures during
services and events. Contact us to arrange servicing.

**A33. Why does my sound system produce feedback or distorted audio?**
Usually incorrect gain, microphones too close to loudspeakers, poor
loudspeaker placement, damaged cables or an overloaded amplifier. We diagnose
on site, including systems we did not supply.

**A34. How can I upgrade an existing sound system without replacing everything?**
Keep what performs well and replace the weak links, often the processing,
microphones or loudspeaker layout. We assess the system first and recommend
a staged upgrade.

**A35. How do I choose a reliable professional audio equipment supplier in Kenya?**
Check for manufacturer authorisation, genuine stock and warranty, in-house
technical support and spare parts, and completed projects you can verify.
Sound Creations has served clients from Nairobi since 2004 and has completed
850+ projects.

### About Sound Creations (needs B2)

**A36. Who is Sound Creations Ltd?** A professional audio, acoustics and
audiovisual company founded in 2004 and based at Mpaka Plaza, Westlands,
Nairobi, with offices in Kigali, DR Congo and Dubai. It designs, supplies,
installs and supports sound, acoustic and AV systems, and has completed 850+ projects.

**A37. What services does Sound Creations provide?** Consultancy and design,
distribution and dealership, integration (installation, commissioning,
training) and after-sale services.

**A38. Where is Sound Creations located?** Mpaka Plaza, Mpaka Road,
Westlands, Nairobi. Open Mon-Fri 9:00-17:30 and Sat 9:00-13:30.

**A39. Which industries does Sound Creations serve?** Churches, mosques and
other places of worship, schools and universities, hotels and conference
centres, corporate offices, venues and live events.

**A40. Which brands are available through Sound Creations?** Including Bose
Professional, Allen & Heath, dB Technologies, Shure, Midas, Behringer, FANE,
Rockfon, Barrisol, Asona and Sommer Cable. [CONFIRM before adding DiGiCo,
Nexo, Nord or Chauvet (B6).]

**A41. What projects has Sound Creations completed?** Including CITAM
Buruburu, All Saints Cathedral, Sarit Expo Centre, West Nairobi School, PCEA
Kahawa Farmers Church and RPF Rubavu Multipurpose Hall (Rwanda). See /projects/.

**A42. How can I request a site assessment?** Use Request a Consultation on
the website, call or WhatsApp +254 715 754 758, or email
info@soundcreationsltd.com.

---

## 3. Order of work

1. Code B1 + B2 (FAQ slots to 10; FAQs on About). One commit, then upload.
2. wp-admin: paste A1-A7 and A13-A35 into the target pages' FAQ boxes.
3. Publish the mosque page (A8-A12) and the architects/contractors page (A28-A31).
4. After B2 is live: About FAQs A36-A42.
5. Owner answers B4-B6 and A32, then the lighting page and any new brand pages.
6. Search Console: request indexing for every changed page; re-run the Rich
   Results Test; repeat the AI visibility check from 19 Oct about 4 weeks later.
