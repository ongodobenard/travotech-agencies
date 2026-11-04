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
   TRAVOTECH PAGE LOADER
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- ═══════════════════════════════════
     TRAVOTECH PAGE LOADER
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

  <div class="cv-ld-name" aria-label="Travotech Agencies">
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
  var FULL = 'TRAVOTECH AGENCIES';
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
<!-- END TRAVOTECH LOADER -->
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

/* ---- Header update: Kenya flag, Font Awesome icons, responsive menu ---- */
.ke-flag{display:inline-block;flex:0 0 auto;width:26px;height:17px;border-radius:2px;position:relative;vertical-align:middle;box-shadow:0 0 0 1px rgba(0,0,0,.18);background:linear-gradient(to bottom,#000 0 30%,#fff 30% 36%,#BB0000 36% 64%,#fff 64% 70%,#006600 70% 100%);}
.ke-flag::after{content:"";position:absolute;left:50%;top:50%;width:7px;height:11px;transform:translate(-50%,-50%);border-radius:50%;background:radial-gradient(ellipse at center,#fff 0 22%,#BB0000 24% 60%,#000 62% 100%);}
.topbar-left i{width:14px;text-align:center;font-size:.8rem;line-height:1;}
.topbar .soc{background:#fff !important;}
.topbar .soc i{font-size:.8rem;line-height:1;}
.topbar .soc[aria-label="Facebook"]{color:#1877F2 !important;}
.topbar .soc[aria-label="X"]{color:#000 !important;}
.topbar .soc[aria-label="WhatsApp"]{color:#25D366 !important;}
.topbar .soc[aria-label="Instagram"] i{background:linear-gradient(45deg,#FEDA75 0%,#FA7E1E 30%,#D62976 55%,#962FBF 80%,#4F5BD5 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;}
.hdr-delivery{flex-direction:row;align-items:center;gap:8px;}
.hdr-delivery>span:last-child{display:flex;flex-direction:column;}
.hdr-wishlist i,.hdr-action i{font-size:1.3rem;line-height:1;transition:transform .2s,color .2s;}
.hdr-wishlist:hover i{transform:scale(1.15);color:#e53935;}
.search-btn i{margin-right:4px;font-size:.85rem;}
.nav-cat-btn i{font-size:.9rem;line-height:1;}
.nav-cat-btn .cat-chevron{font-size:.75rem;margin-left:2px;transition:transform .25s;}
.cat-dropdown a i{width:14px;text-align:center;font-size:.8rem;opacity:.45;transition:opacity .15s,color .15s;}
.cat-dropdown a:hover i{opacity:1;color:#2eaf6e;}
.nav-contact-btn i{font-size:.85rem;}
.navbar ul{gap:0;}
.mob-bar-label{display:flex;align-items:center;gap:8px;}
header .mobile-menu-bar .mob-bar-label{opacity:1;}
@media (max-width:1180px){
  header .navbar{display:none !important;}
  header .mobile-menu-bar{display:flex !important;align-items:center;justify-content:space-between;padding:6px 20px;border-top:1px solid rgba(0,0,0,.07);width:100%;box-sizing:border-box;}
  header .mobile-menu-bar .hamburger{display:flex !important;width:38px;height:38px;padding:8px;border-radius:8px;}
  header .mobile-menu-bar .hamburger span{width:16px;}
  header .mobile-nav-drawer.open{display:flex !important;}
  header .mobile-nav-drawer a.active{color:#2eaf6e;font-weight:700;}
}
@media (max-width:900px){
  .topbar{justify-content:center;}
  .topbar .topbar-right{display:none;}
}

/* ---- Header order update ---- */
.navbar .cat-dropdown-wrap{margin:0 6px;}
.mobile-nav-drawer details.mob-cats{border-radius:10px;overflow:hidden;}
.mobile-nav-drawer details.mob-cats summary{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:10px;font-size:.95rem;font-weight:600;cursor:pointer;list-style:none;background:#2eaf6e;color:#fff;}
.mobile-nav-drawer details.mob-cats summary::-webkit-details-marker{display:none;}
.mobile-nav-drawer details.mob-cats summary .fa-chevron-down{margin-left:auto;font-size:.75rem;transition:transform .2s;}
.mobile-nav-drawer details.mob-cats[open] summary .fa-chevron-down{transform:rotate(180deg);}
.mobile-nav-drawer details.mob-cats[open]{background:#f4fdf7;}
.mobile-nav-drawer details.mob-cats a{padding:10px 16px 10px 30px;font-size:.9rem;}

/* ---- Alignment fixes ---- */
.header-main{align-items:center;}
.hdr-actions{align-items:center;gap:18px;}
.hdr-delivery{align-items:center;text-align:left;line-height:1.25;}
.hdr-delivery strong{display:block;}
.hdr-wishlist,.hdr-action{display:flex;flex-direction:row;align-items:center;gap:8px;height:44px;}
.hdr-wishlist>div,.hdr-action>div{position:relative;display:flex;align-items:center;justify-content:center;width:28px;height:28px;}
.hdr-wishlist i,.hdr-action i{display:block;line-height:1;}
.cart-total{display:block;line-height:1;}
.navbar{align-items:center;gap:6px;padding-top:6px;padding-bottom:6px;}
.navbar ul{align-items:center;}
.navbar ul li a{display:flex;align-items:center;height:44px;padding:0 14px;box-sizing:border-box;}
.navbar .cat-dropdown-wrap{display:flex;align-items:center;margin:0 8px 0 0;}
.navbar .nav-cat-btn{height:44px;}
.navbar .nav-contact-btn{margin-left:auto;height:44px;box-sizing:border-box;}
@media (max-width:1180px){
  .hdr-actions{gap:14px;}
}
</style>

<!-- TOP BAR -->
<div class="topbar">
  <div class="topbar-left">
    <span>
      <i class="fa-solid fa-phone" aria-hidden="true"></i>
      <a href="tel:+254720737151" style="text-decoration:none;color:inherit">+254 720 737 151</a>
    </span>
    <span class="email-info">
      <i class="fa-solid fa-envelope" aria-hidden="true"></i>
      <?php echo esc_html(travotech_email()); ?>
    </span>
    <span class="address-info">
      <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
      <span class="ke-flag" role="img" aria-label="Kenya flag"></span> <?php echo esc_html(travotech_address()); ?> &mdash; Mon-Fri: 8am-6pm | Sat: 8:30am-1:00pm | Sun &amp; Holidays: closed.
    </span>
  </div>
  <div class="topbar-right">
    <a href="<?php echo esc_url(get_option('travotech_facebook','#')); ?>" class="soc" target="_blank" aria-label="Facebook">
      <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
    </a>
    <a href="<?php echo esc_url(get_option('travotech_instagram','#')); ?>" class="soc" target="_blank" aria-label="Instagram">
      <i class="fa-brands fa-instagram" aria-hidden="true"></i>
    </a>
    <a href="<?php echo esc_url(get_option('travotech_twitter','#')); ?>" class="soc" target="_blank" aria-label="X">
      <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
    </a>
    <a href="https://wa.me/254720737151" class="soc" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
      <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
    </a>
  </div>
</div>

<!-- HEADER -->
<header>
  <div class="header-main">

    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link" aria-label="Travotech Agencies — Go to homepage">
      <div class="logo-img-wrap">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/travotechlogo.png'); ?>"
             alt="Travotech Agencies" width="130" height="54" loading="eager" decoding="async"/>
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
      <input class="search-input" type="search" name="s" placeholder="Search lab and hospital equipment..." value="<?php echo get_search_query(); ?>">
      <input type="hidden" name="post_type" value="product">
      <button type="submit" class="search-btn">
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        Search
      </button>
    </form>

    <div class="hdr-actions">
      <div class="hdr-delivery"><span class="ke-flag" role="img" aria-label="Kenya flag"></span><span><strong>Delivery</strong>Nairobi &amp; Kenya</span></div>

      <?php
      $wishlist_url   = function_exists('YITH_WCWL') ? YITH_WCWL()->get_wishlist_url() : home_url('/wishlist');
      $wishlist_count = function_exists('yith_wcwl_count_products_in_wishlist') ? yith_wcwl_count_products_in_wishlist() : 0;
      ?>
      <a href="<?php echo esc_url($wishlist_url); ?>" class="hdr-wishlist" aria-label="Wishlist">
        <div style="position:relative">
          <i class="fa-regular fa-heart" aria-hidden="true"></i>
          <div class="wishlist-badge <?php echo $wishlist_count > 0 ? 'has-items' : ''; ?>">
            <?php echo $wishlist_count > 0 ? $wishlist_count : ''; ?>
          </div>
        </div>
      </a>

      <?php if (function_exists('WC')): ?>
      <a href="<?php echo wc_get_cart_url(); ?>" class="hdr-action">
        <div style="position:relative">
          <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
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
    <span class="mob-bar-label"><span class="ke-flag" role="img" aria-label="Kenya flag"></span>Menu</span>
    <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>

  <nav class="navbar">
    

    <?php
    $shop_url  = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop');
    $trv_pg = function ( array $slugs, $fallback ) {
      foreach ( $slugs as $s ) { $p = get_page_by_path( $s ); if ( $p ) { return get_permalink( $p ); } }
      return home_url( $fallback );
    };
    $s_proj  = array( 'projects', 'our-projects' );
    $s_about = array( 'about-us', 'about' );
    $s_ret   = array( 'return-and-refund-policy', 'return-policy', 'refund-policy', 'refund', 'returns' );
    $s_terms = array( 'terms-and-conditions', 'terms', 'terms-conditions' );
    $nav_links = [
      [home_url('/'),                         'Home',                     is_front_page()],
      [$shop_url,                             'Shop',           function_exists('is_shop') && is_shop()],
      [$trv_pg($s_about, '/about-us/'),       'About Us',                 is_page($s_about)],
      [$trv_pg($s_proj,  '/projects/'),       'Projects',                 is_page($s_proj)],
      [$trv_pg($s_ret,   '/refund/'),         'Return & Refund Policy',   is_page($s_ret)],
    ];
    ?>
    <div class="cat-dropdown-wrap" id="catDropWrap">
      <button class="nav-cat-btn" type="button" aria-haspopup="true" aria-expanded="false" id="catDropBtn">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
        Shop by category
        <i class="fa-solid fa-chevron-down cat-chevron" aria-hidden="true"></i>
      </button>
      <div class="cat-dropdown" id="catDropPanel">
        <?php
        $all_cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>false,'orderby'=>'name','order'=>'ASC']);
        if (!empty($all_cats) && !is_wp_error($all_cats)):
          foreach ($all_cats as $cat): $cat_url = get_term_link($cat); ?>
            <a href="<?php echo esc_url($cat_url); ?>">
              <i class="fa-solid fa-tag" aria-hidden="true"></i>
              <?php echo esc_html($cat->name); ?>
              <?php if ($cat->count > 0): ?><span style="margin-left:auto;font-size:.72rem;opacity:.4;"><?php echo $cat->count; ?></span><?php endif; ?>
            </a>
        <?php endforeach;
        else: ?>
          <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">
            <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
            All Products
          </a>
        <?php endif; ?>
      </div>
    </div>

    <ul>
      <?php foreach ( $nav_links as [ $href, $label, $active ] ): ?>
        <li><a href="<?php echo esc_url( $href ); ?>"<?php echo $active ? ' class="active"' : ''; ?>><?php echo esc_html( $label ); ?></a></li>
      <?php endforeach; ?>
    </ul>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="nav-contact-btn">
      <i class="fa-solid fa-phone" aria-hidden="true"></i>
      Contact Us
    </a>
  </nav>

  <div class="mobile-nav-drawer" id="mobileDrawer">
    <details class="mob-cats">
      <summary><i class="fa-solid fa-bars" aria-hidden="true"></i> Shop By Category <i class="fa-solid fa-chevron-down" aria-hidden="true"></i></summary>
      <?php if ( ! empty( $all_cats ) && ! is_wp_error( $all_cats ) ) : foreach ( $all_cats as $mc ) : ?>
        <a href="<?php echo esc_url( get_term_link( $mc ) ); ?>"><?php echo esc_html( $mc->name ); ?></a>
      <?php endforeach; endif; ?>
    </details>
    <?php foreach ( $nav_links as [ $href, $label, $active ] ): ?>
      <a href="<?php echo esc_url( $href ); ?>"<?php echo $active ? ' class="active"' : ''; ?>><?php echo esc_html( $label ); ?></a>
    <?php endforeach; ?>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="nav-contact-btn">
      <i class="fa-solid fa-phone" aria-hidden="true"></i>
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
