<?php
/**
 * Travotech Agencies - archive-product.php (Shop + category pages)
 * Classes are prefixed sh- so older CSS cannot clash. Uses theme variables from header.php.
 */
get_header();
global $wp_query, $wpdb;

$sh_wa   = preg_replace( '/\D+/', '', (string) get_option( 'travotech_wa', get_option( 'trovatech_wa', '254720737151' ) ) );
$sh_page = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
$sh_shop = $sh_page > 0 ? get_permalink( $sh_page ) : home_url( '/shop/' );
$sh_hero = get_template_directory_uri() . '/assets/js/images/shopbg.png';

/* Page title + intro (good for SEO) */
$sh_term  = is_product_category() ? get_queried_object() : null;
$sh_title = $sh_term ? $sh_term->name : ( is_search() ? 'Search results for ' . get_search_query() : 'Shop Laboratory & Hospital Equipment' );
$sh_intro = ( $sh_term && trim( wp_strip_all_tags( $sh_term->description ) ) !== '' )
    ? wp_strip_all_tags( $sh_term->description )
    : 'Browse quality laboratory and hospital equipment in Kenya. Order online or via WhatsApp, with delivery in Nairobi, Thika and across the country.';

/* Price slider range (from your real prices) */
$sh_top  = (float) $wpdb->get_var( "SELECT MAX(CAST(meta_value AS DECIMAL(12,2))) FROM {$wpdb->postmeta} WHERE meta_key='_price' AND meta_value<>''" );
$sh_max  = max( 1000, (int) ( ceil( $sh_top / 1000 ) * 1000 ) );
$sh_step = $sh_max > 20000 ? 500 : 100;
$cur_min = isset( $_GET['min_price'] ) ? max( 0, (int) $_GET['min_price'] ) : 0;
$cur_max = isset( $_GET['max_price'] ) ? min( $sh_max, (int) $_GET['max_price'] ) : $sh_max;
if ( $cur_max <= $cur_min ) { $cur_min = 0; $cur_max = $sh_max; }
$sh_filtered = ( $cur_min > 0 || $cur_max < $sh_max );

/* Sorting */
$sh_sorts = array(
    'menu_order' => 'Default sorting',
    'popularity' => 'Sort by popularity',
    'date'       => 'Sort by latest',
    'price'      => 'Price: low to high',
    'price-desc' => 'Price: high to low',
);
$sh_orderby = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : 'menu_order';

/* Pagination numbers */
$sh_curr  = max( 1, (int) get_query_var( 'paged' ) );
$sh_total = (int) $wp_query->max_num_pages;
$sh_found = (int) $wp_query->found_posts;
$sh_pp    = max( 1, (int) $wp_query->get( 'posts_per_page' ) );
$sh_from  = $sh_found ? ( $sh_curr - 1 ) * $sh_pp + 1 : 0;
$sh_to    = min( $sh_found, $sh_curr * $sh_pp );
$sh_drop  = array( 'add-to-cart', 'added-to-cart', 'quantity', 'cv_added_name' );
$sh_link  = function ( $n ) use ( $sh_drop ) { return esc_url( remove_query_arg( $sh_drop, get_pagenum_link( $n ) ) ); };

/* Category icon helper */
$sh_icon = function ( $name ) {
    $n   = strtolower( $name );
    $map = array( 'glove' => 'fa-hand', 'consum' => 'fa-hand', 'furnit' => 'fa-bed', 'hospital' => 'fa-bed', 'bed' => 'fa-bed', 'surg' => 'fa-scissors', 'diagnos' => 'fa-stethoscope', 'lab' => 'fa-flask', 'monitor' => 'fa-heart-pulse', 'pharm' => 'fa-pills', 'medic' => 'fa-pills', 'access' => 'fa-kit-medical', 'test' => 'fa-vial' );
    foreach ( $map as $k => $i ) { if ( strpos( $n, $k ) !== false ) { return $i; } }
    return 'fa-box-open';
};

/* Sidebar categories */
$sh_cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'orderby' => 'name', 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
if ( is_wp_error( $sh_cats ) ) { $sh_cats = array(); }
?>
<style>
.sh{font-family:var(--th-fb,'Inter',system-ui,sans-serif);color:#1b2230;line-height:1.55;}
.sh *{box-sizing:border-box;}
.sh a{text-decoration:none;}
.sh img{max-width:100%;}
.sh h1,.sh h2,.sh h3{font-family:var(--th-fh,'Oswald','Arial Narrow',sans-serif);margin:0;color:var(--th-dk,#0c3a27);line-height:1.2;}
.sh a:focus-visible,.sh button:focus-visible,.sh select:focus-visible{outline:3px solid var(--th-red,#e53935);outline-offset:2px;}

/* Hero */
.sh-hero{position:relative;min-height:clamp(190px,26vw,300px);display:flex;align-items:center;background:var(--th-dk,#0c3a27);overflow:hidden;}
.sh-hero>img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:right center;}
.sh-hero-in{position:relative;z-index:1;width:100%;max-width:1280px;margin:0 auto;padding:24px clamp(14px,4vw,48px);}
.sh-hero-box{max-width:560px;background:rgba(12,58,39,.92);color:#fff;padding:20px 24px;border-left:5px solid var(--th-red,#e53935);border-radius:6px;}
.sh-hero h1{color:#fff;font-size:clamp(1.5rem,3.6vw,2.4rem);}
.sh-hero p{margin:8px 0 0;font-size:clamp(.88rem,1.4vw,1rem);color:rgba(255,255,255,.92);}

/* Layout */
.sh-wrap{max-width:1280px;margin:0 auto;padding:clamp(16px,3vw,32px) clamp(14px,4vw,48px) 56px;display:grid;grid-template-columns:270px minmax(0,1fr);gap:28px;align-items:start;}
.sh-filter-toggle{display:none;}

/* Sidebar */
.sh-side{position:sticky;top:150px;display:flex;flex-direction:column;gap:16px;max-height:calc(100vh - 170px);overflow-y:auto;scrollbar-width:thin;}
.sh-widget{background:#fff;border:1px solid #dfe8e3;border-radius:10px;overflow:hidden;box-shadow:0 2px 10px rgba(12,58,39,.06);}
.sh-wt{background:var(--th-dk,#0c3a27);color:#fff;font:600 16px var(--th-fh,'Oswald',sans-serif);letter-spacing:.04em;text-transform:uppercase;padding:13px 16px;border-bottom:3px solid var(--th-red,#e53935);display:flex;align-items:center;gap:10px;}
.sh-wb{padding:10px;}
.sh-cats{list-style:none;margin:0;padding:0;}
.sh-cats li a{display:flex;align-items:center;gap:10px;padding:10px 10px;border-radius:8px;font-size:.9rem;font-weight:600;color:var(--th-dk,#0c3a27);transition:background .15s,color .15s;}
.sh-cats li a i.ic{width:20px;text-align:center;color:var(--th-g,#238a56);}
.sh-cats li a .n{margin-left:auto;font-size:.72rem;font-weight:700;background:var(--th-lt,#e8f6ef);color:var(--th-g,#238a56);padding:2px 8px;border-radius:50px;}
.sh-cats li a:hover,.sh-cats li a.on{background:var(--th-lt,#e8f6ef);color:var(--th-g,#238a56);}
.sh-cats li a.on{box-shadow:inset 3px 0 0 var(--th-red,#e53935);}
.sh-sub{list-style:none;margin:2px 0 6px 30px;padding:0;border-left:2px solid #dfe8e3;}
.sh-sub a{padding:7px 10px;font-size:.82rem;font-weight:600;color:#4b5563;display:block;border-radius:6px;}
.sh-sub a:hover,.sh-sub a.on{color:var(--th-g,#238a56);background:var(--th-lt,#e8f6ef);}

/* Price filter */
.sh-pr{padding:16px 16px 18px;}
.sh-pr-lab{display:flex;justify-content:space-between;font-size:.82rem;font-weight:700;color:var(--th-dk,#0c3a27);margin-bottom:6px;}
.sh-track{position:relative;height:26px;margin:6px 0 10px;}
.sh-track-bg,.sh-track-fill{position:absolute;top:10px;height:6px;border-radius:3px;}
.sh-track-bg{left:0;right:0;background:#dfe8e3;}
.sh-track-fill{background:var(--th-g,#238a56);}
.sh-track input{position:absolute;left:0;top:3px;width:100%;height:20px;margin:0;background:transparent;pointer-events:none;-webkit-appearance:none;appearance:none;}
.sh-track input::-webkit-slider-thumb{-webkit-appearance:none;width:20px;height:20px;border-radius:50%;background:#fff;border:3px solid var(--th-g,#238a56);cursor:pointer;pointer-events:all;box-shadow:0 2px 6px rgba(0,0,0,.2);}
.sh-track input::-moz-range-thumb{width:16px;height:16px;border-radius:50%;background:#fff;border:3px solid var(--th-g,#238a56);cursor:pointer;pointer-events:all;}
.sh-pr-on{display:flex;align-items:center;justify-content:space-between;gap:8px;background:var(--th-lt,#e8f6ef);border-radius:8px;padding:8px 10px;margin-bottom:12px;font-size:.78rem;font-weight:700;color:var(--th-dk,#0c3a27);}
.sh-pr-on a{color:var(--th-red,#e53935);font-weight:800;}
.sh-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px 14px;border:2px solid var(--th-g,#238a56);border-radius:6px;background:var(--th-g,#238a56);color:#fff;font:600 13px var(--th-fh,'Oswald',sans-serif);letter-spacing:.04em;text-transform:uppercase;cursor:pointer;transition:background .2s,border-color .2s;}
.sh-btn:hover{background:var(--th-dk,#0c3a27);border-color:var(--th-dk,#0c3a27);color:#fff;}
.sh-help p{margin:0 0 12px;font-size:.84rem;color:#4b5563;}
.sh-btn-wa{background:#25D366;border-color:#25D366;}
.sh-btn-wa:hover{background:#1da851;border-color:#1da851;}

/* Toolbar */
.sh-bar{display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:18px;}
.sh-sort{position:relative;}
.sh-sort select{appearance:none;-webkit-appearance:none;background:#fff;border:1.5px solid #c9d3cd;border-radius:8px;padding:10px 38px 10px 14px;font:600 14px var(--th-fb,sans-serif);color:var(--th-dk,#0c3a27);cursor:pointer;min-width:200px;}
.sh-sort i{position:absolute;right:13px;top:50%;transform:translateY(-50%);font-size:.75rem;color:var(--th-g,#238a56);pointer-events:none;}
.sh-view{display:flex;gap:6px;}
.sh-view button{width:42px;height:42px;border-radius:8px;border:1.5px solid #c9d3cd;background:#fff;color:var(--th-dk,#0c3a27);font-size:1rem;cursor:pointer;transition:background .15s,color .15s;}
.sh-view button.on,.sh-view button:hover{background:var(--th-g,#238a56);border-color:var(--th-g,#238a56);color:#fff;}
.sh-count{margin-left:auto;font-weight:700;font-size:.9rem;color:var(--th-g,#238a56);}

/* Grid + cards */
.sh-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;}
.sh-card{background:#fff;border:1px solid #dfe8e3;border-radius:10px;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 2px 10px rgba(12,58,39,.06);transition:transform .2s,box-shadow .2s;}
.sh-card:hover{transform:translateY(-4px);box-shadow:0 10px 26px rgba(12,58,39,.16);}
.sh-img{position:relative;display:flex;align-items:center;justify-content:center;height:clamp(150px,15vw,200px);background:#f4f7f5;padding:10px;flex-shrink:0;overflow:hidden;}
.sh-img img{width:100%;height:100%;object-fit:contain;display:block;}
.sh-img i.ph{font-size:2.6rem;color:var(--th-g,#238a56);opacity:.35;}
.sh-badge{position:absolute;top:10px;left:10px;z-index:1;font:700 11px var(--th-fb,sans-serif);padding:3px 10px;border-radius:4px;color:#fff;background:var(--th-red,#e53935);}
.sh-badge.new{background:var(--th-g,#238a56);}
.sh-body{padding:12px;display:flex;flex-direction:column;gap:7px;flex:1;}
.sh-chips{display:flex;gap:6px;flex-wrap:wrap;}
.sh-chip{font:700 10px var(--th-fb,sans-serif);text-transform:uppercase;letter-spacing:.05em;padding:2px 8px;border-radius:50px;background:var(--th-lt,#e8f6ef);color:var(--th-g,#238a56);}
.sh-chip.b{background:#fff;border:1px solid #c9d3cd;color:#4b5563;}
.sh-name{font-size:.98rem;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.6em;}
.sh-name a{color:var(--th-dk,#0c3a27);}
.sh-name a:hover{color:var(--th-g,#238a56);}
.sh-price{margin-top:auto;font-weight:800;color:var(--th-g,#238a56);display:flex;gap:8px;align-items:baseline;flex-wrap:wrap;}
.sh-price del{color:#9aa3ad;font-weight:500;font-size:.8rem;}
.sh-price small{font-weight:600;color:#6b7280;font-size:.75rem;}
.sh-btns{display:grid;gap:7px;margin-top:4px;}
.sh-b{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;padding:10px 8px;border-radius:6px;border:2px solid var(--th-g,#238a56);background:var(--th-g,#238a56);color:#fff;font:600 12px var(--th-fh,'Oswald',sans-serif);letter-spacing:.03em;text-transform:uppercase;line-height:1.2;text-align:center;cursor:pointer;transition:background .2s,border-color .2s;}
.sh-b:hover{background:var(--th-dk,#0c3a27);border-color:var(--th-dk,#0c3a27);color:#fff;}
.sh-b.wa{background:#25D366;border-color:#25D366;}
.sh-b.wa:hover{background:#1da851;border-color:#1da851;}
.sh-b.off{background:#e5e9e7;border-color:#e5e9e7;color:#6b7280;pointer-events:none;}
.sh-b.atc-loading{opacity:.65;pointer-events:none;}

/* List view */
.sh-grid.is-list{grid-template-columns:1fr;}
.sh-grid.is-list .sh-card{flex-direction:row;}
.sh-grid.is-list .sh-img{width:220px;height:auto;min-height:190px;}
.sh-grid.is-list .sh-body{justify-content:center;}
.sh-grid.is-list .sh-name{min-height:0;font-size:1.1rem;}
.sh-grid.is-list .sh-btns{grid-template-columns:1fr 1fr;max-width:460px;}
.sh-grid.is-list .sh-price{margin-top:0;}

/* Pagination */
.sh-pg{display:flex;gap:6px;justify-content:center;align-items:center;flex-wrap:wrap;margin-top:34px;}
.sh-pg a,.sh-pg span{min-width:40px;height:40px;padding:0 12px;display:inline-flex;align-items:center;justify-content:center;gap:6px;border-radius:8px;border:1.5px solid #c9d3cd;background:#fff;color:var(--th-dk,#0c3a27);font-weight:700;font-size:.85rem;transition:background .15s,color .15s;}
.sh-pg a:hover,.sh-pg .on{background:var(--th-g,#238a56);border-color:var(--th-g,#238a56);color:#fff;}
.sh-pg .dots{border:0;background:none;}

.sh-empty{grid-column:1/-1;text-align:center;padding:50px 16px;background:#fff;border:1px dashed #c9d3cd;border-radius:10px;}
.sh-empty i{font-size:2.6rem;color:var(--th-g,#238a56);opacity:.35;margin-bottom:12px;}
.sh-empty p{color:#4b5563;margin:8px 0 0;}
.sh-empty a{color:var(--th-g,#238a56);font-weight:700;}

/* Hide default WooCommerce notices (we show our own toast) */
.woocommerce-notices-wrapper,.woocommerce-message,.woocommerce-info,ul.woocommerce-error{display:none !important;}

/* Toast */
#travotech-toast{position:fixed;bottom:100px;right:24px;z-index:999999;width:min(340px,calc(100vw - 24px));background:var(--th-dk,#0c3a27);color:#fff;border-radius:12px;padding:14px 16px 18px;box-shadow:0 12px 40px rgba(0,0,0,.3);display:flex;align-items:flex-start;gap:12px;opacity:0;transform:translateY(20px);transition:opacity .3s,transform .3s;pointer-events:none;overflow:hidden;font-family:var(--th-fb,sans-serif);}
#travotech-toast.cv-show{opacity:1;transform:translateY(0);pointer-events:auto;}
.cv-ic{width:36px;height:36px;border-radius:50%;background:var(--th-g,#238a56);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.cv-body{flex:1;min-width:0;}
.cv-title{font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#5fd39a;margin-bottom:3px;}
.cv-name{font-size:.88rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:10px;}
.cv-act{display:flex;gap:8px;}
.cv-act a,.cv-act button{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border-radius:6px;font:700 12px var(--th-fb,sans-serif);border:0;cursor:pointer;text-decoration:none;}
.cv-act a{background:var(--th-red,#e53935);color:#fff;}
.cv-act button{background:rgba(255,255,255,.12);color:#fff;}
.cv-bar{position:absolute;left:0;right:0;bottom:0;height:4px;background:var(--th-g,#238a56);transform-origin:left;}
#travotech-toast.cv-show .cv-bar{animation:cvCount 5s linear forwards;}
@keyframes cvCount{from{transform:scaleX(1);}to{transform:scaleX(0);}}

/* Responsive */
@media (max-width:1100px){
    .sh-wrap{grid-template-columns:240px minmax(0,1fr);gap:20px;}
    .sh-grid{grid-template-columns:repeat(3,minmax(0,1fr));}
}
@media (max-width:900px){
    .sh-wrap{grid-template-columns:1fr;gap:14px;}
    .sh-filter-toggle{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:12px;border-radius:8px;border:2px solid var(--th-dk,#0c3a27);background:var(--th-dk,#0c3a27);color:#fff;font:600 14px var(--th-fh,'Oswald',sans-serif);letter-spacing:.04em;text-transform:uppercase;cursor:pointer;}
    .sh-side{display:none;position:static;max-height:none;overflow:visible;}
    .sh-side.open{display:flex;}
    .sh-grid{grid-template-columns:repeat(3,minmax(0,1fr));}
}
@media (max-width:700px){
    .sh-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;}
    .sh-count{margin-left:0;width:100%;order:3;}
    .sh-sort{flex:1;}
    .sh-sort select{width:100%;min-width:0;}
    .sh-hero-box{padding:16px 18px;}
}
@media (max-width:560px){
    .sh-img{height:140px;padding:8px;}
    .sh-body{padding:10px;gap:6px;}
    .sh-name{font-size:.86rem;}
    .sh-b{font-size:11px;padding:9px 4px;letter-spacing:0;}
    .sh-grid.is-list .sh-card{flex-direction:row;}
    .sh-grid.is-list .sh-img{width:120px;min-height:150px;}
    .sh-grid.is-list .sh-btns{grid-template-columns:1fr;}
    .sh-pg a,.sh-pg span{min-width:36px;height:36px;padding:0 9px;}
    #travotech-toast{right:12px;left:12px;width:auto;bottom:84px;}
}
@media (max-width:340px){.sh-grid{grid-template-columns:1fr;}}

/* ---- Fixes v2 ---- */
/* Sidebar box titles: white on dark green */
.sh .sh-wt,.sh h2.sh-wt{color:#fff;}
.sh .sh-wt i{color:#fff;}

/* Phones: always 2 products per row, no list view */
@media (max-width:700px){
    .sh .sh-view{display:none;}
    .sh .sh-grid,.sh .sh-grid.is-list{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;}
    .sh .sh-grid.is-list .sh-card{flex-direction:column;}
    .sh .sh-grid.is-list .sh-img{width:auto;height:140px;min-height:0;}
    .sh .sh-grid.is-list .sh-btns{grid-template-columns:1fr;max-width:none;}
    .sh .sh-grid.is-list .sh-name{font-size:.86rem;min-height:2.6em;}
    .sh .sh-grid.is-list .sh-price{margin-top:auto;}
}
@media (max-width:380px){
    .sh .sh-img{height:120px !important;}
    .sh .sh-b{font-size:10px;padding:8px 2px;}
    .sh .sh-name{font-size:.8rem;}
    .sh .sh-body{padding:8px;}
}

/* ---- Fixes v3 ---- */
/* Sidebar boxes must never shrink */
.sh .sh-widget{flex:0 0 auto;overflow:visible;}
.sh .sh-wt{border-radius:10px 10px 0 0;}
.sh .sh-wb,.sh .sh-pr{display:block;min-height:0;}
.sh .sh-widget:last-child{border-radius:10px;}

/* Long category lists scroll inside their own box */
.sh .sh-wb>.sh-cats{max-height:320px;overflow-y:auto;scrollbar-width:thin;padding-right:4px;}

/* Price slider: make sure it is visible and clickable */
.sh .sh-pr{padding:16px 16px 18px;}
.sh .sh-track{display:block;height:28px;}
.sh .sh-track input{display:block;}
.sh .sh-btn{min-height:44px;}
</style>

<div id="travotech-toast" role="alert" aria-live="assertive">
    <div class="cv-ic"><i class="fa-solid fa-check" aria-hidden="true"></i></div>
    <div class="cv-body">
        <div class="cv-title">Added to cart</div>
        <div class="cv-name" id="cv-toast-name"></div>
        <div class="cv-act">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> View cart</a>
            <button type="button" id="cv-toast-close">Dismiss</button>
        </div>
    </div>
    <div class="cv-bar" id="cv-toast-bar"></div>
</div>

<main class="sh" id="main">

    <section class="sh-hero" aria-labelledby="sh-h1">
        <img src="<?php echo esc_url( $sh_hero ); ?>" alt="Laboratory and hospital equipment on sale at Travotech Agencies" width="1600" height="400" fetchpriority="high" decoding="async">
        <div class="sh-hero-in">
            <div class="sh-hero-box">
                <h1 id="sh-h1"><?php echo esc_html( $sh_title ); ?></h1>
                <p><?php echo esc_html( $sh_intro ); ?></p>
            </div>
        </div>
    </section>

    <div class="sh-wrap">

        <button type="button" class="sh-filter-toggle" id="shFilterBtn" aria-expanded="false" aria-controls="shSide"><i class="fa-solid fa-sliders" aria-hidden="true"></i> Categories &amp; filters</button>

        <!-- SIDEBAR -->
        <aside class="sh-side" id="shSide" aria-label="Shop filters">

            <div class="sh-widget">
                <h2 class="sh-wt"><i class="fa-solid fa-table-cells-large" aria-hidden="true"></i> Categories</h2>
                <div class="sh-wb">
                    <ul class="sh-cats">
                        <li><a href="<?php echo esc_url( $sh_shop ); ?>"<?php echo ! $sh_term ? ' class="on"' : ''; ?>><i class="fa-solid fa-border-all ic" aria-hidden="true"></i> All products <span class="n"><?php echo (int) wp_count_posts( 'product' )->publish; ?></span></a></li>
                        <?php foreach ( $sh_cats as $c ) :
                            $cu = get_term_link( $c );
                            if ( is_wp_error( $cu ) ) { continue; }
                            $cnt  = (int) get_term_meta( $c->term_id, 'product_count_product_cat', true );
                            if ( ! $cnt ) { $cnt = (int) $c->count; }
                            $open = $sh_term && ( $sh_term->term_id === $c->term_id || term_is_ancestor_of( $c->term_id, $sh_term->term_id, 'product_cat' ) );
                            ?>
                        <li>
                            <a href="<?php echo esc_url( $cu ); ?>"<?php echo $open ? ' class="on"' : ''; ?>><i class="fa-solid <?php echo esc_attr( $sh_icon( $c->name ) ); ?> ic" aria-hidden="true"></i> <?php echo esc_html( $c->name ); ?> <span class="n"><?php echo $cnt; ?></span></a>
                            <?php if ( $open ) :
                                $kids = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => $c->term_id ) );
                                if ( ! is_wp_error( $kids ) && $kids ) : ?>
                            <ul class="sh-sub">
                                <?php foreach ( $kids as $k ) : $ku = get_term_link( $k ); if ( is_wp_error( $ku ) ) { continue; } ?>
                                <li><a href="<?php echo esc_url( $ku ); ?>"<?php echo ( $sh_term && $sh_term->term_id === $k->term_id ) ? ' class="on"' : ''; ?>><?php echo esc_html( $k->name ); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="sh-widget">
                <h2 class="sh-wt"><i class="fa-solid fa-tags" aria-hidden="true"></i> Price range</h2>
                <div class="sh-pr">
                    <?php if ( $sh_filtered ) : ?>
                    <div class="sh-pr-on"><span>KES <?php echo number_format( $cur_min ); ?> - KES <?php echo number_format( $cur_max ); ?></span><a href="#" id="shClear">Clear</a></div>
                    <?php endif; ?>
                    <div class="sh-pr-lab"><span id="shLo">KES <?php echo number_format( $cur_min ); ?></span><span id="shHi">KES <?php echo number_format( $cur_max ); ?></span></div>
                    <div class="sh-track">
                        <div class="sh-track-bg"></div><div class="sh-track-fill" id="shFill"></div>
                        <input type="range" id="shMin" min="0" max="<?php echo (int) $sh_max; ?>" step="<?php echo (int) $sh_step; ?>" value="<?php echo (int) $cur_min; ?>" aria-label="Minimum price">
                        <input type="range" id="shMax" min="0" max="<?php echo (int) $sh_max; ?>" step="<?php echo (int) $sh_step; ?>" value="<?php echo (int) $cur_max; ?>" aria-label="Maximum price">
                    </div>
                    <button type="button" class="sh-btn" id="shApply"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply filter</button>
                </div>
            </div>

            <div class="sh-widget sh-help">
                <h2 class="sh-wt"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Quick order</h2>
                <div class="sh-wb" style="padding:14px 16px 16px;">
                    <p>Can&rsquo;t find what you need? Send us a WhatsApp message.</p>
                    <a class="sh-btn sh-btn-wa" href="https://wa.me/<?php echo esc_attr( $sh_wa ); ?>?text=<?php echo rawurlencode( "Hello Travotech Agencies, I'm looking for a product and need help." ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Ask on WhatsApp</a>
                </div>
            </div>
        </aside>

        <!-- PRODUCTS -->
        <section aria-label="Products">
            <div class="sh-bar">
                <div class="sh-sort">
                    <select id="shSort" aria-label="Sort products">
                        <?php foreach ( $sh_sorts as $k => $v ) : ?>
                        <option value="<?php echo esc_attr( $k ); ?>"<?php selected( $sh_orderby, $k ); ?>><?php echo esc_html( $v ); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                </div>
                <div class="sh-view" role="group" aria-label="Product layout">
                    <button type="button" id="shGrid" class="on" aria-label="Grid view"><i class="fa-solid fa-table-cells" aria-hidden="true"></i></button>
                    <button type="button" id="shList" aria-label="List view"><i class="fa-solid fa-list" aria-hidden="true"></i></button>
                </div>
                <div class="sh-count"><?php echo $sh_found ? 'Showing ' . (int) $sh_from . '&ndash;' . (int) $sh_to . ' of ' . (int) $sh_found . ' products' : 'No products found'; ?></div>
            </div>

            <div class="sh-grid" id="shProducts">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                $product = wc_get_product( get_the_ID() );
                if ( ! $product ) { continue; }
                $pid   = $product->get_id();
                $pname = $product->get_name();
                $purl  = get_permalink( $pid );
                $pc    = $product->get_price();
                $pr    = $product->get_regular_price();
                $isvar = $product->is_type( 'variable' );
                $sale  = $product->is_on_sale();
                $cr    = $product->get_date_created();
                $isnew = $cr && ( time() - $cr->getTimestamp() ) < ( 30 * DAY_IN_SECONDS );
                $pcats = get_the_terms( $pid, 'product_cat' );
                $cat_n = ( $pcats && ! is_wp_error( $pcats ) ) ? $pcats[0]->name : '';
                $brs   = get_the_terms( $pid, 'product_brand' );
                if ( ! $brs || is_wp_error( $brs ) ) { $brs = get_the_terms( $pid, 'pa_brand' ); }
                $brand = ( $brs && ! is_wp_error( $brs ) ) ? $brs[0]->name : '';
                $can   = $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && $pc !== '';
                $oos   = ! $product->is_in_stock();
                $short = mb_strlen( $pname ) > 30 ? mb_substr( $pname, 0, 30 ) . '...' : $pname;
                $pshow = $isvar ? (float) $product->get_variation_price( 'min' ) : (float) $pc;
                $wamsg = rawurlencode( "Hello Travotech Agencies, I'd like to order: *" . $pname . '*' . ( $pc !== '' ? ' - KES ' . number_format( $pshow, 2 ) : '' ) . '. Link: ' . $purl );
                $thumb = get_the_post_thumbnail( $pid, 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'alt' => $pname ) );
                ?>
                <article class="sh-card" id="pcard-<?php echo (int) $pid; ?>">
                    <a class="sh-img" href="<?php echo esc_url( $purl ); ?>" aria-label="<?php echo esc_attr( $pname ); ?>">
                        <?php if ( $sale && ! $isvar && $pr ) : ?><span class="sh-badge">-<?php echo (int) round( ( ( $pr - $pc ) / $pr ) * 100 ); ?>%</span>
                        <?php elseif ( $isnew ) : ?><span class="sh-badge new">New</span><?php endif; ?>
                        <?php echo $thumb ? $thumb : '<i class="fa-solid fa-flask-vial ph" aria-hidden="true"></i>'; // phpcs:ignore ?>
                    </a>
                    <div class="sh-body">
                        <?php if ( $cat_n || $brand ) : ?>
                        <div class="sh-chips">
                            <?php if ( $cat_n ) : ?><span class="sh-chip"><?php echo esc_html( $cat_n ); ?></span><?php endif; ?>
                            <?php if ( $brand ) : ?><span class="sh-chip b"><?php echo esc_html( $brand ); ?></span><?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <h3 class="sh-name"><a href="<?php echo esc_url( $purl ); ?>"><?php echo esc_html( $pname ); ?></a></h3>
                        <div class="sh-price">
                            <?php if ( $pc === '' ) : ?>Price on request
                            <?php else : ?>
                                <?php if ( $isvar ) : ?><small>From</small><?php endif; ?>
                                <?php if ( $sale && ! $isvar && $pr ) : ?><del>KES <?php echo number_format( (float) $pr, 2 ); ?></del><?php endif; ?>
                                <span>KES <?php echo number_format( $pshow, 2 ); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="sh-btns">
                            <?php if ( $can ) : ?>
                            <button type="button" class="sh-b sh-atc" data-pid="<?php echo (int) $pid; ?>" data-name="<?php echo esc_attr( $short ); ?>"><i class="fa-solid fa-cart-plus" aria-hidden="true"></i> <span class="t">Add to cart</span></button>
                            <?php elseif ( $oos ) : ?>
                            <span class="sh-b off"><i class="fa-solid fa-ban" aria-hidden="true"></i> Out of stock</span>
                            <?php else : ?>
                            <a class="sh-b" href="<?php echo esc_url( $purl ); ?>"><i class="fa-solid fa-list-check" aria-hidden="true"></i> <?php echo $isvar ? 'Select options' : 'View details'; ?></a>
                            <?php endif; ?>
                            <a class="sh-b wa" href="https://wa.me/<?php echo esc_attr( $sh_wa ); ?>?text=<?php echo $wamsg; ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Order via WhatsApp</a>
                        </div>
                    </div>
                </article>
            <?php endwhile; else : ?>
                <div class="sh-empty">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <h2>No products found</h2>
                    <p>
                        <?php if ( $sh_filtered ) : ?>Nothing in this price range. <a href="#" id="shClear2">Clear the filter</a> or <?php endif; ?>
                        <a href="https://wa.me/<?php echo esc_attr( $sh_wa ); ?>" target="_blank" rel="noopener noreferrer">ask us on WhatsApp</a>.
                    </p>
                </div>
            <?php endif; ?>
            </div>

            <?php if ( $sh_total > 1 ) : ?>
            <nav class="sh-pg" aria-label="Product pages">
                <?php if ( $sh_curr > 1 ) : ?><a href="<?php echo $sh_link( $sh_curr - 1 ); // phpcs:ignore ?>" rel="prev"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i> Prev</a><?php endif; ?>
                <?php
                $show = array();
                for ( $i = 1; $i <= $sh_total; $i++ ) { if ( $i === 1 || $i === $sh_total || abs( $i - $sh_curr ) <= 2 ) { $show[] = $i; } }
                $prev = 0;
                foreach ( $show as $pg ) :
                    if ( $prev && $pg - $prev > 1 ) : ?><span class="dots">&hellip;</span><?php endif;
                    if ( $pg === $sh_curr ) : ?><span class="on" aria-current="page"><?php echo (int) $pg; ?></span>
                    <?php else : ?><a href="<?php echo $sh_link( $pg ); // phpcs:ignore ?>"><?php echo (int) $pg; ?></a><?php endif;
                    $prev = $pg;
                endforeach; ?>
                <?php if ( $sh_curr < $sh_total ) : ?><a href="<?php echo $sh_link( $sh_curr + 1 ); // phpcs:ignore ?>" rel="next">Next <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a><?php endif; ?>
            </nav>
            <?php endif; ?>
        </section>
    </div>
</main>

<script>
(function(){
    var $=function(id){return document.getElementById(id);};

    /* Clean URL helper: drops page number and one-time cart params */
    function cleanUrl(){
        var u=new URL(window.location.href);
        u.pathname=u.pathname.replace(/\/page\/\d+\/?$/,'/');
        ['paged','page','add-to-cart','added-to-cart','quantity','cv_added_name'].forEach(function(k){u.searchParams.delete(k);});
        return u;
    }

    /* Sort */
    var sort=$('shSort');
    if(sort){sort.addEventListener('change',function(){var u=cleanUrl();u.searchParams.set('orderby',sort.value);window.location.href=u.toString();});}

    /* Mobile filters */
    var fb=$('shFilterBtn'),side=$('shSide');
    if(fb&&side){fb.addEventListener('click',function(){var o=side.classList.toggle('open');fb.setAttribute('aria-expanded',o?'true':'false');});}

    /* Grid / list toggle */
    var grid=$('shProducts'),bg=$('shGrid'),bl=$('shList');
    function setView(v){
        if(!grid)return;
        grid.classList.toggle('is-list',v==='list');
        if(bg)bg.classList.toggle('on',v!=='list');
        if(bl)bl.classList.toggle('on',v==='list');
        try{localStorage.setItem('sh_view',v);}catch(e){}
    }
    if(bg)bg.addEventListener('click',function(){setView('grid');});
    if(bl)bl.addEventListener('click',function(){setView('list');});
    try{if(localStorage.getItem('sh_view')==='list'){setView('list');}}catch(e){}

    /* Price slider */
    var mn=$('shMin'),mx=$('shMax');
    if(mn&&mx){
        var MAX=parseInt(mx.max,10),STEP=parseInt(mn.step,10)||100;
        var lo=$('shLo'),hi=$('shHi'),fill=$('shFill');
        var fmt=function(n){return 'KES '+Number(n).toLocaleString();};
        var upd=function(moved){
            var a=parseInt(mn.value,10),b=parseInt(mx.value,10);
            if(a>b-STEP){if(moved==='min'){a=b-STEP;mn.value=a;}else{b=a+STEP;mx.value=b;}}
            lo.textContent=fmt(a);hi.textContent=fmt(b);
            var pa=a/MAX*100,pb=b/MAX*100;fill.style.left=pa+'%';fill.style.width=(pb-pa)+'%';
        };
        mn.addEventListener('input',function(){upd('min');});
        mx.addEventListener('input',function(){upd('max');});
        upd('max');
        $('shApply').addEventListener('click',function(){
            var u=cleanUrl();u.searchParams.set('min_price',mn.value);u.searchParams.set('max_price',mx.value);window.location.href=u.toString();
        });
    }
    ['shClear','shClear2'].forEach(function(id){
        var c=$(id);if(c)c.addEventListener('click',function(e){e.preventDefault();var u=cleanUrl();u.searchParams.delete('min_price');u.searchParams.delete('max_price');window.location.href=u.toString();});
    });

    /* Toast */
    var toast=$('travotech-toast'),tn=$('cv-toast-name'),bar=$('cv-toast-bar'),tc=$('cv-toast-close'),timer=null;
    function showToast(name){
        if(!toast)return;
        if(tn)tn.textContent=name||'';
        if(bar){bar.style.animation='none';void bar.offsetWidth;bar.style.animation='';}
        toast.classList.add('cv-show');
        if(timer)clearTimeout(timer);
        timer=setTimeout(function(){toast.classList.remove('cv-show');},5000);
    }
    if(tc)tc.addEventListener('click',function(){toast.classList.remove('cv-show');if(timer)clearTimeout(timer);});

    /* After an add-to-cart reload: restore scroll, show toast, clean the URL */
    var params=new URLSearchParams(window.location.search);
    var added=params.get('cv_added_name');
    var saved=null;try{saved=sessionStorage.getItem('cv_scroll_pos');}catch(e){}
    if(added){
        if(saved!==null){window.scrollTo(0,parseInt(saved,10));}
        window.addEventListener('load',function(){if(saved!==null){window.scrollTo(0,parseInt(saved,10));}try{sessionStorage.removeItem('cv_scroll_pos');}catch(e){}});
        document.addEventListener('DOMContentLoaded',function(){showToast(added);});
        var cu=new URL(window.location.href);
        ['cv_added_name','added-to-cart','add-to-cart','quantity'].forEach(function(k){cu.searchParams.delete(k);});
        window.history.replaceState(null,'',cu.toString());
    }

    /* Add to cart: save scroll, let WooCommerce add the item, come back to the same spot */
    document.querySelectorAll('.sh-atc').forEach(function(btn){
        btn.addEventListener('click',function(e){
            e.preventDefault();
            try{sessionStorage.setItem('cv_scroll_pos',String(window.pageYOffset||document.documentElement.scrollTop||0));}catch(x){}
            btn.classList.add('atc-loading');
            var t=btn.querySelector('.t');if(t)t.textContent='Adding...';
            var u=new URL(window.location.href);
            u.searchParams.set('add-to-cart',btn.getAttribute('data-pid'));
            u.searchParams.set('quantity','1');
            u.searchParams.set('cv_added_name',btn.getAttribute('data-name'));
            window.location.href=u.toString();
        });
    });
})();
</script>

<?php get_footer(); ?>