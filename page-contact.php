<?php
/*
Template Name: Contact Us
*/

/* ---- Edit these if anything changes ---- */
$ct_to = get_option( 'admin_email' ); /* where the form messages are sent */
$ct_phone1 = '0720737151';
$ct_phone2 = '0729080053';
$ct_email1 = 'travogencies@yahoo.com';
$ct_email2 = 'sales@travotechagencies.co.ke';
$ct_social = array(
    array( 'fa-brands fa-facebook-f', 'Facebook', '' ),
    array( 'fa-brands fa-x-twitter', 'X', '' ),
    array( 'fa-brands fa-linkedin-in', 'LinkedIn', '' ),
    array( 'fa-brands fa-youtube', 'YouTube', '' ),
    array( 'fa-brands fa-tiktok', 'TikTok', '' ),
);
$ct_branches = array(
    array( 'Head Office - Kahawa Sukari', 'Kahawa Sukari, Bungoma Road, Bungoma Close - Gate No.4', '0720737151', 'Kahawa Sukari, Bungoma Road, Bungoma Close, Nairobi, Kenya' ),
    array( 'Travotech Nairobi', 'Tom Mboya Street - Nyambene House, 1st floor, meters away from Afya Centre', '0729080053', 'Nyambene House, Tom Mboya Street, Nairobi, Kenya' ),
    array( 'Travotech Meru', 'Tom Mboya Street, Meru Town, directly opposite Post Bank Meru / YETU Sacco', '0725282453', 'Tom Mboya Street, Meru Town, Kenya' ),
);
$img = esc_url( get_template_directory_uri() ) . '/assets/js/images/';
$ct_bg  = 'contact.png';  /* hero background */
$ct_ppl = 'whyus.png';    /* the people */
$page_url = get_permalink();

/* ---- Handle the form ---- */
$ct_err = '';
$ct_val = array( 'name' => '', 'email' => '', 'phone' => '', 'message' => '' );
if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['ct_submit'] ) ) {
    if ( ! isset( $_POST['ct_nonce'] ) || ! wp_verify_nonce( $_POST['ct_nonce'], 'travotech_contact' ) ) {
        $ct_err = 'Your session expired. Please refresh the page and try again.';
    } elseif ( ! empty( $_POST['ct_website'] ) ) {
        wp_safe_redirect( $page_url ); exit;
    } else {
        $ct_val['name']    = sanitize_text_field( wp_unslash( $_POST['ct_name'] ?? '' ) );
        $ct_val['email']   = sanitize_email( wp_unslash( $_POST['ct_email'] ?? '' ) );
        $ct_val['phone']   = sanitize_text_field( wp_unslash( $_POST['ct_phone'] ?? '' ) );
        $ct_val['message'] = sanitize_textarea_field( wp_unslash( $_POST['ct_message'] ?? '' ) );
        if ( '' === $ct_val['name'] || '' === $ct_val['message'] ) {
            $ct_err = 'Please enter your name and message.';
        } elseif ( ! is_email( $ct_val['email'] ) ) {
            $ct_err = 'Please enter a valid email address.';
        } else {
            $body = "Name: {$ct_val['name']}\nEmail: {$ct_val['email']}\nPhone: {$ct_val['phone']}\n\nMessage:\n{$ct_val['message']}\n";
            $sent = wp_mail( $ct_to, '[Website] New message from ' . $ct_val['name'], $body, array( 'Reply-To: ' . $ct_val['name'] . ' <' . $ct_val['email'] . '>' ) );
            if ( $sent ) { wp_safe_redirect( add_query_arg( 'sent', '1', $page_url ) . '#send' ); exit; }
            $ct_err = 'Sorry, we could not send your message. Please call or WhatsApp us instead.';
        }
    }
}

if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) ) {
    add_filter( 'pre_get_document_title', function () {
        return 'Contact Travotech Agencies | Medical & Laboratory Equipment Nairobi';
    } );
    add_action( 'wp_head', function () {
        echo '<meta name="description" content="' . esc_attr( 'Contact Travotech Agencies in Nairobi, Kenya for laboratory analyzers, hospital beds, patient monitors, reagents and medical supplies. Call, WhatsApp, email or visit our Nairobi, Kahawa Sukari and Meru offices.' ) . '">' . "\n";
    }, 1 );
}
get_header();
?>
<script type="application/ld+json">
<?php echo wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'LocalBusiness', 'name' => 'Travotech Agencies Limited', 'url' => home_url( '/' ), 'telephone' => '+254' . substr( $ct_phone2, 1 ), 'email' => $ct_email2, 'address' => array( '@type' => 'PostalAddress', 'streetAddress' => 'Nyambene House, Tom Mboya Street', 'addressLocality' => 'Nairobi', 'addressCountry' => 'KE' ) ), JSON_UNESCAPED_SLASHES ); ?>
</script>

<style>
.ct{--ct-g:var(--th-g,#22adb0);--ct-gd:var(--th-gd,#22adb0);--ct-dk:var(--th-dk,#093c3c);--ct-red:var(--th-red,#d32f2f);--ct-tint:#e6fafa;--ct-line:#cdf1f0;
font-family:'Inter',system-ui,sans-serif;color:#1d4847;overflow-x:hidden;}
.ct *,.ct *::before,.ct *::after{box-sizing:border-box;}
.ct h1,.ct h2,.ct h3{font-family:var(--th-fh,'Oswald',sans-serif);color:var(--ct-dk);margin:0;line-height:1.2;letter-spacing:.01em;}
.ct p{margin:0 0 10px;line-height:1.65;font-size:.95rem;}
.ct-wrap{width:100%;max-width:1200px;margin:0 auto;padding:0 5%;}

/* Top: background band + people + overlapping cards */
.ct-top{position:relative;background:#f2fcfc;}
.ct-band{position:relative;background:var(--ct-dk);color:#fff;overflow:hidden;}
.ct-band-bg{position:absolute;inset:0;background:var(--ct-dk);isolation:isolate;}
.ct-band-bg img{width:100%;height:100%;object-fit:cover;object-position:center;display:block;mix-blend-mode:luminosity;opacity:.75;}
.ct-band-bg::after{content:"";position:absolute;inset:0;background:rgba(0,0,0,.4);}
.ct-band-in{position:relative;z-index:2;max-width:1200px;margin:0 auto;padding:28px 5% 96px;}
.ct-txt{max-width:600px;}
.ct .ct-band h1{color:#fff;font-size:clamp(2.4rem,5.6vw,4rem);line-height:1.05;margin-bottom:8px;}
.ct .ct-band h1 small{display:block;font-size:clamp(.95rem,1.7vw,1.1rem);font-weight:500;line-height:1.35;margin-top:8px;color:#90efee;}
.ct-sub{font-family:var(--th-fh,'Oswald',sans-serif);font-size:clamp(1.15rem,2.3vw,1.6rem);color:#fff;margin:0 0 6px !important;}
.ct .ct-band p{color:rgba(255,255,255,.95);}
.ct-band-line{display:block;width:80px;height:3px;background:#fff;border-radius:2px;margin-top:10px;}
.ct-people-m{display:none;}
.ct-people-d{position:absolute;top:0;bottom:0;right:max(0px,calc((100% - 1200px)/2));width:min(46%,580px);display:flex;align-items:flex-end;justify-content:flex-end;pointer-events:none;z-index:1;}
.ct-people-d img{height:100%;width:auto;max-width:100%;object-fit:contain;object-position:bottom right;display:block;}

.ct-cards-wrap{position:relative;z-index:3;max-width:1200px;margin:-66px auto 0;padding:0 5% 26px;}
.ct-cards{display:grid;grid-template-columns:1.1fr 1fr;max-width:720px;background:#fff;color:#1d4847;border-radius:16px;box-shadow:0 14px 34px rgba(9,60,60,.22);overflow:hidden;}
.ct-form-box{padding:20px 22px;}
.ct-info-box{padding:20px 22px;background:var(--ct-tint);color:#1d4847;}
.ct-title{display:flex;align-items:center;gap:12px;margin-bottom:12px;}
.ct-title i{width:40px;height:40px;border-radius:50%;background:var(--ct-g);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.ct .ct-title h2{font-size:1.25rem;}
.ct-field{position:relative;margin-bottom:8px;}
.ct-field i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--ct-g);font-size:.9rem;}
.ct-field.ct-ta i{top:16px;transform:none;}
.ct-field input,.ct-field textarea{width:100%;border:1px solid var(--ct-line);border-radius:6px;background:#fff;padding:9px 12px 9px 38px;font:inherit;font-size:.9rem;color:#1d4847;}
.ct-field textarea{min-height:70px;resize:vertical;}
.ct-field input:focus,.ct-field textarea:focus{outline:2px solid var(--ct-g);outline-offset:0;border-color:var(--ct-g);}
.ct-hp{position:absolute !important;left:-9999px;width:1px;height:1px;overflow:hidden;}
.ct-send{width:100%;display:flex;align-items:center;justify-content:center;gap:8px;border:0;border-radius:50px;background:var(--ct-g);color:#fff;font-weight:700;font-size:.92rem;padding:11px;cursor:pointer;transition:background .2s;}
.ct-send:hover{background:var(--ct-gd);}
.ct-note{border-radius:6px;padding:9px 12px;font-size:.86rem;margin-bottom:10px;}
.ct-ok{background:#dffafa;border:1px solid #87e9e7;color:#0d5a59;}
.ct-err{background:#fdecea;border:1px solid #f1a9a3;color:#8a1c14;}

.ct-det{display:flex;gap:12px;align-items:flex-start;padding:7px 0;}
.ct-det>i{font-size:1.1rem;color:var(--ct-g);width:22px;text-align:center;margin-top:3px;flex-shrink:0;}
.ct-det b{display:block;font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--ct-dk);font-size:.98rem;}
.ct .ct-det span,.ct .ct-det a{display:block;font-size:.88rem;line-height:1.5;text-decoration:none;word-break:break-word;color:#1d4847;}
.ct .ct-det a:hover{color:var(--ct-gd);text-decoration:underline;}
.ct-follow{border-top:1px solid var(--ct-line);margin-top:6px;padding-top:10px;}
.ct-follow b{font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--ct-dk);display:block;margin-bottom:8px;}
.ct-soc{display:flex;gap:8px;flex-wrap:wrap;}
.ct .ct-soc a{width:34px;height:34px;border-radius:50%;background:var(--ct-g);color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:.85rem;transition:background .2s;}
.ct .ct-soc a:hover{background:var(--ct-red);}

/* Lower area: map left, call-to-action right, then offices */
.ct-lower{display:grid;grid-template-columns:1.15fr 1fr;grid-template-areas:"map cta" "off off";gap:20px;padding:6px 0 34px;}
.ct-map{grid-area:map;position:relative;border-radius:12px;overflow:hidden;border:1px solid var(--ct-line);min-height:200px;}
.ct-map iframe{position:absolute;inset:0;width:100%;height:100%;border:0;}
.ct-map-tag{position:absolute;left:12px;top:12px;z-index:2;background:#fff;border-radius:8px;padding:9px 14px;box-shadow:0 4px 14px rgba(0,0,0,.2);max-width:210px;}
.ct-map-tag b{display:block;font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--ct-dk);}
.ct-map-tag span{display:block;font-size:.8rem;line-height:1.4;color:#1d4847;}
.ct .ct-map-tag a{font-size:.8rem;font-weight:600;color:var(--ct-gd);}
.ct-cta{grid-area:cta;background:var(--ct-dk);color:#fff;border-radius:12px;padding:22px 26px;display:flex;align-items:center;gap:20px;}
.ct-cta>i{font-size:2.6rem;flex-shrink:0;padding-right:20px;border-right:1px solid rgba(255,255,255,.35);}
.ct .ct-cta h2{color:#fff;font-size:clamp(1.25rem,2.2vw,1.6rem);margin-bottom:6px;}
.ct .ct-cta p{color:rgba(255,255,255,.92);font-size:.9rem;margin-bottom:12px;}
.ct .ct-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:50px;font-weight:700;font-size:.9rem;text-decoration:none;background:#fff;color:var(--ct-dk);}
.ct .ct-btn:hover{background:var(--ct-tint);}
.ct-off{grid-area:off;padding-top:14px;}
.ct .ct-h2{text-align:center;font-size:clamp(1.5rem,3vw,2.1rem);margin-bottom:20px;display:flex;align-items:center;justify-content:center;gap:14px;}
.ct .ct-h2::before,.ct .ct-h2::after{content:"";height:3px;width:clamp(26px,7vw,80px);background:var(--ct-g);border-radius:2px;}
.ct-offs{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.ct-o{border:1px solid var(--ct-line);border-radius:12px;padding:20px;background:#fff;box-shadow:0 6px 18px rgba(9,60,60,.06);}
.ct-o>i{width:46px;height:46px;border-radius:50%;background:var(--ct-tint);color:var(--ct-g);display:flex;align-items:center;justify-content:center;font-size:1.2rem;margin-bottom:10px;}
.ct .ct-o h3{font-size:1.15rem;margin-bottom:6px;}
.ct-o p{font-size:.88rem;margin-bottom:6px;color:#1d4847;}
.ct .ct-o a.ct-ph{font-weight:600;text-decoration:none;color:var(--ct-dk);}
.ct .ct-o a.ct-mp{display:inline-flex;gap:6px;align-items:center;margin-top:6px;font-size:.85rem;font-weight:700;color:var(--ct-red);text-decoration:none;}

/* Tablet and phone: text on the hero, people under it, then cards, map last */
@media (max-width:1000px){
.ct-people-d{display:none;}
.ct-band-bg::after{background:rgba(9,60,60,.78);}
.ct-band-in{padding:24px 5% 0;}
.ct-people-m{display:flex;justify-content:center;align-items:flex-end;height:clamp(180px,42vw,280px);margin-top:12px;}
.ct-people-m img{height:100%;width:auto;max-width:100%;object-fit:contain;object-position:bottom center;display:block;}
.ct-cards-wrap{margin-top:-24px;}
.ct-cards{max-width:100%;}
.ct-lower{grid-template-columns:1fr;grid-template-areas:"cta" "off" "map";}
.ct-map{min-height:290px;}
.ct-offs{grid-template-columns:repeat(2,1fr);}
}
@media (max-width:700px){
.ct-cards{grid-template-columns:1fr;}
.ct-offs{grid-template-columns:1fr;}
.ct-form-box,.ct-info-box{padding:18px;}
.ct-cta{flex-direction:column;text-align:center;}
.ct-cta>i{border-right:0;padding-right:0;}
}

/* ---- Hero fix v2 ---- */
/* One hero: contact.png covers the whole top area, behind the cards and the people */
.ct-top{background:var(--ct-dk);overflow:hidden;}
.ct-band{position:static;overflow:visible;background:none;}
.ct-band-in{padding:30px 5% 24px;}
.ct-cards-wrap{margin:0 auto;padding:0 5% 40px;}
.ct-people-d{top:0;bottom:0;width:min(46%,580px);z-index:1;}
.ct-cards-wrap{z-index:3;}
@media (max-width:1000px){
    .ct-band-in{padding:24px 5% 0;}
    .ct-cards-wrap{margin:16px auto 0;padding-bottom:28px;}
}

/* ---- Hero fix v3 ---- */
/* Desktop keeps v2. Phone and tablet go back to the earlier layout, with a bigger people image */
@media (max-width:1000px){
    .ct-top{background:#f2fcfc;overflow:visible;}
    .ct-band{position:relative;overflow:hidden;background:var(--ct-dk);}
    .ct-band-in{padding:24px 5% 0;}
    .ct-people-m{height:clamp(250px,64vw,400px);margin-top:10px;}
    .ct-cards-wrap{margin:-24px auto 0;padding:0 5% 26px;}
}

/* ---- Hero fix v4 ---- */
/* Desktop only: bigger people image, anchored to the bottom right */
@media (min-width:1001px){
    .ct-people-d{width:min(52%,680px);}
    .ct-people-d img{transform:scale(1.2);transform-origin:bottom right;}
}

/* ---- Hero fix v5 ---- */
/* Desktop only: narrower form card, people pushed to the right so both faces show */
@media (min-width:1001px){
    .ct-cards{max-width:600px;grid-template-columns:1.05fr 1fr;}
    .ct-form-box,.ct-info-box{padding:18px 18px;}
    .ct-people-d{right:0;width:min(55%,720px);}
    .ct-people-d img{transform:translateX(7%) scale(1.2);transform-origin:bottom right;}
}

/* ---- Contact image v2 ---- */
html body main.ct .ct-top .ct-band .ct-band-bg img{mix-blend-mode:normal !important;opacity:1 !important;filter:none !important;}
html body main.ct .ct-top .ct-band .ct-band-bg::after{background:linear-gradient(to right,rgba(9,60,60,.74) 0%,rgba(9,60,60,.5) 45%,rgba(9,60,60,.14) 100%) !important;}
@media (max-width:1000px){
html body main.ct .ct-top .ct-band .ct-band-bg::after{background:rgba(9,60,60,.55) !important;}
}

/* ct-v6: taller message box, bigger people image on phone and tablet */
html body main.ct .ct-field textarea{min-height:130px !important;height:130px;}
@media (max-width:700px){
html body main.ct .ct-field textarea{min-height:150px !important;height:150px;}
}
@media (max-width:1000px){
html body main.ct .ct-people-m{height:clamp(300px,84vw,460px) !important;margin-top:0 !important;}
html body main.ct .ct-people-m img{height:100% !important;transform:scale(1.25);transform-origin:bottom center;}
}
</style>

<main class="ct">

<div class="ct-top">

<div class="ct-band">
<div class="ct-band-bg"><img src="<?php echo $img . $ct_bg; ?>" alt="" width="1672" height="941" fetchpriority="high"></div>
<div class="ct-band-in">
<div class="ct-txt">
<h1>Contact Us <small>Travotech Agencies, Medical &amp; Laboratory Equipment Supplier in Nairobi, Kenya</small></h1>
<p class="ct-sub">We&rsquo;re here to support your healthcare needs.</p>
<p>Get in touch for quotes, product inquiries, delivery and after-sales support on laboratory analyzers, hospital beds, patient monitors, reagents and medical supplies across Kenya. Our team is always ready to help.</p>
<span class="ct-band-line"></span>
</div>
<div class="ct-people-m"><img src="<?php echo $img . $ct_ppl; ?>" alt="" width="500" height="500" loading="lazy"></div>
</div>
</div>

<div class="ct-people-d"><img src="<?php echo $img . $ct_ppl; ?>" alt="Travotech Agencies healthcare team ready to help customers in Nairobi, Kenya" width="500" height="600" loading="lazy"></div>

<div class="ct-cards-wrap" id="send">
<div class="ct-cards">
<div class="ct-form-box">
<div class="ct-title"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i><h2>Send Us a Message</h2></div>
<?php if ( isset( $_GET['sent'] ) ) : ?><div class="ct-note ct-ok" role="status">Thank you. Your message has been sent and our team will reply soon.</div><?php endif; ?>
<?php if ( $ct_err ) : ?><div class="ct-note ct-err" role="alert"><?php echo esc_html( $ct_err ); ?></div><?php endif; ?>
<form method="post" action="<?php echo esc_url( $page_url . '#send' ); ?>">
<?php wp_nonce_field( 'travotech_contact', 'ct_nonce' ); ?>
<div class="ct-hp" aria-hidden="true"><label>Website <input type="text" name="ct_website" tabindex="-1" autocomplete="off"></label></div>
<div class="ct-field"><i class="fa-solid fa-user" aria-hidden="true"></i><input type="text" name="ct_name" placeholder="Your Name" aria-label="Your name" value="<?php echo esc_attr( $ct_val['name'] ); ?>" required></div>
<div class="ct-field"><i class="fa-solid fa-envelope" aria-hidden="true"></i><input type="email" name="ct_email" placeholder="Your Email" aria-label="Your email" value="<?php echo esc_attr( $ct_val['email'] ); ?>" required></div>
<div class="ct-field"><i class="fa-solid fa-phone" aria-hidden="true"></i><input type="tel" name="ct_phone" placeholder="Your Phone" aria-label="Your phone" value="<?php echo esc_attr( $ct_val['phone'] ); ?>"></div>
<div class="ct-field ct-ta"><i class="fa-solid fa-comment-dots" aria-hidden="true"></i><textarea name="ct_message" placeholder="Your Message" aria-label="Your message" required><?php echo esc_textarea( $ct_val['message'] ); ?></textarea></div>
<button class="ct-send" type="submit" name="ct_submit" value="1"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Send Message</button>
</form>
</div>

<div class="ct-info-box">
<div class="ct-title"><i class="fa-solid fa-phone" aria-hidden="true"></i><h2>Our Contact Details</h2></div>
<div class="ct-det"><i class="fa-solid fa-phone" aria-hidden="true"></i><div><b>Phone / WhatsApp</b><a href="tel:+254<?php echo esc_attr( substr( $ct_phone1, 1 ) ); ?>"><?php echo esc_html( $ct_phone1 ); ?></a><a href="tel:+254<?php echo esc_attr( substr( $ct_phone2, 1 ) ); ?>"><?php echo esc_html( $ct_phone2 ); ?></a></div></div>
<div class="ct-det"><i class="fa-solid fa-envelope" aria-hidden="true"></i><div><b>Email Us</b><a href="mailto:<?php echo esc_attr( $ct_email1 ); ?>"><?php echo esc_html( $ct_email1 ); ?></a><a href="mailto:<?php echo esc_attr( $ct_email2 ); ?>"><?php echo esc_html( $ct_email2 ); ?></a></div></div>
<div class="ct-det"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><div><b>Our Location</b><span>Travotech Nairobi, Tom Mboya Street, Nyambene House, 1st floor, Nairobi, Kenya</span></div></div>
<?php $ct_have = array_filter( $ct_social, function ( $s ) { return '' !== $s[2]; } ); ?>
<?php if ( $ct_have ) : ?>
<div class="ct-follow"><b>Follow Us</b><div class="ct-soc">
<?php foreach ( $ct_have as $s ) : ?><a href="<?php echo esc_url( $s[2] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $s[1] ); ?>"><i class="<?php echo esc_attr( $s[0] ); ?>" aria-hidden="true"></i></a><?php endforeach; ?>
</div></div>
<?php endif; ?>
</div>
</div>
</div>

</div>

<div class="ct-wrap">
<div class="ct-lower">

<div class="ct-map">
<div class="ct-map-tag"><b>Travotech Nairobi</b><span>Nyambene House, Tom Mboya Street</span><a href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo rawurlencode( 'Nyambene House, Tom Mboya Street, Nairobi, Kenya' ); ?>" target="_blank" rel="noopener">View larger map</a></div>
<iframe title="Map of Travotech Nairobi, Nyambene House, Tom Mboya Street" src="https://www.google.com/maps?q=<?php echo rawurlencode( 'Nyambene House, Tom Mboya Street, Nairobi, Kenya' ); ?>&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
</div>

<div class="ct-cta">
<i class="fa-solid fa-handshake" aria-hidden="true"></i>
<div>
<h2>Let&rsquo;s Build a Healthier Kenya Together</h2>
<p>Your health is our priority. Reach out today for the best laboratory and healthcare solutions.</p>
<a class="ct-btn" href="tel:+254<?php echo esc_attr( substr( $ct_phone2, 1 ) ); ?>">Call Us Now <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
</div>
</div>

<section class="ct-off">
<h2 class="ct-h2">Our Offices</h2>
<div class="ct-offs">
<?php foreach ( $ct_branches as $b ) : ?>
<div class="ct-o">
<i class="fa-solid fa-location-dot" aria-hidden="true"></i>
<h3><?php echo esc_html( $b[0] ); ?></h3>
<p><?php echo esc_html( $b[1] ); ?></p>
<p><i class="fa-solid fa-phone" aria-hidden="true"></i> <a class="ct-ph" href="tel:+254<?php echo esc_attr( substr( $b[2], 1 ) ); ?>"><?php echo esc_html( $b[2] ); ?></a></p>
<a class="ct-mp" href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo rawurlencode( $b[3] ); ?>" target="_blank" rel="noopener"><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> Open in Google Maps</a>
</div>
<?php endforeach; ?>
</div>
</section>

</div>
</div>
</main>

<?php get_footer(); ?>