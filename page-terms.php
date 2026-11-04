<?php
/**
 * Terms & Conditions Page Template
 * Slug: terms  (or terms-and-conditions — match your WP page slug)
 * WordPress loads this directly — get_header() / get_footer() required here.
 */

get_header();
wp_enqueue_style( 'dashicons' );
?>

<style>
/* ── Page wrapper ────────────────────────────────── */
.terms-page { position: relative; }

/* ── Banner ──────────────────────────────────────── */
.terms-page .tp-banner {
  background: linear-gradient(135deg, #1e8a54 0%, #2eaf6e 60%, #3dc97e 100%);
  color: #fff;
  padding: 64px 0 52px;
  text-align: center;
  position: relative;
  overflow: hidden;
  z-index: 1;
}
.terms-page .tp-banner::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse at 70% 50%, rgba(255,255,255,.08) 0%, transparent 70%);
}
.terms-page .tp-banner .tp-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 700;
  color: #fff;
  margin: 0 0 12px;
  position: relative;
  z-index: 1;
  text-shadow: 0 2px 20px rgba(0,0,0,.15);
}
.terms-page .tp-breadcrumb {
  font-size: .82rem;
  font-weight: 600;
  color: rgba(255,255,255,.8);
  position: relative;
  z-index: 1;
}
.terms-page .tp-breadcrumb a {
  color: #fff;
  text-decoration: underline;
  font-weight: 700;
}
.terms-page .tp-breadcrumb a:hover { color: #b8ecd4; }

/* ── Content section — bubble stage ─────────────── */
.terms-page .tp-content {
  position: relative;
  padding: 60px 5%;
  background: #edf8f3;
  overflow: hidden;
  z-index: 1;
}

/* Canvas scoped to content section only */
#tp-bubble-canvas {
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  pointer-events: none;
  z-index: 0;
}

/* ── Main card ───────────────────────────────────── */
.terms-page .tp-inner {
  position: relative;
  z-index: 2;
  max-width: 900px;
  margin: 0 auto;
  background: rgba(255,255,255,.90);
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  padding: 44px 52px;
  border-radius: 20px;
  border: 1.5px solid rgba(184,236,212,.7);
  box-shadow: 0 8px 40px rgba(46,175,110,.12), 0 2px 12px rgba(0,0,0,.04);
}

/* ── Section headings ────────────────────────────── */
.terms-page .tp-inner h2 {
  font-family: 'Nunito', sans-serif;
  color: #1a2e25;
  font-size: 1.12rem;
  font-weight: 800;
  margin: 36px 0 12px;
  padding-bottom: 10px;
  border-bottom: 2px solid #e8f8f0;
  display: flex;
  align-items: center;
  gap: 10px;
}
.terms-page .tp-inner h2 .dashicons {
  color: #2eaf6e;
  font-size: 20px;
  width: 20px;
  height: 20px;
  flex-shrink: 0;
}
.terms-page .tp-inner h2:first-of-type { margin-top: 0; }

/* ── Body text ───────────────────────────────────── */
.terms-page .tp-inner p {
  color: #4a6358;
  font-size: .88rem;
  line-height: 1.88;
  margin-bottom: 14px;
  font-weight: 500;
}
.terms-page .tp-inner a {
  color: #2eaf6e;
  text-decoration: underline;
  font-weight: 700;
}
.terms-page .tp-inner a:hover { color: #1e8a54; }

/* ── Intro bar ───────────────────────────────────── */
.terms-page .tp-inner .tp-intro {
  font-size: .95rem;
  color: #1a2e25;
  font-weight: 600;
  background: #f0faf5;
  border-left: 4px solid #2eaf6e;
  padding: 16px 20px;
  border-radius: 0 10px 10px 0;
  margin-bottom: 28px;
}
.terms-page .tp-inner .tp-date {
  font-size: .78rem;
  color: #8aaa98;
  font-style: italic;
  margin-bottom: 32px;
  display: block;
}

/* ── Callout boxes ───────────────────────────────── */
.tp-callout {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 14px 18px;
  border-radius: 10px;
  margin: 16px 0;
  font-size: .85rem;
  font-weight: 600;
  line-height: 1.65;
}
.tp-callout .dashicons {
  font-size: 20px; width: 20px; height: 20px;
  flex-shrink: 0; margin-top: 1px;
}
.tp-callout.info    { background:#e8f4ff; border-left:4px solid #4a80f0; color:#1a3070; }
.tp-callout.info    .dashicons { color:#4a80f0; }
.tp-callout.warning { background:#fff8e8; border-left:4px solid #f0a500; color:#6b4a00; }
.tp-callout.warning .dashicons { color:#f0a500; }
.tp-callout.success { background:#e8f8f0; border-left:4px solid #2eaf6e; color:#1a4030; }
.tp-callout.success .dashicons { color:#2eaf6e; }
.tp-callout.danger  { background:#fff0f0; border-left:4px solid #e53935; color:#7a1010; }
.tp-callout.danger  .dashicons { color:#e53935; }

/* ── Payment zone cards ──────────────────────────── */
.tp-zone-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin: 18px 0 24px;
}
.tp-zone-card {
  border-radius: 14px;
  padding: 22px 20px;
  border: 2px solid transparent;
  position: relative;
  overflow: hidden;
}
.tp-zone-card.nairobi {
  background: linear-gradient(135deg, #e8f8f0, #d0f2e4);
  border-color: #2eaf6e;
}
.tp-zone-card.county {
  background: linear-gradient(135deg, #fff8e8, #fdeec8);
  border-color: #f0a500;
}
.tp-zone-card .tz-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: .72rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .06em;
  padding: 4px 12px;
  border-radius: 50px;
  margin-bottom: 12px;
}
.tp-zone-card.nairobi .tz-badge { background:#2eaf6e; color:#fff; }
.tp-zone-card.county  .tz-badge { background:#f0a500; color:#fff; }
.tp-zone-card .tz-title  { font-size:1rem; font-weight:900; color:#1a2e25; margin-bottom:6px; font-family:'Nunito',sans-serif; }
.tp-zone-card .tz-amount { font-size:1.9rem; font-weight:900; font-family:'Playfair Display',serif; line-height:1; margin-bottom:6px; }
.tp-zone-card.nairobi .tz-amount { color:#1e8a54; }
.tp-zone-card.county  .tz-amount { color:#c47d00; }
.tp-zone-card .tz-sub { font-size:.78rem; color:#4a6358; font-weight:600; line-height:1.5; }
.tp-zone-card .tz-icon { position:absolute; top:14px; right:16px; font-size:2rem; opacity:.12; }

/* ── Bullet list ─────────────────────────────────── */
.tp-list {
  margin: 12px 0 18px 0;
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.tp-list-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  font-size: .87rem;
  color: #4a6358;
  font-weight: 500;
  line-height: 1.65;
}
.tp-list-item .dashicons {
  color: #2eaf6e;
  font-size: 16px;
  width: 16px;
  height: 16px;
  flex-shrink: 0;
  margin-top: 2px;
}

/* ── Payment methods ─────────────────────────────── */
.tp-methods {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin: 14px 0;
}
.tp-method {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f0faf5;
  border: 1.5px solid #b8ecd4;
  border-radius: 50px;
  padding: 8px 16px;
  font-size: .82rem;
  font-weight: 700;
  color: #1a2e25;
}
.tp-method .dashicons { color:#2eaf6e; font-size:16px; width:16px; height:16px; }

/* ── Contact box ─────────────────────────────────── */
.tp-contact-box {
  background: #f0faf5;
  border: 1.5px solid #b8ecd4;
  border-radius: 12px;
  padding: 22px 26px;
  margin-top: 10px;
  overflow: hidden;
}
.tp-contact-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
  font-size: .88rem;
  color: #4a6358;
  font-weight: 500;
  min-width: 0;
}
.tp-contact-row:last-child { margin-bottom: 0; }
.tp-contact-row .dashicons { color:#2eaf6e; font-size:18px; width:18px; height:18px; flex-shrink:0; }
.tp-contact-row a {
  color: #2eaf6e; font-weight: 700; text-decoration: none;
  word-break: break-all; overflow-wrap: anywhere; min-width: 0;
}
.tp-contact-row a:hover { color:#1e8a54; text-decoration:underline; }
.tp-contact-row span, .tp-contact-row strong {
  word-break: break-word; overflow-wrap: anywhere; min-width: 0;
}

@media(max-width:768px){
  .terms-page .tp-inner { padding: 28px 20px; }
  .tp-zone-grid { grid-template-columns: 1fr; }
}
</style>

<div class="terms-page">

  <!-- ── Banner ── -->
  <section class="tp-banner">
    <div style="max-width:1200px;margin:0 auto;padding:0 5%;">
      <h1 class="tp-title">Terms &amp; Conditions</h1>
      <nav class="tp-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url( home_url() ); ?>">Home</a>
        &rsaquo;
        <span>Terms &amp; Conditions</span>
      </nav>
    </div>
  </section>

  <!-- ── Content with bubbles ── -->
  <section class="tp-content">

    <canvas id="tp-bubble-canvas"></canvas>

    <div class="tp-inner">

      <p class="tp-intro">Welcome to <strong>Travotech Agencies</strong>. By accessing our website, placing an order, or using any of our services, you agree to be bound by these Terms &amp; Conditions. Please read them carefully before proceeding.</p>
      <span class="tp-date">Last updated: <?php echo date( 'F Y' ); ?></span>

      <!-- 1. About Us -->
      <h2><span class="dashicons dashicons-store"></span> 1. About Travotech Agencies</h2>
      <p><strong>Travotech Agencies</strong> is a licensed pharmacy operating under the Pharmacy and Poisons Board of Kenya. We provide prescription and over-the-counter medicines, healthcare products, and pharmaceutical consultations to customers across Kenya, with delivery services available nationwide.</p>
      <p>By using our website or services, you confirm that you are at least 18 years of age, or are acting under the supervision of a parent or legal guardian.</p>

      <!-- 2. Use of Website -->
      <h2><span class="dashicons dashicons-admin-site-alt3"></span> 2. Use of Our Website</h2>
      <p>You agree to use this website only for lawful purposes and in a manner that does not infringe the rights of others. You must not:</p>
      <div class="tp-list">
        <div class="tp-list-item"><span class="dashicons dashicons-no-alt"></span><span>Use the site to transmit any harmful, fraudulent, or unlawful content.</span></div>
        <div class="tp-list-item"><span class="dashicons dashicons-no-alt"></span><span>Attempt to gain unauthorised access to any part of our website or systems.</span></div>
        <div class="tp-list-item"><span class="dashicons dashicons-no-alt"></span><span>Submit false prescriptions or misrepresent your identity or medical information.</span></div>
        <div class="tp-list-item"><span class="dashicons dashicons-no-alt"></span><span>Use automated tools to scrape, copy, or republish content from this site.</span></div>
      </div>
      <p>We reserve the right to suspend or terminate access to any user who violates these terms.</p>

      <!-- 3. Orders & Prescriptions -->
      <h2><span class="dashicons dashicons-clipboard"></span> 3. Orders &amp; Prescription Requirements</h2>
      <p>All prescription medicines require a valid prescription from a licensed healthcare provider registered in Kenya. By placing an order for prescription medicine, you confirm that:</p>
      <div class="tp-list">
        <div class="tp-list-item"><span class="dashicons dashicons-yes-alt"></span><span>The prescription was issued to you personally by a licensed doctor or healthcare provider.</span></div>
        <div class="tp-list-item"><span class="dashicons dashicons-yes-alt"></span><span>You have provided an accurate, unaltered copy of the prescription.</span></div>
        <div class="tp-list-item"><span class="dashicons dashicons-yes-alt"></span><span>The prescription has not expired and has not already been dispensed in full elsewhere.</span></div>
      </div>
      <div class="tp-callout danger">
        <span class="dashicons dashicons-warning"></span>
        <span>Submitting a forged, altered, or fraudulent prescription is a criminal offence under Kenyan law and will be reported to the relevant authorities immediately.</span>
      </div>
      <p>We reserve the right to verify prescriptions with the issuing healthcare provider before dispensing any medication.</p>

      <!-- 4. Payment Terms -->
      <h2><span class="dashicons dashicons-money-alt"></span> 4. Payment Terms</h2>
      <p>Payment terms vary based on your delivery location. Please review the zone that applies to your order:</p>

      <div class="tp-zone-grid">
        <div class="tp-zone-card nairobi">
          <span class="tz-icon dashicons dashicons-building"></span>
          <div class="tz-badge">
            <span class="dashicons dashicons-yes-alt" style="font-size:14px;width:14px;height:14px;"></span>
            Nairobi
          </div>
          <div class="tz-title">Nairobi County</div>
          <div class="tz-amount">Pay on Delivery</div>
          <div class="tz-sub">Pay in full when your order arrives, by our rider in Cash or via M-Pesa Till No. <strong>TILL_NUMBER_HERE</strong> (TRAVOTECH AGENCIES). No advance payment needed.</div>
        </div>
        <div class="tp-zone-card county">
          <span class="tz-icon dashicons dashicons-admin-site-alt3"></span>
          <div class="tz-badge">
            <span class="dashicons dashicons-warning" style="font-size:14px;width:14px;height:14px;"></span>
            Other Counties
          </div>
          <div class="tz-title">Outside Nairobi</div>
          <div class="tz-amount">Full Payment</div>
          <div class="tz-sub">100% of the order total must be fully paid and confirmed before your order is dispatched for delivery.</div>
        </div>
      </div>

      <div class="tp-callout warning">
        <span class="dashicons dashicons-warning"></span>
        <span>Orders destined for counties outside Nairobi will <strong>not be dispatched</strong> until the <strong>full order payment</strong> has been received and confirmed by our team. Contact us on <a href="tel:+254720737151">+254 720 737 151</a> after completing your payment.</span>
      </div>

      <p>We accept the following payment methods:</p>
      <div class="tp-methods">
        <div class="tp-method"><span class="dashicons dashicons-smartphone"></span> M-Pesa Till: TILL_NUMBER_HERE (TRAVOTECH AGENCIES)</div>
        <div class="tp-method"><span class="dashicons dashicons-money-alt"></span> Cash on Delivery</div>
        <div class="tp-method"><span class="dashicons dashicons-credit-card"></span> Visa / Mastercard</div>
        <div class="tp-method"><span class="dashicons dashicons-bank"></span> Bank Transfer</div>
      </div>

      <!-- 5. Delivery -->
      <h2><span class="dashicons dashicons-car"></span> 5. Delivery Terms</h2>
      <p><strong>Nairobi:</strong> Same-day or next-day delivery for orders confirmed before 2:00 PM on business days.</p>
      <p><strong>Other Counties:</strong> 1–3 business days after dispatch. Delivery times are estimates and may vary due to courier availability, public holidays, or circumstances beyond our control.</p>
      <div class="tp-callout info">
        <span class="dashicons dashicons-info"></span>
        <span>You are responsible for providing an accurate delivery address and ensuring someone is available to receive and pay for the order. Failed deliveries due to incorrect addresses or unavailability may incur a re-delivery fee.</span>
      </div>

      <!-- 6. Cancellation & Refunds -->
      <h2><span class="dashicons dashicons-undo"></span> 6. Cancellations &amp; Refunds</h2>
      <p><strong>Before dispatch:</strong> You may cancel your order at any time before it is dispatched. Any payment made will be refunded in full within 1–3 business days.</p>
      <p><strong>After dispatch:</strong> Orders cannot be cancelled once dispatched. You may refuse delivery, but return shipping costs will be deducted from any applicable refund.</p>
      <p><strong>Refund eligibility:</strong></p>
      <div class="tp-list">
        <div class="tp-list-item"><span class="dashicons dashicons-yes-alt"></span><span><strong>Full refund:</strong> Wrong product received, damaged or expired product on arrival, or order not delivered.</span></div>
        <div class="tp-list-item"><span class="dashicons dashicons-yes-alt"></span><span><strong>Partial refund:</strong> Missing items or partial order fulfilment errors.</span></div>
        <div class="tp-list-item"><span class="dashicons dashicons-no-alt"></span><span><strong>No refund:</strong> Dispensed prescription medicines, opened or used products, or orders cancelled after dispatch.</span></div>
      </div>
      <p>All refund requests must be submitted within <strong>48 hours</strong> of delivery by contacting us on <a href="tel:+254720737151">+254 720 737 151</a>.</p>

      <!-- 7. Pricing -->
      <h2><span class="dashicons dashicons-tag"></span> 7. Pricing &amp; Availability</h2>
      <p>All prices on our website are displayed in Kenyan Shillings (KES) and are inclusive of applicable taxes unless otherwise stated. Prices are subject to change without prior notice. In the event of a pricing error, we reserve the right to cancel or amend your order and will notify you promptly.</p>
      <p>Product availability is not guaranteed. If a product becomes unavailable after your order is placed, we will contact you to offer a suitable alternative or a full refund.</p>

      <!-- 8. Intellectual Property -->
      <h2><span class="dashicons dashicons-lock"></span> 8. Intellectual Property</h2>
      <p>All content on this website, including text, images, logos, graphics, and product descriptions is the property of Travotech Agencies or its content suppliers and is protected under Kenyan and international intellectual property law.</p>
      <p>You may not reproduce, distribute, or use any content from this website for commercial purposes without our express written permission.</p>

      <!-- 9. Limitation of Liability -->
      <h2><span class="dashicons dashicons-shield"></span> 9. Limitation of Liability</h2>
      <p>Travotech Agencies shall not be liable for any indirect, incidental, or consequential damages arising from the use of our website or services. Our total liability in any matter arising from these terms shall not exceed the value of the order in question.</p>
      <div class="tp-callout info">
        <span class="dashicons dashicons-info-outline"></span>
        <span>Health information provided on our website is for general guidance only and does not constitute medical advice. Always consult a qualified healthcare provider before starting, stopping, or changing any medication.</span>
      </div>

      <!-- 10. Privacy -->
      <h2><span class="dashicons dashicons-privacy"></span> 10. Privacy</h2>
      <p>Your use of our website and services is also governed by our <a href="<?php echo esc_url( home_url('/privacy-policy/') ); ?>">Privacy Policy</a>, which is incorporated into these Terms &amp; Conditions by reference. By using our services, you consent to the collection and use of your information as described in that policy.</p>

      <!-- 11. Governing Law -->
      <h2><span class="dashicons dashicons-admin-home"></span> 11. Governing Law</h2>
      <p>These Terms &amp; Conditions are governed by and construed in accordance with the laws of the Republic of Kenya. Any disputes arising out of or in connection with these terms shall be subject to the exclusive jurisdiction of the Kenyan courts.</p>
      <p>We are also bound by the regulations of the <strong>Pharmacy and Poisons Board of Kenya</strong> and the <strong>Kenya Data Protection Act, 2019</strong>.</p>

      <!-- 12. Changes to Terms -->
      <h2><span class="dashicons dashicons-edit"></span> 12. Changes to These Terms</h2>
      <p>We reserve the right to update or revise these Terms &amp; Conditions at any time. The revised version will be posted on this page with an updated date. Your continued use of our website or services after any changes constitutes your acceptance of the new terms.</p>

      <!-- 13. Contact -->
      <h2><span class="dashicons dashicons-phone"></span> 13. Contact Us</h2>
      <p>If you have any questions about these Terms &amp; Conditions, please contact us:</p>

      <div class="tp-contact-box">
        <div class="tp-contact-row">
          <span class="dashicons dashicons-store"></span>
          <strong>Travotech Agencies</strong>
        </div>
        <div class="tp-contact-row">
          <span class="dashicons dashicons-location"></span>
          <span>Utawala Astrol (Nairobi)</span>
        </div>
        <div class="tp-contact-row">
          <span class="dashicons dashicons-phone"></span>
          <a href="tel:+254720737151">+254 720 737 151</a>
        </div>
        <div class="tp-contact-row">
          <span class="dashicons dashicons-whatsapp" style="color:#25d366;"></span>
          <a href="https://wa.me/254720737151" target="_blank" rel="noopener">WhatsApp: +254 720 737 151</a>
        </div>
        <div class="tp-contact-row">
          <span class="dashicons dashicons-email-alt"></span>
          <a href="mailto:sales@travotechagencies.co.ke">sales@travotechagencies.co.ke</a>
        </div>
        <div class="tp-contact-row">
          <span class="dashicons dashicons-admin-site-alt3"></span>
          <a href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_url( home_url() ); ?></a>
        </div>
      </div>

    </div><!-- /.tp-inner -->
  </section><!-- /.tp-content -->

</div><!-- /.terms-page -->

<script>
(function () {
  const canvas  = document.getElementById('tp-bubble-canvas');
  if (!canvas) return;
  const section = canvas.closest('.tp-content');
  const ctx     = canvas.getContext('2d');

  function resize() {
    canvas.width  = section.offsetWidth;
    canvas.height = section.offsetHeight;
  }
  resize();
  window.addEventListener('resize', resize);
  new ResizeObserver(resize).observe(section);

  function rand(a, b) { return Math.random() * (b - a) + a; }

  function drawCross(ctx, x, y, r) {
    const arm = r * 0.38, thick = r * 0.13;
    ctx.save();
    ctx.globalAlpha = 0.72;
    ctx.fillStyle = '#e53935';
    ctx.beginPath(); ctx.roundRect(x - arm, y - thick, arm * 2, thick * 2, thick * 0.5); ctx.fill();
    ctx.beginPath(); ctx.roundRect(x - thick, y - arm, thick * 2, arm * 2, thick * 0.5); ctx.fill();
    ctx.fillStyle = 'rgba(255,255,255,0.55)';
    ctx.beginPath(); ctx.arc(x, y, thick * 0.55, 0, Math.PI * 2); ctx.fill();
    ctx.restore();
  }

  function draw3DBubble(ctx, x, y, r, baseColor) {
    const bg = ctx.createRadialGradient(x-r*.25, y-r*.25, r*.05, x, y, r);
    bg.addColorStop(0,   'rgba(255,255,255,0.55)');
    bg.addColorStop(0.4, baseColor.replace('BASE','0.18'));
    bg.addColorStop(0.8, baseColor.replace('BASE','0.32'));
    bg.addColorStop(1,   baseColor.replace('BASE','0.50'));
    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fillStyle=bg; ctx.fill();

    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2);
    ctx.strokeStyle=baseColor.replace('BASE','0.55'); ctx.lineWidth=r*.045; ctx.stroke();

    const g1=ctx.createRadialGradient(x-r*.32,y-r*.36,r*.01,x-r*.20,y-r*.20,r*.52);
    g1.addColorStop(0,'rgba(255,255,255,0.80)'); g1.addColorStop(.5,'rgba(255,255,255,0.20)'); g1.addColorStop(1,'rgba(255,255,255,0.00)');
    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fillStyle=g1; ctx.fill();

    const g2=ctx.createRadialGradient(x+r*.30,y+r*.28,0,x+r*.30,y+r*.28,r*.18);
    g2.addColorStop(0,'rgba(255,255,255,0.45)'); g2.addColorStop(1,'rgba(255,255,255,0.00)');
    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fillStyle=g2; ctx.fill();

    ctx.save();
    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.clip();
    const cg=ctx.createRadialGradient(x,y+r*.85,r*.1,x,y+r,r*.6);
    cg.addColorStop(0,baseColor.replace('BASE','0.35')); cg.addColorStop(1,'rgba(255,255,255,0.00)');
    ctx.beginPath(); ctx.arc(x,y+r*.72,r*.55,0,Math.PI*2); ctx.fillStyle=cg; ctx.fill();
    ctx.restore();

    drawCross(ctx, x, y, r);
  }

  const COLORS = [
    'rgba(46,175,110,BASE)','rgba(30,138,84,BASE)',
    'rgba(61,201,126,BASE)','rgba(184,236,212,BASE)',
    'rgba(102,210,155,BASE)',
  ];

  const bubbles = [];
  const COUNT   = 18;

  function makeBubble(forceBottom) {
    const r = rand(50, 115);
    return {
      x : rand(r, canvas.width - r),
      y : forceBottom ? rand(canvas.height, canvas.height + r*2) : rand(r, canvas.height - r),
      r,
      color  : COLORS[Math.floor(rand(0, COLORS.length))],
      dx     : rand(-0.45, 0.45),
      dy     : rand(-0.55, -0.15),
      phase  : rand(0, Math.PI * 2),
      wobble : rand(0.004, 0.010),
    };
  }

  for (let i = 0; i < COUNT; i++) bubbles.push(makeBubble(false));

  function tick() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    bubbles.forEach((b, i) => {
      b.phase += b.wobble;
      b.x += b.dx + Math.sin(b.phase * 0.7) * 0.3;
      b.y += b.dy;
      if (b.x - b.r < 0)            { b.x = b.r;                b.dx =  Math.abs(b.dx); }
      if (b.x + b.r > canvas.width) { b.x = canvas.width - b.r; b.dx = -Math.abs(b.dx); }
      if (b.y + b.r < 0)            { bubbles[i] = makeBubble(true); return; }
      draw3DBubble(ctx, b.x, b.y, b.r, b.color);
    });
    requestAnimationFrame(tick);
  }
  tick();
})();
</script>

<?php get_footer(); ?>
