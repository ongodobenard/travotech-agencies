<?php
/**
 * Travotech Agencies - header.php
 * Layout follows the Family Drugmart header, in the Travotech green palette.
 * Every class is prefixed th- so older CSS cannot clash with it.
 */
$th_opt = function ( array $keys, $default = '' ) {
    foreach ( $keys as $k ) {
        $v = get_option( $k, '' );
        if ( is_string( $v ) && trim( $v ) !== '' ) { return trim( $v ); }
    }
    return $default;
};
$th_pg = function ( array $slugs, $fallback ) {
    foreach ( $slugs as $s ) {
        $p = get_page_by_path( $s );
        if ( $p ) { return get_permalink( $p ); }
    }
    return home_url( $fallback );
};

$th_wa    = preg_replace( '/\D+/', '', $th_opt( array( 'travotech_wa', 'trovatech_wa' ), '254720737151' ) );
$th_phone = $th_opt( array( 'travotech_phone_display', 'trovatech_phone_display' ), '+254 720 737 151' );
$th_email = function_exists( 'travotech_email' ) ? travotech_email() : $th_opt( array( 'travotech_email', 'trovatech_email' ), 'sales@travotechagencies.co.ke' );
$th_addr  = function_exists( 'travotech_address' ) ? travotech_address() : $th_opt( array( 'travotech_location', 'trovatech_location' ), 'Nairobi, Kenya' );
$th_hours = $th_opt( array( 'travotech_hours', 'trovatech_hours' ), 'Mon-Fri: 8am-6pm | Sat: 8:30am-1:00pm | Sun & Holidays: closed' );
$th_flag  = '<span class="ke-flag" role="img" aria-label="Kenya flag"></span>';

$th_logo = '';
if ( get_theme_mod( 'custom_logo' ) ) { $th_logo = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ); }
if ( ! $th_logo ) { $th_logo = get_template_directory_uri() . '/assets/js/images/travotechlogo.png'; }

$th_shop = ( function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0 ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
$s_about = array( 'about-us', 'about' );
$s_proj  = array( 'projects', 'our-projects' );
$s_ret   = array( 'return-and-refund-policy', 'return-policy', 'refund-policy', 'refund', 'returns' );
$s_cont  = array( 'contact', 'contact-us' );

$th_links = array(
    array( home_url( '/' ),                  'Home',                   is_front_page() ),
    array( $th_shop,                         'Shop',                   function_exists( 'is_shop' ) && is_shop() ),
    array( $th_pg( $s_about, '/about-us/' ), 'About Us',               is_page( $s_about ) ),
    array( $th_pg( $s_proj, '/projects/' ),  'Projects',               is_page( $s_proj ) ),
    array( $th_pg( $s_ret, '/refund/' ),     'Return & Refund Policy', is_page( $s_ret ) ),
);
$th_contact_url = $th_pg( $s_cont, '/contact/' );
$th_contact_on  = is_page( $s_cont );

$th_socials = array();
$th_soc_def = array(
    array( 'facebook',  array( 'travotech_facebook', 'trovatech_facebook' ),                          'fa-brands fa-facebook-f',  'Facebook' ),
    array( 'instagram', array( 'travotech_instagram', 'trovatech_instagram' ),                        'fa-brands fa-instagram',   'Instagram' ),
    array( 'tiktok',    array( 'travotech_tiktok', 'trovatech_tiktok' ),                              'fa-brands fa-tiktok',      'TikTok' ),
    array( 'linkedin',  array( 'travotech_linkedin', 'trovatech_linkedin' ),                          'fa-brands fa-linkedin-in', 'LinkedIn' ),
    array( 'x',         array( 'travotech_x', 'travotech_twitter', 'trovatech_twitter' ),             'fa-brands fa-x-twitter',   'X' ),
);
foreach ( $th_soc_def as $d ) {
    $u = $th_opt( $d[1], '' );
    if ( $u !== '' ) { $th_socials[] = array( $d[0], $u, $d[2], $d[3] ); }
}

/* Shop by Category: live WooCommerce categories (main + sub-categories) */
$th_cats = array();
if ( taxonomy_exists( 'product_cat' ) ) {
    $th_parents = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0, 'orderby' => 'name', 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
    if ( ! is_wp_error( $th_parents ) ) {
        foreach ( $th_parents as $p ) {
            $pu = get_term_link( $p );
            if ( is_wp_error( $pu ) ) { continue; }
            $kids = array();
            $kt = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $p->term_id, 'orderby' => 'name' ) );
            if ( ! is_wp_error( $kt ) ) {
                foreach ( $kt as $k ) {
                    $ku = get_term_link( $k );
                    if ( ! is_wp_error( $ku ) ) { $kids[] = array( $k->name, $ku ); }
                }
            }
            $th_cats[] = array( $p->name, $pu, $kids );
        }
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#22adb0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
<style>
:root{--th-g:#22adb0;--th-gd:#1a8f92;--th-dk:#093c3c;--th-nv:#072f2f;--th-lt:#e4fafa;--th-red:#e53935;--th-px:48px;--th-fh:'Oswald','Arial Narrow',sans-serif;--th-fb:'Inter',system-ui,-apple-system,'Segoe UI',Arial,sans-serif;}

/* ===== Loader ===== */
#th-loader{position:fixed;inset:0;z-index:9999999;background:transparent;display:flex;align-items:center;justify-content:center;opacity:1;transition:opacity .45s ease;}
#th-loader.th-out{opacity:0;pointer-events:none;}
.th-dots{width:96px;height:96px;overflow:visible;}
.th-dots .th-ring{transform-origin:50px 50px;animation:th-orbit 1.8s linear infinite;}
.th-dots circle{transform-box:fill-box;transform-origin:center;animation:th-dotpulse 1.8s ease-in-out infinite;}
.th-dots circle:nth-child(2n){animation-delay:-.3s;}
.th-dots circle:nth-child(3n){animation-delay:-.6s;}
.th-dots .r{fill:#e53935;}
.th-dots .t{fill:#22adb0;}
.th-dots .g{fill:#009228;}
@keyframes th-orbit{from{transform:rotate(0deg);}to{transform:rotate(360deg);}}
@keyframes th-dotpulse{0%,100%{transform:scale(1);}50%{transform:scale(.7);}}
@media (prefers-reduced-motion:reduce){.th-dots .th-ring,.th-dots circle{animation:none !important;}}
/* ===== Flag ===== */
.ke-flag{display:inline-block;flex:0 0 auto;width:24px;height:16px;border-radius:2px;position:relative;vertical-align:middle;box-shadow:0 0 0 1px rgba(0,0,0,.25);background:#000;}
.ke-flag::after{content:"";position:absolute;left:50%;top:50%;width:6px;height:10px;transform:translate(-50%,-50%);border-radius:50%;background:#fff;}

/* ===== Top bar ===== */
.th-top,.th-sticky,.th-mnav{font-family:var(--th-fb);}
.th-top *,.th-sticky *,.th-mnav *{box-sizing:border-box;}
.th-top{background:var(--th-nv);color:#fff;font-size:12px;display:flex;justify-content:space-between;align-items:center;gap:16px;padding:6px var(--th-px);overflow:hidden;}
.th-marq{flex:1 1 auto;min-width:0;overflow:hidden;-webkit-mask-image:rgba(0,0,0,.45);mask-image:rgba(0,0,0,.45);}
.th-marq-track{display:inline-flex;align-items:center;white-space:nowrap;animation:th-scroll 40s linear infinite;will-change:transform;}
.th-marq:hover .th-marq-track{animation-play-state:paused;}
@keyframes th-scroll{from{transform:translateX(0);}to{transform:translateX(-50%);}}
.th-mi{display:inline-flex;align-items:center;gap:7px;font-weight:700;white-space:nowrap;}
.th-mi i{font-size:.85rem;color:#22adb0;}
.th-mi a{color:inherit;text-decoration:none;}
.th-msep{margin:0 26px;opacity:.4;}
@media (prefers-reduced-motion:reduce){.th-marq-track{animation:none;}}
.th-soc-wrap{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.th-soc{width:28px;height:28px;border-radius:14px !important;background:#fff;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:.85rem;transition:transform .2s;}
.th-soc:hover{transform:translateY(-2px) scale(1.1);}
.th-soc i{line-height:1;}
.th-soc-facebook{color:#22adb0;}.th-soc-linkedin{color:#22adb0;}.th-soc-x{color:#000;}.th-soc-whatsapp{color:#25D366;}
.th-soc-tiktok{color:#000;}.th-soc-tiktok i{text-shadow:1px 1px 0 #FE2C55,-1px -1px 0 #5ae8e5;}
.th-soc-instagram i{background:#FEDA75;-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;}

/* ===== Sticky header ===== */
.th-sticky{position:sticky;top:0;z-index:500;box-shadow:0 2px 14px rgba(0,0,0,0);transition:box-shadow .25s;}
.th-sticky.is-pinned{box-shadow:0 4px 18px rgba(0,0,0,.2);}
.th-bar{background:var(--th-g);display:flex;align-items:center;gap:18px;padding:10px var(--th-px);}
.th-burger{display:none;background:rgba(255,255,255,.15);border:0;cursor:pointer;flex-direction:column;gap:5px;padding:8px;border-radius:5px;flex-shrink:0;}
.th-burger span{display:block;width:22px;height:2px;background:#fff;border-radius:2px;}
.th-logo{display:flex;align-items:center;text-decoration:none;flex-shrink:0;}
.th-logo-box{background:#fff;border-radius:10px;padding:5px 10px;display:flex;align-items:center;box-shadow:0 2px 8px rgba(0,0,0,.25);transition:transform .25s,box-shadow .25s;}
.th-logo:hover .th-logo-box{transform:scale(1.04);box-shadow:0 4px 14px rgba(0,0,0,.35);}
.th-logo-box img{display:block;height:48px;width:auto;max-width:200px;object-fit:contain;}
.th-search{flex:1;max-width:620px;margin:0 auto;}
.th-search form{display:flex;border-radius:5px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.18);}
.th-search input[type="search"]{flex:1;min-width:0;border:0;outline:0;padding:11px 18px;font:400 14px var(--th-fb);color:#333;background:#fff;}
.th-search button{background:var(--th-dk);color:#fff;border:0;padding:11px 24px;font:600 13px var(--th-fb);cursor:pointer;display:flex;align-items:center;gap:7px;white-space:nowrap;transition:background .2s;}
.th-search button:hover{background:var(--th-nv);}
.th-right{display:flex;align-items:center;gap:14px;flex-shrink:0;}
.th-deliv{display:flex;align-items:center;gap:9px;color:#fff;font-size:12px;line-height:1.3;}
.th-deliv strong{display:block;font-weight:700;}
.th-wish,.th-cart{position:relative;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;border-radius:6px;transition:background .2s,transform .15s;}
.th-wish{width:40px;height:40px;border-radius:50%;}
.th-wish i,.th-cart i{font-size:1.25rem;line-height:1;}
.th-cart{flex-direction:column;gap:3px;padding:5px 10px;}
.th-wish:hover,.th-cart:hover{background:rgba(255,255,255,.18);transform:translateY(-1px);}
.th-cart-amt{font-size:13px;font-weight:700;line-height:1;color:#fff;}
.th-badge{position:absolute;top:-2px;right:-2px;min-width:18px;height:18px;padding:0 4px;border-radius:50%;background:var(--th-red);color:#fff;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;border:2px solid var(--th-g);line-height:1;}
.th-cartwrap{position:relative;display:flex;align-items:center;}

/* Cart hover preview */
.th-cdrop{position:absolute;top:calc(100% + 12px);right:0;width:340px;background:#fff;border-radius:14px;border:1.5px solid #e0f2f2;box-shadow:0 16px 48px rgba(9,60,60,.2),0 2px 10px rgba(0,0,0,.08);z-index:99999;opacity:0;visibility:hidden;transform:translateY(10px);transition:opacity .22s,transform .22s,visibility .22s;pointer-events:none;color:#183332;}
.th-cdrop::after{content:"";position:absolute;left:0;right:0;top:-14px;height:14px;}
.th-cartwrap:hover .th-cdrop,.th-cartwrap:focus-within .th-cdrop{opacity:1;visibility:visible;transform:translateY(0);pointer-events:auto;}
.th-cd-head{background:var(--th-nv);border-bottom:3px solid var(--th-red);padding:12px 16px;border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:space-between;color:#fff;font:700 .88rem var(--th-fh);letter-spacing:.03em;}
.th-cd-head b{background:#fff;color:var(--th-dk);font:800 .65rem var(--th-fb);padding:2px 9px;border-radius:50px;}
.th-cd-items{max-height:256px;overflow-y:auto;padding:6px 0;}
.th-cd-item{display:flex;align-items:center;gap:11px;padding:9px 16px;border-bottom:1px solid #edf8f8;}
.th-cd-item:last-child{border-bottom:0;}
.th-cd-item img,.th-cd-ph{width:48px;height:48px;border-radius:8px;object-fit:contain;background:#f1fafa;border:1px solid #e0f2f2;flex-shrink:0;padding:3px;}
.th-cd-ph{display:flex;align-items:center;justify-content:center;color:var(--th-g);opacity:.5;}
.th-cd-info{flex:1;min-width:0;}
.th-cd-name{font-size:.8rem;font-weight:700;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:3px;}
.th-cd-meta{font-size:.7rem;color:#6b7280;}
.th-cd-meta em{font-style:normal;background:var(--th-lt);color:var(--th-g);font-weight:800;padding:1px 6px;border-radius:4px;margin-right:6px;}
.th-cd-price{font:800 .85rem var(--th-fb);color:var(--th-g);white-space:nowrap;}
.th-cd-empty{padding:28px 16px;text-align:center;color:#6b7280;font-size:.85rem;}
.th-cd-empty i{display:block;font-size:2rem;opacity:.25;margin-bottom:10px;}
.th-cd-foot{border-top:2px solid #e0f2f2;padding:12px 16px 14px;background:#f5fcfc;border-radius:0 0 12px 12px;}
.th-cd-total{display:flex;justify-content:space-between;align-items:center;margin-bottom:11px;padding-bottom:11px;border-bottom:1px solid #e0f2f2;font-size:.76rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;}
.th-cd-total span:last-child{font:800 1rem var(--th-fb);color:var(--th-g);text-transform:none;letter-spacing:0;}
.th-cd-btns{display:flex;gap:8px;}
.th-cd-btns a{flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:10px 12px;border-radius:50px;font:700 .8rem var(--th-fb);text-decoration:none;border:2px solid var(--th-g);white-space:nowrap;transition:all .2s;}
.th-cd-view{color:var(--th-g);background:#fff;}.th-cd-view:hover{background:var(--th-lt);}
.th-cd-go{color:#fff;background:var(--th-g);}.th-cd-go:hover{background:var(--th-dk);border-color:var(--th-dk);}

/* ===== Desktop menu bar ===== */
.th-nav{background:#fff;border-top:4px solid var(--th-red);padding:6px 12px;}
.th-nav-in{background:var(--th-dk);border-radius:8px;}
.th-list{display:flex;align-items:stretch;list-style:none;margin:0;padding:0 var(--th-px);flex-wrap:wrap;}
.th-list>li>a{display:flex;align-items:center;gap:7px;padding:13px 17px;font:600 13px var(--th-fh);letter-spacing:.04em;text-transform:uppercase;color:rgba(255,255,255,.9);white-space:nowrap;text-decoration:none;border-bottom:3px solid transparent;transition:background .2s,color .15s,border-color .2s;}
.th-list>li>a:hover,.th-list>li>a.active{background:rgba(0,0,0,.2);color:#fff;border-bottom-color:var(--th-red);}
.th-spacer{flex:1;}
.th-contact>a{background:var(--th-red) !important;color:#fff !important;border-radius:6px;border-bottom:0 !important;margin:7px 0 7px 6px;padding:6px 20px !important;font-weight:700 !important;}
.th-contact>a:hover,.th-contact>a.active{background:#c62828 !important;color:#fff !important;transform:translateY(-1px);}

/* Shop By Category dropdown */
.th-has-dd{position:relative;}
.th-has-dd>a .fa-chevron-down{font-size:.7rem;opacity:.8;}
.th-dd{position:absolute;top:100%;left:0;display:flex;align-items:stretch;max-width:calc(100vw - 40px);background:#fff;border-radius:0 0 8px 8px;border-top:3px solid var(--th-red);box-shadow:0 14px 36px rgba(0,0,0,.22);z-index:600;opacity:0;visibility:hidden;transform:translateY(8px);transition:opacity .2s,transform .2s,visibility .2s;}
.th-has-dd:hover .th-dd,.th-has-dd:focus-within .th-dd{opacity:1;visibility:visible;transform:translateY(0);}
.th-main{display:flex;align-items:flex-start;gap:10px;padding:12px;}
.th-col{width:250px;list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:6px;}
.th-col li{list-style:none;margin:0;padding:0;}
.th-col li a{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:9px 14px;font:600 13px var(--th-fh);letter-spacing:.02em;color:var(--th-dk);text-decoration:none;background:#fff;border:1.5px solid #c9d3cd;border-radius:10px;transition:background .15s,color .15s,border-color .15s,box-shadow .15s;}
.th-col li a:hover,.th-col li.is-active>a{background:var(--th-lt);color:var(--th-g);border-color:#75cfce;box-shadow:0 2px 8px rgba(0,0,0,.08);}
.th-col li.is-active>a{border-color:var(--th-g);}
.th-arrow{font-size:17px;line-height:1;opacity:.65;font-weight:800;}
.th-subwrap{display:none;flex:0 0 320px;width:320px;padding:14px 14px 16px;background:#f4fcfc;border-left:1.5px solid #d7f0f0;border-radius:0 0 8px 0;}
.th-dd.has-panel .th-subwrap{display:block;}
.th-sub{display:none;}.th-sub.is-active{display:block;}
.th-sub h3{font:700 14px var(--th-fh);letter-spacing:.03em;color:var(--th-dk);margin:0 0 3px;}
.th-sub-all{display:inline-block;margin-bottom:11px;font:700 12px var(--th-fb);color:var(--th-g);text-decoration:none;}
.th-sub-all:hover{text-decoration:underline;}
.th-sublist{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:6px;}
.th-sublist li a{display:block;padding:9px 12px;font:600 13px var(--th-fb);color:var(--th-dk);text-decoration:none;background:#fff;border:1.5px solid #c9d3cd;border-radius:10px;transition:background .15s,color .15s,border-color .15s;}
.th-sublist li a:hover{background:var(--th-lt);color:var(--th-g);border-color:#75cfce;}

/* ===== Mobile drawer ===== */
.th-movl{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:998;backdrop-filter:blur(2px);}
.th-movl.open{display:block;}
.th-mnav{position:fixed;top:0;left:-310px;width:300px;max-width:88vw;height:100%;background:#fff;z-index:999;transition:left .3s ease;overflow-y:auto;box-shadow:4px 0 24px rgba(0,0,0,.2);}
.th-mnav.open{left:0;}
.th-mhead{background:var(--th-g);padding:12px 16px;display:flex;justify-content:space-between;align-items:center;gap:10px;}
.th-mhead .th-logo-box img{height:38px;}
.th-mclose{background:rgba(255,255,255,.18);border:0;color:#fff;font-size:18px;cursor:pointer;width:34px;height:34px;border-radius:50%;flex-shrink:0;}
.th-mflag{display:flex;align-items:center;gap:8px;padding:9px 20px;background:var(--th-lt);font-size:12px;font-weight:600;color:var(--th-dk);}
.th-mnav a{display:block;padding:13px 22px;font:600 14px var(--th-fh);letter-spacing:.03em;text-transform:uppercase;color:var(--th-dk);border-bottom:1px solid #eaf6f6;text-decoration:none;transition:background .15s,color .15s,padding-left .2s;}
.th-mnav a:hover{background:var(--th-lt);color:var(--th-g);padding-left:28px;}
.th-mnav a.active{background:var(--th-lt);color:var(--th-g);border-left:4px solid var(--th-red);padding-left:18px;}
.th-mnav .th-mcontact{margin:14px 22px;display:inline-flex;align-items:center;gap:8px;background:var(--th-red);color:#fff !important;border-radius:6px;padding:9px 24px;border-bottom:0;}
.th-mnav .th-mcontact:hover{background:#c62828;padding-left:24px;}
.th-mnav details>summary{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:13px 22px;font:600 14px var(--th-fh);letter-spacing:.03em;text-transform:uppercase;color:var(--th-dk);border-bottom:1px solid #eaf6f6;cursor:pointer;list-style:none;}
.th-mnav details>summary::-webkit-details-marker{display:none;}
.th-mnav details>summary::after{content:'\25BE';font-size:12px;opacity:.7;transition:transform .2s;}
.th-mnav details[open]>summary{background:var(--th-g);color:#fff;}
.th-mnav details[open]>summary::after{transform:rotate(180deg);}
.th-mnav details a{padding-left:38px;font:600 13px var(--th-fb);text-transform:none;letter-spacing:0;background:#f9fdfd;}
.th-mnav details details>summary{padding-left:38px;font:600 13px var(--th-fb);text-transform:none;letter-spacing:0;background:#fff;color:var(--th-dk);}
.th-mnav details details[open]>summary{background:var(--th-lt);color:var(--th-g);}
.th-mnav details details a{padding-left:54px;font-size:12.5px;}
.th-mnav a.th-mall{color:var(--th-g);font-weight:700;}

/* ===== Responsive ===== */
@media (max-width:1180px){.th-deliv{display:none;}}
@media (max-width:1024px){:root{--th-px:28px;}}
@media (max-width:960px){
    .th-nav,.th-cdrop{display:none !important;}
    .th-burger{display:flex;}
    .th-bar{display:grid;grid-template-columns:auto 1fr auto;grid-template-rows:auto auto;align-items:center;gap:0;padding:0;}
    .th-burger{grid-column:1;grid-row:1;align-self:stretch;margin:0;padding:0 14px;border-radius:0;background:rgba(255,255,255,.1);border-right:1px solid rgba(255,255,255,.16);justify-content:center;min-height:54px;}
    .th-logo{grid-column:2;grid-row:1;padding:6px 10px;min-width:0;}
    .th-logo-box img{height:36px;max-width:150px;}
    .th-right{grid-column:3;grid-row:1;gap:0;padding:0 6px;align-self:stretch;border-left:1px solid rgba(255,255,255,.16);}
    .th-search{grid-column:1 / -1;grid-row:2;max-width:100%;width:100%;margin:0;padding:8px 11px;border-top:1px solid rgba(255,255,255,.2);background:rgba(0,0,0,.14);}
    .th-search input[type="search"]{padding:9px 12px;font-size:13px;}
    .th-search button{padding:9px 14px;font-size:12px;}
}
@media (max-width:640px){
    .th-top{display:none;}
    .th-cart-amt{font-size:11px;}
    .th-wish i,.th-cart i{font-size:1.1rem;}
}
@media (max-width:380px){
    .th-cart-amt{display:none;}
    .th-logo-box img{height:30px;max-width:120px;}
}

/* ---- Top bar uses theme font ---- */
.th-top{font-family:var(--th-fh);font-size:13px;letter-spacing:.04em;}
.th-top .th-mi,.th-top .th-mi a{font-family:var(--th-fh);font-weight:600;color:#fff;}
.th-top .th-mi i{color:#22adb0;}

/* ---- WooCommerce image override ---- */
.th-sticky .th-logo-box img,.th-mhead .th-logo-box img{height:var(--th-lh,48px) !important;width:auto !important;max-width:var(--th-lw,200px) !important;object-fit:contain;}
.th-mhead{--th-lh:38px;}
#th-loader .th-ld-box img{height:60px !important;width:auto !important;max-width:230px !important;}
.th-cdrop .th-cd-item img{width:48px !important;height:48px !important;max-width:48px !important;}
@media (max-width:960px){.th-sticky{--th-lh:36px;--th-lw:150px;}}
@media (max-width:380px){.th-sticky{--th-lh:30px;--th-lw:120px;}}

/* ---- Mobile search height ---- */
@media (max-width:960px){
    .th-search{padding:10px 11px;}
    .th-search form{min-height:48px;}
    .th-search input[type="search"]{min-height:48px;height:48px;padding:0 14px;font-size:15px;}
    .th-search button{min-height:48px;height:48px;padding:0 18px;font-size:14px;}
}
@media (max-width:380px){
    .th-search input[type="search"]{font-size:14px;padding:0 10px;}
    .th-search button{padding:0 12px;font-size:13px;}
}

/* ---- Hero overlay v2 ---- */
html body [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body .ct .ct-band-bg::after{content:"";position:absolute;inset:0;z-index:1;pointer-events:none;background:rgba(11,74,140,.55) !important;}
html body.home [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body.home [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body.home .ct .ct-band-bg::after,
html body.post-type-archive-product [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body.post-type-archive-product [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body.post-type-archive-product .ct .ct-band-bg::after,
html body.woocommerce-shop [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body.woocommerce-shop [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body.woocommerce-shop .ct .ct-band-bg::after,
html body[class*="page-template-page-about-us"] [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body[class*="page-template-page-about-us"] [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body[class*="page-template-page-about-us"] .ct .ct-band-bg::after,
html body[class*="page-template-page-contact"] [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body[class*="page-template-page-contact"] [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body[class*="page-template-page-contact"] .ct .ct-band-bg::after{background:linear-gradient(to right,rgba(11,74,140,.9) 0%,rgba(11,74,140,.65) 40%,rgba(11,74,140,0) 78%) !important;}
html body [class$="hero"],html body [class*="hero "]{position:relative;}
html body [class$="hero"]:not(.rp-hero) h1,html body [class*="hero "]:not(.rp-hero) h1,
html body [class$="hero"]:not(.rp-hero) h2,html body [class*="hero "]:not(.rp-hero) h2,
html body [class$="hero"]:not(.rp-hero) p,html body [class*="hero "]:not(.rp-hero) p,
html body [class$="hero"]:not(.rp-hero) a,html body [class*="hero "]:not(.rp-hero) a,
html body [class$="hero"]:not(.rp-hero) button,html body [class*="hero "]:not(.rp-hero) button{position:relative;z-index:3;}
html body [class*="hero"] img{opacity:1 !important;filter:none !important;}
html body [class*="hero"] h1,html body [class*="hero"] h2,html body [class*="hero"] p,
html body .ct .ct-band h1,html body .ct .ct-band p{text-shadow:0 1px 3px rgba(0,0,0,.6),0 3px 18px rgba(0,0,0,.5);}
@media (max-width:800px){
html body.home [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body.home [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body.home .ct .ct-band-bg::after,
html body.post-type-archive-product [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body.post-type-archive-product [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body.post-type-archive-product .ct .ct-band-bg::after,
html body.woocommerce-shop [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body.woocommerce-shop [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body.woocommerce-shop .ct .ct-band-bg::after,
html body[class*="page-template-page-about-us"] [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body[class*="page-template-page-about-us"] [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body[class*="page-template-page-about-us"] .ct .ct-band-bg::after,
html body[class*="page-template-page-contact"] [class$="hero"][class$="hero"][class$="hero"]:not(.rp-hero)::before,
html body[class*="page-template-page-contact"] [class*="hero "][class*="hero "][class*="hero "]:not(.rp-hero)::before,
html body[class*="page-template-page-contact"] .ct .ct-band-bg::after{background:rgba(11,74,140,.6) !important;}
}

/* ---- Flag and badge v1 ---- */
html body .ke-flag{width:26px;height:17px;border-radius:2px;background:linear-gradient(to bottom,#000 0,#000 27%,#fff 27%,#fff 35%,#bb0000 35%,#bb0000 65%,#fff 65%,#fff 73%,#006600 73%,#006600 100%);box-shadow:0 0 0 1px rgba(0,0,0,.25);}
html body .ke-flag::after{width:7px;height:12px;border-radius:50%;background:linear-gradient(90deg,#bb0000 0,#bb0000 38%,#fff 38%,#fff 62%,#bb0000 62%,#bb0000 100%);border:1px solid #000;box-sizing:border-box;transform:translate(-50%,-50%);}
html body .th-deliv .ke-flag{display:inline-block;}
@media (max-width:1180px){
    html body .th-deliv{display:flex !important;}
    html body .th-deliv > span:not(.ke-flag){display:none;}
}
@media (max-width:960px){
    html body .th-deliv{margin-right:8px;}
}
html body .th-cart .th-badge{left:50%;right:auto;top:-3px;margin-left:2px;}
@media (max-width:640px){
    html body .th-cart .th-badge{min-width:16px;height:16px;font-size:9px;top:-2px;}
}

/* ---- wa-nohover-v1: Order via WhatsApp buttons keep their colour on hover ---- */
html body .hp-btn.hp-btn-sm.hp-btn-wa:hover,
html body .hp-btn.hp-btn-sm.hp-btn-wa:focus,
html body .hp-btn.hp-btn-sm.hp-btn-wa:active,
html body .hp-btn.hp-btn-sm.hp-btn-wa:focus-visible,
html body .sh-b.wa:hover,
html body .sh-b.wa:focus,
html body .sh-b.wa:active,
html body .sh-b.wa:focus-visible,
html body .hp-b.wa:hover,
html body .hp-b.wa:focus,
html body .hp-b.wa:active,
html body .hp-b.wa:focus-visible,
html body .chkp-wa-btn:hover,
html body .chkp-wa-btn:focus,
html body .chkp-wa-btn:active,
html body .chkp-wa-btn:focus-visible{background:#25d366 !important;background-color:#25d366 !important;border-color:#25d366 !important;color:#fff !important;}

/* ---- Category side panel v1 ---- */
@media (min-width:961px){ .th-has-dd .th-dd{display:none !important;} }
@media (max-width:960px){ .th-side{display:none !important;} }
.th-side{display:none;position:absolute;left:0;top:0;width:var(--th-sw,290px);z-index:450;background:#fff;flex-direction:column;box-shadow:6px 0 24px rgba(9,60,60,.18);border-right:3px solid var(--th-red);font-family:var(--th-fh);box-sizing:border-box;}
.th-side *{box-sizing:border-box;}
.th-side.open{display:flex;}
.th-side.is-fixed{position:fixed;}
.th-side-head{flex:0 0 auto;background:var(--th-dk);color:#fff;padding:14px 18px;font:600 15px var(--th-fh);letter-spacing:.04em;text-transform:uppercase;display:flex;align-items:center;gap:10px;border-bottom:3px solid var(--th-red);}
.th-side-list{flex:1 1 auto;min-height:0;overflow-y:auto;overscroll-behavior:contain;list-style:none;margin:0;padding:8px;scrollbar-width:thin;scrollbar-color:var(--th-g) var(--th-lt);}
.th-side-list::-webkit-scrollbar{width:8px;}
.th-side-list::-webkit-scrollbar-track{background:var(--th-lt);}
.th-side-list::-webkit-scrollbar-thumb{background:var(--th-g);border-radius:6px;}
.th-side-item{list-style:none;margin:0 0 2px;padding:0;}
.th-side-row{display:flex;align-items:center;border-radius:8px;transition:background .15s;}
.th-side-row:hover{background:var(--th-lt);}
.th-side-row>a{flex:1;min-width:0;display:flex;align-items:center;gap:12px;padding:11px 10px;font:600 14px var(--th-fh);letter-spacing:.02em;color:var(--th-dk);text-decoration:none;line-height:1.3;}
.th-side-row>a i{width:22px;text-align:center;color:var(--th-g);font-size:1.05rem;flex:0 0 auto;}
.th-side-row>a:hover{color:var(--th-g);}
.th-side-tg{flex:0 0 38px;height:38px;border:0;background:transparent;color:var(--th-dk);cursor:pointer;border-radius:8px;}
.th-side-tg i{font-size:.8rem;transition:transform .2s;}
.th-side-item.open .th-side-tg i{transform:rotate(90deg);}
.th-side-sub{display:none;list-style:none;margin:2px 0 6px 22px;padding:0 0 0 10px;border-left:2px solid #d7f0f0;}
.th-side-item.open .th-side-sub{display:block;}
.th-side-sub a{display:block;padding:8px 10px;font:500 13.5px var(--th-fh);color:var(--th-dk);text-decoration:none;border-radius:6px;}
.th-side-sub a:hover{background:var(--th-lt);color:var(--th-g);}
.th-side-foot{flex:0 0 auto;padding:10px;background:#f4fcfc;border-top:1px solid #d7f0f0;}
.th-side-foot a{display:flex;align-items:center;justify-content:center;gap:8px;padding:11px 12px;border-radius:8px;background:var(--th-g);color:#fff;font:600 13px var(--th-fh);letter-spacing:.04em;text-transform:uppercase;text-decoration:none;}
.th-side-foot a:hover{background:var(--th-dk);}
html.th-push{overflow-x:clip;}
html body .th-pushed{margin-left:var(--th-sw,290px) !important;width:auto !important;max-width:none !important;}

/* ---- Mobile menu: our font, bigger text, scrollable ---- */
@media (max-width:960px){
    html body .th-mnav{height:100vh;height:100dvh;overflow-y:auto;-webkit-overflow-scrolling:touch;overscroll-behavior:contain;padding-bottom:48px;}
    html body .th-mnav a,html body .th-mnav details>summary{font-family:var(--th-fh);font-size:16px;letter-spacing:.03em;line-height:1.35;padding-top:14px;padding-bottom:14px;}
    html body .th-mnav details a{font-family:var(--th-fh);font-size:15px;font-weight:500;text-transform:none;letter-spacing:.01em;}
    html body .th-mnav details details>summary{font-family:var(--th-fh);font-size:15px;text-transform:none;}
    html body .th-mnav details details a{font-size:14.5px;}
}

/* ---- WhatsApp floating icon pulse ---- */
@keyframes th-wapulse{0%{box-shadow:0 0 0 0 rgba(37,211,102,.65);}70%{box-shadow:0 0 0 20px rgba(37,211,102,0);}100%{box-shadow:0 0 0 0 rgba(37,211,102,0);}}
html body .th-wa-pulse,html body [class*="whatsapp-float"],html body [class*="wa-float"],html body [class*="float-wa"],html body #whatsapp-float,html body .wa-fab,html body .whatsapp-fab,html body .floating-whatsapp{animation:th-wapulse 1.8s ease-out infinite;}
@media (prefers-reduced-motion:reduce){html body .th-wa-pulse,html body [class*="whatsapp-float"],html body [class*="wa-float"],html body [class*="float-wa"]{animation:none;}}

/* ---- Category side panel v2: no red borders, under the menu, hover opens sub-categories ---- */
html body .th-side{position:fixed;display:none;border:0;border-radius:0 0 10px 10px;overflow:hidden;box-shadow:0 14px 36px rgba(9,60,60,.22);z-index:520;}
html body .th-side.open{display:flex;}
html body .th-side-head{border-bottom:0;}
html body .th-side-sub{border-left:0;padding-left:0;margin-left:34px;}
@media (max-width:960px){ html body .th-side{display:none !important;} }
html body .cv-loading{opacity:.65;pointer-events:none;}

/* ---- btn-radius-v1: every button uses the Add to Cart radius ---- */
html body .th-cd-btns a,
html body .th-cd-view,
html body .th-cd-go,
html body .cart-checkout-btn,
html body .cart-coupon-group button[name="apply_coupon"],
html body .mobile-apply-btn,
html body button[name="update_cart"],
html body .cart-empty-box a.btn-shop,
html body .chkp-wa-btn,
html body .chkp-place-btn,
html body .chkp-wrap button,
html body #chkp-wa-btn,
html body #chkp-wa-btn-mobile,
html body #chkp-place-btn-desktop,
html body #chkp-place-btn-mobile,
html body .sp-wa-btn,
html body .sp-atc-btn,
html body .sp-wrap .p-btn-cart,
html body .sp-wrap .p-btn-wa,
html body .single_add_to_cart_button,
html body .hp-btn,
html body .hp-b,
html body .sh-b,
html body .sh-btn,
html body .spx-submit,
html body a[href*="wa.me"]:not(.th-soc),
html body a[href*="api.whatsapp.com"]:not(.th-soc),
html body a[href*="whatsapp.com/send"]:not(.th-soc),
html body [class*="whatsapp-float"],
html body [class*="wa-float"],
html body [class*="float-wa"],
html body .th-wa-pulse,
html body #whatsapp-float,
html body .wa-fab,
html body .whatsapp-fab,
html body .floating-whatsapp{border-radius:6px !important;}

/* ---- tight-v1: compact banners on Terms and Refund, small breadcrumb everywhere ---- */
html body .site-breadcrumb{padding-top:6px !important;padding-bottom:6px !important;margin:0 !important;min-height:0 !important;line-height:1.3 !important;font-size:.85rem !important;}

/* Terms */
html body main.tm .tm-hero-in{padding:22px 5% 46px !important;}
html body main.tm .tm-hero-txt{max-width:820px !important;}
html body main.tm .tm-hero h1{font-size:clamp(1.5rem,3vw,2.3rem) !important;margin:0 0 10px !important;}
html body main.tm .tm-badge{margin-bottom:10px !important;}
html body main.tm .tm-hero-line{margin-bottom:10px !important;}
html body main.tm .tm-upd{margin-top:10px !important;}
html body main.tm .tm-sum{margin-top:-26px !important;}

/* Refund */
html body .rp-hero{min-height:0 !important;padding-top:20px !important;padding-bottom:44px !important;}
html body .rp-hero > div,
html body .rp-hero [class*="-in"],
html body .rp-hero [class*="inner"],
html body .rp-hero [class*="wrap"]{padding-top:0 !important;padding-bottom:0 !important;min-height:0 !important;}
html body .rp-hero h1{font-size:clamp(1.5rem,3vw,2.3rem) !important;margin:0 0 10px !important;}
</style>
<?php wp_head(); ?>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/live-search.js?v=1" defer></script>
</head>
<body <?php body_class(); ?>>

<div id="th-loader" aria-hidden="true">
    <svg class="th-dots" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" focusable="false">
        <g class="th-ring">
            <circle class="r" cx="50"   cy="20"   r="2.4"/>
            <circle class="t" cx="67.6" cy="25.7" r="4.6"/>
            <circle class="g" cx="78.5" cy="40.7" r="6.6"/>
            <circle class="t" cx="78.5" cy="59.3" r="7.6"/>
            <circle class="g" cx="67.6" cy="74.3" r="6.8"/>
            <circle class="t" cx="50"   cy="80"   r="5"/>
            <circle class="g" cx="32.4" cy="74.3" r="3.4"/>
            <circle class="r" cx="21.5" cy="59.3" r="2.4"/>
            <circle class="g" cx="21.5" cy="40.7" r="2"/>
            <circle class="t" cx="32.4" cy="25.7" r="2.2"/>
        </g>
    </svg>
</div>
<script>
(function(){
    function hide(){var l=document.getElementById('th-loader');if(!l||l.dataset.gone)return;l.dataset.gone='1';l.classList.add('th-out');setTimeout(function(){l.style.display='none';},480);}
    if(document.readyState==='complete'){hide();}else{window.addEventListener('load',hide);}
    setTimeout(hide,4000);
})();
</script>
<?php wp_body_open(); ?>

<!-- ==================== MOBILE DRAWER ==================== -->
<div class="th-movl" id="thOvl"></div>
<nav class="th-mnav" id="thMnav" aria-label="Mobile navigation">
    <div class="th-mhead">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="th-logo" style="padding:0;border:0;background:none;"><span class="th-logo-box"><img src="<?php echo esc_url( $th_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"></span></a>
        <button class="th-mclose" id="thMclose" aria-label="Close menu">&#x2715;</button>
    </div>
    <div class="th-mflag"><?php echo $th_flag; ?> Delivery in Nairobi, Thika &amp; across Kenya</div>

    <details>
        <summary>Shop By Category</summary>
        <a class="th-mall" href="<?php echo esc_url( $th_shop ); ?>">View all products</a>
        <?php foreach ( $th_cats as $c ) : ?>
            <?php if ( ! empty( $c[2] ) ) : ?>
                <details>
                    <summary><?php echo esc_html( $c[0] ); ?></summary>
                    <a class="th-mall" href="<?php echo esc_url( $c[1] ); ?>">View all <?php echo esc_html( $c[0] ); ?></a>
                    <?php foreach ( $c[2] as $k ) : ?>
                        <a href="<?php echo esc_url( $k[1] ); ?>"><?php echo esc_html( $k[0] ); ?></a>
                    <?php endforeach; ?>
                </details>
            <?php else : ?>
                <a href="<?php echo esc_url( $c[1] ); ?>"><?php echo esc_html( $c[0] ); ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </details>

    <?php foreach ( $th_links as $l ) : ?>
        <a href="<?php echo esc_url( $l[0] ); ?>"<?php echo $l[2] ? ' class="active"' : ''; ?>><?php echo esc_html( $l[1] ); ?></a>
    <?php endforeach; ?>
    <a href="<?php echo esc_url( $th_contact_url ); ?>" class="th-mcontact"><i class="fa-solid fa-phone" aria-hidden="true"></i> Contact Us</a>
</nav>

<!-- ==================== TOP BAR ==================== -->
<div class="th-top">
    <div class="th-marq">
        <div class="th-marq-track">
            <?php
            $th_items = function () use ( $th_phone, $th_wa, $th_email, $th_addr, $th_hours, $th_flag ) {
                ?>
                <span class="th-mi"><i class="fa-solid fa-phone" aria-hidden="true"></i><a href="tel:+<?php echo esc_attr( $th_wa ); ?>"><?php echo esc_html( $th_phone ); ?></a></span><span class="th-msep">&#9679;</span>
                <span class="th-mi"><i class="fa-solid fa-envelope" aria-hidden="true"></i><a href="mailto:<?php echo esc_attr( $th_email ); ?>"><?php echo esc_html( $th_email ); ?></a></span><span class="th-msep">&#9679;</span>
                <span class="th-mi"><?php echo $th_flag; ?><?php echo esc_html( $th_addr ); ?></span><span class="th-msep">&#9679;</span>
                <span class="th-mi"><i class="fa-solid fa-clock" aria-hidden="true"></i><?php echo esc_html( $th_hours ); ?></span><span class="th-msep">&#9679;</span>
                <span class="th-mi"><i class="fa-solid fa-truck-fast" aria-hidden="true"></i>Lab and hospital equipment delivered in Nairobi, Thika and across Kenya</span><span class="th-msep">&#9679;</span>
                <?php
            };
            $th_items();
            $th_items();
            ?>
        </div>
    </div>
    <div class="th-soc-wrap">
        <?php foreach ( $th_socials as $s ) : ?>
            <a href="<?php echo esc_url( $s[1] ); ?>" class="th-soc th-soc-<?php echo esc_attr( $s[0] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $s[3] ); ?>"><i class="<?php echo esc_attr( $s[2] ); ?>" aria-hidden="true"></i></a>
        <?php endforeach; ?>
        <a href="https://wa.me/<?php echo esc_attr( $th_wa ); ?>" class="th-soc th-soc-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
    </div>
</div>

<!-- ==================== STICKY HEADER ==================== -->
<div class="th-sticky" id="thSticky">

<div class="th-bar">
    <button class="th-burger" id="thBurger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button>

    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="th-logo" aria-label="Travotech Agencies - Go to homepage">
        <span class="th-logo-box"><img src="<?php echo esc_url( $th_logo ); ?>" alt="Travotech Agencies" width="160" height="48" loading="eager" decoding="async"></span>
    </a>

    <div class="th-search">
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" name="s" placeholder="Search lab and hospital equipment..." value="<?php echo esc_attr( get_search_query() ); ?>">
            <input type="hidden" name="post_type" value="product">
            <button type="submit"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Search</button>
        </form>
    </div>

    <div class="th-right">
        <div class="th-deliv"><?php echo $th_flag; ?><span><strong>Delivery</strong>Nairobi &amp; Kenya</span></div>

        <?php
        $th_wl_url = function_exists( 'YITH_WCWL' ) ? YITH_WCWL()->get_wishlist_url() : home_url( '/wishlist/' );
        $th_wl_cnt = function_exists( 'yith_wcwl_count_products_in_wishlist' ) ? (int) yith_wcwl_count_products_in_wishlist() : 0;
        ?>
        <a href="<?php echo esc_url( $th_wl_url ); ?>" class="th-wish" aria-label="Wishlist">
            <i class="fa-regular fa-heart" aria-hidden="true"></i>
            <?php if ( $th_wl_cnt > 0 ) : ?><span class="th-badge"><?php echo (int) $th_wl_cnt; ?></span><?php endif; ?>
        </a>

        <?php if ( function_exists( 'WC' ) && WC()->cart ) :
            $th_items_in = WC()->cart->get_cart();
            $th_cnt      = WC()->cart->get_cart_contents_count();
            $th_total    = WC()->cart->get_cart_total();
            $th_cart_url = wc_get_cart_url();
            $th_chk_url  = wc_get_checkout_url();
        ?>
        <div class="th-cartwrap">
            <a href="<?php echo esc_url( $th_cart_url ); ?>" class="th-cart" aria-label="View cart">
                <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                <span class="th-cart-amt"><?php echo wp_kses_post( $th_total ); ?></span>
                <?php if ( $th_cnt > 0 ) : ?><span class="th-badge"><?php echo (int) $th_cnt; ?></span><?php endif; ?>
            </a>

            <div class="th-cdrop" role="region" aria-label="Cart preview">
                <div class="th-cd-head"><span><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Your Cart</span><b><?php echo (int) $th_cnt; ?> item<?php echo 1 !== $th_cnt ? 's' : ''; ?></b></div>
                <div class="th-cd-items">
                    <?php if ( ! empty( $th_items_in ) ) : foreach ( $th_items_in as $it ) :
                        $pr   = $it['data'];
                        $qty  = (int) $it['quantity'];
                        $iid  = $pr->get_image_id();
                        $iurl = $iid ? wp_get_attachment_image_url( $iid, 'thumbnail' ) : '';
                    ?>
                    <div class="th-cd-item">
                        <?php if ( $iurl ) : ?><img src="<?php echo esc_url( $iurl ); ?>" alt="<?php echo esc_attr( $pr->get_name() ); ?>"><?php else : ?><span class="th-cd-ph"><i class="fa-regular fa-image" aria-hidden="true"></i></span><?php endif; ?>
                        <div class="th-cd-info">
                            <div class="th-cd-name" title="<?php echo esc_attr( $pr->get_name() ); ?>"><?php echo esc_html( $pr->get_name() ); ?></div>
                            <div class="th-cd-meta"><em>&times;<?php echo $qty; ?></em><?php echo esc_html( wp_strip_all_tags( wc_price( $pr->get_price() ) ) ); ?> each</div>
                        </div>
                        <div class="th-cd-price"><?php echo wp_kses_post( wc_price( $pr->get_price() * $qty ) ); ?></div>
                    </div>
                    <?php endforeach; else : ?>
                    <div class="th-cd-empty"><i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>Your cart is currently empty</div>
                    <?php endif; ?>
                </div>
                <?php if ( ! empty( $th_items_in ) ) : ?>
                <div class="th-cd-foot">
                    <div class="th-cd-total"><span>Order Total</span><span><?php echo wp_kses_post( $th_total ); ?></span></div>
                    <div class="th-cd-btns">
                        <a href="<?php echo esc_url( $th_cart_url ); ?>" class="th-cd-view">View Cart</a>
                        <a href="<?php echo esc_url( $th_chk_url ); ?>" class="th-cd-go">Checkout <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ==================== DESKTOP MENU ==================== -->
<nav class="th-nav" aria-label="Primary navigation">
    <div class="th-nav-in">
        <ul class="th-list">

            <li class="th-has-dd">
                <a href="<?php echo esc_url( $th_shop ); ?>"><i class="fa-solid fa-bars" aria-hidden="true"></i> Shop By Category <i class="fa-solid fa-chevron-down" aria-hidden="true"></i></a>
                <div class="th-dd" id="thDd">
                    <div class="th-main">
                        <?php if ( empty( $th_cats ) ) : ?>
                            <ul class="th-col"><li><a href="<?php echo esc_url( $th_shop ); ?>"><span>All Products</span></a></li></ul>
                        <?php else :
                            foreach ( array( false, true ) as $want_sub ) :
                                $th_has_col = false;
                                foreach ( $th_cats as $c ) { if ( ( ! empty( $c[2] ) ) === $want_sub ) { $th_has_col = true; break; } }
                                if ( ! $th_has_col ) { continue; }
                        ?>
                        <ul class="th-col">
                            <?php foreach ( $th_cats as $i => $c ) :
                                $has = ! empty( $c[2] );
                                if ( $has !== $want_sub ) { continue; } ?>
                            <li data-cat="<?php echo (int) $i; ?>"<?php echo $has ? ' class="has-sub"' : ''; ?>>
                                <a href="<?php echo esc_url( $c[1] ); ?>"><span><?php echo esc_html( $c[0] ); ?></span><?php if ( $has ) : ?><span class="th-arrow" aria-hidden="true">&rsaquo;</span><?php endif; ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endforeach; endif; ?>
                    </div>
                    <div class="th-subwrap">
                        <?php foreach ( $th_cats as $i => $c ) : if ( empty( $c[2] ) ) { continue; } ?>
                        <div class="th-sub" data-cat="<?php echo (int) $i; ?>">
                            <h3><?php echo esc_html( $c[0] ); ?></h3>
                            <a class="th-sub-all" href="<?php echo esc_url( $c[1] ); ?>">View all</a>
                            <ul class="th-sublist">
                                <?php foreach ( $c[2] as $k ) : ?>
                                <li><a href="<?php echo esc_url( $k[1] ); ?>"><?php echo esc_html( $k[0] ); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </li>

            <?php foreach ( $th_links as $l ) : ?>
            <li><a href="<?php echo esc_url( $l[0] ); ?>"<?php echo $l[2] ? ' class="active"' : ''; ?>><?php echo esc_html( $l[1] ); ?></a></li>
            <?php endforeach; ?>

            <li class="th-spacer" aria-hidden="true"></li>
            <li class="th-contact"><a href="<?php echo esc_url( $th_contact_url ); ?>"<?php echo $th_contact_on ? ' class="active"' : ''; ?>><i class="fa-solid fa-phone" aria-hidden="true"></i> Contact Us</a></li>
        </ul>
    </div>
</nav>

</div><!-- /.th-sticky -->
<script>
/* cv-ajax-atc-v1: add to cart in the background, no reload, no scroll */
(function(){
    var SEL='.sh-atc,.hp-atc,#sp-main-atc,.travotech-rel-atc';
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
    document.addEventListener('click',function(e){
        var btn=e.target.closest?e.target.closest(SEL):null;
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
        var tx=btn.querySelector('.t'),old=tx?tx.textContent:'';
        btn.setAttribute('data-busy','1');
        btn.classList.add('cv-loading');
        if(btn.id==='sp-main-atc')btn.classList.add('atc-loading');
        if(tx)tx.textContent='Adding...';
        function done(){
            btn.removeAttribute('data-busy');
            btn.classList.remove('cv-loading','atc-loading');
        }
        fetch(u.toString(),{credentials:'same-origin',headers:{'X-Requested-With':'XMLHttpRequest'}})
        .then(function(r){if(!r.ok)throw new Error('http');return r.text();})
        .then(function(html){
            if(!swapCart(html))throw new Error('nocart');
            done();
            if(tx){tx.textContent='Added';setTimeout(function(){tx.textContent=old;},1400);}
            toast(name);
        })
        .catch(function(){
            done();if(tx)tx.textContent=old;
            window.location.href=u.toString();
        });
    },true);
})();
</script>

<?php
$th_ic = function ( $n ) {
    $n   = strtolower( $n );
    $map = array( 'glove' => 'fa-hand', 'consum' => 'fa-hand', 'furnit' => 'fa-bed', 'hospital' => 'fa-bed', 'bed' => 'fa-bed', 'surg' => 'fa-scissors', 'diagnos' => 'fa-stethoscope', 'lab' => 'fa-flask', 'monitor' => 'fa-heart-pulse', 'pharm' => 'fa-pills', 'medic' => 'fa-pills', 'access' => 'fa-kit-medical', 'test' => 'fa-vial', 'ppe' => 'fa-mask-face', 'protect' => 'fa-mask-face', 'well' => 'fa-heart' );
    foreach ( $map as $k => $i ) { if ( strpos( $n, $k ) !== false ) { return $i; } }
    return 'fa-box-open';
};
?>
<aside class="th-side" id="thSide" aria-label="Product categories">
    <div class="th-side-head"><i class="fa-solid fa-table-cells-large" aria-hidden="true"></i> Products Categories</div>
    <ul class="th-side-list">
        <?php foreach ( $th_cats as $th_c ) : $has = ! empty( $th_c[2] ); ?>
        <li class="th-side-item">
            <div class="th-side-row">
                <a href="<?php echo esc_url( $th_c[1] ); ?>"><i class="fa-solid <?php echo esc_attr( $th_ic( $th_c[0] ) ); ?>" aria-hidden="true"></i><span><?php echo esc_html( $th_c[0] ); ?></span></a>
                <?php if ( $has ) : ?><button type="button" class="th-side-tg" aria-expanded="false" aria-label="Show <?php echo esc_attr( $th_c[0] ); ?> sub-categories"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button><?php endif; ?>
            </div>
            <?php if ( $has ) : ?>
            <ul class="th-side-sub">
                <?php foreach ( $th_c[2] as $k ) : ?><li><a href="<?php echo esc_url( $k[1] ); ?>"><?php echo esc_html( $k[0] ); ?></a></li><?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="th-side-foot"><a href="<?php echo esc_url( $th_shop ); ?>">View all products <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
</aside>
<script>
(function(){
    var li=document.querySelector('.th-has-dd'),side=document.getElementById('thSide'),nav=document.querySelector('.th-nav-in');
    if(!li||!side||!nav)return;
    var timer=null;
    function desk(){return window.innerWidth>960;}
    function items(){return side.querySelectorAll('.th-side-item');}
    function place(){
        var nb=nav.getBoundingClientRect().bottom,lr=li.getBoundingClientRect();
        side.style.left=Math.max(lr.left,0)+'px';
        side.style.top=nb+'px';
        side.style.width=Math.max(lr.width,250)+'px';
        side.style.height=Math.max(Math.min(window.innerHeight-nb-12,560),220)+'px';
    }
    function closeSubs(){
        items().forEach(function(x){x.classList.remove('open');var b=x.querySelector('.th-side-tg');if(b)b.setAttribute('aria-expanded','false');});
    }
    function open(){if(!desk())return;clearTimeout(timer);place();side.classList.add('open');}
    function close(){side.classList.remove('open');closeSubs();}
    function shut(){clearTimeout(timer);timer=setTimeout(close,300);}
    li.addEventListener('mouseenter',open);
    li.addEventListener('mouseleave',shut);
    li.addEventListener('focusin',open);
    side.addEventListener('mouseenter',function(){clearTimeout(timer);});
    side.addEventListener('mouseleave',shut);
    document.addEventListener('keydown',function(e){if(e.key==='Escape')close();});
    window.addEventListener('resize',close);
    window.addEventListener('scroll',function(){if(side.classList.contains('open'))place();},{passive:true});
    /* hover a category: its sub-categories open without a click */
    side.addEventListener('mouseover',function(e){
        var it=e.target.closest('.th-side-item');if(!it||it.classList.contains('open'))return;
        closeSubs();
        if(it.querySelector('.th-side-sub')){it.classList.add('open');var b=it.querySelector('.th-side-tg');if(b)b.setAttribute('aria-expanded','true');}
    });
    side.addEventListener('click',function(e){
        var b=e.target.closest('.th-side-tg');if(!b)return;
        var it=b.closest('.th-side-item'),o=it.classList.toggle('open');
        b.setAttribute('aria-expanded',o?'true':'false');
    });
})();(function(){
    function mark(){
        var a=document.querySelectorAll('a[href*="wa.me"],a[href*="api.whatsapp.com"],a[href*="whatsapp.com/send"]');
        for(var i=0;i<a.length;i++){
            var e=a[i];if(e.closest('.th-top,.th-soc-wrap'))continue;
            if(getComputedStyle(e).position==='fixed'){e.classList.add('th-wa-pulse');}
            else{var p=e.parentElement;if(p&&getComputedStyle(p).position==='fixed'){p.classList.add('th-wa-pulse');}}
        }
    }
    document.addEventListener('DOMContentLoaded',mark);
    window.addEventListener('load',function(){mark();setTimeout(mark,1500);});
})();
</script>

<script>
(function(){
    var b=document.getElementById('thBurger'),n=document.getElementById('thMnav'),o=document.getElementById('thOvl'),c=document.getElementById('thMclose');
    function open(){n.classList.add('open');o.classList.add('open');b.setAttribute('aria-expanded','true');document.body.style.overflow='hidden';}
    function close(){n.classList.remove('open');o.classList.remove('open');b.setAttribute('aria-expanded','false');document.body.style.overflow='';}
    if(b)b.addEventListener('click',open);if(c)c.addEventListener('click',close);if(o)o.addEventListener('click',close);

    var s=document.getElementById('thSticky');
    if(s){var f=function(){s.classList.toggle('is-pinned',window.scrollY>4);};window.addEventListener('scroll',f,{passive:true});f();}

    /* Shop By Category: show the sub-category panel when a category with sub-categories is hovered */
    var dd=document.getElementById('thDd');if(!dd)return;
    var holder=dd.parentNode,items=dd.querySelectorAll('.th-col > li'),panels=dd.querySelectorAll('.th-sub');
    function show(li){
        var has=li.classList.contains('has-sub'),id=li.getAttribute('data-cat');
        for(var i=0;i<items.length;i++){items[i].classList.toggle('is-active',has&&items[i]===li);}
        for(var j=0;j<panels.length;j++){panels[j].classList.toggle('is-active',has&&panels[j].getAttribute('data-cat')===id);}
        dd.classList.toggle('has-panel',has);
    }
    function reset(){
        for(var i=0;i<items.length;i++){items[i].classList.remove('is-active');}
        for(var j=0;j<panels.length;j++){panels[j].classList.remove('is-active');}
        dd.classList.remove('has-panel');
    }
    for(var k=0;k<items.length;k++){(function(li){
        li.addEventListener('mouseenter',function(){if(li.classList.contains('has-sub')){show(li);}else{reset();}});
        li.addEventListener('focusin',function(){show(li);});
    })(items[k]);}
    holder.addEventListener('mouseleave',reset);
})();
</script>

<?php if ( ! is_front_page() ) : ?>
<div class="site-breadcrumb">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
    <?php if ( function_exists( 'is_shop' ) && is_shop() ) : ?>
        <span>&#8250;</span><span>Shop</span>
    <?php elseif ( is_singular( 'product' ) ) : ?>
        <span>&#8250;</span><a href="<?php echo esc_url( $th_shop ); ?>">Shop</a>
        <span>&#8250;</span><span><?php the_title(); ?></span>
    <?php elseif ( function_exists( 'is_product_category' ) && is_product_category() ) : ?>
        <span>&#8250;</span><a href="<?php echo esc_url( $th_shop ); ?>">Shop</a>
        <span>&#8250;</span><span><?php single_cat_title(); ?></span>
    <?php elseif ( is_page() ) : ?>
        <span>&#8250;</span><span><?php the_title(); ?></span>
    <?php endif; ?>
</div>
<?php endif; ?>
