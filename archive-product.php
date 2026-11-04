<?php get_header(); ?>
<?php
add_filter('loop_shop_per_page', function($n) { return 16; }, 20);

$travotech_toast_pid  = isset($_GET['travotech_added'])  ? intval($_GET['travotech_added'])  : 0;
$travotech_toast_name = '';
if ($travotech_toast_pid) {
  $p = wc_get_product($travotech_toast_pid);
  if ($p) {
    $n = $p->get_name();
    $travotech_toast_name = mb_strlen($n) > 30 ? mb_substr($n,0,30).'…' : $n;
  }
}
?>

<style>
/* ═══════════════════════════════════════════════════
   SHOP LAYOUT
═══════════════════════════════════════════════════ */
.shop-wrap { padding: 0 0 60px; }
.shop-layout {
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 28px;
  max-width: 1280px;
  margin: 0 auto;
  padding: 28px 32px;
  align-items: start;
}

/* ═══════════════════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════════════════ */
.shop-sidebar { position: sticky; top: 20px; display: flex; flex-direction: column; gap: 16px; }
.sidebar-widget { border-radius: 14px; padding: 18px 16px; border: 1px solid rgba(0,0,0,.07); }
.sidebar-widget-title {
  font-size: 0.75rem; font-weight: 800; letter-spacing: .10em;
  text-transform: uppercase; margin-bottom: 14px; padding-bottom: 10px;
  border-bottom: 2px solid var(--green,#2eaf6e); color: var(--dark,#1a3c2e);
}
.sidebar-cat-list { display: flex; flex-direction: column; gap: 2px; }
.sidebar-cat-list a {
  display: flex; align-items: center; justify-content: space-between;
  padding: 8px 10px; border-radius: 8px; font-size: 0.83rem; font-weight: 500;
  text-decoration: none; color: var(--text-mid,#4a5568);
  transition: background .15s, color .15s, padding-left .15s;
}
.sidebar-cat-list a:hover,.sidebar-cat-list a.active {
  background: rgba(46,175,110,.1); color: var(--green,#2eaf6e);
  padding-left: 14px; font-weight: 700;
}
.sidebar-cat-list a span {
  font-size: 0.72rem; font-weight: 600; background: rgba(0,0,0,.06);
  padding: 2px 7px; border-radius: 50px; opacity: .7;
}
.sidebar-cat-list a.active span,.sidebar-cat-list a:hover span { background: rgba(46,175,110,.2); opacity: 1; }

.active-filter-bar {
  display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
  padding: 10px 14px; background: var(--green-light,#e8f8f0);
  border-radius: 10px; margin-bottom: 4px;
}
.active-filter-bar span { font-size: .78rem; font-weight: 700; color: var(--green-dark,#1e8a54); }
.active-filter-clear {
  margin-left: auto; font-size: .72rem; font-weight: 700;
  color: var(--green,#2eaf6e); text-decoration: none;
  border: 1px solid var(--green,#2eaf6e); border-radius: 6px;
  padding: 2px 8px; transition: background .15s, color .15s; white-space: nowrap;
}
.active-filter-clear:hover { background: var(--green,#2eaf6e); color: #fff; }

.price-slider-wrap { padding: 4px 2px 0; }
.price-range-display { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.price-range-display span { font-size: 0.82rem; font-weight: 700; color: var(--dark,#1a3c2e); }
.price-range-display .price-sep { font-size: 0.75rem; opacity: .4; }
.price-track-outer { position: relative; height: 6px; margin: 18px 0 10px; }
.price-track-bg { position: absolute; inset: 0; border-radius: 3px; background: rgba(0,0,0,.1); }
.price-track-fill { position: absolute; top: 0; bottom: 0; border-radius: 3px; background: var(--green,#2eaf6e); }
.price-range-input {
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 100%; left: 0; appearance: none; -webkit-appearance: none;
  background: transparent; pointer-events: none; height: 6px; margin: 0;
}
.price-range-input::-webkit-slider-thumb {
  -webkit-appearance: none; width: 18px; height: 18px; border-radius: 50%;
  background: #fff; border: 2.5px solid var(--green,#2eaf6e);
  box-shadow: 0 2px 8px rgba(46,175,110,.35); cursor: pointer;
  pointer-events: all; transition: transform .15s, box-shadow .15s;
}
.price-range-input::-moz-range-thumb {
  width: 18px; height: 18px; border-radius: 50%; background: #fff;
  border: 2.5px solid var(--green,#2eaf6e); box-shadow: 0 2px 8px rgba(46,175,110,.35);
  cursor: pointer; pointer-events: all;
}
.price-range-input::-webkit-slider-thumb:hover { transform: scale(1.2); }
.price-apply-btn {
  display: flex; align-items: center; justify-content: center; gap: 6px;
  width: 100%; margin-top: 14px; padding: 9px 12px; border: none; border-radius: 8px;
  background: var(--green,#2eaf6e); color: #fff; font-size: 0.78rem;
  font-weight: 700; cursor: pointer; letter-spacing: .04em;
  transition: opacity .18s, transform .15s; font-family: 'Nunito', sans-serif;
}
.price-apply-btn:hover { opacity: .88; transform: translateY(-1px); }

.sidebar-wa-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  width: 100%; padding: 10px 14px; border-radius: 9px;
  background: var(--green,#2eaf6e); color: #fff; font-size: 0.78rem;
  font-weight: 700; text-decoration: none; transition: opacity .18s, transform .15s;
  box-sizing: border-box; font-family: 'Nunito', sans-serif;
}
.sidebar-wa-btn:hover { opacity: .88; transform: translateY(-1px); }

/* ═══════════════════════════════════════════════════
   TOOLBAR
═══════════════════════════════════════════════════ */
.shop-toolbar {
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 10px; margin-bottom: 20px;
  padding-bottom: 14px; border-bottom: 1px solid rgba(0,0,0,.07);
}
.shop-results { font-size: 0.85rem; opacity: .6; font-weight: 500; }

/* ═══════════════════════════════════════════════════
   PRODUCT GRID
═══════════════════════════════════════════════════ */
.shop-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }

.p-card {
  border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;
  border: 1.5px solid var(--green-light,#e8f8f0);
  transition: transform .25s, box-shadow .25s; background: #fff;
  position: relative;
}
.p-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(46,175,110,.12); border-color: var(--green-mid,#b8ecd4); }

.p-img-link { display: block; text-decoration: none; flex-shrink: 0; overflow: hidden; }
.p-img {
  position: relative; width: 100%; height: 200px; overflow: hidden;
  flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: #f8f8f8;
}
.p-img img {
  width: 100%; height: 100%; object-fit: contain; object-position: center;
  display: block; transition: transform .3s; padding: 8px; box-sizing: border-box;
}
.p-card:hover .p-img img { transform: scale(1.04); }

.p-wish {
  position: absolute; top: 8px; right: 8px; width: 30px; height: 30px;
  border-radius: 50%; border: none; background: #fff; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 2px 8px rgba(0,0,0,.1); transition: transform .2s; z-index: 2;
}
.p-wish:hover { transform: scale(1.15); }

.p-badge-sale,.p-badge-new {
  position: absolute; top: 8px; left: 8px; font-size: 0.62rem; font-weight: 800;
  padding: 3px 9px; border-radius: 50px; letter-spacing: .03em; z-index: 2;
}
.p-badge-sale { background: #ff4757; color: #fff; }
.p-badge-new  { background: var(--green,#2eaf6e); color: #fff; }

.p-body { padding: 14px 14px 0; display: flex; flex-direction: column; flex: 1; }

.p-card-meta { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-bottom: 5px; }
.p-card-cat {
  font-size: .62rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: .07em; padding: 2px 8px; border-radius: 50px;
  line-height: 1.5; white-space: nowrap; text-decoration: none;
  background: var(--green-light,#e8f8f0); color: var(--green,#2eaf6e);
}
.p-card-brand {
  font-size: .62rem; font-weight: 700; padding: 2px 8px; border-radius: 50px;
  line-height: 1.5; border: 1.2px solid var(--green-mid,#b8ecd4);
  white-space: nowrap; opacity: .85; color: var(--text-mid,#4a6358);
}

.p-cat,.p-desc { display: none; }
.p-name { font-size: clamp(.88rem,1.5vw,1rem); font-weight: 700; line-height: 1.3; margin-bottom: 4px; }
.p-name a { text-decoration: none; color: inherit; transition: color .15s; }
.p-name a:hover { text-decoration: underline; }

.p-price-wrap { display: flex; align-items: center; gap: 8px; margin: 5px 0 10px; flex-wrap: wrap; }
.p-price-old  { font-size: .72rem; text-decoration: line-through; opacity: .45; }
.p-price-cur  { font-size: clamp(.88rem,1.5vw,1rem); font-weight: 700; color: var(--green,#2eaf6e); }

.p-btns { display: flex; flex-direction: column; gap: 6px; margin-top: auto; padding: 8px 10px 10px; }
.p-btn-cart,.p-btn-wa {
  display: flex; align-items: center; gap: 8px; width: 100%; padding: 8px 10px;
  font-size: .7rem; font-weight: 700; text-decoration: none; text-transform: uppercase;
  letter-spacing: .02em; border-radius: 8px; border: none; cursor: pointer;
  transition: background .2s, color .2s, opacity .18s, transform .15s;
  box-sizing: border-box; white-space: nowrap; font-family: 'Nunito', sans-serif;
}
.p-btn-cart:hover,.p-btn-wa:hover { opacity: .88; transform: translateY(-1px); }
.p-btn-ico { width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.p-btn-cart { background: #fff; color: var(--dark,#1a3c2e); border: 1.5px solid rgba(0,0,0,.08); box-shadow: 0 1px 4px rgba(0,0,0,.06); }
.p-btn-cart .p-btn-ico { background: var(--green,#2eaf6e); color: #fff; }
.p-btn-cart:hover { background: var(--green,#2eaf6e); color: #fff; border-color: var(--green,#2eaf6e); }
.p-btn-cart:hover .p-btn-ico { background: rgba(255,255,255,.25); }
.p-btn-wa { background: var(--green,#2eaf6e); color: #fff; box-shadow: 0 2px 8px rgba(46,175,110,.25); }
.p-btn-wa .p-btn-ico { background: rgba(255,255,255,.2); color: #fff; }

/* ATC loading state */
.p-btn-cart.atc-loading {
  pointer-events: none;
  opacity: .7;
}
.p-btn-cart.atc-loading .p-btn-ico {
  background: rgba(255,255,255,.3);
}

/* Sort */
.woocommerce-ordering { margin: 0; }
.woocommerce-ordering select,select.orderby {
  appearance: none; -webkit-appearance: none; background-color: #fff;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%232eaf6e' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 10px center;
  padding: 8px 32px 8px 12px; border: 1.5px solid var(--green,#2eaf6e);
  border-radius: 8px; font-size: 0.82rem; font-weight: 600;
  color: var(--dark,#1a3c2e); cursor: pointer; min-width: 190px; outline: none;
  transition: border-color .2s, box-shadow .2s; box-shadow: 0 1px 4px rgba(46,175,110,.1);
}
.woocommerce-ordering select:hover,select.orderby:hover { border-color: #22994f; }
.woocommerce-ordering select:focus,select.orderby:focus { border-color: #22994f; box-shadow: 0 0 0 3px rgba(46,175,110,.18); }

/* ═══════════════════════════════════════════════════
   PAGINATION
═══════════════════════════════════════════════════ */
.wc-pagination {
  display: flex; gap: 6px; justify-content: center;
  align-items: center; margin-top: 36px; flex-wrap: wrap;
}
.wc-page-btn {
  width: 38px; height: 38px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: .82rem; font-weight: 700; text-decoration: none;
  border: 1.5px solid rgba(0,0,0,.12); color: var(--text-mid,#4a5568);
  transition: background .15s, color .15s, border-color .15s, transform .15s;
}
.wc-page-btn:hover { background: var(--green,#2eaf6e); color: #fff; border-color: var(--green,#2eaf6e); transform: scale(1.08); }
.wc-page-btn.active { background: var(--green,#2eaf6e); color: #fff; border-color: var(--green,#2eaf6e); box-shadow: 0 4px 14px rgba(46,175,110,.35); }
.wc-page-btn.wc-page-dots { border: none; background: none; pointer-events: none; width: auto; letter-spacing: .1em; }
.wc-page-btn.wc-page-next,.wc-page-btn.wc-page-prev { width: auto; padding: 0 14px; border-radius: 8px; gap: 5px; font-size: .8rem; }

/* Hide ALL WC notices */
.woocommerce-notices-wrapper,
.woocommerce-message,
.woocommerce-info,
ul.woocommerce-error,
.wc-forward { display: none !important; }

/* Empty state */
.shop-empty { text-align: center; padding: 60px 20px; grid-column: 1 / -1; }
.shop-empty-icon { margin-bottom: 16px; opacity: .3; }

/* ═══════════════════════════════════════════════════
   FIXED TOAST NOTIFICATION
═══════════════════════════════════════════════════ */
#travotech-toast {
  position: fixed;
  bottom: 100px;
  right: 24px;
  z-index: 999999;
  min-width: 280px;
  max-width: 340px;
  background: #1a3c2e;
  color: #fff;
  border-radius: 14px;
  padding: 14px 16px;
  box-shadow: 0 12px 40px rgba(0,0,0,.3);
  display: flex;
  align-items: flex-start;
  gap: 12px;
  font-family: 'Nunito', sans-serif;
  opacity: 0;
  transform: translateY(20px) scale(0.95);
  transition: opacity .4s cubic-bezier(.34,1.56,.64,1),
              transform .4s cubic-bezier(.34,1.56,.64,1);
  pointer-events: none;
}
#travotech-toast.cv-show {
  opacity: 1;
  transform: translateY(0) scale(1);
  pointer-events: all;
}
.cv-toast-icon-wrap {
  width: 36px; height: 36px; border-radius: 50%;
  background: #2eaf6e;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; margin-top: 1px;
}
.cv-toast-body { flex: 1; min-width: 0; }
.cv-toast-title {
  font-size: .72rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: .08em; color: #2eaf6e; margin-bottom: 3px;
}
.cv-toast-name {
  font-size: .85rem; font-weight: 700; color: #fff;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  margin-bottom: 10px;
}
.cv-toast-actions { display: flex; gap: 8px; }
.cv-toast-btn-cart {
  display: inline-flex; align-items: center; gap: 5px;
  background: #2eaf6e; color: #fff;
  padding: 6px 12px; border-radius: 8px;
  font-size: .72rem; font-weight: 800;
  text-decoration: none; transition: background .2s;
  white-space: nowrap;
}
.cv-toast-btn-cart:hover { background: #27964f; color: #fff; }
.cv-toast-btn-close {
  display: inline-flex; align-items: center;
  background: rgba(255,255,255,.1); color: rgba(255,255,255,.7);
  padding: 6px 10px; border-radius: 8px; border: none; cursor: pointer;
  font-size: .72rem; font-weight: 700; transition: background .2s;
  font-family: 'Nunito', sans-serif;
}
.cv-toast-btn-close:hover { background: rgba(255,255,255,.2); color: #fff; }
.cv-toast-progress {
  position: absolute; bottom: 0; left: 0; right: 0; height: 4px;
  background: rgba(255,255,255,.15); border-radius: 0 0 14px 14px; overflow: hidden;
}
.cv-toast-progress-bar {
  height: 100%; width: 100%;
  background: #2eaf6e;
  transform-origin: left;
  animation: none;
}
#travotech-toast.cv-show .cv-toast-progress-bar {
  animation: cvCountdown 5s linear forwards;
}
@keyframes cvCountdown {
  from { transform: scaleX(1); }
  to   { transform: scaleX(0); }
}
@media(max-width:600px) {
  #travotech-toast { bottom: 80px; right: 12px; left: 12px; min-width: unset; max-width: unset; }
}

/* ═══════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════ */
@media(max-width:1100px) { .shop-grid { grid-template-columns: repeat(3,1fr); } }
@media(max-width:900px) {
  .shop-layout { grid-template-columns: 220px 1fr; gap: 20px; padding: 20px; }
  .shop-grid { grid-template-columns: repeat(2,1fr); gap: 12px; }
}
@media(max-width:640px) {
  .shop-layout { grid-template-columns: 1fr; padding: 14px; }
  .shop-sidebar { position: static; }
  .shop-grid { grid-template-columns: repeat(2,1fr); gap: 10px; }
  .p-img { height: 160px; }
  .p-btn-cart,.p-btn-wa { font-size: .62rem; padding: 7px 8px; gap: 5px; }
  .p-btn-ico { width: 20px; height: 20px; }
  .p-btns { gap: 5px; padding: 6px 8px 8px; }
  .p-name { font-size: .82rem; }
}
@media(max-width:380px) { .shop-grid { grid-template-columns: 1fr; } }
</style>

<!-- FIXED TOAST HTML -->
<div id="travotech-toast" role="alert" aria-live="assertive">
  <div class="cv-toast-icon-wrap">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
  </div>
  <div class="cv-toast-body">
    <div class="cv-toast-title">✓ Added to Cart</div>
    <div class="cv-toast-name" id="cv-toast-name"></div>
    <div class="cv-toast-actions">
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cv-toast-btn-cart">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
        View Cart
      </a>
      <button class="cv-toast-btn-close" id="cv-toast-close" type="button">Dismiss</button>
    </div>
  </div>
  <div class="cv-toast-progress">
    <div class="cv-toast-progress-bar" id="cv-toast-bar"></div>
  </div>
</div>

<div class="shop-wrap">
  <div class="shop-layout">

    <!-- ═══════ SIDEBAR ═══════ -->
    <aside class="shop-sidebar">
      <div class="sidebar-widget">
        <div class="sidebar-widget-title">Categories</div>
        <div class="sidebar-cat-list">
          <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>"
             <?php echo !is_product_category() ? 'class="active"' : ''; ?>>
            All Products
            <span><?php echo wp_count_posts('product')->publish; ?></span>
          </a>
          <?php
          $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0]);
          if ($cats && !is_wp_error($cats)):
            foreach ($cats as $c): ?>
              <a href="<?php echo esc_url(get_term_link($c)); ?>"
                 <?php echo is_product_category($c->slug) ? 'class="active"' : ''; ?>>
                <?php echo esc_html($c->name); ?>
                <span><?php echo $c->count; ?></span>
              </a>
            <?php endforeach;
          endif; ?>
        </div>
      </div>

      <div class="sidebar-widget">
        <div class="sidebar-widget-title">Price Range</div>
        <?php
        $has_price_filter = isset($_GET['min_price']) || isset($_GET['max_price']);
        $cur_min = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
        $cur_max = isset($_GET['max_price']) ? intval($_GET['max_price']) : 200000;
        $clear_url = remove_query_arg(['min_price','max_price']);
        ?>
        <?php if ($has_price_filter && ($cur_min > 0 || $cur_max < 200000)): ?>
          <div class="active-filter-bar">
            <span>KES <?php echo number_format($cur_min); ?> — KES <?php echo number_format($cur_max); ?></span>
            <a href="<?php echo esc_url($clear_url); ?>" class="active-filter-clear">✕ Clear</a>
          </div>
        <?php endif; ?>
        <div class="price-slider-wrap">
          <div class="price-range-display">
            <span id="priceMinLabel">KES <?php echo number_format($cur_min); ?></span>
            <span class="price-sep">—</span>
            <span id="priceMaxLabel">KES <?php echo number_format($cur_max); ?></span>
          </div>
          <div class="price-track-outer">
            <div class="price-track-bg"></div>
            <div class="price-track-fill" id="priceTrackFill"></div>
            <input type="range" class="price-range-input" id="priceMin" min="0" max="200000" step="500" value="<?php echo $cur_min; ?>">
            <input type="range" class="price-range-input" id="priceMax" min="0" max="200000" step="500" value="<?php echo $cur_max; ?>">
          </div>
          <button class="price-apply-btn" id="priceApplyBtn" type="button">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Apply Filter
          </button>
        </div>
      </div>

      <div class="sidebar-widget">
        <div class="sidebar-widget-title">Quick Order</div>
        <p style="font-size:.78rem;line-height:1.6;margin-bottom:14px;opacity:.65;">Can't find what you need? Send us a WhatsApp message!</p>
        <a href="https://wa.me/254720737151?text=<?php echo urlencode("Hello! I'm looking for a product and need help."); ?>"
           class="sidebar-wa-btn" target="_blank" rel="noopener">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Ask on WhatsApp
        </a>
      </div>
    </aside>

    <!-- ═══════ MAIN AREA ═══════ -->
    <div class="shop-products-area">

      <div class="shop-toolbar">
        <div class="shop-results"><?php woocommerce_result_count(); ?></div>
        <div style="display:flex;gap:12px;align-items:center;">
          <?php woocommerce_catalog_ordering(); ?>
        </div>
      </div>

      <?php if (have_posts()): ?>
        <div class="shop-grid">
          <?php while (have_posts()): the_post(); global $product;
            $sale      = $product->is_on_sale();
            $is_new    = (time() - strtotime($product->get_date_created())) < (30 * DAY_IN_SECONDS);
            $img       = get_the_post_thumbnail_url(get_the_ID(),'woocommerce_thumbnail');
            $pr        = $product->get_regular_price();
            $pc        = $product->get_price();
            $pid       = get_the_ID();
            $wamsg     = urlencode("Hello! I'd like to order: *".get_the_title()."* — KES {$pc}. Link: ".get_permalink());
            $cats      = get_the_terms($pid,'product_cat');
            $cat_n     = ($cats && !is_wp_error($cats)) ? $cats[0]->name : '';
            $cat_lnk   = ($cats && !is_wp_error($cats)) ? get_term_link($cats[0]) : '#';
            $brands    = get_the_terms($pid,'product_brand');
            if (!$brands || is_wp_error($brands)) $brands = get_the_terms($pid,'pa_brand');
            $brand_n   = ($brands && !is_wp_error($brands)) ? $brands[0]->name : '';
            $is_simple = $product->is_type('simple');
            $pname     = get_the_title();
            $pname_short = mb_strlen($pname) > 30 ? mb_substr($pname,0,30).'…' : $pname;
          ?>
          <div class="p-card reveal" id="pcard-<?php echo $pid; ?>">

            <a href="<?php the_permalink(); ?>" class="p-img-link">
              <div class="p-img">
                <?php if ($img): ?>
                  <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                <?php else: ?>
                  <svg style="width:56px;height:56px;opacity:.25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.5 3.5a6 6 0 018 8l-8.5 8.5a6 6 0 01-8-8l8.5-8.5z"/><line x1="9" y1="15" x2="15" y2="9"/></svg>
                <?php endif; ?>
                <button class="p-wish" aria-label="Wishlist" onclick="event.preventDefault();event.stopPropagation();">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                </button>
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
                  <!-- Silent AJAX ATC — no navigation, no scroll -->
                  <button type="button"
                    class="p-btn-cart travotech-atc-btn"
                    data-pid="<?php echo esc_attr($pid); ?>"
                    data-name="<?php echo esc_attr($pname_short); ?>">
                    <span class="p-btn-ico">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
                    </span>
                    <span class="p-atc-txt">Add to Cart</span>
                  </button>
                <?php else: ?>
                  <a href="<?php the_permalink(); ?>" class="p-btn-cart">
                    <span class="p-btn-ico">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
                    </span>
                    <span>Select Options</span>
                  </a>
                <?php endif; ?>

                <a href="https://wa.me/254720737151?text=<?php echo $wamsg; ?>" class="p-btn-wa" target="_blank" rel="noopener">
                  <span class="p-btn-ico">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                  </span>
                  Buy Via WhatsApp
                </a>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php
        $total = wc_get_loop_prop('total_pages');
        $curr  = max(1, get_query_var('paged'));
        if ($total > 1): ?>
        <div class="wc-pagination">
          <?php if ($curr > 1): ?>
            <a href="<?php echo esc_url(get_pagenum_link($curr-1)); ?>" class="wc-page-btn wc-page-prev">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>PREV
            </a>
          <?php endif; ?>
          <?php
          $show=[]; $delta=2;
          for($i=1;$i<=$total;$i++){
            if($i==1||$i==$total||abs($i-$curr)<=$delta) $show[]=$i;
          }
          $show=array_unique($show); sort($show); $prev=0;
          foreach($show as $pg):
            if($prev && $pg-$prev>1): ?><span class="wc-page-btn wc-page-dots">…</span><?php endif; ?>
            <a href="<?php echo esc_url(get_pagenum_link($pg)); ?>"
               class="wc-page-btn <?php echo $pg===$curr?'active':''; ?>"><?php echo $pg; ?></a>
          <?php $prev=$pg; endforeach; ?>
          <?php if ($curr < $total): ?>
            <a href="<?php echo esc_url(get_pagenum_link($curr+1)); ?>" class="wc-page-btn wc-page-next">
              NEXT<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
          <?php endif; ?>
        </div>
        <?php endif; ?>

      <?php else: ?>
        <div class="shop-empty">
          <div class="shop-empty-icon">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </div>
          <h3 style="font-family:'Playfair Display',serif;margin-bottom:8px;">No products found</h3>
          <p style="font-size:.85rem;opacity:.6;">
            <?php if ($has_price_filter): ?>
              No products in this price range. <a href="<?php echo esc_url($clear_url); ?>" style="color:var(--green);font-weight:700">Clear filter</a> or
            <?php endif; ?>
            <a href="https://wa.me/254720737151" style="color:var(--green);font-weight:700">ask us on WhatsApp</a>
          </p>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>

<!-- Price Slider JS -->
<script>
(function(){
  var mn=document.getElementById('priceMin'),mx=document.getElementById('priceMax'),
      lmn=document.getElementById('priceMinLabel'),lmx=document.getElementById('priceMaxLabel'),
      fill=document.getElementById('priceTrackFill'),btn=document.getElementById('priceApplyBtn');
  if(!mn||!mx) return;
  var MIN=0,MAX=200000,GAP=2500;
  function fmt(n){ return 'KES '+Number(n).toLocaleString(); }
  function upd(moved){
    var lo=parseInt(mn.value),hi=parseInt(mx.value);
    if(lo>=hi-GAP){ if(moved==='min'){lo=hi-GAP;mn.value=lo;}else{hi=lo+GAP;mx.value=hi;} }
    lo=Math.max(MIN,lo); hi=Math.min(MAX,hi);
    lmn.textContent=fmt(lo); lmx.textContent=fmt(hi);
    var plo=((lo-MIN)/(MAX-MIN))*100,phi=((hi-MIN)/(MAX-MIN))*100;
    fill.style.left=plo+'%'; fill.style.width=(phi-plo)+'%';
  }
  mn.addEventListener('input',function(){ upd('min'); });
  mx.addEventListener('input',function(){ upd('max'); });
  btn.addEventListener('click',function(){
    var lo=parseInt(mn.value),hi=parseInt(mx.value);
    var url=new URL(window.location.href);
    url.searchParams.set('min_price',lo);
    url.searchParams.set('max_price',hi);
    url.searchParams.delete('paged');
    url.searchParams.delete('page');
    window.location.href=url.toString();
  });
  upd('max');
})();
</script>

<!-- ATC + Scroll-restore + Toast JS -->
<script>
(function(){

  /* ══════════════════════════════════════════
     TOAST
  ══════════════════════════════════════════ */
  var toast       = document.getElementById('travotech-toast');
  var toastNameEl = document.getElementById('cv-toast-name');
  var toastBar    = document.getElementById('cv-toast-bar');
  var closeBtn    = document.getElementById('cv-toast-close');
  var hideTimer   = null;

  function showToast(name) {
    if (!toast) return;
    if (toastNameEl) toastNameEl.textContent = name || '';
    if (toastBar) {
      toastBar.style.animation = 'none';
      void toastBar.offsetWidth;
      toastBar.style.animation = '';
    }
    toast.classList.add('cv-show');
    if (hideTimer) clearTimeout(hideTimer);
    hideTimer = setTimeout(function(){ toast.classList.remove('cv-show'); }, 5000);
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', function(){
      toast.classList.remove('cv-show');
      if (hideTimer) clearTimeout(hideTimer);
    });
  }

  /* ══════════════════════════════════════════
     ON PAGE LOAD — restore scroll + show toast
     if we came back from an add-to-cart reload
  ══════════════════════════════════════════ */
  var params      = new URLSearchParams(window.location.search);
  var toastName   = params.get('cv_added_name');
  var savedScroll = sessionStorage.getItem('cv_scroll_pos');

  if (toastName) {
    /* Restore scroll immediately — before any paint */
    if (savedScroll !== null) {
      var scrollY = parseInt(savedScroll, 10);
      window.scrollTo(0, scrollY);
    }

    /* Restore again after full load (browser sometimes overrides) */
    window.addEventListener('load', function() {
      if (savedScroll !== null) window.scrollTo(0, parseInt(savedScroll, 10));
      sessionStorage.removeItem('cv_scroll_pos');
    });

    /* Show toast once DOM is ready */
    document.addEventListener('DOMContentLoaded', function() {
      if (savedScroll !== null) window.scrollTo(0, parseInt(savedScroll, 10));
      showToast(decodeURIComponent(toastName));
    });

    /* Clean the URL — remove our params so refresh doesn't re-toast */
    var cleanUrl = new URL(window.location.href);
    cleanUrl.searchParams.delete('cv_added_name');
    cleanUrl.searchParams.delete('added-to-cart');
    cleanUrl.searchParams.delete('add-to-cart');
    window.history.replaceState(null, '', cleanUrl.toString());
  }

  /* ══════════════════════════════════════════
     ADD TO CART — save scroll → reload
     WC processes the add natively on reload.
     Page comes back to exact same Y position.
     Toast appears. Cart count updates.
  ══════════════════════════════════════════ */
  document.querySelectorAll('.travotech-atc-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();

      var pid  = btn.getAttribute('data-pid');
      var name = btn.getAttribute('data-name');

      /* Save scroll position to sessionStorage before navigating */
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
      sessionStorage.setItem('cv_scroll_pos', scrollY);

      /* Loading feedback */
      btn.classList.add('atc-loading');
      var txtEl = btn.querySelector('.p-atc-txt');
      if (txtEl) txtEl.textContent = 'Adding…';

      /* Build URL: WC ?add-to-cart=X processes the add on load */
      var url = new URL(window.location.href);
      url.searchParams.set('add-to-cart',   pid);
      url.searchParams.set('quantity',      '1');
      url.searchParams.set('cv_added_name', encodeURIComponent(name));

      window.location.href = url.toString();
    });
  });

})();
</script>

<?php get_footer(); ?>
