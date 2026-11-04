<?php $wa = '254720737151'; $phone = '+254 720 737 151'; ?>

<style>
/* ═══════════════════════════════════════════════════
   FOOTER RESPONSIVE STYLES
═══════════════════════════════════════════════════ */

/* Desktop: 4 columns */
.foot-grid {
  display: grid;
  grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
  gap: 40px;
  padding: 56px 48px 40px;
}
.foot-desc {
  font-size: 0.85rem;
  line-height: 1.7;
  margin: 10px 0 18px;
  opacity: .75;
}
.foot-socs {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}
.foot-soc {
  width: 34px; height: 34px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: opacity .2s, transform .2s;
}
.foot-soc:hover { opacity: .75; transform: translateY(-2px); }
.foot-h {
  font-size: 0.82rem;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  margin-bottom: 16px;
  opacity: .5;
}
.foot-links {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.foot-links li a {
  font-size: 0.88rem;
  text-decoration: none;
  opacity: .75;
  display: flex;
  align-items: center;
  transition: opacity .2s, padding-left .2s;
}
.foot-links li a:hover { opacity: 1; padding-left: 4px; }

/* Bottom bar */
.foot-bot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  padding: 16px 48px;
  border-top: 1px solid rgba(255,255,255,.08);
  font-size: 0.82rem;
  opacity: .6;
}
.foot-legal { display: flex; gap: 20px; flex-wrap: wrap; }
.foot-legal a { text-decoration: none; opacity: .8; }
.foot-legal a:hover { opacity: 1; }

/* Credit */
.foot-credit {
  text-align: center;
  padding: 10px 20px 14px;
  font-size: 12.5px;
  color: rgba(255,255,255,.35);
  border-top: 1px solid rgba(255,255,255,.06);
}
.foot-credit a {
  color: rgba(255,255,255,.6);
  text-decoration: none;
  font-weight: 500;
  transition: color .2s;
}
.foot-credit a:hover { color: #fff; }

/* ── Tablet (≤ 960px): 2 columns ── */
@media (max-width: 960px) {
  .foot-grid {
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    padding: 40px 28px 32px;
  }
  .foot-bot { padding: 14px 28px; }
}

/* ── Mobile (≤ 600px): 1 column ── */
@media (max-width: 600px) {
  .foot-grid {
    grid-template-columns: 1fr;
    gap: 28px;
    padding: 32px 18px 24px;
  }
  .foot-grid > div:first-child { text-align: center; }
  .foot-grid > div:first-child .foot-socs { justify-content: center; }
  .foot-grid > div:first-child .foot-logo-link { justify-content: center; }
  .foot-h {
    font-size: 0.9rem;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255,255,255,.1);
  }
  .foot-links { gap: 8px; }
  .foot-links li a { font-size: 0.9rem; padding: 2px 0; }
  .foot-bot {
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 14px 18px;
    gap: 8px;
  }
  .foot-legal { justify-content: center; gap: 14px; }
  .foot-credit { font-size: 11.5px; padding: 10px 16px 16px; }
  .foot-logo-wrap {
    width:  clamp(85px, 26vw, 115px) !important;
    height: clamp(30px, 10vw,  42px) !important;
    padding: 0 !important;
  }
}

@media (max-width: 380px) {
  .foot-logo-wrap {
    width:  clamp(78px, 28vw, 105px) !important;
    height: clamp(28px, 11vw,  38px) !important;
  }
}

/* ═══════════════════════════════════════════════════
   FOOTER LOGO
═══════════════════════════════════════════════════ */
@keyframes foot-logo-fade-in {
  from { opacity: 0; transform: scale(0.92) translateY(4px); }
  to   { opacity: 1; transform: scale(1)    translateY(0);   }
}
.foot-logo-link {
  display: inline-flex;
  align-items: center;
  text-decoration: none !important;
  flex-shrink: 0;
  animation: foot-logo-fade-in 0.55s cubic-bezier(.34,1.56,.64,1) both;
}
.foot-logo-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid #2eaf6e;
  border-radius: 5px;
  overflow: hidden;
  padding: 0;
  box-shadow: 0 2px 8px rgba(0,0,0,.18);
  width:  clamp(90px, 9vw, 125px);
  height: clamp(32px,  4vw,  46px);
  transition: transform 0.25s cubic-bezier(.34,1.56,.64,1), box-shadow 0.25s ease, border-color 0.2s ease;
}
.foot-logo-link:hover .foot-logo-wrap {
  transform:    scale(1.05) translateY(-1px);
  box-shadow:   0 6px 20px rgba(46,175,110,.4);
  border-color: #22994f;
}
.foot-logo-link:active .foot-logo-wrap {
  transform:  scale(0.96);
  box-shadow: 0 2px 6px rgba(46,175,110,.2);
}
.foot-logo-wrap img {
  width: 100%; height: 100%;
  object-fit: cover; object-position: center;
  display: block; transition: transform 0.3s ease;
}
.foot-logo-link:hover .foot-logo-wrap img { transform: scale(1.04); }

@media (max-width: 960px) {
  .foot-logo-wrap {
    width:  clamp(80px, 12vw, 115px);
    height: clamp(30px,  5vw,  42px);
    padding: 0;
  }
}

/* ═══════════════════════════════════════════════════
   M-PESA TILL BANNER
═══════════════════════════════════════════════════ */
.foot-mpesa-strip {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  padding: 14px 0 0;
  box-sizing: border-box;
}
.foot-mpesa-strip .fms-label {
  font-size: .6rem;
  font-weight: 800;
  color: rgba(255,255,255,.4);
  text-transform: uppercase;
  letter-spacing: .12em;
}

.mpesa-till-banner {
  display: inline-flex;
  align-items: stretch;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 24px rgba(0,0,0,.35);
  font-family: 'Nunito', sans-serif;
  transform-origin: center top;
}
.mpesa-till-banner .mtb-left {
  background: #4caf50;
  padding: 14px 24px;
  display: flex;
  align-items: center;
  flex-shrink: 0;
}
.mpesa-till-banner .mtb-lipa {
  font-size: .72rem;
  font-weight: 900;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: .1em;
  line-height: 1;
  display: block;
  margin-bottom: 4px;
  white-space: nowrap;
}
.mpesa-till-banner .mtb-wordmark {
  display: flex;
  align-items: center;
  gap: 0;
}
.mpesa-till-banner .mtb-m,
.mpesa-till-banner .mtb-pesa {
  font-size: 1.9rem;
  font-weight: 900;
  color: #fff;
  line-height: 1;
  font-style: italic;
  letter-spacing: -.02em;
}
.mpesa-till-banner .mtb-phone-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  margin-bottom: 2px;
}
.mpesa-till-banner .mtb-phone-icon svg { width: 18px; height: 18px; }
.mpesa-till-banner .mtb-right {
  background: #fff;
  padding: 10px 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 6px;
}
.mpesa-till-banner .mtb-label {
  font-size: .62rem;
  font-weight: 900;
  color: #333;
  text-transform: uppercase;
  letter-spacing: .08em;
  white-space: nowrap;
}
.mpesa-till-banner .mtb-digits { display: flex; gap: 5px; }
.mpesa-till-banner .mtb-digit {
  width: 36px; height: 40px;
  background: #4caf50;
  color: #fff;
  font-size: 1.3rem;
  font-weight: 900;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 1;
  box-shadow: 0 2px 6px rgba(76,175,80,.4);
  font-family: 'Nunito', sans-serif;
  flex-shrink: 0;
}
.mpesa-till-banner .mtb-store {
  font-size: .62rem;
  font-weight: 800;
  color: #777;
  text-transform: uppercase;
  letter-spacing: .08em;
  white-space: nowrap;
}

</style>

<!-- FOOTER -->
<footer>

  <!-- ══ M-PESA TILL BANNER ══ -->
  <div class="foot-mpesa-strip">
    <span class="fms-label">Pay via M-Pesa</span>
    <div class="mpesa-till-banner">
      <div class="mtb-left">
        <div>
          <span class="mtb-lipa">Lipa Na</span>
          <div class="mtb-wordmark">
            <span class="mtb-m">M</span>
            <span class="mtb-phone-icon">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5" y="1" width="14" height="22" rx="3" ry="3" fill="#e53935"/>
                <rect x="7" y="4" width="10" height="13" rx="1" fill="#fff" opacity="0.9"/>
                <circle cx="12" cy="20" r="1.2" fill="#fff" opacity="0.9"/>
                <rect x="8.5" y="12" width="1.5" height="3" rx=".5" fill="#4caf50"/>
                <rect x="11" y="10.5" width="1.5" height="4.5" rx=".5" fill="#4caf50"/>
                <rect x="13.5" y="9" width="1.5" height="6" rx=".5" fill="#4caf50"/>
              </svg>
            </span>
            <span class="mtb-pesa">pesa</span>
          </div>
        </div>
      </div>
      <div class="mtb-right">
        <span class="mtb-label">Buy Goods Till Number</span>
        <div class="mtb-digits">
          <span class="mtb-digit">5</span>
          <span class="mtb-digit">2</span>
          <span class="mtb-digit">7</span>
          <span class="mtb-digit">9</span>
          <span class="mtb-digit">2</span>
          <span class="mtb-digit">3</span>
          <span class="mtb-digit">7</span>
        </div>
        <span class="mtb-store">TRAVOTECH AGENCIES</span>
      </div>
    </div>
  </div>
  <!-- ══ END M-PESA TILL BANNER ══ -->

  <div class="foot-grid">

    <!-- Col 1: Brand -->
    <div>
      <a href="<?php echo esc_url(home_url('/')); ?>"
         class="foot-logo-link"
         aria-label="Travotech Agencies — Go to homepage"
         style="margin-bottom:8px;">
        <div class="foot-logo-wrap">
          <img
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/travotechlogo.png'); ?>"
            alt="Travotech Agencies"
            width="210"
            height="72"
            loading="lazy"
            decoding="async"
          />
        </div>
      </a>
      <p class="foot-desc">Kenya's trusted pharmacy. Quality medicines, supplements and healthcare products delivered with care across Nairobi and Kenya.</p>
      <div class="foot-socs">
        <a href="<?php echo esc_url(get_option('travotech_facebook','#')); ?>" class="foot-soc" target="_blank" aria-label="Facebook">
          <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
        </a>
        <a href="<?php echo esc_url(get_option('travotech_instagram','#')); ?>" class="foot-soc" target="_blank" aria-label="Instagram">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </a>
        <a href="<?php echo esc_url(get_option('travotech_twitter','#')); ?>" class="foot-soc" target="_blank" aria-label="X (Twitter)">
          <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <a href="https://wa.me/<?php echo esc_attr($wa); ?>" class="foot-soc" target="_blank" aria-label="WhatsApp">
          <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
      </div>
    </div>

    <!-- Col 2: Quick Links -->
    <div>
      <div class="foot-h">Quick Links</div>
      <ul class="foot-links">
        <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
        <li><a href="<?php echo esc_url(function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop')); ?>">Shop</a></li>
        <li><a href="<?php echo esc_url(home_url('/about-us')); ?>">About Us</a></li>
        <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
        <li><a href="<?php echo esc_url(home_url('/submit-prescription')); ?>">Submit Prescription</a></li>
      </ul>
    </div>

    <!-- Col 3: Categories -->
    <div>
      <div class="foot-h">Categories</div>
      <ul class="foot-links">
        <?php
        $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,'number'=>6]);
        if ($cats && !is_wp_error($cats)) {
          foreach ($cats as $c) {
            echo '<li><a href="' . esc_url(get_term_link($c)) . '">' . esc_html($c->name) . '</a></li>';
          }
        } else {
          $shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop');
          foreach (['Prescription Meds','Supplements','Baby Care','Skincare','Equipment','Dental Care'] as $n) {
            echo '<li><a href="' . esc_url($shop_url) . '">' . esc_html($n) . '</a></li>';
          }
        }
        ?>
      </ul>
    </div>

    <!-- Col 4: Contact -->
    <div>
      <div class="foot-h">Contact Us</div>
      <ul class="foot-links">
        <li>
          <a href="https://wa.me/<?php echo esc_attr($wa); ?>?text=<?php echo urlencode('Hello ' . get_bloginfo('name') . '! I would like to place an order.'); ?>" target="_blank">
            <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px;margin-right:7px;flex-shrink:0"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WhatsApp Us
          </a>
        </li>
        <li>
          <a href="tel:+254720737151">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;margin-right:7px;flex-shrink:0"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
            +254 720 737 151
          </a>
        </li>
        <li>
          <a href="mailto:<?php echo esc_attr(travotech_email()); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;margin-right:7px;flex-shrink:0"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <?php echo esc_html(travotech_email()); ?>
          </a>
        </li>
        <li>
          <a href="#">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;margin-right:7px;flex-shrink:0"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <?php echo esc_html(travotech_address()); ?>
          </a>
        </li>
        <li>
          <a href="<?php echo esc_url(home_url('/refund')); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;margin-right:7px;flex-shrink:0"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 014-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 01-4 4H3"/></svg>
            Return &amp; Refund Policy
          </a>
        </li>
      </ul>
    </div>

  </div><!-- /.foot-grid -->

  <div class="foot-bot">
    <div class="foot-copy">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</div>
    <div class="foot-legal">
      <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>
      <a href="<?php echo esc_url(home_url('/terms')); ?>">Terms &amp; Conditions</a>
    </div>
  </div>

  <div class="foot-credit">
    Designed &amp; Developed by <a href="https://devnovatech.co.ke/" target="_blank" rel="noopener">Devnovatech Software Developers</a>
  </div>

</footer>

<!-- ═══════════════════════════════════════════════════
     FLOATING BUTTONS — Travotech Headphone Style
═══════════════════════════════════════════════════ -->
<style>

/* ── Container ── */
.float-btns {
  position: fixed;
  bottom: 28px;
  right: 22px;
  display: flex;
  flex-direction: column-reverse;
  align-items: center;
  gap: 14px;
  z-index: 9999;
}

/* ── Child buttons (WhatsApp / Call) ── */
.f-btn {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  box-shadow: 0 4px 18px rgba(0,0,0,.25);
  transition: transform .2s cubic-bezier(.34,1.56,.64,1), box-shadow .2s;
  flex-shrink: 0;
  position: relative;
}
.f-btn:hover {
  transform: scale(1.1);
  box-shadow: 0 8px 28px rgba(0,0,0,.3);
}
.f-wa   { background: #25d366; }
.f-call { background: linear-gradient(145deg, #1c8a54, #2eaf6e); }

/* Tooltip */
.f-tip {
  position: absolute;
  right: calc(100% + 12px);
  top: 50%;
  transform: translateY(-50%);
  background: rgba(10,10,10,.82);
  color: #fff;
  font-size: 0.78rem;
  font-weight: 600;
  padding: 5px 12px;
  border-radius: 8px;
  white-space: nowrap;
  pointer-events: none;
  opacity: 0;
  transition: opacity .2s;
  letter-spacing: 0.02em;
}
.f-btn:hover .f-tip { opacity: 1; }

/* Child show/hide animation */
.f-child {
  opacity: 0;
  transform: scale(0.5) translateY(12px);
  pointer-events: none;
  transition: opacity .28s cubic-bezier(.34,1.56,.64,1),
              transform .28s cubic-bezier(.34,1.56,.64,1);
}
.f-child:nth-child(1) { transition-delay: .06s; }
.f-child:nth-child(2) { transition-delay: .13s; }
.float-btns.open .f-child {
  opacity: 1;
  transform: scale(1) translateY(0);
  pointer-events: auto;
}

/* ── Main toggle wrapper (button + Travotech tag) ── */
.f-toggle-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 7px;
  position: relative;
}

/* ── Pulse rings — circular, one-shot (fires once then stops) ── */
@keyframes cv-pulse {
  0%   { transform: translate(-50%, -50%) scale(1);   opacity: 0.65; }
  100% { transform: translate(-50%, -50%) scale(1.7); opacity: 0; }
}
.f-pulse-ring {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 68px;
  height: 68px;
  border-radius: 50%;
  border: 2.5px solid rgba(46,175,110,0.5);
  transform: translate(-50%, -50%) scale(1);
  /* 1s duration | ease-out | play once | keep end state */
  animation: cv-pulse 1s ease-out 1 forwards;
  pointer-events: none;
  z-index: 0;
}
.f-pulse-ring-2 {
  animation-delay: 0.5s;
}
/* Hide rings when menu is open */
.f-toggle.active ~ .f-pulse-ring,
.f-toggle.active ~ .f-pulse-ring-2 {
  display: none;
}

/* ── Main toggle button ── */
.f-toggle {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  background: linear-gradient(145deg, #1c8a54, #2eaf6e);
  border: 3px solid #2eaf6e;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow:
    0 6px 24px rgba(46,175,110,.55),
    0 0 0 5px rgba(46,175,110,.12),
    inset 0 1px 1px rgba(255,255,255,.2);
  position: relative;
  z-index: 2;
  transition: transform .3s cubic-bezier(.34,1.56,.64,1),
              background .25s ease,
              box-shadow .25s ease,
              border-color .25s ease;
  flex-shrink: 0;
}
.f-toggle:hover {
  transform: scale(1.08);
  box-shadow:
    0 10px 36px rgba(46,175,110,.7),
    0 0 0 8px rgba(46,175,110,.15),
    inset 0 1px 1px rgba(255,255,255,.25);
}
.f-toggle:active { transform: scale(0.96); }

/* Active (expanded) state — red */
.f-toggle.active {
  background: linear-gradient(145deg, #a81a1a, #e53935);
  border-color: #e53935;
  box-shadow:
    0 6px 24px rgba(229,57,53,.55),
    0 0 0 5px rgba(229,57,53,.12),
    inset 0 1px 1px rgba(255,255,255,.15);
}
.f-toggle.active:hover {
  box-shadow:
    0 10px 36px rgba(229,57,53,.7),
    0 0 0 8px rgba(229,57,53,.15),
    inset 0 1px 1px rgba(255,255,255,.2);
}

/* Icon states */
.f-ico-open  { display: flex; align-items: center; justify-content: center; }
.f-ico-close { display: none; align-items: center; justify-content: center; }
.f-toggle.active .f-ico-open  { display: none; }
.f-toggle.active .f-ico-close { display: flex; }

/* ── Travotech pill tag ── */
.f-travotech-tag {
  display: inline-block;
  font-family: 'Nunito', 'Helvetica Neue', Arial, sans-serif;
  font-size: 8.5px;
  font-weight: 900;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: #2eaf6e;
  background: rgba(46,175,110,0.1);
  border: 1.5px solid rgba(46,175,110,0.35);
  border-radius: 20px;
  padding: 3px 11px;
  pointer-events: none;
  transition: color .25s, background .25s, border-color .25s;
  white-space: nowrap;
}
.f-toggle.active + .f-travotech-tag,
.f-toggle-wrap.active-wrap .f-travotech-tag {
  color: #e53935;
  background: rgba(229,57,53,0.1);
  border-color: rgba(229,57,53,0.35);
}

/* ── Responsive ── */
@media (max-width: 600px) {
  .float-btns {
    bottom: 20px;
    right: 14px;
    gap: 10px;
  }
  /* Child buttons (WhatsApp / Call) */
  .f-btn {
    width: 44px;
    height: 44px;
  }
  .f-btn svg {
    width: 20px;
    height: 20px;
  }
  /* Main toggle */
  .f-toggle {
    width: 54px;
    height: 54px;
  }
  /* Pulse rings — match smaller toggle size */
  .f-pulse-ring {
    width: 54px;
    height: 54px;
  }
  /* Travotech tag */
  .f-travotech-tag {
    font-size: 7.5px;
    padding: 3px 9px;
  }
}

</style>

<div class="float-btns" id="floatBtns">

  <!-- Child: Call -->
  <a href="tel:+254720737151" class="f-btn f-call f-child" aria-label="Call Us">
    <div class="f-tip">Call Us</div>
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
         stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
    </svg>
  </a>

  <!-- Child: WhatsApp -->
  <a href="https://wa.me/254720737151?text=<?php echo urlencode('Hello ' . get_bloginfo('name') . '! I would like to place an order.'); ?>"
     class="f-btn f-wa f-child" target="_blank" rel="noopener" aria-label="WhatsApp">
    <div class="f-tip">WhatsApp Us</div>
    <svg width="26" height="26" viewBox="0 0 24 24" fill="#fff">
      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
  </a>

  <!-- ══ Main toggle button — Travotech Headphone ══ -->
  <div class="f-toggle-wrap" id="floatToggleWrap">

    <!-- Pulse rings — centred with translate, circular, fire once -->
    <div class="f-pulse-ring"  id="pulseRing1"></div>
    <div class="f-pulse-ring f-pulse-ring-2" id="pulseRing2"></div>

    <button class="f-toggle" id="floatToggle" aria-label="Contact options" aria-expanded="false">

      <!-- OPEN state: large professional headphone + SMS bubble -->
      <span class="f-ico-open">
        <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">

          <!-- ── Headband — thick premium arc ── -->
          <path d="M10 28
                   C10 13 18 7 26 7
                   C34 7 42 13 42 28"
                stroke="white"
                stroke-width="3.8"
                stroke-linecap="round"
                fill="none"/>

          <!-- ── LEFT ear assembly ── -->
          <rect x="4" y="25" width="12" height="20" rx="6" fill="white"/>
          <rect x="7"  y="29" width="6"  height="12" rx="3" fill="#2eaf6e"/>
          <circle cx="10" cy="35" r="1.8" fill="white" opacity="0.7"/>
          <rect x="7" y="23" width="8" height="6" rx="3" fill="rgba(255,255,255,0.45)"/>

          <!-- ── RIGHT ear assembly ── -->
          <rect x="36" y="25" width="12" height="20" rx="6" fill="white"/>
          <rect x="39" y="29" width="6"  height="12" rx="3" fill="#2eaf6e"/>
          <circle cx="42" cy="35" r="1.8" fill="white" opacity="0.7"/>
          <rect x="37" y="23" width="8" height="6" rx="3" fill="rgba(255,255,255,0.45)"/>

          <!-- ── Mic boom arm (right cup) ── -->
          <path d="M48 37 Q52 41 52 47" stroke="rgba(255,255,255,0.55)" stroke-width="2.2" stroke-linecap="round" fill="none"/>
          <rect x="49.5" y="46" width="5" height="7" rx="2.5" fill="white" opacity="0.75"/>
          <circle cx="52" cy="49.5" r="1.4" fill="#e53935"/>

          <!-- ══ SMS speech-bubble icon — centred on headband ══ -->
          <rect x="15" y="18" width="22" height="15" rx="4" fill="#e53935"/>
          <path d="M21 33 L19 37.5 L25 33.5 Z" fill="#e53935"/>
          <text x="26"
                y="29.5"
                text-anchor="middle"
                font-family="'Nunito','Arial Black',Arial,sans-serif"
                font-weight="900"
                font-size="8"
                letter-spacing="1"
                fill="white">SMS</text>

        </svg>
      </span>

      <!-- CLOSE state: X icon (when expanded) -->
      <span class="f-ico-close">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="#fff" stroke-width="2.8" stroke-linecap="round">
          <line x1="18" y1="6"  x2="6"  y2="18"/>
          <line x1="6"  y1="6"  x2="18" y2="18"/>
        </svg>
      </span>

    </button>

    <!-- Travotech pill label -->
    <span class="f-travotech-tag" id="travotechTag">Travotech</span>

  </div>
  <!-- ══ End main toggle ══ -->

</div><!-- /.float-btns -->

<script>
(function () {
  var wrap      = document.getElementById('floatBtns');
  var toggle    = document.getElementById('floatToggle');
  var wrapDiv   = document.getElementById('floatToggleWrap');
  var tag       = document.getElementById('travotechTag');
  var ring1     = document.getElementById('pulseRing1');
  var ring2     = document.getElementById('pulseRing2');
  if (!wrap || !toggle) return;

  function setOpen(open) {
    wrap.classList.toggle('open', open);
    toggle.classList.toggle('active', open);
    wrapDiv.classList.toggle('active-wrap', open);
    toggle.setAttribute('aria-expanded', open);
    if (tag) tag.style.color        = open ? '#e53935' : '';
    if (tag) tag.style.background   = open ? 'rgba(229,57,53,0.1)' : '';
    if (tag) tag.style.borderColor  = open ? 'rgba(229,57,53,0.35)' : '';
    /* Hide pulse rings while expanded */
    if (ring1) ring1.style.display  = open ? 'none' : '';
    if (ring2) ring2.style.display  = open ? 'none' : '';
  }

  toggle.addEventListener('click', function () {
    setOpen(!wrap.classList.contains('open'));
  });

  wrap.querySelectorAll('.f-child').forEach(function (btn) {
    btn.addEventListener('click', function () { setOpen(false); });
  });

  document.addEventListener('click', function (e) {
    if (!wrap.contains(e.target)) setOpen(false);
  });
})();

/* ── M-Pesa banner auto-scaler ── */
(function () {
  var banner = document.querySelector('.mpesa-till-banner');
  var strip  = document.querySelector('.foot-mpesa-strip');
  if (!banner || !strip) return;
  function scaleBanner() {
    banner.style.transform    = 'scale(1)';
    banner.style.marginBottom = '0';
    var available = strip.offsetWidth - 90;
    var natural   = banner.scrollWidth;
    if (natural > available) {
      var ratio = available / natural;
      banner.style.transform    = 'scale(' + ratio + ')';
      var lost = banner.offsetHeight * (1 - ratio);
      banner.style.marginBottom = '-' + (lost / 2) + 'px';
    }
  }
  scaleBanner();
  window.addEventListener('resize', scaleBanner);
})();
</script>

<?php wp_footer(); ?>
</body>
</html>
