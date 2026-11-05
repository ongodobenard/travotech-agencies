<?php
/**
 * Cart Page Template
 * Slug: cart
 */
get_header();
wp_enqueue_style('dashicons');
?>

<style>
/* ════════════════════════════════════════
   HIDE ALL WC NOTICES
════════════════════════════════════════ */
.woocommerce-notices-wrapper,
.woocommerce-message,
.woocommerce-info,
ul.woocommerce-error,
.wc-forward,
body.woocommerce-cart .woocommerce > .woocommerce-notices-wrapper {
  display: none !important;
}

/* ════════════════════════════════════════
   BANNER
════════════════════════════════════════ */
.cart-banner {
  background: linear-gradient(135deg, #2dbebc 0%, #36d0cd 60%, #57d8d6 100%);
  padding: clamp(18px,4vw,40px) clamp(16px,5%,60px);
  position: relative;
  overflow: hidden;
}
.cart-banner::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse at 80% 50%, rgba(255,255,255,.07) 0%, transparent 65%);
}
.cart-banner-inner {
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 8px;
  max-width: 1200px;
  margin: 0 auto;
}
.cart-banner h1 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.1rem, 3vw, 2rem);
  font-weight: 700;
  color: #fff;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 9px;
}
.cart-breadcrumb {
  font-size: clamp(.68rem, 1.8vw, .8rem);
  color: rgba(255,255,255,.78);
  font-weight: 600;
}
.cart-breadcrumb a { color: #fff; text-decoration: underline; }

/* ════════════════════════════════════════
   PAGE WRAP + GRID LAYOUT
════════════════════════════════════════ */
.cart-page-wrap {
  background: #eefcfc;
  padding: clamp(14px, 3vw, 48px) clamp(10px, 4%, 48px);
  min-height: 60vh;
}
.cart-layout {
  display: grid;
  grid-template-columns: 1fr 290px;
  gap: 20px;
  max-width: 1200px;
  margin: 0 auto;
  align-items: start;
}

/* ════════════════════════════════════════
   SHARED CARD
════════════════════════════════════════ */
.cart-card {
  background: #fff;
  border-radius: 14px;
  border: 1.5px solid #b0f4f3;
  box-shadow: 0 4px 20px rgba(54,208,205,.07);
  overflow: hidden;
}
.cart-card-head {
  padding: 13px 16px;
  border-bottom: 2px solid #e5fbfb;
  background: #f9fefe;
  display: flex;
  align-items: center;
  gap: 8px;
}
.cart-card-head .dashicons {
  color: #36d0cd;
  font-size: 17px;
  width: 17px;
  height: 17px;
  flex-shrink: 0;
}
.cart-card-head h2 {
  font-family: 'Nunito', sans-serif;
  font-size: clamp(.8rem, 2vw, .92rem);
  font-weight: 800;
  color: #103837;
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.item-count {
  font-size: .68rem;
  color: #5bd9d7;
  font-weight: 600;
  margin-left: 4px;
}

/* ════════════════════════════════════════
   DESKTOP TABLE
════════════════════════════════════════ */
.cart-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

.cart-table-wrap table.shop_table {
  border: none !important;
  border-collapse: collapse;
  width: 100%;
  margin: 0 !important;
  min-width: 420px;
}
.cart-table-wrap table.shop_table thead tr th {
  background: #f9fefe;
  border-bottom: 2px solid #e5fbfb !important;
  border-top: none !important;
  padding: 10px 10px !important;
  font-size: .62rem;
  font-weight: 800;
  color: #5bd9d7;
  text-transform: uppercase;
  letter-spacing: .07em;
  font-family: 'Nunito', sans-serif;
  white-space: nowrap;
}
.cart-table-wrap table.shop_table tbody tr td {
  border-bottom: 1px solid #e5fbfb !important;
  border-top: none !important;
  padding: 12px 10px !important;
  vertical-align: middle;
  font-size: .84rem;
  color: #2dbebc;
  font-family: 'Nunito', sans-serif;
}
.cart-table-wrap table.shop_table tbody tr:last-child td { border-bottom: none !important; }

/* Image */
.cart-table-wrap .product-thumbnail img {
  width: 48px !important; height: 48px !important;
  min-width: 48px !important; min-height: 48px !important;
  max-width: 48px !important; max-height: 48px !important;
  object-fit: contain !important;
  border-radius: 8px !important;
  border: 1.5px solid #e5fbfb !important;
  background: #f8f8f8 !important;
  padding: 3px !important;
  display: block !important;
}

/* Product name */
.cart-table-wrap .product-name a {
  color: #103837 !important;
  font-weight: 700;
  text-decoration: none;
  font-size: .84rem;
  line-height: 1.35;
}
.cart-table-wrap .product-name a:hover { color: #36d0cd !important; }

/* Price & subtotal */
.cart-table-wrap .product-price .amount,
.cart-table-wrap .product-subtotal .amount {
  font-weight: 800 !important;
  color: #36d0cd !important;
  font-size: .84rem !important;
}

/* Remove */
.cart-table-wrap a.remove {
  color: #e53935 !important;
  font-size: .95rem !important;
  font-weight: 900 !important;
  width: 24px !important; height: 24px !important;
  border-radius: 50% !important;
  background: #fff0f0 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  transition: all .2s !important;
  text-decoration: none !important;
  line-height: 1 !important;
  flex-shrink: 0;
}
.cart-table-wrap a.remove:hover { background: #e53935 !important; color: #fff !important; }

/* ════════════════════════════════════════
   QUANTITY STEPPER
════════════════════════════════════════ */
.qty-wrap {
  display: inline-flex;
  align-items: center;
  border: 2px solid #b0f4f3;
  border-radius: 9px;
  overflow: hidden;
  background: #fff;
  transition: border-color .2s, box-shadow .2s;
}
.qty-wrap:focus-within {
  border-color: #36d0cd;
  box-shadow: 0 0 0 3px rgba(54,208,205,.1);
}
.qty-btn {
  width: 30px;
  height: 34px;
  border: none;
  background: #eefcfc;
  color: #36d0cd;
  font-size: 1.05rem;
  font-weight: 900;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .2s, color .2s;
  flex-shrink: 0;
  padding: 0;
  user-select: none;
  line-height: 1;
}
.qty-btn:hover { background: #36d0cd; color: #fff; }
.qty-btn:active { background: #2dbebc; color: #fff; }
.qty-btn:disabled {
  opacity: .35;
  cursor: not-allowed;
  background: #eefcfc !important;
  color: #b0f4f3 !important;
  pointer-events: all; /* keep pointer-events ON so cursor shows */
}
.qty-btn:disabled:hover {
  background: #eefcfc !important;
  color: #b0f4f3 !important;
  transform: none;
}

.qty-wrap input.qty {
  width: 42px !important;
  height: 34px !important;
  min-width: 42px !important;
  border: none !important;
  border-left: 1.5px solid #b0f4f3 !important;
  border-right: 1.5px solid #b0f4f3 !important;
  border-radius: 0 !important;
  box-shadow: none !important;
  text-align: center;
  font-family: 'Nunito', sans-serif;
  font-size: .84rem;
  font-weight: 700;
  color: #103837;
  background: #fff;
  padding: 0 !important;
  outline: none !important;
  -moz-appearance: textfield;
}
.qty-wrap input.qty::-webkit-outer-spin-button,
.qty-wrap input.qty::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

/* ════════════════════════════════════════
   ACTIONS ROW — desktop only
════════════════════════════════════════ */
.cart-actions-bar {
  padding: 12px 14px;
  border-top: 2px solid #e5fbfb;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 8px;
  background: #f9fefe;
}
.cart-coupon-group {
  display: flex;
  gap: 6px;
  align-items: center;
  flex: 1;
  min-width: 0;
}
.cart-coupon-group input#coupon_code {
  padding: 8px 10px;
  border: 2px solid #b0f4f3;
  border-radius: 8px;
  font-family: 'Nunito', sans-serif;
  font-size: .76rem;
  outline: none;
  width: 120px;
  box-sizing: border-box;
  flex: 1;
  min-width: 80px;
}
.cart-coupon-group input#coupon_code:focus { border-color: #36d0cd; }

.cart-coupon-group button[name="apply_coupon"] {
  background: #eefcfc;
  color: #36d0cd;
  border: 2px solid #36d0cd;
  padding: 8px 12px;
  border-radius: 50px;
  font-family: 'Nunito', sans-serif;
  font-size: .72rem;
  font-weight: 800;
  cursor: pointer;
  transition: all .2s;
  white-space: nowrap;
}
.cart-coupon-group button[name="apply_coupon"]:hover {
  background: #36d0cd; color: #fff;
}

/* Update Cart button — shared style for both desktop & mobile */
button[name="update_cart"] {
  background: #eefcfc !important;
  color: #b0f4f3 !important;
  border: 2px solid #b0f4f3 !important;
  padding: 8px 14px !important;
  border-radius: 50px !important;
  font-family: 'Nunito', sans-serif !important;
  font-size: .72rem !important;
  font-weight: 800 !important;
  cursor: not-allowed !important;
  opacity: .55 !important;
  transition: all .25s !important;
  white-space: nowrap !important;
  pointer-events: none !important;
}
button[name="update_cart"].cart-changed {
  background: #36d0cd !important;
  color: #fff !important;
  border-color: #36d0cd !important;
  opacity: 1 !important;
  cursor: pointer !important;
  pointer-events: all !important;
  box-shadow: 0 4px 14px rgba(54,208,205,.3) !important;
  animation: pulseBtn .5s ease;
}
@keyframes pulseBtn {
  0%  { transform: scale(1); }
  45% { transform: scale(1.06); }
  100%{ transform: scale(1); }
}

/* ════════════════════════════════════════
   EMPTY CART
════════════════════════════════════════ */
.cart-empty-box {
  text-align: center;
  padding: clamp(28px,6vw,60px) 20px;
}
.cart-empty-box .cei {
  width: 64px; height: 64px;
  background: #e5fbfb; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 14px;
}
.cart-empty-box .cei .dashicons { font-size: 28px; width: 28px; height: 28px; color: #36d0cd; }
.cart-empty-box h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: #103837; margin: 0 0 8px; }
.cart-empty-box p  { font-size: .82rem; color: #5bd9d7; margin: 0 0 18px; }
.cart-empty-box a.btn-shop {
  display: inline-flex; align-items: center; gap: 7px;
  background: #36d0cd; color: #fff;
  padding: 11px 22px; border-radius: 50px;
  font-size: .84rem; font-weight: 800; text-decoration: none;
  font-family: 'Nunito', sans-serif;
  box-shadow: 0 6px 18px rgba(54,208,205,.3); transition: all .25s;
}
.cart-empty-box a.btn-shop:hover { background: #2dbebc; transform: translateY(-2px); }

/* ════════════════════════════════════════
   SIDEBAR
════════════════════════════════════════ */
.cart-sidebar { position: sticky; top: 80px; }
.cart-totals-card {
  background: #fff;
  border-radius: 14px;
  border: 1.5px solid #b0f4f3;
  box-shadow: 0 4px 20px rgba(54,208,205,.07);
  overflow: hidden;
}
.cart-totals-head {
  background: linear-gradient(135deg, #2dbebc, #36d0cd);
  padding: 13px 16px;
  display: flex; align-items: center; gap: 8px;
}
.cart-totals-head .dashicons { color: #fff; font-size: 17px; width: 17px; height: 17px; }
.cart-totals-head h2 {
  font-family: 'Nunito', sans-serif;
  font-size: clamp(.8rem, 2vw, .92rem);
  font-weight: 800; color: #fff; margin: 0;
}

/* Totals table */
.cart-totals-table { width: 100%; border-collapse: collapse; margin: 0; }
.cart-totals-table tr th,
.cart-totals-table tr td {
  padding: 12px 16px;
  border: none;
  border-bottom: 1px solid #e5fbfb;
  font-family: 'Nunito', sans-serif;
  font-size: clamp(.8rem, 2vw, .88rem);
  vertical-align: middle;
}
.cart-totals-table tr th { color: #5bd9d7; font-weight: 700; width: 42%; text-align: left; }
.cart-totals-table tr td { color: #103837; font-weight: 700; text-align: right; }
.cart-totals-table tr.total-row th,
.cart-totals-table tr.total-row td {
  border-bottom: none;
  padding-top: 14px; padding-bottom: 14px;
}
.cart-totals-table tr.total-row th { color: #103837; font-size: clamp(.84rem,2vw,.9rem); font-weight: 800; }
.cart-totals-table tr.total-row td {
  color: #36d0cd !important;
  font-size: clamp(1rem,3vw,1.2rem) !important;
  font-weight: 900 !important;
}

/* Checkout button */
.cart-checkout-wrap {
  padding: 14px 16px;
  border-top: 2px solid #e5fbfb;
  background: #f9fefe;
}
.cart-checkout-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  background: #36d0cd; color: #fff;
  padding: clamp(11px,2vw,14px) 18px;
  border-radius: 50px;
  font-family: 'Nunito', sans-serif;
  font-size: clamp(.82rem,2vw,.92rem);
  font-weight: 900; text-decoration: none;
  width: 100%; box-sizing: border-box; text-align: center;
  box-shadow: 0 6px 18px rgba(54,208,205,.3);
  transition: all .3s; letter-spacing: .02em;
}
.cart-checkout-btn:hover {
  background: #2dbebc; transform: translateY(-2px);
  box-shadow: 0 10px 26px rgba(54,208,205,.4); color: #fff;
}

/* Payment note */
.cart-pay-note {
  margin: 0 16px 14px;
  background: #eefcfc; border: 1.5px solid #b0f4f3;
  border-radius: 10px; padding: 11px 12px;
  font-size: clamp(.68rem,1.8vw,.76rem);
  color: #2dbebc; font-family: 'Nunito', sans-serif; line-height: 1.55;
}
.cart-pay-note .pn-row {
  display: flex; align-items: flex-start; gap: 7px; margin-bottom: 5px;
}
.cart-pay-note .pn-row:last-child { margin-bottom: 0; }
.cart-pay-note .pn-row .dashicons { font-size: 13px; width: 13px; height: 13px; flex-shrink: 0; margin-top: 2px; }
.cart-pay-note .pn-row.nairobi .dashicons { color: #36d0cd; }
.cart-pay-note .pn-row.county  .dashicons { color: #f0a500; }

/* ════════════════════════════════════════
   MOBILE CART ROWS — hidden on desktop
════════════════════════════════════════ */
.mobile-cart-list { display: none; }
.mobile-cart-actions { display: none; }

/* ════════════════════════════════════════
   RESPONSIVE — TABLET (≤ 900px)
════════════════════════════════════════ */
@media (max-width: 900px) {
  .cart-layout { grid-template-columns: 1fr; gap: 16px; }
  .cart-sidebar { position: static; }
}

/* ════════════════════════════════════════
   RESPONSIVE — MOBILE (≤ 640px)
════════════════════════════════════════ */
@media (max-width: 640px) {
  .cart-page-wrap { padding: 12px 3%; }
  .cart-layout { gap: 12px; }

  /* Hide desktop table + desktop actions, show mobile cards */
  .cart-table-wrap .desktop-table { display: none !important; }
  .cart-actions-bar { display: none !important; }
  .mobile-cart-list { display: block; }
  .mobile-cart-actions { display: flex; }

  /* Mobile cart item card */
  .mobile-cart-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 13px 14px;
    border-bottom: 1px solid #e5fbfb;
    position: relative;
  }
  .mobile-cart-item:last-child { border-bottom: none; }

  /* Image */
  .mci-img { flex-shrink: 0; }
  .mci-img img {
    width: 52px !important; height: 52px !important;
    object-fit: contain !important;
    border-radius: 9px !important;
    border: 1.5px solid #e5fbfb !important;
    background: #f8f8f8 !important;
    padding: 3px !important;
    display: block !important;
  }

  /* Info */
  .mci-info { flex: 1; min-width: 0; }
  .mci-name {
    font-family: 'Nunito', sans-serif;
    font-size: .82rem; font-weight: 700;
    color: #103837; line-height: 1.35;
    margin-bottom: 4px;
    text-decoration: none; display: block;
  }
  .mci-name:hover { color: #36d0cd; }
  .mci-price {
    font-family: 'Nunito', sans-serif;
    font-size: .74rem; color: #5bd9d7; font-weight: 600;
    margin-bottom: 8px;
  }
  .mci-price .amount { color: #36d0cd !important; font-weight: 800 !important; }

  /* Bottom row: qty + subtotal */
  .mci-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
  }
  .mci-subtotal {
    font-family: 'Nunito', sans-serif;
    font-size: .78rem; font-weight: 800;
    color: #103837;
  }
  .mci-subtotal .amount { color: #36d0cd !important; }
  .mci-subtotal-label {
    font-size: .66rem; color: #5bd9d7; font-weight: 600; margin-right: 3px;
  }

  /* Remove button — top right */
  .mci-remove {
    position: absolute;
    top: 11px; right: 12px;
    color: #e53935 !important;
    font-size: .9rem !important;
    font-weight: 900 !important;
    width: 22px !important; height: 22px !important;
    border-radius: 50% !important;
    background: #fff0f0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all .2s !important;
    text-decoration: none !important;
  }
  .mci-remove:hover { background: #e53935 !important; color: #fff !important; }

  /* Mobile actions */
  .mobile-cart-actions {
    padding: 12px 14px;
    border-top: 2px solid #e5fbfb;
    background: #f9fefe;
    flex-direction: column;
    gap: 8px;
  }
  .mobile-coupon-row {
    display: flex;
    gap: 6px;
    align-items: center;
  }
  .mobile-coupon-row input#coupon_code_mobile {
    flex: 1;
    padding: 8px 10px;
    border: 2px solid #b0f4f3;
    border-radius: 8px;
    font-family: 'Nunito', sans-serif;
    font-size: .76rem;
    outline: none;
    min-width: 0;
    box-sizing: border-box;
  }
  .mobile-coupon-row input#coupon_code_mobile:focus { border-color: #36d0cd; }
  .mobile-apply-btn {
    background: #eefcfc;
    color: #36d0cd;
    border: 2px solid #36d0cd;
    padding: 8px 12px;
    border-radius: 50px;
    font-family: 'Nunito', sans-serif;
    font-size: .72rem; font-weight: 800;
    cursor: pointer; white-space: nowrap;
    transition: all .2s;
  }
  .mobile-apply-btn:hover { background: #36d0cd; color: #fff; }

  /* Totals */
  .cart-totals-table tr th,
  .cart-totals-table tr td { padding: 10px 14px; font-size: .82rem; }
  .cart-totals-table tr.total-row td { font-size: 1.05rem !important; }
  .cart-checkout-btn { font-size: .84rem; padding: 12px 16px; }
  .cart-pay-note { margin: 0 14px 13px; }

  /* Qty stepper mobile */
  .qty-btn { width: 27px; height: 30px; font-size: .95rem; }
  .qty-wrap input.qty { width: 36px !important; min-width: 36px !important; height: 30px !important; font-size: .8rem; }
  .qty-btn:disabled { opacity: .35; cursor: not-allowed; background: #eefcfc !important; color: #b0f4f3 !important; pointer-events: all; }
  .qty-btn:disabled:hover { background: #eefcfc !important; color: #b0f4f3 !important; }
}

/* ════════════════════════════════════════
   RESPONSIVE — SMALL (≤ 400px)
════════════════════════════════════════ */
@media (max-width: 400px) {
  .cart-page-wrap { padding: 10px 2%; }
  .cart-banner { padding: 14px 3%; }
  .cart-banner h1 { font-size: 1rem; gap: 7px; }
  .mobile-cart-item { padding: 11px 11px; }
  .mci-img img { width: 44px !important; height: 44px !important; }
  .mci-name { font-size: .78rem; }
  .cart-totals-table tr th,
  .cart-totals-table tr td { padding: 9px 12px; font-size: .78rem; }
  .cart-totals-table tr.total-row td { font-size: .98rem !important; }
  .cart-checkout-btn { font-size: .8rem; padding: 11px 14px; }
}
</style>

<!-- ════ BANNER ════ -->
<section class="cart-banner">
  <div class="cart-banner-inner">
    <h1>
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.85)" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      My Cart
    </h1>
    <nav class="cart-breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> &rsaquo;
      <a href="<?php echo esc_url(function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop')); ?>">Shop</a> &rsaquo;
      <span>Cart</span>
    </nav>
  </div>
</section>

<!-- ════ MAIN ════ -->
<div class="cart-page-wrap">
  <div class="cart-layout">

    <!-- ══ LEFT: Cart items ══ -->
    <div class="cart-card">
      <div class="cart-card-head">
        <span class="dashicons dashicons-cart"></span>
        <h2>Products in Cart
          <?php if (function_exists('WC') && WC()->cart):
            $cnt = WC()->cart->get_cart_contents_count();
            echo '<span class="item-count">(' . $cnt . ' item' . ($cnt != 1 ? 's' : '') . ')</span>';
          endif; ?>
        </h2>
      </div>

      <?php if (function_exists('WC') && WC()->cart && !WC()->cart->is_empty()): ?>

        <?php $cart_items = WC()->cart->get_cart(); ?>

        <!-- ══ SINGLE FORM wraps both desktop table + mobile list ══ -->
        <form class="woocommerce-cart-form" id="cartForm" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
          <?php do_action('woocommerce_before_cart_contents'); ?>
          <?php wp_nonce_field('woocommerce-cart','woocommerce-cart-nonce'); ?>

          <!-- ── DESKTOP TABLE ── -->
          <div class="cart-table-wrap">
            <table class="shop_table desktop-table" cellspacing="0">
              <thead>
                <tr>
                  <th class="product-remove" style="width:32px">&nbsp;</th>
                  <th class="product-thumbnail" style="width:60px">&nbsp;</th>
                  <th class="product-name"><?php esc_html_e('Product','woocommerce'); ?></th>
                  <th class="product-price" style="width:100px"><?php esc_html_e('Price','woocommerce'); ?></th>
                  <th class="product-quantity" style="width:110px"><?php esc_html_e('Quantity','woocommerce'); ?></th>
                  <th class="product-subtotal" style="width:100px"><?php esc_html_e('Subtotal','woocommerce'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cart_items as $cart_item_key => $cart_item):
                  $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                  $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                  if (!$_product || !$_product->exists() || $cart_item['quantity'] <= 0) continue;
                  if (!apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) continue;
                  $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class','cart_item',$cart_item,$cart_item_key)); ?>"
                    data-key="<?php echo esc_attr($cart_item_key); ?>"
                    data-price="<?php echo esc_attr((float)$_product->get_price()); ?>">

                  <td class="product-remove">
                    <?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                      '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                      esc_url(wc_get_cart_remove_url($cart_item_key)),
                      esc_html__('Remove this item','woocommerce'),
                      esc_attr($product_id),
                      esc_attr($_product->get_sku())
                    ), $cart_item_key); ?>
                  </td>

                  <td class="product-thumbnail">
                    <?php $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail'), $cart_item, $cart_item_key);
                    echo $product_permalink ? '<a href="'.esc_url($product_permalink).'">'.$thumbnail.'</a>' : $thumbnail; ?>
                  </td>

                  <td class="product-name">
                    <?php echo $product_permalink
                      ? '<a href="'.esc_url($product_permalink).'">'.wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)).'</a>'
                      : wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key));
                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                    echo wc_get_formatted_cart_item_data($cart_item); ?>
                  </td>

                  <td class="product-price">
                    <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                  </td>

                  <td class="product-quantity">
                    <?php
                    $min_qty = $_product->is_sold_individually() ? 1 : 0;
                    $max_qty = $_product->is_sold_individually() ? 1 : $_product->get_max_purchase_quantity();
                    $qty_val = apply_filters('woocommerce_cart_item_quantity', $cart_item['quantity'], $cart_item_key, $cart_item);
                    $qty_html = woocommerce_quantity_input([
                      'input_name'   => "cart[{$cart_item_key}][qty]",
                      'input_value'  => $qty_val,
                      'max_value'    => $max_qty,
                      'min_value'    => $min_qty,
                      'product_name' => $_product->get_name(),
                    ], $_product, false);
                    echo apply_filters('woocommerce_cart_item_quantity', $qty_html, $cart_item_key, $cart_item);
                    ?>
                  </td>

                  <td class="product-subtotal">
                    <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                  </td>

                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php do_action('woocommerce_after_cart_contents'); ?>

          <!-- ── MOBILE CARD LIST (hidden on desktop via CSS) ── -->
          <div class="mobile-cart-list">
            <?php foreach ($cart_items as $cart_item_key => $cart_item):
              $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
              $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
              if (!$_product || !$_product->exists() || $cart_item['quantity'] <= 0) continue;
              $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
              $thumbnail = $_product->get_image('woocommerce_thumbnail');
              $min_qty = $_product->is_sold_individually() ? 1 : 0;
              $max_qty = $_product->is_sold_individually() ? 1 : $_product->get_max_purchase_quantity();
              $qty_val = $cart_item['quantity'];
            ?>
            <div class="mobile-cart-item" data-key="<?php echo esc_attr($cart_item_key); ?>" data-price="<?php echo esc_attr((float)$_product->get_price()); ?>">

              <!-- Remove -->
              <?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                '<a href="%s" class="mci-remove" aria-label="%s" data-product_id="%s">&times;</a>',
                esc_url(wc_get_cart_remove_url($cart_item_key)),
                esc_html__('Remove this item','woocommerce'),
                esc_attr($product_id)
              ), $cart_item_key); ?>

              <!-- Image -->
              <div class="mci-img">
                <?php echo $product_permalink ? '<a href="'.esc_url($product_permalink).'">'.$thumbnail.'</a>' : $thumbnail; ?>
              </div>

              <!-- Info -->
              <div class="mci-info">
                <?php if ($product_permalink): ?>
                  <a href="<?php echo esc_url($product_permalink); ?>" class="mci-name">
                    <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?>
                  </a>
                <?php else: ?>
                  <span class="mci-name"><?php echo wp_kses_post($_product->get_name()); ?></span>
                <?php endif; ?>

                <div class="mci-price">
                  <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                </div>

                <div class="mci-bottom">
                  <!-- Qty stepper (shares same name as desktop input — only one form now) -->
                  <div class="quantity">
                    <input type="number"
                      class="input-text qty text"
                      name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]"
                      value="<?php echo esc_attr($qty_val); ?>"
                      min="<?php echo esc_attr($min_qty); ?>"
                      max="<?php echo esc_attr($max_qty > 0 ? $max_qty : ''); ?>"
                      step="1"
                      data-original="<?php echo esc_attr($qty_val); ?>">
                  </div>

                  <!-- Subtotal -->
                  <div class="mci-subtotal">
                    <span class="mci-subtotal-label">Total:</span>
                    <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                  </div>
                </div>
              </div>

            </div>
            <?php endforeach; ?>
          </div>

          <!-- ── SINGLE ACTIONS BAR (desktop visible / mobile visible) ── -->
          <div class="cart-actions-bar">
            <div class="cart-coupon-group">
              <input type="text" name="coupon_code" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code','woocommerce'); ?>">
              <button type="submit" name="apply_coupon" value="Apply coupon"><?php esc_html_e('Apply coupon','woocommerce'); ?></button>
            </div>
            <button type="submit" name="update_cart" value="Update cart" id="updateCartBtn"><?php esc_html_e('Update cart','woocommerce'); ?></button>
            <?php do_action('woocommerce_cart_actions'); ?>
          </div>

          <!-- ── MOBILE ACTIONS (shown only on mobile via CSS) ── -->
          <div class="mobile-cart-actions">
            <div class="mobile-coupon-row">
              <!-- Reuses same coupon_code name — only one form now -->
              <input type="text" name="coupon_code" id="coupon_code_mobile" value="" placeholder="<?php esc_attr_e('Coupon code','woocommerce'); ?>">
              <button type="submit" class="mobile-apply-btn" name="apply_coupon" value="Apply coupon"><?php esc_html_e('Apply coupon','woocommerce'); ?></button>
            </div>
            <button type="submit" name="update_cart" value="Update cart" id="updateCartBtnMobile" style="width:100%"><?php esc_html_e('Update cart','woocommerce'); ?></button>
            <?php do_action('woocommerce_cart_actions'); ?>
          </div>

        </form><!-- end #cartForm -->

      <?php else: ?>

        <div class="cart-empty-box">
          <div class="cei"><span class="dashicons dashicons-cart"></span></div>
          <h3>Your cart is empty</h3>
          <p>Looks like you haven't added any products yet.</p>
          <a href="<?php echo esc_url(function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop')); ?>" class="btn-shop">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            Continue Shopping
          </a>
        </div>

      <?php endif; ?>
    </div>

    <!-- ══ RIGHT: Totals sidebar ══ -->
    <?php if (function_exists('WC') && WC()->cart && !WC()->cart->is_empty()): ?>
    <div class="cart-sidebar">
      <div class="cart-totals-card">

        <div class="cart-totals-head">
          <span class="dashicons dashicons-calculator"></span>
          <h2>Cart Totals</h2>
        </div>

        <table class="cart-totals-table">
          <tbody>
            <tr>
              <th><?php esc_html_e('Subtotal','woocommerce'); ?></th>
              <td><?php wc_cart_totals_subtotal_html(); ?></td>
            </tr>
            <?php foreach (WC()->cart->get_fees() as $fee): ?>
            <tr>
              <th><?php echo esc_html($fee->name); ?></th>
              <td><?php wc_cart_totals_fee_html($fee); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()): ?>
            <tr>
              <th><?php esc_html_e('Shipping','woocommerce'); ?></th>
              <td><?php wc_cart_totals_shipping_html(); ?></td>
            </tr>
            <?php elseif (WC()->cart->needs_shipping()): ?>
            <tr>
              <th><?php esc_html_e('Shipping','woocommerce'); ?></th>
              <td><?php esc_html_e('Calculated at checkout','woocommerce'); ?></td>
            </tr>
            <?php endif; ?>
            <?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
            <tr>
              <th><?php wc_cart_totals_coupon_label($coupon); ?></th>
              <td><?php wc_cart_totals_coupon_html($coupon); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
              <th><?php esc_html_e('Total','woocommerce'); ?></th>
              <td><?php wc_cart_totals_order_total_html(); ?></td>
            </tr>
          </tbody>
        </table>

        <div class="cart-checkout-wrap">
          <button type="button" class="cart-checkout-btn" id="checkoutBtn"
            data-checkout-url="<?php echo esc_url(wc_get_checkout_url()); ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            Proceed to Checkout
          </button>
        </div>

        <div class="cart-pay-note">
          <div class="pn-row nairobi">
            <span class="dashicons dashicons-location"></span>
            <span><strong>Nairobi:</strong> Pay on delivery: Cash</span>
          </div>
          <div class="pn-row county">
            <span class="dashicons dashicons-warning"></span>
            <span><strong>Other Counties:</strong> Full payment required before dispatch</span>
          </div>
        </div>

      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<script>
(function(){

  /* ══════════════════════════════════════════
     FORMAT NUMBER  →  "1,234.00"
  ══════════════════════════════════════════ */
  function fmt(num) {
    return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }

  /* ══════════════════════════════════════════
     UPDATE A PRICE CELL  (keeps WC markup intact)
  ══════════════════════════════════════════ */
  function writeAmount(cell, amount) {
    if (!cell) return;
    var bdi = cell.querySelector('bdi');
    if (bdi) {
      var sym = bdi.querySelector('.woocommerce-Price-currencySymbol');
      var symHtml = sym ? sym.outerHTML : '<span class="woocommerce-Price-currencySymbol">KSh</span>';
      bdi.innerHTML = symHtml + fmt(amount);
    }
  }

  /* ══════════════════════════════════════════
     RECALC ALL TOTALS IN DOM
     — per-row subtotal (desktop + mobile)
     — sidebar subtotal + grand total
  ══════════════════════════════════════════ */
  function recalcTotals() {
    var grand = 0;

    /* Desktop rows */
    document.querySelectorAll('tr[data-key][data-price]').forEach(function(row) {
      var price = parseFloat(row.getAttribute('data-price')) || 0;
      var inp   = row.querySelector('.quantity input.qty');
      var qty   = inp ? (parseFloat(inp.value) || 0) : 0;
      var sub   = price * qty;
      grand += sub;
      writeAmount(row.querySelector('.product-subtotal'), sub);
    });

    /* Mobile cards */
    document.querySelectorAll('.mobile-cart-item[data-key][data-price]').forEach(function(card) {
      var price = parseFloat(card.getAttribute('data-price')) || 0;
      var inp   = card.querySelector('.quantity input.qty');
      var qty   = inp ? (parseFloat(inp.value) || 0) : 0;
      var sub   = price * qty;

      var subEl = card.querySelector('.mci-subtotal');
      if (subEl) {
        var bdi = subEl.querySelector('bdi');
        if (bdi) {
          writeAmount(subEl, sub);
        } else {
          /* plain-text fallback */
          var label = subEl.querySelector('.mci-subtotal-label');
          var lHtml = label ? label.outerHTML : '<span class="mci-subtotal-label">Total:</span>';
          subEl.innerHTML = lHtml + ' KSh ' + fmt(sub);
        }
      }
    });

    /* Sidebar subtotal + total */
    writeAmount(document.querySelector('.cart-totals-table tbody tr:first-child td'), grand);
    writeAmount(document.querySelector('.cart-totals-table .total-row td'), grand);
  }

  /* ══════════════════════════════════════════
     SILENT SESSION UPDATE via fetch
     Builds a FormData from the cart form
     (already has the updated qty values +
     the WC nonce), adds update_cart, POSTs it.
     No reload. WC session stays in sync.
  ══════════════════════════════════════════ */
  var saveTimer = null;

  function saveToSession() {
    var form = document.getElementById('cartForm');
    if (!form) return;

    var data = new FormData(form);
    data.append('update_cart', 'Update cart');

    fetch(form.getAttribute('action'), {
      method: 'POST',
      credentials: 'same-origin',
      body: data
    })
    /* We don't need the response — WC has updated its session.
       If it fails, the session is slightly out of sync but
       the checkout button will catch it (see below). */
    .catch(function(err){ console.warn('Cart session sync failed:', err); });
  }

  /* ══════════════════════════════════════════
     SYNC DESKTOP ↔ MOBILE INPUTS
  ══════════════════════════════════════════ */
  function syncPaired(source) {
    var name = source.name;
    document.querySelectorAll('.quantity input.qty[name="' + name + '"]').forEach(function(inp){
      if (inp !== source) inp.value = source.value;
    });
  }

  /* ══════════════════════════════════════════
     QUANTITY STEPPERS
  ══════════════════════════════════════════ */
  function wrapQtyInputs() {
    document.querySelectorAll('.quantity input.qty').forEach(function(input){
      if (input.closest('.qty-wrap')) return;

      var min = parseFloat(input.getAttribute('min')) || 0;
      var max = parseFloat(input.getAttribute('max')) || 0;

      var wrap = document.createElement('div');
      wrap.className = 'qty-wrap';

      var btnM = document.createElement('button');
      btnM.type = 'button'; btnM.className = 'qty-btn qty-minus';
      btnM.innerHTML = '&#8722;'; btnM.setAttribute('aria-label','Decrease');

      var btnP = document.createElement('button');
      btnP.type = 'button'; btnP.className = 'qty-btn qty-plus';
      btnP.innerHTML = '&#43;'; btnP.setAttribute('aria-label','Increase');

      input.parentNode.insertBefore(wrap, input);
      wrap.appendChild(btnM);
      wrap.appendChild(input);
      wrap.appendChild(btnP);

      function refreshBtns() {
        var v = parseFloat(input.value) || 1;
        /* Enforce minimum of 1 — never allow 0 or negative */
        if (v < 1) { input.value = 1; v = 1; }
        btnM.disabled = (v <= 1); /* minus always disabled at 1 */
        btnP.disabled = (max > 0 && v >= max);
      }
      refreshBtns();

      /* +/- : instant DOM update + debounced silent session save */
      function onStep() {
        syncPaired(input);
        recalcTotals();
        /* Keep Update Cart inactive — session is saved silently */
        setUpdateBtnInactive();
        /* Debounce: wait for rapid taps to settle before posting */
        clearTimeout(saveTimer);
        saveTimer = setTimeout(saveToSession, 600);
      }

      btnM.addEventListener('click', function(){
        var v = parseFloat(input.value) || 1;
        if (v > 1) { input.value = v - 1; refreshBtns(); onStep(); }
      });

      btnP.addEventListener('click', function(){
        var v = parseFloat(input.value) || 1;
        if (!max || v < max) { input.value = v + 1; refreshBtns(); onStep(); }
      });

      /* Manual typing — live recalc + activates Update Cart button */
      input.addEventListener('input', function(){
        /* Strip any non-numeric chars, enforce min 1 */
        var raw = input.value.replace(/[^0-9]/g, '');
        if (raw === '' || raw === '0') {
          /* Don't snap while typing — only enforce on blur */
        } else {
          input.value = raw;
        }
        refreshBtns();
        syncPaired(input);
        recalcTotals();
        checkChanged();
      });

      /* On blur: clamp to minimum 1 so 0 can never be submitted */
      input.addEventListener('blur', function(){
        var v = parseInt(input.value, 10);
        if (!v || v < 1) {
          input.value = 1;
          refreshBtns();
          syncPaired(input);
          recalcTotals();
          checkChanged();
        }
      });
    });
  }

  /* ══════════════════════════════════════════
     UPDATE CART BUTTON STATE
     (only relevant for manual typing path)
  ══════════════════════════════════════════ */
  var originals  = {};
  var qtyChanged = false;

  function storeOriginals() {
    document.querySelectorAll('.quantity input.qty').forEach(function(inp){
      if (!(inp.name in originals)) originals[inp.name] = inp.value;
    });
  }

  function setUpdateBtnInactive() {
    qtyChanged = false;
    ['updateCartBtn','updateCartBtnMobile'].forEach(function(id){
      var btn = document.getElementById(id);
      if (btn) btn.classList.remove('cart-changed');
    });
  }

  function checkChanged() {
    qtyChanged = false;
    document.querySelectorAll('.quantity input.qty').forEach(function(inp){
      if (originals[inp.name] !== undefined && inp.value !== originals[inp.name]) qtyChanged = true;
    });
    ['updateCartBtn','updateCartBtnMobile'].forEach(function(id){
      var btn = document.getElementById(id);
      if (!btn) return;
      if (qtyChanged) btn.classList.add('cart-changed');
      else            btn.classList.remove('cart-changed');
    });
  }

  /* Update Cart button click — manual typing path */
  document.addEventListener('click', function(e){
    if (e.target && e.target.name === 'update_cart') {
      if (!e.target.classList.contains('cart-changed')) {
        e.preventDefault();
      } else {
        /* Let the form submit normally — full WC reload */
      }
    }
  });

  /* ══════════════════════════════════════════
     REMOVE ITEM — fetch WC remove URL, clean reload
     (Removing a row still needs a reload since
     the row itself must disappear from the DOM)
  ══════════════════════════════════════════ */
  function bindRemoveLinks() {
    document.querySelectorAll('a.remove, a.mci-remove').forEach(function(link){
      if (link.dataset.removeBound) return;
      link.dataset.removeBound = '1';

      link.addEventListener('click', function(e){
        e.preventDefault();
        var href = link.getAttribute('href');
        if (!href) return;

        /* Animate row out */
        var row = link.closest('tr') || link.closest('.mobile-cart-item');
        if (row) {
          row.style.transition = 'opacity .22s ease, transform .22s ease';
          row.style.opacity    = '0';
          row.style.transform  = 'translateX(-14px)';
        }
        link.style.pointerEvents = 'none';
        link.style.opacity = '0.3';

        fetch(href, {
          method: 'GET',
          credentials: 'same-origin',
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(){
          window.location.replace(window.location.origin + window.location.pathname);
        })
        .catch(function(){ window.location.href = href; });
      });
    });
  }

  /* ══════════════════════════════════════════
     CHECKOUT BUTTON
     Session is already up to date from the
     silent saves, so just navigate directly.
     If somehow qtyChanged is still true
     (manual-typing path without Update Cart),
     do one last silent save first then redirect.
  ══════════════════════════════════════════ */
  document.addEventListener('DOMContentLoaded', function(){
    var checkoutBtn = document.getElementById('checkoutBtn');
    if (!checkoutBtn) return;
    var checkoutUrl = checkoutBtn.getAttribute('data-checkout-url');

    checkoutBtn.addEventListener('click', function(e){
      e.preventDefault();

      if (!qtyChanged) {
        /* +/- path: session already saved silently → go straight to checkout */
        window.location.href = checkoutUrl;
        return;
      }

      /* Manual-typing path: do one final save then redirect */
      checkoutBtn.disabled = true;
      checkoutBtn.style.opacity = '0.75';
      checkoutBtn.innerHTML =
        '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation:spinIcon .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>&nbsp;Saving…';

      var form = document.getElementById('cartForm');
      var data = new FormData(form);
      data.append('update_cart', 'Update cart');

      fetch(form.getAttribute('action'), {
        method: 'POST',
        credentials: 'same-origin',
        body: data
      })
      .then(function(){ window.location.href = checkoutUrl; })
      .catch(function(){ window.location.href = checkoutUrl; });
    });
  });

  /* Spin keyframe */
  (function(){
    var s = document.createElement('style');
    s.textContent = '@keyframes spinIcon { to { transform: rotate(360deg); } }';
    document.head.appendChild(s);
  })();

  /* ══════════════════════════════════════════
     INIT
  ══════════════════════════════════════════ */
  function init() {
    wrapQtyInputs();
    storeOriginals();
    bindRemoveLinks();
    recalcTotals();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
</script>

<?php get_footer(); ?>
