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
    'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>',
    'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>',
    'tiktok'    => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>',
    'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
    'x'         => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
);
$trv_social_labels = array(
    'facebook'  => 'Travotech Agencies on Facebook',
    'instagram' => 'Travotech Agencies on Instagram',
    'tiktok'    => 'Travotech Agencies on TikTok',
    'linkedin'  => 'Travotech Agencies on LinkedIn',
    'x'         => 'Travotech Agencies on X',
);

$trv_wa_icon = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';

$trv_quote_link = 'https://wa.me/' . $trv_wa . '?text=' . rawurlencode( 'Hello Travotech Agencies, I would like a quote for lab / hospital equipment.' );
$trv_order_link = 'https://wa.me/' . $trv_wa . '?text=' . rawurlencode( 'Hello Travotech Agencies! I would like to place an order.' );
?>

<style>
:root{
  --trv-bg:#0c3a27;
  --trv-bg-deep:#092d1f;
  --trv-brand:#2eaf6e;
  --trv-brand-dark:#238a56;
  --trv-accent:#5fd39a;
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
.trv-soc-facebook{background:#1877F2 !important;}
.trv-soc-instagram{background:linear-gradient(45deg,#feda75 0%,#fa7e1e 25%,#d62976 50%,#962fbf 75%,#4f5bd5 100%) !important;}
.trv-soc-linkedin{background:#0A66C2 !important;}
.trv-soc-x{background:#000 !important;box-shadow:0 0 0 1.5px rgba(255,255,255,.35);}
.trv-soc-tiktok{background:#000 !important;box-shadow:2px 2px 0 #fe2c55,-2px -2px 0 #25f4ee;}
.trv-foot-soc:hover,.trv-foot-soc:focus-visible{filter:brightness(1.12);transform:translateY(-2px);}
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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
            <a href="tel:+<?php echo esc_attr( $trv_wa ); ?>"><?php echo esc_html( $trv_phone ); ?></a>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <a href="mailto:<?php echo esc_attr( $trv_email ); ?>"><?php echo esc_html( $trv_email ); ?></a>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span><?php echo esc_html( $trv_addr ); ?></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
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