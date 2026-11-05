<?php
/* single-product.php — Individual product page */
get_header();
global $product;

/* ── Toast params ── */
$travotech_toast_pid  = isset($_GET['travotech_added'])  ? intval($_GET['travotech_added'])  : 0;
$travotech_toast_name = '';
if ($travotech_toast_pid) {
  $p = wc_get_product($travotech_toast_pid);
  if ($p) {
    $n = $p->get_name();
    $travotech_toast_name = mb_strlen($n) > 30 ? mb_substr($n,0,30).'…' : $n;
  }
}

while (have_posts()): the_post();
  $pid       = get_the_ID();
  $wa        = '254720737151';
  $name      = $product->get_name();
  $price_c   = (float)$product->get_price();
  $price_r   = $product->get_regular_price();
  $sale      = $product->is_on_sale();
  $img       = get_the_post_thumbnail_url($pid, 'woocommerce_single');
  $cats      = get_the_terms($pid, 'product_cat');
  $cat_n     = $cats ? $cats[0]->name : '';
  $sku       = $product->get_sku();
  $stock     = $product->get_stock_status();
  $is_simple = $product->is_type('simple');
  $wa_msg    = urlencode("Hello " . get_bloginfo('name') . "! I'd like to order: *{$name}* — KES {$price_c}. " . get_permalink() . " Please confirm availability.");
  $atc_nonce     = wp_create_nonce('woocommerce-add-to-cart');
  $wc_ajax_nonce = wp_create_nonce('wc_add_to_cart_nonce');   /* used by /?wc-ajax=add_to_cart */
  $max_qty   = $product->get_max_purchase_quantity();
  $max_qty   = ($max_qty < 1) ? 9999 : $max_qty;

  /* Related products with pagination */
  $related_per_page = 4;
  $related_page     = isset($_GET['rel_page']) ? max(1, intval($_GET['rel_page'])) : 1;
  $all_related      = wc_get_related_products($pid, 100);
  $total_related    = count($all_related);
  $total_rel_pages  = $total_related > 0 ? ceil($total_related / $related_per_page) : 1;
  $rel_offset       = ($related_page - 1) * $related_per_page;
  $paged_related    = array_slice($all_related, $rel_offset, $related_per_page);
?>
<style>
/* ═══════════════════════════════════════
   SINGLE PRODUCT PAGE
═══════════════════════════════════════ */
.sp-wrap { max-width: 1200px; margin: 0 auto; padding: 32px 40px 60px; }
.sp-card { display: flex; gap: 48px; align-items: flex-start; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.07); }
.sp-gallery { flex: 0 0 420px; max-width: 420px; min-height: 380px; display: flex; align-items: center; justify-content: center; background: #f8f8f8; border-radius: 16px 0 0 16px; overflow: hidden; padding: 20px; }
.sp-gallery img { width: 100%; max-height: 400px; object-fit: contain; display: block; }
.sp-info { flex: 1; padding: 32px 36px 32px 0; display: flex; flex-direction: column; gap: 14px; }
.sp-meta-card { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; padding: 12px 14px; background: rgba(0,0,0,.03); border-radius: 12px; border: 1px solid rgba(0,0,0,.06); }
.sp-meta-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 600; white-space: nowrap; }
.sp-meta-cat    { background: rgba(34,173,176,.1); color: var(--green,#22adb0); }
.sp-meta-stock.instock    { background: rgba(34,173,176,.12); color: var(--green,#22adb0); }
.sp-meta-stock.outofstock { background: rgba(229,57,53,.1); color: #e53935; }
.sp-meta-sku    { background: rgba(0,0,0,.06); color: rgba(0,0,0,.55); }
.sp-title { font-size: clamp(1.3rem,3vw,2rem); font-weight: 800; line-height: 1.25; margin: 0; }

/* Live price */
.sp-price-wrap { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.sp-price-cur  { font-size: clamp(1.3rem,3vw,1.8rem); font-weight: 800; color: var(--green,#22adb0); transition: transform .15s; }
.sp-price-cur.bump { transform: scale(1.07); }
.sp-price-old  { font-size: 1rem; text-decoration: line-through; opacity: .45; }

.sp-desc { font-size: 0.9rem; line-height: 1.7; opacity: .8; }
.sp-desc p { margin: 0 0 8px; }

/* Qty stepper */
.sp-qty-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.sp-qty-label { font-size: .78rem; font-weight: 700; color: rgba(0,0,0,.5); text-transform: uppercase; letter-spacing: .06em; white-space: nowrap; }
.sp-qty-wrap { display: inline-flex; align-items: center; border: 2px solid #b0f4f3; border-radius: 10px; overflow: hidden; background: #fff; transition: border-color .2s, box-shadow .2s; }
.sp-qty-wrap:focus-within { border-color: #22adb0; box-shadow: 0 0 0 3px rgba(34,173,176,.12); }
.sp-qty-btn { width: 38px; height: 42px; border: none; background: #eefcfc; color: #22adb0; font-size: 1.15rem; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .18s, color .18s; flex-shrink: 0; padding: 0; user-select: none; line-height: 1; }
.sp-qty-btn:hover  { background: #22adb0; color: #fff; }
.sp-qty-btn:active { background: #22adb0; color: #fff; }
.sp-qty-btn:disabled { opacity: .3; cursor: not-allowed; }
.sp-qty-btn:disabled:hover { background: #eefcfc; color: #22adb0; }
#sp-qty-input { width: 52px; height: 42px; border: none !important; border-left: 1.5px solid #b0f4f3 !important; border-right: 1.5px solid #b0f4f3 !important; border-radius: 0 !important; box-shadow: none !important; text-align: center; font-family: 'Inter',system-ui,sans-serif; font-size: .9rem; font-weight: 700; color: #103837; background: #fff; padding: 0 !important; outline: none !important; -moz-appearance: textfield; }
#sp-qty-input::-webkit-outer-spin-button, #sp-qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

/* Action buttons */
.sp-actions { display: flex; flex-direction: column; gap: 10px; margin-top: 4px; }
.sp-wa-btn { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 24px; background: var(--green,#22adb0); color: #fff; font-size: clamp(0.72rem,2vw,0.92rem); font-weight: 700; text-decoration: none; border-radius: 12px; text-transform: uppercase; letter-spacing: .04em; box-shadow: 0 4px 14px rgba(34,173,176,.3); transition: opacity .2s, transform .15s; white-space: nowrap; }
.sp-wa-btn:hover { opacity: .88; transform: translateY(-1px); }
.sp-wa-btn svg { flex-shrink: 0; }
.sp-atc-btn { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 24px; background: var(--dark,#0e4847); color: #fff; font-size: clamp(0.72rem,2vw,0.92rem); font-weight: 700; border: none; border-radius: 12px; cursor: pointer; text-transform: uppercase; letter-spacing: .04em; box-shadow: 0 4px 14px rgba(0,0,0,.2); transition: opacity .2s, transform .15s; width: 100%; font-family: 'Inter',system-ui,sans-serif; text-decoration: none; }
.sp-atc-btn:hover { opacity: .88; transform: translateY(-1px); color: #fff; }
.sp-atc-btn svg { flex-shrink: 0; }
.sp-atc-btn.atc-loading { opacity: .7; pointer-events: none; }
.sp-atc-btn .atc-spinner { display: none; width: 16px; height: 16px; border: 2.5px solid rgba(255,255,255,.4); border-top-color: #fff; border-radius:14px !important; animation: spinBtn .6s linear infinite; flex-shrink: 0; }
.sp-atc-btn.atc-loading .atc-spinner { display: block; }
.sp-atc-btn.atc-loading .atc-icon    { display: none; }
@keyframes spinBtn { to { transform: rotate(360deg); } }

/* Variable product WC form */
.sp-actions .cart { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.sp-actions .quantity { flex-shrink: 0; }
.sp-actions .quantity input[type="number"] { width: 64px; height: 48px; border: 2px solid rgba(0,0,0,.12); border-radius: 10px; text-align: center; font-size: 1rem; font-weight: 700; outline: none; padding: 0 8px; transition: border-color .2s; }
.sp-actions .quantity input[type="number"]:focus { border-color: var(--green,#22adb0); }
.sp-actions .single_add_to_cart_button, .sp-actions button[type="submit"] { flex: 1; min-width: 120px; height: 48px; background: var(--dark,#0e4847) !important; color: #fff !important; border: none !important; border-radius: 10px !important; font-size: clamp(0.68rem,2vw,0.85rem) !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: .04em !important; cursor: pointer !important; transition: opacity .2s !important; display: flex; align-items: center; justify-content: center; gap: 8px; white-space: nowrap; }
.sp-actions .single_add_to_cart_button:hover, .sp-actions button[type="submit"]:hover { opacity: .85 !important; }

/* Tabs */
.sp-tabs-section { margin-top: 40px; }
.woocommerce-tabs .wc-tabs { display: flex !important; flex-direction: row !important; align-items: center !important; gap: 0 !important; border-bottom: 2px solid rgba(0,0,0,.08) !important; padding: 0 !important; list-style: none !important; margin: 0 0 28px !important; flex-wrap: nowrap !important; }
.woocommerce-tabs .wc-tabs li { margin: 0 !important; border: none !important; background: none !important; }
.woocommerce-tabs .wc-tabs li a { display: block !important; padding: 12px 24px !important; font-size: 0.88rem !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: .06em !important; text-decoration: none !important; color: rgba(0,0,0,.4) !important; border-bottom: 3px solid transparent !important; margin-bottom: -2px !important; transition: color .2s, border-color .2s !important; }
.woocommerce-tabs .wc-tabs li.active a, .woocommerce-tabs .wc-tabs li a:hover { color: var(--green,#22adb0) !important; border-bottom-color: var(--green,#22adb0) !important; }
.woocommerce-tabs .woocommerce-Tabs-panel h2 { font-size: 1rem !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: .08em !important; color: var(--green,#22adb0) !important; margin: 0 0 16px !important; padding-bottom: 10px !important; border-bottom: 1.5px solid rgba(34,173,176,.15) !important; }
.woocommerce-tabs .woocommerce-Tabs-panel p { text-indent: 0 !important; margin: 0 0 12px !important; line-height: 1.75 !important; font-size: 0.9rem !important; }

/* Hide WC notices */
.woocommerce-notices-wrapper, .woocommerce-message, .woocommerce-info, ul.woocommerce-error, .wc-forward { display: none !important; }

/* ═══════════════════════════════════════
   TOAST
═══════════════════════════════════════ */
#travotech-toast { position: fixed; bottom: 100px; right: 24px; z-index: 999999; min-width: 280px; max-width: 340px; background: #0e4847; color: #fff; border-radius: 14px; padding: 14px 16px 18px; box-shadow: 0 12px 40px rgba(0,0,0,.3); display: flex; align-items: flex-start; gap: 12px; font-family: 'Inter',system-ui,sans-serif; opacity: 0; transform: translateY(20px) scale(0.95); transition: opacity .4s cubic-bezier(.34,1.56,.64,1), transform .4s cubic-bezier(.34,1.56,.64,1); pointer-events: none; }
#travotech-toast.cv-show { opacity: 1; transform: translateY(0) scale(1); pointer-events: all; }
.cv-toast-icon-wrap { width: 36px; height: 36px; border-radius: 50%; background: #22adb0; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
.cv-toast-body { flex: 1; min-width: 0; }
.cv-toast-title { font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: #22adb0; margin-bottom: 3px; }
.cv-toast-name  { font-size: .85rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 10px; }
.cv-toast-actions { display: flex; gap: 8px; }
.cv-toast-btn-cart { display: inline-flex; align-items: center; gap: 5px; background: #22adb0; color: #fff; padding: 6px 12px; border-radius: 8px; font-size: .72rem; font-weight: 800; text-decoration: none; transition: background .2s; white-space: nowrap; }
.cv-toast-btn-cart:hover { background: #22adb0; color: #fff; }
.cv-toast-btn-close { display: inline-flex; align-items: center; background: rgba(255,255,255,.1); color: rgba(255,255,255,.7); padding: 6px 10px; border-radius: 8px; border: none; cursor: pointer; font-size: .72rem; font-weight: 700; transition: background .2s; font-family: 'Inter',system-ui,sans-serif; }
.cv-toast-btn-close:hover { background: rgba(255,255,255,.2); color: #fff; }
.cv-toast-progress { position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: rgba(255,255,255,.15); border-radius: 0 0 14px 14px; overflow: hidden; }
.cv-toast-progress-bar { height: 100%; width: 100%; background: #22adb0; transform-origin: left; animation: none; }
#travotech-toast.cv-show .cv-toast-progress-bar { animation: cvCountdown 5s linear forwards; }
@keyframes cvCountdown { from{transform:scaleX(1);}to{transform:scaleX(0);} }
@media(max-width:600px) { #travotech-toast { bottom: 80px; right: 12px; left: 12px; min-width: unset; max-width: unset; } }

/* ═══════════════════════════════════════
   RELATED PRODUCTS
═══════════════════════════════════════ */
.sp-related { margin-top: 32px; padding-top: 36px; border-top: 1.5px solid rgba(34,173,176,.15); }
.sp-related-hdr { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; }
.sp-related-title { font-size: clamp(1.4rem,3vw,2rem); font-weight: 800; letter-spacing: -.02em; line-height: 1.1; margin: 0; display: flex; align-items: center; gap: 8px; }
.sp-related-title .t1 { color: var(--dark,#0e4847); }
.sp-related-title .t2 { color: var(--green,#22adb0); }
.sp-related-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }
.sp-related-grid .p-card { border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; border: 1.5px solid var(--green-light,#e5fbfb); transition: transform .25s, box-shadow .25s; background: #fff; position: relative; box-shadow: none; }
.sp-related-grid .p-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(34,173,176,.12); border-color: var(--green-mid,#b0f4f3); }
.sp-related-grid .p-img-link { display: block; text-decoration: none; flex-shrink: 0; overflow: hidden; }
.sp-related-grid .p-img { position: relative; width: 100%; height: 200px; overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: #f8f8f8; }
.sp-related-grid .p-img img { width: 100%; height: 100%; object-fit: contain; object-position: center; display: block; transition: transform .3s; padding: 8px; box-sizing: border-box; }
.sp-related-grid .p-card:hover .p-img img { transform: scale(1.04); }
.sp-related-grid .p-badge-sale, .sp-related-grid .p-badge-new { position: absolute; top: 8px; left: 8px; font-size: 0.62rem; font-weight: 800; padding: 3px 9px; border-radius: 50px; letter-spacing: .03em; z-index: 2; }
.sp-related-grid .p-badge-sale { background: #ff4757; color: #fff; }
.sp-related-grid .p-badge-new  { background: var(--green,#22adb0); color: #fff; }
.sp-related-grid .p-body { padding: 14px 14px 0; display: flex; flex-direction: column; flex: 1; }
.sp-related-grid .p-card-meta { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-bottom: 5px; }
.sp-related-grid .p-card-cat { font-size: .62rem; font-weight: 800; text-transform: uppercase; letter-spacing: .07em; padding: 2px 8px; border-radius: 50px; line-height: 1.5; white-space: nowrap; text-decoration: none; background: var(--green-light,#e5fbfb); color: var(--green,#22adb0); }
.sp-related-grid .p-card-brand { font-size: .62rem; font-weight: 700; padding: 2px 8px; border-radius: 50px; line-height: 1.5; border: 1.2px solid var(--green-mid,#b0f4f3); white-space: nowrap; opacity: .85; color: var(--text-mid,#22adb0); }
.sp-related-grid .p-name { font-size: clamp(.88rem,1.5vw,1rem); font-weight: 700; line-height: 1.3; margin-bottom: 4px; }
.sp-related-grid .p-name a { text-decoration: none; color: inherit; transition: color .15s; }
.sp-related-grid .p-name a:hover { text-decoration: underline; }
.sp-related-grid .p-price-wrap { display: flex; align-items: center; gap: 8px; margin: 5px 0 10px; flex-wrap: wrap; }
.sp-related-grid .p-price-old  { font-size: .72rem; text-decoration: line-through; opacity: .45; }
.sp-related-grid .p-price-cur  { font-size: clamp(.88rem,1.5vw,1rem); font-weight: 700; color: var(--green,#22adb0); }
.sp-related-grid .p-btns { display: flex; flex-direction: column; gap: 6px; margin-top: auto; padding: 8px 10px 10px; }
.sp-related-grid .p-btn-cart, .sp-related-grid .p-btn-wa { display: flex; align-items: center; gap: 8px; width: 100%; padding: 8px 10px; font-size: .7rem; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: .02em; border-radius: 8px; border: none; cursor: pointer; transition: opacity .18s, transform .15s; box-sizing: border-box; white-space: nowrap; font-family: 'Inter',system-ui,sans-serif; }
.sp-related-grid .p-btn-cart:hover, .sp-related-grid .p-btn-wa:hover { opacity: .88; transform: translateY(-1px); }
.sp-related-grid .p-btn-ico { width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.sp-related-grid .p-btn-cart { background: #fff; color: var(--dark,#0e4847); border: 1.5px solid rgba(0,0,0,.08) !important; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
.sp-related-grid .p-btn-cart .p-btn-ico { background: var(--green,#22adb0); color: #fff; }
.sp-related-grid .p-btn-cart:hover { background: var(--green,#22adb0); color: #fff; border-color: var(--green,#22adb0) !important; }
.sp-related-grid .p-btn-cart:hover .p-btn-ico { background: rgba(255,255,255,.25); }
.sp-related-grid .p-btn-wa { background: var(--green,#22adb0); color: #fff; box-shadow: 0 2px 8px rgba(34,173,176,.25); }
.sp-related-grid .p-btn-wa .p-btn-ico { background: rgba(255,255,255,.2); color: #fff; }
.sp-rel-pagination { display: flex; gap: 6px; justify-content: center; align-items: center; margin-top: 28px; flex-wrap: wrap; }
.sp-rel-page-btn { width: 36px; height: 36px; border-radius:14px !important; display: flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 700; text-decoration: none; border: 1.5px solid rgba(0,0,0,.12); color: var(--text-mid,#22adb0); transition: background .15s, color .15s, border-color .15s, transform .15s; }
.sp-rel-page-btn:hover { background: var(--green,#22adb0); color: #fff; border-color: var(--green,#22adb0); transform: scale(1.08); }
.sp-rel-page-btn.active { background: var(--green,#22adb0); color: #fff; border-color: var(--green,#22adb0); box-shadow: 0 4px 14px rgba(34,173,176,.35); }
.sp-rel-page-btn.dots { border: none; background: none; pointer-events: none; width: auto; letter-spacing: .1em; }
.sp-rel-page-btn.prev, .sp-rel-page-btn.next { width: auto; padding: 0 12px; border-radius: 8px; gap: 4px; font-size: .78rem; }

/* Responsive */
@media(max-width:960px) { .sp-wrap { padding: 20px 24px 48px; } .sp-gallery { flex: 0 0 340px; max-width: 340px; } .sp-info { padding: 24px 24px 24px 0; gap: 12px; } .sp-related-grid { grid-template-columns: repeat(3,1fr); } }
@media(max-width:760px) { .sp-related-grid { grid-template-columns: repeat(2,1fr); gap: 12px; } .sp-related-grid .p-img { height: 160px; } .sp-related-grid .p-btn-cart, .sp-related-grid .p-btn-wa { font-size: .62rem; padding: 7px 8px; gap: 5px; } .sp-related-grid .p-btn-ico { width: 20px; height: 20px; } }
@media(max-width:700px) { .sp-wrap { padding: 12px 14px 40px; } .sp-card { flex-direction: column; gap: 0; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,.08); } .sp-gallery { flex: none; max-width: 100%; width: 100%; min-height: 240px; border-radius: 16px 16px 0 0; padding: 16px; } .sp-gallery img { max-height: 260px; } .sp-info { padding: 20px 18px 24px; gap: 10px; } .sp-title { font-size: clamp(1.1rem,5vw,1.4rem); } .sp-price-cur { font-size: clamp(1.1rem,5vw,1.4rem); } .sp-wa-btn { padding: 11px 14px; gap: 8px; } .woocommerce-tabs .wc-tabs li a { padding: 10px 14px !important; } .sp-related-title { font-size: clamp(1.2rem,6vw,1.6rem); } }
@media(max-width:480px) { .sp-related-grid { grid-template-columns: repeat(2,1fr); gap: 8px; } .sp-wa-btn { padding: 10px 12px; gap: 6px; } }
@media(max-width:400px) { .sp-info { padding: 16px 14px 20px; } .sp-gallery { min-height: 200px; } .sp-gallery img { max-height: 200px; } .sp-meta-card { padding: 10px; gap: 6px; } .sp-meta-badge { font-size: 0.7rem; padding: 4px 9px; } .sp-related-grid { grid-template-columns: 1fr; } }

/* ---- spx-v1: product page fonts, tabs, reviews ---- */
.sp-wrap{font-family:var(--th-fb,'Inter',system-ui,sans-serif);color:#183332;}
.sp-wrap h1,.sp-wrap h2,.sp-wrap h3,.sp-title,.sp-price-cur,.sp-related-title,.sp-related-grid .p-name{font-family:var(--th-fh,'Oswald','Arial Narrow',sans-serif);color:var(--th-dk,#093c3c);letter-spacing:.01em;}
.sp-title{font-weight:600;}
.sp-price-cur,.sp-related-grid .p-price-cur{color:var(--th-g,#22adb0);font-weight:600;}
.sp-wrap .sp-wa-btn,.sp-wrap .sp-atc-btn,.sp-wrap .p-btn-cart,.sp-wrap .p-btn-wa,.sp-wrap .sp-actions .single_add_to_cart_button{font-family:var(--th-fh,'Oswald',sans-serif) !important;font-weight:600;letter-spacing:.04em;border-radius:8px !important;}
.sp-wrap .sp-wa-btn{background:#25D366;box-shadow:none;}
.sp-wrap .sp-atc-btn{background:var(--th-g,#22adb0);box-shadow:none;}
.sp-wrap .sp-atc-btn:hover{background:var(--th-dk,#093c3c);opacity:1;}
.sp-wrap .sp-atc-btn .atc-spinner{border-radius:50% !important;}
.sp-wrap .sp-qty-wrap,.sp-wrap .sp-card,.sp-wrap .sp-gallery{border-radius:10px;}
.sp-wrap .sp-meta-badge{border-radius:6px;}
.sp-wrap .sp-rel-page-btn{border-radius:8px !important;}

.spx-tabs{background:#fff;border:1px solid #d7f0f0;border-radius:10px;box-shadow:0 2px 10px rgba(9,60,60,.06);overflow:hidden;}
.spx-tablist{display:flex;gap:4px;flex-wrap:wrap;background:#f1fafa;padding:8px 8px 0;border-bottom:2px solid #d7f0f0;}
.spx-tab{border:0;background:transparent;padding:12px 22px;font:600 14px var(--th-fh,'Oswald',sans-serif);letter-spacing:.05em;text-transform:uppercase;color:var(--th-dk,#093c3c);cursor:pointer;border-radius:8px 8px 0 0;}
.spx-tab:hover{background:#fff;}
.spx-tab.on{background:var(--th-g,#22adb0);color:#fff;}
.spx-panel{display:none;padding:clamp(16px,3vw,28px);font-size:.95rem;line-height:1.75;color:#1d4847;}
.spx-panel.on{display:block;}
.spx-panel p{margin:0 0 12px;}
.spx-spec{width:100%;border-collapse:collapse;}
.spx-spec th,.spx-spec td{padding:12px 14px;border-bottom:1px solid #e0f2f2;text-align:left;font-size:.92rem;}
.spx-spec th{width:34%;font-weight:600;color:var(--th-dk,#093c3c);background:#f9fefe;}
.spx-stars{display:inline-flex;gap:3px;color:var(--th-g,#22adb0);font-size:.9rem;}
.spx-stars .off{color:#cfe3e2;}
.spx-rev-top{margin-bottom:18px;}
.spx-rev-score{display:flex;align-items:center;gap:12px;flex-wrap:wrap;}
.spx-rev-score b{font:600 2.2rem var(--th-fh,'Oswald',sans-serif);color:var(--th-dk,#093c3c);line-height:1;}
.spx-rev-score small{color:#6b7280;}
.spx-rev-list{display:grid;gap:12px;margin-bottom:26px;}
.spx-rev{display:flex;gap:14px;align-items:flex-start;border:1px solid #d7f0f0;border-radius:10px;padding:16px;background:#fff;}
.spx-av{width:44px;height:44px;border-radius:50%;background:var(--th-g,#22adb0);color:#fff;display:flex;align-items:center;justify-content:center;font:600 1.1rem var(--th-fh,'Oswald',sans-serif);flex-shrink:0;}
.spx-rev-b{flex:1;min-width:0;}
.spx-rev-h{display:flex;gap:10px;align-items:baseline;flex-wrap:wrap;margin-bottom:4px;}
.spx-rev-h strong{color:var(--th-dk,#093c3c);}
.spx-rev-h span{font-size:.8rem;color:#6b7280;}
.spx-rev-b p{margin:6px 0 0;}
.spx-empty{background:#e6fafa;border-left:4px solid var(--th-g,#22adb0);border-radius:6px;padding:12px 14px;margin:0;}
.spx-form{background:#f9fefe;border:1px solid #d7f0f0;border-radius:10px;padding:clamp(16px,3vw,26px);display:grid;gap:14px;}
.spx-form h3{font:600 1.3rem var(--th-fh,'Oswald',sans-serif);margin:0;}
.spx-f label{display:block;font-size:.88rem;font-weight:600;color:var(--th-dk,#093c3c);margin-bottom:6px;}
.spx-f .req{color:var(--th-red,#e53935);}
.spx-f input[type="text"],.spx-f input[type="email"],.spx-f textarea{width:100%;box-sizing:border-box;border:1.5px solid #c9d3cd;border-radius:8px;background:#fff;padding:0 14px;height:50px;font:500 15px var(--th-fb,'Inter',sans-serif);color:var(--th-dk,#093c3c);outline:none;}
.spx-f textarea{height:auto;min-height:130px;padding:12px 14px;resize:vertical;}
.spx-f input:focus,.spx-f textarea:focus{border-color:var(--th-g,#22adb0);box-shadow:0 0 0 3px rgba(34,173,176,.12);}
.spx-two{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.spx-rate{display:inline-flex;flex-direction:row-reverse;gap:4px;position:relative;}
.spx-rate input{position:absolute;opacity:0;width:0;height:0;}
.spx-rate label{margin:0;font-size:1.7rem;color:#cfe3e2;cursor:pointer;line-height:1;transition:color .15s;}
.spx-rate input:checked~label,.spx-rate label:hover,.spx-rate label:hover~label{color:var(--th-g,#22adb0);}
.spx-rate input:focus-visible+label{outline:2px solid var(--th-red,#e53935);outline-offset:2px;border-radius:4px;}
.spx-submit{justify-self:start;min-height:50px;padding:0 30px;border:0;border-radius:8px;background:var(--th-g,#22adb0);color:#fff;font:600 14px var(--th-fh,'Oswald',sans-serif);letter-spacing:.05em;text-transform:uppercase;cursor:pointer;transition:background .2s;}
.spx-submit:hover{background:var(--th-dk,#093c3c);}
.spx-note{margin:0;font-size:.8rem;color:#6b7280;}
@media (max-width:600px){
  .spx-tab{padding:10px 14px;font-size:13px;}
  .spx-two{grid-template-columns:1fr;}
  .spx-spec th{width:42%;}
  .spx-submit{width:100%;justify-self:stretch;}
}
/* ---- spx-atc-v1: green WhatsApp buttons + animated add to cart ---- */
html body .sp-wrap .sp-wa-btn,
html body .sp-wrap .sp-wa-btn:hover,
html body .sp-wrap .sp-wa-btn:focus,
html body .sp-wrap .sp-wa-btn:active,
html body .sp-wrap .sp-related-grid .p-btn-wa,
html body .sp-wrap .sp-related-grid .p-btn-wa:hover,
html body .sp-wrap .sp-related-grid .p-btn-wa:focus{background:#25D366 !important;background-color:#25D366 !important;border-color:#25D366 !important;color:#fff !important;box-shadow:none !important;opacity:1 !important;}
html body .sp-wrap .sp-atc-btn.atc-loading,
html body .sp-wrap .p-btn-cart.atc-loading{opacity:.75;pointer-events:none;}
html body .sp-wrap .sp-atc-btn.atc-loading .atc-spinner{display:block;border-radius:50% !important;}
html body .sp-wrap .sp-atc-btn.atc-done{background:#093c3c !important;opacity:1;}
html body .sp-wrap .p-btn-cart.atc-done{background:#093c3c !important;color:#fff !important;border-color:#093c3c !important;}
html body .sp-wrap .atc-done .t{animation:spxPop .35s ease;}
@keyframes spxPop{0%{transform:scale(.85);opacity:.4;}100%{transform:scale(1);opacity:1;}}
</style>

<!-- TOAST -->
<div id="travotech-toast" role="alert" aria-live="assertive">
  <div class="cv-toast-icon-wrap">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
  </div>
  <div class="cv-toast-body">
    <div class="cv-toast-title">Added to Cart</div>
    <div class="cv-toast-name" id="cv-toast-name"><?php echo esc_html($travotech_toast_name); ?></div>
    <div class="cv-toast-actions">
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cv-toast-btn-cart">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
        View Cart
      </a>
      <button class="cv-toast-btn-close" id="cv-toast-close" type="button">Dismiss</button>
    </div>
  </div>
  <div class="cv-toast-progress"><div class="cv-toast-progress-bar" id="cv-toast-bar"></div></div>
</div>

<div class="sp-wrap">
  <div class="sp-card">

    <!-- IMAGE -->
    <div class="sp-gallery">
      <?php if ($img): ?>
        <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>">
      <?php else: ?>
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".2"><path d="M10.5 3.5a6 6 0 018 8l-8.5 8.5a6 6 0 01-8-8l8.5-8.5z"/><line x1="9" y1="15" x2="15" y2="9"/></svg>
      <?php endif; ?>
    </div>

    <!-- INFO -->
    <div class="sp-info">
      <h1 class="sp-title"><?php the_title(); ?></h1>

      <!-- Live price (updates as qty changes) -->
      <div class="sp-price-wrap">
        <div class="sp-price-cur" id="sp-live-price">KES <?php echo number_format($price_c, 2); ?></div>
        <?php if ($sale && $price_r): ?>
          <div class="sp-price-old">KES <?php echo number_format($price_r, 2); ?></div>
        <?php endif; ?>
      </div>

      <?php $short_desc = $product->get_short_description() ?: $product->get_description(); if ($short_desc): ?>
      <div class="sp-desc"><?php echo wp_kses_post(wp_trim_words($short_desc, 40)); ?></div>
      <?php endif; ?>

      <div class="sp-meta-card">
        <?php if ($cat_n): ?>
        <div class="sp-meta-badge sp-meta-cat">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
          <?php echo esc_html($cat_n); ?>
        </div>
        <?php endif; ?>
        <div class="sp-meta-badge sp-meta-stock <?php echo $stock==='instock'?'instock':'outofstock'; ?>">
          <?php if ($stock==='instock'): ?>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>In Stock
          <?php else: ?>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Out of Stock
          <?php endif; ?>
        </div>
        <?php if ($sku): ?>
        <div class="sp-meta-badge sp-meta-sku">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3l-4 4-4-4"/></svg>
          SKU: <?php echo esc_html($sku); ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="sp-actions">

        <?php if ($is_simple): ?>
        <!-- QTY STEPPER -->
        <div class="sp-qty-row">
          <span class="sp-qty-label">Qty:</span>
          <div class="sp-qty-wrap">
            <button type="button" class="sp-qty-btn" id="sp-qty-minus" aria-label="Decrease">&#8722;</button>
            <input type="number" id="sp-qty-input"
              value="1" min="1" max="<?php echo esc_attr($max_qty); ?>" step="1"
              data-unit-price="<?php echo esc_attr($price_c); ?>"
              aria-label="Quantity">
            <button type="button" class="sp-qty-btn" id="sp-qty-plus" aria-label="Increase">&#43;</button>
          </div>
        </div>
        <?php endif; ?>

        <!-- WhatsApp — JS builds the message dynamically with current qty/price -->
        <button type="button" class="sp-wa-btn" id="sp-wa-btn"
          data-wa="<?php echo esc_attr($wa); ?>"
          data-name="<?php echo esc_attr($name); ?>"
          data-price="<?php echo esc_attr($price_c); ?>"
          data-url="<?php echo esc_attr(get_permalink()); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Buy Via WhatsApp
        </button>

        <?php if ($is_simple): ?>
        <!-- Silent ATC button -->
        <button type="button" class="sp-atc-btn" id="sp-main-atc"
          data-pid="<?php echo esc_attr($pid); ?>"
          data-nonce="<?php echo esc_attr($wc_ajax_nonce); ?>"
          data-name="<?php echo esc_attr(mb_strlen($name)>30?mb_substr($name,0,30).'…':$name); ?>"
          data-price="<?php echo esc_attr($price_c); ?>"
          data-fullname="<?php echo esc_attr($name); ?>">
          <span class="atc-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
          </span>
          <div class="atc-spinner"></div><span class="t">Add to Cart</span></button>
        <?php else: ?>
        <?php woocommerce_template_single_add_to_cart(); ?>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <!-- TABS -->
  <div class="sp-tabs-section">
    <?php
$spx_desc  = $product->get_description();
$spx_attrs = array();
foreach ( $product->get_attributes() as $a ) {
  if ( ! is_object( $a ) || ! $a->get_visible() ) { continue; }
  $v = $product->get_attribute( $a->get_name() );
  if ( $v !== '' ) { $spx_attrs[ wc_attribute_label( $a->get_name() ) ] = $v; }
}
if ( $product->get_weight() ) { $spx_attrs['Weight'] = $product->get_weight() . ' ' . get_option( 'woocommerce_weight_unit' ); }
if ( $product->has_dimensions() ) { $spx_attrs['Dimensions'] = wc_format_dimensions( $product->get_dimensions( false ) ); }
$spx_reviews = get_comments( array( 'post_id' => $pid, 'status' => 'approve', 'type__in' => array( 'review', 'comment' ), 'parent' => 0, 'order' => 'DESC' ) );
$spx_count   = count( $spx_reviews );
$spx_sum = 0; $spx_n = 0;
foreach ( $spx_reviews as $rv ) { $rt = (int) get_comment_meta( $rv->comment_ID, 'rating', true ); if ( $rt > 0 ) { $spx_sum += $rt; $spx_n++; } }
$spx_avg  = $spx_n ? $spx_sum / $spx_n : 0;
$spx_star = function ( $n ) { $o = ''; for ( $i = 1; $i <= 5; $i++ ) { $o .= '<i class="fa-solid fa-star' . ( $i <= round( $n ) ? '' : ' off' ) . '" aria-hidden="true"></i>'; } return $o; };
?>
<div class="spx-tabs" id="spx-tabs">
  <div class="spx-tablist" role="tablist">
    <button type="button" class="spx-tab on" data-t="desc">Description</button>
    <?php if ( $spx_attrs ) : ?><button type="button" class="spx-tab" data-t="spec">Specifications</button><?php endif; ?>
    <button type="button" class="spx-tab" data-t="rev" id="spx-tab-rev">Reviews (<?php echo (int) $spx_count; ?>)</button>
  </div>

  <div class="spx-panel on" id="spx-p-desc">
    <?php echo $spx_desc ? wp_kses_post( wpautop( $spx_desc ) ) : '<p>No description yet. Message us on WhatsApp for full product details.</p>'; ?>
  </div>

  <?php if ( $spx_attrs ) : ?>
  <div class="spx-panel" id="spx-p-spec">
    <table class="spx-spec"><tbody>
      <?php foreach ( $spx_attrs as $k => $v ) : ?>
      <tr><th><?php echo esc_html( $k ); ?></th><td><?php echo esc_html( $v ); ?></td></tr>
      <?php endforeach; ?>
    </tbody></table>
  </div>
  <?php endif; ?>

  <div class="spx-panel" id="spx-p-rev">
    <div class="spx-rev-top">
      <div class="spx-rev-score">
        <b><?php echo $spx_n ? number_format( $spx_avg, 1 ) : '0.0'; ?></b>
        <span class="spx-stars"><?php echo $spx_star( $spx_avg ); // phpcs:ignore ?></span>
        <small><?php echo (int) $spx_count; ?> review<?php echo $spx_count === 1 ? '' : 's'; ?></small>
      </div>
    </div>

    <div class="spx-rev-list">
      <?php if ( $spx_reviews ) : foreach ( $spx_reviews as $rv ) :
        $rt = (int) get_comment_meta( $rv->comment_ID, 'rating', true ); ?>
      <article class="spx-rev">
        <div class="spx-av"><?php echo esc_html( mb_strtoupper( mb_substr( trim( $rv->comment_author ) ?: 'C', 0, 1 ) ) ); ?></div>
        <div class="spx-rev-b">
          <div class="spx-rev-h">
            <strong><?php echo esc_html( $rv->comment_author ?: 'Customer' ); ?></strong>
            <span><?php echo esc_html( mysql2date( 'j M Y', $rv->comment_date ) ); ?></span>
          </div>
          <?php if ( $rt ) : ?><div class="spx-stars"><?php echo $spx_star( $rt ); // phpcs:ignore ?></div><?php endif; ?>
          <p><?php echo esc_html( $rv->comment_content ); ?></p>
        </div>
      </article>
      <?php endforeach; else : ?>
      <p class="spx-empty">No reviews yet. Be the first to review this product.</p>
      <?php endif; ?>
    </div>

    <?php if ( comments_open( $pid ) ) : ?>
    <form class="spx-form" action="<?php echo esc_url( site_url( '/wp-comments-post.php' ) ); ?>" method="post">
      <h3>Write a review</h3>
      <div class="spx-f">
        <label>Your rating</label>
        <div class="spx-rate">
          <?php for ( $i = 5; $i >= 1; $i-- ) : ?><input type="radio" name="rating" id="spx-r<?php echo $i; ?>" value="<?php echo $i; ?>"><label for="spx-r<?php echo $i; ?>" title="<?php echo $i; ?> stars"><i class="fa-solid fa-star" aria-hidden="true"></i></label><?php endfor; ?>
        </div>
      </div>
      <div class="spx-f">
        <label for="spx-comment">Your review <span class="req">*</span></label>
        <textarea id="spx-comment" name="comment" rows="5" required placeholder="Tell us what you think about this product"></textarea>
      </div>
      <?php if ( ! is_user_logged_in() ) : ?>
      <div class="spx-two">
        <div class="spx-f"><label for="spx-author">Name <span class="req">*</span></label><input type="text" id="spx-author" name="author" required placeholder="Your name"></div>
        <div class="spx-f"><label for="spx-email">Email <span class="req">*</span></label><input type="email" id="spx-email" name="email" required placeholder="your@email.com"></div>
      </div>
      <?php endif; ?>
      <input type="hidden" name="comment_post_ID" value="<?php echo (int) $pid; ?>">
      <input type="hidden" name="comment_parent" value="0">
      <button type="submit" class="spx-submit">Submit review</button>
      <p class="spx-note">Reviews appear after our team approves them.</p>
    </form>
    <?php endif; ?>
  </div>
</div>
  </div>

  <!-- RELATED PRODUCTS -->
  <?php if (!empty($paged_related)): ?>
  <div class="sp-related">
    <div class="sp-related-hdr">
      <h2 class="sp-related-title">
        <span class="t1">Related</span>
        <span class="t2">Products</span>
      </h2>
      <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="trending-viewall">
        View All
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>
    <div class="sp-related-grid">
      <?php foreach ($paged_related as $rid):
        $rp       = wc_get_product($rid);
        if (!$rp) continue;
        $rimg     = get_the_post_thumbnail_url($rid,'woocommerce_thumbnail');
        $rpc      = $rp->get_price();
        $rpr      = $rp->get_regular_price();
        $rsale    = $rp->is_on_sale();
        $ris_new  = (time() - strtotime($rp->get_date_created())) < (30*DAY_IN_SECONDS);
        $rsimp    = $rp->is_type('simple');
        $rcats    = get_the_terms($rid,'product_cat');
        $rcat_n   = ($rcats&&!is_wp_error($rcats))?$rcats[0]->name:'';
        $rcat_lnk = ($rcats&&!is_wp_error($rcats))?get_term_link($rcats[0]):'#';
        $rbrands  = get_the_terms($rid,'product_brand');
        if (!$rbrands||is_wp_error($rbrands)) $rbrands = get_the_terms($rid,'pa_brand');
        $rbrand_n = ($rbrands&&!is_wp_error($rbrands))?$rbrands[0]->name:'';
        $rwa_msg  = urlencode("Hello! I'd like to order: *".$rp->get_name()."* — KES {$rpc}. ".get_permalink($rid));
        $rname_s  = mb_strlen($rp->get_name())>30?mb_substr($rp->get_name(),0,30).'…':$rp->get_name();
      ?>
      <div class="p-card">
        <a href="<?php echo get_permalink($rid); ?>" class="p-img-link">
          <div class="p-img">
            <?php if ($rimg): ?><img src="<?php echo esc_url($rimg); ?>" alt="<?php echo esc_attr($rp->get_name()); ?>" loading="lazy">
            <?php else: ?><svg style="width:48px;height:48px;opacity:.2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M10.5 3.5a6 6 0 018 8l-8.5 8.5a6 6 0 01-8-8l8.5-8.5z"/></svg><?php endif; ?>
            <?php if ($rsale&&$rpr): ?><div class="p-badge-sale">-<?php echo round((($rpr-$rpc)/$rpr)*100); ?>% OFF</div>
            <?php elseif ($ris_new): ?><div class="p-badge-new">NEW</div><?php endif; ?>
          </div>
        </a>
        <div class="p-body">
          <?php if ($rcat_n||$rbrand_n): ?>
          <div class="p-card-meta">
            <?php if ($rcat_n): ?><a href="<?php echo esc_url($rcat_lnk); ?>" class="p-card-cat"><?php echo esc_html($rcat_n); ?></a><?php endif; ?>
            <?php if ($rbrand_n): ?><span class="p-card-brand"><?php echo esc_html($rbrand_n); ?></span><?php endif; ?>
          </div>
          <?php endif; ?>
          <div class="p-name"><a href="<?php echo get_permalink($rid); ?>"><?php echo esc_html($rp->get_name()); ?></a></div>
          <div class="p-price-wrap">
            <?php if ($rsale&&$rpr): ?><div class="p-price-old">KES <?php echo number_format($rpr,2); ?></div><?php endif; ?>
            <div class="p-price-cur">KES <?php echo number_format($rpc,2); ?></div>
          </div>
          <div class="p-btns">
            <?php if ($rsimp): ?>
            <button type="button" class="p-btn-cart travotech-rel-atc"
              data-pid="<?php echo esc_attr($rid); ?>"
              data-nonce="<?php echo esc_attr(wp_create_nonce('woocommerce-add-to-cart')); ?>"
              data-name="<?php echo esc_attr($rname_s); ?>">
              <span class="p-btn-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg></span><span class="t">Add to Cart</span></button>
            <?php else: ?>
            <a href="<?php echo get_permalink($rid); ?>" class="p-btn-cart">
              <span class="p-btn-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg></span>
              Select Options
            </a>
            <?php endif; ?>
            <a href="https://wa.me/<?php echo esc_attr($wa); ?>?text=<?php echo $rwa_msg; ?>" class="p-btn-wa" target="_blank" rel="noopener noreferrer">
              <span class="p-btn-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></span>
              Buy Via WhatsApp
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if ($total_rel_pages > 1): $base_url = get_permalink($pid); ?>
    <div class="sp-rel-pagination">
      <?php if ($related_page > 1): ?>
        <a href="<?php echo esc_url(add_query_arg('rel_page',$related_page-1,$base_url)); ?>#sp-related-anchor" class="sp-rel-page-btn prev">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>PREV
        </a>
      <?php endif; ?>
      <?php
      $show=[]; $delta=2;
      for($i=1;$i<=$total_rel_pages;$i++){
        if($i==1||$i==$total_rel_pages||abs($i-$related_page)<=$delta) $show[]=$i;
      }
      $show=array_unique($show); sort($show); $prev_pg=0;
      foreach($show as $pg):
        if($prev_pg && $pg-$prev_pg>1): ?><span class="sp-rel-page-btn dots">…</span><?php endif; ?>
        <a href="<?php echo esc_url(add_query_arg('rel_page',$pg,$base_url)); ?>#sp-related-anchor"
           class="sp-rel-page-btn <?php echo $pg===$related_page?'active':''; ?>"><?php echo $pg; ?></a>
      <?php $prev_pg=$pg; endforeach; ?>
      <?php if ($related_page < $total_rel_pages): ?>
        <a href="<?php echo esc_url(add_query_arg('rel_page',$related_page+1,$base_url)); ?>#sp-related-anchor" class="sp-rel-page-btn next">
          NEXT<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <div id="sp-related-anchor" style="position:relative;top:-80px;"></div>
  <?php endif; ?>

</div>

<script>
(function(){

  /* ════════════════════════════════════
     TOAST
  ════════════════════════════════════ */
  var toast    = document.getElementById('travotech-toast');
  var toastNm  = document.getElementById('cv-toast-name');
  var toastBar = document.getElementById('cv-toast-bar');
  var closeBtn = document.getElementById('cv-toast-close');
  var hideTimer = null;

  function showToast(name) {
    if (!toast) return;
    if (toastNm && name) toastNm.textContent = name;
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

  /* Show on first load if legacy query param present */
  var TOAST_PID = <?php echo intval($travotech_toast_pid); ?>;
  if (TOAST_PID > 0) {
    document.addEventListener('DOMContentLoaded', function(){
      showToast(null);
      if (window.history && window.history.replaceState) {
        var clean = window.location.pathname +
          (window.location.search
            .replace(/[?&]travotech_added=[^&]*/g,'')
            .replace(/[?&]travotech_scroll=[^&]*/g,'')
            .replace(/^&/,'?') || '');
        window.history.replaceState(null, '', clean);
      }
    });
  }

  /* ════════════════════════════════════
     QTY STEPPER — live price, no reload
  ════════════════════════════════════ */
  var qtyInput  = document.getElementById('sp-qty-input');
  var minusBtn  = document.getElementById('sp-qty-minus');
  var plusBtn   = document.getElementById('sp-qty-plus');
  var priceEl   = document.getElementById('sp-live-price');
  var unitPrice = qtyInput ? (parseFloat(qtyInput.getAttribute('data-unit-price')) || 0) : 0;
  var maxQty    = qtyInput ? (parseInt(qtyInput.getAttribute('max')) || 9999) : 9999;

  function fmt(n) {
    return n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }

  function updateLivePrice() {
    if (!priceEl || !qtyInput) return;
    var qty = Math.max(1, parseInt(qtyInput.value) || 1);
    priceEl.textContent = 'KES ' + fmt(unitPrice * qty);
    priceEl.classList.remove('bump');
    void priceEl.offsetWidth;
    priceEl.classList.add('bump');
    setTimeout(function(){ priceEl.classList.remove('bump'); }, 200);
  }

  function refreshBtns() {
    if (!qtyInput) return;
    var v = parseInt(qtyInput.value) || 1;
    if (minusBtn) minusBtn.disabled = (v <= 1);
    if (plusBtn)  plusBtn.disabled  = (v >= maxQty);
  }

  if (minusBtn) {
    minusBtn.addEventListener('click', function(){
      var v = parseInt(qtyInput.value) || 1;
      if (v > 1) { qtyInput.value = v - 1; updateLivePrice(); refreshBtns(); }
    });
  }
  if (plusBtn) {
    plusBtn.addEventListener('click', function(){
      var v = parseInt(qtyInput.value) || 1;
      if (v < maxQty) { qtyInput.value = v + 1; updateLivePrice(); refreshBtns(); }
    });
  }
  if (qtyInput) {
    qtyInput.addEventListener('input', function(){
      var v = parseInt(qtyInput.value) || 1;
      if (v < 1)      { qtyInput.value = 1;      v = 1; }
      if (v > maxQty) { qtyInput.value = maxQty; v = maxQty; }
      updateLivePrice();
      refreshBtns();
    });
    refreshBtns();
  }

  var CART_URL  = '<?php echo esc_js(wc_get_cart_url()); ?>';
  var PERMALINK = '<?php echo esc_js(get_permalink()); ?>';

  /* ════════════════════════════════════
     ADD TO CART — reload page, no scroll
     Save scroll Y + product name to
     sessionStorage before navigating.
     On reload: restore scroll before
     first paint, then show toast.
  ════════════════════════════════════ */

  /* On page load: check if we just did an ATC reload */
  (function restoreAfterATC(){
    var savedY = sessionStorage.getItem('cv_scroll_y');
    var tname  = sessionStorage.getItem('cv_toast_name');
    if (savedY === null) return;           /* normal load — do nothing */

    var y = parseInt(savedY) || 0;
    sessionStorage.removeItem('cv_scroll_y');
    sessionStorage.removeItem('cv_toast_name');

    /* Suppress scroll instantly */
    document.documentElement.scrollTop = y;
    document.body.scrollTop            = y;

    /* Also lock it after DOMContentLoaded + load (browser tries to scroll) */
    function lock(){ document.documentElement.scrollTop = y; document.body.scrollTop = y; }
    document.addEventListener('DOMContentLoaded', function(){ lock(); if (tname) showToast(tname); });
    window.addEventListener('load', lock);
    /* Belt-and-suspenders: keep locking for first 800ms */
    var lockTimer = setInterval(lock, 16);
    setTimeout(function(){ clearInterval(lockTimer); }, 800);
  })();

  /* ── Main product ATC button ── */
  var mainBtn = document.getElementById('sp-main-atc');
  if (mainBtn) {
    mainBtn.addEventListener('click', function(){
      var qty  = qtyInput ? Math.max(1, parseInt(qtyInput.value) || 1) : 1;
      var pid  = mainBtn.getAttribute('data-pid');
      var name = mainBtn.getAttribute('data-name');

      /* Save scroll + toast info before reload */
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
      sessionStorage.setItem('cv_scroll_y',   scrollY);
      sessionStorage.setItem('cv_toast_name', name);

      /* WC native add-to-cart: redirect back to this product page */
      window.location.href = PERMALINK
        + (PERMALINK.indexOf('?') > -1 ? '&' : '?')
        + 'add-to-cart=' + encodeURIComponent(pid)
        + '&quantity='   + encodeURIComponent(qty);
    });
  }

  /* ── WhatsApp button — builds message from live qty/price ── */
  var waBtn = document.getElementById('sp-wa-btn');
  if (waBtn) {
    waBtn.addEventListener('click', function(){
      var waNum    = waBtn.getAttribute('data-wa');
      var pname    = waBtn.getAttribute('data-name');
      var unitP    = parseFloat(waBtn.getAttribute('data-price')) || 0;
      var purl     = waBtn.getAttribute('data-url');
      var qty      = qtyInput ? Math.max(1, parseInt(qtyInput.value) || 1) : 1;
      var total    = unitP * qty;

      var msg = 'Hello Travotech Agencies,\n\n'
              + 'ORDER REQUEST\n'
              + '============================\n\n'
              + 'PRODUCT DETAILS:\n'
              + 'Product : ' + pname + '\n'
              + 'Unit Price: KES ' + fmt(unitP) + '\n'
              + 'Quantity  : ' + qty + '\n'
              + 'Total     : KES ' + fmt(total) + '\n'
              + '----------------------------\n'
              + purl + '\n\n'
              + 'Please confirm availability. Thank you.';

      window.open('https://wa.me/' + waNum + '?text=' + encodeURIComponent(msg), '_blank', 'noopener,noreferrer');
    });
  }

  /* ── Related product ATC buttons (qty always 1) ── */
  document.querySelectorAll('.travotech-rel-atc').forEach(function(btn){
    btn.addEventListener('click', function(){
      /* Quick icon pulse for feedback */
      var ico = btn.querySelector('.p-btn-ico');
      if (ico) {
        var origBg = ico.style.background;
        ico.style.background = '#22adb0';
        setTimeout(function(){ ico.style.background = origBg; }, 600);
      }
      silentATC(
        btn.getAttribute('data-pid'),
        1,
        btn.getAttribute('data-nonce'),
        btn.getAttribute('data-name'),
        null
      );
    });
  });

})();
</script>

<script>
(function(){
  /* tabs */
  var tabs=document.querySelectorAll('.spx-tab');
  function openTab(t){
    tabs.forEach(function(b){b.classList.toggle('on',b.getAttribute('data-t')===t);});
    document.querySelectorAll('.spx-panel').forEach(function(p){p.classList.toggle('on',p.id==='spx-p-'+t);});
  }
  tabs.forEach(function(b){b.addEventListener('click',function(){openTab(b.getAttribute('data-t'));});});
  if(/#comment-|#reviews|#spx-rev/.test(window.location.hash)){openTab('rev');}

  /* related products: add to cart (replaces the missing silentATC) */
  window.silentATC=function(pid,qty,nonce,name){
    try{sessionStorage.setItem('cv_scroll_y',String(window.pageYOffset||document.documentElement.scrollTop||0));sessionStorage.setItem('cv_toast_name',name||'');}catch(e){}
    var u=new URL(window.location.href);
    ['rel_page','add-to-cart','quantity'].forEach(function(k){if(k!=='rel_page')u.searchParams.delete(k);});
    u.searchParams.set('add-to-cart',pid);
    u.searchParams.set('quantity',qty||1);
    window.location.href=u.toString();
  };
})();
</script>
<script>
/* spx-atc-v1: add to cart in the background, no reload, no scroll */
(function(){
  var timer=null;
  function toast(name){
    var t=document.getElementById('travotech-toast');if(!t)return;
    var n=document.getElementById('cv-toast-name');if(n)n.textContent=name||'';
    var bar=document.getElementById('cv-toast-bar');
    if(bar){bar.style.animation='none';void bar.offsetWidth;bar.style.animation='';}
    t.classList.add('cv-show');
    if(timer)clearTimeout(timer);
    timer=setTimeout(function(){t.classList.remove('cv-show');},5000);
  }
  function swapCart(html){
    try{
      var doc=new DOMParser().parseFromString(html,'text/html');
      var fresh=doc.querySelector('.th-cartwrap'),cur=document.querySelector('.th-cartwrap');
      if(!fresh||!cur)return false;
      cur.innerHTML=fresh.innerHTML;
      return true;
    }catch(e){return false;}
  }
  window.addEventListener('click',function(e){
    var btn=e.target.closest?e.target.closest('#sp-main-atc,.travotech-rel-atc'):null;
    if(!btn)return;
    e.preventDefault();e.stopImmediatePropagation();
    if(btn.getAttribute('data-busy'))return;
    var pid=btn.getAttribute('data-pid');if(!pid)return;
    var qi=document.getElementById('sp-qty-input');
    var qty=(btn.id==='sp-main-atc'&&qi)?Math.max(1,parseInt(qi.value,10)||1):1;
    var name=btn.getAttribute('data-name')||'Product';
    var u=new URL(window.location.href);
    ['add-to-cart','added-to-cart','quantity','cv_added_name'].forEach(function(k){u.searchParams.delete(k);});
    u.hash='';
    u.searchParams.set('add-to-cart',pid);
    u.searchParams.set('quantity',qty);
    var t=btn.querySelector('.t'),old=t?t.textContent:'';
    btn.setAttribute('data-busy','1');
    btn.classList.add('atc-loading');
    if(t)t.textContent='Adding...';
    fetch(u.toString(),{credentials:'same-origin',headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){if(!r.ok)throw new Error('http');return r.text();})
    .then(function(html){
      if(!swapCart(html))throw new Error('nocart');
      btn.classList.remove('atc-loading');
      btn.classList.add('atc-done');
      if(t)t.textContent='Added';
      toast(name);
      setTimeout(function(){
        btn.classList.remove('atc-done');
        if(t)t.textContent=old;
        btn.removeAttribute('data-busy');
      },1600);
    })
    .catch(function(){ window.location.href=u.toString(); });
  },true);
})();
</script><?php endwhile; get_footer(); ?>
