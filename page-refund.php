<?php
/**
 * Template Name: Return Refund Policy
 */
get_header();
wp_enqueue_style( 'dashicons' );
?>

<style>
/* ── WhatsApp Button ── */
.wa-cta-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  background: var(--green);
  color: white;
  padding: 13px 28px;
  border-radius: 50px;
  font-size: .92rem;
  font-weight: 800;
  font-family: 'Nunito', sans-serif;
  text-decoration: none;
  transition: all .3s;
  box-shadow: 0 6px 20px rgba(46,175,110,.3);
  white-space: nowrap;
}
.wa-cta-btn:hover {
  background: var(--green-dark);
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(46,175,110,.4);
}

/* ── Bubble content wrapper ── */
.refund-bubble-zone {
  position: relative;
  background: white;
  padding: 56px 5%;
  overflow: hidden;
}
#refund-bubble-canvas {
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  pointer-events: none;
  z-index: 0;
}
.refund-bubble-zone .refund-inner {
  position: relative;
  z-index: 2;
  max-width: 820px;
  margin: 0 auto;
}

/* ── Feature cards — glassmorphism over bubbles ── */
.refund-bubble-zone .why-feat {
  background: rgba(255,255,255,.88);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border: 1.5px solid rgba(184,236,212,.7);
  box-shadow: 0 4px 20px rgba(46,175,110,.08);
}

/* ── Terms link banner ── */
.terms-link-banner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  background: linear-gradient(135deg, #1e8a54, #2eaf6e);
  border-radius: 14px;
  padding: 20px 26px;
  margin-bottom: 32px;
  flex-wrap: wrap;
}
.terms-link-banner .tlb-text {
  display: flex;
  align-items: center;
  gap: 12px;
}
.terms-link-banner .tlb-text .dashicons {
  color: #fff;
  font-size: 26px;
  width: 26px;
  height: 26px;
  flex-shrink: 0;
}
.terms-link-banner .tlb-title {
  font-size: .92rem;
  font-weight: 900;
  color: #fff;
  font-family: 'Nunito', sans-serif;
}
.terms-link-banner .tlb-sub {
  font-size: .76rem;
  color: rgba(255,255,255,.8);
  font-weight: 500;
  margin-top: 2px;
}
.terms-link-banner .tlb-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  background: #fff;
  color: var(--green);
  padding: 10px 20px;
  border-radius: 50px;
  font-size: .82rem;
  font-weight: 900;
  font-family: 'Nunito', sans-serif;
  text-decoration: none;
  transition: all .25s;
  white-space: nowrap;
  flex-shrink: 0;
}
.terms-link-banner .tlb-btn:hover {
  background: var(--green-light);
  transform: translateY(-1px);
}
.terms-link-banner .tlb-btn .dashicons {
  font-size: 16px; width: 16px; height: 16px;
}

@media (max-width: 768px) {
  .wa-cta-btn {
    font-size: .78rem;
    padding: 11px 18px;
    gap: 7px;
    white-space: normal;
    text-align: center;
    max-width: 280px;
    width: 100%;
  }
  .wa-cta-btn svg { width: 16px; height: 16px; flex-shrink: 0; }
  .terms-link-banner { flex-direction: column; align-items: flex-start; }
}

@media (max-width: 480px) {
  .wa-cta-btn {
    font-size: .72rem;
    padding: 10px 14px;
    gap: 6px;
    max-width: 260px;
  }
  .wa-cta-btn svg { width: 14px; height: 14px; }
  .btn-outline {
    font-size: .72rem !important;
    padding: 10px 14px !important;
  }
}
</style>

<!-- ── Banner ── -->
<section style="background:var(--green-pale);padding:56px 5%;text-align:center;">
  <div class="sec-tag sec-tag-outline reveal">Legal</div>
  <h1 class="sec-title reveal rd1">Return &amp; <span>Refund Policy</span></h1>
  <p class="sec-desc reveal rd2" style="margin:0 auto;">Please read our return and refund policy carefully before making a purchase.</p>
</section>

<!-- ── Content with 3D Bubbles ── -->
<section class="refund-bubble-zone">

  <!-- Bubble canvas scoped to this section only -->
  <canvas id="refund-bubble-canvas"></canvas>

  <div class="refund-inner">

    <!-- ── Terms & Conditions Link Banner ── -->
    <div class="terms-link-banner reveal">
      <div class="tlb-text">
        <span class="dashicons dashicons-media-text"></span>
        <div>
          <div class="tlb-title">Also review our Terms &amp; Conditions</div>
          <div class="tlb-sub">Our T&amp;Cs cover payment zones, delivery, pricing, and your legal rights as a customer.</div>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url('/terms') ); ?>" class="tlb-btn">
        <span class="dashicons dashicons-arrow-right-alt"></span>
        Read Terms &amp; Conditions
      </a>
    </div>

    <!-- 1. Returns Eligibility -->
    <div class="why-feat reveal" style="margin-bottom:20px;">
      <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg></div>
      <div>
        <div class="wf-title">1. Returns Eligibility</div>
        <div class="wf-desc">Products may be returned within <strong>7 days</strong> of purchase if unused, in original packaging, and with proof of purchase. Prescription medicines and opened products cannot be returned for safety reasons.</div>
      </div>
    </div>

    <!-- 2. Non-Returnable Items -->
    <div class="why-feat reveal rd1" style="margin-bottom:20px;">
      <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
      <div>
        <div class="wf-title">2. Non-Returnable Items</div>
        <div class="wf-desc">The following cannot be returned: prescription medicines, opened supplements, perishable health products, personal care items, and any product used or damaged after delivery.</div>
      </div>
    </div>

    <!-- 3. Refund Process -->
    <div class="why-feat reveal rd2" style="margin-bottom:20px;">
      <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
      <div>
        <div class="wf-title">3. Refund Process</div>
        <div class="wf-desc">Once your return is received and inspected, we will notify you via WhatsApp or email. Approved refunds are processed within <strong>3–5 business days</strong> via your original payment method.</div>
      </div>
    </div>

    <!-- 4. Damaged or Wrong Items -->
    <div class="why-feat reveal rd3" style="margin-bottom:20px;">
      <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
      <div>
        <div class="wf-title">4. Damaged or Wrong Items</div>
        <div class="wf-desc">If you received a damaged or incorrect item, contact us within <strong>24 hours</strong> of delivery via WhatsApp with a photo. We will arrange a replacement or full refund at no extra cost.</div>
      </div>
    </div>

    <!-- 5. Exchange Policy -->
    <div class="why-feat reveal" style="margin-bottom:20px;">
      <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 014-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 01-4 4H3"/></svg></div>
      <div>
        <div class="wf-title">5. Exchange Policy</div>
        <div class="wf-desc">We offer exchanges for eligible products within 7 days. The exchanged item must be of equal or greater value. Any price difference must be settled before the exchange is processed.</div>
      </div>
    </div>

    <!-- 6. How to Initiate a Return -->
    <div class="why-feat reveal rd1" style="margin-bottom:20px;">
      <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg></div>
      <div>
        <div class="wf-title">6. How to Initiate a Return</div>
        <div class="wf-desc">Contact us via WhatsApp at <strong>+254 720 737 151</strong> or email <strong>orders@travotechpharmacy.co.ke</strong> with your order details and reason for return.</div>
      </div>
    </div>

    <!-- 7. Governing Law -->
    <div class="why-feat reveal rd2" style="margin-bottom:20px;">
      <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
      <div>
        <div class="wf-title">7. Governing Law</div>
        <div class="wf-desc">This policy is governed by the laws of Kenya and the regulations of the Pharmacy and Poisons Board of Kenya. Any disputes shall be resolved in accordance with Kenyan consumer protection laws. For full legal terms, see our <a href="<?php echo esc_url( home_url('/terms') ); ?>" style="color:var(--green);font-weight:700;">Terms &amp; Conditions</a>.</div>
      </div>
    </div>

    <!-- ── CTA Box ── -->
    <div style="background:rgba(240,250,245,.95);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-radius:16px;border:1.5px solid rgba(184,236,212,.7);padding:28px;text-align:center;margin-top:40px;" class="reveal">
      <div style="font-size:1rem;font-weight:900;color:var(--text);margin-bottom:8px;">Still Have Questions?</div>
      <p style="font-size:.82rem;color:var(--text-light);margin-bottom:20px;">Contact our team and we'll help resolve any issue quickly.</p>
      <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;align-items:center;">

        <!-- WhatsApp Button -->
        <a href="https://wa.me/254720737151?text=<?php echo urlencode('Hello Travotech Agencies! I have a question about your Return and Refund Policy.'); ?>"
           class="wa-cta-btn"
           target="_blank"
           rel="noopener">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
          </svg>
          Chat on WhatsApp: +254 720 737 151
        </a>

        <!-- Terms & Conditions Button -->
        <a href="<?php echo esc_url( home_url('/terms') ); ?>" class="btn-outline">
          Terms &amp; Conditions
        </a>

        <!-- Contact Page Button -->
        <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="btn-outline">Contact Page</a>

      </div>
    </div>

  </div><!-- /.refund-inner -->
</section><!-- /.refund-bubble-zone -->

<script>
(function () {
  const canvas  = document.getElementById('refund-bubble-canvas');
  if (!canvas) return;
  const section = canvas.closest('.refund-bubble-zone');
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
    const bg = ctx.createRadialGradient(x-r*.25,y-r*.25,r*.05,x,y,r);
    bg.addColorStop(0,   'rgba(255,255,255,0.55)');
    bg.addColorStop(0.4, baseColor.replace('BASE','0.18'));
    bg.addColorStop(0.8, baseColor.replace('BASE','0.32'));
    bg.addColorStop(1,   baseColor.replace('BASE','0.50'));
    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fillStyle=bg; ctx.fill();

    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2);
    ctx.strokeStyle=baseColor.replace('BASE','0.55');
    ctx.lineWidth=r*.045; ctx.stroke();

    const g1=ctx.createRadialGradient(x-r*.32,y-r*.36,r*.01,x-r*.20,y-r*.20,r*.52);
    g1.addColorStop(0,'rgba(255,255,255,0.80)');
    g1.addColorStop(.5,'rgba(255,255,255,0.20)');
    g1.addColorStop(1,'rgba(255,255,255,0.00)');
    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fillStyle=g1; ctx.fill();

    const g2=ctx.createRadialGradient(x+r*.30,y+r*.28,0,x+r*.30,y+r*.28,r*.18);
    g2.addColorStop(0,'rgba(255,255,255,0.45)');
    g2.addColorStop(1,'rgba(255,255,255,0.00)');
    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fillStyle=g2; ctx.fill();

    ctx.save();
    ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.clip();
    const cg=ctx.createRadialGradient(x,y+r*.85,r*.1,x,y+r,r*.6);
    cg.addColorStop(0,baseColor.replace('BASE','0.35'));
    cg.addColorStop(1,'rgba(255,255,255,0.00)');
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
      x      : rand(r, canvas.width - r),
      y      : forceBottom ? rand(canvas.height, canvas.height + r*2) : rand(r, canvas.height - r),
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
