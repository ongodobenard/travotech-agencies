<?php
/**
 * Checkout Page Template — Slug: checkout
 * Updated: April 2026
 *
 * CHANGES:
 * - Silent AJAX cart reset (WC session + fragment refresh) after successful Place Order
 * - 2 fields per row grid, fully responsive (single col on mobile) — NO full-width exceptions
 * - No emojis — Dashicons only throughout
 * - Success message shows customer email confirmation was sent
 * - Cart count in header updated to 0 after successful order
 * - Steps bar advances to Confirmation immediately on success
 * - All AJAX handlers remain in functions.php
 */

/* ════════════════════════════════════════════════════════════
   SUPPRESS ALL WOOCOMMERCE NOTICES ON CHECKOUT PAGE
════════════════════════════════════════════════════════════ */
add_action( 'template_redirect', function () {
    if ( function_exists( 'wc_clear_notices' ) ) wc_clear_notices();
}, 1 );

add_action( 'template_redirect', function () {
    remove_all_actions( 'woocommerce_before_checkout_form' );
    add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
    add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}, 5 );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
add_action( 'wp', function () {
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
    remove_action( 'woocommerce_before_cart',          'woocommerce_output_all_notices', 10 );
    remove_action( 'woocommerce_before_shop_loop',     'woocommerce_output_all_notices', 10 );
} );

add_filter( 'woocommerce_add_message', '__return_empty_string' );
add_filter( 'woocommerce_add_notice',  '__return_empty_string' );

add_action( 'wp_loaded', function () {
    if ( function_exists( 'wc_clear_notices' ) ) wc_clear_notices();
}, 1 );

get_header();
wp_enqueue_style( 'dashicons' );
?>
<style>
/* ════════════════════════════════════════════════════════
   NUCLEAR NOTICE HIDE
════════════════════════════════════════════════════════ */
.woocommerce-notices-wrapper,.woocommerce-notices-wrapper *,.woocommerce-message,.woocommerce-info,.woocommerce-error,.wc-forward,ul.woocommerce-error,ul.woocommerce-message,ul.woocommerce-info,.woocommerce-NoticeGroup,.woocommerce-NoticeGroup-checkout,.woocommerce-NoticeGroup-updateOrderReview,.woocommerce>.woocommerce-message,.woocommerce>.woocommerce-info,.woocommerce>.woocommerce-error,body .woocommerce-message,body .woocommerce-info,div.woocommerce>.woocommerce-notices-wrapper,.chkp-wrap .woocommerce-notices-wrapper,.chkp-wrap .woocommerce-message,.chkp-wrap .woocommerce-info,.chkp-wrap ul.woocommerce-error,.chkp-wrap .woocommerce-NoticeGroup,.chkp-wrap .woocommerce-NoticeGroup-checkout{display:none!important;visibility:hidden!important;height:0!important;overflow:hidden!important;margin:0!important;padding:0!important;border:none!important;opacity:0!important;pointer-events:none!important;}

/* ── BANNER ── */
.chkp-banner{background:#22adb0;padding:clamp(18px,3vw,36px) 5%;position:relative;overflow:hidden;}
.chkp-banner::before{content:'';position:absolute;inset:0;background:rgba(255,255,255,.07);}
.chkp-banner-inner{position:relative;z-index:1;max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
.chkp-banner h1{font-family:var(--th-fh,'Oswald',sans-serif);font-size:clamp(1.2rem,2.5vw,1.9rem);font-weight:700;color:#fff;margin:0;display:flex;align-items:center;gap:8px;}
.chkp-breadcrumb{font-size:.75rem;color:rgba(255,255,255,.75);font-weight:600;}
.chkp-breadcrumb a{color:#fff;text-decoration:underline;}

/* ── STEPS ── */
.chkp-steps{background:#fff;border-bottom:2px solid #e5fbfb;padding:10px 5%;}
.chkp-steps-inner{max-width:1200px;margin:0 auto;display:flex;align-items:center;}
.chkp-step{display:flex;align-items:center;gap:5px;font-size:.72rem;font-weight:700;font-family:'Inter',system-ui,sans-serif;color:#5bd9d7;white-space:nowrap;}
.chkp-step.active{color:#22adb0;}.chkp-step.done{color:#22adb0;}
.chkp-step-num{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.6rem;font-weight:900;flex-shrink:0;background:#e5fbfb;color:#5bd9d7;}
.chkp-step.active .chkp-step-num{background:#22adb0;color:#fff;}
.chkp-step.done .chkp-step-num{background:#22adb0;color:#fff;}
.chkp-step-line{flex:1;height:2px;background:#e5fbfb;margin:0 6px;min-width:10px;}
.chkp-step-line.done{background:#22adb0;}
.chkp-step-lbl{display:inline;}

/* ── LAYOUT ── */
.chkp-wrap{background:#eefcfc;padding:clamp(14px,2.5vw,36px) 5%;min-height:60vh;}
.chkp-layout{display:grid;grid-template-columns:1fr 300px;gap:18px;max-width:1200px;margin:0 auto;align-items:start;}

/* ── CARDS ── */
.chkp-card{background:#fff;border-radius:12px;border:1.5px solid #b0f4f3;box-shadow:0 3px 16px rgba(34,173,176,.07);overflow:hidden;margin-bottom:14px;}
.chkp-card:last-child{margin-bottom:0;}
.chkp-card-head{padding:11px 16px;border-bottom:2px solid #e5fbfb;display:flex;align-items:center;gap:7px;background:#f9fefe;}
.chkp-card-head .dashicons{color:#22adb0;font-size:15px;width:15px;height:15px;}
.chkp-card-head h3{font-family:'Inter',system-ui,sans-serif;font-size:.85rem;font-weight:800;color:#103837;margin:0;}
.chkp-card-body{padding:clamp(10px,2vw,18px);}

/* ════════════════════════════════════════════════
   FORM GRID — strict 2 fields per row, no exceptions
════════════════════════════════════════════════ */
.chkp-grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:12px 14px;
}
/* Remove span2 behaviour — nothing spans full width */
.chkp-grid .span2{grid-column:unset;}

.chkp-fg{display:flex;flex-direction:column;gap:4px;}
.chkp-fg label{font-family:'Inter',system-ui,sans-serif;font-size:.76rem;font-weight:700;color:#22adb0;line-height:1.3;}
.chkp-fg label .req{color:#e53935;}
.chkp-fg label .opt{color:#5bd9d7;font-weight:500;}
.chkp-fg input,.chkp-fg select,.chkp-fg textarea{
  width:100%;box-sizing:border-box;
  padding:9px 12px;
  border:2px solid #b0f4f3;
  border-radius:8px;
  font-family:'Inter',system-ui,sans-serif;
  font-size:.83rem;color:#103837;
  background:#fff;outline:none;
  -webkit-appearance:none;appearance:none;
  transition:border-color .2s,box-shadow .2s;
}
.chkp-fg input:focus,.chkp-fg select:focus,.chkp-fg textarea:focus{border-color:#22adb0;box-shadow:0 0 0 3px rgba(34,173,176,.1);}
.chkp-fg input.error,.chkp-fg select.error,.chkp-fg textarea.error{border-color:#e53935!important;box-shadow:0 0 0 3px rgba(229,57,53,.1)!important;}
.chkp-fg select{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%238aaa98' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:28px;}
.chkp-field-error{font-size:.7rem;color:#e53935;font-family:'Inter',system-ui,sans-serif;margin-top:2px;display:none;}
.chkp-fg.has-error .chkp-field-error{display:block;}

/* ── EMAIL NOTE ── */
.chkp-email-note{font-size:.7rem;color:#22adb0;font-family:'Inter',system-ui,sans-serif;margin-top:4px;display:flex;align-items:center;gap:4px;}

/* ── VALIDATION BANNER ── */
.chkp-validation-msg{display:none;background:#fff0f0;border:1.5px solid #e53935;border-left:4px solid #e53935;border-radius:10px;padding:11px 14px;font-family:'Inter',system-ui,sans-serif;font-size:.83rem;color:#b71c1c;margin-bottom:12px;}
.chkp-validation-msg.show{display:block;}

/* ── PAYMENT ── */
.chkp-pay-pills{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:12px;}
.chkp-pay-pill{display:inline-flex;align-items:center;gap:5px;background:#eefcfc;border:1.5px solid #b0f4f3;border-radius:50px;padding:5px 10px;font-size:.72rem;font-weight:700;color:#103837;font-family:'Inter',system-ui,sans-serif;}
.chkp-pay-pill .dashicons{color:#22adb0;font-size:12px;width:12px;height:12px;}
.chkp-wrap #payment{background:transparent!important;border:none!important;padding:0!important;}
.chkp-wrap #payment ul.payment_methods{list-style:none!important;border:none!important;padding:0!important;margin:0!important;background:transparent!important;}
.chkp-wrap #payment ul.payment_methods li{background:#eefcfc!important;border:2px solid #b0f4f3!important;border-radius:9px!important;padding:10px 13px!important;margin-bottom:8px!important;cursor:pointer!important;transition:border-color .2s,background .2s!important;}
.chkp-wrap #payment ul.payment_methods li:has(input:checked){border-color:#22adb0!important;background:#e5fbfb!important;}
.chkp-wrap #payment ul.payment_methods li label{font-size:.84rem!important;font-weight:700!important;color:#103837!important;margin:0!important;cursor:pointer!important;display:flex!important;align-items:center!important;gap:7px!important;}
.chkp-wrap #payment ul.payment_methods li input[type="radio"]{accent-color:#22adb0!important;width:14px!important;height:14px!important;flex-shrink:0!important;}
.chkp-wrap #payment .payment_box{background:#fff!important;border:1.5px solid #b0f4f3!important;border-radius:7px!important;padding:10px 12px!important;margin:7px 0 0!important;font-size:.8rem!important;color:#22adb0!important;font-family:'Inter',system-ui,sans-serif!important;line-height:1.6!important;display:block!important;}
.chkp-wrap #payment #place_order,.chkp-wrap #payment .place-order{display:none!important;}

/* ── BUTTONS ── */
.chkp-actions{display:flex;flex-direction:column;gap:10px;}
.chkp-wa-btn{display:flex;align-items:center;justify-content:center;gap:8px;background:#25d366;color:#fff;padding:13px 14px;border-radius:14px !important;font-family:'Inter',system-ui,sans-serif;font-size:.9rem;font-weight:900;text-decoration:none;border:none;cursor:pointer;box-shadow:0 5px 18px rgba(37,211,102,.3);transition:all .3s;width:100%;box-sizing:border-box;text-align:center;}
.chkp-wa-btn:hover{background:#22adb0;transform:translateY(-2px);color:#fff;}
.chkp-place-btn{display:flex;align-items:center;justify-content:center;gap:8px;background:#22adb0;color:#fff;padding:12px 14px;border-radius:14px !important;font-family:'Inter',system-ui,sans-serif;font-size:.88rem;font-weight:900;border:none;cursor:pointer;width:100%;box-sizing:border-box;box-shadow:0 5px 18px rgba(34,173,176,.3);transition:all .3s;}
.chkp-place-btn:hover:not(:disabled){background:#22adb0;transform:translateY(-2px);}
.chkp-place-btn:disabled{opacity:.65;cursor:not-allowed;transform:none;}
.chkp-or{display:flex;align-items:center;gap:8px;color:#5bd9d7;font-size:.7rem;font-weight:700;font-family:'Inter',system-ui,sans-serif;}
.chkp-or::before,.chkp-or::after{content:'';flex:1;height:1px;background:#daf6f6;}
.chkp-back{display:flex;align-items:center;justify-content:center;gap:6px;color:#5bd9d7;font-size:.78rem;font-weight:700;font-family:'Inter',system-ui,sans-serif;text-decoration:none;transition:color .2s;}
.chkp-back:hover{color:#22adb0;}

/* ── SIDEBAR ── */
.chkp-sidebar{position:sticky;top:85px;}
.chkp-summary-card{background:#fff;border-radius:12px;border:1.5px solid #b0f4f3;box-shadow:0 3px 16px rgba(34,173,176,.07);overflow:hidden;margin-bottom:14px;}
.chkp-summary-head{background:#22adb0;padding:12px 16px;display:flex;align-items:center;gap:7px;}
.chkp-summary-head .dashicons{color:#fff;font-size:15px;width:15px;height:15px;}
.chkp-summary-head h3{font-family:'Inter',system-ui,sans-serif;font-size:.85rem;font-weight:800;color:#fff;margin:0;}
.chkp-summary-card .woocommerce-checkout-review-order-table{width:100%!important;border-collapse:collapse!important;border:none!important;margin:0!important;}
.chkp-summary-card .woocommerce-checkout-review-order-table th,.chkp-summary-card .woocommerce-checkout-review-order-table td{padding:8px 14px!important;border:none!important;border-bottom:1px solid #e5fbfb!important;font-family:'Inter',system-ui,sans-serif!important;font-size:.79rem!important;vertical-align:middle!important;}
.chkp-summary-card .woocommerce-checkout-review-order-table thead th{font-size:.62rem!important;font-weight:800!important;color:#5bd9d7!important;text-transform:uppercase!important;letter-spacing:.07em!important;background:#f9fefe!important;}
.chkp-summary-card .woocommerce-checkout-review-order-table .product-name{color:#103837!important;font-weight:700!important;}
.chkp-summary-card .woocommerce-checkout-review-order-table .product-total .amount{color:#22adb0!important;font-weight:800!important;}
.chkp-summary-card .woocommerce-checkout-review-order-table tfoot .order-total th{font-weight:800!important;color:#103837!important;font-size:.84rem!important;}
.chkp-summary-card .woocommerce-checkout-review-order-table tfoot .order-total .amount{font-size:1.05rem!important;font-weight:900!important;color:#22adb0!important;}
.chkp-summary-card .woocommerce-checkout-review-order-table tfoot tr:last-child td,.chkp-summary-card .woocommerce-checkout-review-order-table tfoot tr:last-child th{border-bottom:none!important;}
.chkp-pay-note{background:#eefcfc;border-top:2px solid #e5fbfb;padding:11px 14px;font-family:'Inter',system-ui,sans-serif;}
.chkp-pnr{display:flex;align-items:flex-start;gap:6px;margin-bottom:6px;font-size:.72rem;color:#22adb0;line-height:1.45;}
.chkp-pnr:last-child{margin-bottom:0;}
.chkp-pnr .dashicons{font-size:12px;width:12px;height:12px;flex-shrink:0;margin-top:1px;}
.chkp-pnr.nairobi .dashicons{color:#22adb0;}.chkp-pnr.county .dashicons{color:#f0a500;}.chkp-pnr.mpesa .dashicons{color:#22adb0;}

/* ── MOBILE ACTIONS ── */
.chkp-mobile-actions{display:none;}
.chkp-desktop-actions{display:flex;flex-direction:column;gap:10px;}

/* ── ORDER SUCCESS BANNER ── */
.chkp-success-banner{
  display:none;background:#ebfcfc;border:1.5px solid #57e7e5;border-left:4px solid #22adb0;
  border-radius:10px;padding:16px;font-family:'Inter',system-ui,sans-serif;margin-bottom:12px;
}
.chkp-success-banner.show{display:block;}
.chkp-success-banner-title{font-size:.95rem;font-weight:900;color:#22adb0;margin-bottom:6px;display:flex;align-items:center;gap:7px;}
.chkp-success-banner-body{font-size:.8rem;color:#22adb0;line-height:1.6;}
.chkp-success-banner-body a{color:#22adb0;font-weight:800;}
.chkp-success-banner-order{display:inline-block;background:#22adb0;color:#fff;border-radius:50px;padding:3px 12px;font-size:.7rem;font-weight:800;margin-top:8px;}
.chkp-success-email-note{margin-top:8px;font-size:.75rem;color:#22adb0;background:rgba(34,173,176,.1);border-radius:6px;padding:7px 10px;display:flex;align-items:center;gap:6px;}

/* ── ERROR BANNER ── */
.chkp-error-banner{
  display:none;background:#fff0f0;border:1.5px solid #e53935;border-left:4px solid #e53935;
  border-radius:10px;padding:14px;font-family:'Inter',system-ui,sans-serif;margin-bottom:12px;
  font-size:.82rem;color:#b71c1c;
}
.chkp-error-banner.show{display:block;}

/* ── SPINNER ── */
.chkp-place-btn .cv-spin{display:none;width:15px;height:15px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:cvSpin .7s linear infinite;}
.chkp-place-btn.loading .cv-spin{display:inline-block;}
.chkp-place-btn.loading .chkp-btn-label{opacity:.7;}
@keyframes cvSpin{to{transform:rotate(360deg);}}

/* ── FORM FADED AFTER SUCCESS ── */
.chkp-form-faded .chkp-card{opacity:0.3;pointer-events:none;transition:opacity .4s;}
.chkp-form-faded #chkp-actions-card-desktop{opacity:1;pointer-events:auto;}

/* ════════════════════════════════════════════════
   RESPONSIVE BREAKPOINTS
════════════════════════════════════════════════ */
@media(max-width:960px){
  .chkp-layout{grid-template-columns:1fr;grid-template-rows:auto auto auto;}
  .chkp-left{order:1;}.chkp-sidebar{order:2;position:static;}
  .chkp-desktop-actions{display:none!important;}
  .chkp-mobile-actions{display:flex!important;flex-direction:column;gap:10px;order:3;background:#fff;border-radius:12px;border:1.5px solid #b0f4f3;box-shadow:0 3px 16px rgba(34,173,176,.07);padding:16px;margin-top:0;}
}

/* At 700px keep 2-col grid but reduce gaps */
@media(max-width:700px){
  .chkp-wrap{padding:12px 3%;}
  .chkp-banner{padding:16px 3%;}
  .chkp-steps{padding:8px 3%;}
  .chkp-card-body{padding:12px 10px;}
  .chkp-grid{gap:8px 10px;}
}

/* Below 540px collapse to single column */
@media(max-width:540px){
  .chkp-wrap{padding:10px 3%;}
  .chkp-banner{padding:14px 3%;}
  .chkp-banner h1{font-size:1.1rem;}
  .chkp-breadcrumb{font-size:.68rem;}
  .chkp-card-body{padding:10px 8px;}
  /* SINGLE COLUMN on small screens */
  .chkp-grid{grid-template-columns:1fr!important;gap:8px;}
  .chkp-step-lbl{display:none!important;}
  .chkp-step-line{min-width:5px;margin:0 4px;}
  .chkp-pay-pills{gap:4px;}
  .chkp-pay-pill{font-size:.62rem;padding:4px 7px;}
  .chkp-pay-pill .dashicons{display:none;}
  .chkp-fg input,.chkp-fg select,.chkp-fg textarea{padding:7px 10px;font-size:.8rem;}
  .chkp-fg label{font-size:.72rem;}
  .chkp-wa-btn{font-size:.84rem;padding:12px 10px;}
  .chkp-place-btn{font-size:.82rem;padding:11px 10px;}
  .chkp-summary-card .woocommerce-checkout-review-order-table th,.chkp-summary-card .woocommerce-checkout-review-order-table td{padding:7px 10px!important;font-size:.74rem!important;}
}

@media(max-width:360px){
  .chkp-wrap{padding:8px 2%;}
  .chkp-card-body{padding:8px 6px;}
  .chkp-fg input,.chkp-fg select{padding:6px 8px;font-size:.76rem;}
  .chkp-wa-btn{font-size:.78rem;padding:10px 8px;gap:6px;}
  .chkp-place-btn{font-size:.76rem;padding:10px 8px;}
}

/* ---- Simple checkout ---- */
.chkp-grid.chkp-simple{grid-template-columns:1fr !important;gap:12px;}
.chkp-wrap #payment{display:none !important;}

/* ---- chkp-fields-v2: layout, sizes, square-ish corners ---- */
body .chkp-grid.chkp-simple{display:grid !important;grid-template-columns:1fr 1fr !important;gap:16px 20px !important;}
body .chkp-grid.chkp-simple .chkp-fg{margin:0 !important;min-width:0;}
body .chkp-fg input[type="text"],
body .chkp-fg input[type="tel"],
body .chkp-fg input[type="email"]{height:54px !important;font-size:16px !important;padding:0 16px !important;border-radius:8px !important;box-sizing:border-box;width:100%;}
body .chkp-fg label{font-size:15px !important;}
body .chkp-card{border-radius:12px !important;}
body .chkp-wrap button,
body .chkp-wrap .button,
body #chkp-wa-btn,
body #chkp-place-btn-desktop,
body #chkp-place-btn-mobile{border-radius:8px !important;}

@media (max-width:768px){
  body .chkp-grid.chkp-simple{grid-template-columns:1fr !important;gap:14px !important;}
  body .chkp-fg input[type="text"],
  body .chkp-fg input[type="tel"],
  body .chkp-fg input[type="email"]{height:60px !important;font-size:18px !important;padding:0 18px !important;}
  body .chkp-fg label{font-size:16px !important;}
  body .chkp-wrap button,
  body #chkp-wa-btn,
  body #chkp-place-btn-desktop,
  body #chkp-place-btn-mobile{min-height:56px;font-size:17px !important;}
}

/* ---- chkp-sidebar-scroll: summary matches the left column height, items scroll ---- */
@media (min-width:961px){
  .chkp-layout{align-items:stretch;}
  .chkp-sidebar{position:relative !important;top:auto !important;min-height:460px;}
  .chkp-sidebar .chkp-summary-card{position:absolute;top:0;right:0;bottom:0;left:0;margin:0;display:flex;flex-direction:column;}
  .chkp-sidebar .chkp-summary-head{flex:0 0 auto;}
  .chkp-sidebar #order_review{flex:1 1 auto;min-height:0;overflow-y:auto;-webkit-overflow-scrolling:touch;scrollbar-width:thin;scrollbar-color:#22adb0 #e5fbfb;}
  .chkp-sidebar #order_review::-webkit-scrollbar{width:8px;}
  .chkp-sidebar #order_review::-webkit-scrollbar-track{background:#e5fbfb;}
  .chkp-sidebar #order_review::-webkit-scrollbar-thumb{background:#22adb0;border-radius:6px;}
  .chkp-sidebar .woocommerce-checkout-review-order-table thead th{position:sticky;top:0;z-index:2;}
  .chkp-sidebar .chkp-pay-note{flex:0 0 auto;}
}

/* ---- Checkout summary v2: items scroll, totals stay fixed ---- */
@media (min-width:961px){
    html body .chkp-layout{align-items:stretch;}
    html body .chkp-sidebar{position:relative !important;top:auto !important;min-height:460px;}
    html body .chkp-sidebar .chkp-summary-card{position:absolute;top:0;right:0;bottom:0;left:0;margin:0;display:flex;flex-direction:column;}
    html body .chkp-sidebar .chkp-summary-head{flex:0 0 auto;}
    html body .chkp-sidebar #order_review{flex:1 1 auto;min-height:0;overflow-y:auto;overscroll-behavior:contain;}
    html body .chkp-sidebar .chkp-pay-note{flex:0 0 auto;}
}
@media (max-width:960px){
    html body .chkp-sidebar #order_review{max-height:380px;overflow-y:auto;overscroll-behavior:contain;-webkit-overflow-scrolling:touch;}
}
html body .chkp-summary-card .woocommerce-checkout-review-order-table{border-collapse:separate !important;border-spacing:0 !important;}
html body .chkp-summary-card .woocommerce-checkout-review-order-table thead th{position:sticky;top:0;z-index:3;background:#f9fefe !important;}
html body .chkp-summary-card .woocommerce-checkout-review-order-table tfoot{position:sticky;bottom:0;z-index:4;}
html body .chkp-summary-card .woocommerce-checkout-review-order-table tfoot th,
html body .chkp-summary-card .woocommerce-checkout-review-order-table tfoot td{background:#fff !important;}
html body .chkp-summary-card .woocommerce-checkout-review-order-table tfoot tr:first-child th,
html body .chkp-summary-card .woocommerce-checkout-review-order-table tfoot tr:first-child td{border-top:2px solid #b0f4f3 !important;}

/* ---- Checkout summary v3: scrollable items, fixed Total, no shipping row ---- */
html body .chkp-summary-card .woocommerce-checkout-review-order-table tfoot tr.cart-subtotal,
html body .chkp-summary-card .woocommerce-checkout-review-order-table tfoot tr.shipping,
html body .chkp-summary-card .woocommerce-checkout-review-order-table tfoot tr.woocommerce-shipping-totals{display:none !important;}
html body .chkp-scroll{scrollbar-width:thin;scrollbar-color:#22adb0 #e5fbfb;overscroll-behavior:contain;-webkit-overflow-scrolling:touch;}
html body .chkp-scroll::-webkit-scrollbar{width:8px;}
html body .chkp-scroll::-webkit-scrollbar-track{background:#e5fbfb;}
html body .chkp-scroll::-webkit-scrollbar-thumb{background:#22adb0;border-radius:6px;}
@media (min-width:961px){
    html body .chkp-layout{align-items:stretch;}
    html body .chkp-sidebar{position:relative !important;top:auto !important;min-height:480px;}
    html body .chkp-sidebar .chkp-summary-card{position:absolute;top:0;right:0;bottom:0;left:0;margin:0;display:flex;flex-direction:column;overflow:hidden;}
    html body .chkp-sidebar .chkp-summary-head{flex:0 0 auto;}
    html body .chkp-sidebar .chkp-scroll{flex:1 1 auto;min-height:0;overflow-y:auto;}
    html body .chkp-sidebar .chkp-pay-note{flex:0 0 auto;}
}
@media (max-width:960px){
    html body .chkp-scroll{max-height:380px;overflow-y:auto;}
}
</style>

<?php if ( function_exists( 'wc_clear_notices' ) ) wc_clear_notices(); ?>

<!-- BANNER -->
<section class="chkp-banner">
  <div class="chkp-banner-inner">
    <h1>
      <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.85)" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      Checkout
    </h1>
    <nav class="chkp-breadcrumb">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &rsaquo;
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Cart</a> &rsaquo;
      <span>Checkout</span>
    </nav>
  </div>
</section>

<!-- STEPS -->
<div class="chkp-steps" id="chkp-steps-bar">
  <div class="chkp-steps-inner">
    <div class="chkp-step done">
      <div class="chkp-step-num"><span class="dashicons dashicons-yes" style="font-size:10px;width:10px;height:10px;"></span></div>
      <span class="chkp-step-lbl">Cart</span>
    </div>
    <div class="chkp-step-line done"></div>
    <div class="chkp-step active" id="chkp-step-2">
      <div class="chkp-step-num">2</div>
      <span class="chkp-step-lbl">Checkout</span>
    </div>
    <div class="chkp-step-line" id="chkp-step-line-2"></div>
    <div class="chkp-step" id="chkp-step-3">
      <div class="chkp-step-num">3</div>
      <span class="chkp-step-lbl">Confirmation</span>
    </div>
  </div>
</div>

<!-- MAIN -->
<div class="chkp-wrap">
<?php if ( function_exists( 'WC' ) && WC()->cart ) :
    if ( function_exists( 'wc_clear_notices' ) ) wc_clear_notices();
    $checkout    = WC()->checkout();
    $val         = function ( $key ) use ( $checkout ) { $v = $checkout->get_value( $key ); return esc_attr( $v ?? '' ); };
    $countries   = WC()->countries->get_allowed_countries();
    $sel_country = $val( 'billing_country' ) ?: 'KE';
    $states      = WC()->countries->get_states( $sel_country ) ?: [];
    $sel_state   = $val( 'billing_state' );
    $order_nonce = wp_create_nonce( 'travotech_order_nonce' );
?>
<div class="chkp-layout">

  <!-- LEFT: FORM -->
  <div class="chkp-left" id="chkp-left">
    <form name="checkout" method="post" id="chkp-form"
          class="checkout woocommerce-checkout"
          action="<?php echo esc_url( wc_get_checkout_url() ); ?>"
          enctype="multipart/form-data" novalidate>

      <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

      <!-- YOUR DETAILS (simple) -->
      <div class="chkp-card" id="chkp-card-billing">
        <div class="chkp-card-head">
          <span class="dashicons dashicons-admin-users"></span>
          <h3>Your Details</h3>
        </div>
        <div class="chkp-card-body">
          <div class="chkp-grid chkp-simple">

            <div class="chkp-fg" data-field="billing_first_name">
              <label>Full name <span class="req">*</span></label>
              <input type="text" name="billing_first_name" id="billing_first_name" value="<?php echo $val( 'billing_first_name' ); ?>" placeholder="Your full name" autocomplete="name">
              <span class="chkp-field-error">Your name is required</span>
            </div>

            <div class="chkp-fg" data-field="billing_phone">
              <label>Phone number <span class="req">*</span></label>
              <input type="tel" name="billing_phone" id="billing_phone" value="<?php echo $val( 'billing_phone' ); ?>" placeholder="+254 7XX XXX XXX" autocomplete="tel">
              <span class="chkp-field-error">Phone number is required</span>
            </div>

            <div class="chkp-fg" data-field="billing_email">
              <label>Email <span class="req">*</span></label>
              <input type="email" name="billing_email" id="billing_email" value="<?php echo $val( 'billing_email' ); ?>" placeholder="your@email.com" autocomplete="email">
              <span class="chkp-field-error">A valid email address is required</span>
            </div>

            <div class="chkp-fg" data-field="billing_address_1">
              <label>Street address <span class="req">*</span></label>
              <input type="text" name="billing_address_1" id="billing_address_1" value="<?php echo $val( 'billing_address_1' ); ?>" placeholder="House number, street, estate / area" autocomplete="street-address">
              <span class="chkp-field-error">Street address is required</span>
            </div>

          </div>

          <!-- defaults for the fields we no longer ask for -->
          <input type="hidden" name="billing_country" id="billing_country" value="KE">
          
          <input type="hidden" name="billing_city" id="billing_city" value="To be confirmed">
          <input type="hidden" name="payment_method" value="cod">
        </div>
      </div>

      <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

      <!-- ACTIONS — DESKTOP ONLY -->
      <div class="chkp-card" id="chkp-actions-card-desktop">
        <div class="chkp-card-body">
          <?php if ( function_exists( 'woocommerce_checkout_privacy_policy_text' ) ) woocommerce_checkout_privacy_policy_text(); ?>
          <?php if ( function_exists( 'woocommerce_terms_and_conditions_page_content' ) ) woocommerce_terms_and_conditions_page_content(); ?>

          <!-- Validation error -->
          <div class="chkp-validation-msg" id="chkp-val-msg">
            <strong>Please fill in all required fields before proceeding.</strong>
            <span id="chkp-val-detail"></span>
          </div>

          <!-- Success banner -->
          <div class="chkp-success-banner" id="chkp-success-desktop">
            <div class="chkp-success-banner-title">
              <span class="dashicons dashicons-yes-alt" style="color:#22adb0;font-size:18px;width:18px;height:18px;"></span>
              Order Placed Successfully
            </div>
            <div class="chkp-success-banner-body">
              Your order has been saved and our team will contact you shortly to confirm delivery.<br>
              For urgent enquiries: <a href="https://wa.me/254720737151" target="_blank">WhatsApp +254 720 737 151</a>
              <div class="chkp-success-email-note" id="chkp-email-note-desktop" style="display:none;">
                <span class="dashicons dashicons-email-alt" style="font-size:13px;width:13px;height:13px;color:#22adb0;flex-shrink:0;"></span>
                <span id="chkp-email-note-text-desktop">A confirmation email has been sent to your inbox.</span>
              </div>
              <div><span class="chkp-success-banner-order" id="chkp-order-badge-desktop"></span></div>
            </div>
          </div>

          <!-- Error banner -->
          <div class="chkp-error-banner" id="chkp-error-desktop"></div>

          <div class="chkp-desktop-actions" id="chkp-desktop-actions">
            <a href="#" id="chkp-wa-btn" class="chkp-wa-btn">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Make Order via WhatsApp
            </a>
            <div class="chkp-or">OR place order on website</div>
            <button type="button" class="chkp-place-btn" id="chkp-place-btn-desktop">
              <span class="cv-spin"></span>
              <span class="dashicons dashicons-yes-alt" style="font-size:15px;width:15px;height:15px;"></span>
              <span class="chkp-btn-label">Place Order</span>
            </button>
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="chkp-back">
              <span class="dashicons dashicons-arrow-left-alt" style="font-size:13px;width:13px;height:13px;"></span>
              Return to Cart
            </a>
          </div>

          <a href="<?php echo esc_url( function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' ) ); ?>"
             class="chkp-place-btn" id="chkp-continue-desktop"
             style="display:none;text-decoration:none;margin-top:10px;background:#22adb0;">
             <span class="dashicons dashicons-cart" style="font-size:14px;width:14px;height:14px;"></span>
             Continue Shopping
          </a>
        </div>
      </div>

    </form>
    <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
  </div>

  <!-- SIDEBAR / ORDER SUMMARY -->
  <div class="chkp-sidebar">
    <div class="chkp-summary-card">
      <div class="chkp-summary-head">
        <span class="dashicons dashicons-list-view"></span>
        <h3 id="chkp-summary-title">Order Summary <?php $cnt = intval( WC()->cart->get_cart_contents_count() ); echo '(' . $cnt . ' item' . ( $cnt !== 1 ? 's' : '' ) . ')'; ?></h3>
      </div>
      <div class="chkp-scroll" id="chkp-scroll"><?php woocommerce_order_review(); ?></div>
      <div class="chkp-pay-note">
        <div class="chkp-pnr nairobi"><span class="dashicons dashicons-location"></span><span><strong>Nairobi:</strong> Pay on delivery: Cash</span></div>
        <div class="chkp-pnr county"><span class="dashicons dashicons-warning"></span><span><strong>Other Counties:</strong> Full payment before dispatch</span></div>
        
      </div>
    </div>
  </div>

  <!-- MOBILE ACTIONS -->
  <div class="chkp-mobile-actions">
    <div class="chkp-validation-msg" id="chkp-val-msg-mobile">
      <strong>Please fill in all required fields before proceeding.</strong>
      <span id="chkp-val-detail-mobile"></span>
    </div>

    <div class="chkp-success-banner" id="chkp-success-mobile">
      <div class="chkp-success-banner-title">
        <span class="dashicons dashicons-yes-alt" style="color:#22adb0;font-size:18px;width:18px;height:18px;"></span>
        Order Placed Successfully
      </div>
      <div class="chkp-success-banner-body">
        Your order has been saved and our team will contact you shortly to confirm delivery.<br>
        <a href="https://wa.me/254720737151" target="_blank">WhatsApp +254 720 737 151</a>
        <div class="chkp-success-email-note" id="chkp-email-note-mobile" style="display:none;">
          <span class="dashicons dashicons-email-alt" style="font-size:13px;width:13px;height:13px;color:#22adb0;flex-shrink:0;"></span>
          <span id="chkp-email-note-text-mobile">A confirmation email has been sent to your inbox.</span>
        </div>
        <div><span class="chkp-success-banner-order" id="chkp-order-badge-mobile"></span></div>
      </div>
    </div>

    <div class="chkp-error-banner" id="chkp-error-mobile"></div>

    <a href="#" id="chkp-wa-btn-mobile" class="chkp-wa-btn">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      Make Order via WhatsApp
    </a>
    <div class="chkp-or">OR place order on website</div>

    <button type="button" id="chkp-place-btn-mobile" class="chkp-place-btn">
      <span class="cv-spin"></span>
      <span class="dashicons dashicons-yes-alt" style="font-size:15px;width:15px;height:15px;"></span>
      <span class="chkp-btn-label">Place Order</span>
    </button>

    <a href="<?php echo esc_url( function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' ) ); ?>"
       class="chkp-place-btn" id="chkp-continue-mobile"
       style="display:none;text-decoration:none;background:#22adb0;">
       <span class="dashicons dashicons-cart" style="font-size:14px;width:14px;height:14px;"></span>
       Continue Shopping
    </a>

    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="chkp-back">
      <span class="dashicons dashicons-arrow-left-alt" style="font-size:13px;width:13px;height:13px;"></span>
      Return to Cart
    </a>
  </div>

</div><!-- /.chkp-layout -->

<?php endif; ?>
</div><!-- /.chkp-wrap -->

<script>
(function(){

  var AJAX_URL    = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>';
  var ORDER_NONCE = '<?php echo esc_js( $order_nonce ); ?>';
  var WC_AJAX_URL = '<?php echo esc_js( home_url( "/?wc-ajax=%%endpoint%%" ) ); ?>';

  /* ── NUKE NOTICES ── */
  function nukeNotices() {
    var sels = ['.woocommerce-notices-wrapper','.woocommerce-message','.woocommerce-info','ul.woocommerce-error','.woocommerce-NoticeGroup','.woocommerce-NoticeGroup-checkout','.woocommerce-NoticeGroup-updateOrderReview'];
    sels.forEach(function(s){ document.querySelectorAll(s).forEach(function(el){ el.style.cssText='display:none!important;visibility:hidden!important;height:0!important;overflow:hidden!important;margin:0!important;padding:0!important;'; if(el.parentNode)el.parentNode.removeChild(el); }); });
  }
  nukeNotices();
  document.addEventListener('DOMContentLoaded', nukeNotices);
  if(window.MutationObserver){
    new MutationObserver(function(muts){ muts.forEach(function(m){ m.addedNodes.forEach(function(n){ if(n.nodeType===1){var c=n.className||'';if(['woocommerce-message','woocommerce-info','woocommerce-error','woocommerce-NoticeGroup','woocommerce-notices-wrapper'].some(function(k){return c.indexOf(k)>-1;}))nukeNotices();} }); }); }).observe(document.body,{childList:true,subtree:true});
  }

  /* ── REQUIRED FIELDS — email mandatory ── */
  var required = [
    {id:'billing_first_name', label:'Full name'},
    {id:'billing_phone',      label:'Phone'},
    {id:'billing_email',      label:'Email address', type:'email'},
    {id:'billing_address_1', label:'Street address'}
  ];

  function getVal(id){ var el=document.getElementById(id); return el?el.value.trim():''; }

  function validateForm(msgId, detailId){
    var missing=[], hasError=false;
    required.forEach(function(f){
      var wrap=document.querySelector('[data-field="'+f.id+'"]');
      var inp=document.getElementById(f.id);
      if(wrap)wrap.classList.remove('has-error');
      if(inp)inp.classList.remove('error');
    });
    required.forEach(function(f){
      var val = getVal(f.id);
      var invalid = !val;
      if(!invalid && f.type === 'email'){
        invalid = !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
      }
      if(invalid){
        missing.push(f.label); hasError=true;
        var wrap=document.querySelector('[data-field="'+f.id+'"]');
        var inp=document.getElementById(f.id);
        if(wrap)wrap.classList.add('has-error');
        if(inp)inp.classList.add('error');
      }
    });
    if(hasError){
      var msg=document.getElementById(msgId);
      var det=document.getElementById(detailId);
      if(msg)msg.classList.add('show');
      if(det)det.textContent=' Missing: '+missing.join(', ')+'.';
      var first=document.querySelector('.chkp-fg.has-error');
      if(first)first.scrollIntoView({behavior:'smooth',block:'center'});
    }
    return !hasError;
  }

  function collectFormData(via){
    var form = document.getElementById('chkp-form');
    var fd = new FormData(form);
    var fullName = getVal('billing_first_name').split(/\s+/);
    fd.set('billing_first_name', fullName.shift() || '');
    fd.set('billing_last_name', fullName.join(' ') || '-');
    fd.append('action',              'travotech_send_order_email');
    fd.append('travotech_order_nonce', ORDER_NONCE);
    fd.append('order_via',           via || 'website');
    var payEl = document.querySelector('#chkp-form input[name="payment_method"]:checked');
    if(payEl) fd.set('payment_method', payEl.value);
    return fd;
  }

  function buildWaMessage(){
    var fname=getVal('billing_first_name'), lname=getVal('billing_last_name'),
        company=getVal('billing_company'), phone=getVal('billing_phone'),
        email=getVal('billing_email'), addr1=getVal('billing_address_1'),
        addr2=getVal('billing_address_2'), city=getVal('billing_city');
    var stateSel=document.getElementById('billing_state');
    var stateVal=stateSel?(stateSel.options[stateSel.selectedIndex]?stateSel.options[stateSel.selectedIndex].text:stateSel.value):'';
    var postcode=getVal('billing_postcode');
    var notes=document.getElementById('order_comments')?document.getElementById('order_comments').value.trim():'';
    var itemLines=[];
    document.querySelectorAll('.woocommerce-checkout-review-order-table tbody tr').forEach(function(tr){
      var name=tr.querySelector('.product-name'); var total=tr.querySelector('.product-total');
      if(name&&total)itemLines.push(name.textContent.trim()+' - '+total.textContent.trim());
    });
    var grandTotal='';
    var totRow=document.querySelector('.woocommerce-checkout-review-order-table tfoot .order-total .amount');
    if(totRow)grandTotal=totRow.textContent.trim();
    var msg='Hello Travotech Agencies,\n\nORDER REQUEST\n============================\n\nCUSTOMER DETAILS:\n';
    msg+='Name: '+fname+' '+lname+'\n';
    if(company)msg+='Company: '+company+'\n';
    msg+='Phone: '+phone+'\nEmail: '+email+'\nAddress: '+addr1+'\n\nORDER ITEMS:\n';
    if(itemLines.length){itemLines.forEach(function(l){msg+=l+'\n';});}
    msg+='\n----------------------------\nORDER TOTAL: '+grandTotal+'\n----------------------------\n';
    if(notes)msg+='\nNOTES: '+notes+'\n';
    msg+='\nPayment: [Please confirm payment arrangements]\n\nPlease confirm my order. Thank you.';
    return msg;
  }

  function sendOrderToServer(via, onDone){
    var fd = collectFormData(via);
    fetch(AJAX_URL, {
      method:'POST', body:fd, credentials:'same-origin',
      headers:{'X-Requested-With':'XMLHttpRequest'}
    })
    .then(function(r){ return r.json(); })
    .then(function(res){ if(onDone) onDone(res); })
    .catch(function(){ if(onDone) onDone(null); });
  }

  /* ════════════════════════════════════════════════════════
     SILENT CART RESET via WooCommerce cart fragments AJAX
  ════════════════════════════════════════════════════════ */
  function refreshHeaderCart(){
    fetch(window.location.href,{credentials:'same-origin',cache:'no-store',headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){return r.text();})
    .then(function(html){
      var d=new DOMParser().parseFromString(html,'text/html');
      var f=d.querySelector('.th-cartwrap'),cur=document.querySelector('.th-cartwrap');
      if(f&&cur)cur.innerHTML=f.innerHTML;
    }).catch(function(){});
  }

  function silentCartReset(){
    refreshHeaderCart();
    var form = document.getElementById('chkp-form');
    if(form){
      form.querySelectorAll('input:not([type="hidden"]):not([type="radio"]):not([type="checkbox"])').forEach(function(inp){ inp.value=''; });
      form.querySelectorAll('textarea').forEach(function(ta){ ta.value=''; });
      form.querySelectorAll('select').forEach(function(sel){ sel.selectedIndex=0; });
      form.querySelectorAll('.has-error').forEach(function(el){ el.classList.remove('has-error'); });
      form.querySelectorAll('.error').forEach(function(el){ el.classList.remove('error'); });
    }

    var wcFragmentUrl = WC_AJAX_URL.replace('%%endpoint%%', 'get_refreshed_fragments');
    fetch(wcFragmentUrl, {
      method:'POST', credentials:'same-origin',
      headers:{'X-Requested-With':'XMLHttpRequest','Content-Type':'application/x-www-form-urlencoded'},
      body:'security=&time='+ Date.now()
    })
    .then(function(r){ return r.json(); })
    .then(function(data){
      if(data && data.fragments){
        Object.keys(data.fragments).forEach(function(selector){
          try{
            var els = document.querySelectorAll(selector);
            els.forEach(function(el){
              var tmp = document.createElement('div');
              tmp.innerHTML = data.fragments[selector];
              if(tmp.firstChild) el.parentNode.replaceChild(tmp.firstChild, el);
            });
          }catch(e){}
        });
      }
    })
    .catch(function(){})
    .finally(function(){
      var cartSelectors = [
        '.cart-contents-count','.wc-cart-count','.cart-count',
        '.site-header-cart .count','a.cart-contents span.count',
        '.header-cart-count','.cart-item-count','[class*="cart-"] .count'
      ];
      document.querySelectorAll(cartSelectors.join(',')).forEach(function(el){
        if(/\d/.test(el.textContent)){
          el.textContent = el.textContent.replace(/\d+/, '0');
        }
      });
    });

    var tbody = document.querySelector('.woocommerce-checkout-review-order-table tbody');
    if(tbody) tbody.innerHTML = '<tr><td colspan="2" style="padding:12px 14px;font-size:.8rem;color:#5bd9d7;font-family:Inter,system-ui,sans-serif;text-align:center;">Cart cleared</td></tr>';

    var totCell = document.querySelector('.woocommerce-checkout-review-order-table tfoot .order-total .amount');
    if(totCell) totCell.textContent = 'KES 0.00';

    var sidebarHead = document.getElementById('chkp-summary-title');
    if(sidebarHead) sidebarHead.textContent = 'Order Summary (0 items)';

    ['chkp-card-billing','chkp-card-payment','chkp-card-notes'].forEach(function(id){
      var card = document.getElementById(id);
      if(card){
        card.style.transition = 'opacity .4s';
        card.style.opacity = '0.3';
        card.style.pointerEvents = 'none';
      }
    });
  }

  function showSuccess(orderId, customerEmail, isDesktop){
    var suffix      = isDesktop ? '-desktop' : '-mobile';
    var succEl      = document.getElementById('chkp-success'+suffix);
    var badge       = document.getElementById('chkp-order-badge'+suffix);
    var actions     = isDesktop ? document.getElementById('chkp-desktop-actions') : null;
    var continueBtn = document.getElementById('chkp-continue'+suffix);
    var errEl       = document.getElementById('chkp-error'+suffix);
    var emailNote   = document.getElementById('chkp-email-note'+suffix);
    var emailText   = document.getElementById('chkp-email-note-text'+suffix);

    if(errEl) errEl.classList.remove('show');
    if(badge) badge.textContent = orderId ? 'Order #'+orderId : 'Order received';
    if(succEl) succEl.classList.add('show');
    if(actions) actions.style.display='none';
    if(continueBtn) continueBtn.style.display='flex';

    if(emailNote && customerEmail){
      if(emailText) emailText.textContent = 'A confirmation email has been sent to ' + customerEmail;
      emailNote.style.display = 'flex';
    }

    var step3 = document.getElementById('chkp-step-3');
    var line2  = document.getElementById('chkp-step-line-2');
    var step2  = document.getElementById('chkp-step-2');
    if(step3){ step3.classList.add('active'); }
    if(line2){ line2.classList.add('done'); }
    if(step2){
      step2.classList.remove('active');
      step2.classList.add('done');
      var num = step2.querySelector('.chkp-step-num');
      if(num) num.innerHTML = '<span class="dashicons dashicons-yes" style="font-size:10px;width:10px;height:10px;"></span>';
    }

    if(succEl) succEl.scrollIntoView({behavior:'smooth',block:'center'});
    silentCartReset();
  }

  function showError(msg, isDesktop){
    var suffix = isDesktop ? '-desktop' : '-mobile';
    var errEl  = document.getElementById('chkp-error'+suffix);
    if(!errEl) return;
    errEl.innerHTML = '<strong>'+msg+'</strong><br><small>You can also order via <a href="https://wa.me/254720737151" style="color:#b71c1c;">WhatsApp +254 720 737 151</a></small>';
    errEl.classList.add('show');
    errEl.scrollIntoView({behavior:'smooth',block:'center'});
  }

  function handlePlaceOrder(isDesktop){
    var valMsg    = isDesktop ? 'chkp-val-msg'    : 'chkp-val-msg-mobile';
    var valDetail = isDesktop ? 'chkp-val-detail' : 'chkp-val-detail-mobile';
    var btnId     = isDesktop ? 'chkp-place-btn-desktop' : 'chkp-place-btn-mobile';
    var btn       = document.getElementById(btnId);

    if(!validateForm(valMsg, valDetail)) return;
    document.getElementById(valMsg).classList.remove('show');

    if(btn){ btn.disabled=true; btn.classList.add('loading'); }

    var customerEmail = getVal('billing_email');

    sendOrderToServer('website', function(res){
      if(btn){ btn.disabled=false; btn.classList.remove('loading'); }

      if(res && res.success){
        showSuccess(
          res.data && res.data.order_id ? res.data.order_id : null,
          customerEmail,
          isDesktop
        );
      } else if(res && res.data && res.data.order_id){
        showSuccess(res.data.order_id, customerEmail, isDesktop);
      } else {
        var errMsg = (res && res.data && res.data.msg)
          ? res.data.msg
          : 'Something went wrong. Please try again or contact us via WhatsApp.';
        showError(errMsg, isDesktop);
      }
    });
  }

  function handleWaOrder(isDesktop){
    var valMsg    = isDesktop ? 'chkp-val-msg'    : 'chkp-val-msg-mobile';
    var valDetail = isDesktop ? 'chkp-val-detail' : 'chkp-val-detail-mobile';
    var waRequired = ['billing_first_name','billing_phone','billing_address_1'];
    var missing=[], hasError=false;
    waRequired.forEach(function(id){
      var wrap=document.querySelector('[data-field="'+id+'"]');
      var inp=document.getElementById(id);
      if(wrap)wrap.classList.remove('has-error');
      if(inp)inp.classList.remove('error');
    });
    waRequired.forEach(function(id){
      if(!document.getElementById(id) || !document.getElementById(id).value.trim()){
        missing.push(id.replace('billing_','').replace(/_/g,' ')); hasError=true;
        var wrap=document.querySelector('[data-field="'+id+'"]');
        var inp=document.getElementById(id);
        if(wrap)wrap.classList.add('has-error');
        if(inp)inp.classList.add('error');
      }
    });
    if(hasError){
      var msg=document.getElementById(valMsg);
      var det=document.getElementById(valDetail);
      if(msg)msg.classList.add('show');
      if(det)det.textContent=' Missing: '+missing.join(', ')+'.';
      var first=document.querySelector('.chkp-fg.has-error');
      if(first)first.scrollIntoView({behavior:'smooth',block:'center'});
      return;
    }
    document.getElementById(valMsg).classList.remove('show');

    window.open('https://wa.me/254720737151?text='+encodeURIComponent(buildWaMessage()), '_blank');
    sendOrderToServer('whatsapp', function(res){
      if(res && (res.success || (res.data && res.data.order_id))){ silentCartReset(); }
    });
  }

  /* ── WIRE UP BUTTONS ── */
  var btnD = document.getElementById('chkp-place-btn-desktop');
  if(btnD) btnD.addEventListener('click', function(){ handlePlaceOrder(true); });

  var btnM = document.getElementById('chkp-place-btn-mobile');
  if(btnM) btnM.addEventListener('click', function(){ handlePlaceOrder(false); });

  var waD = document.getElementById('chkp-wa-btn');
  if(waD) waD.addEventListener('click', function(e){ e.preventDefault(); handleWaOrder(true); });

  var waM = document.getElementById('chkp-wa-btn-mobile');
  if(waM) waM.addEventListener('click', function(e){ e.preventDefault(); handleWaOrder(false); });

  var form = document.getElementById('chkp-form');
  if(form) form.addEventListener('submit', function(e){ e.preventDefault(); });

  /* ── LIVE FIELD VALIDATION ── */
  required.forEach(function(f){
    var inp=document.getElementById(f.id);
    var wrap=document.querySelector('[data-field="'+f.id+'"]');
    if(!inp||!wrap) return;
    function clear(){
      if(inp.value.trim()){
        if(f.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inp.value.trim())) return;
        wrap.classList.remove('has-error');
        inp.classList.remove('error');
      }
    }
    inp.addEventListener('input',  clear);
    inp.addEventListener('change', clear);
    inp.addEventListener('blur', function(){
      var val = inp.value.trim();
      var bad = !val;
      if(!bad && f.type === 'email') bad = !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
      if(bad){ wrap.classList.add('has-error'); inp.classList.add('error'); }
      else   { wrap.classList.remove('has-error'); inp.classList.remove('error'); }
    });
  });

})();
</script>

<?php get_footer(); ?>
