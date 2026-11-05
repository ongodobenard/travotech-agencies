<?php
/**
 * Privacy Policy Page Template
 * Slug: privacy-policy
 * WordPress loads this directly — get_header() / get_footer() required here.
 */

get_header();
wp_enqueue_style( 'dashicons' );
?>

<style>
/* ── Page wrapper ────────────────────────────────── */
.privacy-policy-page {
  position: relative;
}

/* ── Banner ──────────────────────────────────────── */
.privacy-policy-page .pp-banner {
  background: #2dbebc;
  color: #fff;
  padding: 64px 0 52px;
  text-align: center;
  position: relative;
  overflow: hidden;
  z-index: 1;
}
.privacy-policy-page .pp-banner::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(255,255,255,.08);
}
.privacy-policy-page .pp-banner .pp-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 700;
  color: #fff;
  margin: 0 0 12px;
  position: relative;
  z-index: 1;
  text-shadow: 0 2px 20px rgba(0,0,0,.15);
}
.privacy-policy-page .pp-breadcrumb {
  font-size: .82rem;
  font-weight: 600;
  color: rgba(255,255,255,.8);
  position: relative;
  z-index: 1;
}
.privacy-policy-page .pp-breadcrumb a {
  color: #fff;
  text-decoration: underline;
  font-weight: 700;
}
.privacy-policy-page .pp-breadcrumb a:hover { color: #b0f4f3; }

/* ── Content section — bubble stage ─────────────── */
.privacy-policy-page .pp-content {
  position: relative;
  padding: 60px 5%;
  background: #e9fbfb;
  overflow: hidden; /* clips bubbles to this zone only */
  z-index: 1;
}

/* Canvas lives INSIDE .pp-content */
#pp-bubble-canvas {
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  pointer-events: none;
  z-index: 0;
}

/* ── Policy card — floats above bubbles ──────────── */
.privacy-policy-page .policy-inner {
  position: relative;
  z-index: 2;
  max-width: 860px;
  margin: 0 auto;
  background: rgba(255,255,255,.88);
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  padding: 44px 52px;
  border-radius: 20px;
  border: 1.5px solid rgba(176,244,243,.7);
  box-shadow: 0 8px 40px rgba(54,208,205,.12), 0 2px 12px rgba(0,0,0,.04);
}
.privacy-policy-page .policy-inner h2 {
  font-family: 'Nunito', sans-serif;
  color: #103837;
  font-size: 1.15rem;
  font-weight: 800;
  margin: 36px 0 10px;
  padding-bottom: 10px;
  border-bottom: 2px solid #e5fbfb;
}
.privacy-policy-page .policy-inner h2:first-of-type { margin-top: 0; }
.privacy-policy-page .policy-inner p {
  color: #2dbebc;
  font-size: .88rem;
  line-height: 1.85;
  margin-bottom: 14px;
  font-weight: 500;
}
.privacy-policy-page .policy-inner .pp-intro {
  font-size: .95rem;
  color: #103837;
  font-weight: 600;
  background: #eefcfc;
  border-left: 4px solid #36d0cd;
  padding: 16px 20px;
  border-radius: 0 10px 10px 0;
  margin-bottom: 28px;
}
.privacy-policy-page .policy-inner .pp-date {
  font-size: .78rem;
  color: #5bd9d7;
  font-style: italic;
  margin-bottom: 32px;
  display: block;
}
.privacy-policy-page .policy-inner a {
  color: #36d0cd;
  text-decoration: underline;
  font-weight: 700;
}
.privacy-policy-page .policy-inner a:hover { color: #2dbebc; }

/* ── Contact box ─────────────────────────────────── */
.privacy-policy-page .policy-inner .pp-contact-box {
  background: #eefcfc;
  border: 1.5px solid #b0f4f3;
  border-radius: 12px;
  padding: 22px 26px;
  margin-top: 10px;
  overflow: hidden;
}
.privacy-policy-page .policy-inner .pp-contact-box .pp-contact-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
  font-size: .88rem;
  color: #2dbebc;
  font-weight: 500;
  min-width: 0; /* allow flex children to shrink */
}
.privacy-policy-page .policy-inner .pp-contact-box .pp-contact-row:last-child { margin-bottom: 0; }
.privacy-policy-page .policy-inner .pp-contact-box .pp-contact-row .dashicons {
  color: #36d0cd;
  font-size: 18px;
  width: 18px;
  height: 18px;
  flex-shrink: 0;
}
.privacy-policy-page .policy-inner .pp-contact-box .pp-contact-row span,
.privacy-policy-page .policy-inner .pp-contact-box .pp-contact-row strong {
  word-break: break-word;
  overflow-wrap: anywhere;
  min-width: 0;
}
.privacy-policy-page .policy-inner .pp-contact-box .pp-contact-row a {
  color: #36d0cd;
  font-weight: 700;
  text-decoration: none;
  word-break: break-all;
  overflow-wrap: anywhere;
  min-width: 0;
}
.privacy-policy-page .policy-inner .pp-contact-box .pp-contact-row a:hover {
  color: #2dbebc;
  text-decoration: underline;
}

@media(max-width: 768px) {
  .privacy-policy-page .policy-inner { padding: 28px 20px; }
}
</style>

<div class="privacy-policy-page">

  <!-- ── Banner (no bubbles) ── -->
  <section class="pp-banner">
    <div style="max-width:1200px;margin:0 auto;padding:0 5%;">
      <h1 class="pp-title"><?php the_title(); ?></h1>
      <nav class="pp-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url( home_url() ); ?>">Home</a>
        &rsaquo;
        <span><?php the_title(); ?></span>
      </nav>
    </div>
  </section>

  <!-- ── Content (bubbles live here only) ── -->
  <section class="pp-content">

    <!-- Canvas scoped to this section -->
    <canvas id="pp-bubble-canvas"></canvas>

    <div class="policy-inner">

      <p class="pp-intro">At <strong>Travotech Agencies</strong>, your privacy and the confidentiality of your health information are of the utmost importance to us. This policy explains how we collect, use, protect, and share your information when you use our services.</p>
      <span class="pp-date">Last updated: <?php echo date( 'F Y' ); ?></span>

      <h2>1. Information We Collect</h2>
      <p><strong>Personal &amp; Contact Details:</strong> Your full name, phone number, email address, and delivery address when you place an order or register an account.</p>
      <p><strong>Health &amp; Prescription Information:</strong> Prescription details, medication history, and health-related information you submit when ordering prescription medicines or using our consultation service. This is treated with the highest level of confidentiality.</p>
      <p><strong>Payment Information:</strong> Billing details processed securely through our payment providers (card processors). We do not store your full card details on our servers.</p>
      <p><strong>Device &amp; Usage Data:</strong> IP address, browser type, and pages visited, collected automatically to help us improve your experience.</p>

      <h2>2. How We Use Your Information</h2>
      <p>We use the information we collect to process and fulfill your medication orders and prescription requests accurately and safely; verify prescriptions with licensed healthcare providers where required by Kenyan law; send order confirmations and delivery updates via SMS or email; maintain a secure medication history to assist with repeat prescriptions and drug interaction checks; and comply with regulations set by the Pharmacy and Poisons Board of Kenya.</p>

      <h2>3. Prescription &amp; Medical Data Confidentiality</h2>
      <p>All prescription data and health-related information you share with us is strictly confidential. It is accessible only to our licensed pharmacists and relevant healthcare staff on a need-to-know basis. We do not sell, rent, or share your medical information with any third party for marketing purposes ever.</p>
      <p>Prescription records are retained in accordance with the Pharmacy and Poisons Board of Kenya requirements and applicable health regulations.</p>

      <h2>4. Sharing Your Information</h2>
      <p><strong>Delivery Partners:</strong> Your name and address are shared with our courier partners solely to fulfill your order.</p>
      <p><strong>Payment Processors:</strong> Payment details are securely handled by our PCI-compliant payment providers.</p>
      <p><strong>Healthcare Providers:</strong> With your consent, or where legally required, prescription information may be shared with the prescribing doctor or relevant health authority.</p>
      <p><strong>Legal Compliance:</strong> We may disclose information if required by law, court order, or a government authority in Kenya.</p>

      <h2>5. Data Security</h2>
      <p>We implement industry-standard security measures including SSL encryption on all data transmissions, secure access controls, and regular security audits. While we take every reasonable precaution, we encourage you to keep your account credentials confidential and contact us immediately if you suspect unauthorized access.</p>

      <h2>6. Cookies</h2>
      <p>Our website uses cookies to enhance your browsing experience, remember your cart items, and understand how visitors use our site. You can control cookie settings through your browser preferences. Disabling cookies may affect some functionality such as maintaining your shopping cart.</p>

      <h2>7. Your Rights</h2>
      <p>Under the <strong>Kenya Data Protection Act, 2019</strong>, you have the right to access the personal data we hold about you; correct any inaccurate information; request deletion of your data subject to our legal retention obligations; and withdraw consent for marketing communications at any time. To exercise any of these rights, contact us at <a href="mailto:sales@travotechagencies.co.ke">sales@travotechagencies.co.ke</a>.</p>

      <h2>8. Children's Privacy</h2>
      <p>Our services are not directed at children under 18. If you are ordering medication on behalf of a child, a parent or legal guardian must complete the transaction. We do not knowingly collect personal data from minors without verified parental consent.</p>

      <h2>9. Third-Party Links</h2>
      <p>Our website may contain links to third-party sites such as health information portals or insurance providers. We are not responsible for the privacy practices of those sites and encourage you to review their policies independently.</p>

      <h2>10. Changes to This Policy</h2>
      <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. The updated version will always be available on this page with the revised date shown above. Continued use of our services after any changes constitutes your acceptance of the updated policy.</p>

      <h2>11. Contact Us</h2>
      <p>If you have any questions or requests regarding this Privacy Policy, please get in touch:</p>
      <div class="pp-contact-box">
        <div class="pp-contact-row">
          <span class="dashicons dashicons-store"></span>
          <strong>Travotech Agencies</strong>
        </div>
        <div class="pp-contact-row">
          <span class="dashicons dashicons-location"></span>
          <span>Utawala Astrol (Nairobi)</span>
        </div>
        <div class="pp-contact-row">
          <span class="dashicons dashicons-phone"></span>
          <a href="tel:+254720737151">+254 720 737 151</a>
        </div>
        <div class="pp-contact-row">
          <span class="dashicons dashicons-email-alt"></span>
          <a href="mailto:sales@travotechagencies.co.ke">sales@travotechagencies.co.ke</a>
        </div>
        <div class="pp-contact-row">
          <span class="dashicons dashicons-admin-site-alt3"></span>
          <a href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_url( home_url() ); ?></a>
        </div>
      </div>

    </div><!-- /.policy-inner -->
  </section><!-- /.pp-content -->

</div><!-- /.privacy-policy-page -->

<script>
(function () {
  const canvas  = document.getElementById('pp-bubble-canvas');
  if (!canvas) return;
  const section = canvas.closest('.pp-content');
  const ctx     = canvas.getContext('2d');

  /* ── Size canvas to match its parent section ── */
  function resize() {
    canvas.width  = section.offsetWidth;
    canvas.height = section.offsetHeight;
  }
  resize();
  window.addEventListener('resize', resize);
  new ResizeObserver(resize).observe(section);

  /* ── Helpers ── */
  function rand(a, b) { return Math.random() * (b - a) + a; }

  /* ── Draw red medical cross inside bubble ── */
  function drawCross(ctx, x, y, r) {
    const arm   = r * 0.38;   /* half-length of each arm */
    const thick = r * 0.13;   /* half-thickness of bar   */
    const alpha = 0.72;

    ctx.save();
    ctx.globalAlpha = alpha;

    /* Red fill */
    ctx.fillStyle = '#e53935';

    /* Horizontal bar */
    ctx.beginPath();
    ctx.roundRect(x - arm, y - thick, arm * 2, thick * 2, thick * 0.5);
    ctx.fill();

    /* Vertical bar */
    ctx.beginPath();
    ctx.roundRect(x - thick, y - arm, thick * 2, arm * 2, thick * 0.5);
    ctx.fill();

    /* Tiny white centre dot for depth */
    ctx.fillStyle = 'rgba(255,255,255,0.55)';
    ctx.beginPath();
    ctx.arc(x, y, thick * 0.55, 0, Math.PI * 2);
    ctx.fill();

    ctx.restore();
  }

  /* ── 3-D bubble painter ── */
  function draw3DBubble(ctx, x, y, r, baseColor) {
    /* 1. Soft body fill */
    const bodyGrad = ctx.createRadialGradient(
      x - r * 0.25, y - r * 0.25, r * 0.05,
      x,            y,            r
    );
    bodyGrad.addColorStop(0,   'rgba(255,255,255,0.55)');
    bodyGrad.addColorStop(0.4, baseColor.replace('BASE', '0.18'));
    bodyGrad.addColorStop(0.8, baseColor.replace('BASE', '0.32'));
    bodyGrad.addColorStop(1,   baseColor.replace('BASE', '0.50'));
    ctx.beginPath();
    ctx.arc(x, y, r, 0, Math.PI * 2);
    ctx.fillStyle = bodyGrad;
    ctx.fill();

    /* 2. Rim */
    ctx.beginPath();
    ctx.arc(x, y, r, 0, Math.PI * 2);
    ctx.strokeStyle = baseColor.replace('BASE', '0.55');
    ctx.lineWidth   = r * 0.045;
    ctx.stroke();

    /* 3. Primary glare */
    const glare1 = ctx.createRadialGradient(
      x - r * 0.32, y - r * 0.36, r * 0.01,
      x - r * 0.20, y - r * 0.20, r * 0.52
    );
    glare1.addColorStop(0,   'rgba(255,255,255,0.80)');
    glare1.addColorStop(0.5, 'rgba(255,255,255,0.20)');
    glare1.addColorStop(1,   'rgba(255,255,255,0.00)');
    ctx.beginPath();
    ctx.arc(x, y, r, 0, Math.PI * 2);
    ctx.fillStyle = glare1;
    ctx.fill();

    /* 4. Micro-glare */
    const glare2 = ctx.createRadialGradient(
      x + r * 0.30, y + r * 0.28, 0,
      x + r * 0.30, y + r * 0.28, r * 0.18
    );
    glare2.addColorStop(0, 'rgba(255,255,255,0.45)');
    glare2.addColorStop(1, 'rgba(255,255,255,0.00)');
    ctx.beginPath();
    ctx.arc(x, y, r, 0, Math.PI * 2);
    ctx.fillStyle = glare2;
    ctx.fill();

    /* 5. Bottom crescent */
    ctx.save();
    ctx.beginPath();
    ctx.arc(x, y, r, 0, Math.PI * 2);
    ctx.clip();
    const cGrad = ctx.createRadialGradient(x, y + r * 0.85, r * 0.1, x, y + r, r * 0.6);
    cGrad.addColorStop(0, baseColor.replace('BASE', '0.35'));
    cGrad.addColorStop(1, 'rgba(255,255,255,0.00)');
    ctx.beginPath();
    ctx.arc(x, y + r * 0.72, r * 0.55, 0, Math.PI * 2);
    ctx.fillStyle = cGrad;
    ctx.fill();
    ctx.restore();

    /* 6. Red medical cross — centred in bubble */
    drawCross(ctx, x, y, r);
  }

  /* ── Bubble colours — theme greens ── */
  const COLORS = [
    'rgba(54,208,205,BASE)',
    'rgba(45,190,188,BASE)',
    'rgba(87,216,214,BASE)',
    'rgba(176,244,243,BASE)',
    'rgba(95,217,215,BASE)',
  ];

  const COUNT   = 18;
  const bubbles = [];

  function makeBubble(forceBottom) {
    const r     = rand(50, 115);
    const color = COLORS[Math.floor(rand(0, COLORS.length))];
    return {
      x     : rand(r, canvas.width  - r),
      y     : forceBottom
                ? rand(canvas.height, canvas.height + r * 2)
                : rand(r, canvas.height - r),
      r, color,
      dx    : rand(-0.45, 0.45),
      dy    : rand(-0.55, -0.15),
      phase : rand(0, Math.PI * 2),
      wobble: rand(0.004, 0.010),
    };
  }

  for (let i = 0; i < COUNT; i++) bubbles.push(makeBubble(false));

  /* ── Animation loop ── */
  function tick() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    bubbles.forEach((b, i) => {
      b.phase += b.wobble;
      b.x     += b.dx + Math.sin(b.phase * 0.7) * 0.3;
      b.y     += b.dy;

      if (b.x - b.r < 0)             { b.x = b.r;               b.dx =  Math.abs(b.dx); }
      if (b.x + b.r > canvas.width)  { b.x = canvas.width - b.r; b.dx = -Math.abs(b.dx); }
      if (b.y + b.r < 0)             { bubbles[i] = makeBubble(true); return; }

      draw3DBubble(ctx, b.x, b.y, b.r, b.color);
    });

    requestAnimationFrame(tick);
  }

  tick();
})();
</script>

<?php get_footer(); ?>
