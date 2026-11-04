<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#2eaf6e">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<style>
/* ═══════════════════════════════════════════
   TROVATECH PAGE LOADER
   Background: deep pharmacy green (#1a3c2e)
   Spinner: bright green + red accent
   Starts painting on browser first frame
═══════════════════════════════════════════ */
#cv-page-loader {
  position: fixed; inset: 0; z-index: 9999999;
  background: #1a3c2e;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  gap: clamp(18px,4vw,28px);
  opacity: 1; transition: opacity .4s ease;
}
#cv-page-loader.cv-ld-out { opacity: 0; pointer-events: none; }

/* Glow backdrop behind icon */
.cv-ld-glow {
  position: absolute;
  width: clamp(140px,35vw,220px);
  height: clamp(140px,35vw,220px);
  border-radius: 50%;
  background: radial-gradient(circle, rgba(46,175,110,.18) 0%, transparent 70%);
  animation: cv-glow-pulse 2s ease-in-out infinite;
}
@keyframes cv-glow-pulse {
  0%,100% { transform: scale(1);   opacity: .7; }
  50%      { transform: scale(1.2); opacity: 1;  }
}

/* Icon wrapper */
.cv-ld-icon {
  position: relative;
  width:  clamp(72px,18vw,110px);
  height: clamp(72px,18vw,110px);
  display: flex; align-items: center; justify-content: center;
  z-index: 1;
}

/* Outer spinning ring */
.cv-ld-ring {
  position: absolute; inset: 0; border-radius: 50%;
  border: clamp(4px,.9vw,6px) solid rgba(46,175,110,.2);
  border-top-color:    #2eaf6e;
  border-right-color:  #3dc97e;
  border-bottom-color: rgba(229,57,53,.35);
  border-left-color:   #e53935;
  animation: cv-spin 1s cubic-bezier(.55,.08,.45,.92) infinite;
}
@keyframes cv-spin { to { transform: rotate(360deg); } }

/* Inner counter-spin ring */
.cv-ld-ring2 {
  position: absolute;
  inset: clamp(8px,2vw,12px);
  border-radius: 50%;
  border: clamp(2px,.5vw,3px) solid rgba(255,255,255,.08);
  border-top-color: rgba(255,255,255,.25);
  border-bottom-color: rgba(229,57,53,.2);
  animation: cv-spin2 1.6s linear infinite;
}
@keyframes cv-spin2 { to { transform: rotate(-360deg); } }

/* Pharmacy cross — white on dark bg */
.cv-ld-bar-v {
  position: absolute;
  width:  clamp(12px,3vw,18px);
  height: clamp(36px,9vw,56px);
  background: #fff;
  border-radius: 4px;
  box-shadow: 0 0 12px rgba(46,175,110,.6);
}
.cv-ld-bar-h {
  position: absolute;
  width:  clamp(36px,9vw,56px);
  height: clamp(12px,3vw,18px);
  background: #fff;
  border-radius: 4px;
  box-shadow: 0 0 12px rgba(46,175,110,.6);
}

/* Red accent dot */
.cv-ld-red-dot {
  position: absolute;
  bottom: clamp(4px,1vw,8px); right: clamp(4px,1vw,8px);
  width:  clamp(9px,2.2vw,14px);
  height: clamp(9px,2.2vw,14px);
  background: #e53935; border-radius: 50%;
  box-shadow: 0 0 8px rgba(229,57,53,.7);
  animation: cv-pulse 1.4s ease-in-out infinite;
}
@keyframes cv-pulse {
  0%,100% { transform: scale(1);    opacity: 1;  }
  50%      { transform: scale(1.4); opacity: .7; }
}

/* Three dot pulse */
.cv-ld-dots { display: flex; gap: clamp(7px,1.8vw,12px); z-index: 1; }
.cv-ld-d {
  display: block;
  width:  clamp(8px,2vw,11px);
  height: clamp(8px,2vw,11px);
  border-radius: 50%;
  animation: cv-dots 1.3s ease-in-out infinite;
}
.cv-ld-d:nth-child(1) { background: #2eaf6e; animation-delay: 0s;   box-shadow: 0 0 8px rgba(46,175,110,.6); }
.cv-ld-d:nth-child(2) { background: #3dc97e; animation-delay: .2s;  box-shadow: 0 0 8px rgba(61,201,126,.6); }
.cv-ld-d:nth-child(3) { background: #e53935; animation-delay: .4s;  box-shadow: 0 0 8px rgba(229,57,53,.6);  }
@keyframes cv-dots {
  0%,80%,100% { transform: scale(.5); opacity: .35; }
  40%          { transform: scale(1);  opacity: 1;   }
}

/* Typing name */
.cv-ld-name {
  display: flex; align-items: center; gap: 3px;
  font-family: system-ui, -apple-system, sans-serif;
  font-size: clamp(.82rem,3.2vw,1.2rem);
  font-weight: 800; letter-spacing: .2em;
  text-transform: uppercase;
  min-height: 1.8em; user-select: none;
  z-index: 1;
}
.cv-ld-typed .cv-char {
  display: inline-block; opacity: 0; transform: translateY(8px);
  animation: cv-char-in .2s ease forwards;
}
@keyframes cv-char-in { to { opacity: 1; transform: translateY(0); } }
.cv-ld-typed .cv-g  { color: #2eaf6e; }
.cv-ld-typed .cv-r  { color: #e53935; }
.cv-ld-typed .cv-w  { color: rgba(255,255,255,.85); }
.cv-ld-cursor {
  color: #2eaf6e; font-weight: 300; font-size: 1.3em;
  line-height: 1; margin-left: 2px;
  animation: cv-blink .7s step-end infinite;
}
@keyframes cv-blink { 0%,100%{opacity:1;} 50%{opacity:0;} }

/* Thin green border at bottom */
.cv-ld-border {
  position: absolute; bottom: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, transparent, #2eaf6e, #e53935, #2eaf6e, transparent);
  animation: cv-border-slide 2s linear infinite;
  background-size: 200% 100%;
}
@keyframes cv-border-slide {
  0%   { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

@media (prefers-reduced-motion: reduce) {
  .cv-ld-ring, .cv-ld-ring2, .cv-ld-d, .cv-ld-red-dot,
  .cv-ld-cursor, .cv-ld-glow, .cv-ld-border { animation: none !important; }
  .cv-ld-typed .cv-char { opacity: 1 !important; transform: none !important; animation: none !important; }
}
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- ═══════════════════════════════════
     TROVATECH PAGE LOADER
═══════════════════════════════════ -->
<div id="cv-page-loader" aria-hidden="true">
  <div class="cv-ld-glow"></div>

  <div class="cv-ld-icon">
    <div class="cv-ld-ring"></div>
    <div class="cv-ld-ring2"></div>
    <div class="cv-ld-bar-v"></div>
    <div class="cv-ld-bar-h"></div>
    <div class="cv-ld-red-dot"></div>
  </div>

  <div class="cv-ld-dots">
    <span class="cv-ld-d"></span>
    <span class="cv-ld-d"></span>
    <span class="cv-ld-d"></span>
  </div>

  <div class="cv-ld-name" aria-label="Trovatech Agencies">
    <span class="cv-ld-typed" id="cvLdTyped"></span>
    <span class="cv-ld-cursor" aria-hidden="true">|</span>
  </div>

  <div class="cv-ld-border"></div>
</div>

<script>
(function(){
  var typed = document.getElementById('cvLdTyped');
  if (!typed) return;
  /* C-A-R-E = green, V-E-E = red, space+PHARMACY = white */
  var FULL = 'TROVATECH AGENCIES';
  function col(i){ return i<=3?'cv-g':i<=6?'cv-r':'cv-w'; }
  var i=0, ready=false, t=null;
  function tick(){
    if(i>=FULL.length){
      if(!ready){ typed.innerHTML=''; i=0; t=setTimeout(tick,1200); }
      return;
    }
    var s=document.createElement('span');
    s.className='cv-char '+col(i);
    s.textContent=FULL[i]===' '?' ':FULL[i];
    typed.appendChild(s); i++;
    t=setTimeout(tick,90);
  }
  tick();
  function hide(){
    if(ready)return; ready=true; clearTimeout(t);
    var l=document.getElementById('cv-page-loader');
    if(l){ l.classList.add('cv-ld-out'); setTimeout(function(){ l.style.display='none'; },420); }
  }
  if(document.readyState==='complete'){ hide(); }
  else{ window.addEventListener('load', hide); }
  setTimeout(hide, 6000);
})();
</script>
<!-- END TROVATECH LOADER -->
<?php wp_body_open(); ?>

<style>
/* ═══════════════════════════════════════════════════
   TOP BAR
═══════════════════════════════════════════════════ */
.topbar {
  display: flex; align-items: center; justify-content: space-between;
  gap: 12px; padding: 7px 48px; font-size: 0.78rem; flex-wrap: wrap;
}
.topbar-left { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }
.topbar-left span { display: flex; align-items: center; gap: 5px; white-space: nowrap; }
.topbar-left svg { flex-shrink: 0; }
.topbar-right { display: flex; align-items: center; gap: 8px; }
.soc {
  width: 26px; height: 26px; border-radius: 50%;
  display: inline-flex; align-items: center; justify-content: center;
  transition: opacity .2s;
}
.soc:hover { opacity: .7; }

/* ═══════════════════════════════════════════════════
   LOGO
═══════════════════════════════════════════════════ */
@keyframes logo-fade-in {
  from { opacity:0; transform:scale(0.92) translateY(-4px); }
  to   { opacity:1; transform:scale(1) translateY(0); }
}
@keyframes logo-shimmer {
  0%  { box-shadow: 0 0 0 0   rgba(46,175,110,0.0), 0 2px 8px rgba(0,0,0,.10); }
  50% { box-shadow: 0 0 0 3px rgba(46,175,110,0.28),0 4px 14px rgba(46,175,110,.18); }
  100%{ box-shadow: 0 0 0 0   rgba(46,175,110,0.0), 0 2px 8px rgba(0,0,0,.10); }
}
.logo-link {
  display: inline-flex; align-items: center; text-decoration: none !important;
  flex-shrink: 0; animation: logo-fade-in .55s cubic-bezier(.34,1.56,.64,1) both;
}
.logo-img-wrap {
  display: flex; align-items: center; justify-content: center;
  border: 2px solid #2eaf6e; border-radius: 5px; overflow: hidden; padding: 0;
  box-shadow: 0 2px 8px rgba(0,0,0,.10); animation: logo-shimmer 2.4s ease .6s 2;
  transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease, border-color .2s ease;
  width: clamp(150px,16vw,210px); height: clamp(52px,7vw,72px);
}
.logo-link:hover .logo-img-wrap { transform:scale(1.05) translateY(-1px); box-shadow:0 6px 20px rgba(46,175,110,.35); border-color:#22994f; }
.logo-link:active .logo-img-wrap { transform:scale(0.96); box-shadow:0 2px 6px rgba(46,175,110,.2); }
.logo-img-wrap img { width:100%; height:100%; object-fit:contain; object-position:center; display:block; transition:transform .3s ease; }
.logo-link:hover .logo-img-wrap img { transform:scale(1.04); }
@media (max-width:960px){ .logo-img-wrap{ width:clamp(130px,18vw,180px); height:clamp(46px,7vw,64px); } }
@media (max-width:640px){ .logo-img-wrap{ width:clamp(140px,44vw,185px); height:clamp(48px,15vw,64px); } }
@media (max-width:380px){ .logo-img-wrap{ width:clamp(125px,46vw,160px); height:clamp(44px,16vw,58px); } }

/* ═══════════════════════════════════════════════════
   HEADER MAIN
═══════════════════════════════════════════════════ */
.header-main { display:flex; align-items:center; gap:20px; padding:12px 48px; flex-wrap:wrap; }
.search-wrap { display:flex; flex:1 1 380px; min-width:0; border-radius:50px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.08); }
.hdr-actions { display:flex; align-items:center; gap:14px; flex-shrink:0; }
.hdr-delivery { display:flex; flex-direction:column; font-size:.75rem; line-height:1.3; }
.hdr-action { display:flex; align-items:center; gap:6px; text-decoration:none; flex-shrink:0; }
.cart-total { font-size:clamp(.62rem,1.8vw,.9rem); font-weight:700; white-space:nowrap; }
.act-badge {
  position:absolute; top:-6px; right:-6px; min-width:18px; height:18px; border-radius:50%;
  font-size:.65rem; font-weight:800; display:flex; align-items:center; justify-content:center;
  padding:0 3px; background:var(--green,#2eaf6e); color:#fff; line-height:1;
}
.hdr-wishlist { display:flex; align-items:center; gap:6px; text-decoration:none; flex-shrink:0; position:relative; cursor:pointer; }
.hdr-wishlist svg { transition:transform .2s, color .2s; }
.hdr-wishlist:hover svg { transform:scale(1.15); color:#e53935; }
.wishlist-badge {
  position:absolute; top:-6px; right:-6px; min-width:18px; height:18px; border-radius:50%;
  font-size:.65rem; font-weight:800; display:none; align-items:center; justify-content:center;
  padding:0 3px; background:#e53935; color:#fff; line-height:1;
}
.wishlist-badge.has-items { display:flex; }
@media (max-width:960px){ .hdr-wishlist svg,.hdr-action svg{ width:20px; height:20px; } .cart-total{ font-size:clamp(.62rem,1.6vw,.82rem); } }
@media (max-width:640px){ .hdr-wishlist svg,.hdr-action svg{ width:22px; height:22px; } .cart-total{ font-size:clamp(.6rem,3.5vw,.78rem); } }
@media (max-width:380px){ .cart-total{ font-size:clamp(.58rem,3vw,.7rem); } .hdr-action svg,.hdr-wishlist svg{ width:20px; height:20px; } }

/* ═══════════════════════════════════════════════════
   NAVBAR
═══════════════════════════════════════════════════ */
.navbar { display:flex; align-items:center; gap:4px; padding:0 48px; flex-wrap:wrap; position:relative; }
.navbar ul { display:flex; align-items:center; gap:2px; list-style:none; margin:0; padding:0; flex-wrap:wrap; }
.hamburger {
  display:none; flex-direction:column; justify-content:center; align-items:center; gap:5px;
  width:44px; height:44px; padding:10px; border:2px solid rgba(0,0,0,.12); background:#fff;
  cursor:pointer; border-radius:10px; flex-shrink:0; transition:background .2s,border-color .2s; z-index:999;
}
.hamburger:hover{ background:#f4f4f4; border-color:rgba(0,0,0,.2); }
.hamburger span{ display:block; width:20px; height:2px; border-radius:2px; background:#1a3c2e; transition:transform .3s,opacity .3s; flex-shrink:0; }
.hamburger.open span:nth-child(1){ transform:translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2){ opacity:0; transform:scaleX(0); }
.hamburger.open span:nth-child(3){ transform:translateY(-7px) rotate(-45deg); }
@media (max-width:960px){
  .topbar{ padding:6px 20px; }
  .header-main{ padding:10px 20px; gap:12px; }
  .navbar{ padding:0 20px; }
  .hdr-delivery{ display:none; }
  .search-wrap{ flex:1 1 240px; }
}
@media (max-width:640px){
  .topbar{ display:none !important; }
  header{ display:flex; flex-direction:column; }
  .header-main{ display:flex; flex-direction:row; align-items:center; justify-content:space-between; padding:10px 16px; flex-wrap:nowrap; gap:8px; width:100%; box-sizing:border-box; }
  .search-wrap,.hdr-delivery{ display:none !important; }
  .hdr-actions{ gap:8px; display:flex; align-items:center; }
  .hdr-action{ display:flex !important; }
  .cart-total{ display:inline !important; }
  .hamburger{ display:none !important; }
  .mobile-menu-bar .hamburger{ display:flex !important; width:36px; height:36px; padding:8px; border-radius:8px; }
  .mobile-menu-bar .hamburger span{ width:16px; height:2px; }
  .mobile-menu-bar{ display:flex !important; align-items:center; justify-content:space-between; padding:6px 16px; border-top:1px solid rgba(0,0,0,.07); gap:10px; width:100%; box-sizing:border-box; }
  .mobile-menu-bar .mob-bar-label{ font-size:.8rem; font-weight:600; opacity:.6; }
  .navbar{ display:none !important; }
}
@media (max-width:380px){ .header-main{ padding:8px 12px; } .mobile-menu-bar{ padding:7px 12px; } }
.mobile-menu-bar{ display:none; }

/* ═══════════════════════════════════════════════════
   CATEGORY DROPDOWN
═══════════════════════════════════════════════════ */
.cat-dropdown-wrap{ position:relative; flex-shrink:0; }
.nav-cat-btn{ display:inline-flex; align-items:center; gap:8px; padding:9px 18px; border:none; border-radius:6px; font-size:.9rem; font-weight:600; cursor:pointer; white-space:nowrap; background:var(--green,#2eaf6e); color:#fff; transition:opacity .18s; user-select:none; }
.nav-cat-btn:hover{ opacity:.88; }
.nav-cat-btn svg{ flex-shrink:0; }
.nav-cat-btn .cat-chevron{ margin-left:2px; transition:transform .25s; flex-shrink:0; }
.cat-dropdown-wrap:hover .cat-chevron,.cat-dropdown-wrap.open .cat-chevron{ transform:rotate(180deg); }
.cat-dropdown{ display:none; position:absolute; top:calc(100% + 6px); left:0; min-width:240px; border-radius:10px; overflow:hidden; z-index:9999; background:#fff; border:1px solid #e8e8e8; box-shadow:0 10px 36px rgba(0,0,0,.13),0 2px 8px rgba(0,0,0,.07); animation:catFadeIn .18s ease both; max-height:340px; overflow-y:auto; overflow-x:hidden; scrollbar-width:thin; scrollbar-color:#2eaf6e #f0f0f0; }
.cat-dropdown::-webkit-scrollbar{ width:4px; }
.cat-dropdown::-webkit-scrollbar-track{ background:#f0f0f0; }
.cat-dropdown::-webkit-scrollbar-thumb{ background:#2eaf6e; border-radius:2px; }
@keyframes catFadeIn{ from{opacity:0;transform:translateY(-6px);}to{opacity:1;transform:translateY(0);} }
.cat-dropdown-wrap:hover .cat-dropdown,.cat-dropdown-wrap.open .cat-dropdown{ display:block; }
.cat-dropdown a{ display:flex; align-items:center; gap:10px; padding:11px 16px; font-size:.88rem; font-weight:500; text-decoration:none; color:#1a3c2e; background:#fff; border-bottom:1px solid #f0f0f0; transition:background .15s,padding-left .15s,color .15s; }
.cat-dropdown a:last-child{ border-bottom:none; }
.cat-dropdown a:hover{ background:#f4fdf7; padding-left:22px; color:#2eaf6e; }
.cat-dropdown a:hover svg{ opacity:1; color:#2eaf6e; }
.cat-dropdown a svg{ flex-shrink:0; opacity:.45; transition:opacity .15s; }
@media (min-width:641px){ .hamburger,.mobile-menu-bar,.mobile-nav-drawer{ display:none !important; } }
.nav-contact-btn{ display:inline-flex; align-items:center; gap:6px; padding:8px 18px; border-radius:50px; font-size:.85rem; font-weight:600; text-decoration:none; white-space:nowrap; background:var(--green,#2eaf6e); color:#fff !important; border:none; cursor:pointer; transition:opacity .2s,transform .15s; margin-left:6px; }
.nav-contact-btn:hover{ opacity:.88; transform:translateY(-1px); }
.nav-contact-btn svg{ flex-shrink:0; }
.mobile-nav-drawer .nav-contact-btn{ display:flex; justify-content:center; border-radius:12px; padding:13px 16px; font-size:.95rem; margin:6px 0 2px; margin-left:0; }
.mobile-nav-drawer{ display:none; flex-direction:column; padding:8px 12px 16px; gap:2px; border-top:1px solid rgba(0,0,0,.07); }
.mobile-nav-drawer.open{ display:flex !important; }
.mobile-nav-drawer a{ display:block; padding:12px 16px; border-radius:10px; font-size:.95rem; font-weight:500; text-decoration:none; transition:background .15s; color:inherit; }
.mobile-nav-drawer a:hover{ background:rgba(0,0,0,.04); }
</style>

<!-- TOP BAR -->
<div class="topbar">
  <div class="topbar-left">
    <span>
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
      <a href="tel:+WHATSAPP_NUMBER_HERE" style="text-decoration:none;color:inherit">+254 790 007616</a>
    </span>
    <span class="email-info">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      <?php echo esc_html(trovatech_email()); ?>
    </span>
    <span class="address-info">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
      <?php echo esc_html(trovatech_address()); ?> &mdash; Mon-Fri: 8am-6pm | Sat: 8:30am-1:00pm | Sun &amp; Holidays: closed.
    </span>
  </div>
  <div class="topbar-right">
    <a href="<?php echo esc_url(get_option('trovatech_facebook','#')); ?>" class="soc" target="_blank" aria-label="Facebook">
      <svg viewBox="0 0 24 24" fill="currentColor" width="13" height="13"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
    </a>
    <a href="<?php echo esc_url(get_option('trovatech_instagram','#')); ?>" class="soc" target="_blank" aria-label="Instagram">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
    </a>
    <a href="<?php echo esc_url(get_option('trovatech_twitter','#')); ?>" class="soc" target="_blank" aria-label="X">
      <svg viewBox="0 0 24 24" fill="currentColor" width="13" height="13"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
    </a>
    <a href="https://wa.me/WHATSAPP_NUMBER_HERE" class="soc" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
      <svg viewBox="0 0 24 24" fill="currentColor" width="13" height="13"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
  </div>
</div>

<!-- HEADER -->
<header>
  <div class="header-main">

    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link" aria-label="Trovatech Agencies — Go to homepage">
      <div class="logo-img-wrap">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/Trovatech_Logo.png'); ?>"
             alt="Trovatech Agencies" width="130" height="54" loading="eager" decoding="async"/>
      </div>
    </a>

    <form class="search-wrap" role="search" method="get" action="<?php echo home_url('/'); ?>">
      <select class="search-cat" name="product_cat">
        <option value="">All categories</option>
        <?php
        $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>false,'parent'=>0]);
        if (!empty($cats) && !is_wp_error($cats)):
          foreach ($cats as $c): ?>
            <option value="<?php echo esc_attr($c->slug); ?>"><?php echo esc_html($c->name); ?></option>
        <?php endforeach; endif; ?>
      </select>
      <input class="search-input" type="search" name="s" placeholder="Search medicines, brands, symptoms..." value="<?php echo get_search_query(); ?>">
      <input type="hidden" name="post_type" value="product">
      <button type="submit" class="search-btn">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Search
      </button>
    </form>

    <div class="hdr-actions">
      <div class="hdr-delivery"><strong>Delivery</strong>Nairobi &amp; Kenya</div>

      <?php
      $wishlist_url   = function_exists('YITH_WCWL') ? YITH_WCWL()->get_wishlist_url() : home_url('/wishlist');
      $wishlist_count = function_exists('yith_wcwl_count_products_in_wishlist') ? yith_wcwl_count_products_in_wishlist() : 0;
      ?>
      <a href="<?php echo esc_url($wishlist_url); ?>" class="hdr-wishlist" aria-label="Wishlist">
        <div style="position:relative">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
          <div class="wishlist-badge <?php echo $wishlist_count > 0 ? 'has-items' : ''; ?>">
            <?php echo $wishlist_count > 0 ? $wishlist_count : ''; ?>
          </div>
        </div>
      </a>

      <?php if (function_exists('WC')): ?>
      <a href="<?php echo wc_get_cart_url(); ?>" class="hdr-action">
        <div style="position:relative">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
          <?php $count = WC()->cart->get_cart_contents_count(); if ($count > 0): ?>
            <div class="act-badge"><?php echo $count; ?></div>
          <?php endif; ?>
        </div>
        <span class="cart-total"><?php echo WC()->cart->get_cart_total(); ?></span>
      </a>
      <?php endif; ?>
    </div>

  </div>

  <div class="mobile-menu-bar">
    <span class="mob-bar-label">Menu</span>
    <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>

  <nav class="navbar">
    <div class="cat-dropdown-wrap" id="catDropWrap">
      <button class="nav-cat-btn" type="button" aria-haspopup="true" aria-expanded="false" id="catDropBtn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        Shop by category
        <svg class="cat-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
      </button>
      <div class="cat-dropdown" id="catDropPanel">
        <?php
        $all_cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>false,'orderby'=>'name','order'=>'ASC']);
        if (!empty($all_cats) && !is_wp_error($all_cats)):
          foreach ($all_cats as $cat): $cat_url = get_term_link($cat); ?>
            <a href="<?php echo esc_url($cat_url); ?>">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
              <?php echo esc_html($cat->name); ?>
              <?php if ($cat->count > 0): ?><span style="margin-left:auto;font-size:.72rem;opacity:.4;"><?php echo $cat->count; ?></span><?php endif; ?>
            </a>
        <?php endforeach;
        else: ?>
          <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
            All Products
          </a>
        <?php endif; ?>
      </div>
    </div>

    <?php
    $shop_url  = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop');
    $nav_links = [
      [home_url('/'),                    'Home',                is_front_page()],
      [$shop_url,                        'Shop',                is_shop()],
      [home_url('/submit-prescription'), 'Submit Prescription', is_page('submit-prescription')],
      [home_url('/about-us'),            'About Us',            is_page('about-us')],
    ];
    ?>
    <ul>
      <?php foreach ($nav_links as [$href, $label, $active]): ?>
        <li><a href="<?php echo esc_url($href); ?>"<?php echo $active ? ' class="active"' : ''; ?>><?php echo esc_html($label); ?></a></li>
      <?php endforeach; ?>
    </ul>

    <a href="<?php echo esc_url(home_url('/refund')); ?>" class="nav-right">Return and Refund Policy</a>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="nav-contact-btn">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
      Contact Us
    </a>
  </nav>

  <div class="mobile-nav-drawer" id="mobileDrawer">
    <?php
    $mob_links = [
      [home_url('/'),                    'Home'],
      [function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop'), 'Shop'],
      [home_url('/submit-prescription'), 'Submit Prescription'],
      [home_url('/about-us'),            'About Us'],
      [home_url('/refund'),              'Return &amp; Refund Policy'],
    ];
    foreach ($mob_links as [$href, $label]):
    ?>
      <a href="<?php echo esc_url($href); ?>"><?php echo $label; ?></a>
    <?php endforeach; ?>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="nav-contact-btn">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
      Contact Us
    </a>
  </div>

</header>

<script>
(function(){
  var btn=document.getElementById('hamburgerBtn'), drawer=document.getElementById('mobileDrawer');
  if(btn&&drawer){
    btn.addEventListener('click',function(){ var o=drawer.classList.toggle('open'); btn.classList.toggle('open',o); btn.setAttribute('aria-expanded',o); });
    drawer.querySelectorAll('a').forEach(function(a){ a.addEventListener('click',function(){ drawer.classList.remove('open'); btn.classList.remove('open'); btn.setAttribute('aria-expanded',false); }); });
  }
  var cw=document.getElementById('catDropWrap'), cb=document.getElementById('catDropBtn');
  if(cw&&cb){
    cb.addEventListener('click',function(e){ e.stopPropagation(); var o=cw.classList.toggle('open'); cb.setAttribute('aria-expanded',o); });
    document.addEventListener('click',function(e){ if(!cw.contains(e.target)){ cw.classList.remove('open'); cb.setAttribute('aria-expanded',false); } });
    cw.querySelectorAll('.cat-dropdown a').forEach(function(a){ a.addEventListener('click',function(){ cw.classList.remove('open'); cb.setAttribute('aria-expanded',false); }); });
  }
})();
</script>

<?php if (!is_front_page()): ?>
<div class="site-breadcrumb">
  <a href="<?php echo home_url('/'); ?>">Home</a>
  <?php if (is_shop()): ?>
    <span>&#8250;</span><span>Shop</span>
  <?php elseif (is_singular('product')): ?>
    <span>&#8250;</span>
    <?php if (function_exists('wc_get_page_id')): ?><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a><?php endif; ?>
    <span>&#8250;</span><span><?php the_title(); ?></span>
  <?php elseif (is_product_category()): ?>
    <span>&#8250;</span>
    <?php if (function_exists('wc_get_page_id')): ?><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a><?php endif; ?>
    <span>&#8250;</span><span><?php single_cat_title(); ?></span>
  <?php elseif (is_page()): ?>
    <span>&#8250;</span><span><?php the_title(); ?></span>
  <?php endif; ?>
</div>
<?php endif; ?>
