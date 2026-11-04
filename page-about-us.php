<?php
/**
 * Template Name: About Us
 */
get_header(); ?>

<style>
/* ── Delivery Section ── */
.rx-delivery { background: var(--green-pale); padding: 56px 5%; }
.rx-delivery-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 32px; }
.delivery-info-box { background: white; border-radius: 16px; padding: 28px; border: 1.5px solid var(--green-light); }
.di-title { font-size: .88rem; font-weight: 900; color: var(--text); margin-bottom: 20px; display: flex; align-items: center; gap: 8px; padding-bottom: 12px; border-bottom: 2px solid var(--green-light); }
.delivery-row { display: flex; gap: 12px; margin-bottom: 18px; align-items: flex-start; }
.delivery-row:last-child { margin-bottom: 0; }
.di-icon { width: 32px; height: 32px; border-radius: 8px; background: var(--green-pale); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.di-label { font-size: .82rem; font-weight: 800; color: var(--text); margin-bottom: 4px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.di-desc { font-size: .76rem; color: var(--text-light); line-height: 1.6; font-weight: 500; }
.di-badge { font-size: .62rem; font-weight: 800; padding: 2px 8px; border-radius: 50px; }
.di-badge--green { background: var(--green-light); color: var(--green); }
.di-badge--orange { background: #fff3e8; color: #e65100; }

/* ── Stat Counter ── */
.stat-num { font-size: 2.4rem; font-weight: 900; color: white; font-variant-numeric: tabular-nums; }

/* ── Team Grid ── */
.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
}

/* ── WhatsApp Button Base ── */
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
.wa-cta-btn--white {
  background: white;
  color: var(--green);
  box-shadow: 0 6px 20px rgba(0,0,0,.15);
}
.wa-cta-btn--white:hover {
  background: var(--green-light);
}

/* ── Responsive ── */
@media (max-width: 1024px) {
  .rx-delivery-grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
  /* About section */
  .why-grid { display: flex !important; flex-direction: column !important; gap: 32px !important; }
  .why-img-wrap { display: block !important; width: 100% !important; max-width: 100% !important; min-height: 280px !important; position: relative !important; }
  .why-img, .why-img--real { display: block !important; width: 100% !important; height: 280px !important; overflow: hidden !important; border-radius: 16px !important; }
  .why-img--real img { width: 100% !important; height: 100% !important; object-fit: cover !important; object-position: top center !important; display: block !important; }
  .why-blob { display: none; }

  /* Team */
  .team-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 14px; }
  .t-img { height: 150px !important; }
  .t-name { font-size: .82rem !important; }
  .t-role { font-size: .65rem !important; }
  .t-body { padding: 12px !important; }

  /* WhatsApp button */
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
}

@media (max-width: 480px) {
  /* Stats */
  .stat-num { font-size: 1.8rem; }

  /* Team */
  .team-grid { grid-template-columns: 1fr 1fr !important; gap: 10px; }
  .t-img { height: 120px !important; }
  .t-name { font-size: .75rem !important; }
  .t-role { font-size: .6rem !important; }
  .t-soc { width: 24px !important; height: 24px !important; }
  .t-socials { gap: 5px !important; }

  /* WhatsApp button */
  .wa-cta-btn {
    font-size: .72rem;
    padding: 10px 14px;
    gap: 6px;
    max-width: 260px;
  }
  .wa-cta-btn svg { width: 14px; height: 14px; }

  /* Why section */
  .why-img-wrap { min-height: 220px !important; }
  .why-img, .why-img--real { height: 220px !important; }

  /* Delivery */
  .delivery-info-box { padding: 18px; }
  .di-label { font-size: .76rem; }
  .di-desc { font-size: .7rem; }
}
</style>

<section class="why-sec" style="padding-top:56px;">
  <div class="why-grid">
    <div class="why-img-wrap">
      <div class="why-blob"></div>
      <div class="why-img why-img--real" style="overflow:hidden;">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/js/images/doctors.png"
             alt="Our Pharmacists"
             style="width:100%;height:100%;object-fit:cover;object-position:top center;display:block;">
      </div>
      <div class="why-years">
        <div class="why-years-n">12</div>
        <div class="why-years-t">YEARS<br>SERVING</div>
      </div>
    </div>
    <div>
      <div class="sec-tag sec-tag-outline reveal">About Us</div>
      <h1 class="sec-title reveal rd1">About <span>Travotech Agencies</span></h1>
      <p class="sec-desc reveal rd2">Kenya's most trusted pharmacy serving thousands of families with quality, affordable and certified medicines since 2012. Licensed by the Pharmacy and Poisons Board of Kenya.</p>
      <div class="why-feats" style="margin-top:28px;">
        <div class="why-feat reveal rd1">
          <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
          <div><div class="wf-title">Our Mission</div><div class="wf-desc">To provide every Kenyan family with access to quality, affordable and certified healthcare products.</div></div>
        </div>
        <div class="why-feat reveal rd2">
          <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
          <div><div class="wf-title">Our Vision</div><div class="wf-desc">To be Kenya's most trusted and accessible pharmacy, online and in-store.</div></div>
        </div>
        <div class="why-feat reveal rd3">
          <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg></div>
          <div><div class="wf-title">Our Values</div><div class="wf-desc">Integrity, care, excellence and accessibility in everything we do for our customers.</div></div>
        </div>
        <div class="why-feat reveal rd4">
          <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
          <div><div class="wf-title">Award Winning</div><div class="wf-desc">Recognized for excellence in healthcare delivery across Kenya.</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<section style="background:var(--green);padding:48px 5%;">
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:24px;text-align:center;">
    <div class="reveal">
      <div class="stat-num" data-target="12" data-suffix="+">0+</div>
      <div style="font-size:.82rem;color:rgba(255,255,255,.7);font-weight:700;margin-top:4px;">Years of Service</div>
    </div>
    <div class="reveal rd1">
      <div class="stat-num" data-target="5" data-suffix="K+">0K+</div>
      <div style="font-size:.82rem;color:rgba(255,255,255,.7);font-weight:700;margin-top:4px;">Happy Customers</div>
    </div>
    <div class="reveal rd2">
      <div class="stat-num" data-target="2" data-suffix="K+">0K+</div>
      <div style="font-size:.82rem;color:rgba(255,255,255,.7);font-weight:700;margin-top:4px;">Products Available</div>
    </div>
    <div class="reveal rd3">
      <div class="stat-num" data-target="24" data-suffix="/7">0/7</div>
      <div style="font-size:.82rem;color:rgba(255,255,255,.7);font-weight:700;margin-top:4px;">WhatsApp Support</div>
    </div>
  </div>
</section>

<script>
(function(){
  function animateCounter(el) {
    var target = parseInt(el.getAttribute('data-target'));
    var suffix = el.getAttribute('data-suffix');
    var duration = 1800;
    var start = null;
    function step(ts) {
      if (!start) start = ts;
      var progress = Math.min((ts - start) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      var current = Math.floor(eased * target);
      el.textContent = current + suffix;
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = target + suffix;
    }
    requestAnimationFrame(step);
  }
  var counters = document.querySelectorAll('.stat-num');
  if ('IntersectionObserver' in window) {
    var obs = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) { animateCounter(entry.target); obs.unobserve(entry.target); }
      });
    }, { threshold: 0.3 });
    counters.forEach(function(c) { obs.observe(c); });
  } else {
    counters.forEach(function(c) { animateCounter(c); });
  }
})();
</script>

<!-- SERVICES -->
<section class="srv-sec">
  <div style="text-align:center">
    <div class="sec-tag sec-tag-solid reveal">What We Do</div>
    <h2 class="sec-title reveal rd1">Our <span>Services</span></h2>
  </div>
  <div class="srv-grid">
    <div class="srv-card reveal"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div><div class="srv-name">Prescription<br>Medicines</div></div>
    <div class="srv-card hl reveal rd1"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><div class="srv-name">24/7 Emergency<br>Services</div></div>
    <div class="srv-card reveal rd2"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div><div class="srv-name">Free<br>Consultation</div></div>
    <div class="srv-card reveal rd3"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/></svg></div><div class="srv-name">Excellence<br>Rewards</div></div>
    <div class="srv-card reveal rd4"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div><div class="srv-name">CountryWide<br>Delivery</div></div>
    <div class="srv-card reveal rd1"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div><div class="srv-name">Professional<br>Pharmacists</div></div>
  </div>
</section>

<!-- DELIVERY SCHEDULE -->
<section class="rx-delivery">
  <div style="text-align:center;margin-bottom:32px;">
    <div class="sec-tag sec-tag-solid reveal">Delivery Info</div>
    <h2 class="sec-title reveal rd1">Delivery <span>Schedule</span></h2>
    <p class="sec-desc reveal rd2" style="margin:0 auto;">We deliver across Nairobi same day and countrywide within 1-2 days.</p>
  </div>
  <div class="rx-delivery-grid">

    <!-- Nairobi -->
    <div class="delivery-info-box reveal">
      <div class="di-title">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Nairobi: Same Day Delivery
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div>
          <div class="di-label">Order by 3:00 PM <span class="di-badge di-badge--green">Same Day</span></div>
          <div class="di-desc">Orders placed before 3:00 PM are dispatched the same day and delivered within Nairobi by evening.</div>
        </div>
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e65100" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
        <div>
          <div class="di-label">3:00 PM – 6:00 PM <span class="di-badge di-badge--orange">Possible Same Day</span></div>
          <div class="di-desc">Orders between 3–6 PM may still be delivered same day depending on location. Our team will confirm via WhatsApp.</div>
        </div>
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
        <div>
          <div class="di-label">After 6:00 PM <span class="di-badge di-badge--orange">Next Morning</span></div>
          <div class="di-desc">Orders received after 6:00 PM are processed the following morning and delivered next day.</div>
        </div>
      </div>
    </div>

    <!-- Countrywide -->
    <div class="delivery-info-box reveal rd1">
      <div class="di-title">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        Outside Nairobi: Countrywide
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
        <div>
          <div class="di-label">Nearby Counties <span class="di-badge di-badge--green">Next Day</span></div>
          <div class="di-desc">Kiambu, Machakos, Kajiado, Murang'a and surrounding areas typically receive orders the next day.</div>
        </div>
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e65100" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
        <div>
          <div class="di-label">Distant Counties <span class="di-badge di-badge--orange">1–2 Days</span></div>
          <div class="di-desc">Mombasa, Kisumu, Nakuru, Eldoret and farther counties take 1–2 days depending on courier routes.</div>
        </div>
      </div>
      <div class="delivery-row">
        <div class="di-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
        <div>
          <div class="di-label">WhatsApp Confirmation</div>
          <div class="di-desc">We always confirm your expected delivery time via WhatsApp before dispatching your order.</div>
        </div>
      </div>
    </div>

  </div>

  <!-- WHATSAPP BUTTON -->
  <div style="text-align:center;margin-top:40px;" class="reveal">
    <p style="font-size:.88rem;color:var(--text-mid);font-weight:600;margin-bottom:16px;">Have delivery questions? Chat with us directly!</p>
    <a href="https://wa.me/WHATSAPP_NUMBER_HERE?text=<?php echo urlencode('Hello Travotech Agencies! I have a delivery enquiry.'); ?>"
       class="wa-cta-btn"
       target="_blank"
       rel="noopener">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
      Chat on WhatsApp: +254 790 007616.
    </a>
  </div>

</section>

<!-- TEAM -->
<section class="team-sec">
  <div class="team-hdr">
    <div class="sec-tag sec-tag-solid reveal">Our Team</div>
    <h2 class="sec-title reveal rd1">Meet Our Best <span>Pharmacists</span></h2>
  </div>
  <div class="team-grid">
    <?php
    $team = [
      ['Dr. Sarah Wanjiku', 'Lead Pharmacist'],
      ['Dr. James Otieno',  'Clinical Pharmacist'],
      ['Dr. Grace Kamau',   'Pharmaceutical Tech'],
      ['Dr. Peter Mwangi',  'Pharmacy Manager'],
    ];
    $delays = ['reveal', 'reveal rd1', 'reveal rd2', 'reveal rd3'];
    foreach ($team as $i => $member): ?>
    <div class="t-card <?php echo $delays[$i]; ?>">
      <div class="t-img">
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5">
          <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
      </div>
      <div class="t-body">
        <div class="t-name"><?php echo esc_html($member[0]); ?></div>
        <div class="t-role"><?php echo esc_html($member[1]); ?></div>
        <div class="t-socials">
          <a href="#" class="t-soc" aria-label="LinkedIn">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
          <a href="#" class="t-soc" aria-label="Facebook">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
          </a>
          <a href="mailto:<?php echo esc_attr(travotech_email()); ?>" class="t-soc" aria-label="Email">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- CTA -->
<section class="cta-sec">
  <div class="cta-b1"></div><div class="cta-b2"></div>
  <div style="text-align:center;position:relative;z-index:1;">
    <div class="sec-tag sec-tag-solid reveal" style="background:rgba(255,255,255,.2)">Get In Touch</div>
    <h2 class="sec-title reveal rd1" style="color:white;">Have Questions? <span style="color:var(--green-mid);">We're Here</span></h2>
    <p class="sec-desc reveal rd2" style="color:rgba(255,255,255,.8);margin:0 auto 28px;">Reach out via WhatsApp or visit us at Utawala Astrol (Nairobi).</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;" class="reveal rd3">
      <a href="https://wa.me/WHATSAPP_NUMBER_HERE?text=<?php echo urlencode('Hello Travotech Agencies! I have an enquiry.'); ?>"
         class="wa-cta-btn wa-cta-btn--white"
         target="_blank"
         rel="noopener">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        Chat on WhatsApp
      </a>
      <a href="<?php echo home_url('/contact'); ?>" class="btn-outline" style="border-color:rgba(255,255,255,.5);color:white;">Contact Us</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>