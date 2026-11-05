<?php
/**
 * Travotech Agencies — footer.php
 * Layout and type follow the Leshavin reference footer (Oswald headings, Inter body).
 * Palette is the Travotech green. Everything is prefixed trv- so it cannot clash with older CSS.
 */

$trv_pick = function ( array $fns, $default ) {
    foreach ( $fns as $fn ) {
        if ( function_exists( $fn ) ) {
            $v = call_user_func( $fn );
            if ( is_string( $v ) && trim( $v ) !== '' ) {
                return $v;
            }
        }
    }
    return $default;
};
$trv_opt = function ( array $keys ) {
    foreach ( $keys as $k ) {
        $v = get_option( $k, '' );
        if ( is_string( $v ) && trim( $v ) !== '' ) {
            return trim( $v );
        }
    }
    return '';
};
$trv_page = function ( array $slugs, $fallback ) {
    foreach ( $slugs as $s ) {
        $p = get_page_by_path( $s );
        if ( $p ) {
            return get_permalink( $p );
        }
    }
    return home_url( $fallback );
};

$trv_wa    = preg_replace( '/\D+/', '', $trv_pick( array( 'travotech_wa', 'trovatech_wa', 'leshavin_wa' ), '254720737151' ) );
$trv_phone = $trv_pick( array( 'travotech_phone_display', 'trovatech_phone_display', 'leshavin_phone_display' ), '+254 720 737 151' );
$trv_email = $trv_pick( array( 'travotech_email', 'trovatech_email', 'leshavin_email' ), 'sales@travotechagencies.co.ke' );
$trv_addr  = $trv_pick( array( 'travotech_location', 'trovatech_location', 'leshavin_location' ), 'Nairobi, Kenya' );
$trv_hours = $trv_pick( array( 'travotech_hours', 'trovatech_hours', 'leshavin_hours' ), 'Mon-Fri: 8am-6pm | Sat: 8:30am-1:00pm | Sun & Holidays: closed' );

$trv_map_src  = 'https://www.google.com/maps?q=' . rawurlencode( $trv_addr ) . '&output=embed';
$trv_map_link = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $trv_addr );

$trv_shop = ( function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0 )
    ? get_permalink( wc_get_page_id( 'shop' ) )
    : home_url( '/shop/' );

$trv_about   = $trv_page( array( 'about-us', 'about' ), '/about-us/' );
$trv_contact = $trv_page( array( 'contact', 'contact-us' ), '/contact/' );
$trv_return  = $trv_page( array( 'return-and-refund-policy', 'return-policy', 'refund-policy', 'returns' ), '/return-policy/' );
$trv_terms   = $trv_page( array( 'terms-and-conditions', 'terms', 'terms-conditions' ), '/terms/' );

/* Find the real pages by template file first, then by slug text */
$trv_find = function ( array $tpls, array $needles, $fallback ) {
    $pages = get_pages( array( 'post_status' => 'publish' ) );
    foreach ( $pages as $p ) {
        if ( in_array( get_page_template_slug( $p->ID ), $tpls, true ) ) {
            return get_permalink( $p );
        }
    }
    foreach ( $needles as $n ) {
        foreach ( $pages as $p ) {
            if ( false !== strpos( $p->post_name, $n ) ) {
                return get_permalink( $p );
            }
        }
    }
    return home_url( $fallback );
};
$trv_about   = $trv_find( array( 'page-about.php' ), array( 'about' ), '/about-us/' );
$trv_contact = $trv_find( array( 'page-contact.php' ), array( 'contact' ), '/contact/' );
$trv_return  = $trv_find( array( 'page-refund.php', 'page-return.php', 'page-returns.php', 'page-return-policy.php', 'page-refund-policy.php', 'page-return-refund.php' ), array( 'refund', 'return' ), '/return-policy/' );
$trv_terms   = $trv_find( array( 'page-terms.php', 'page-terms-conditions.php' ), array( 'terms' ), '/terms/' );

$trv_logo = '';
if ( get_theme_mod( 'custom_logo' ) ) {
    $trv_logo = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
}
if ( ! $trv_logo ) {
    $trv_logo = get_template_directory_uri() . '/assets/js/images/travotechlogo.png';
}

$trv_social_urls = array(
    'facebook'  => $trv_opt( array( 'travotech_facebook', 'trovatech_facebook', 'leshavin_facebook' ) ),
    'instagram' => $trv_opt( array( 'travotech_instagram', 'trovatech_instagram', 'leshavin_instagram' ) ),
    'tiktok'    => $trv_opt( array( 'travotech_tiktok', 'trovatech_tiktok', 'leshavin_tiktok' ) ),
    'linkedin'  => $trv_opt( array( 'travotech_linkedin', 'trovatech_linkedin', 'leshavin_linkedin' ) ),
    'x'         => $trv_opt( array( 'travotech_x', 'travotech_twitter', 'trovatech_twitter', 'leshavin_twitter' ) ),
);
$trv_social_icons = array(
    'facebook'  => '<i class="fa-brands fa-facebook-f" aria-hidden="true"></i>',
    'instagram' => '<i class="fa-brands fa-instagram" aria-hidden="true"></i>',
    'tiktok'    => '<i class="fa-brands fa-tiktok" aria-hidden="true"></i>',
    'linkedin'  => '<i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>',
    'x'         => '<i class="fa-brands fa-x-twitter" aria-hidden="true"></i>',
);
$trv_social_labels = array(
    'facebook'  => 'Travotech Agencies on Facebook',
    'instagram' => 'Travotech Agencies on Instagram',
    'tiktok'    => 'Travotech Agencies on TikTok',
    'linkedin'  => 'Travotech Agencies on LinkedIn',
    'x'         => 'Travotech Agencies on X',
);

$trv_wa_icon = '<i class="fa-brands fa-whatsapp" aria-hidden="true"></i>';

$trv_quote_link = 'https://wa.me/' . $trv_wa . '?text=' . rawurlencode( 'Hello Travotech Agencies, I would like a quote for lab / hospital equipment.' );
$trv_order_link = 'https://wa.me/' . $trv_wa . '?text=' . rawurlencode( 'Hello Travotech Agencies! I would like to place an order.' );
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
<style>
:root{
  --trv-bg:#093c3c;
  --trv-bg-deep:#072f2f;
  --trv-brand:#36d0cd;
  --trv-brand-dark:#2dbebc;
  --trv-accent:#5ad8d6;
  --trv-line:rgba(255,255,255,.16);
  --trv-text:rgba(255,255,255,.84);
  --trv-text-dim:rgba(255,255,255,.66);
  --trv-font-head:'Oswald','Arial Narrow',sans-serif;
  --trv-font-body:'Inter',system-ui,-apple-system,'Segoe UI',Arial,sans-serif;
  --trv-px:48px;
}
.trv-footer{
  background:var(--trv-bg);
  font-family:var(--trv-font-body);
  font-size:1rem;
  line-height:1.6;
  border-top:4px solid var(--trv-brand);
}
.trv-footer *{box-sizing:border-box;}
.trv-foot-inner{max-width:1280px;margin:0 auto;padding:60px var(--trv-px) 44px;}
.trv-foot-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr 1.25fr;gap:44px;}
.trv-foot-col{min-width:0;}

.trv-foot-logo{display:inline-flex;align-items:center;gap:12px;flex-wrap:wrap;text-decoration:none;margin-bottom:18px;}
.trv-foot-logo-img{background:#fff;border-radius:10px;padding:6px 10px;display:flex;align-items:center;}
.trv-foot-logo-img img{height:52px;width:auto;object-fit:contain;display:block;}
.trv-foot-logo-tag{font-family:var(--trv-font-head);font-size:.85rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--trv-accent);}
.trv-foot-desc{font-size:1rem;line-height:1.75;color:var(--trv-text);margin:0 0 22px;max-width:380px;}

.trv-foot-socs{display:flex;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px;}
.trv-foot-soc{
  width:44px;height:44px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  color:#fff;border:1.5px solid var(--trv-line);text-decoration:none;
  transition:background .2s,border-color .2s,transform .2s;
}
.trv-foot-soc svg{width:20px;height:20px;display:block;}
.trv-foot-soc:hover,.trv-foot-soc:focus-visible{background:var(--trv-brand);border-color:var(--trv-brand);transform:translateY(-2px);}

.trv-foot-quote{
  display:inline-flex;align-items:center;gap:10px;
  background:var(--trv-brand);color:#fff;text-decoration:none;
  font-family:var(--trv-font-head);font-size:1rem;font-weight:600;letter-spacing:.04em;
  padding:13px 22px;border-radius:999px;transition:background .2s,transform .2s;
}
.trv-foot-quote svg{width:20px;height:20px;flex-shrink:0;}
.trv-foot-quote:hover,.trv-foot-quote:focus-visible{background:var(--trv-brand-dark);transform:translateY(-2px);color:#fff;}

.trv-foot-card{margin-top:26px;max-width:320px;background:rgba(255,255,255,.96);border-radius:10px;padding:16px 18px;box-shadow:0 10px 26px rgba(0,0,0,.2);}
.trv-foot-card-label{font-family:var(--trv-font-head);font-size:.8rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:#55665d;margin-bottom:8px;}
.trv-foot-card-main{
  border-top:2px dotted var(--trv-brand);border-bottom:2px dotted var(--trv-brand);
  padding:10px 0;text-align:center;
  font-family:var(--trv-font-head);font-weight:700;font-size:1.15rem;color:var(--trv-bg);letter-spacing:.02em;
}
.trv-foot-card-sub{font-size:.88rem;color:#55665d;text-align:center;margin-top:8px;}

.trv-foot-h{
  font-family:var(--trv-font-head);font-size:1.15rem;font-weight:700;color:#fff;
  text-transform:uppercase;letter-spacing:.06em;margin:0 0 22px;position:relative;padding-bottom:12px;
}
.trv-foot-h::after{content:'';position:absolute;left:0;bottom:0;width:34px;height:3px;background:var(--trv-brand);}

.trv-foot-links{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:6px;}
.trv-foot-links a{color:var(--trv-text);text-decoration:none;font-size:1rem;display:inline-block;padding:6px 0;transition:color .18s,padding-left .18s;}
.trv-foot-links a:hover,.trv-foot-links a:focus-visible{color:var(--trv-accent);padding-left:5px;}

.trv-foot-contact{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:16px;}
.trv-foot-contact li{display:flex;align-items:flex-start;gap:12px;font-size:1rem;color:var(--trv-text);line-height:1.55;}
.trv-foot-contact svg{width:20px;height:20px;flex-shrink:0;margin-top:3px;color:var(--trv-accent);}
.trv-foot-contact a{color:inherit;text-decoration:none;word-break:break-word;transition:color .18s;}
.trv-foot-contact a:hover,.trv-foot-contact a:focus-visible{color:var(--trv-accent);}

.trv-foot-map-wrap{margin-top:20px;}
.trv-foot-map{position:relative;width:100%;height:150px;border-radius:10px;overflow:hidden;border:1.5px solid var(--trv-line);background:var(--trv-bg-deep);}
.trv-foot-map iframe{width:100%;height:100%;border:0;display:block;filter:grayscale(.15) contrast(1.02);}
.trv-foot-map-overlay{position:absolute;inset:0;background:transparent;cursor:pointer;}
.trv-foot-map-link{
  display:inline-flex;align-items:center;gap:8px;margin-top:12px;
  font-family:var(--trv-font-head);font-size:.95rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;
  color:var(--trv-accent);text-decoration:none;transition:color .18s,gap .18s;
}
.trv-foot-map-link svg{width:15px;height:15px;flex-shrink:0;}
.trv-foot-map-link:hover,.trv-foot-map-link:focus-visible{color:#fff;gap:12px;}

.trv-foot-bottom{border-top:1px solid var(--trv-line);background:var(--trv-bg-deep);}
.trv-foot-bottom-inner{max-width:1280px;margin:0 auto;padding:20px var(--trv-px);display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:14px;}
.trv-foot-copy{font-size:.92rem;color:var(--trv-text-dim);justify-self:start;}
.trv-foot-credit{font-size:.92rem;color:var(--trv-text-dim);justify-self:center;text-align:center;}
.trv-foot-credit a{color:#fff;text-decoration:none;font-weight:700;transition:color .18s;}
.trv-foot-credit a:hover,.trv-foot-credit a:focus-visible{color:var(--trv-accent);}
.trv-foot-legal{justify-self:end;display:flex;gap:22px;flex-wrap:wrap;}
.trv-foot-legal a{font-size:.92rem;color:var(--trv-text);text-decoration:none;padding:4px 0;transition:color .18s;}
.trv-foot-legal a:hover,.trv-foot-legal a:focus-visible{color:var(--trv-accent);}

.trv-fab-wa{
  position:fixed;right:22px;bottom:22px;z-index:900;
  width:58px;height:58px;border-radius:50%;background:#25D366;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 6px 20px rgba(0,0,0,.28);text-decoration:none;color:#fff;
  transition:transform .2s,box-shadow .2s;
}
.trv-fab-wa:hover,.trv-fab-wa:focus-visible{transform:translateY(-3px);box-shadow:0 10px 26px rgba(0,0,0,.34);}
.trv-fab-wa svg{width:28px;height:28px;}
.trv-fab-tip{
  position:absolute;right:calc(100% + 12px);top:50%;transform:translateY(-50%) translateX(6px);
  background:var(--trv-bg);color:#fff;font-family:var(--trv-font-body);font-size:.9rem;font-weight:600;white-space:nowrap;
  padding:8px 14px;border-radius:6px;opacity:0;visibility:hidden;pointer-events:none;
  transition:opacity .2s,transform .2s,visibility .2s;
}
.trv-fab-wa:hover .trv-fab-tip,.trv-fab-wa:focus-visible .trv-fab-tip{opacity:1;visibility:visible;transform:translateY(-50%) translateX(0);}

@media(max-width:1024px){
  :root{--trv-px:32px;}
  .trv-foot-grid{grid-template-columns:1fr 1fr;row-gap:40px;}
  .trv-foot-col.trv-foot-brand{grid-column:1 / -1;}
  .trv-foot-desc{max-width:none;}
}
@media(max-width:900px){
  .trv-foot-bottom-inner{grid-template-columns:1fr;justify-items:center;text-align:center;gap:8px;}
  .trv-foot-copy,.trv-foot-legal{justify-self:center;}
  .trv-foot-legal{justify-content:center;}
}
@media(max-width:600px){
  :root{--trv-px:20px;}
  .trv-foot-inner{padding:40px var(--trv-px) 28px;}
  .trv-foot-grid{grid-template-columns:1fr;row-gap:34px;}
  .trv-foot-logo-img img{height:48px;}
  .trv-foot-card{max-width:none;}
  .trv-foot-map{height:200px;}
  .trv-foot-links a{padding:8px 0;}
  .trv-foot-copy,.trv-foot-credit,.trv-foot-legal a{font-size:.9rem;}
  .trv-foot-bottom{padding-bottom:44px;}
  .trv-fab-wa{width:54px;height:54px;right:16px;bottom:16px;}
  .trv-fab-wa svg{width:26px;height:26px;}
  .trv-fab-tip{display:none;}
}
@media(prefers-reduced-motion:reduce){
  .trv-footer *,.trv-fab-wa{transition:none !important;}
}

/* ---- Cleanup: tighter, cleaner footer ---- */
.trv-foot-inner{padding-top:44px;padding-bottom:20px;}
.trv-foot-grid{grid-template-columns:1.4fr .9fr 1fr 1.4fr;gap:32px 40px;}
.trv-foot-logo{margin-bottom:12px;}
.trv-foot-desc{font-size:.95rem;line-height:1.65;margin:0 0 16px;}
.trv-foot-socs{margin-bottom:16px;gap:10px;}
.trv-foot-soc{width:40px;height:40px;}
.trv-foot-h{font-size:1rem;margin:0 0 14px;padding-bottom:10px;}
.trv-foot-links{gap:0;}
.trv-foot-links a{padding:5px 0;font-size:.95rem;}
.trv-foot-contact{gap:12px;}
.trv-foot-contact li{min-width:0;font-size:.95rem;}
.trv-foot-contact a,.trv-foot-contact span{min-width:0;word-break:normal;overflow-wrap:anywhere;}
.trv-foot-bottom{background:transparent;border-top:1px solid var(--trv-line);}
.trv-foot-bottom-inner{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:8px 24px;padding-top:14px;padding-bottom:14px;}
.trv-foot-copy,.trv-foot-credit,.trv-foot-legal a{font-size:.85rem;}
.trv-foot-legal{gap:18px;}
@media(max-width:900px){.trv-foot-bottom-inner{flex-direction:column;justify-content:center;text-align:center;gap:6px;}}
@media(max-width:600px){.trv-foot-inner{padding-top:32px;}.trv-foot-grid{gap:26px;}}

/* ---- Social icons: real brand colors ---- */
.trv-foot-soc{border:0 !important;color:#fff !important;}
.trv-soc-facebook{background:#39d1ce !important;}
.trv-soc-instagram{background:linear-gradient(45deg,#feda75 0%,#fa7e1e 25%,#d62976 50%,#962fbf 75%,#4ed6d3 100%) !important;}
.trv-soc-linkedin{background:#2dbebc !important;}
.trv-soc-x{background:#000 !important;box-shadow:0 0 0 1.5px rgba(255,255,255,.35);}
.trv-soc-tiktok{background:#000 !important;box-shadow:2px 2px 0 #fe2c55,-2px -2px 0 #5ae8e5;}
.trv-foot-soc:hover,.trv-foot-soc:focus-visible{filter:brightness(1.12);transform:translateY(-2px);}

/* ---- Font Awesome icons ---- */
.trv-foot-contact i{flex:0 0 22px;width:22px;margin-top:4px;text-align:center;font-size:1rem;line-height:1;color:var(--trv-accent);}
.trv-foot-soc i{font-size:1.15rem;line-height:1;}
.trv-fab-wa i{font-size:1.9rem;line-height:1;}

/* ---- Real brand colors for Font Awesome icons ---- */
.trv-foot-soc.trv-soc-facebook,
.trv-foot-soc.trv-soc-instagram,
.trv-foot-soc.trv-soc-tiktok,
.trv-foot-soc.trv-soc-linkedin,
.trv-foot-soc.trv-soc-x{background:#fff !important;border:0 !important;box-shadow:none !important;}
.trv-foot-soc.trv-soc-facebook{color:#39d1ce !important;}
.trv-foot-soc.trv-soc-linkedin{color:#2dbebc !important;}
.trv-foot-soc.trv-soc-x{color:#000 !important;}
.trv-foot-soc.trv-soc-tiktok{color:#000 !important;}
.trv-foot-soc.trv-soc-tiktok i{text-shadow:1.5px 1.5px 0 #FE2C55,-1.5px -1.5px 0 #5ae8e5;}
.trv-foot-soc.trv-soc-instagram{color:#D62976 !important;}
.trv-foot-soc.trv-soc-instagram i{background:linear-gradient(45deg,#FEDA75 0%,#FA7E1E 30%,#D62976 55%,#962FBF 80%,#4ed6d3 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;}
.trv-foot-soc:hover,.trv-foot-soc:focus-visible{background:#e6fbfb !important;filter:none !important;transform:translateY(-2px);}

/* Contact icons */
.trv-foot-contact li:nth-child(1) i{color:#57d8d6;}
.trv-foot-contact li:nth-child(2) i{color:#FF6B5E;}
.trv-foot-contact li:nth-child(3) i{color:#FF5A4D;}
.trv-foot-contact li:nth-child(4) i{color:#FFC73A;}

/* ---- Responsive fix (must stay last) ---- */
@media (max-width:1024px){
  .trv-foot-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:28px 24px;}
  .trv-foot-col.trv-foot-brand{grid-column:1 / -1;}
}
@media (max-width:600px){
  .trv-foot-inner{padding-left:20px;padding-right:20px;}
  .trv-foot-grid{grid-template-columns:minmax(0,1fr);gap:28px;}
  .trv-foot-col.trv-foot-brand{grid-column:auto;}
  .trv-foot-h{font-size:1.05rem;}
  .trv-foot-links a{padding:7px 0;}
  .trv-foot-contact a,.trv-foot-contact span{overflow-wrap:break-word;word-break:normal;}
  .trv-foot-bottom-inner{display:flex;flex-direction:column;align-items:center;text-align:center;gap:10px;padding-left:20px;padding-right:20px;}
  .trv-foot-copy{order:1;}
  .trv-foot-legal{order:2;justify-content:center;}
  .trv-foot-credit{order:3;}
  .trv-foot-bottom{padding-bottom:76px;}
}

/* ---- Responsive fix (must stay last) ---- */
@media (max-width:1024px){
  .trv-foot-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:28px 24px;}
  .trv-foot-col.trv-foot-brand{grid-column:1 / -1;}
}
@media (max-width:600px){
  .trv-foot-inner{padding-left:20px;padding-right:20px;}
  .trv-foot-grid{grid-template-columns:minmax(0,1fr);gap:28px;}
  .trv-foot-col.trv-foot-brand{grid-column:auto;}
  .trv-foot-h{font-size:1.05rem;}
  .trv-foot-links a{padding:7px 0;}
  .trv-foot-contact a,.trv-foot-contact span{overflow-wrap:break-word;word-break:normal;}
  .trv-foot-bottom-inner{display:flex;flex-direction:column;align-items:center;text-align:center;gap:10px;padding-left:20px;padding-right:20px;}
  .trv-foot-copy{order:1;}
  .trv-foot-legal{order:2;justify-content:center;}
  .trv-foot-credit{order:3;}
  .trv-foot-bottom{padding-bottom:76px;}
}

/* ---- Mobile final: no duplicates, tight lines, no bottom gap ---- */
@media (max-width:900px){
  .trv-footer .trv-foot-legal{display:none !important;}
  .trv-footer .trv-foot-links{gap:0 !important;}
  .trv-footer .trv-foot-links li{margin:0 !important;}
  .trv-footer .trv-foot-links a{padding:2px 0 !important;line-height:1.35 !important;}
  .trv-footer .trv-foot-contact{gap:8px !important;}
  .trv-footer .trv-foot-h{margin:0 0 6px !important;padding-bottom:8px !important;}
  .trv-footer .trv-foot-grid{gap:18px !important;}
  .trv-footer .trv-foot-inner{padding-top:24px !important;padding-bottom:4px !important;}
  .trv-footer .trv-foot-bottom{padding-bottom:0 !important;margin:0 !important;}
  .trv-footer .trv-foot-bottom-inner{gap:2px !important;padding-top:10px !important;padding-bottom:10px !important;}
  .trv-footer .trv-foot-copy,.trv-footer .trv-foot-credit{line-height:1.4 !important;}
}

/* ---- Footer v2 ---- */
@media (min-width:901px){
    .trv-footer .trv-foot-bottom-inner{display:flex !important;flex-wrap:nowrap !important;align-items:center;justify-content:space-between;gap:24px;padding-right:90px;}
    .trv-footer .trv-foot-copy{order:1;}
    .trv-footer .trv-foot-legal{order:2;display:flex !important;gap:22px;}
    .trv-footer .trv-foot-credit{order:3;text-align:right;}
}
@media (max-width:900px){
    .trv-footer .trv-foot-bottom{padding-bottom:56px !important;}
    .trv-footer .trv-foot-bottom-inner{gap:0 !important;}
    .trv-footer .trv-foot-copy{font-size:.75rem !important;line-height:1.5 !important;margin:0 0 10px !important;}
    .trv-footer .trv-foot-credit{display:block;font-size:.7rem !important;line-height:1.5 !important;margin:0 !important;padding-top:10px;border-top:1px solid var(--trv-line);width:100%;max-width:300px;}
    .trv-footer .trv-foot-credit a{font-size:.7rem !important;font-weight:600;}
}

/* ---- Footer v3 ---- */
/* Desktop only: no legal links in the bottom bar, copyright left, credit right, one line each */
@media (min-width:901px){
    .trv-footer .trv-foot-legal{display:none !important;}
    .trv-footer .trv-foot-bottom-inner{display:flex !important;flex-wrap:nowrap !important;align-items:center;justify-content:space-between;gap:24px;padding-right:100px;}
    .trv-footer .trv-foot-copy,
    .trv-footer .trv-foot-credit{white-space:nowrap;margin:0;}
    .trv-footer .trv-foot-credit{text-align:right;}
}

/* ---- Footer v4 ---- */
/* Phone and tablet only: remove the empty gap under the credit */
@media (max-width:900px){
    .trv-footer .trv-foot-bottom{padding-bottom:0 !important;margin-bottom:0 !important;}
    .trv-footer .trv-foot-bottom-inner{padding-bottom:12px !important;}
    .trv-footer .trv-foot-credit{padding-bottom:0 !important;margin-bottom:0 !important;}
    body{margin-bottom:0 !important;padding-bottom:0 !important;}
}
</style>

<footer class="trv-footer" role="contentinfo">
  <div class="trv-foot-inner">
    <div class="trv-foot-grid">

      <div class="trv-foot-col trv-foot-brand">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="trv-foot-logo">
          <span class="trv-foot-logo-img"><img src="<?php echo esc_url( $trv_logo ); ?>" alt="Travotech Agencies Limited — laboratory and hospital supplies in Nairobi, Kenya" width="160" height="52" loading="lazy"></span>
          <span class="trv-foot-logo-tag">The Home of Laboratory &amp; Hospital Supplies</span>
        </a>
        <p class="trv-foot-desc">Travotech Agencies Limited is a trusted Nairobi supplier of affordable, professional laboratory and hospital equipment: hematology analyzers, hospital beds, patient monitors and rapid tests at pocket-friendly prices, delivered to Thika, Nairobi and across Kenya.</p>

        <div class="trv-foot-socs">
          <?php
          foreach ( $trv_social_urls as $trv_net => $trv_url ) :
            $trv_has = ( $trv_url !== '' );
          ?>
            <a href="<?php echo $trv_has ? esc_url( $trv_url ) : '#'; ?>" class="trv-foot-soc trv-soc-<?php echo esc_attr( $trv_net ); ?>"<?php echo $trv_has ? ' target="_blank" rel="noopener noreferrer"' : ''; ?> aria-label="<?php echo esc_attr( $trv_social_labels[ $trv_net ] ); ?>">
              <?php echo $trv_social_icons[ $trv_net ]; ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="trv-foot-col">
        <div class="trv-foot-h">Quick Links</div>
        <ul class="trv-foot-links">
          <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
          <li><a href="<?php echo esc_url( $trv_shop ); ?>">Shop Equipment</a></li>
          <li><a href="<?php echo esc_url( $trv_about ); ?>">About Us</a></li>
          <li><a href="<?php echo esc_url( $trv_return ); ?>">Return &amp; Refund Policy</a></li>
          <li><a href="<?php echo esc_url( $trv_contact ); ?>">Contact Us</a></li>
          <li><a href="<?php echo esc_url( $trv_terms ); ?>">Terms &amp; Conditions</a></li>
        </ul>
      </div>

      <div class="trv-foot-col">
        <div class="trv-foot-h">Shop by Category</div>
        <ul class="trv-foot-links">
          <?php
          $trv_cats = array();
          if ( taxonomy_exists( 'product_cat' ) ) {
            $trv_cats = get_terms( array(
              'taxonomy'   => 'product_cat',
              'hide_empty' => true,
              'parent'     => 0,
              'number'     => 6,
              'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
            ) );
          }
          if ( $trv_cats && ! is_wp_error( $trv_cats ) && count( $trv_cats ) ) :
            foreach ( $trv_cats as $trv_c ) :
              $trv_link = get_term_link( $trv_c );
              if ( is_wp_error( $trv_link ) ) { continue; }
          ?>
            <li><a href="<?php echo esc_url( $trv_link ); ?>"><?php echo esc_html( $trv_c->name ); ?></a></li>
          <?php
            endforeach;
          else :
            foreach ( array( 'Laboratory Equipment', 'Hematology Analyzers', 'Hospital Beds', 'Patient Monitors', 'Rapid Test Kits', 'Medical Devices' ) as $trv_fn ) :
          ?>
            <li><a href="<?php echo esc_url( $trv_shop ); ?>"><?php echo esc_html( $trv_fn ); ?></a></li>
          <?php
            endforeach;
          endif;
          ?>
        </ul>
      </div>

      <div class="trv-foot-col">
        <div class="trv-foot-h">Contact Us</div>
        <ul class="trv-foot-contact">
          <li>
            <i class="fa-solid fa-phone" aria-hidden="true"></i>
            <a href="tel:+<?php echo esc_attr( $trv_wa ); ?>"><?php echo esc_html( $trv_phone ); ?></a>
          </li>
          <li>
            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
            <a href="mailto:<?php echo esc_attr( $trv_email ); ?>"><?php echo esc_html( $trv_email ); ?></a>
          </li>
          <li>
            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
            <span><?php echo esc_html( $trv_addr ); ?></span>
          </li>
          <li>
            <i class="fa-solid fa-clock" aria-hidden="true"></i>
            <span><?php echo esc_html( $trv_hours ); ?></span>
          </li>
        </ul>
      </div>

    </div>
  </div>

  <div class="trv-foot-bottom">
    <div class="trv-foot-bottom-inner">
      <div class="trv-foot-copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Travotech Agencies Limited. All rights reserved.</div>
      <div class="trv-foot-credit">
        Designed and Developed By <a href="https://devnovatech.co.ke/" target="_blank" rel="noopener noreferrer">DevNovaTech Software Developers</a>
      </div>
      <nav class="trv-foot-legal" aria-label="Legal">
        <a href="<?php echo esc_url( $trv_terms ); ?>">Terms &amp; Conditions</a>
        <a href="<?php echo esc_url( $trv_return ); ?>">Return &amp; Refund Policy</a>
      </nav>
    </div>
  </div>
</footer>

<a href="<?php echo esc_url( $trv_order_link ); ?>" class="trv-fab-wa" target="_blank" rel="noopener noreferrer" aria-label="Chat with Travotech Agencies on WhatsApp">
  <span class="trv-fab-tip">Chat on WhatsApp</span>
  <?php echo $trv_wa_icon; ?>
</a>

<?php wp_footer(); ?>
</body>
</html>