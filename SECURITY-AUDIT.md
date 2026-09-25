# Security Audit

**Scope:** first-party code in this repository — the `soundcreations` theme, the
`soundcreations-child` theme, and the `sound-creations-core` and
`sound-creations-enquiries` plugins.

**Out of scope:** WordPress core, third-party plugins, the hosting environment,
TLS configuration, DNS, and the WordPress database.

This document records the controls that exist in the code, why each one is
there, and the gaps that remain open. It reflects the code as committed.

---

## 1. Summary

The site takes an unusually deliberate approach for a WordPress build: no page
builder, no e-commerce, no third-party form plugin, and comments removed
entirely. Each of those is one fewer attack surface. On top of that, the theme
carries a hardening module and the enquiry plugin carries a dedicated abuse-control
module that runs before any submission is stored, mailed or written to disk.

The highest-value assets are (a) the stored enquiries, which hold customer PII,
and (b) `wp-login.php`, which on any WordPress install is the most attacked
endpoint in existence. Both have specific controls.

| Area | Assessment |
| --- | --- |
| Public form abuse | Strong — layered, ordered cheapest-first |
| File upload | Strong — allowlist, content-type verification, unguessable names |
| PII handling | Strong — restricted capabilities plus automatic expiry |
| Authentication | Good — throttled, non-hinting errors; MFA is outside this repo |
| Enumeration | Good — author scans, REST users and REST media all blocked |
| Response headers | Good baseline; CSP is deliberately narrow |
| Mail header injection | Addressed explicitly |
| Supply chain / CI | **Gap** — no automated checks before deploy |
| Monitoring | **Gap** — no durable error or intrusion logging |

---

## 2. Attack surface reduction

| Control | Where | Rationale |
| --- | --- | --- |
| XML-RPC disabled | `inc/hardening.php` | Primary brute-force amplification and pingback-DDoS vector; the site uses none of it |
| Pingback methods unset | `inc/hardening.php` | Removes the DDoS-reflection methods even if XML-RPC is re-enabled elsewhere |
| `X-Pingback` header stripped | `inc/hardening.php` | Stops advertising the endpoint |
| Comments fully disabled | `inc/hardening.php` | Closed via `comments_open`/`pings_open`, existing comments hidden, direct POSTs to `wp-comments-post.php` rejected with 403, comment support removed from every post type, REST comment routes removed, comment feeds 403'd, admin screens and menus removed and redirected |
| File editor disabled | `functions.php` **and** `inc/hardening.php` | `DISALLOW_FILE_EDIT` removes the standard post-compromise pivot from "admin session" to "arbitrary PHP execution". Defined in both places so it holds even if one is unloaded |
| `wp_head` cruft removed | `inc/hardening.php` | Generator tag, RSD, WLW manifest, shortlink and adjacent-post links: version disclosure and dead surface |
| Core version stripped from asset URLs | `inc/hardening.php` | Removes WordPress version fingerprinting while keeping first-party filemtime cache-busting |
| Emoji and oEmbed scripts removed | `inc/hardening.php` | Inline script and request removal; smaller surface and faster pages |
| No page builder, no WooCommerce, no form plugin | Architecture | Each avoided dependency is an avoided CVE stream |

## 3. Authentication

**Login brute-force throttle** (`inc/hardening.php`): the `authenticate` filter
runs at priority 5 and **refuses the attempt before any password is checked**, so
a locked-out IP costs no hashing work. Five failures from one IP buys a
15-minute lockout; fifteen buys an hour. A successful login clears the counter
immediately via `wp_login`.

**Generic login errors**: `login_errors` always returns "Invalid login details.
Please try again." — no username-versus-password hinting, which otherwise turns
the login form into a username oracle.

**IP spoofing resistance** (`sc_client_ip()`): `X-Forwarded-For`,
`CF-Connecting-IP` and `X-Real-IP` are trivially spoofable, so they are honoured
**only** when the connecting peer is an address the site owner has explicitly
declared through the `sc_trusted_proxies` filter. Without this, a bot could
rotate a header value and defeat the throttle entirely. Counter keys are
`md5( ip . wp_salt('nonce') )`, so raw IPs are never written into transient names.

> **Deployment note.** If this site sits behind Cloudflare or a load balancer,
> the proxy addresses **must** be declared via `sc_trusted_proxies` (and
> `sc_enq_trusted_proxies`). Otherwise every visitor resolves to the proxy IP and
> all rate limiting collapses into one shared bucket.

## 4. Enumeration

| Vector | Control |
| --- | --- |
| `?author=N` scans | Logged-out requests carrying an `author` query var are 301'd to the homepage |
| `/wp-json/wp/v2/users` | Route removed for logged-out visitors |
| `/wp-json/wp/v2/users/<id>` | Route removed for logged-out visitors |
| `/wp-json/wp/v2/media` | Route removed for logged-out visitors, so enquiry attachments cannot be listed even though their names are unguessable |
| `/wp-json/wp/v2/comments*` | All comment routes removed |

## 5. Response headers

Set through the `wp_headers` filter:

| Header | Value | Protects against |
| --- | --- | --- |
| `X-Content-Type-Options` | `nosniff` | MIME confusion |
| `X-Frame-Options` | `SAMEORIGIN` | Clickjacking (legacy clients) |
| `Referrer-Policy` | `strict-origin-when-cross-origin` | Referrer leakage |
| `Permissions-Policy` | `geolocation=(), microphone=(), camera=()` | Unwanted device access |
| `Cross-Origin-Opener-Policy` | `same-origin` | Cross-origin window attacks |
| `X-Permitted-Cross-Domain-Policies` | `none` | Legacy Flash/PDF policy abuse |
| `Content-Security-Policy` | `frame-ancestors 'self'; object-src 'none'; base-uri 'self'` | Clickjacking, plugin embedding, `<base>` hijacking |
| `Strict-Transport-Security` | `max-age=31536000; includeSubDomains` (HTTPS only) | Protocol downgrade |

**On the CSP.** It sets no `script-src` or `style-src`. This is a documented,
deliberate limitation: the theme ships inline scripts (the pre-paint theme
switch, speculation rules) and the Seraphinite Accelerator plugin injects its
own inline CSS and JS, so a strict policy would break the site. The three
directives that *are* set close real attack paths with zero risk of blocking
legitimate assets. Tightening this is tracked in section 9.

## 6. Enquiry abuse controls

The ordering in `sc_enq_handle()` is itself a control: the cheap checks run
first so that a bot cannot make the server do expensive work by submitting
garbage.

| Layer | Detail |
| --- | --- |
| Attempt throttle | 12 attempts / 10 minutes per IP, counted on **every** attempt including ones that go on to fail validation |
| Nonce | `sc_enquiry_submit`, verified before any processing |
| Form-type allowlist | Unknown `sc_type` rejected |
| Honeypot | `sc_website` field; filled means bot, answered with success |
| Time trap | Submitted under 3 seconds after render is rejected |
| Stale render stamp | Older than 24 hours is a replayed or scripted payload |
| User-Agent check | A real browser always sends one |
| Volume cap | 5 submissions / hour per IP |
| Consent gate | Enforced server-side on forms that require it |
| Sanitisation | Per field type: `sanitize_textarea_field`, `sanitize_email`, `sanitize_text_field`; required fields and email validity enforced |
| Spam scoring | Additive; ≥ 5 rejected. See below |
| Duplicate suppression | Fingerprint of type + payload per IP, 3-hour window |

**Spam scoring** (`sc_enq_spam_score()`) weighs link stuffing (2, plus 3 more at
three or more links), BBCode or raw HTML in a plain-text field (3), known spam
vocabulary (3), bulk Cyrillic or CJK in an English-language B2B form (3),
disposable sender domains (4), a URL or `@` inside the name field (3), and a
long body containing no spaces at all (3). It is additive rather than a single
hard rule so that one false positive cannot block a legitimate enquiry on its own,
and is filterable via `sc_enq_spam_score`.

**Why spam gets a success response.** Rejected spam and duplicates are redirected
as `sc_sent=1` but never stored and never mailed. A bot that sees failure retries;
one that sees success moves on. Crucially, staff are never trained to ignore a
noisy queue — the security value of a clean inbox is that people still read it.

## 7. File uploads

Only the Dealer application accepts a file. `sc_enq_handle_upload()` enforces,
in order:

1. `UPLOAD_ERR_OK` and `is_uploaded_file()` — no path-supplied files.
2. Size between 1 byte and **5 MB**.
3. Outright rejection of double extensions and executable tails by regex:
   `.php`, `.php7`, `.phtml`, `.phar`, `.js`, `.htm`, `.html`, `.htaccess`,
   `.sh`, `.exe`, `.svg` — anywhere in the name, which kills `shell.php.pdf`.
   SVG is excluded because it is an XSS vector, not because it is executable.
4. `wp_check_filetype_and_ext()` against an explicit allowlist of PDF, DOC,
   DOCX, JPEG and PNG.
5. An **independent `finfo` content-type check** of the file's real bytes, so a
   renamed payload with a valid-looking extension is still rejected.
6. A randomly generated filename: `enquiry-YYYYMMDD-{16 random chars}.{ext}`.
   The URL is emailed to staff and never listed publicly, so uploads are neither
   guessable nor enumerable — and with `/wp-json/wp/v2/media` closed to
   logged-out visitors, not listable either.

## 8. PII and privacy

**Storage.** Enquiries hold name, email, phone and IP. With WordPress's default
`post` capability type, any Contributor, Author or Editor could read every lead
the site has ever received. The `sc_enquiry` post type therefore uses a dedicated
capability set (`edit_sc_enquiry`, `read_sc_enquiry`, `delete_sc_enquiry` and
their plural forms) granted only to administrators. `create_posts` is mapped to
`do_not_allow` on purpose — enquiries may only ever arrive through the public
form; `wp_insert_post()` does not check capabilities, so submissions are
unaffected while hand-authoring in wp-admin is blocked.

The type is also `public => false` and `exclude_from_search => true`, so leads
never surface in site search or on the front end.

Capability syncing is version-gated (`sc_enq_caps_version`) so the role object is
only rewritten when the capability list actually changes.

**Retention.** A daily `sc_enq_daily_purge` cron permanently deletes enquiries
older than **24 months** — long enough to outlast any live sales cycle, short
enough that the site is not an indefinite PII store. Filterable via
`sc_enq_retention_months`; returning 0 disables purging. The cron is unscheduled
on plugin deactivation.

**Consent.** The Consultation and Contact forms require an explicit consent
checkbox, enforced server-side rather than only in the browser.

## 9. Mail security

**Header injection.** The `Reply-To` display name is attacker-supplied.
`sanitize_text_field()` already strips newlines, but `sc_enq_header_safe()` adds
defence in depth: it replaces CR, LF, tab and their URL-encoded forms, strips
`<`, `>`, `"` and `;`, and truncates to 70 characters. The address half is
passed through `sanitize_email()` and `is_email()` before use.

**Sender identity.** `mail.php` filters `wp_mail_from` and `wp_mail_from_name` so
all site mail originates from the Sound Creations address on the site's own
domain, keeping SPF and DKIM alignment intact. Mis-aligned senders are a
deliverability problem and a phishing-pretext problem at the same time.

**Body format.** Notifications are sent as `text/plain`, so injected markup in a
submission cannot render as HTML in a staff mail client.

## 10. Output and input handling

- Every PHP file opens with an `ABSPATH` guard, preventing direct execution.
- Output is escaped at the point of use: `esc_html()`, `esc_attr()`, `esc_url()`,
  `esc_html__()`/`esc_attr__()` for translated strings.
- The one unescaped echo is the inlined first-party critical CSS, read from files
  in the theme directory, marked with a `phpcs:ignore` and a stated reason. It
  accepts no user input.
- Redirects use `wp_safe_redirect()` throughout, so an attacker cannot turn the
  enquiry endpoint into an open redirect.
- Admin settings use the Settings API with explicit `sanitize_callback`s; the
  routing screen validates every address through `sanitize_email()` and drops
  anything that fails.
- Admin-side rendering is gated on `current_user_can( 'manage_options' )`.

## 11. Open items and recommendations

Ordered by value, highest first.

| # | Item | Why it matters | Suggested action |
| --- | --- | --- | --- |
| 1 | **No CI or automated checks** | Nothing catches a PHP fatal, a coding-standards regression or an accidental secret before it reaches production | Add a workflow running `php -l` across the tree plus PHPCS with the WordPress ruleset on every pull request |
| 2 | **No error or intrusion monitoring** | Failures and attack patterns are invisible; the login throttle records nothing durable | Add error monitoring, and log lockouts and spam rejections to a retained store |
| 3 | **Trusted proxies likely undeclared** | Behind a CDN, every rate limit silently degrades to one global bucket | Declare the proxy addresses via `sc_trusted_proxies` and `sc_enq_trusted_proxies` in a small site plugin, and verify the resolved IP on a real submission |
| 4 | **CSP has no `script-src` / `style-src`** | XSS is only partially mitigated | Remove or externalise remaining inline scripts, then adopt a nonce-based policy; re-evaluate the accelerator plugin's inline injection |
| 5 | **Duplicate `sc_enquiry` registration** | Core registers it with `capability_type => 'post'`; the plugin registers a restricted version only when Core has not. Ordering decides which wins | Consolidate into one definition that always uses the restricted capabilities |
| 6 | **Rate limiting uses transients** | On an object cache without persistence, counters can be evicted early and limits weakened | Confirm the caching backend, or move counters to a dedicated table if eviction is observed |
| 7 | **Version constant drift** | `SC_CORE_VERSION` is `0.5.24` while the plugin header reads `0.5.25`; version-gated migrations key off constants | Single-source the version and add a check |
| 8 | **No two-factor authentication** | Administrators can read every stored lead | Enable 2FA for all administrator accounts (site configuration, outside this repo) |
| 9 | **Uploads served from the web root** | Accepted files land under `wp-content/uploads`, protected by unguessable names rather than by access control | Consider serving attachments through an authenticated handler, or deny direct execution in the uploads directory at the web-server level |
| 10 | **No dependency or secret scanning** | Third-party plugins are the usual WordPress compromise route | Enable automated dependency alerts and secret scanning on the repository |

## 12. Operational checklist

Not enforced by code, but required for the controls above to hold:

- [ ] HTTPS enforced site-wide (HSTS only emits when SSL is detected).
- [ ] `sc_trusted_proxies` and `sc_enq_trusted_proxies` declared if behind a CDN.
- [ ] Administrator accounts limited in number and protected with 2FA.
- [ ] `wp-config.php` salts rotated after any suspected exposure — the rate-limit
      and lockout keys are derived from `wp_salt( 'nonce' )`.
- [ ] WordPress core and all third-party plugins kept current.
- [ ] Database and uploads backed up, with a tested restore.
- [ ] Enquiry notification addresses verified after any change to routing.
- [ ] PHP execution denied inside `wp-content/uploads` at the web-server level.
