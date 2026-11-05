<?php
/**
 * Template Name: About Us
 *
 * Refined About Us page — left sidebar + main content, fully responsive.
 * Matches the Nozaltah / Pharmacare brand (deep rose-pink + teal accent).
 *
 * HOW TO DEPLOY (fixes the 404):
 * 1. Upload THIS file to: /wp-content/themes/YOUR-ACTIVE-THEME/page-about-us.php
 * 2. In WP Admin → Settings → Permalinks → click "Save Changes" (flushes rewrites)
 * 3. In WP Admin → Pages → check if an "About Us" page exists.
 *    - If YES: edit it → Page Attributes → Template → select "About Us" → Update
 *    - If NO:  create a new Page titled "About Us", slug "about-us", publish it,
 *              then set Template → "About Us"
 * 4. Clear any caching plugin cache + browser cache
 * 5. Visit /about-us/ — it should now render correctly.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // security: no direct access

get_header();
?>

<!-- Google Fonts — consistent with front-page -->
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600;1,700;1,800&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ══════════════════════════════════════════════════
   VARIABLES
   ══════════════════════════════════════════════════ */
:root {
    --pk:        #8B1A4A;
    --pk-light:  #f9edf3;
    --teal:      #1aaa8f;
    --teal-light:#e8f5f2;
    --text:      #1a1a2e;
    --muted:     #6b7280;
    --border:    #eef0f3;
    --white:     #ffffff;
    --radius:    10px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ── Outer wrapper ── */
.noz-about-page {
    max-width: 1380px;
    margin: 0 auto;
    padding: 24px 20px 40px;
    display: flex;
    align-items: flex-start;
    gap: 24px;
}

/* ══════════════════════════════════════════════════
   LEFT SIDEBAR
   ══════════════════════════════════════════════════ */
.noz-about-sidebar {
    width: 270px;
    min-width: 270px;
    flex-shrink: 0;
    position: sticky;
    top: 16px;
    align-self: flex-start;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

/* sidebar card base */
.noz-sb-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
}

/* pharmacy info widget */
.noz-sb-pharmacy {
    padding: 20px;
    text-align: center;
    background: linear-gradient(160deg, var(--pk) 0%, #b0255f 100%);
    color: #fff;
}
.noz-sb-pharmacy .sb-logo-circle {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: rgba(255,255,255,.18);
    border: 2px solid rgba(255,255,255,.35);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 12px;
    font-size: 28px;
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-weight: 700;
    color: #fff;
}
.noz-sb-pharmacy h3 {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
}
.noz-sb-pharmacy p {
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    color: rgba(255,255,255,.82);
    line-height: 1.5;
}

/* quick stats */
.noz-sb-stats {
    padding: 16px 20px;
}
.noz-sb-stats h4 {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 12px;
}
.noz-stat-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--border);
}
.noz-stat-row:last-child { border-bottom: none; }
.noz-stat-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    background: var(--pk-light);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: var(--pk);
}
.noz-stat-icon.teal { background: var(--teal-light); color: var(--teal); }
.noz-stat-val {
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.1;
}
.noz-stat-lbl {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    color: var(--muted);
}

/* contact widget */
.noz-sb-contact {
    padding: 16px 20px;
}
.noz-sb-contact h4 {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 12px;
}
.noz-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid var(--border);
}
.noz-contact-item:last-child { border-bottom: none; }
.noz-ci-icon {
    width: 30px; height: 30px;
    border-radius: 6px;
    background: var(--teal-light);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: var(--teal);
    margin-top: 1px;
}
.noz-ci-text {
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    color: var(--muted);
    line-height: 1.5;
}
.noz-ci-text strong {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 1px;
}

/* CTA button */
.noz-sb-cta {
    display: block;
    background: var(--teal);
    color: #fff;
    text-align: center;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 800;
    padding: 13px 20px;
    text-decoration: none;
    border-radius: var(--radius);
    transition: background .2s, transform .18s;
    letter-spacing: .4px;
}
.noz-sb-cta:hover { background: #138a74; transform: translateY(-1px); }

/* ══════════════════════════════════════════════════
   MAIN CONTENT
   ══════════════════════════════════════════════════ */
.noz-about-main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* ── Hero banner ── */
.noz-hero {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: var(--pk);
    padding: 52px 44px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 220px;
}
.noz-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
    pointer-events: none;
}
.noz-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; right: 80px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
    pointer-events: none;
}
.noz-hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,.16);
    border: 1px solid rgba(255,255,255,.26);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    padding: 5px 14px 5px 9px;
    border-radius: 30px;
    margin-bottom: 16px;
    width: fit-content;
    backdrop-filter: blur(6px);
}
.noz-hero-tag-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #f9c5d6;
    flex-shrink: 0;
}
.noz-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 700;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 14px;
    text-shadow: 0 2px 20px rgba(0,0,0,.15);
}
.noz-hero p {
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    line-height: 1.72;
    color: rgba(255,255,255,.85);
    max-width: 580px;
}

/* ── Feature cards row ── */
.noz-features {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}
.noz-feat-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 22px 20px 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    transition: box-shadow .2s, transform .2s;
}
.noz-feat-card:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,.08);
    transform: translateY(-3px);
}
.noz-feat-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    background: var(--pk-light);
    display: flex; align-items: center; justify-content: center;
    color: var(--pk);
}
.noz-feat-card h3 {
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.3;
}
.noz-feat-card p {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    color: var(--muted);
    line-height: 1.6;
}
.noz-feat-badge {
    margin-top: auto;
    display: inline-block;
    background: var(--teal-light);
    color: var(--teal);
    font-family: 'DM Sans', sans-serif;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .8px;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 20px;
    width: fit-content;
}

/* ── Story section ── */
.noz-story {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
}
.noz-story-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
}
.noz-story-text {
    padding: 36px;
    border-right: 1px solid var(--border);
}
.noz-story-text .section-label {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: 'DM Sans', sans-serif;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: var(--pk);
    margin-bottom: 14px;
}
.noz-story-text .section-label::before {
    content: '';
    width: 18px; height: 2px;
    background: var(--pk);
    border-radius: 2px;
}
.noz-story-text h2 {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: clamp(24px, 2.8vw, 36px);
    font-weight: 700;
    color: var(--text);
    line-height: 1.2;
    margin-bottom: 16px;
}
.noz-story-text p {
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: var(--muted);
    line-height: 1.75;
    margin-bottom: 12px;
}
.noz-story-text p:last-of-type { margin-bottom: 0; }

.noz-story-stats {
    padding: 36px;
    background: #fafbfc;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 20px;
}
.noz-big-stat {
    text-align: center;
    padding: 20px;
    background: var(--white);
    border-radius: 8px;
    border: 1px solid var(--border);
}
.noz-big-stat .num {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: 42px;
    font-weight: 700;
    color: var(--pk);
    line-height: 1;
    display: block;
    margin-bottom: 4px;
}
.noz-big-stat .lbl {
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .8px;
}

/* ── Values strip ── */
.noz-values {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}
.noz-val-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 16px;
    text-align: center;
    transition: box-shadow .2s, transform .2s;
}
.noz-val-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,.07); transform: translateY(-2px); }
.noz-val-num {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: 32px;
    font-weight: 700;
    color: var(--pk);
    line-height: 1;
    margin-bottom: 4px;
}
.noz-val-card h4 {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 800;
    color: var(--text);
    margin-bottom: 6px;
}
.noz-val-card p {
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    color: var(--muted);
    line-height: 1.55;
}

/* ── Trust CTA strip ── */
.noz-trust {
    background: linear-gradient(135deg, var(--pk) 0%, #b0255f 100%);
    border-radius: var(--radius);
    padding: 32px 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
}
.noz-trust-text h2 {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: clamp(22px, 2.6vw, 32px);
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
}
.noz-trust-text p {
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: rgba(255,255,255,.82);
    line-height: 1.6;
    max-width: 480px;
}
.noz-trust-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: var(--pk);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 800;
    padding: 13px 26px;
    border-radius: 8px;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(0,0,0,.18);
    transition: transform .18s, box-shadow .2s;
}
.noz-trust-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.24); }

/* ══════════════════════════════════════════════════
   RESPONSIVE
   ══════════════════════════════════════════════════ */
@media (max-width: 1100px) {
    .noz-values { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    .noz-about-page {
        flex-direction: column;
        padding: 16px 14px 32px;
        gap: 16px;
    }
    .noz-about-sidebar {
        width: 100%;
        min-width: 0;
        position: static;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .noz-sb-pharmacy { flex: 1 1 220px; }
    .noz-sb-stats     { flex: 1 1 220px; }
    .noz-sb-contact   { flex: 1 1 220px; }
    .noz-sb-cta       { flex: 1 1 100%; }

    .noz-features { grid-template-columns: repeat(2, 1fr); }

    .noz-story-inner { grid-template-columns: 1fr; }
    .noz-story-text  { border-right: none; border-bottom: 1px solid var(--border); }
    .noz-story-stats { flex-direction: row; flex-wrap: wrap; gap: 12px; }
    .noz-big-stat    { flex: 1 1 120px; }
}

@media (max-width: 640px) {
    .noz-about-sidebar { flex-direction: column; }
    .noz-hero { padding: 32px 24px; }
    .noz-features { grid-template-columns: 1fr; }
    .noz-values   { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .noz-story-text { padding: 24px 20px; }
    .noz-story-stats { padding: 20px; }
    .noz-trust { flex-direction: column; text-align: center; padding: 28px 22px; }
    .noz-trust-text p { max-width: 100%; }
}

@media (max-width: 400px) {
    .noz-values { grid-template-columns: 1fr; }
}
</style>

<div class="noz-about-page">

    <!-- ══ LEFT SIDEBAR ══ -->
    <aside class="noz-about-sidebar">

        <!-- Brand card -->
        <div class="noz-sb-card noz-sb-pharmacy">
            <div class="sb-logo-circle">N</div>
            <h3>Nozaltah</h3>
            <p>Licensed online pharmacy serving Kenya since 2018. Regulated &amp; trusted.</p>
        </div>

        <!-- Quick stats -->
        <div class="noz-sb-card noz-sb-stats">
            <h4>At a Glance</h4>

            <div class="noz-stat-row">
                <div class="noz-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <div class="noz-stat-val">500,000+</div>
                    <div class="noz-stat-lbl">Happy Customers</div>
                </div>
            </div>

            <div class="noz-stat-row">
                <div class="noz-stat-icon teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <div>
                    <div class="noz-stat-val">25,000+</div>
                    <div class="noz-stat-lbl">Products in Stock</div>
                </div>
            </div>

            <div class="noz-stat-row">
                <div class="noz-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <div class="noz-stat-val">200+</div>
                    <div class="noz-stat-lbl">Licensed Suppliers</div>
                </div>
            </div>

            <div class="noz-stat-row">
                <div class="noz-stat-icon teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="noz-stat-val">24/7</div>
                    <div class="noz-stat-lbl">Pharmacist Support</div>
                </div>
            </div>
        </div>

        <!-- Contact widget -->
        <div class="noz-sb-card noz-sb-contact">
            <h4>Contact Us</h4>

            <div class="noz-contact-item">
                <div class="noz-ci-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11.9a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.69a16 16 0 0 0 6 6l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16z"/></svg>
                </div>
                <div class="noz-ci-text">
                    <strong>Phone</strong>
                    +254 796 038 686
                </div>
            </div>

            <div class="noz-contact-item">
                <div class="noz-ci-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div class="noz-ci-text">
                    <strong>Email</strong>
                    info@nozaltah.co.ke
                </div>
            </div>

            <div class="noz-contact-item">
                <div class="noz-ci-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div class="noz-ci-text">
                    <strong>Location</strong>
                    Nairobi, Kenya
                </div>
            </div>
        </div>

        <!-- CTA -->
        <a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="noz-sb-cta">
            Shop Now &rarr;
        </a>

    </aside>

    <!-- ══ MAIN CONTENT ══ -->
    <main class="noz-about-main">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <div class="noz-hero">
                <span class="noz-hero-tag"><span class="noz-hero-tag-dot"></span>Our Story</span>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>

        <?php endwhile; else : ?>

            <!-- ── Hero banner ── -->
            <div class="noz-hero">
                <span class="noz-hero-tag"><span class="noz-hero-tag-dot"></span>Our Story</span>
                <h1>About Nozaltah</h1>
                <p>Your trusted online pharmacy. Committed to delivering genuine medicines, health supplements, and wellness products right to your door — with care, speed, and expertise.</p>
            </div>

            <!-- ── Feature cards ── -->
            <div class="noz-features">

                <div class="noz-feat-card">
                    <div class="noz-feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3>100% Genuine Products</h3>
                    <p>Every product sourced directly from licensed manufacturers and distributors. No counterfeits, ever.</p>
                    <span class="noz-feat-badge">Verified</span>
                </div>

                <div class="noz-feat-card">
                    <div class="noz-feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </div>
                    <h3>Fast &amp; Free Delivery</h3>
                    <p>Orders over KSh 9,999 ship free. Same-day dispatch on orders placed before 2 PM.</p>
                    <span class="noz-feat-badge">Free over 9,999</span>
                </div>

                <div class="noz-feat-card">
                    <div class="noz-feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11.9a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.69a16 16 0 0 0 6 6l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16z"/></svg>
                    </div>
                    <h3>24/7 Expert Support</h3>
                    <p>Licensed pharmacists and customer care available around the clock for your peace of mind.</p>
                    <span class="noz-feat-badge">Always On</span>
                </div>

            </div>

            <!-- ── Our Story ── -->
            <div class="noz-story">
                <div class="noz-story-inner">
                    <div class="noz-story-text">
                        <span class="section-label">Who We Are</span>
                        <h2>Built on Trust,<br>Driven by Care</h2>
                        <p>Nozaltah was founded with a simple mission: to make quality healthcare accessible and affordable for everyone in Kenya. What started as a small online store has grown into one of the most trusted digital pharmacies — serving over 500,000 customers nationwide.</p>
                        <p>We partner with over 200 licensed suppliers and carry more than 25,000 products across medicine, wellness, beauty, fitness, and devices categories. Every order is handled by certified pharmacy professionals to ensure you receive exactly what you need, safely and on time.</p>
                    </div>
                    <div class="noz-story-stats">
                        <div class="noz-big-stat">
                            <span class="num">500K+</span>
                            <span class="lbl">Customers Served</span>
                        </div>
                        <div class="noz-big-stat">
                            <span class="num">25K+</span>
                            <span class="lbl">Products Available</span>
                        </div>
                        <div class="noz-big-stat">
                            <span class="num">200+</span>
                            <span class="lbl">Trusted Suppliers</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Values ── -->
            <div class="noz-values">
                <div class="noz-val-card">
                    <div class="noz-val-num">01</div>
                    <h4>Authenticity</h4>
                    <p>Only genuine, licensed products from verified manufacturers.</p>
                </div>
                <div class="noz-val-card">
                    <div class="noz-val-num">02</div>
                    <h4>Accessibility</h4>
                    <p>Affordable healthcare delivered anywhere in Kenya, fast.</p>
                </div>
                <div class="noz-val-card">
                    <div class="noz-val-num">03</div>
                    <h4>Expertise</h4>
                    <p>Licensed pharmacists guiding every step of your wellness journey.</p>
                </div>
                <div class="noz-val-card">
                    <div class="noz-val-num">04</div>
                    <h4>Integrity</h4>
                    <p>Transparent pricing, honest advice, and your privacy protected.</p>
                </div>
            </div>

            <!-- ── Trust CTA ── */
            <div class="noz-trust">
                <div class="noz-trust-text">
                    <h2>Ready to experience better healthcare?</h2>
                    <p>Browse over 25,000 genuine products and have them delivered to your door today.</p>
                </div>
                <a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="noz-trust-btn">
                    Shop Now
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

        <?php endif; ?>

    </main>

</div><!-- /.noz-about-page -->

<?php get_footer(); ?>
