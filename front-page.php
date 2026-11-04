<?php get_header(); ?>

<!-- HERO SLIDER -->
<div class="hero">

  <div class="hero-slide hs1 active">
    <div class="hero-blob"></div>
    <div class="hero-blob2"></div>
    <div class="hero-content">
      <div class="hero-badge">Welcome To <?php bloginfo('name'); ?></div>
      <h1>Trusted Care,<br><span>Close To Home.</span></h1>
      <p class="hero-desc">Quality medicines and healthcare products for every Kenyan family. Browse thousands of certified products and enquire via WhatsApp.</p>
      <div class="hero-btns">
        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn-green">
          <svg class="btn-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Shop Now
        </a>
        <a href="#about" class="btn-outline">Know More</a>
      </div>
    </div>
    <div class="hero-image">
      <div class="hero-img-box">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/js/images/doctors.png" alt="" class="hero-real-img hero-real-img--doctors">
        <div class="hero-float-badge">
          <div class="fb-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></div>
          <div><div class="fb-text">KEBS Certified</div><div class="fb-sub">All products verified</div></div>
        </div>
      </div>
    </div>
  </div>

  <div class="hero-slide hs2">
    <div class="hero-blob"></div>
    <div class="hero-content">
      <div class="hero-badge">Special Offers This Week</div>
      <h1>Best Prices on<br><span>Vitamins &amp; Supplements</span></h1>
      <p class="hero-desc">Up to 30% off on vitamins, supplements and wellness products. Limited stock, enquire now via WhatsApp before it runs out.</p>
      <div class="hero-btns">
        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn-green">
          <svg class="btn-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>View Offers
        </a>
        <a href="#contact" class="btn-outline">Contact Us</a>
      </div>
    </div>
    <div class="hero-image">
      <div class="hero-img-box" style="background:linear-gradient(180deg,#fff8e8,#fde8a0)">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/js/images/meds.png" alt="" class="hero-real-img hero-real-img--meds">
      </div>
    </div>
  </div>

  <div class="hero-slide hs3">
    <div class="hero-blob"></div>
    <div class="hero-content">
      <div class="hero-badge">Premium Skincare Range</div>
      <h1>Glow Up With<br><span>Trusted Skincare</span></h1>
      <p class="hero-desc">Discover certified skincare products loved by thousands of Kenyans. From cleansers to serums, quality you can trust.</p>
      <div class="hero-btns">
        <a href="<?php echo home_url('/product-category/beauty-personal-care/'); ?>" class="btn-green">
          <svg class="btn-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
          </svg>Shop Skincare
        </a>
        <a href="#contact" class="btn-outline">Call Now</a>
      </div>
    </div>
    <div class="hero-image hero-image--dual">
      <div class="hero-img-box hero-img-box--skin1" style="background:linear-gradient(180deg,#f0faf0,#d6f5d6)">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/js/images/skin_care1.jpg" alt="" class="hero-real-img hero-real-img--skin">
      </div>
      <div class="hero-img-box hero-img-box--skin2">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/js/images/skin_care2.jpg" alt="" class="hero-real-img hero-real-img--skin2">
      </div>
    </div>
  </div>

  <button class="hero-nav h-prev" id="hPrev">&#8249;</button>
  <button class="hero-nav h-next" id="hNext">&#8250;</button>
  <div class="hero-dots">
    <button class="hero-dot active" data-s="0"></button>
    <button class="hero-dot" data-s="1"></button>
    <button class="hero-dot" data-s="2"></button>
  </div>
</div>


<style>
.hero { position:relative;width:100%;margin-top:0;padding-top:0;overflow:hidden; }
.hero-slide { display:none;width:100%;height:auto;padding:20px 60px 40px;box-sizing:border-box;align-items:center;gap:48px;position:relative;overflow:hidden; }
header { margin-bottom:0!important;padding-bottom:0!important; }
.hero-blob,.hero-blob2 { pointer-events:none;position:absolute;top:0; }
.hero-slide.active { display:flex;align-items:center;animation:slideIn .55s cubic-bezier(.4,0,.2,1) both; }
@keyframes slideIn { from{opacity:0;transform:translateX(40px);}to{opacity:1;transform:translateX(0);} }
.hero-content  { flex:1 1 50%;max-width:560px;position:relative;z-index:2; }
.hero-image    { flex:1 1 44%;display:flex;justify-content:center;align-items:flex-end;position:relative;z-index:2; }
.hero-img-box  { position:relative;width:100%;max-width:460px;min-height:320px;border-radius:28px;overflow:hidden;display:flex;align-items:flex-end;justify-content:center;box-shadow:0 24px 64px rgba(0,0,0,.10); }
.hero-real-img--doctors { width:100%;height:360px;object-fit:contain;object-position:bottom center;display:block; }
.hero-real-img--meds    { width:82%;height:300px;object-fit:contain;object-position:center;display:block;margin:auto;padding:24px 0; }
.hero-image--dual       { gap:14px;flex-direction:row;align-items:flex-end; }
.hero-img-box--skin1    { max-width:250px;min-height:280px; }
.hero-img-box--skin2    { max-width:190px;min-height:240px;position:relative;top:28px; }
.hero-real-img--skin    { width:100%;height:260px;object-fit:contain;padding:14px; }
.hero-real-img--skin2   { width:100%;height:220px;object-fit:cover;object-position:top center; }
.btn-ico { width:18px;height:18px;margin-right:7px;vertical-align:middle;flex-shrink:0; }
.btn-green,.btn-outline { display:inline-flex;align-items:center; }
.hero-float-badge { position:absolute;bottom:60px;left:-30px;background:white;border-radius:14px;padding:10px 16px;box-shadow:0 8px 30px rgba(0,0,0,.1);display:flex;align-items:center;gap:10px;animation:fb 3s ease-in-out infinite; }
@keyframes fb { 0%,100%{transform:translateY(0);}50%{transform:translateY(-8px);} }
.fb-icon { width:34px;height:34px;border-radius:9px;background:var(--green-light,#e8f8f0);display:flex;align-items:center;justify-content:center; }
.fb-text { font-size:.7rem;font-weight:800;color:var(--text,#1a2e25); }
.fb-sub  { font-size:.62rem;color:var(--text-light,#8aaa98);font-weight:500; }
.hero-nav { position:absolute;top:50%;transform:translateY(-50%);width:44px;height:44px;border-radius:50%;border:2px solid rgba(255,255,255,.35);background:rgba(255,255,255,.15);backdrop-filter:blur(6px);color:#fff;font-size:22px;cursor:pointer;z-index:10;display:flex;align-items:center;justify-content:center;transition:background .2s,border-color .2s; }
.hero-nav:hover { background:rgba(255,255,255,.30);border-color:rgba(255,255,255,.6); }
.h-prev { left:18px; } .h-next { right:18px; }
.hero-dots { position:absolute;bottom:22px;left:50%;transform:translateX(-50%);display:flex;gap:8px;z-index:10; }
.hero-dot  { width:8px;height:8px;border-radius:50%;border:none;background:rgba(255,255,255,.4);cursor:pointer;padding:0;transition:background .25s,width .25s; }
.hero-dot.active { background:#fff;width:24px;border-radius:4px; }
@media(max-width:1023px) and (min-width:769px) {
  .hero-slide{padding:20px 40px 36px;gap:32px;}.hero-img-box{max-width:380px;min-height:320px;}.hero-real-img--doctors{height:340px;}.hero-real-img--meds{height:300px;}
  .hero-img-box--skin1{max-width:200px;min-height:290px;}.hero-img-box--skin2{max-width:155px;min-height:250px;top:22px;}.hero-real-img--skin{height:270px;}.hero-real-img--skin2{height:240px;}
}
@media(max-width:768px) {
  .hero{overflow:visible;padding-bottom:8px;}
  .hero-slide.active{display:block!important;flex-direction:unset!important;align-items:unset!important;gap:unset!important;position:relative;width:calc(100% - 28px);height:220px;min-height:220px;max-height:220px;margin:12px 14px;padding:0;border-radius:18px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.22);background:#1a3c2e;}
  .hero-image{position:absolute!important;top:0!important;left:0!important;right:0!important;bottom:0!important;width:100%!important;height:100%!important;display:block!important;z-index:0;flex:unset!important;justify-content:unset!important;align-items:unset!important;}
  .hero-img-box{position:absolute!important;top:0!important;left:0!important;right:0!important;bottom:0!important;width:100%!important;height:100%!important;max-width:100%!important;min-height:unset!important;border-radius:0!important;box-shadow:none!important;display:block!important;overflow:hidden;}
  .hero-real-img--doctors{width:100%!important;height:100%!important;object-fit:cover;object-position:center top;display:block;padding:0;margin:0;}
  .hero-real-img--meds{width:100%!important;height:100%!important;object-fit:cover;object-position:center center;display:block;padding:0;margin:0;}
  .hero-image--dual{position:absolute!important;top:0!important;left:0!important;right:0!important;bottom:0!important;width:100%!important;height:100%!important;display:flex!important;flex-direction:row!important;gap:0!important;align-items:stretch!important;}
  .hero-img-box--skin1{position:relative!important;top:0!important;flex:0 0 55%!important;width:55%!important;height:100%!important;max-width:55%!important;min-height:unset!important;border-radius:0!important;overflow:hidden;display:block!important;}
  .hero-img-box--skin2{position:relative!important;top:0!important;flex:0 0 45%!important;width:45%!important;height:100%!important;max-width:45%!important;min-height:unset!important;border-radius:0!important;overflow:hidden;display:block!important;}
  .hero-real-img--skin{width:100%!important;height:100%!important;object-fit:cover;object-position:center top;display:block;padding:0;}
  .hero-real-img--skin2{width:100%!important;height:100%!important;object-fit:cover;object-position:center top;display:block;}
  .hero-slide.active::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:linear-gradient(to right,rgba(0,0,0,.65) 0%,rgba(0,0,0,.40) 42%,rgba(0,0,0,.06) 100%);z-index:1;pointer-events:none;}
  .hero-content{position:absolute!important;top:0!important;left:0!important;width:62%!important;height:100%!important;z-index:2;padding:20px 14px 55px 18px!important;display:flex!important;flex-direction:column;justify-content:center;max-width:unset!important;flex:unset!important;box-sizing:border-box;}
  .hero-badge,.hero-desc,.hero-btns .btn-outline{display:none;}
  .hero-slide h1{font-size:clamp(1.05rem,4.8vw,1.4rem);line-height:1.22;margin:0 0 12px;color:#fff;font-weight:800;text-shadow:0 1px 8px rgba(0,0,0,.55);}
  .hero-slide h1 span{color:#a8efc4;}.hero-slide h1 br{display:none;}
  .hero-btns .btn-green{font-size:.8rem;padding:9px 18px;border-radius:50px;white-space:nowrap;background:var(--green,#2eaf6e);color:#fff;box-shadow:0 4px 16px rgba(46,175,110,.5);display:inline-flex;align-items:center;}
  .btn-ico{width:14px;height:14px;margin-right:5px;}.hero-float-badge{display:none;}.hero-blob,.hero-blob2{opacity:.1;}
  .h-prev{left:8px;}.h-next{right:8px;}
  .hero-nav{position:absolute;top:50%;transform:translateY(-50%);bottom:unset;width:26px;height:26px;font-size:14px;background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.38);backdrop-filter:blur(4px);z-index:5;}
  .hero-dots{bottom:8px;z-index:5;}.hero-dot{width:6px;height:6px;background:rgba(255,255,255,.45);}.hero-dot.active{width:16px;background:#fff;}
}
@media(max-width:380px) {
  .hero-slide.active{height:190px;min-height:190px;max-height:190px;margin:10px 10px;width:calc(100% - 20px);}
  .hero-slide h1{font-size:1rem;}.hero-content{padding:16px 12px 50px 14px!important;}
}

/* ═══════════════════════════════════════
   TOAST NOTIFICATION
═══════════════════════════════════════ */
#travotech-toast {
  position:fixed;bottom:100px;right:24px;z-index:999999;
  min-width:280px;max-width:340px;
  background:#1a3c2e;color:#fff;
  border-radius:14px;padding:14px 16px 18px;
  box-shadow:0 12px 40px rgba(0,0,0,.3);
  display:flex;align-items:flex-start;gap:12px;
  font-family:'Nunito',sans-serif;
  opacity:0;transform:translateY(20px) scale(0.95);
  transition:opacity .4s cubic-bezier(.34,1.56,.64,1),transform .4s cubic-bezier(.34,1.56,.64,1);
  pointer-events:none;
}
#travotech-toast.cv-show{opacity:1;transform:translateY(0) scale(1);pointer-events:all;}
.cv-toast-icon-wrap{width:36px;height:36px;border-radius:50%;background:#2eaf6e;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
.cv-toast-body{flex:1;min-width:0;}
.cv-toast-title{font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#2eaf6e;margin-bottom:3px;}
.cv-toast-name{font-size:.85rem;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:10px;}
.cv-toast-actions{display:flex;gap:8px;}
.cv-toast-btn-cart{display:inline-flex;align-items:center;gap:5px;background:#2eaf6e;color:#fff;padding:6px 12px;border-radius:8px;font-size:.72rem;font-weight:800;text-decoration:none;transition:background .2s;white-space:nowrap;}
.cv-toast-btn-cart:hover{background:#27964f;color:#fff;}
.cv-toast-btn-close{display:inline-flex;align-items:center;background:rgba(255,255,255,.1);color:rgba(255,255,255,.7);padding:6px 10px;border-radius:8px;border:none;cursor:pointer;font-size:.72rem;font-weight:700;transition:background .2s;font-family:'Nunito',sans-serif;}
.cv-toast-btn-close:hover{background:rgba(255,255,255,.2);color:#fff;}
.cv-toast-progress{position:absolute;bottom:0;left:0;right:0;height:4px;background:rgba(255,255,255,.15);border-radius:0 0 14px 14px;overflow:hidden;}
.cv-toast-progress-bar{height:100%;width:100%;background:#2eaf6e;transform-origin:left;animation:none;}
#travotech-toast.cv-show .cv-toast-progress-bar{animation:cvCountdown 5s linear forwards;}
@keyframes cvCountdown{from{transform:scaleX(1);}to{transform:scaleX(0);}}
@media(max-width:600px){#travotech-toast{bottom:80px;right:12px;left:12px;min-width:unset;max-width:unset;}}
</style>

<!-- TOAST HTML -->
<div id="travotech-toast" role="alert" aria-live="assertive">
  <div class="cv-toast-icon-wrap">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
  </div>
  <div class="cv-toast-body">
    <div class="cv-toast-title">Added to Cart</div>
    <div class="cv-toast-name" id="cv-toast-name"></div>
    <div class="cv-toast-actions">
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cv-toast-btn-cart">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
        View Cart
      </a>
      <button class="cv-toast-btn-close" id="cv-toast-close" type="button">Dismiss</button>
    </div>
  </div>
  <div class="cv-toast-progress"><div class="cv-toast-progress-bar"></div></div>
</div>


<!-- FEATURES STRIP -->
<div class="feat-strip">
  <div class="feat-grid">
    <div class="feat-item"><div class="feat-icon fi-g"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div><div><div class="feat-label">Fast Delivery</div><div class="feat-sub">Same day Nairobi</div></div></div>
    <div class="feat-div"></div>
    <div class="feat-item"><div class="feat-icon fi-b"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div><div><div class="feat-label">Multiple Payment</div><div class="feat-sub">M-Pesa, Cash &amp; more</div></div></div>
    <div class="feat-div"></div>
    <div class="feat-item"><div class="feat-icon fi-p"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div><div><div class="feat-label">Best Prices</div><div class="feat-sub">Guaranteed lowest</div></div></div>
    <div class="feat-div"></div>
    <div class="feat-item"><div class="feat-icon fi-o"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><div><div class="feat-label">24/7 Support</div><div class="feat-sub">Always available</div></div></div>
    <div class="feat-div"></div>
    <div class="feat-item"><div class="feat-icon fi-t"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div><div><div class="feat-label">Easy Prescription</div><div class="feat-sub">Upload &amp; we prepare</div></div></div>
  </div>
</div>

<style>
.search-sec{display:flex;align-items:center;gap:16px;padding:18px 48px;flex-wrap:wrap;}
.search-sec-label{display:flex;align-items:center;white-space:nowrap;font-weight:600;font-size:.95rem;flex-shrink:0;}
.search-sec-bar{display:flex;flex:1 1 300px;min-width:0;border-radius:50px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);}
.search-sec-input{flex:1;border:none;outline:none;padding:12px 20px;font-size:.9rem;min-width:0;background:#fff;}
.search-sec-btn{padding:12px 24px;border:none;cursor:pointer;font-weight:600;font-size:.9rem;white-space:nowrap;flex-shrink:0;}
@media(max-width:900px){.search-sec{padding:16px 24px;gap:12px;}}
@media(max-width:600px){.search-sec{flex-direction:column;align-items:stretch;padding:14px 16px;gap:10px;}.search-sec-label{font-size:.88rem;justify-content:center;}.search-sec-bar{flex:1 1 auto;width:100%;border-radius:12px;}.search-sec-input{padding:11px 16px;font-size:.88rem;border-radius:12px 0 0 12px;}.search-sec-btn{padding:11px 18px;font-size:.88rem;border-radius:0 12px 12px 0;}}
</style>
<div class="search-sec">
  <span class="search-sec-label">
    <svg style="width:17px;height:17px;margin-right:7px;flex-shrink:0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    Search Your Medicine:
  </span>
  <form class="search-sec-bar" method="get" action="<?php echo home_url('/'); ?>">
    <input class="search-sec-input" type="search" name="s" placeholder="e.g. Paracetamol, Vitamin C, Amoxicillin..." value="<?php echo get_search_query(); ?>">
    <input type="hidden" name="post_type" value="product">
    <button type="submit" class="search-sec-btn">Search</button>
  </form>
</div>

<style>
.cat-sec{padding:36px 48px 52px;}.cat-sec--pale{background:var(--green-pale,#f0faf5);}.cat-sec--light{background:#fff;}
.cat-sec-hdr{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:28px;}
.cat-sec-title{display:flex;align-items:center;gap:10px;font-size:2rem;font-weight:800;letter-spacing:-.02em;line-height:1.1;}
.cat-sec-title .cst-1{color:var(--dark,#1a3c2e);}.cat-sec-title .cst-2{color:var(--green,#2eaf6e);}
.cat-sec-viewall{font-size:.85rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;padding:7px 18px;border-radius:50px;border:1.5px solid currentColor;transition:background .2s,color .2s;white-space:nowrap;}
.cat-prod-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:28px;}
.cat-pagination{display:flex;justify-content:center;align-items:center;gap:6px;flex-wrap:wrap;margin-top:8px;}
.cat-page-btn{min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1.5px solid rgba(0,0,0,.12);background:#fff;font-size:.82rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s,border-color .2s,color .2s;text-decoration:none;color:var(--text,#1a2e25);font-family:'Nunito',sans-serif;}
.cat-page-btn.active,.cat-page-btn:hover{background:var(--green,#2eaf6e);border-color:var(--green,#2eaf6e);color:#fff;}
.cat-page-arrow{font-size:1.1rem;}.cat-page-dots{min-width:24px;height:36px;padding:0 4px;border:none;background:none;cursor:default;color:var(--text-light,#8aaa98);display:flex;align-items:center;justify-content:center;font-size:.9rem;}
.p-img-link{display:block;text-decoration:none;flex-shrink:0;overflow:hidden;}
.p-img{position:relative;width:100%;height:200px;overflow:hidden;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:#f8f8f8;}
.p-img img{width:100%;height:100%;object-fit:contain;object-position:center;display:block;transition:transform .3s;padding:8px;box-sizing:border-box;}
.p-card:hover .p-img img,.p-img-link:hover .p-img img{transform:scale(1.04);}
.p-body{padding:14px 14px 0;display:flex;flex-direction:column;flex:1;}
.p-card-meta{display:flex;align-items:center;gap:6px;flex-wrap:wrap;margin-bottom:5px;}
.p-card-cat{font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:2px 8px;border-radius:50px;line-height:1.5;white-space:nowrap;text-decoration:none;background:var(--green-light,#e8f8f0);color:var(--green,#2eaf6e);}
.p-card-brand{font-size:.62rem;font-weight:700;padding:2px 8px;border-radius:50px;line-height:1.5;border:1.2px solid var(--green-mid,#b8ecd4);white-space:nowrap;opacity:.85;color:var(--text-mid,#4a6358);}
.p-name{font-size:clamp(.95rem,1.8vw,1.05rem);font-weight:700;line-height:1.3;margin-bottom:4px;}
.p-name a{text-decoration:none;color:inherit;transition:color .15s;}.p-name a:hover{text-decoration:underline;}
.p-cat,.p-desc{display:none;}
.p-price-wrap{display:flex;align-items:center;gap:8px;margin:5px 0 10px;flex-wrap:wrap;}
.p-price-old{font-size:.72rem;text-decoration:line-through;opacity:.45;}
.p-price-cur{font-size:clamp(.95rem,1.8vw,1.05rem);font-weight:700;}
.p-btns{display:flex;flex-direction:column;gap:6px;margin-top:auto;padding:8px 10px 10px;}
.p-btn-cart,.p-btn-wa{display:flex;align-items:center;gap:8px;width:100%;padding:8px 10px;font-size:.7rem;font-weight:700;text-decoration:none;text-transform:uppercase;letter-spacing:.02em;border-radius:8px;border:none;cursor:pointer;transition:opacity .18s,transform .15s;box-sizing:border-box;white-space:nowrap;font-family:'Nunito',sans-serif;}
.p-btn-cart:hover,.p-btn-wa:hover{opacity:.88;transform:translateY(-1px);}
.p-btn-ico{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.p-btn-cart{background:#fff;color:var(--dark,#1a3c2e);border:1.5px solid rgba(0,0,0,.08);box-shadow:0 1px 4px rgba(0,0,0,.06);}
.p-btn-cart .p-btn-ico{background:var(--green,#2eaf6e);color:#fff;}
.p-btn-cart:hover{background:var(--green,#2eaf6e);color:#fff;border-color:var(--green,#2eaf6e);}
.p-btn-cart:hover .p-btn-ico{background:rgba(255,255,255,.25);}
.p-btn-wa{background:var(--green,#2eaf6e);color:#fff;border:none;box-shadow:0 2px 8px rgba(46,175,110,.25);}
.p-btn-wa .p-btn-ico{background:rgba(255,255,255,.2);color:#fff;}
.p-wish{position:absolute;top:10px;right:10px;width:30px;height:30px;border-radius:50%;background:white;border:none;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 10px rgba(0,0,0,.1);transition:all .2s;cursor:pointer;z-index:2;}
.p-badge-sale{position:absolute;top:10px;left:10px;background:#ff4757;color:white;font-size:.62rem;font-weight:800;padding:3px 9px;border-radius:50px;z-index:2;}
.p-badge-new{position:absolute;top:10px;left:10px;background:var(--green,#2eaf6e);color:white;font-size:.62rem;font-weight:800;padding:3px 9px;border-radius:50px;z-index:2;}
.p-btn-cart.cv-atc-loading { opacity:.65; pointer-events:none; }
.p-btn-cart.cv-atc-loading .p-btn-ico { animation: cvAtcSpin .6s linear infinite; }
@keyframes cvAtcSpin { to { transform: rotate(360deg); } }
@media(max-width:1023px)and (min-width:541px){.cat-sec{padding:28px 36px 40px;}.cat-prod-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:540px){.cat-sec{padding:20px 16px 32px;}.cat-sec-title{font-size:1.4rem;}.cat-prod-grid{grid-template-columns:repeat(2,1fr);gap:10px;}.p-img{height:160px;}.p-name{font-size:clamp(.88rem,4vw,1rem);}.p-btn-cart,.p-btn-wa{font-size:.65rem;padding:7px 8px;gap:6px;}.p-btn-ico{width:20px;height:20px;}.p-btns{gap:5px;padding:6px 8px 8px;}}
@media(max-width:320px){.cat-prod-grid{grid-template-columns:1fr;}}
</style>

<?php
function fp_find_cat( $names ) {
  foreach ( $names as $name ) {
    $t = get_term_by( 'slug', sanitize_title($name), 'product_cat' );
    if ( $t ) return $t;
    $t = get_term_by( 'name', $name, 'product_cat' );
    if ( $t ) return $t;
  }
  foreach ( $names as $name ) {
    $res = get_terms(['taxonomy'=>'product_cat','hide_empty'=>false,'name__like'=>$name,'number'=>1]);
    if ( $res && !is_wp_error($res) ) return $res[0];
  }
  return null;
}

function fp_get_meta( $post_id ) {
  $cats     = get_the_terms( $post_id, 'product_cat' );
  $cat_n    = ($cats && !is_wp_error($cats)) ? $cats[0]->name : '';
  $cat_link = ($cats && !is_wp_error($cats)) ? get_term_link($cats[0]) : '#';
  $brands   = get_the_terms( $post_id, 'product_brand' );
  if ( !$brands || is_wp_error($brands) ) $brands = get_the_terms( $post_id, 'pa_brand' );
  $brand_n  = ($brands && !is_wp_error($brands)) ? $brands[0]->name : '';
  return [ $cat_n, $cat_link, $brand_n ];
}

function fp_cart_ico() {
  return '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>';
}
function fp_wa_ico() {
  return '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
}
function fp_wish_ico() {
  return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>';
}

function fp_card( $product, $wa ) {
  $pid       = $product->get_id();
  $sale      = $product->is_on_sale();
  $is_new    = ( time() - strtotime($product->get_date_created()) ) < ( 30 * DAY_IN_SECONDS );
  $img       = get_the_post_thumbnail_url( $pid, 'woocommerce_thumbnail' );
  $pr        = $product->get_regular_price();
  $pc        = $product->get_price();
  $is_simple = $product->is_type('simple');
  $permalink = get_permalink($pid);
  $title     = get_the_title($pid);
  $title_short = mb_strlen($title) > 35 ? mb_substr($title, 0, 35) . '...' : $title;
  $sku       = esc_attr( $product->get_sku() );
  $wamsg     = urlencode( "Hello Travotech Agencies!\n\nI'd like to order:\n*" . $title . "*\nPrice: KES " . number_format($pc, 2) . "\n\nLink: " . $permalink . "\n\nPlease confirm availability. Thank you." );
  list( $cat_n, $cat_link, $brand_n ) = fp_get_meta($pid);
  $nonce     = wp_create_nonce('wc_add_to_cart_nonce');
  ?>
  <div class="p-card">
    <a href="<?php echo $permalink; ?>" class="p-img-link">
      <div class="p-img">
        <?php if ($img): ?><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
        <?php else: ?><svg style="width:56px;height:56px;opacity:.25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.5 3.5a6 6 0 018 8l-8.5 8.5a6 6 0 01-8-8l8.5-8.5z"/><line x1="9" y1="15" x2="15" y2="9"/></svg><?php endif; ?>
        <button class="p-wish" aria-label="Wishlist" onclick="event.preventDefault();event.stopPropagation();"><?php echo fp_wish_ico(); ?></button>
        <?php if ($sale && $pr): ?>
          <div class="p-badge-sale">-<?php echo round((($pr-$pc)/$pr)*100); ?>% OFF</div>
        <?php elseif ($is_new): ?>
          <div class="p-badge-new">NEW</div>
        <?php endif; ?>
      </div>
    </a>
    <div class="p-body">
      <?php if ($cat_n || $brand_n): ?>
        <div class="p-card-meta">
          <?php if ($cat_n): ?><a href="<?php echo esc_url($cat_link); ?>" class="p-card-cat"><?php echo esc_html($cat_n); ?></a><?php endif; ?>
          <?php if ($brand_n): ?><span class="p-card-brand"><?php echo esc_html($brand_n); ?></span><?php endif; ?>
        </div>
      <?php endif; ?>
      <div class="p-name"><a href="<?php echo $permalink; ?>"><?php echo esc_html($title); ?></a></div>
      <div class="p-price-wrap">
        <?php if ($sale && $pr): ?><div class="p-price-old">KES <?php echo number_format($pr,2); ?></div><?php endif; ?>
        <div class="p-price-cur">KES <?php echo number_format($pc,2); ?></div>
      </div>
      <div class="p-btns">
        <?php if ($is_simple): ?>
        <button type="button" class="p-btn-cart cv-atc-btn"
          data-pid="<?php echo esc_attr($pid); ?>"
          data-nonce="<?php echo esc_attr($nonce); ?>"
          data-name="<?php echo esc_attr($title_short); ?>">
          <span class="p-btn-ico"><?php echo fp_cart_ico(); ?></span>Add to Cart
        </button>
        <?php else: ?>
        <a href="<?php echo esc_url($permalink); ?>" class="p-btn-cart">
          <span class="p-btn-ico"><?php echo fp_cart_ico(); ?></span>Select Options
        </a>
        <?php endif; ?>
        <a href="https://wa.me/254720737151?text=<?php echo $wamsg; ?>"
           class="p-btn-wa" target="_blank" rel="noopener noreferrer">
          <span class="p-btn-ico"><?php echo fp_wa_ico(); ?></span>Buy Via WhatsApp
        </a>
      </div>
    </div>
  </div>
  <?php
}

function fp_build_base( $page_param ) {
  $params = $_GET;
  unset( $params[$page_param] );
  $qs = http_build_query($params);
  return home_url('/') . ( $qs ? '?' . $qs . '&' : '?' );
}

function fp_pagination( $cur_page, $total, $base, $page_param, $id ) {
  if ( $total <= 1 ) return;
  $delta = 2;
  echo '<div class="cat-pagination">';
  if ( $cur_page > 1 )
    echo '<a href="' . esc_url($base.$page_param.'='.($cur_page-1).'#'.$id.'-section') . '" class="cat-page-btn cat-page-arrow" aria-label="Previous">&#8249;</a>';
  $show = [];
  for ( $i = 1; $i <= $total; $i++ ) {
    if ( $i===1 || $i===$total || abs($i-$cur_page)<=$delta ) $show[] = $i;
  }
  $prev = null;
  foreach ( $show as $p ) {
    if ( $prev !== null && $p-$prev > 1 )
      echo '<span class="cat-page-dots">&#8230;</span>';
    echo '<a href="' . esc_url($base.$page_param.'='.$p.'#'.$id.'-section') . '"
             class="cat-page-btn '.($p===$cur_page?'active':'').'"
             aria-label="Page '.$p.'"'.($p===$cur_page?' aria-current="page"':'').'>'.$p.'</a>';
    $prev = $p;
  }
  if ( $cur_page < $total )
    echo '<a href="' . esc_url($base.$page_param.'='.($cur_page+1).'#'.$id.'-section') . '" class="cat-page-btn cat-page-arrow" aria-label="Next">&#8250;</a>';
  echo '</div>';
}

function fp_section( $id, $label1, $label2, $cat_names, $bg, $wa ) {
  $per_page   = 4;
  $page_param = $id . '_page';
  $cur_page   = max( 1, intval( $_GET[$page_param] ?? 1 ) );
  $cat_obj    = fp_find_cat($cat_names);
  $cat_slug   = $cat_obj ? $cat_obj->slug : '';
  $cat_link   = $cat_obj ? get_term_link($cat_obj) : get_permalink(wc_get_page_id('shop'));
  $q_args = [
    'post_type'      => 'product',
    'posts_per_page' => $per_page,
    'paged'          => $cur_page,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ];
  if ( $cat_slug )
    $q_args['tax_query'] = [['taxonomy'=>'product_cat','field'=>'slug','terms'=>$cat_slug]];
  $q     = new WP_Query($q_args);
  $total = $q->max_num_pages;
  $base  = fp_build_base($page_param);
  ?>
  <div id="<?php echo esc_attr($id); ?>-section" style="scroll-margin-top:90px;"></div>
  <section class="cat-sec <?php echo esc_attr($bg); ?>">
    <div class="cat-sec-hdr">
      <div class="cat-sec-title">
        <span class="cst-1"><?php echo esc_html($label1); ?></span>
        <span class="cst-2"><?php echo esc_html($label2); ?></span>
      </div>
      <a href="<?php echo esc_url($cat_link); ?>" class="cat-sec-viewall">
        View All <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>
    <div class="cat-prod-grid">
      <?php if ( $q->have_posts() ):
        while ( $q->have_posts() ) { $q->the_post(); global $product; fp_card($product, $wa); }
        wp_reset_postdata();
      else: ?>
        <p style="grid-column:1/-1;text-align:center;color:var(--text-light,#8aaa98);padding:40px;opacity:.65;">
          No <strong><?php echo esc_html("$label1 $label2"); ?></strong> products yet.
        </p>
      <?php endif; ?>
    </div>
    <?php fp_pagination($cur_page, $total, $base, $page_param, $id); ?>
  </section>
  <?php
}
?>

<!-- BEAUTY & PERSONAL CARE -->
<?php fp_section('beauty','Beauty &','Personal Care',['Beauty & Personal Care','Beauty and Personal Care','beauty-personal-care','beauty','personal-care','personal care','skincare','skin care','skin-care'],'cat-sec--pale','254720737151'); ?>

<!-- MOTHER & CHILD -->
<?php fp_section('mc','Mother &','Child',['Mother & Child','Mother and Child','mother-child','mother-and-child','Baby Care','baby-care','baby care','baby','maternity','Mother & Baby'],'cat-sec--light','254720737151'); ?>


<!-- WHY US -->
<section class="why-sec" id="about">
  <div class="why-grid">
    <div class="why-img-wrap">
      <div class="why-blob"></div>
      <div class="why-img why-img--real">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/js/images/doctors.png" alt="" style="width:100%;height:100%;object-fit:contain;object-position:bottom center;display:block;">
      </div>
      <div class="why-years"><div class="why-years-n">12</div><div class="why-years-t">YEARS<br>SERVING</div></div>
    </div>
    <div>
      <div class="sec-tag sec-tag-outline reveal">Why We're Best?</div>
      <h2 class="sec-title reveal rd1">Why Choose Us<br><span>Healing Starts Here.</span></h2>
      <p class="sec-desc reveal rd2">Kenya's most trusted pharmacy serving thousands of families with quality, affordable and certified medicines since 2012.</p>
      <div class="why-feats">
        <div class="why-feat reveal rd1"><div class="wf-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 9.5V5a2.5 2.5 0 015 0v4.5"/><path d="M9.5 7H4.5"/><circle cx="15.5" cy="15.5" r="4.5"/><path d="M9.5 9.5C9.5 12.5 15.5 12.5 15.5 15"/></svg></div><div><div class="wf-title">Licensed Pharmacists</div><div class="wf-desc">All staff licensed by the Pharmacy and Poisons Board of Kenya.</div></div></div>
        <div class="why-feat reveal rd2"><div class="wf-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg></div><div><div class="wf-title">24/7 Emergency Services</div><div class="wf-desc">Round the clock availability via WhatsApp for urgent needs.</div></div></div>
        <div class="why-feat reveal rd3"><div class="wf-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div><div><div class="wf-title">Free Consultation</div><div class="wf-desc">Chat with our pharmacist before purchasing, always free.</div></div></div>
        <div class="why-feat reveal rd4"><div class="wf-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-1a2 2 0 012-2h16a2 2 0 012 2v1a2 2 0 01-2 2h-2"/><rect x="6" y="18" width="12" height="4"/></svg></div><div><div class="wf-title">Excellence Reward</div><div class="wf-desc">Award-winning pharmacy recognized for quality healthcare.</div></div></div>
      </div>
    </div>
  </div>
</section>
<style>.why-img--real{overflow:hidden;background:linear-gradient(180deg,#e8f5e9,#c8e6c9);}</style>

<!-- SERVICES -->
<section class="srv-sec">
  <div style="text-align:center">
    <div class="sec-tag sec-tag-solid reveal">Our Services</div>
    <h2 class="sec-title reveal rd1">What We <span>Offer</span></h2>
  </div>
  <div class="srv-grid">
    <div class="srv-card reveal"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div><div class="srv-name">Prescription<br>Medicines</div></div>
    <div class="srv-card hl reveal rd1"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><div class="srv-name">24/7 Emergency<br>Services</div></div>
    <div class="srv-card reveal rd2"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div><div class="srv-name">Free<br>Consultation</div></div>
    <div class="srv-card reveal rd3"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg></div><div class="srv-name">Excellence<br>Rewards</div></div>
    <div class="srv-card reveal rd4"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div><div class="srv-name">Countrywide<br>Delivery</div></div>
    <div class="srv-card reveal rd1"><div class="srv-icon-c"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div><div class="srv-name">Professional<br>Pharmacists</div></div>
  </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="prod-sec" id="products">
  <div class="prod-header">
    <div>
      <div class="sec-tag sec-tag-solid reveal">Our Catalogue</div>
      <h2 class="sec-title reveal rd1">Featured <span>Products</span></h2>
    </div>
    <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn-outline reveal">View All Products &rarr;</a>
  </div>
  <div class="prod-tabs reveal">
    <button class="tab-btn active" data-cat="">All</button>
    <?php foreach (get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,'number'=>6]) as $tc): ?>
      <button class="tab-btn" data-cat="<?php echo esc_attr($tc->slug); ?>"><?php echo esc_html($tc->name); ?></button>
    <?php endforeach; ?>
  </div>

  <?php
  $fp_page  = max(1, intval($_GET['fp_page'] ?? 1));
  $fp_base  = fp_build_base('fp_page');
  $fp_q     = new WP_Query(['post_type'=>'product','posts_per_page'=>4,'paged'=>$fp_page,'orderby'=>'date','order'=>'DESC']);
  $fp_total = $fp_q->max_num_pages;
  ?>

  <div class="prod-grid cat-prod-grid" id="prodGrid" style="margin-bottom:28px;">
    <?php
    if ($fp_q->have_posts()):
      while ($fp_q->have_posts()): $fp_q->the_post(); global $product;
        $sale      = $product->is_on_sale();
        $is_new    = (time() - strtotime($product->get_date_created())) < (30*DAY_IN_SECONDS);
        $img       = get_the_post_thumbnail_url(get_the_ID(),'woocommerce_thumbnail');
        $pr        = $product->get_regular_price();
        $pc        = $product->get_price();
        $is_simple = $product->is_type('simple');
        $title     = get_the_title();
        $title_short = mb_strlen($title) > 35 ? mb_substr($title, 0, 35) . '...' : $title;
        $wamsg     = urlencode("Hello Travotech Agencies!\n\nI'd like to order:\n*".$title."*\nPrice: KES ".number_format($pc,2)."\n\nLink: ".get_permalink()."\n\nPlease confirm availability. Thank you.");
        $cats      = get_the_terms(get_the_ID(),'product_cat');
        $cat_n     = ($cats && !is_wp_error($cats)) ? $cats[0]->name : '';
        $cat_lnk   = ($cats && !is_wp_error($cats)) ? get_term_link($cats[0]) : '#';
        $brands    = get_the_terms(get_the_ID(),'product_brand');
        if (!$brands || is_wp_error($brands)) $brands = get_the_terms(get_the_ID(),'pa_brand');
        $brand_n   = ($brands && !is_wp_error($brands)) ? $brands[0]->name : '';
        $nonce     = wp_create_nonce('wc_add_to_cart_nonce');
    ?>
    <div class="p-card reveal">
      <a href="<?php the_permalink(); ?>" class="p-img-link">
        <div class="p-img">
          <?php if ($img): ?><img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
          <?php else: ?><svg style="width:56px;height:56px;opacity:.25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.5 3.5a6 6 0 018 8l-8.5 8.5a6 6 0 01-8-8l8.5-8.5z"/><line x1="9" y1="15" x2="15" y2="9"/></svg><?php endif; ?>
          <button class="p-wish" aria-label="Wishlist" onclick="event.preventDefault();event.stopPropagation();">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
          </button>
          <?php if ($sale && $pr): ?><div class="p-badge-sale">-<?php echo round((($pr-$pc)/$pr)*100); ?>% OFF</div>
          <?php elseif ($is_new): ?><div class="p-badge-new">NEW</div><?php endif; ?>
        </div>
      </a>
      <div class="p-body">
        <?php if ($cat_n || $brand_n): ?>
          <div class="p-card-meta">
            <?php if ($cat_n): ?><a href="<?php echo esc_url($cat_lnk); ?>" class="p-card-cat"><?php echo esc_html($cat_n); ?></a><?php endif; ?>
            <?php if ($brand_n): ?><span class="p-card-brand"><?php echo esc_html($brand_n); ?></span><?php endif; ?>
          </div>
        <?php endif; ?>
        <div class="p-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
        <div class="p-price-wrap">
          <?php if ($sale && $pr): ?><div class="p-price-old">KES <?php echo number_format($pr,2); ?></div><?php endif; ?>
          <div class="p-price-cur">KES <?php echo number_format($pc,2); ?></div>
        </div>
        <div class="p-btns">
          <?php if ($is_simple): ?>
          <button type="button" class="p-btn-cart cv-atc-btn"
            data-pid="<?php echo get_the_ID(); ?>"
            data-nonce="<?php echo esc_attr($nonce); ?>"
            data-name="<?php echo esc_attr($title_short); ?>">
            <span class="p-btn-ico"><?php echo fp_cart_ico(); ?></span>Add to Cart
          </button>
          <?php else: ?>
          <a href="<?php the_permalink(); ?>" class="p-btn-cart">
            <span class="p-btn-ico"><?php echo fp_cart_ico(); ?></span>Select Options
          </a>
          <?php endif; ?>
          <a href="https://wa.me/254720737151?text=<?php echo $wamsg; ?>"
             class="p-btn-wa" target="_blank" rel="noopener noreferrer">
            <span class="p-btn-ico"><?php echo fp_wa_ico(); ?></span>Buy Via WhatsApp
          </a>
        </div>
      </div>
    </div>
    <?php endwhile; wp_reset_postdata();
    else: echo '<p style="grid-column:1/-1;text-align:center;color:var(--text-light);padding:40px;">No products yet.</p>';
    endif; ?>
  </div>

  <div id="products-section" style="scroll-margin-top:90px;"></div>
  <?php fp_pagination($fp_page, $fp_total, $fp_base, 'fp_page', 'products'); ?>
</section>

<!-- CTA SECTION -->
<section class="cta-sec" id="contact">
  <div class="cta-b1"></div><div class="cta-b2"></div>
  <div class="cta-grid">
    <div class="cta-content">
      <div class="sec-tag sec-tag-solid reveal" style="background:rgba(255,255,255,.2)">Get In Touch</div>
      <h2 class="sec-title reveal rd1">Health Care<br><span>With Us</span></h2>
      <p class="sec-desc reveal rd2" style="color:rgba(255,255,255,.8)">Have a product enquiry? Need a prescription filled? Reach out and we'll respond promptly.</p>
      <div class="cta-btns reveal rd3">
        <a href="https://wa.me/254720737151" class="btn-green" style="background:white;color:var(--green);box-shadow:0 6px 20px rgba(0,0,0,.15)" target="_blank" rel="noopener noreferrer">
          <svg style="width:20px;height:20px;margin-right:8px" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Chat on WhatsApp
        </a>
        <a href="tel:+254720737151" class="btn-outline" style="border-color:rgba(255,255,255,.5);color:white">
          <svg style="width:18px;height:18px;margin-right:8px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.27 9.09 19.79 19.79 0 01.22.45 2 2 0 012.22 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.72 6.72l1.28-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
          +254 790 007 616
        </a>
      </div>
    </div>

    <!-- ── HOME CONTACT FORM ── -->
    <div class="cta-form reveal rd1">
      <div class="cta-form-title">Send Us a Message</div>
      <form data-cvform="home" method="post" novalidate>
        <?php wp_nonce_field('travotech_nonce','nonce'); ?>
        <input type="hidden" name="action" value="travotech_contact">
        <div class="form-row">
          <div class="fg" id="hfg-name">
            <input type="text" id="hcv_name" name="contact_name" placeholder="Your Name">
            <div class="hcv-err">Please enter your name</div>
          </div>
          <div class="fg" id="hfg-email">
            <input type="email" id="hcv_email" name="contact_email" placeholder="Email Address">
            <div class="hcv-err">Please enter a valid email</div>
          </div>
        </div>
        <div class="form-row">
          <div class="fg" id="hfg-phone">
            <input type="tel" id="hcv_phone" name="contact_phone" placeholder="Phone / WhatsApp">
            <div class="hcv-err">Please enter your phone number</div>
          </div>
          <div class="fg" id="hfg-dept">
            <select id="hcv_dept" name="contact_dept">
              <option value="">Department</option>
              <option value="Prescription">Prescription</option>
              <option value="Product Enquiry">Product Enquiry</option>
              <option value="Delivery">Delivery</option>
            </select>
            <div class="hcv-err">Please select a department</div>
          </div>
        </div>
        <div class="fg" id="hfg-msg">
          <textarea id="hcv_msg" name="contact_msg" placeholder="Your message..."></textarea>
          <div class="hcv-err">Please enter your message</div>
        </div>
        <button type="button" class="form-submit" id="hcvSubmitBtn">Send Message &rarr;</button>

        <!-- Success Toast -->
        <div class="hcv-toast hcv-success" id="hcvSuccess" role="alert" aria-live="polite">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Message sent! Our pharmacist will get back to you shortly. For urgent enquiries WhatsApp us on <a href="https://wa.me/254720737151" style="color:inherit;font-weight:900;text-decoration:underline;" target="_blank">+254 790 007616</a>.</span>
        </div>

        <!-- Error Toast -->
        <div class="hcv-toast hcv-error" id="hcvError" role="alert" aria-live="polite">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;margin-top:2px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>
          <span id="hcvErrorText"></span>
        </div>
      </form>

      <style>
      .hcv-err {
        font-size:.68rem;color:#e53935;font-weight:700;
        margin-top:3px;display:none;font-family:'Nunito',sans-serif;
      }
      .hfg-invalid input,
      .hfg-invalid select,
      .hfg-invalid textarea {
        border-color:#e53935 !important;background:#fff8f8 !important;
      }
      .hfg-invalid .hcv-err { display:block; }
      .hcv-toast {
        display:flex;align-items:flex-start;gap:8px;border-radius:10px;
        padding:0 14px;font-size:.78rem;font-weight:700;
        font-family:'Nunito',sans-serif;border:1.5px solid transparent;
        line-height:1.45;opacity:0;max-height:0;overflow:hidden;
        pointer-events:none;margin-top:0;
        transition:opacity .35s ease,max-height .45s ease,padding .45s ease,margin-top .45s ease;
      }
      .hcv-toast.hcv-show {
        opacity:1;max-height:120px;padding:12px 14px;
        margin-top:14px;pointer-events:auto;
      }
      .hcv-toast.hcv-success{background:#edfaf3;color:#1a6e44;border-color:#6fcf97;}
      .hcv-toast.hcv-error  {background:#fff0f0;color:#b71c1c;border-color:#ef9a9a;}
      .hcv-toast svg{flex-shrink:0;margin-top:2px;}
      </style>
    </div>

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
    $team   = [['Dr. Sarah Wanjiku','Lead Pharmacist'],['Dr. James Otieno','Clinical Pharmacist'],['Dr. Grace Kamau','Pharmaceutical Tech'],['Dr. Peter Mwangi','Pharmacy Manager']];
    $delays = ['','rd1','rd2','rd3'];
    foreach ($team as $i => $m): ?>
    <div class="t-card reveal <?php echo $delays[$i]; ?>">
      <div class="t-img"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:56px;height:56px;opacity:.6"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
      <div class="t-body">
        <div class="t-name"><?php echo esc_html($m[0]); ?></div>
        <div class="t-role"><?php echo esc_html($m[1]); ?></div>
        <div class="t-socials">
          <a href="#" class="t-soc">in</a><a href="#" class="t-soc">f</a>
          <a href="#" class="t-soc"><svg style="width:14px;height:14px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="test-sec">
  <div class="test-b1"></div><div class="test-b2"></div>
  <div class="test-hdr">
    <div class="sec-tag sec-tag-solid reveal">Testimonials</div>
    <h2 class="sec-title reveal rd1">Our Customer <span>Feedback</span></h2>
  </div>
  <div class="test-grid">
    <div class="t-card2 reveal">
      <div class="t-quote">&ldquo;</div>
      <p class="t-text">This pharmacy has been my go-to for 3 years. The prices are unbeatable and the WhatsApp service is incredibly fast. Highly recommended!</p>
      <div class="t-author">
        <div class="t-av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:32px;height:32px"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
        <div><div class="t-aname">Mary Wambui</div><div class="t-arole">Regular Customer,Westlands.</div><div class="t-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div></div>
      </div>
    </div>
    <div class="t-card2 reveal rd1">
      <div class="t-quote">&ldquo;</div>
      <p class="t-text">I submitted my prescription via WhatsApp in the morning and had my medication delivered by afternoon. Best pharmacy service I've experienced in Kenya!</p>
      <div class="t-author">
        <div class="t-av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:32px;height:32px"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
        <div><div class="t-aname">John Kariuki</div><div class="t-arole">Regular Customer, Kileleshwa.</div><div class="t-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════
     ADD TO CART — SILENT FETCH + TOAST JS
═══════════════════════════════════════ -->
<script>
(function(){

  var CART_URL = '<?php echo esc_js(wc_get_cart_url()); ?>';
  var HOME_URL = '<?php echo esc_js(home_url("/")); ?>';

  /* ── CART TOAST ── */
  var toast    = document.getElementById('travotech-toast');
  var toastNm  = document.getElementById('cv-toast-name');
  var toastBar = toast ? toast.querySelector('.cv-toast-progress-bar') : null;
  var closeBtn = document.getElementById('cv-toast-close');
  var hideTimer = null;

  function showCartToast(name) {
    if (!toast) return;
    if (toastNm) toastNm.textContent = name || '';
    if (toastBar) {
      toastBar.style.animation = 'none';
      void toastBar.offsetWidth;
      toastBar.style.animation = '';
    }
    toast.classList.add('cv-show');
    clearTimeout(hideTimer);
    hideTimer = setTimeout(function(){ toast.classList.remove('cv-show'); }, 5000);
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', function(){
      toast.classList.remove('cv-show');
      clearTimeout(hideTimer);
    });
  }

  /* ── RESTORE SCROLL + SHOW CART TOAST AFTER ATC RELOAD ── */
  (function restoreAfterATC(){
    var savedY = sessionStorage.getItem('fp_scroll_y');
    var tname  = sessionStorage.getItem('fp_toast_name');
    if (savedY === null) return;
    var y = parseInt(savedY) || 0;
    sessionStorage.removeItem('fp_scroll_y');
    sessionStorage.removeItem('fp_toast_name');
    document.documentElement.scrollTop = y;
    document.body.scrollTop            = y;
    function lock(){ document.documentElement.scrollTop = y; document.body.scrollTop = y; }
    document.addEventListener('DOMContentLoaded', function(){ lock(); if (tname) showCartToast(tname); });
    window.addEventListener('load', lock);
    var lockTimer = setInterval(lock, 16);
    setTimeout(function(){ clearInterval(lockTimer); }, 800);
  })();

  /* ── ADD TO CART CLICK ── */
  document.addEventListener('click', function(e) {
    var btn = e.target.closest('.cv-atc-btn');
    if (!btn) return;
    e.preventDefault();
    e.stopPropagation();
    var pid  = btn.getAttribute('data-pid');
    var name = btn.getAttribute('data-name');
    var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
    sessionStorage.setItem('fp_scroll_y',   scrollY);
    sessionStorage.setItem('fp_toast_name', name);
    btn.classList.add('cv-atc-loading');
    window.location.href = HOME_URL + '?add-to-cart=' + encodeURIComponent(pid) + '&quantity=1';
  });

})();
</script>

<!-- ═══════════════════════════════════════
     HOME CONTACT FORM — runs after all scripts
═══════════════════════════════════════ -->
<script>
window.addEventListener('load', function () {

  var form = document.querySelector('[data-cvform="home"]');
  if (!form) return;

  /* Clone to strip any listeners main.js attached */
  var fresh = form.cloneNode(true);
  form.parentNode.replaceChild(fresh, form);
  form = fresh;

  var btn        = document.getElementById('hcvSubmitBtn');
  var successEl  = document.getElementById('hcvSuccess');
  var errorEl    = document.getElementById('hcvError');
  var errorText  = document.getElementById('hcvErrorText');
  var toastTimer = null;
  var isSending  = false;

  var fields = [
    { id: 'hfg-name',  input: 'hcv_name',  check: function(v){ return v.trim().length >= 2; } },
    { id: 'hfg-email', input: 'hcv_email', check: function(v){ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()); } },
    { id: 'hfg-phone', input: 'hcv_phone', check: function(v){ return v.trim().replace(/\s/g,'').length >= 9; } },
    { id: 'hfg-dept',  input: 'hcv_dept',  check: function(v){ return v !== '' && v !== 'Department'; } },
    { id: 'hfg-msg',   input: 'hcv_msg',   check: function(v){ return v.trim().length >= 5; } }
  ];

  function showToast(el, ms) {
    clearTimeout(toastTimer);
    if (successEl) successEl.classList.remove('hcv-show');
    if (errorEl)   errorEl.classList.remove('hcv-show');
    el.classList.add('hcv-show');
    toastTimer = setTimeout(function(){ el.classList.remove('hcv-show'); }, ms || 6000);
  }

  function btnLoading() { btn.textContent = 'Sending…';       btn.disabled = true;  isSending = true;  }
  function btnReset()   { btn.textContent = 'Send Message →'; btn.disabled = false; isSending = false; }

  function validateField(f, el, fg) {
    var pass = f.check(el.value);
    fg.classList.toggle('hfg-invalid', !pass);
    return pass;
  }

  function validateAll() {
    var ok = true;
    fields.forEach(function(f) {
      var el = document.getElementById(f.input);
      var fg = document.getElementById(f.id);
      if (el && fg && !validateField(f, el, fg)) ok = false;
    });
    return ok;
  }

  function resetForm() {
    btnReset();
    form.reset();
    fields.forEach(function(f) {
      var fg = document.getElementById(f.id);
      if (fg) fg.classList.remove('hfg-invalid');
    });
  }

  fields.forEach(function(f) {
    var el = document.getElementById(f.input);
    var fg = document.getElementById(f.id);
    if (!el || !fg) return;
    el.addEventListener('blur',   function(){ if (!isSending) validateField(f, el, fg); });
    el.addEventListener('input',  function(){ if (!isSending && fg.classList.contains('hfg-invalid')) validateField(f, el, fg); });
    el.addEventListener('change', function(){ if (!isSending && fg.classList.contains('hfg-invalid')) validateField(f, el, fg); });
  });

  /* type="button" means form submit never fires — main.js can't intercept */
  btn.addEventListener('click', function() {
    if (isSending) return;

    /* Validation fail — field errors only, no toast, no fetch */
    if (!validateAll()) {
      var first = form.querySelector('.hfg-invalid');
      if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    btnLoading();

    var formData = new FormData(form);

    fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
      method: 'POST',
      body:   formData
    })
    .then(function(r){ return r.text(); })
    .then(function(raw) {
      var clean = raw.trim();
      var s = clean.indexOf('{');
      if (s > 0) clean = clean.substring(s);
      var data;
      try { data = JSON.parse(clean); }
      catch(e) {
        btnReset();
        errorText.textContent = 'Server error. Please contact us via WhatsApp on +254 790 007616.';
        showToast(errorEl, 8000);
        return;
      }
      if (data.success) {
        resetForm();
        showToast(successEl, 7000);
      } else {
        btnReset();
        errorText.textContent = (data.data && data.data.msg)
          ? data.data.msg
          : 'Mail delivery failed. Please contact us via WhatsApp on +254 790 007616.';
        showToast(errorEl, 7000);
      }
    })
    .catch(function() {
      btnReset();
      errorText.textContent = 'Network error. Please check your connection and try again.';
      showToast(errorEl, 7000);
    });
  });

});
</script>

<?php get_footer(); ?>