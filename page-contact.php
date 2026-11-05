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
$ct_wa = '254720737151';
$ct_social = array(
    array( 'fa-brands fa-facebook-f', 'Facebook', '' ),
    array( 'fa-brands fa-linkedin-in', 'LinkedIn', '' ),
    array( 'fa-brands fa-youtube', 'YouTube', '' ),
);
$ct_branches = array(
    array( 'Head Office - Kahawa Sukari', 'Kahawa Sukari, Bungoma Road, Bungoma Close - Gate No.4', '0720737151', 'Kahawa Sukari, Bungoma Road, Bungoma Close, Nairobi, Kenya' ),
    array( 'Travotech Nairobi', 'Tom Mboya Street - Nyambene House, 1st floor, meters away from Afya Centre', '0729080053', 'Nyambene House, Tom Mboya Street, Nairobi, Kenya' ),
    array( 'Travotech Meru', 'Tom Mboya Street, Meru Town, directly opposite Post Bank Meru / YETU Sacco', '0725282453', 'Tom Mboya Street, Meru Town, Kenya' ),
);
$img = esc_url( get_template_directory_uri() ) . '/assets/js/images/';
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
.ct{--ct-g:var(--th-g,#238a56);--ct-gd:var(--th-gd,#1b6d44);--ct-dk:var(--th-dk,#0c3a27);--ct-red:var(--th-red,#d32f2f);--ct-tint:#eaf6ef;--ct-line:#d6e8de;
font-family:'Inter',system-ui,sans-serif;color:#2b3a33;overflow-x:hidden;}
.ct *,.ct *::before,.ct *::after{box-sizing:border-box;}
.ct h1,.ct h2,.ct h3{font-family:var(--th-fh,'Oswald',sans-serif);color:var(--ct-dk);margin:0;line-height:1.2;letter-spacing:.01em;}
.ct p{margin:0 0 10px;line-height:1.7;font-size:.95rem;}
.ct a{color:inherit;}
.ct-wrap{width:100%;max-width:1200px;margin:0 auto;padding:0 5%;}

/* Hero */
.ct-hero{position:relative;background:var(--ct-dk);color:#fff;overflow:hidden;}
.ct-hero-img{position:absolute;top:0;right:0;bottom:0;width:100%;}
.ct-hero-img img{width:100%;height:100%;object-fit:cover;object-position:right center;display:block;}
.ct-hero-img::before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,var(--ct-dk) 0%,var(--ct-dk) 38%,rgba(12,58,39,0) 68%);z-index:1;}
.ct-hero-in{position:relative;z-index:2;max-width:1200px;margin:0 auto;padding:clamp(34px,6vw,60px) 5% 40px;}
.ct-hero-txt{max-width:600px;margin-bottom:34px;}
.ct .ct-hero h1{color:#fff;font-size:clamp(2.4rem,7vw,4.4rem);line-height:1.05;margin-bottom:10px;}
.ct .ct-hero h1 small{display:block;font-size:clamp(1rem,2.2vw,1.35rem);font-weight:500;line-height:1.35;margin-top:10px;color:#9fe0bf;}
.ct-sub{font-family:var(--th-fh,'Oswald',sans-serif);font-size:clamp(1.2rem,2.6vw,1.7rem);color:#fff;margin:0 0 8px !important;}
.ct .ct-hero p{color:rgba(255,255,255,.92);}
.ct-hero-line{display:block;width:70px;height:4px;background:var(--ct-red);border-radius:2px;margin-top:14px;}

/* Form and details cards */
.ct-cards{display:grid;grid-template-columns:1.1fr 1fr;gap:0;max-width:820px;background:#fff;border-radius:14px;box-shadow:0 14px 34px rgba(0,0,0,.25);overflow:hidden;}
.ct-form-box{padding:26px;}
.ct-info-box{padding:26px;background:var(--ct-tint);}
.ct-title{display:flex;align-items:center;gap:12px;margin-bottom:16px;}
.ct-title i{width:42px;height:42px;border-radius:50%;background:var(--ct-g);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.ct .ct-title h2{font-size:1.3rem;}
.ct-field{position:relative;margin-bottom:10px;}
.ct-field i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--ct-g);font-size:.95rem;}
.ct-field.ct-ta i{top:18px;transform:none;}
.ct-field input,.ct-field textarea{width:100%;border:1px solid var(--ct-line);border-radius:6px;background:#fff;padding:12px 12px 12px 42px;font:inherit;font-size:.92rem;color:#2b3a33;}
.ct-field textarea{min-height:100px;resize:vertical;}
.ct-field input:focus,.ct-field textarea:focus{outline:2px solid var(--ct-g);outline-offset:0;border-color:var(--ct-g);}
.ct-hp{position:absolute !important;left:-9999px;width:1px;height:1px;overflow:hidden;}
.ct-send{width:100%;display:flex;align-items:center;justify-content:center;gap:8px;border:0;border-radius:6px;background:var(--ct-g);color:#fff;font-weight:700;font-size:.95rem;padding:13px;cursor:pointer;transition:background .2s;}
.ct-send:hover{background:var(--ct-gd);}
.ct-note{border-radius:6px;padding:10px 12px;font-size:.88rem;margin-bottom:12px;}
.ct-ok{background:#e3f6ea;border:1px solid #9bd5b2;color:#14532d;}
.ct-err{background:#fdecea;border:1px solid #f1a9a3;color:#8a1c14;}

.ct-det{display:flex;gap:12px;align-items:flex-start;padding:10px 0;}
.ct-det>i{font-size:1.2rem;color:var(--ct-g);width:24px;text-align:center;margin-top:3px;flex-shrink:0;}
.ct-det b{display:block;font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--ct-dk);font-size:1rem;}
.ct-det span,.ct-det a{display:block;font-size:.9rem;line-height:1.55;text-decoration:none;word-break:break-word;}
.ct-det a:hover{color:var(--ct-gd);text-decoration:underline;}
.ct-follow{border-top:1px solid var(--ct-line);margin-top:6px;padding-top:12px;}
.ct-follow b{font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--ct-dk);display:block;margin-bottom:8px;}
.ct-soc{display:flex;gap:10px;}
.ct-soc a{width:38px;height:38px;border-radius:50%;background:var(--ct-g);color:#fff !important;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:background .2s;}
.ct-soc a:hover{background:var(--ct-red);}

/* Map and CTA */
.ct-row{display:grid;grid-template-columns:1.2fr 1fr;gap:20px;padding:30px 0 10px;}
.ct-map{position:relative;border-radius:12px;overflow:hidden;border:1px solid var(--ct-line);min-height:260px;}
.ct-map iframe{position:absolute;inset:0;width:100%;height:100%;border:0;}
.ct-map-tag{position:absolute;left:12px;top:12px;z-index:2;background:#fff;border-radius:8px;padding:10px 14px;box-shadow:0 4px 14px rgba(0,0,0,.2);max-width:210px;}
.ct-map-tag b{display:block;font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--ct-dk);}
.ct-map-tag span{display:block;font-size:.8rem;line-height:1.4;}
.ct-map-tag a{font-size:.8rem;font-weight:600;color:var(--ct-gd);}
.ct-cta{background:var(--ct-red);color:#fff;border-radius:12px;padding:26px;display:flex;align-items:center;gap:20px;}
.ct-cta>i{font-size:2.6rem;flex-shrink:0;}
.ct .ct-cta h2{color:#fff;font-size:clamp(1.3rem,2.4vw,1.7rem);margin-bottom:6px;}
.ct .ct-cta p{color:#fff;font-size:.9rem;margin-bottom:12px;}
.ct-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:6px;font-weight:700;font-size:.9rem;text-decoration:none;background:#fff;color:var(--ct-dk) !important;}
.ct-btn:hover{background:var(--ct-tint);}

/* Offices */
.ct-off{padding:28px 0 34px;}
.ct .ct-h2{text-align:center;font-size:clamp(1.5rem,3vw,2.1rem);margin-bottom:22px;display:flex;align-items:center;justify-content:center;gap:14px;}
.ct .ct-h2::before,.ct .ct-h2::after{content:"";height:3px;width:clamp(26px,7vw,80px);background:var(--ct-g);border-radius:2px;}
.ct-offs{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.ct-o{border:1px solid var(--ct-line);border-radius:12px;padding:20px;background:#fff;box-shadow:0 6px 18px rgba(12,58,39,.06);}
.ct-o>i{width:46px;height:46px;border-radius:50%;background:var(--ct-tint);color:var(--ct-g);display:flex;align-items:center;justify-content:center;font-size:1.2rem;margin-bottom:10px;}
.ct .ct-o h3{font-size:1.15rem;margin-bottom:6px;}
.ct-o p{font-size:.88rem;margin-bottom:6px;}
.ct-o a.ct-ph{font-weight:600;text-decoration:none;color:var(--ct-dk);}
.ct-o a.ct-mp{display:inline-flex;gap:6px;align-items:center;margin-top:6px;font-size:.85rem;font-weight:700;color:var(--ct-red);text-decoration:none;}

@media (max-width:1000px){
.ct-hero-img::before{background:linear-gradient(90deg,var(--ct-dk) 0%,var(--ct-dk) 30%,rgba(12,58,39,0) 80%);}
.ct-cards{max-width:100%;}
.ct-offs{grid-template-columns:repeat(2,1fr);}
}
@media (max-width:800px){
.ct-hero-img{position:relative;width:100%;height:220px;}
.ct-hero-img::before{display:none;}
.ct-hero-img img{object-position:center top;}
.ct-hero-in{padding-top:28px;}
.ct-cards{grid-template-columns:1fr;}
.ct-row{grid-template-columns:1fr;}
.ct-map{min-height:280px;}
}
@media (max-width:600px){
.ct-offs{grid-template-columns:1fr;}
.ct-form-box,.ct-info-box{padding:20px;}
.ct-cta{flex-direction:column;text-align:center;}
}
</style>

<main class="ct">

<div class="ct-hero">
<div class="ct-hero-img">
<img src="<?php echo $img; ?>contactbg.png" alt="Travotech Agencies healthcare team ready to help customers in Nairobi, Kenya" width="1600" height="800" fetchpriority="high">
</div>
<div class="ct-hero-in">
<div class="ct-hero-txt">
<h1>Contact Us <small>Travotech Agencies, Medical &amp; Laboratory Equipment Supplier in Nairobi, Kenya</small></h1>
<p class="ct-sub">We&rsquo;re here to support your healthcare needs.</p>
<p>Get in touch for quotes, product inquiries, delivery and after-sales support on laboratory analyzers, hospital beds, patient monitors, reagents and medical supplies across Kenya. Our team is always ready to help.</p>
<span class="ct-hero-line"></span>
</div>

<div class="ct-cards" id="send">
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

<div class="ct-row">
<div class="ct-map">
<div class="ct-map-tag"><b>Travotech Nairobi</b><span>Nyambene House, Tom Mboya Street</span><a href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo rawurlencode( 'Nyambene House, Tom Mboya Street, Nairobi, Kenya' ); ?>" target="_blank" rel="noopener">View larger map</a></div>
<iframe title="Map of Travotech Nairobi, Nyambene House, Tom Mboya Street" src="https://www.google.com/maps?q=<?php echo rawurlencode( 'Nyambene House, Tom Mboya Street, Nairobi, Kenya' ); ?>&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
</div>
<div class="ct-cta">
<i class="fa-solid fa-handshake" aria-hidden="true"></i>
<div>
<h2>Let&rsquo;s Build a Healthier Kenya Together</h2>
<p>Your health is our priority. Reach out today for the best laboratory and healthcare solutions.</p>
<a class="ct-btn" href="tel:+254<?php echo esc_attr( substr( $ct_phone2, 1 ) ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call Us Now</a>
</div>
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
</main>

<?php get_footer(); ?>