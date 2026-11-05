<?php
/*
Template Name: About Us
*/
if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) ) {
    add_filter( 'pre_get_document_title', function () {
        return 'About Travotech Agencies | Laboratory & Healthcare Supplier Kenya';
    } );
}
get_header();

$img  = esc_url( get_template_directory_uri() ) . '/assets/js/images/';
$shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
$contact = home_url( '/contact/' );

/* Images: change the filenames here if you want different pictures */
$ab_hero    = 'aboutbg.png';
$ab_who     = 'aboutbg2.png';
$ab_why     = file_exists( get_template_directory() . '/assets/js/images/whyus.png' ) ? 'whyus.png' : 'doctors.png';
$ab_quality = 'homebg2.png';

/* Team: names and roles are placeholders taken from the mockup. Replace with real staff. */
$ab_team = array(
    array( 'male1.png',   'Dr. Michael Otieno', 'Medical Director',  'Leading our team with professionalism and care.' ),
    array( 'female1.png', 'Dr. Grace Wanjiru',  'Head Pharmacist',   'Ensuring safe and quality medicines for you.' ),
    array( 'male2.png',   'Dr. Peter Kamau',    'Senior Clinician',  'Committed to your health and wellbeing.' ),
    array( 'female2.png', 'Dr. Susan Njeri',    'Healthcare Support','Providing compassionate care at all times.' ),
);

/* Meta description (skipped when Yoast or Rank Math handles it) */
if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) ) {
    add_action( 'wp_head', function () {
        echo '<meta name="description" content="' . esc_attr( 'Travotech Agencies Limited is a trusted supplier of quality pharmaceutical, laboratory and healthcare products in Nairobi and across Kenya. Meet our mission, values and team.' ) . '">' . "\n";
    }, 1 );
}
?>
<script type="application/ld+json">
<?php echo wp_json_encode( array(
    '@context' => 'https://schema.org',
    '@type'    => 'AboutPage',
    'name'     => 'About Travotech Agencies Limited',
    'url'      => get_permalink(),
    'about'    => array(
        '@type' => 'Organization',
        'name'  => 'Travotech Agencies Limited',
        'url'   => home_url( '/' ),
        'areaServed' => 'Kenya',
    ),
), JSON_UNESCAPED_SLASHES ); ?>
</script>

<style>
.ab{--ab-g:var(--th-g,#0d4fc8);--ab-gd:var(--th-gd,#0a41a6);--ab-dk:var(--th-dk,#031a42);--ab-red:var(--th-red,#d32f2f);--ab-tint:#e6edfa;--ab-line:#cddaf1;
font-family:'Inter',system-ui,sans-serif;color:#1d2c48;overflow-x:hidden;}
.ab *,.ab *::before,.ab *::after{box-sizing:border-box;}
.ab img{max-width:100%;display:block;}
.ab h1,.ab h2,.ab h3{font-family:var(--th-fh,'Oswald',sans-serif);color:var(--ab-dk);margin:0;line-height:1.15;letter-spacing:.01em;}
.ab p{margin:0;line-height:1.7;}
.ab-wrap{width:100%;max-width:1200px;margin:0 auto;padding:0 5%;}
.ab-sec{padding:clamp(36px,6vw,64px) 0;}
.ab-h2{font-size:clamp(1.5rem,3.2vw,2.2rem);text-align:center;display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:28px;}
.ab-h2::before,.ab-h2::after{content:"";height:3px;width:clamp(30px,8vw,90px);background:var(--ab-g);border-radius:2px;}

/* Hero */
.ab-hero{position:relative;height:clamp(180px,32vw,380px);overflow:hidden;}
.ab-hero img{width:100%;height:100%;object-fit:cover;object-position:center 25%;}
.ab-hero::after{content:"";position:absolute;left:0;right:0;bottom:0;height:60px;background:linear-gradient(to bottom,transparent,#fff);}

/* Who we are */
.ab-who{display:grid;grid-template-columns:1.15fr 1.2fr 1fr;gap:28px;align-items:center;}
.ab-pill{display:inline-block;background:var(--ab-tint);color:var(--ab-gd);font-weight:600;font-size:.85rem;padding:4px 14px;border-radius:6px;margin-bottom:10px;}
.ab-who h1{font-size:clamp(2rem,4.5vw,3rem);margin-bottom:12px;}
.ab-who h1 span{color:var(--ab-g);}
.ab-who p{font-size:.95rem;}
.ab-who-line{width:60px;height:4px;background:var(--ab-red);border-radius:2px;margin-top:16px;}
.ab-tiles{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;}
.ab-tile{background:var(--ab-tint);border:1px solid var(--ab-line);border-radius:10px;padding:16px 10px;text-align:center;}
.ab-tile i{font-size:1.7rem;color:var(--ab-g);margin-bottom:8px;display:block;}
.ab-tile b{font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--ab-dk);font-size:.95rem;}
.ab-who-img img{width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:10px;}

/* Mission and vision */
.ab-mv-bg{background:linear-gradient(180deg,#fff,var(--ab-tint));}
.ab-mv{display:grid;grid-template-columns:1fr 1fr;gap:24px;}
.ab-card{background:#fff;border:1px solid var(--ab-line);border-radius:10px;padding:24px;display:flex;gap:18px;align-items:flex-start;box-shadow:0 6px 18px rgba(3,26,66,.06);}
.ab-ic{flex:0 0 64px;height:64px;border-radius:50%;background:var(--ab-g);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.6rem;}
.ab-card h3{font-size:1.3rem;margin-bottom:6px;}
.ab-card p{font-size:.92rem;}

/* Core values */
.ab-vals{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
.ab-val{border:1px solid var(--ab-line);border-radius:10px;padding:22px 14px;text-align:center;background:#fff;}
.ab-val i{font-size:2rem;color:var(--ab-g);margin-bottom:10px;display:block;}
.ab-val h3{font-size:1.1rem;margin-bottom:4px;}
.ab-val p{font-size:.86rem;line-height:1.5;}

/* Why choose */
.ab-why{display:grid;grid-template-columns:1fr 1fr;align-items:stretch;background:var(--ab-tint);}
.ab-why-img{min-height:280px;position:relative;}
.ab-why-img img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:top center;}
.ab-why-txt{padding:clamp(24px,5vw,56px);}
.ab-why-txt h2{font-size:clamp(1.6rem,3.4vw,2.3rem);margin-bottom:10px;}
.ab-why-txt>p{font-weight:600;color:var(--ab-dk);margin-bottom:14px;}
.ab-ticks{list-style:none;margin:0;padding:0;display:grid;gap:10px;}
.ab-ticks li{display:flex;gap:10px;align-items:flex-start;font-size:.95rem;}
.ab-ticks i{color:var(--ab-g);margin-top:4px;}

/* Commitment banner */
.ab-commit{position:relative;color:#fff;background:var(--ab-dk);overflow:hidden;}
.ab-commit img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.28;}
.ab-commit-in{position:relative;padding:clamp(32px,6vw,60px) 5%;max-width:1200px;margin:0 auto;}
.ab-commit h2{color:#fff;font-size:clamp(1.6rem,3.4vw,2.3rem);margin-bottom:10px;}
.ab-commit p{max-width:620px;margin-bottom:18px;}
.ab-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:6px;font-weight:700;font-size:.9rem;text-decoration:none;background:var(--ab-red);color:#fff !important;transition:background .2s;}
.ab-btn:hover{background:#c62828;}
.ab-btn.ab-btn-w{background:#fff;color:var(--ab-dk) !important;}
.ab-btn.ab-btn-w:hover{background:var(--ab-tint);}

/* Trust strip */
.ab-trust{display:grid;grid-template-columns:repeat(4,1fr);}
.ab-trust div{text-align:center;padding:22px 10px;border-right:1px solid var(--ab-line);}
.ab-trust div:last-child{border-right:0;}
.ab-trust i{font-size:1.8rem;color:var(--ab-g);display:block;margin-bottom:6px;}
.ab-trust b{font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--ab-dk);}

/* Team */
.ab-team-sub{text-align:center;max-width:620px;margin:-12px auto 28px;}
.ab-team{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
.ab-member{border:1px solid var(--ab-line);border-radius:12px;overflow:hidden;background:#fff;text-align:center;box-shadow:0 6px 18px rgba(3,26,66,.06);}
.ab-member-img{aspect-ratio:1/1.05;background:radial-gradient(circle at 50% 38%,#c5d6f4 0 36%,var(--ab-tint) 37%);}
.ab-member-img img{width:100%;height:100%;object-fit:cover;object-position:center top;}
.ab-member-body{padding:14px 12px 18px;}
.ab-member h3{font-size:1.15rem;margin-bottom:8px;}
.ab-role{display:inline-block;background:var(--ab-g);color:#fff;font-size:.82rem;font-weight:600;padding:4px 14px;border-radius:6px;margin-bottom:8px;}
.ab-member p{font-size:.86rem;line-height:1.5;}

/* CTA band */
.ab-cta{background:var(--ab-red);color:#fff;border-radius:12px;padding:24px 28px;display:flex;align-items:center;gap:22px;justify-content:space-between;}
.ab-cta i.fa-capsules{font-size:2.4rem;}
.ab-cta-t{flex:1;}
.ab-cta h2{color:#fff;font-size:clamp(1.3rem,2.6vw,1.8rem);margin-bottom:4px;}
.ab-cta p{font-size:.92rem;}

/* Tablet */
@media (max-width:1000px){
.ab-who{grid-template-columns:1fr 1fr;}
.ab-who-img{grid-column:1/-1;}
.ab-vals,.ab-team{grid-template-columns:repeat(2,1fr);}
}
/* Phone */
@media (max-width:700px){
.ab-who{grid-template-columns:1fr;}
.ab-mv{grid-template-columns:1fr;}
.ab-card{padding:18px;}
.ab-ic{flex-basis:52px;height:52px;font-size:1.3rem;}
.ab-why{grid-template-columns:1fr;}
.ab-why-img{min-height:240px;}
.ab-trust{grid-template-columns:repeat(2,1fr);}
.ab-trust div:nth-child(2){border-right:0;}
.ab-trust div:nth-child(-n+2){border-bottom:1px solid var(--ab-line);}
.ab-team{gap:12px;}
.ab-member h3{font-size:1rem;}
.ab-member p{font-size:.8rem;}
.ab-cta{flex-direction:column;text-align:center;}
.ab-h2::before,.ab-h2::after{width:24px;}
}

/* ---- About v2 ---- */
.ab .ab-h2{margin:0 0 28px;}
.ab .ab-team-sub{margin:0 auto 28px;max-width:620px;text-align:center;}
.ab .ab-who h2{font-size:clamp(2rem,4.5vw,3rem);margin-bottom:12px;}
.ab .ab-who h2 span{color:var(--ab-g);}
.ab .ab-hero{display:flex;align-items:center;justify-content:center;height:auto;min-height:clamp(280px,42vw,440px);text-align:center;}
.ab .ab-hero::after{display:none;}
.ab .ab-hero::before{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(3,26,66,.78),rgba(3,26,66,.55));z-index:1;}
.ab .ab-hero img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 25%;}
.ab .ab-hero-in{position:relative;z-index:2;max-width:860px;padding:40px 5%;}
.ab .ab-hero h1{color:#fff;font-size:clamp(1.8rem,5vw,3.2rem);line-height:1.15;margin:0 0 14px;text-shadow:0 2px 12px rgba(0,0,0,.35);}
.ab .ab-hero-line{display:block;width:70px;height:4px;background:var(--ab-red);border-radius:2px;margin:0 auto 16px;}
.ab .ab-hero p{color:#fff;font-size:clamp(.95rem,2vw,1.15rem);max-width:700px;margin:0 auto;}
.ab>section:last-child{padding-bottom:28px;}

/* ---- About v3 ---- */
.ab .ab-hero::before{background:linear-gradient(180deg,rgba(3,26,66,.10),rgba(3,26,66,.18)) !important;}
.ab .ab-hero-in{background:rgba(3,26,66,.62);-webkit-backdrop-filter:blur(3px);backdrop-filter:blur(3px);border-radius:14px;padding:clamp(18px,3.5vw,34px) clamp(16px,4vw,40px);margin:32px 5%;max-width:820px;}
.ab .ab-hero h1{font-size:clamp(1.5rem,4vw,2.6rem);margin:0 0 12px;}
.ab .ab-hero p{font-size:clamp(.9rem,1.8vw,1.05rem);}
@media (max-width:700px){
    .ab .ab-hero{min-height:260px;}
    .ab .ab-hero-in{margin:20px 4%;}
}

/* ---- About v4 ---- */
.ab .ab-hero-in{background:none !important;-webkit-backdrop-filter:none !important;backdrop-filter:none !important;border-radius:0;box-shadow:none;padding:40px 5% !important;margin:0 auto !important;}
.ab .ab-hero::before{background:rgba(3,26,66,.18) !important;}
.ab .ab-hero h1{text-shadow:0 2px 4px rgba(0,0,0,.55),0 4px 22px rgba(0,0,0,.45);}
.ab .ab-hero p{text-shadow:0 1px 3px rgba(0,0,0,.65),0 2px 14px rgba(0,0,0,.5);font-weight:500;}
</style>

<main class="ab">

<div class="ab-hero">
<img src="<?php echo $img . $ab_hero; ?>" alt="Travotech Agencies Limited healthcare and pharmacy team in Kenya" width="1600" height="500" fetchpriority="high">
<div class="ab-hero-in">
<h1>Trusted Laboratory, Pharmaceutical &amp; Healthcare Supplier in Kenya</h1>
<span class="ab-hero-line"></span>
<p>Travotech Agencies Limited supplies quality laboratory equipment, pharmaceutical and healthcare products to hospitals, clinics, pharmacies and laboratories in Nairobi and across Kenya.</p>
</div>
</div>

<section class="ab-sec">
<div class="ab-wrap ab-who">
<div>
<span class="ab-pill">About Us</span>
<h2>Who <span>We Are</span></h2>
<p>Travotech Agencies Limited is a trusted provider of quality pharmaceutical, laboratory and healthcare products in Kenya. We are committed to improving health and wellness through safe, reliable and affordable products.</p>
<div class="ab-who-line"></div>
</div>
<div class="ab-tiles">
<div class="ab-tile"><i class="fa-solid fa-shield-heart" aria-hidden="true"></i><b>Quality Products</b></div>
<div class="ab-tile"><i class="fa-solid fa-handshake" aria-hidden="true"></i><b>Trusted Partner</b></div>
<div class="ab-tile"><i class="fa-solid fa-users" aria-hidden="true"></i><b>Dedicated Team</b></div>
<div class="ab-tile"><i class="fa-solid fa-heart-pulse" aria-hidden="true"></i><b>Better Health</b></div>
</div>
<div class="ab-who-img">
<img src="<?php echo $img . $ab_who; ?>" alt="Travotech Agencies Limited, pharmaceutical and laboratory equipment supplier in Nairobi" width="600" height="450" loading="lazy">
</div>
</div>
</section>

<section class="ab-sec ab-mv-bg">
<div class="ab-wrap">
<h2 class="ab-h2">Our Mission &amp; Vision</h2>
<div class="ab-mv">
<div class="ab-card">
<div class="ab-ic"><i class="fa-solid fa-bullseye" aria-hidden="true"></i></div>
<div>
<h3>Our Mission</h3>
<p>To provide high-quality pharmaceutical, laboratory and healthcare products and services that promote better health and wellness for all Kenyans.</p>
</div>
</div>
<div class="ab-card">
<div class="ab-ic"><i class="fa-solid fa-eye" aria-hidden="true"></i></div>
<div>
<h3>Our Vision</h3>
<p>To be the leading and most trusted pharmaceutical and healthcare partner in Kenya and beyond.</p>
</div>
</div>
</div>
</div>
</section>

<section class="ab-sec">
<div class="ab-wrap">
<h2 class="ab-h2">Our Core Values</h2>
<div class="ab-vals">
<div class="ab-val"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><h3>Integrity</h3><p>We do what is right, always.</p></div>
<div class="ab-val"><i class="fa-solid fa-award" aria-hidden="true"></i><h3>Quality</h3><p>We never compromise on quality.</p></div>
<div class="ab-val"><i class="fa-solid fa-handshake-angle" aria-hidden="true"></i><h3>Reliability</h3><p>You can count on us.</p></div>
<div class="ab-val"><i class="fa-solid fa-headset" aria-hidden="true"></i><h3>Customer Care</h3><p>Your health is our priority.</p></div>
</div>
</div>
</section>

<section class="ab-why">
<div class="ab-why-img">
<img src="<?php echo $img . $ab_why; ?>" alt="Healthcare professionals supporting Travotech customers" width="800" height="600" loading="lazy">
</div>
<div class="ab-why-txt">
<h2>Why Choose Travotech</h2>
<p>We are your trusted healthcare partner, offering quality products and professional support.</p>
<ul class="ab-ticks">
<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Wide range of genuine pharmaceutical and laboratory products</li>
<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Competitive prices</li>
<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Professional and friendly support</li>
<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Reliable delivery across Kenya</li>
</ul>
</div>
</section>

<section class="ab-commit">
<img src="<?php echo $img . $ab_quality; ?>" alt="" aria-hidden="true" loading="lazy">
<div class="ab-commit-in">
<h2>Our Commitment to Quality</h2>
<p>At Travotech Agencies Limited, quality is at the heart of everything we do. We source our products from verified and reputable suppliers and adhere to strict quality assurance standards.</p>
<a class="ab-btn" href="<?php echo esc_url( $shop ); ?>">Browse products <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
</div>
</section>

<div class="ab-wrap">
<div class="ab-trust">
<div><i class="fa-solid fa-shield-heart" aria-hidden="true"></i><b>Trusted Healthcare</b></div>
<div><i class="fa-solid fa-capsules" aria-hidden="true"></i><b>Quality Products</b></div>
<div><i class="fa-solid fa-users" aria-hidden="true"></i><b>Customer Focus</b></div>
<div><i class="fa-solid fa-handshake" aria-hidden="true"></i><b>Reliable Service</b></div>
</div>
</div>

<section class="ab-sec">
<div class="ab-wrap">
<h2 class="ab-h2">Our Team</h2>
<p class="ab-team-sub">A dedicated team of healthcare professionals, always ready to support you with expert advice and reliable service.</p>
<div class="ab-team">
<?php foreach ( $ab_team as $m ) : ?>
<article class="ab-member">
<div class="ab-member-img">
<img src="<?php echo $img . esc_attr( $m[0] ); ?>" alt="<?php echo esc_attr( $m[1] . ', ' . $m[2] . ' at Travotech Agencies Limited' ); ?>" width="400" height="420" loading="lazy">
</div>
<div class="ab-member-body">
<h3><?php echo esc_html( $m[1] ); ?></h3>
<span class="ab-role"><?php echo esc_html( $m[2] ); ?></span>
<p><?php echo esc_html( $m[3] ); ?></p>
</div>
</article>
<?php endforeach; ?>
</div>
</div>
</section>

<section class="ab-sec" style="padding-top:0;">
<div class="ab-wrap">
<div class="ab-cta">
<i class="fa-solid fa-capsules" aria-hidden="true"></i>
<div class="ab-cta-t">
<h2>Explore Our Products Today</h2>
<p>Get quality pharmaceutical, laboratory and healthcare products in Kenya.</p>
</div>
<a class="ab-btn ab-btn-w" href="<?php echo esc_url( $contact ); ?>">Contact Us <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
</div>
</div>
</section>

</main>

<?php get_footer(); ?>