<?php
/*
Template Name: Projects
*/

/* ---- pj-v1: edit these to match your business ---- */
$pj_phone_show = '0720737151';
$pj_phone_link = '+254720737151';
$pj_wa         = '254720737151';
$pj_email      = 'sales@travotechagencies.co.ke';
$contact       = home_url( '/contact/' );
$shop          = ( function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0 ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );

/* Placeholder images from /assets/js/images/. Replace the file name in each project with your real project photo. */
$pj_img_url = get_template_directory_uri() . '/assets/js/images/';
$pj_img_dir = get_template_directory() . '/assets/js/images/';

/* title, description, county, icon, image file. Replace these samples with your real projects. */
$pj_projects = array(
    array( 'Patient Monitoring System', 'Supply and setup of multi-parameter patient monitors for intensive care and ward use.', 'Nairobi', 'fa-heart-pulse', 'homebg.png' ),
    array( 'Hospital Bed Supply', 'Delivery and set up of adjustable hospital beds for wards and referral facilities.', 'Kisumu', 'fa-bed-pulse', 'homebg2.png' ),
    array( 'Laboratory Analyzer Setup', 'Installation and training for chemistry and haematology analyzers in a busy laboratory.', 'Nyeri', 'fa-microscope', 'aboutbg.png' ),
    array( 'Ultrasound Machine', 'Professional commissioning of ultrasound devices for clinics and diagnostic centres.', 'Mombasa', 'fa-wave-square', 'aboutbg2.png' ),
    array( 'Operating Theatre Equipment', 'Supply of theatre lights, tables and monitoring equipment for safer surgery.', 'Thika', 'fa-user-doctor', 'contactbg.png' ),
    array( 'Infusion Pump Setup', 'Supply and staff guidance for infusion and syringe pumps for safe, accurate dosing.', 'Nakuru', 'fa-syringe', 'shopbg.png' ),
    array( 'Digital X-Ray System', 'Complete installation of digital X-ray equipment with handover and user training.', 'Eldoret', 'fa-x-ray', 'whyus.png' ),
    array( 'Defibrillator Installation', 'Supply of life-saving defibrillators and basic user training for healthcare facilities.', 'Meru', 'fa-bolt', 'contact.png' ),
);
$pj_counties = array();
foreach ( $pj_projects as $x ) { $pj_counties[ $x[2] ] = true; }
$pj_counties = array_keys( $pj_counties );

$pj_faq = array(
    array( 'Who offers professional medical equipment installation in Kenya?', 'Travotech Agencies supplies and installs laboratory and hospital equipment for hospitals, clinics, pharmacies, schools and laboratories in Nairobi, Kisumu, Nyeri and across Kenya.' ),
    array( 'Do you serve Kisumu, Nyeri and other counties, not only Nairobi?', 'Yes. We deliver and support customers in Nairobi, Kisumu, Nyeri, Mombasa, Nakuru, Eldoret, Thika, Meru and many other counties.' ),
    array( 'Are your prices affordable for small clinics?', 'We aim to give fair, clear pricing for individual buyers, small clinics and institutions that buy in bulk. Send us your list and we will send a quotation.' ),
    array( 'Do you train our staff after installation?', 'Our team can guide your staff on safe daily use and basic care, and we stay available for questions after the sale.' ),
    array( 'How do I request a quote for my facility?', 'Call or WhatsApp us, or use the contact page. Tell us what equipment you need and where your facility is, and we will reply with options and prices.' ),
);

$pj_title = 'Medical Equipment Projects in Kenya | Travotech Agencies';
$pj_desc  = 'Top, professional and affordable medical equipment supply and installation in Nairobi, Kisumu, Nyeri and across Kenya.';

if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) ) {
    add_filter( 'pre_get_document_title', function () use ( $pj_title ) { return $pj_title; } );
    add_action( 'wp_head', function () use ( $pj_desc ) {
        echo '<meta name="description" content="' . esc_attr( $pj_desc ) . '">' . "\n";
    }, 1 );
}
get_header();

/* ---- Structured data ---- */
$pj_items = array();
foreach ( $pj_projects as $i => $x ) {
    $pj_items[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'name' => $x[0] . ' - ' . $x[2] . ', Kenya' );
}
$pj_faq_ld = array();
foreach ( $pj_faq as $q ) {
    $pj_faq_ld[] = array( '@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $q[1] ) );
}
?>
<script type="application/ld+json">
<?php echo wp_json_encode( array(
    '@context'   => 'https://schema.org',
    '@type'      => 'CollectionPage',
    'name'       => 'Our Projects',
    'url'        => get_permalink(),
    'description'=> $pj_desc,
    'publisher'  => array( '@type' => 'Organization', 'name' => 'Travotech Agencies Limited', 'url' => home_url( '/' ), 'areaServed' => 'Kenya' ),
    'mainEntity' => array( '@type' => 'ItemList', 'itemListElement' => $pj_items ),
), JSON_UNESCAPED_SLASHES ); ?>
</script>
<script type="application/ld+json">
<?php echo wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $pj_faq_ld ), JSON_UNESCAPED_SLASHES ); ?>
</script>

<style>
.pj{--pj-g:var(--th-g,#22adb0);--pj-gd:var(--th-gd,#1a8f92);--pj-dk:var(--th-dk,#093c3c);--pj-red:var(--th-red,#e53935);--pj-tint:#e6fafa;--pj-line:#cdf1f0;
font-family:var(--th-fb,'Inter',system-ui,sans-serif);color:#1d4847;overflow-x:hidden;}
.pj *,.pj *::before,.pj *::after{box-sizing:border-box;}
.pj h1,.pj h2,.pj h3{font-family:var(--th-fh,'Oswald','Arial Narrow',sans-serif);color:var(--pj-dk);margin:0;line-height:1.2;letter-spacing:.01em;}
.pj p{margin:0 0 12px;line-height:1.75;font-size:.95rem;}
.pj a{color:var(--pj-gd);}
.pj img{max-width:100%;height:auto;display:block;}
.pj-wrap{width:100%;max-width:1280px;margin:0 auto;padding:0 clamp(16px,4vw,48px);}
.pj-sec{padding:clamp(34px,6vw,70px) 0;}
.pj-sec.alt{background:var(--pj-tint);}
.pj-head{text-align:center;max-width:820px;margin:0 auto clamp(22px,4vw,36px);}
.pj-head h2{font-size:clamp(1.5rem,3.2vw,2.2rem);padding-bottom:12px;}
.pj-head h2::after{content:"";display:block;width:64px;height:4px;background:var(--pj-red);border-radius:2px;margin:12px auto 0;}
.pj-head p{margin:10px 0 0;}

/* Top banner (no photo) */
.pj-top{position:relative;background:var(--pj-dk);color:#fff;overflow:hidden;}
.pj-top-in{position:relative;z-index:2;max-width:1280px;margin:0 auto;padding:clamp(24px,3.6vw,40px) clamp(16px,4vw,48px) clamp(44px,5vw,56px);}
.pj-top-txt{max-width:660px;}
.pj-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#fff;font-size:.82rem;font-weight:600;padding:5px 14px;border-radius:6px;margin-bottom:16px;}
.pj .pj-top h1{color:#fff;font-size:clamp(1.7rem,4.4vw,3rem);margin-bottom:14px;}
.pj-line{display:block;width:70px;height:4px;background:var(--pj-red);border-radius:2px;margin-bottom:16px;}
.pj .pj-top p{color:rgba(255,255,255,.9);font-size:clamp(.95rem,1.8vw,1.1rem);margin:0;}
.pj-top-btns{display:flex;flex-wrap:wrap;gap:12px;margin-top:18px;}
.pj-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 24px;border-radius:6px;font:600 14px var(--th-fh,'Oswald',sans-serif);letter-spacing:.04em;text-transform:uppercase;text-decoration:none;background:var(--pj-g);color:#fff !important;border:2px solid var(--pj-g);transition:background .2s,border-color .2s;cursor:pointer;}
.pj-btn:hover{background:var(--pj-dk);border-color:var(--pj-dk);}
.pj-btn-red{background:var(--pj-red);border-color:var(--pj-red);}
.pj-btn-red:hover{background:#c62828;border-color:#c62828;}
.pj-btn-ghost{background:transparent;border-color:#fff;}
.pj-btn-ghost:hover{background:#fff;border-color:#fff;color:var(--pj-dk) !important;}

/* Top banner art */
.pj-ha{position:absolute;right:0;top:0;height:100%;width:min(62%,700px);pointer-events:none;overflow:hidden;}
.pj-ha i{position:absolute;line-height:1;}
.pj-ring{position:absolute;border-radius:50%;border:2px solid rgba(255,255,255,.10);}
.pj-ring1{width:360px;height:360px;right:-80px;bottom:-120px;}
.pj-ring2{width:230px;height:230px;right:-20px;bottom:-60px;}
.pj-ecg{position:absolute;left:0;right:0;top:50%;width:100%;height:120px;transform:translateY(-50%);opacity:.55;}
.pj-ecg path{fill:none;stroke:#22adb0;stroke-width:3;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:1100;stroke-dashoffset:1100;animation:pjDraw 4.5s ease-in-out infinite;}
@keyframes pjDraw{0%{stroke-dashoffset:1100;}55%,80%{stroke-dashoffset:0;}100%{stroke-dashoffset:-1100;}}
.pj .pj-a1{right:12%;top:12%;font-size:clamp(80px,11vw,150px);color:#22adb0;opacity:.30;}
.pj .pj-a2{right:44%;top:14%;font-size:clamp(40px,5vw,64px);color:#fff;opacity:.14;}
.pj .pj-a3{right:5%;bottom:12%;font-size:clamp(50px,6.4vw,84px);color:#fff;opacity:.14;}
.pj .pj-a4{right:30%;bottom:10%;font-size:clamp(34px,4.4vw,54px);color:#e53935;opacity:.55;}
.pj .pj-a5{right:60%;bottom:20%;font-size:clamp(30px,4vw,46px);color:#22adb0;opacity:.34;}
.pj .pj-a6{right:3%;top:10%;font-size:22px;color:#fff;opacity:.25;}
.pj .pj-a7{right:52%;top:60%;font-size:20px;color:#22adb0;opacity:.4;}
@media (prefers-reduced-motion:reduce){.pj-ecg path{animation:none;stroke-dashoffset:0;}}
@media (max-width:1000px){.pj-ha{opacity:.55;width:75%;}}
@media (max-width:640px){.pj-ha{opacity:.32;width:100%;}.pj .pj-a2,.pj .pj-a5{display:none;}}

/* Highlights */
.pj-sum{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-top:-26px;position:relative;z-index:5;}
.pj-sum div{background:#fff;border:1px solid var(--pj-line);border-radius:10px;padding:18px 16px;box-shadow:0 8px 22px rgba(9,60,60,.10);}
.pj-sum i{font-size:1.5rem;color:var(--pj-g);margin-bottom:8px;display:block;}
.pj-sum b{display:block;font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--pj-dk);font-size:1.02rem;margin-bottom:4px;}
.pj-sum span{font-size:.85rem;line-height:1.55;display:block;}

/* Filter */
.pj-filter{display:flex;flex-wrap:wrap;justify-content:center;gap:8px;margin:0 0 clamp(18px,3vw,28px);}
.pj-chip{background:#fff;border:1.5px solid var(--pj-line);color:var(--pj-dk);font:600 13px var(--th-fb,'Inter',sans-serif);padding:8px 16px;border-radius:50px;cursor:pointer;transition:all .2s;}
.pj-chip:hover{border-color:var(--pj-g);color:var(--pj-gd);}
.pj-chip[aria-pressed="true"]{background:var(--pj-g);border-color:var(--pj-g);color:#fff;}

/* Project cards */
.pj-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
.pj-card{background:#fff;border:1px solid var(--pj-line);border-radius:12px;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 2px 12px rgba(9,60,60,.07);transition:transform .2s,box-shadow .2s;}
.pj-card:hover{transform:translateY(-4px);box-shadow:0 12px 28px rgba(9,60,60,.16);}
.pj-card[hidden]{display:none;}
.pj-card-img{position:relative;aspect-ratio:4/3;background:var(--pj-tint);overflow:hidden;display:flex;align-items:center;justify-content:center;}
.pj-card-img img{width:100%;height:100%;object-fit:cover;transition:transform .4s;}
.pj-card:hover .pj-card-img img{transform:scale(1.05);}
.pj-card-img>i{font-size:3rem;color:var(--pj-g);opacity:.4;}
.pj-tag{position:absolute;left:10px;top:10px;z-index:2;background:var(--pj-red);color:#fff;font:700 11px var(--th-fb,sans-serif);padding:4px 10px;border-radius:4px;display:inline-flex;align-items:center;gap:5px;}
.pj-card-body{padding:16px;display:flex;flex-direction:column;gap:8px;flex:1;border-top:3px solid var(--pj-g);}
.pj-card h3{font-size:1.08rem;}
.pj-card p{font-size:.88rem;line-height:1.6;margin:0;flex:1;}
.pj-loc{display:flex;align-items:center;gap:7px;font-weight:600;font-size:.85rem;color:var(--pj-dk);padding-top:10px;border-top:1px solid var(--pj-line);}
.pj-loc i{color:var(--pj-red);}

/* Feature cards */
.pj-feat{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
.pj-feat div{background:#fff;border:1px solid var(--pj-line);border-radius:10px;padding:24px 20px;text-align:center;}
.pj-feat i{font-size:2rem;color:var(--pj-g);margin-bottom:12px;display:block;}
.pj-feat h3{font-size:1.1rem;margin-bottom:8px;}
.pj-feat p{margin:0;font-size:.9rem;}
.pj-copy{max-width:900px;margin:0 auto clamp(22px,4vw,34px);text-align:center;}

/* Locations */
.pj-locs{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
.pj-locs div{background:#fff;border:1px solid var(--pj-line);border-radius:10px;padding:18px;}
.pj-locs h3{font-size:1.05rem;margin-bottom:6px;display:flex;align-items:center;gap:8px;}
.pj-locs h3 i{color:var(--pj-g);}
.pj-locs p{margin:0;font-size:.88rem;}

/* Steps */
.pj-steps{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;counter-reset:pjs;}
.pj-steps div{position:relative;background:#fff;border:1px solid var(--pj-line);border-radius:10px;padding:26px 18px 20px;counter-increment:pjs;}
.pj-steps div::before{content:counter(pjs);position:absolute;top:-16px;left:18px;width:34px;height:34px;border-radius:50%;background:var(--pj-red);color:#fff;font:700 15px var(--th-fh,'Oswald',sans-serif);display:flex;align-items:center;justify-content:center;}
.pj-steps h3{font-size:1.05rem;margin-bottom:6px;}
.pj-steps p{margin:0;font-size:.88rem;}

/* FAQ */
.pj-faq{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:repeat(2,1fr);gap:12px;align-items:start;}
.pj-faq details{background:#fff;border:1px solid var(--pj-line);border-radius:10px;padding:0;}
.pj-faq summary{cursor:pointer;list-style:none;padding:15px 18px;font:600 1rem var(--th-fh,'Oswald',sans-serif);color:var(--pj-dk);display:flex;justify-content:space-between;align-items:center;gap:12px;}
.pj-faq summary::-webkit-details-marker{display:none;}
.pj-faq summary::after{content:"\f067";font-family:"Font Awesome 6 Free";font-weight:900;font-size:.85rem;color:var(--pj-red);line-height:1;flex-shrink:0;}
.pj-faq details[open] summary::after{content:"\f068";}
.pj-faq details[open]{border-color:var(--pj-g);}
.pj-faq details p{padding:0 18px 16px;margin:0;font-size:.92rem;}

/* CTA */
.pj-cta{background:var(--th-nv,#072f2f);color:#fff;padding:clamp(30px,5vw,48px) 0;border-top:4px solid var(--pj-red);}
.pj-cta .pj-wrap{display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;}
.pj .pj-cta h2{color:#fff;font-size:clamp(1.4rem,3vw,2rem);}
.pj .pj-cta p{margin:6px 0 0;color:rgba(255,255,255,.9);}
.pj-cta-btns{display:flex;flex-wrap:wrap;gap:12px;}

.pj a:focus-visible,.pj-chip:focus-visible,.pj summary:focus-visible{outline:3px solid var(--pj-red);outline-offset:2px;}

@media (max-width:1200px){.pj-grid{grid-template-columns:repeat(3,1fr);}}
@media (max-width:1000px){
.pj-sum{grid-template-columns:repeat(2,1fr);}
.pj-feat,.pj-steps{grid-template-columns:repeat(2,1fr);}
.pj-locs{grid-template-columns:repeat(2,1fr);}
.pj-steps{row-gap:28px;}
}
@media (max-width:820px){.pj-grid{grid-template-columns:repeat(2,1fr);gap:14px;}}
@media (max-width:640px){
.pj-sum{grid-template-columns:1fr;margin-top:-24px;}
.pj-feat,.pj-steps,.pj-locs{grid-template-columns:1fr;}
.pj-top-btns .pj-btn,.pj-cta-btns .pj-btn{width:100%;}
.pj-cta .pj-wrap{text-align:center;justify-content:center;}
.pj-cta-btns{width:100%;}
}
@media (max-width:480px){
.pj-grid{grid-template-columns:1fr;}
.pj-chip{padding:7px 13px;font-size:12px;}
}

/* pj-v2: compact banner, 2-column FAQ */
@media (max-width:900px){.pj-faq{grid-template-columns:1fr;}}
@media (max-width:640px){.pj-top-in{padding-bottom:40px;}}
</style>

<main class="pj" id="main">

<!-- TOP BANNER: no photo, art only -->
<section class="pj-top" aria-labelledby="pj-h1">
<div class="pj-ha" aria-hidden="true">
<span class="pj-ring pj-ring1"></span>
<span class="pj-ring pj-ring2"></span>
<svg class="pj-ecg" viewBox="0 0 700 120" preserveAspectRatio="none"><path d="M0 60 H170 L195 60 L215 18 L245 104 L270 36 L288 60 H430 L455 60 L475 22 L505 100 L530 40 L548 60 H700"/></svg>
<i class="fa-solid fa-diagram-project pj-a1"></i>
<i class="fa-solid fa-hospital pj-a2"></i>
<i class="fa-solid fa-truck-medical pj-a3"></i>
<i class="fa-solid fa-location-dot pj-a4"></i>
<i class="fa-solid fa-stethoscope pj-a5"></i>
<i class="fa-solid fa-plus pj-a6"></i>
<i class="fa-solid fa-plus pj-a7"></i>
</div>
<div class="pj-top-in">
<div class="pj-top-txt">
<span class="pj-badge"><i class="fa-solid fa-diagram-project" aria-hidden="true"></i> Our Projects</span>
<h1 id="pj-h1">Top Medical Equipment Projects in Kenya</h1>
<span class="pj-line"></span>
<p>Professional, affordable equipment supply and installation in Nairobi, Kisumu, Nyeri and across Kenya.</p>
<div class="pj-top-btns">
<a class="pj-btn pj-btn-red" href="<?php echo esc_url( $contact ); ?>"><i class="fa-solid fa-handshake" aria-hidden="true"></i> Partner with us</a>
<a class="pj-btn pj-btn-ghost" href="<?php echo esc_url( $shop ); ?>"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Shop equipment</a>
</div>
</div>
</div>
</section>

<div class="pj-wrap">
<div class="pj-sum">
<div><i class="fa-solid fa-user-gear" aria-hidden="true"></i><b>Professional setup</b><span>Careful installation and handover by a team that knows the equipment.</span></div>
<div><i class="fa-solid fa-tags" aria-hidden="true"></i><b>Affordable pricing</b><span>Fair, clear prices for clinics, hospitals and bulk buyers.</span></div>
<div><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i><b>Across Kenya</b><span>Projects in Nairobi, Kisumu, Nyeri, Mombasa and many more counties.</span></div>
<div><i class="fa-solid fa-headset" aria-hidden="true"></i><b>Ongoing support</b><span>Advice and help from our team long after delivery.</span></div>
</div>
</div>

<!-- PROJECTS -->
<section class="pj-sec" aria-labelledby="pj-grid-h">
<div class="pj-wrap">
<div class="pj-head">
<h2 id="pj-grid-h">Our Medical Equipment Installation Projects</h2>
<p>A selection of laboratory and hospital equipment projects we have delivered. Filter by county to see work near you.</p>
</div>

<div class="pj-filter" role="group" aria-label="Filter projects by county">
<button type="button" class="pj-chip" data-county="all" aria-pressed="true">All Kenya</button>
<?php foreach ( $pj_counties as $c ) : ?>
<button type="button" class="pj-chip" data-county="<?php echo esc_attr( $c ); ?>" aria-pressed="false"><?php echo esc_html( $c ); ?></button>
<?php endforeach; ?>
</div>

<div class="pj-grid" id="pj-grid">
<?php foreach ( $pj_projects as $x ) :
    $has = file_exists( $pj_img_dir . $x[4] ); ?>
<article class="pj-card" data-county="<?php echo esc_attr( $x[2] ); ?>">
<div class="pj-card-img">
<span class="pj-tag"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> <?php echo esc_html( $x[2] ); ?></span>
<?php if ( $has ) : ?>
<img src="<?php echo esc_url( $pj_img_url . $x[4] ); ?>" alt="<?php echo esc_attr( $x[0] . ' project in ' . $x[2] . ', Kenya' ); ?>" loading="lazy" width="640" height="480" decoding="async">
<?php else : ?>
<i class="fa-solid <?php echo esc_attr( $x[3] ); ?>" aria-hidden="true"></i>
<?php endif; ?>
</div>
<div class="pj-card-body">
<h3><?php echo esc_html( $x[0] ); ?></h3>
<p><?php echo esc_html( $x[1] ); ?></p>
<div class="pj-loc"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> <?php echo esc_html( $x[2] ); ?> County</div>
</div>
</article>
<?php endforeach; ?>
</div>
</div>
</section>

<!-- WHY -->
<section class="pj-sec alt" aria-labelledby="pj-why-h">
<div class="pj-wrap">
<div class="pj-head"><h2 id="pj-why-h">Why Kenyan Facilities Choose Travotech Agencies</h2></div>
<div class="pj-copy">
<p>Looking for the best supplier of professional, affordable medical and laboratory equipment in Kenya? Travotech Agencies helps hospitals, clinics, pharmacies, schools and laboratories get the right equipment at a fair price, with professional installation and friendly support. Whether you are in Nairobi, Kisumu, Nyeri or another county, we make the process simple from the first call to the final handover.</p>
</div>
<div class="pj-feat">
<div><i class="fa-solid fa-user-doctor" aria-hidden="true"></i><h3>Professional team</h3><p>Experienced staff who understand hospital and laboratory equipment.</p></div>
<div><i class="fa-solid fa-circle-check" aria-hidden="true"></i><h3>Quality products</h3><p>Equipment from trusted manufacturers, checked before it reaches you.</p></div>
<div><i class="fa-solid fa-tags" aria-hidden="true"></i><h3>Affordable prices</h3><p>Clear pricing that works for small clinics and large institutions.</p></div>
<div><i class="fa-solid fa-truck-fast" aria-hidden="true"></i><h3>Delivery nationwide</h3><p>Timely delivery to your facility anywhere in Kenya.</p></div>
</div>
</div>
</section>

<!-- LOCATIONS -->
<section class="pj-sec" aria-labelledby="pj-loc-h">
<div class="pj-wrap">
<div class="pj-head">
<h2 id="pj-loc-h">Medical Equipment Supply and Installation in Kisumu, Nairobi, Nyeri and Beyond</h2>
<p>With our head office in Kahawa and branches in Nairobi and Meru, we serve facilities across the country.</p>
</div>
<div class="pj-locs">
<div><h3><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Nairobi</h3><p>Patient monitors, laboratory analyzers, hospital beds and consumables for hospitals and clinics in Nairobi and its environs.</p></div>
<div><h3><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Kisumu</h3><p>Reliable equipment supply and setup for facilities in Kisumu and the wider Lake Victoria region.</p></div>
<div><h3><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Nyeri</h3><p>Affordable laboratory and hospital equipment, delivered and supported in Nyeri and the Mount Kenya region.</p></div>
<div><h3><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Mombasa</h3><p>Diagnostic and monitoring equipment for coastal hospitals and diagnostic centres.</p></div>
<div><h3><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Nakuru, Eldoret and Thika</h3><p>Professional installation and training for facilities in the Rift Valley and Central Kenya.</p></div>
<div><h3><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Meru and all counties</h3><p>Our Meru branch and delivery network keep every county within reach.</p></div>
</div>
</div>
</section>

<!-- HOW WE DELIVER -->
<section class="pj-sec alt" aria-labelledby="pj-how-h">
<div class="pj-wrap">
<div class="pj-head">
<h2 id="pj-how-h">How We Deliver Every Project</h2>
<p>A simple process that keeps your facility informed at each step.</p>
</div>
<div class="pj-steps">
<div><h3>Tell us your need</h3><p>Share the equipment you want and where your facility is.</p></div>
<div><h3>Get a clear quote</h3><p>We send options and prices that fit your budget.</p></div>
<div><h3>Delivery and setup</h3><p>Our team delivers, installs and tests the equipment.</p></div>
<div><h3>Training and support</h3><p>Your staff learn safe use, and we stay on call to help.</p></div>
</div>
</div>
</section>

<!-- FAQ -->
<section class="pj-sec" aria-labelledby="pj-faq-h">
<div class="pj-wrap">
<div class="pj-head"><h2 id="pj-faq-h">Frequently Asked Questions</h2></div>
<div class="pj-faq">
<?php foreach ( $pj_faq as $q ) : ?>
<details>
<summary><?php echo esc_html( $q[0] ); ?></summary>
<p><?php echo esc_html( $q[1] ); ?></p>
</details>
<?php endforeach; ?>
</div>
</div>
</section>

<!-- CTA -->
<section class="pj-cta" aria-labelledby="pj-cta-h">
<div class="pj-wrap">
<div>
<h2 id="pj-cta-h">Let&rsquo;s Equip Your Facility Together</h2>
<p>Get professional, affordable medical and laboratory equipment services from a trusted partner.</p>
</div>
<div class="pj-cta-btns">
<a class="pj-btn pj-btn-red" href="<?php echo esc_url( $contact ); ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i> Contact us today</a>
<a class="pj-btn pj-btn-ghost" href="https://wa.me/<?php echo esc_attr( $pj_wa ); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> WhatsApp</a>
</div>
</div>
</section>

</main>

<script>
(function(){
    var chips=document.querySelectorAll('.pj-chip'),cards=document.querySelectorAll('.pj-card');
    if(!chips.length)return;
    chips.forEach(function(chip){
        chip.addEventListener('click',function(){
            var c=chip.getAttribute('data-county');
            chips.forEach(function(x){x.setAttribute('aria-pressed',x===chip?'true':'false');});
            cards.forEach(function(card){
                card.hidden=!(c==='all'||card.getAttribute('data-county')===c);
            });
        });
    });
})();
</script>

<?php get_footer(); ?>