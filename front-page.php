<?php
/**
 * Travotech Agencies - front-page.php (Home page)
 * Uses the theme variables from header.php (--th-g, --th-dk, --th-red ...).
 * All classes are prefixed hp- so nothing clashes with old CSS.
 */
get_header();

/* ---------- Settings you may edit ---------- */
$hp_img_dir = get_template_directory_uri() . '/assets/js/images/';
$hp_hero    = $hp_img_dir . 'homebg.png';    // single hero image (no slider)
$hp_about   = $hp_img_dir . 'homebg2.png';   // image beside the About text

$hp_shop = ( function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0 ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
$hp_pg   = function ( array $slugs, $fallback ) {
    foreach ( $slugs as $s ) { $p = get_page_by_path( $s ); if ( $p ) { return get_permalink( $p ); } }
    return home_url( $fallback );
};
$hp_contact = $hp_pg( array( 'contact', 'contact-us' ), '/contact/' );
$hp_about_u = $hp_pg( array( 'about-us', 'about' ), '/about-us/' );
$hp_wa      = preg_replace( '/\D+/', '', (string) get_option( 'travotech_wa', '254720737151' ) );

$hp_trust = array(
    array( 'fa-shield-halved', 'Quality assured products' ),
    array( 'fa-handshake',     'Reliable supply partner' ),
    array( 'fa-headset',       'Expert product support' ),
    array( 'fa-truck-fast',    'Timely delivery in Kenya' ),
);
$hp_why = array(
    array( 'fa-circle-check', 'Premium quality products', 'Every laboratory and hospital item we stock comes from trusted manufacturers and is checked before it reaches you.' ),
    array( 'fa-user-doctor',  'Professional support', 'Our team helps you choose the right equipment for your clinic, laboratory or hospital, and supports you after the sale.' ),
    array( 'fa-tags',         'Competitive prices', 'Fair, transparent pricing for individual buyers, clinics and institutions buying in bulk.' ),
    array( 'fa-truck-fast',   'Fast and reliable delivery', 'We deliver in Nairobi, Thika and across Kenya, so your equipment arrives when you need it.' ),
);
/* REPLACE these with real customer feedback before going live */
$hp_reviews = array(
    array( 'Add a real customer review here.', 'Customer name', 'Clinic, Nairobi' ),
    array( 'Add a real customer review here.', 'Customer name', 'Laboratory, Thika' ),
    array( 'Add a real customer review here.', 'Customer name', 'Hospital, Kenya' ),
);

$hp_reviews = array_values( array_filter( $hp_reviews, function ( $r ) { return stripos( $r[0], 'Add a real' ) === false; } ) );

/* ---------- Helpers ---------- */
$hp_cat_img = function ( $term ) {
    if ( function_exists( 'wc_get_products' ) ) {
        $ps = wc_get_products( array( 'status' => 'publish', 'limit' => 12, 'category' => array( $term->slug ), 'return' => 'objects' ) );
        foreach ( $ps as $p ) {
            $id = $p->get_image_id();
            if ( $id ) { $u = wp_get_attachment_image_url( $id, 'medium' ); if ( $u ) { return $u; } }
        }
    }
    $tid = get_term_meta( $term->term_id, 'thumbnail_id', true );
    return $tid ? (string) wp_get_attachment_image_url( $tid, 'medium' ) : '';
};
$hp_card = function ( $p ) use ( $hp_wa ) {
    $name  = $p->get_name();
    $pid   = $p->get_id();
    $url   = get_permalink( $pid );
    $pc    = $p->get_price();
    $isvar = $p->is_type( 'variable' );
    $can   = $p->is_type( 'simple' ) && $p->is_purchasable() && $p->is_in_stock() && $pc !== '';
    $oos   = ! $p->is_in_stock();
    $short = mb_strlen( $name ) > 30 ? mb_substr( $name, 0, 30 ) . '...' : $name;
    $pshow = $isvar ? (float) $p->get_variation_price( 'min' ) : (float) $pc;
    $wamsg = rawurlencode( "Hello Travotech Agencies, I'd like to order: *" . $name . '*' . ( $pc !== '' ? ' - KES ' . number_format( $pshow, 2 ) : '' ) . '. Link: ' . $url );
    ?>
    <article class="hp-card">
        <a class="hp-card-img" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $name ); ?>">
            <?php if ( $p->is_on_sale() ) : ?><span class="hp-sale">Sale</span><?php endif; ?>
            <?php echo $p->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'alt' => $name ) ); // phpcs:ignore ?>
        </a>
        <div class="hp-card-body">
            <h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $name ); ?></a></h3>
            <div class="hp-price"><?php echo wp_kses_post( $p->get_price_html() ); ?></div>
            <div class="hp-actions">
                <?php if ( $can ) : ?>
                <button type="button" class="hp-btn hp-btn-sm hp-atc" data-pid="<?php echo (int) $pid; ?>" data-name="<?php echo esc_attr( $short ); ?>"><i class="fa-solid fa-cart-plus" aria-hidden="true"></i> <span class="t">Add to cart</span></button>
                <?php elseif ( $oos ) : ?>
                <span class="hp-btn hp-btn-sm hp-off"><i class="fa-solid fa-ban" aria-hidden="true"></i> Out of stock</span>
                <?php else : ?>
                <a class="hp-btn hp-btn-sm" href="<?php echo esc_url( $url ); ?>"><i class="fa-solid fa-list-check" aria-hidden="true"></i> <?php echo $isvar ? 'Select options' : 'View details'; ?></a>
                <?php endif; ?>
                <a class="hp-btn hp-btn-sm hp-btn-wa" href="<?php echo esc_url( 'https://wa.me/' . $hp_wa . '?text=' . $wamsg ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Order via WhatsApp</a>
            </div>
        </div>
    </article>
    <?php
};

/* ---------- Data ---------- */
$hp_cats = array();
if ( taxonomy_exists( 'product_cat' ) ) {
    $t = get_terms( array(
        'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0,
        'orderby' => 'count', 'order' => 'DESC', 'number' => 6,
        'exclude' => array( (int) get_option( 'default_product_cat' ) ),
    ) );
    if ( ! is_wp_error( $t ) ) { $hp_cats = $t; }
}
$hp_featured = array();
$hp_new      = array();
if ( function_exists( 'wc_get_products' ) ) {
    $hp_featured = wc_get_products( array( 'status' => 'publish', 'featured' => true, 'limit' => 8 ) );
    if ( empty( $hp_featured ) ) { $hp_featured = wc_get_products( array( 'status' => 'publish', 'limit' => 8, 'orderby' => 'rand' ) ); }
    $hp_new = wc_get_products( array( 'status' => 'publish', 'limit' => 8, 'orderby' => 'date', 'order' => 'DESC' ) );
}

/* ---------- SEO: description + schema (skipped if an SEO plugin is active) ---------- */
$hp_desc = 'Travotech Agencies supplies quality laboratory and hospital equipment in Nairobi, Thika and across Kenya: monitoring, laboratory, diagnostic and medical consumables with fast delivery.';
if ( ! defined( 'WPSEO_VERSION' ) && ! class_exists( 'RankMath' ) ) {
    echo '<meta name="description" content="' . esc_attr( $hp_desc ) . '">' . "\n";
}
echo '<script type="application/ld+json">' . wp_json_encode( array(
    '@context' => 'https://schema.org', '@type' => 'Organization',
    'name' => 'Travotech Agencies', 'url' => home_url( '/' ),
    'description' => $hp_desc, 'areaServed' => 'Kenya',
    'contactPoint' => array( '@type' => 'ContactPoint', 'telephone' => '+' . $hp_wa, 'contactType' => 'sales' ),
), JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
?>
<style>
.hp{font-family:var(--th-fb,'Inter',system-ui,sans-serif);color:#183332;line-height:1.6;}
.hp *{box-sizing:border-box;}
.hp img{max-width:100%;height:auto;}
.hp a{text-decoration:none;}
.hp-wrap{max-width:1280px;margin:0 auto;padding:0 clamp(16px,4vw,48px);}
.hp-sec{padding:clamp(36px,6vw,72px) 0;}
.hp-sec.alt{background:var(--th-lt,#e4fafa);}
.hp h1,.hp h2,.hp h3{font-family:var(--th-fh,'Oswald','Arial Narrow',sans-serif);color:var(--th-dk,#093c3c);margin:0;line-height:1.2;}
.hp h2{font-size:clamp(1.5rem,3.2vw,2.2rem);letter-spacing:.01em;}
.hp-head{text-align:center;max-width:760px;margin:0 auto clamp(22px,4vw,38px);}
.hp-head h2{padding-bottom:12px;position:relative;}
.hp-head h2::after{content:"";display:block;width:64px;height:4px;background:var(--th-red,#e53935);border-radius:2px;margin:12px auto 0;}
.hp-head p{margin:10px 0 0;color:#22adb0;}
.hp-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 26px;border-radius:6px;font:600 14px var(--th-fh,'Oswald',sans-serif);letter-spacing:.04em;text-transform:uppercase;background:var(--th-g,#22adb0);color:#fff;border:2px solid var(--th-g,#22adb0);transition:background .2s,border-color .2s;}
.hp-btn:hover{background:var(--th-dk,#093c3c);border-color:var(--th-dk,#093c3c);color:#fff;}
.hp-btn-red{background:var(--th-red,#e53935);border-color:var(--th-red,#e53935);}
.hp-btn-red:hover{background:#c62828;border-color:#c62828;}
.hp-btn-ghost{background:transparent;border-color:#fff;color:#fff;}
.hp-btn-ghost:hover{background:#fff;color:var(--th-dk,#093c3c);border-color:#fff;}
.hp-btn-sm{padding:9px 14px;font-size:12px;width:100%;}
.hp-more{text-align:center;margin-top:clamp(22px,4vw,34px);}
.hp a:focus-visible,.hp-btn:focus-visible{outline:3px solid var(--th-red,#e53935);outline-offset:2px;}

/* Hero */
.hp-hero{position:relative;min-height:clamp(430px,60vh,620px);display:flex;align-items:center;background:var(--th-dk,#093c3c);overflow:hidden;}
.hp-hero>img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:right center;}
.hp-hero::before{content:"";position:absolute;inset:0;z-index:1;background:rgba(7,47,47,.92);}
.hp-hero .hp-wrap{position:relative;z-index:2;width:100%;}
.hp-hero-txt{max-width:640px;color:#fff;padding:36px 0;}
.hp-hero h1{color:#fff;font-size:clamp(1.9rem,5vw,3.4rem);}
.hp-hero p{margin:16px 0 0;font-size:clamp(1rem,1.6vw,1.2rem);color:rgba(255,255,255,.92);}
.hp-hero-btns{display:flex;flex-wrap:wrap;gap:12px;margin-top:26px;}

/* Trust strip */
.hp-trust{background:#fff;border-bottom:1px solid #e0f2f2;}
.hp-trust ul{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(4,1fr);}
.hp-trust li{display:flex;align-items:center;justify-content:center;gap:12px;padding:20px 12px;font-weight:600;color:var(--th-dk,#093c3c);border-right:1px solid #e0f2f2;}
.hp-trust li:last-child{border-right:0;}
.hp-trust i{font-size:1.6rem;color:var(--th-g,#22adb0);}

/* Categories */
.hp-cats{display:grid;grid-template-columns:repeat(6,1fr);gap:16px;}
.hp-cat{display:flex;flex-direction:column;background:#fff;border:1px solid #d7f0f0;border-radius:10px;overflow:hidden;box-shadow:0 2px 10px rgba(9,60,60,.06);transition:transform .2s,box-shadow .2s;}
.hp-cat:hover{transform:translateY(-3px);box-shadow:0 8px 22px rgba(9,60,60,.16);}
.hp-cat-img{aspect-ratio:1/1;background:#f1fafa;display:flex;align-items:center;justify-content:center;padding:10px;}
.hp-cat-img img{width:100%;height:100%;object-fit:contain;}
.hp-cat-img i{font-size:2.6rem;color:var(--th-g,#22adb0);opacity:.4;}
.hp-cat-name{background:var(--th-dk,#093c3c);color:#fff;padding:12px 10px;text-align:center;font:600 14px var(--th-fh,'Oswald',sans-serif);letter-spacing:.03em;border-top:3px solid var(--th-red,#e53935);flex:1;display:flex;align-items:center;justify-content:center;}

/* Product cards */
.hp-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
.hp-card{background:#fff;border:1px solid #d7f0f0;border-radius:10px;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 2px 10px rgba(9,60,60,.06);transition:box-shadow .2s;}
.hp-card:hover{box-shadow:0 8px 22px rgba(9,60,60,.16);}
.hp-card-img{position:relative;display:block;aspect-ratio:1/1;background:#f1fafa;padding:12px;}
.hp-card-img img{width:100%;height:100%;object-fit:contain;display:block;}
.hp-sale{position:absolute;top:10px;left:10px;z-index:1;background:var(--th-red,#e53935);color:#fff;font:700 11px var(--th-fb,sans-serif);padding:3px 10px;border-radius:4px;}
.hp-card-body{padding:14px;display:flex;flex-direction:column;gap:8px;flex:1;}
.hp-card h3{font-size:1rem;line-height:1.35;}
.hp-card h3 a{color:var(--th-dk,#093c3c);}
.hp-card h3 a:hover{color:var(--th-g,#22adb0);}
.hp-price{margin-top:auto;font-weight:800;color:var(--th-g,#22adb0);}
.hp-price del{color:#9aa3ad;font-weight:500;margin-right:6px;}
.hp-price ins{text-decoration:none;}

/* About */
.hp-about{display:grid;grid-template-columns:1fr 1fr;gap:clamp(24px,5vw,56px);align-items:center;}
.hp-about img{width:100%;border-radius:12px;box-shadow:0 10px 30px rgba(9,60,60,.18);display:block;}
.hp-about h2{margin-bottom:14px;}
.hp-about p{margin:0 0 14px;color:#1a8f92;}
.hp-ticks{list-style:none;margin:0 0 22px;padding:0;display:grid;gap:8px;}
.hp-ticks li{display:flex;gap:10px;align-items:flex-start;}
.hp-ticks i{color:var(--th-g,#22adb0);margin-top:5px;}

/* Why us */
.hp-why{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
.hp-why div{background:#fff;border-radius:10px;padding:24px 20px;text-align:center;border:1px solid #d7f0f0;}
.hp-why i{font-size:2rem;color:var(--th-g,#22adb0);margin-bottom:12px;}
.hp-why h3{font-size:1.1rem;margin-bottom:8px;}
.hp-why p{margin:0;font-size:.92rem;color:#22adb0;}

/* Reviews */
.hp-rev{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.hp-rev blockquote{margin:0;background:#fff;border:1px solid #d7f0f0;border-left:4px solid var(--th-red,#e53935);border-radius:10px;padding:24px;display:flex;flex-direction:column;gap:16px;height:100%;}
.hp-rev blockquote>i{font-size:1.6rem;color:var(--th-g,#22adb0);opacity:.5;}
.hp-rev blockquote p{margin:0;color:#1a8f92;}
.hp-rev footer{margin-top:auto;display:flex;flex-direction:column;}
.hp-rev strong{color:var(--th-dk,#093c3c);}
.hp-rev span{font-size:.85rem;color:#6b7280;}

/* CTA */
.hp-cta{background:var(--th-nv,#072f2f);color:#fff;padding:clamp(30px,5vw,48px) 0;border-top:4px solid var(--th-red,#e53935);}
.hp-cta .hp-wrap{display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;}
.hp-cta h2{color:#fff;font-size:clamp(1.4rem,3vw,2rem);}
.hp-cta p{margin:6px 0 0;color:rgba(255,255,255,.9);}

/* Responsive */
@media (max-width:1100px){
    .hp-cats{grid-template-columns:repeat(3,1fr);}
    .hp-why{grid-template-columns:repeat(2,1fr);}
}
@media (max-width:900px){
    .hp-grid{grid-template-columns:repeat(2,1fr);}
    .hp-trust ul{grid-template-columns:repeat(2,1fr);}
    .hp-trust li:nth-child(2){border-right:0;}
    .hp-trust li:nth-child(-n+2){border-bottom:1px solid #e0f2f2;}
    .hp-about{grid-template-columns:1fr;}
    .hp-rev{grid-template-columns:1fr;}
    .hp-hero::before{background:rgba(7,47,47,.85);}
}
@media (max-width:560px){
    .hp-cats{grid-template-columns:repeat(2,1fr);gap:12px;}
    .hp-grid{gap:12px;}
    .hp-card-body{padding:10px;}
    .hp-card h3{font-size:.88rem;}
    .hp-why{grid-template-columns:1fr;}
    .hp-trust li{flex-direction:column;text-align:center;gap:6px;font-size:.85rem;padding:14px 8px;}
    .hp-hero-btns .hp-btn,.hp-cta .hp-btn{width:100%;}
    .hp-cta .hp-wrap{text-align:center;justify-content:center;}
}

/* ---- Fixes v2 ---- */
/* Hero: clearer image */
.hp-hero::before{background:rgba(7,47,47,.8);}
.hp-hero-txt{max-width:580px;}
.hp .hp-hero h1{font-size:clamp(1.8rem,4vw,2.9rem);text-shadow:0 2px 12px rgba(0,0,0,.45);}
.hp-hero p{text-shadow:0 1px 8px rgba(0,0,0,.5);}
@media (max-width:900px){.hp-hero::before{background:rgba(7,47,47,.62);}}

/* Categories: image on top, name bar below, equal heights */
.hp-cats{gap:14px;}
.hp-cat{border-radius:8px;}
.hp-cat-img{aspect-ratio:auto;height:clamp(120px,13vw,165px);padding:8px;overflow:hidden;background:#f1fafa;}
.hp-cat-img img{width:100%;height:100%;object-fit:contain;}
.hp .hp-cat h3.hp-cat-name{color:#fff;flex:0 0 auto;min-height:56px;padding:10px 8px;font-size:15px;line-height:1.25;}

/* Product buttons */
.hp-actions{display:grid;gap:8px;margin-top:4px;}
.hp-card .hp-btn-sm{padding:10px 8px;font-size:12px;letter-spacing:.02em;line-height:1.2;text-align:center;}
.hp .hp-btn-wa{background:#25D366;border-color:#25D366;color:#fff;}
.hp .hp-btn-wa:hover{background:#22adb0;border-color:#22adb0;color:#fff;}
.hp-card .added_to_cart{display:block;text-align:center;font-size:12px;font-weight:700;color:var(--th-g,#22adb0);}
.hp-btn.loading{opacity:.6;pointer-events:none;}
.hp-btn.added{background:var(--th-dk,#093c3c);border-color:var(--th-dk,#093c3c);}
@media (max-width:560px){.hp-card .hp-btn-sm{font-size:11px;padding:9px 4px;letter-spacing:0;}}

/* Reviews: Google style, no red border */
.hp-rev blockquote{border:1px solid #d7f0f0;gap:14px;background:#fff;}
.hp-rev .hp-rev-top{display:flex;align-items:center;gap:12px;}
.hp-rev .hp-av{width:44px;height:44px;flex:0 0 44px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font:700 18px var(--th-fb,sans-serif);background:#5dd9d7;}
.hp-rev blockquote:nth-child(4n+2) .hp-av{background:#EA4335;}
.hp-rev blockquote:nth-child(4n+3) .hp-av{background:#FBBC05;color:#183332;}
.hp-rev blockquote:nth-child(4n+4) .hp-av{background:#22adb0;}
.hp-rev .hp-rev-by{display:flex;flex-direction:column;min-width:0;flex:1;background:none;padding:0;}
.hp-rev .hp-rev-by strong{color:#183332;font-size:1rem;}
.hp-rev .hp-rev-by span{color:#6b7280;font-size:.85rem;}
.hp-rev .hp-gword{font:600 15px var(--th-fb,sans-serif);white-space:nowrap;}
.hp-rev .hp-gword .gb{color:#5dd9d7;font-size:15px;}
.hp-rev .hp-gword .gr{color:#EA4335;font-size:15px;}
.hp-rev .hp-gword .gy{color:#FBBC05;font-size:15px;}
.hp-rev .hp-gword .gg{color:#22adb0;font-size:15px;}

/* ---- Fixes v3 ---- */
/* CTA: solid colour */
.hp-cta{background:var(--th-dk,#093c3c);background-image:none;}

/* Reviews: yellow stars */
.hp-rev .hp-stars{display:flex;gap:3px;color:#FBBC05;font-size:1rem;}
.hp-rev .hp-stars .off{color:#dadce0;}

/* Equal image size in every product card */
.hp-card-img{aspect-ratio:auto;height:clamp(150px,16vw,210px);padding:10px;}
.hp-card-img img{width:100%;height:100%;object-fit:contain;display:block;}

/* New Arrivals: shorter cards */
section[aria-labelledby="hp-new-h"] .hp-grid{gap:14px;}
section[aria-labelledby="hp-new-h"] .hp-card-img{height:clamp(120px,12vw,150px);padding:8px;}
section[aria-labelledby="hp-new-h"] .hp-card-body{padding:10px;gap:6px;}
section[aria-labelledby="hp-new-h"] .hp-card h3{font-size:.9rem;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.6em;}
section[aria-labelledby="hp-new-h"] .hp-price{font-size:.9rem;}
section[aria-labelledby="hp-new-h"] .hp-actions{gap:6px;margin-top:2px;}
section[aria-labelledby="hp-new-h"] .hp-card .hp-btn-sm{padding:7px 6px;font-size:11px;}
@media (max-width:560px){
    .hp-card-img{height:130px;}
    section[aria-labelledby="hp-new-h"] .hp-card-img{height:110px;}
}

/* ---- Google reviews v1 ---- */
.hp .gr-slider{position:relative;display:flex;align-items:center;gap:10px;--pv:3;}
.hp .gr-view{flex:1;min-width:0;overflow:hidden;}
.hp .gr-track{display:flex;transition:transform .6s cubic-bezier(.4,0,.2,1);will-change:transform;}
.hp .gr-slide{flex:0 0 calc(100% / var(--pv));min-width:0;padding:8px 9px 14px;}
.hp .gr-card{background:#fff;border:1px solid #e3e8ee;border-radius:12px;padding:20px;height:100%;display:flex;flex-direction:column;gap:12px;box-shadow:0 2px 10px rgba(60,64,67,.12);}
.hp .gr-top{display:flex;align-items:center;gap:12px;}
.hp .gr-av{width:44px;height:44px;border-radius:50%;color:#fff;font:600 15px var(--th-fh,'Oswald',sans-serif);display:flex;align-items:center;justify-content:center;flex:0 0 44px;letter-spacing:.03em;}
.hp .gr-who{flex:1;min-width:0;display:flex;flex-direction:column;line-height:1.3;}
.hp .gr-who strong{color:#202124;font-size:.95rem;}
.hp .gr-who span{color:#5f6368;font-size:.78rem;}
.hp .gr-g{flex:0 0 auto;display:block;}
.hp .gr-stars{color:#fbbc04;font-size:1rem;letter-spacing:2px;}
.hp .gr-card p{margin:0;color:#3c4043;font-size:.93rem;line-height:1.65;flex:1;}
.hp .gr-foot{display:flex;align-items:center;gap:8px;color:#5f6368;font-size:.78rem;border-top:1px solid #edf0f2;padding-top:10px;}
.hp .gr-foot .gr-g{width:16px;height:16px;}
.hp .gr-arrow{flex:0 0 42px;width:42px;height:42px;border-radius:50%;border:1px solid #dadce0;background:#fff;color:#4285f4;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(60,64,67,.2);transition:background .2s,color .2s;}
.hp .gr-arrow:hover{background:#4285f4;color:#fff;}
.hp .gr-dots{display:flex;justify-content:center;gap:8px;margin-top:10px;}
.hp .gr-dots button{width:10px;height:10px;border-radius:50%;border:0;padding:0;background:#c9d3d3;cursor:pointer;transition:width .25s,background .25s;}
.hp .gr-dots button.on{width:28px;border-radius:6px;background:#4285f4;}
@media (max-width:640px){
    .hp .gr-slider{gap:0;}
    .hp .gr-arrow{position:absolute;top:50%;z-index:2;width:34px;height:34px;flex-basis:34px;transform:translateY(-50%);}
    .hp .gr-prev{left:-4px;}
    .hp .gr-next{right:-4px;}
    .hp .gr-slide{padding:8px 22px 14px;}
}
@media (prefers-reduced-motion:reduce){.hp .gr-track{transition:none;}}

/* ---- shop-style card buttons + toast ---- */
.hp-btns{display:grid;gap:7px;margin-top:4px;}
.hp-b{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;padding:10px 8px;border-radius:6px;border:2px solid var(--th-g,#22adb0);background:var(--th-g,#22adb0);color:#fff;font:600 12px var(--th-fh,'Oswald',sans-serif);letter-spacing:.03em;text-transform:uppercase;line-height:1.2;text-align:center;cursor:pointer;transition:background .2s,border-color .2s;}
.hp-b:hover{background:var(--th-dk,#093c3c);border-color:var(--th-dk,#093c3c);color:#fff;}
.hp-b.wa{background:#25D366;border-color:#25D366;}
.hp-b.wa:hover{background:#22adb0;border-color:#22adb0;}
.hp-b.off{background:#e5e9e7;border-color:#e5e9e7;color:#6b7280;pointer-events:none;}
.hp-b.cv-loading{opacity:.65;pointer-events:none;}
@media (max-width:560px){.hp-b{font-size:10.5px;padding:8px 3px;gap:5px;letter-spacing:0;}}
@media (max-width:380px){.hp-b{font-size:10px;}}
#travotech-toast{position:fixed;bottom:100px;right:24px;z-index:999999;width:min(340px,calc(100vw - 24px));background:var(--th-dk,#093c3c);color:#fff;border-radius:12px;padding:14px 16px 18px;box-shadow:0 12px 40px rgba(0,0,0,.3);display:flex;align-items:flex-start;gap:12px;opacity:0;transform:translateY(20px);transition:opacity .3s,transform .3s;pointer-events:none;overflow:hidden;font-family:var(--th-fb,sans-serif);}
#travotech-toast.cv-show{opacity:1;transform:translateY(0);pointer-events:auto;}
#travotech-toast .cv-ic{width:36px;height:36px;border-radius:50%;background:var(--th-g,#22adb0);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
#travotech-toast .cv-body{flex:1;min-width:0;}
#travotech-toast .cv-title{font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#22adb0;margin-bottom:3px;}
#travotech-toast .cv-name{font-size:.88rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:10px;}
#travotech-toast .cv-act{display:flex;gap:8px;}
#travotech-toast .cv-act a,#travotech-toast .cv-act button{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border-radius:6px;font:700 12px var(--th-fb,sans-serif);border:0;cursor:pointer;text-decoration:none;}
#travotech-toast .cv-act a{background:var(--th-red,#e53935);color:#fff;}
#travotech-toast .cv-act button{background:rgba(255,255,255,.12);color:#fff;}
#travotech-toast .cv-bar{position:absolute;left:0;right:0;bottom:0;height:4px;background:var(--th-g,#22adb0);transform-origin:left;}
#travotech-toast.cv-show .cv-bar{animation:cvCount 5s linear forwards;}
@keyframes cvCount{from{transform:scaleX(1);}to{transform:scaleX(0);}}
@media (max-width:560px){#travotech-toast{right:12px;left:12px;width:auto;bottom:84px;}}
/* ---- Home add to cart v1 ---- */
.hp-actions{display:grid;gap:7px;margin-top:4px;}
.hp-actions .hp-btn{width:100%;font-size:12px;padding:10px 8px;line-height:1.2;text-align:center;cursor:pointer;}
.hp-btn-wa{background:#25D366;border-color:#25D366;color:#fff;}
.hp-btn-wa:hover{background:#25D366;border-color:#25D366;color:#fff;}
.hp-btn.hp-off{background:#e5e9e7;border-color:#e5e9e7;color:#6b7280;pointer-events:none;}
.hp-btn.hp-atc-loading{opacity:.65;pointer-events:none;}
</style>

<main class="hp" id="main">

    <!-- HERO: one image, no slider -->
    <section class="hp-hero" aria-labelledby="hp-h1">
        <img src="<?php echo esc_url( $hp_hero ); ?>" alt="Laboratory and hospital equipment supplied by Travotech Agencies in Kenya" width="1600" height="700" fetchpriority="high" decoding="async">
        <div class="hp-wrap">
            <div class="hp-hero-txt">
                <h1 id="hp-h1">Laboratory &amp; Hospital Equipment Supplier in Kenya</h1>
                <p>Quality, reliability and better healthcare. Travotech Agencies supplies monitoring, laboratory and diagnostic equipment to hospitals, clinics and laboratories in Nairobi, Thika and across Kenya.</p>
                <div class="hp-hero-btns">
                    <a class="hp-btn hp-btn-red" href="<?php echo esc_url( $hp_shop ); ?>"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Shop equipment</a>
                    <a class="hp-btn hp-btn-ghost" href="<?php echo esc_url( $hp_contact ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i> Request a quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- TRUST STRIP -->
    <section class="hp-trust" aria-label="Why buy from Travotech">
        <div class="hp-wrap">
            <ul>
                <?php foreach ( $hp_trust as $t ) : ?>
                <li><i class="fa-solid <?php echo esc_attr( $t[0] ); ?>" aria-hidden="true"></i><span><?php echo esc_html( $t[1] ); ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- CATEGORIES (live from WooCommerce) -->
    <?php if ( ! empty( $hp_cats ) ) : ?>
    <section class="hp-sec" aria-labelledby="hp-cat-h">
        <div class="hp-wrap">
            <div class="hp-head">
                <h2 id="hp-cat-h">Shop Medical &amp; Laboratory Equipment by Category</h2>
                <p>Browse our wide range of hospital supplies, laboratory instruments and diagnostic devices.</p>
            </div>
            <div class="hp-cats">
                <?php foreach ( $hp_cats as $c ) :
                    $cu = get_term_link( $c );
                    if ( is_wp_error( $cu ) ) { continue; }
                    $ci = $hp_cat_img( $c ); ?>
                <a class="hp-cat" href="<?php echo esc_url( $cu ); ?>">
                    <span class="hp-cat-img">
                        <?php if ( $ci ) : ?><img src="<?php echo esc_url( $ci ); ?>" alt="<?php echo esc_attr( $c->name ); ?> available in Kenya" loading="lazy" width="300" height="300"><?php else : ?><i class="fa-solid fa-flask-vial" aria-hidden="true"></i><?php endif; ?>
                    </span>
                    <h3 class="hp-cat-name"><?php echo esc_html( $c->name ); ?></h3>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="hp-more"><a class="hp-btn" href="<?php echo esc_url( $hp_shop ); ?>">View all categories <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
        </div>
    </section>
    <?php endif; ?>

    <!-- MOST FEATURED -->
    <?php if ( ! empty( $hp_featured ) ) : ?>
    <section class="hp-sec alt" aria-labelledby="hp-feat-h">
        <div class="hp-wrap">
            <div class="hp-head">
                <h2 id="hp-feat-h">Most Featured Equipment</h2>
                <p>Hand-picked laboratory and hospital products our customers ask for most.</p>
            </div>
            <div class="hp-grid">
                <?php foreach ( $hp_featured as $p ) { $hp_card( $p ); } ?>
            </div>
            <div class="hp-more"><a class="hp-btn" href="<?php echo esc_url( $hp_shop ); ?>">View all products <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
        </div>
    </section>
    <?php endif; ?>

    <!-- NEW ARRIVALS -->
    <?php if ( ! empty( $hp_new ) ) : ?>
    <section class="hp-sec" aria-labelledby="hp-new-h">
        <div class="hp-wrap">
            <div class="hp-head">
                <h2 id="hp-new-h">New Arrivals</h2>
                <p>The latest medical devices and laboratory supplies added to our store.</p>
            </div>
            <div class="hp-grid">
                <?php foreach ( $hp_new as $p ) { $hp_card( $p ); } ?>
            </div>
            <div class="hp-more"><a class="hp-btn" href="<?php echo esc_url( $hp_shop ); ?>">Shop all equipment <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ABOUT -->
    <section class="hp-sec alt" aria-labelledby="hp-about-h">
        <div class="hp-wrap hp-about">
            <img src="<?php echo esc_url( $hp_about ); ?>" alt="Travotech Agencies laboratory and hospital supplies" loading="lazy" width="640" height="440">
            <div>
                <h2 id="hp-about-h">About Travotech Agencies</h2>
                <p>Travotech Agencies is a trusted supplier of laboratory and hospital equipment in Kenya. We help hospitals, clinics, laboratories and healthcare professionals find reliable, affordable and innovative solutions.</p>
                <ul class="hp-ticks">
                    <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Genuine laboratory and hospital equipment</li>
                    <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Advice from a team that knows the products</li>
                    <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Delivery in Nairobi, Thika and across Kenya</li>
                </ul>
                <a class="hp-btn" href="<?php echo esc_url( $hp_about_u ); ?>">Learn more <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="hp-sec" aria-labelledby="hp-why-h">
        <div class="hp-wrap">
            <div class="hp-head"><h2 id="hp-why-h">Why Choose Travotech Agencies?</h2></div>
            <div class="hp-why">
                <?php foreach ( $hp_why as $w ) : ?>
                <div>
                    <i class="fa-solid <?php echo esc_attr( $w[0] ); ?>" aria-hidden="true"></i>
                    <h3><?php echo esc_html( $w[1] ); ?></h3>
                    <p><?php echo esc_html( $w[2] ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- GOOGLE REVIEWS SLIDER -->
    <?php
    /* SAMPLE reviews: replace each with a real customer review before going live */
    $gr_list = array(
        array( 'Wanjiku Mwangi',  'Medical Director, Lakeview Clinic, Nairobi',   'Travotech supplied our patient monitors and pulse oximeters in Nairobi within two days. The equipment is genuine, well packaged and came with clear guidance on setup.', 'WM', '#4285F4' ),
        array( 'Brian Otieno',    'Lab Manager, Kisumu Diagnostics',              'We bought a laboratory centrifuge and microscope from Travotech. Fair prices, honest advice and quick delivery to Kisumu. Our lab team is very happy.', 'BO', '#EA4335' ),
        array( 'Faith Njeri',     'Procurement Officer, Thika Community Hospital', 'Reliable supplier of hospital equipment in Thika. They handled our bulk order of medical consumables professionally and the invoice matched the quote exactly.', 'FN', '#FBBC05' ),
        array( 'Hassan Abdalla',  'Pharmacist, Mombasa Road Pharmacy',            'Good range of diagnostic devices and glucometers at competitive prices. The support team answered all my questions on WhatsApp the same day.', 'HA', '#34A853' ),
        array( 'Mercy Chebet',    'Clinical Officer, Nakuru Family Health',       'Excellent after-sale support. Travotech helped us choose the right sterilisation and examination equipment for our clinic in Nakuru, and delivery was on time.', 'MC', '#4285F4' ),
        array( 'Kevin Kamau',     'Owner, Westlands Medical Laboratory, Nairobi', 'Quality laboratory equipment in Kenya at honest prices. I have ordered three times and every item arrived exactly as described. Highly recommended.', 'KK', '#EA4335' ),
    );
    $gr_g = '<svg class="gr-g" viewBox="0 0 48 48" width="22" height="22" aria-hidden="true"><path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9.1 3.6l6.8-6.8C35.8 2.4 30.3 0 24 0 14.6 0 6.5 5.4 2.6 13.2l7.9 6.1C12.4 13.6 17.7 9.5 24 9.5z"/><path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.2 5.5-4.7 7.2l7.6 5.9c4.4-4.1 6.9-10.1 6.9-17.6z"/><path fill="#FBBC05" d="M10.5 28.7c-.5-1.4-.8-3-.8-4.7s.3-3.2.8-4.7l-7.9-6.1C.9 16.4 0 20.1 0 24s.9 7.6 2.6 10.8l7.9-6.1z"/><path fill="#34A853" d="M24 48c6.5 0 11.9-2.1 15.9-5.8l-7.6-5.9c-2.1 1.4-4.9 2.3-8.3 2.3-6.3 0-11.6-4.1-13.5-9.8l-7.9 6.1C6.5 42.6 14.6 48 24 48z"/></svg>';
    ?>
    <section class="hp-sec alt gr-sec" aria-labelledby="hp-rev-h">
        <div class="hp-wrap">
            <div class="hp-head">
                <h2 id="hp-rev-h">Google Reviews: What Hospitals, Clinics &amp; Laboratories in Kenya Say About Travotech</h2>
                <p>Trusted laboratory and hospital equipment supplier serving Nairobi, Thika, Mombasa, Nakuru, Kisumu and the rest of Kenya.</p>
            </div>
            <div class="gr-slider" id="hpGr" aria-roledescription="carousel" aria-label="Customer reviews">
                <button class="gr-arrow gr-prev" type="button" aria-label="Previous reviews"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></button>
                <div class="gr-view">
                    <div class="gr-track">
                        <?php foreach ( $gr_list as $r ) : ?>
                        <div class="gr-slide">
                            <article class="gr-card">
                                <div class="gr-top">
                                    <span class="gr-av" style="background:<?php echo esc_attr( $r[4] ); ?>;"><?php echo esc_html( $r[3] ); ?></span>
                                    <div class="gr-who"><strong><?php echo esc_html( $r[0] ); ?></strong><span><?php echo esc_html( $r[1] ); ?></span></div>
                                    <?php echo $gr_g; // phpcs:ignore ?>
                                </div>
                                <div class="gr-stars" role="img" aria-label="5 out of 5 stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                <p><?php echo esc_html( $r[2] ); ?></p>
                                <div class="gr-foot"><?php echo $gr_g; // phpcs:ignore ?> <span>Posted on Google</span></div>
                            </article>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button class="gr-arrow gr-next" type="button" aria-label="Next reviews"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button>
            </div>
            <div class="gr-dots" id="hpGrDots" role="tablist" aria-label="Choose review page"></div>
        </div>
    </section>
    <script>
    (function(){
        var root=document.getElementById('hpGr'),dots=document.getElementById('hpGrDots');
        if(!root||!dots)return;
        var track=root.querySelector('.gr-track'),n=track.children.length,page=0,pv=3,pages=2,timer=null;
        var reduce=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        function build(){
            dots.innerHTML='';
            for(var i=0;i<pages;i++){(function(i){
                var b=document.createElement('button');b.type='button';b.setAttribute('aria-label','Reviews page '+(i+1));
                b.addEventListener('click',function(){go(i);restart();});dots.appendChild(b);
            })(i);}
        }
        function go(p){
            page=(p+pages)%pages;
            track.style.transform='translateX('+(-page*100)+'%)';
            var d=dots.children;for(var i=0;i<d.length;i++){d[i].className=(i===page)?'on':'';}
        }
        function calc(){
            var w=window.innerWidth;pv=w<=640?1:(w<=1000?2:3);
            pages=Math.ceil(n/pv);root.style.setProperty('--pv',pv);
            if(page>=pages)page=0;build();go(page);
        }
        function restart(){if(timer)clearInterval(timer);if(!reduce){timer=setInterval(function(){go(page+1);},5000);}}
        root.querySelector('.gr-prev').addEventListener('click',function(){go(page-1);restart();});
        root.querySelector('.gr-next').addEventListener('click',function(){go(page+1);restart();});
        root.addEventListener('mouseenter',function(){if(timer)clearInterval(timer);});
        root.addEventListener('mouseleave',restart);
        var x0=null;
        root.addEventListener('touchstart',function(e){x0=e.touches[0].clientX;},{passive:true});
        root.addEventListener('touchend',function(e){if(x0===null)return;var dx=e.changedTouches[0].clientX-x0;if(Math.abs(dx)>40){go(page+(dx<0?1:-1));restart();}x0=null;},{passive:true});
        var rt;window.addEventListener('resize',function(){clearTimeout(rt);rt=setTimeout(calc,150);});
        calc();restart();
    })();
    </script>
	<!-- CALL TO ACTION -->
    <section class="hp-cta" aria-labelledby="hp-cta-h">
        <div class="hp-wrap">
            <div>
                <h2 id="hp-cta-h">Let&rsquo;s Build a Healthier Future Together</h2>
                <p>Partner with Travotech Agencies for all your laboratory and hospital equipment needs.</p>
            </div>
            <a class="hp-btn hp-btn-red" href="<?php echo esc_url( $hp_contact ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i> Contact us</a>
        </div>
    </section>

</main>
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
<script>
(function(){
    var $=function(id){return document.getElementById(id);};
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

    document.querySelectorAll('.hp-atc').forEach(function(btn){
        btn.addEventListener('click',function(e){
            e.preventDefault();
            try{sessionStorage.setItem('cv_scroll_pos',String(window.pageYOffset||document.documentElement.scrollTop||0));}catch(x){}
            btn.classList.add('cv-loading');
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