<?php
/**
 * Template Name: Submit Prescription
 */
get_header(); ?>

<style>
/* ── Global mobile overflow prevention ── */
@media(max-width:768px) {
  html, body { overflow-x: hidden; max-width: 100%; }
  * { box-sizing: border-box; }
}

/* ════════════════════════════════════════════
   BASE FORM STYLES
════════════════════════════════════════════ */
.rx-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.rx-form-grid .fg { margin-bottom: 0; }
.fg.full { grid-column: 1 / -1; }
.fg { display: flex; flex-direction: column; gap: 6px; }
.fg label {
  font-size: 0.8rem; font-weight: 700; opacity: .6;
  text-transform: uppercase; letter-spacing: .04em; transition: color .2s;
}
.fg label span.req { color: var(--green,#22adb0); margin-left: 2px; }
.fg input,.fg select,.fg textarea {
  padding: 11px 14px; border: 1.5px solid rgba(0,0,0,.1);
  border-radius: 10px; font-size: 0.9rem; outline: none;
  transition: border-color .2s, box-shadow .2s;
  width: 100%; box-sizing: border-box; font-family: inherit; background: #fff;
}
.fg input:focus,.fg select:focus,.fg textarea:focus {
  border-color: var(--green,#22adb0);
  box-shadow: 0 0 0 3px rgba(34,173,176,.12);
}
.fg textarea { min-height: 90px; resize: vertical; }

/* ── Validation error state ── */
.fg.has-error label,
.fg.has-error .gender-label-text { color: #e53935 !important; opacity: 1 !important; }
.fg.has-error input,
.fg.has-error select,
.fg.has-error textarea {
  border-color: #e53935 !important;
  box-shadow: 0 0 0 3px rgba(229,57,53,.12) !important;
}
.fg.has-error .gender-wrap { border: 1.5px solid #e53935 !important; border-radius: 10px; padding: 8px 12px; }
.fg.has-error .fg-file { border-color: #e53935 !important; background: rgba(229,57,53,.04) !important; }
.field-error-msg { font-size: .72rem; color: #e53935; font-weight: 700; margin-top: 2px; display: none; }
.fg.has-error .field-error-msg { display: block; }

/* Gender radios */
.gender-wrap { display: flex; gap: 16px; padding: 10px 0 4px; transition: border-color .2s; border-radius: 10px; }
.gender-opt { display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; font-weight: 600; }
.gender-opt input[type="radio"] { width: 18px; height: 18px; accent-color: var(--green,#22adb0); cursor: pointer; flex-shrink: 0; }

/* File upload */
.fg-file { border: 2px dashed rgba(34,173,176,.4); border-radius: 10px; padding: 20px; text-align: center; cursor: pointer; transition: border-color .2s, background .2s; background: rgba(34,173,176,.03); }
.fg-file:hover { border-color: var(--green,#22adb0); background: rgba(34,173,176,.06); }
.fg-file input[type="file"] { display: none; }
.fg-file-label { display: flex; flex-direction: column; align-items: center; gap: 8px; cursor: pointer; }
.fg-file-label svg { opacity: .5; }
.fg-file-label span { font-size: 0.85rem; opacity: .7; font-weight: 600; }
.fg-file-label small { font-size: 0.72rem; opacity: .45; }
#fileName { font-size: 0.8rem; color: var(--green,#22adb0); font-weight: 700; margin-top: 4px; }

/* ── Feedback Toast ── */
.rx-toast {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  border-radius: 12px;
  padding: 0 18px;
  font-size: .85rem;
  font-weight: 700;
  font-family: 'Nunito', sans-serif;
  margin-top: 0;
  border: 1.5px solid transparent;
  line-height: 1.45;
  opacity: 0;
  max-height: 0;
  overflow: hidden;
  pointer-events: none;
  transition: opacity .35s ease, max-height .45s ease, padding .45s ease, margin-top .45s ease;
}
.rx-toast.show {
  opacity: 1;
  max-height: 160px;
  padding: 14px 18px;
  margin-top: 14px;
  pointer-events: auto;
}
.rx-toast svg { flex-shrink: 0; margin-top: 2px; }
.rx-toast.rx-success {
  background: #ebfcfc;
  color: #22adb0;
  border-color: #57e7e5;
}
.rx-toast.rx-error {
  background: #fff0f0;
  color: #b71c1c;
  border-color: #ef9a9a;
}

/* ── Note / Alert box ── */
.rx-note-box { display: flex; align-items: flex-start; gap: 12px; background: #fff8e1; border: 1.5px solid #ffe082; border-radius: 10px; padding: 14px 16px; margin-top: 16px; }
.rx-note-box .rx-note-icon { width: 32px; height: 32px; border-radius: 8px; background: #ffe082; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rx-note-box p { font-size: .78rem; font-weight: 600; color: #6d4c00; line-height: 1.6; margin: 0; }
.rx-note-box strong { color: #4e3500; }

/* ════════════════════════════════════════════
   DELIVERY INFO BOXES
════════════════════════════════════════════ */
.delivery-info-box { background: #fff; border-radius: 14px; border: 1.5px solid var(--green-light,#e5fbfb); padding: 20px 22px; }
.delivery-info-box .di-title { font-size: .78rem; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--green,#22adb0); margin-bottom: 14px; padding-bottom: 10px; border-bottom: 2px solid var(--green-light,#e5fbfb); display: flex; align-items: center; gap: 8px; flex-wrap: wrap; line-height: 1.4; }
.delivery-row { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,.05); }
.delivery-row:last-child { border-bottom: none; padding-bottom: 0; }
.di-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--green-light,#e5fbfb); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.di-label { font-size: .82rem; font-weight: 800; color: var(--dark,#0e4847); margin-bottom: 3px; display: flex; align-items: center; flex-wrap: wrap; gap: 4px; }
.di-desc { font-size: .75rem; color: var(--text-light,#22adb0); line-height: 1.55; font-weight: 500; }
.di-badge { display: inline-block; font-size: .62rem; font-weight: 800; padding: 2px 8px; border-radius: 50px; }
.di-badge--green  { background: var(--green-light,#e5fbfb); color: var(--green,#22adb0); }
.di-badge--orange { background: #fff3e0; color: #e65100; }
.delivery-note-banner { display: flex; align-items: flex-start; gap: 14px; background: #fff8e1; border: 1.5px solid #ffe082; border-radius: 12px; padding: 16px 20px; max-width: 900px; margin: 24px auto 0; }
.delivery-note-banner .dnb-icon { width: 36px; height: 36px; border-radius: 10px; background: #ffe082; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.delivery-note-banner p { font-size: .8rem; font-weight: 600; color: #6d4c00; line-height: 1.6; margin: 0; }
.delivery-note-banner strong { color: #4e3500; }

/* ════════════════════════════════════════════
   DELIVERY IMAGE WITH ANIMATED BUBBLES
════════════════════════════════════════════ */
.rx-img-col { position: relative; }
.rx-bubble-main {
  position: absolute; top: 0; left: 50%; transform: translateX(-50%);
  width: 110%; height: 78%; background: var(--green-light, #e5fbfb);
  border-radius: 50% 50% 50% 50% / 40% 40% 60% 60%; z-index: 0;
  animation: bubbleFloat1 6s ease-in-out infinite;
}
.rx-bubble-2 { position: absolute; bottom: 80px; left: -20px; width: 160px; height: 160px; background: var(--green, #22adb0); border-radius: 50%; z-index: 0; opacity: .18; animation: bubbleFloat2 8s ease-in-out infinite; }
.rx-bubble-3 { position: absolute; bottom: 90px; right: -10px; width: 100px; height: 100px; background: var(--green, #22adb0); border-radius: 50%; z-index: 0; opacity: .12; animation: bubbleFloat3 7s ease-in-out infinite; }
.rx-bubble-4 { position: absolute; top: 10px; right: -15px; width: 70px; height: 70px; background: var(--green-mid, #b0f4f3); border-radius: 50%; z-index: 0; opacity: .5; animation: bubbleFloat2 5s ease-in-out infinite reverse; }
.rx-bubble-5 { position: absolute; top: 20px; left: -10px; width: 50px; height: 50px; background: var(--green-mid, #b0f4f3); border-radius: 50%; z-index: 0; opacity: .4; animation: bubbleFloat3 9s ease-in-out infinite; }
@keyframes bubbleFloat1 {
  0%, 100% { border-radius: 50% 50% 50% 50% / 40% 40% 60% 60%; transform: translateX(-50%) scale(1); }
  33%       { border-radius: 45% 55% 55% 45% / 45% 35% 65% 55%; transform: translateX(-50%) scale(1.02); }
  66%       { border-radius: 55% 45% 45% 55% / 55% 45% 55% 45%; transform: translateX(-50%) scale(0.98); }
}
@keyframes bubbleFloat2 {
  0%, 100% { transform: translateY(0) scale(1); }
  50%       { transform: translateY(-14px) scale(1.06); }
}
@keyframes bubbleFloat3 {
  0%, 100% { transform: translateY(0) scale(1); }
  50%       { transform: translateY(-10px) scale(1.04); }
}
.rx-delivery-img-wrap { position: relative; z-index: 1; text-align: center; overflow: visible; }
.rx-delivery-img-wrap img { width: 100%; max-width: 420px; height: auto; object-fit: cover; object-position: top center; display: block; margin: 0 auto; position: relative; z-index: 1; -webkit-mask-image: rgba(0,0,0,.4); mask-image: rgba(0,0,0,.4); }
.rx-img-overlay-badge { position: relative; z-index: 2; background: var(--green, #22adb0); color: white; border-radius: 14px; padding: 14px 20px; margin: -24px auto 0; max-width: 320px; text-align: center; box-shadow: 0 8px 28px rgba(34,173,176,.35); }
.rx-img-overlay-badge h3 { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700; color: white; margin: 0 0 4px; }
.rx-img-overlay-badge p { font-size: .76rem; color: rgba(255,255,255,.85); font-weight: 600; margin: 0; line-height: 1.5; }
.rx-img-overlay-badge .rx-badge-dots { display: flex; justify-content: center; gap: 4px; margin-top: 8px; }
.rx-img-overlay-badge .rx-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,.5); }
.rx-img-overlay-badge .rx-dot.active { background: white; width: 18px; border-radius: 3px; }
.rx-delivery-badges { display: flex; flex-direction: column; gap: 8px; margin-top: 14px; position: relative; z-index: 2; }
.rx-delivery-badge { display: flex; align-items: center; gap: 12px; background: white; border-radius: 12px; padding: 11px 14px; box-shadow: 0 4px 15px rgba(34,173,176,.08); border: 1.5px solid var(--green-light,#e5fbfb); transition: transform .2s, box-shadow .2s; }
.rx-delivery-badge:hover { transform: translateX(4px); box-shadow: 0 8px 24px rgba(34,173,176,.15); }
.rx-delivery-badge-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rx-delivery-badge-icon.green  { background: var(--green-light,#e5fbfb); }
.rx-delivery-badge-icon.orange { background: #fff3e0; }
.rx-delivery-badge-icon.blue   { background: #ebfcfc; }
.rx-delivery-badge-title { font-size: .8rem; font-weight: 800; color: var(--text,#103837); margin-bottom: 1px; }
.rx-delivery-badge-sub   { font-size: .7rem; color: var(--text-light,#5bd9d7); font-weight: 600; }
.rx-only-notice { display: flex; align-items: flex-start; gap: 14px; background: #ebfcfc; border: 1.5px solid #bcf5f5; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; }
.rx-only-notice .rx-only-icon { width: 40px; height: 40px; border-radius: 10px; background: #bcf5f5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rx-only-notice p { font-size: .82rem; font-weight: 600; color: #1a8f92; line-height: 1.6; margin: 0; }
.rx-only-notice strong { color: #0f6c6a; }

/* ════════════════════════════════════════════
   PAGE SECTIONS
════════════════════════════════════════════ */
.rx-hero { padding: 56px 5%; text-align: center; background: #ebfcfc; }
.rx-how  { background: #fff; padding: 56px 5%; }
.rx-how-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 24px; text-align: center; }
.rx-delivery { background: var(--green-pale,#eefcfc); padding: 48px 5%; }
.rx-delivery-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; max-width: 900px; margin: 0 auto; }
.rx-form-sec { background: #fff; padding: 48px 5% 56px; }
.rx-two-col { display: grid; grid-template-columns: 1fr 1.5fr; gap: 48px; align-items: start; }
.rx-cta { background: var(--green,#22adb0); padding: 40px 5%; text-align: center; position: relative; overflow: hidden; }

/* ════════════════════════════════════════════
   RESPONSIVE
════════════════════════════════════════════ */
@media(max-width:1024px) {
  .rx-how-grid { grid-template-columns: repeat(2,1fr); gap: 16px; }
  .rx-two-col  { grid-template-columns: 1fr; gap: 32px; }
  .rx-delivery-grid { grid-template-columns: 1fr; }
}
@media(max-width:768px) {
  .rx-hero,.rx-how,.rx-delivery,.rx-form-sec,.rx-cta { padding: 36px 16px; }
  .rx-how-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
  .rx-delivery-grid { grid-template-columns: 1fr; gap: 14px; }
  .rx-two-col { display: block !important; width: 100%; }
  .rx-two-col > * { width: 100%; margin-bottom: 28px; }
  .cta-form { padding: 18px 14px !important; }
  .rx-form-grid { grid-template-columns: 1fr !important; gap: 12px; }
  .fg.full { grid-column: 1 !important; }
  .rx-submit-btn { font-size: .72rem !important; padding: 9px 18px !important; width: 100% !important; }
  .rx-bubble-main { width: 100%; height: 72%; }
  .rx-bubble-2 { width: 100px; height: 100px; }
  .rx-bubble-3 { width: 70px; height: 70px; }
}
@media(max-width:480px) {
  .rx-how-grid { grid-template-columns: 1fr !important; }
}
</style>

<!-- HERO -->
<section class="rx-hero">
  <div class="sec-tag sec-tag-outline reveal">Quick &amp; Easy</div>
  <h1 class="sec-title reveal rd1">Submit Your <span>Prescription</span></h1>
  <p class="sec-desc reveal rd2" style="margin:0 auto;max-width:600px;">Upload your prescription and we'll prepare and deliver your medication — same day within Nairobi, next day to counties outside Nairobi.</p>
</section>

<!-- PRESCRIPTION ONLY NOTICE -->
<div style="background:white;padding:24px 5% 0;">
  <div class="rx-only-notice" style="max-width:1100px;margin:0 auto;">
    <div class="rx-only-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a8f92" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
    </div>
    <p>
      <strong>Prescription Medicines Only:</strong> This form is strictly for <strong>doctor-prescribed medicines</strong>. We cannot process orders without a valid prescription signed by a licensed medical practitioner.
      For <strong>over-the-counter medicines</strong>, please visit our
      <a href="<?php echo function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop'); ?>" style="color:#1a8f92;font-weight:800;text-decoration:underline;">Shop page</a>.
    </p>
  </div>
</div>

<!-- HOW IT WORKS -->
<section class="rx-how">
  <div style="text-align:center;margin-bottom:36px;">
    <div class="sec-tag sec-tag-solid reveal">Simple Process</div>
    <h2 class="sec-title reveal rd1">How It <span>Works</span></h2>
  </div>
  <div class="rx-how-grid">
    <div class="srv-card reveal">
      <div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="12" cy="12" r="4"/><line x1="12" y1="3" x2="12" y2="7"/></svg></div>
      <div style="font-weight:800;color:var(--text);margin-bottom:6px;font-size:.9rem;">1. Fill the Form</div>
      <div style="font-size:.78rem;color:var(--text-light);font-weight:500;">Enter your details and attach your prescription file.</div>
    </div>
    <div class="srv-card reveal rd1">
      <div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg></div>
      <div style="font-weight:800;color:var(--text);margin-bottom:6px;font-size:.9rem;">2. Submit Securely</div>
      <div style="font-size:.78rem;color:var(--text-light);font-weight:500;">Your prescription is sent securely to our pharmacy team.</div>
    </div>
    <div class="srv-card reveal rd2">
      <div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5"><polyline points="20 6 9 17 4 12"/></svg></div>
      <div style="font-weight:800;color:var(--text);margin-bottom:6px;font-size:.9rem;">3. We Verify</div>
      <div style="font-size:.78rem;color:var(--text-light);font-weight:500;">Our licensed pharmacist reviews and verifies your prescription.</div>
    </div>
    <div class="srv-card reveal rd3">
      <div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
      <div style="font-weight:800;color:var(--text);margin-bottom:6px;font-size:.9rem;">4. Fast Delivery</div>
      <div style="font-size:.78rem;color:var(--text-light);font-weight:500;">Delivered same day in Nairobi or next day to other counties.</div>
    </div>
  </div>
</section>

<!-- DELIVERY SCHEDULE -->
<section class="rx-delivery">
  <div style="text-align:center;margin-bottom:32px;">
    <div class="sec-tag sec-tag-solid reveal">Delivery Info</div>
    <h2 class="sec-title reveal rd1">Delivery <span>Schedule</span></h2>
  </div>
  <div class="rx-delivery-grid">
    <div class="delivery-info-box reveal">
      <div class="di-title">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Nairobi: Same Day Delivery
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green,#22adb0)" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div><div class="di-label">Order by 3:00 PM <span class="di-badge di-badge--green">Same Day</span></div><div class="di-desc">Orders placed before 3:00 PM are dispatched the same day and delivered within Nairobi by evening.</div></div>
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e65100" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
        <div><div class="di-label">3:00 PM – 6:00 PM <span class="di-badge di-badge--orange">Possible Same Day</span></div><div class="di-desc">Orders between 3–6 PM may still be delivered same day. Our team will confirm via phone or email.</div></div>
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green,#22adb0)" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
        <div><div class="di-label">After 6:00 PM <span class="di-badge di-badge--orange">Next Morning</span></div><div class="di-desc">Orders received after 6:00 PM are processed the following morning.</div></div>
      </div>
    </div>
    <div class="delivery-info-box reveal rd1">
      <div class="di-title">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        Outside Nairobi: Countrywide
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green,#22adb0)" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
        <div><div class="di-label">Nearby Counties <span class="di-badge di-badge--green">Next Day</span></div><div class="di-desc">Kiambu, Machakos, Kajiado, Murang'a and surrounding areas receive orders next day.</div></div>
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e65100" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
        <div><div class="di-label">Distant Counties <span class="di-badge di-badge--orange">1–2 Days</span></div><div class="di-desc">Mombasa, Kisumu, Nakuru, Eldoret and farther counties take 1–2 days.</div></div>
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green,#22adb0)" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
        <div><div class="di-label">Confirmation Call</div><div class="di-desc">We always confirm your expected delivery time before dispatching your order.</div></div>
      </div>
    </div>
  </div>
  <div class="delivery-note-banner reveal">
    <div class="dnb-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e65100" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <p><strong>Important Note:</strong> Delivery will only be initiated after our licensed pharmacist has <strong>reviewed and approved</strong> your prescription. Orders without a valid prescription cannot be processed.</p>
  </div>
</section>

<!-- SUBMIT FORM -->
<section class="rx-form-sec">
  <div class="rx-two-col">

    <!-- LEFT: Image with bubbles -->
    <div class="rx-img-col">
      <div class="rx-bubble-main"></div>
      <div class="rx-bubble-2"></div>
      <div class="rx-bubble-3"></div>
      <div class="rx-bubble-4"></div>
      <div class="rx-bubble-5"></div>
      <div class="rx-delivery-img-wrap">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/js/images/delivery.png" alt="Fast Delivery — Travotech Agencies">
      </div>
      <div class="rx-img-overlay-badge reveal">
        <h3>Fast &amp; Reliable Delivery</h3>
        <p>Same day Nairobi &nbsp;&middot;&nbsp; Next day countrywide</p>
        <div class="rx-badge-dots">
          <div class="rx-dot active"></div>
          <div class="rx-dot"></div>
          <div class="rx-dot"></div>
        </div>
      </div>
      <div class="rx-delivery-badges" style="margin-top:16px;">
        <div class="rx-delivery-badge reveal">
          <div class="rx-delivery-badge-icon green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
          <div><div class="rx-delivery-badge-title">Nairobi: Same Day</div><div class="rx-delivery-badge-sub">Order before 3:00 PM for same day delivery</div></div>
        </div>
        <div class="rx-delivery-badge reveal rd1">
          <div class="rx-delivery-badge-icon orange"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e65100" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
          <div><div class="rx-delivery-badge-title">Countrywide: Next Day</div><div class="rx-delivery-badge-sub">Nearby counties next day · Distant 1–2 days</div></div>
        </div>
        <div class="rx-delivery-badge reveal rd2">
          <div class="rx-delivery-badge-icon green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
          <div><div class="rx-delivery-badge-title">Confirmation Call</div><div class="rx-delivery-badge-sub">We confirm delivery time before dispatch</div></div>
        </div>
        <div class="rx-delivery-badge reveal rd3">
          <div class="rx-delivery-badge-icon blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#60dad8" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <div><div class="rx-delivery-badge-title">Licensed Pharmacists</div><div class="rx-delivery-badge-sub">All prescriptions reviewed by certified pharmacists</div></div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Form -->
    <div class="cta-form reveal rd1">
      <div class="cta-form-title">Submit Your Prescription</div>
      <p style="font-size:.82rem;color:var(--text-light);margin-bottom:18px;font-weight:500;line-height:1.6;">
        Fill in your details and attach your prescription. Our pharmacist will review it and contact you shortly.
      </p>

      <form id="rxForm" enctype="multipart/form-data" novalidate>
        <?php wp_nonce_field('rx_nonce_action', 'rx_nonce'); ?>
        <input type="hidden" name="action" value="travotech_submit_prescription">

        <div class="rx-form-grid">
          <div class="fg" id="fg_fname">
            <label>First Name <span class="req">*</span></label>
            <input type="text" name="rx_fname" id="rx_fname" placeholder="e.g. James">
            <span class="field-error-msg">First name is required.</span>
          </div>
          <div class="fg" id="fg_lname">
            <label>Last Name <span class="req">*</span></label>
            <input type="text" name="rx_lname" id="rx_lname" placeholder="e.g. Kamau">
            <span class="field-error-msg">Last name is required.</span>
          </div>
          <div class="fg" id="fg_age">
            <label>Age <span class="req">*</span></label>
            <input type="number" name="rx_age" id="rx_age" placeholder="e.g. 35" min="1" max="120">
            <span class="field-error-msg">Please enter your age.</span>
          </div>
          <div class="fg" id="fg_gender">
            <label class="gender-label-text">Gender <span class="req">*</span></label>
            <div class="gender-wrap">
              <label class="gender-opt"><input type="radio" name="rx_gender" value="Male"> Male</label>
              <label class="gender-opt"><input type="radio" name="rx_gender" value="Female"> Female</label>
            </div>
            <span class="field-error-msg">Please select your gender.</span>
          </div>
          <div class="fg" id="fg_phone">
            <label>Phone Number <span class="req">*</span></label>
            <input type="tel" name="rx_phone" id="rx_phone" placeholder="+254 720 737 151">
            <span class="field-error-msg">Phone number is required.</span>
          </div>
          <div class="fg">
            <label>Email <span style="opacity:.4;font-size:.7rem;">(optional)</span></label>
            <input type="email" name="rx_email" id="rx_email" placeholder="james@email.com">
          </div>
          <div class="fg full" id="fg_location">
            <label>Delivery Address <span class="req">*</span></label>
            <input type="text" name="rx_location" id="rx_location" placeholder="e.g. Westlands, Nairobi or Kisumu Town, Kisumu County">
            <span class="field-error-msg">Please enter your delivery address.</span>
          </div>
          <div class="fg full">
            <label>Food / Drug Allergies <span style="opacity:.4;font-size:.7rem;">(optional)</span></label>
            <input type="text" name="rx_allergies" id="rx_allergies" placeholder="e.g. Penicillin, Peanuts">
          </div>
          <div class="fg full">
            <label>Additional Notes for Pharmacist <span style="opacity:.4;font-size:.7rem;">(optional)</span></label>
            <textarea name="rx_notes" id="rx_notes" placeholder="Any special instructions..."></textarea>
          </div>
          <div class="fg full" id="fg_file">
            <label>Attach Prescription <span class="req">*</span></label>
            <div class="fg-file" id="fgFileBox" onclick="document.getElementById('rx_file').click()">
              <input type="file" id="rx_file" name="rx_file" accept="image/*,.pdf,.doc,.docx,.heic,.heif,.tiff,.tif,.bmp,.webp">
              <label class="fg-file-label" for="rx_file">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <span>Click to select your prescription file</span>
                <small>Accepted: JPG, PNG, PDF, Word, HEIC, WEBP, TIFF, BMP &mdash; Max 10MB</small>
              </label>
              <div id="fileName"></div>
            </div>
            <span class="field-error-msg">Please attach your prescription file.</span>
          </div>
        </div>

        <div class="rx-note-box" style="margin-top:16px;">
          <div class="rx-note-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e65100" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          </div>
          <p><strong>Note:</strong> Delivery will only begin after our pharmacist has reviewed and approved your prescription. We will contact you to confirm.</p>
        </div>

        <button type="button" id="rxSubmitBtn" class="form-submit rx-submit-btn" style="margin-top:18px;width:100%;display:flex;align-items:center;justify-content:center;gap:8px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          Submit Prescription
        </button>

        <!-- ✅ Success Toast -->
        <div class="rx-toast rx-success" id="rxSuccess" role="alert" aria-live="polite">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="20 6 9 17 4 12"/></svg>
          <span>Your prescription was well received! Our professional pharmacist will review it and get back to you soon.</span>
        </div>

        <!-- ❌ Error Toast -->
        <div class="rx-toast rx-error" id="rxError" role="alert" aria-live="polite">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span id="rxErrorText"></span>
        </div>

      </form>
    </div>

  </div>
</section>

<!-- CTA BOTTOM -->
<section class="rx-cta">
  <div class="cta-b1"></div><div class="cta-b2"></div>
  <div style="position:relative;z-index:1;">
    <h2 class="sec-title reveal" style="color:white;">Need Help? <span style="color:var(--green-mid,#b0f4f3);">Call Us Now</span></h2>
    <p style="color:rgba(255,255,255,.8);font-size:.88rem;margin:10px 0 24px;" class="reveal rd1">Our pharmacists are available Mon–Sat 8am–6pm to assist you.</p>
    <a href="tel:+254720737151" class="btn-green reveal rd2" style="background:white;color:var(--green);">
      <?php echo esc_html(travotech_phone()); ?>
    </a>
  </div>
</section>

<script>
(function() {
  var ajaxUrl   = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
  var isSending = false;
  var toastTimer = null;

  // Show file name on select
  document.getElementById('rx_file').addEventListener('change', function() {
    var nameEl = document.getElementById('fileName');
    var fg     = document.getElementById('fg_file');
    if (this.files && this.files[0]) {
      nameEl.textContent = 'Selected: ' + this.files[0].name;
      fg.classList.remove('has-error');
    }
  });

  // Clear error on input
  var fields = [
    ['rx_fname','fg_fname'],['rx_lname','fg_lname'],
    ['rx_age','fg_age'],['rx_phone','fg_phone'],['rx_location','fg_location'],
  ];
  fields.forEach(function(p) {
    var el = document.getElementById(p[0]);
    if (el) el.addEventListener('input', function() {
      document.getElementById(p[1]).classList.remove('has-error');
    });
  });
  document.querySelectorAll('input[name="rx_gender"]').forEach(function(r) {
    r.addEventListener('change', function() {
      document.getElementById('fg_gender').classList.remove('has-error');
    });
  });

  // Toast helpers
  function showToast(el, ms) {
    clearTimeout(toastTimer);
    document.getElementById('rxSuccess').classList.remove('show');
    document.getElementById('rxError').classList.remove('show');
    el.classList.add('show');
    toastTimer = setTimeout(function() { el.classList.remove('show'); }, ms || 7000);
  }

  function setError(fgId, scrollFirst) {
    var fg = document.getElementById(fgId);
    if (!fg) return;
    fg.classList.add('has-error');
    if (scrollFirst) {
      fg.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  }

  function btnLoading() {
    var btn = document.getElementById('rxSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;animation:rxSpin 1s linear infinite"><path d="M21 12a9 9 0 11-6.219-8.56"/></svg> Sending...';
    isSending = true;
  }

  function btnReset() {
    var btn = document.getElementById('rxSubmitBtn');
    btn.disabled = false;
    btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Submit Prescription';
    isSending = false;
  }

  function resetForm() {
    btnReset();
    document.getElementById('rxForm').reset();
    document.getElementById('fileName').textContent = '';
    fields.forEach(function(p) {
      document.getElementById(p[1]).classList.remove('has-error','has-valid');
    });
    document.getElementById('fg_gender').classList.remove('has-error');
    document.getElementById('fg_file').classList.remove('has-error');
  }

  document.getElementById('rxSubmitBtn').addEventListener('click', function() {
    if (isSending) return;

    var fname    = document.getElementById('rx_fname').value.trim();
    var lname    = document.getElementById('rx_lname').value.trim();
    var age      = document.getElementById('rx_age').value.trim();
    var gender   = document.querySelector('input[name="rx_gender"]:checked');
    var phone    = document.getElementById('rx_phone').value.trim();
    var location = document.getElementById('rx_location').value.trim();
    var file     = document.getElementById('rx_file').files[0];

    var hasError = false;
    var firstError = null;

    if (!fname)    { document.getElementById('fg_fname').classList.add('has-error');    hasError = true; if (!firstError) firstError = 'fg_fname'; }
    if (!lname)    { document.getElementById('fg_lname').classList.add('has-error');    hasError = true; if (!firstError) firstError = 'fg_lname'; }
    if (!age)      { document.getElementById('fg_age').classList.add('has-error');      hasError = true; if (!firstError) firstError = 'fg_age'; }
    if (!gender)   { document.getElementById('fg_gender').classList.add('has-error');   hasError = true; if (!firstError) firstError = 'fg_gender'; }
    if (!phone)    { document.getElementById('fg_phone').classList.add('has-error');    hasError = true; if (!firstError) firstError = 'fg_phone'; }
    if (!location) { document.getElementById('fg_location').classList.add('has-error'); hasError = true; if (!firstError) firstError = 'fg_location'; }
    if (!file)     { document.getElementById('fg_file').classList.add('has-error');     hasError = true; if (!firstError) firstError = 'fg_file'; }

    if (hasError) {
      var firstEl = document.getElementById(firstError);
      if (firstEl) firstEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    btnLoading();

    var formData = new FormData(document.getElementById('rxForm'));

    fetch(ajaxUrl, {
      method: 'POST',
      body: formData
    })
    .then(function(r) { return r.text(); })
    .then(function(raw) {
      var clean = raw.trim();
      var s = clean.indexOf('{');
      if (s > 0) clean = clean.substring(s);
      var data;
      try { data = JSON.parse(clean); } catch(e) {
        btnReset();
        document.getElementById('rxErrorText').textContent = 'Server error. Please call us on ' + '<?php echo esc_js(travotech_phone()); ?>';
        showToast(document.getElementById('rxError'), 8000);
        return;
      }
      if (data.success) {
        resetForm();
        showToast(document.getElementById('rxSuccess'), 8000);
        document.getElementById('rxSubmitBtn').scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else {
        btnReset();
        document.getElementById('rxErrorText').textContent = (data.data && data.data.msg)
          ? data.data.msg
          : 'Failed to send. Please call us on <?php echo esc_js(travotech_phone()); ?>';
        showToast(document.getElementById('rxError'), 8000);
      }
    })
    .catch(function() {
      btnReset();
      document.getElementById('rxErrorText').textContent = 'Network error. Please check your connection and try again.';
      showToast(document.getElementById('rxError'), 8000);
    });
  });
})();
</script>

<style>
@keyframes rxSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

<?php get_footer(); ?>