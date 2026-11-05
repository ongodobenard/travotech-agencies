<?php
/*
Template Name: Return & Refund Policy
*/

/* ---- Edit these numbers to match your real policy ---- */
$rp_return_days = '7';
$rp_report_hours = '48';
$rp_refund_days = '7 to 10 working days';
$rp_restock = '10%';
$rp_updated = 'November 2026';

$rp_phone_show = '+254 796 038686';
$rp_phone_link = '+254796038686';
$rp_wa = '254796038686';
$rp_email = 'info@travotech.co.ke';
$contact = home_url( '/contact/' );
$shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );

if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) ) {
    add_filter( 'pre_get_document_title', function () {
        return 'Return & Refund Policy | Travotech Agencies Kenya';
    } );
    add_action( 'wp_head', function () {
        echo '<meta name="description" content="' . esc_attr( 'Read the Travotech Agencies return and refund policy for laboratory analyzers, hospital beds, patient monitors, reagents and medical equipment in Kenya, including terms and conditions.' ) . '">' . "\n";
    }, 1 );
}
get_header();
?>
<script type="application/ld+json">
<?php echo wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'WebPage', 'name' => 'Return and Refund Policy', 'url' => get_permalink(), 'publisher' => array( '@type' => 'Organization', 'name' => 'Travotech Agencies Limited', 'url' => home_url( '/' ) ) ), JSON_UNESCAPED_SLASHES ); ?>
</script>

<style>
.rp{--rp-g:var(--th-g,#238a56);--rp-gd:var(--th-gd,#1b6d44);--rp-dk:var(--th-dk,#0c3a27);--rp-red:var(--th-red,#d32f2f);--rp-tint:#eaf6ef;--rp-line:#d6e8de;
font-family:'Inter',system-ui,sans-serif;color:#2b3a33;overflow-x:hidden;}
.rp *,.rp *::before,.rp *::after{box-sizing:border-box;}
.rp h1,.rp h2,.rp h3{font-family:var(--th-fh,'Oswald',sans-serif);color:var(--rp-dk);margin:0;line-height:1.2;letter-spacing:.01em;}
.rp p{margin:0 0 12px;line-height:1.75;font-size:.95rem;}
.rp a{color:var(--rp-gd);}
.rp-wrap{width:100%;max-width:1200px;margin:0 auto;padding:0 5%;}

/* Hero: solid colour with line art */
.rp-hero{position:relative;background:var(--rp-dk);color:#fff;overflow:hidden;}
.rp-hero-art{position:absolute;right:0;top:0;height:100%;width:min(60%,640px);opacity:.9;pointer-events:none;}
.rp-hero-in{position:relative;z-index:2;max-width:1200px;margin:0 auto;padding:clamp(44px,8vw,86px) 5%;}
.rp-hero-txt{max-width:640px;}
.rp-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#fff;font-size:.82rem;font-weight:600;padding:5px 14px;border-radius:6px;margin-bottom:16px;}
.rp .rp-hero h1{color:#fff;font-size:clamp(1.7rem,4.4vw,3rem);margin-bottom:14px;}
.rp-hero-line{display:block;width:70px;height:4px;background:var(--rp-red);border-radius:2px;margin-bottom:16px;}
.rp .rp-hero p{color:rgba(255,255,255,.9);font-size:clamp(.95rem,1.8vw,1.1rem);margin:0;}
.rp-upd{margin-top:16px !important;font-size:.85rem !important;color:#9fe0bf !important;}

/* Summary cards */
.rp-sum{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-top:-34px;position:relative;z-index:3;}
.rp-sum div{background:#fff;border:1px solid var(--rp-line);border-radius:10px;padding:18px 16px;box-shadow:0 8px 22px rgba(12,58,39,.10);}
.rp-sum i{font-size:1.5rem;color:var(--rp-g);margin-bottom:8px;display:block;}
.rp-sum b{display:block;font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--rp-dk);font-size:1.02rem;margin-bottom:4px;}
.rp-sum span{font-size:.85rem;line-height:1.55;display:block;}

/* Layout */
.rp-layout{display:grid;grid-template-columns:270px 1fr;gap:34px;align-items:start;padding:40px 0 20px;}
.rp-toc{position:sticky;top:20px;background:var(--rp-tint);border:1px solid var(--rp-line);border-radius:10px;padding:18px;}
.rp-toc h2{font-size:1.1rem;margin-bottom:10px;}
.rp-toc ol{margin:0;padding:0;list-style:none;counter-reset:toc;display:grid;gap:2px;}
.rp-toc li{counter-increment:toc;}
.rp-toc a{display:flex;gap:8px;padding:6px 8px;border-radius:6px;text-decoration:none;font-size:.88rem;color:var(--rp-dk);font-weight:500;}
.rp-toc a::before{content:counter(toc) ".";color:var(--rp-g);font-weight:700;min-width:20px;}
.rp-toc a:hover{background:#fff;}

.rp-body section{padding:0 0 26px;margin-bottom:26px;border-bottom:1px solid var(--rp-line);scroll-margin-top:90px;}
.rp-body section:last-of-type{border-bottom:0;margin-bottom:0;padding-bottom:0;}
.rp-body h2{font-size:clamp(1.3rem,2.6vw,1.7rem);margin-bottom:12px;display:flex;align-items:center;gap:10px;}
.rp-body h2 i{color:var(--rp-g);font-size:1.2rem;}
.rp-body ul{margin:0 0 12px;padding-left:0;list-style:none;display:grid;gap:8px;}
.rp-body li{display:flex;gap:10px;align-items:flex-start;font-size:.95rem;line-height:1.6;}
.rp-body li i{margin-top:5px;color:var(--rp-g);flex-shrink:0;}
.rp-body li i.rp-no{color:var(--rp-red);}
.rp-note{background:#fff7e6;border-left:4px solid #e8a317;border-radius:6px;padding:12px 14px;font-size:.9rem;margin:12px 0;}
.rp-steps{counter-reset:st;display:grid;gap:12px;margin:0 0 12px;padding:0;list-style:none;}
.rp-steps li{counter-increment:st;display:flex;gap:14px;align-items:flex-start;background:var(--rp-tint);border:1px solid var(--rp-line);border-radius:10px;padding:14px;}
.rp-steps li::before{content:counter(st);flex:0 0 34px;height:34px;border-radius:50%;background:var(--rp-g);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;}

/* Contact */
.rp-contact{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:12px;}
.rp-contact a{display:flex;gap:12px;align-items:center;background:#fff;border:1px solid var(--rp-line);border-radius:10px;padding:14px;text-decoration:none;color:var(--rp-dk);font-weight:600;font-size:.9rem;word-break:break-word;}
.rp-contact i{width:40px;height:40px;border-radius:50%;background:var(--rp-g);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.rp-contact small{display:block;font-weight:400;color:#5a6b62;}

/* CTA */
.rp-cta{background:var(--rp-red);color:#fff;border-radius:12px;padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:20px;margin:10px 0 36px;}
.rp .rp-cta h2{color:#fff;font-size:clamp(1.2rem,2.4vw,1.6rem);margin-bottom:4px;}
.rp .rp-cta p{margin:0;color:#fff;font-size:.9rem;}
.rp-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:6px;font-weight:700;font-size:.9rem;text-decoration:none;background:#fff;color:var(--rp-dk) !important;white-space:nowrap;}
.rp-btn:hover{background:var(--rp-tint);}

@media (max-width:1000px){
.rp-sum{grid-template-columns:repeat(2,1fr);}
.rp-layout{grid-template-columns:1fr;gap:22px;padding-top:28px;}
.rp-toc{position:static;}
.rp-toc ol{grid-template-columns:repeat(2,1fr);}
.rp-hero-art{opacity:.45;width:70%;}
}
@media (max-width:640px){
.rp-sum{grid-template-columns:1fr;margin-top:-24px;}
.rp-toc ol{grid-template-columns:1fr;}
.rp-contact{grid-template-columns:1fr;}
.rp-cta{flex-direction:column;text-align:center;}
.rp-hero-art{opacity:.3;width:100%;}
}

/* ---- Refund v2 ---- */
.rp-body li i.rp-dot{font-size:.45rem;margin-top:10px;color:var(--rp-g);}
</style>

<main class="rp">

<header class="rp-hero">
<svg class="rp-hero-art" viewBox="0 0 640 320" preserveAspectRatio="xMaxYMid slice" aria-hidden="true" focusable="false">
<circle cx="520" cy="110" r="150" fill="none" stroke="#ffffff" stroke-opacity=".10" stroke-width="2"/>
<circle cx="520" cy="110" r="100" fill="none" stroke="#ffffff" stroke-opacity=".10" stroke-width="2"/>
<circle cx="520" cy="110" r="52" fill="#ffffff" fill-opacity=".06"/>
<path d="M508 80h24v22h22v24h-22v22h-24v-22h-22v-24h22z" fill="#5fd39a" fill-opacity=".35"/>
<path d="M60 230h130l22-46 34 96 30-120 26 70h60l18-30h90l22 30h120" fill="none" stroke="#5fd39a" stroke-opacity=".55" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M300 40h14v14h14v14h-14v14h-14V68h-14V54h14z" fill="#ffffff" fill-opacity=".14"/>
<path d="M580 250h10v10h10v10h-10v10h-10v-10h-10v-10h10z" fill="#d32f2f" fill-opacity=".55"/>
<circle cx="140" cy="70" r="6" fill="#5fd39a" fill-opacity=".5"/>
<circle cx="410" cy="270" r="9" fill="#ffffff" fill-opacity=".14"/>
</svg>
<div class="rp-hero-in">
<div class="rp-hero-txt">
<span class="rp-badge"><i class="fa-solid fa-rotate-left" aria-hidden="true"></i> Customer policy</span>
<h1>Return &amp; Refund Policy for Medical and Laboratory Equipment in Kenya</h1>
<span class="rp-hero-line"></span>
<p>Buy with confidence from Travotech Agencies Limited. This page explains how returns, refunds and exchanges work for hematology and chemistry analyzers, hospital beds, patient monitors, reagents and other medical supplies, together with our terms and conditions.</p>
<p class="rp-upd"><i class="fa-regular fa-calendar" aria-hidden="true"></i> Last updated: <?php echo esc_html( $rp_updated ); ?></p>
</div>
</div>
</header>

<div class="rp-wrap">

<div class="rp-sum">
<div><i class="fa-solid fa-box-open" aria-hidden="true"></i><b>Report within <?php echo esc_html( $rp_report_hours ); ?> hours</b><span>Tell us about damaged or wrong items within <?php echo esc_html( $rp_report_hours ); ?> hours of delivery.</span></div>
<div><i class="fa-solid fa-rotate-left" aria-hidden="true"></i><b><?php echo esc_html( $rp_return_days ); ?>-day return window</b><span>Unused equipment in original packaging can be returned within <?php echo esc_html( $rp_return_days ); ?> days.</span></div>
<div><i class="fa-solid fa-vial" aria-hidden="true"></i><b>Reagents and tests</b><span>Returned only when faulty or wrong, and only if sealed and in date.</span></div>
<div><i class="fa-solid fa-money-bill-transfer" aria-hidden="true"></i><b>Refund in <?php echo esc_html( $rp_refund_days ); ?></b><span>Approved refunds go back to your original payment method.</span></div>
</div>

<div class="rp-layout">

<aside class="rp-toc" aria-label="Page contents">
<h2>On this page</h2>
<ol>
<li><a href="#overview">Overview</a></li>
<li><a href="#eligible">What can be returned</a></li>
<li><a href="#not-eligible">What cannot be returned</a></li>
<li><a href="#damaged">Damaged or wrong items</a></li>
<li><a href="#how">How to return an item</a></li>
<li><a href="#refunds">Refunds</a></li>
<li><a href="#exchanges">Exchanges</a></li>
<li><a href="#warranty">Warranty and support</a></li>
<li><a href="#cancel">Order cancellations</a></li>
<li><a href="#terms">Terms and conditions</a></li>
<li><a href="#contact">Contact us</a></li>
</ol>
</aside>

<div class="rp-body">

<section id="overview">
<h2><i class="fa-solid fa-circle-info" aria-hidden="true"></i> Overview</h2>
<p>Travotech Agencies Limited supplies laboratory equipment, patient monitoring, hospital furniture and medical consumables to hospitals, clinics, pharmacies, schools and laboratories across Kenya. Many of our products are clinical items, so some have stricter return rules to keep patients and staff safe.</p>
<p>By placing an order with us you agree to this policy and to the terms and conditions below.</p>
</section>

<section id="eligible">
<h2><i class="fa-solid fa-box-open" aria-hidden="true"></i> What can be returned</h2>
<p>You may ask to return equipment such as analyzers, patient monitors, hospital beds, examination couches and trolleys when all of the following apply:</p>
<ul>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> You contact us within <?php echo esc_html( $rp_return_days ); ?> days of delivery.</li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> The item is unused, undamaged and has not been installed or commissioned.</li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> It is in its original packaging with all accessories, manuals and seals.</li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> You can show your order number or proof of purchase.</li>
</ul>
</section>

<section id="not-eligible">
<h2><i class="fa-solid fa-ban" aria-hidden="true"></i> What cannot be returned</h2>
<ul>
<li><i class="fa-solid fa-xmark rp-no" aria-hidden="true"></i> Reagents, lyse solutions and calibrators once opened, or if the cold chain or storage conditions were not kept after delivery.</li>
<li><i class="fa-solid fa-xmark rp-no" aria-hidden="true"></i> Rapid test kits and other diagnostic consumables once the pack is opened.</li>
<li><i class="fa-solid fa-xmark rp-no" aria-hidden="true"></i> Disinfectants and surgical spirit once opened or used.</li>
<li><i class="fa-solid fa-xmark rp-no" aria-hidden="true"></i> Equipment that has been installed, used, repaired or modified by anyone other than our team or an approved engineer.</li>
<li><i class="fa-solid fa-xmark rp-no" aria-hidden="true"></i> Special orders and items imported or configured for your specific request.</li>
<li><i class="fa-solid fa-xmark rp-no" aria-hidden="true"></i> Items damaged through misuse, wrong voltage, poor storage or failure to follow the manufacturer's instructions.</li>
</ul>
<div class="rp-note"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> For safety and quality reasons, we cannot accept returned items that have been in contact with patients, blood or other samples.</div>
</section>

<section id="damaged">
<h2><i class="fa-solid fa-truck-medical" aria-hidden="true"></i> Damaged, defective or wrong items</h2>
<p>Please check your order while the delivery person is with you. If something is damaged, missing or not what you ordered:</p>
<ul>
<li><i class="fa-solid fa-camera" aria-hidden="true"></i> Contact us within <?php echo esc_html( $rp_report_hours ); ?> hours of delivery.</li>
<li><i class="fa-solid fa-camera" aria-hidden="true"></i> Send clear photos or a short video of the item, the packaging and the delivery note.</li>
<li><i class="fa-solid fa-camera" aria-hidden="true"></i> Keep all packaging until we have inspected the item.</li>
</ul>
<p>If the fault is confirmed, we will repair, replace or refund the item at no cost to you, including the return transport.</p>
</section>

<section id="how">
<h2><i class="fa-solid fa-clipboard-list" aria-hidden="true"></i> How to return an item</h2>
<ol class="rp-steps">
<li><div><b>Contact us.</b> Call, email or message us on WhatsApp with your order number, the product name and the reason for the return.</div></li>
<li><div><b>Get approval.</b> Our team reviews your request and replies with a return authorisation and instructions. Please do not send anything back before this.</div></li>
<li><div><b>Pack it safely.</b> Use the original packaging and include all accessories, manuals and the delivery note.</div></li>
<li><div><b>Send or hand it over.</b> We will arrange collection or tell you where to deliver it.</div></li>
<li><div><b>Inspection.</b> We check the item on arrival and confirm the outcome by email or phone.</div></li>
</ol>
</section>

<section id="refunds">
<h2><i class="fa-solid fa-money-bill-transfer" aria-hidden="true"></i> Refunds</h2>
<ul>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> Approved refunds are paid to your original payment method, for example M-Pesa, bank transfer or card, within <?php echo esc_html( $rp_refund_days ); ?> after inspection.</li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> Returns that are not caused by a fault may be charged a restocking fee of up to <?php echo esc_html( $rp_restock ); ?> of the product price, plus the cost of return transport.</li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> Faulty, damaged or wrong items are refunded in full, including delivery charges.</li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> Your bank or mobile money provider may need extra time to show the money in your account.</li>
</ul>
</section>

<section id="exchanges">
<h2><i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i> Exchanges</h2>
<p>If you ordered the wrong model or size, we can exchange it for another product when stock is available. Any price difference is paid by you or refunded to you. The same conditions as returns apply, including the <?php echo esc_html( $rp_return_days ); ?>-day window.</p>
</section>

<section id="warranty">
<h2><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Warranty and support</h2>
<p>Equipment comes with the manufacturer's warranty, and the period is stated on the product page or your quotation. Warranty covers manufacturing faults under normal use. It does not cover damage from misuse, unauthorised repairs, power surges or lack of routine maintenance.</p>
<p>For installation, training or technical help, <a href="<?php echo esc_url( $contact ); ?>">contact our team</a> and we will guide you.</p>
</section>

<section id="cancel">
<h2><i class="fa-solid fa-circle-xmark" aria-hidden="true"></i> Order cancellations</h2>
<p>You can cancel an order before it is dispatched at no charge. Once it has shipped, the return rules above apply. Special orders cannot be cancelled after we have placed them with the supplier.</p>
</section>

<section id="terms">
<h2><i class="fa-solid fa-file-contract" aria-hidden="true"></i> Terms and conditions</h2>
<ul>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> <span><b>Orders and prices.</b> Prices are in Kenya shillings and may change without notice. An order is confirmed when we accept it and, where needed, receive payment.</span></li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> <span><b>Availability.</b> We work hard to keep stock accurate. If an item is unavailable we will offer a replacement, a later delivery date or a full refund.</span></li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> <span><b>Delivery.</b> Delivery times are estimates. Risk passes to you once the goods are delivered and signed for.</span></li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> <span><b>Proper use.</b> Medical and laboratory equipment must be used by trained staff following the manufacturer's instructions and local regulations. You are responsible for choosing products suitable for your facility.</span></li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> <span><b>Liability.</b> Our liability for any claim is limited to the price paid for the product concerned, except where the law does not allow this limit.</span></li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> <span><b>Changes to this policy.</b> We may update this page from time to time. The version on the site when you order is the one that applies to your order.</span></li>
<li><i class="fa-solid fa-circle rp-dot" aria-hidden="true"></i> <span><b>Governing law.</b> These terms are governed by the laws of the Republic of Kenya.</span></li>
</ul>
</section>

<section id="contact">
<h2><i class="fa-solid fa-headset" aria-hidden="true"></i> Contact us</h2>
<p>Questions about a return or refund? Reach our team and quote your order number.</p>
<div class="rp-contact">
<a href="tel:<?php echo esc_attr( $rp_phone_link ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><span><small>Call us</small><?php echo esc_html( $rp_phone_show ); ?></span></a>
<a href="mailto:<?php echo esc_attr( $rp_email ); ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i><span><small>Email us</small><?php echo esc_html( $rp_email ); ?></span></a>
<a href="https://wa.me/<?php echo esc_attr( $rp_wa ); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><span><small>WhatsApp</small>Chat with us</span></a>
</div>
</section>

</div>
</div>

<div class="rp-cta">
<div>
<h2>Need help with an order?</h2>
<p>Our team will guide you on returns, refunds and choosing the right equipment.</p>
</div>
<a class="rp-btn" href="<?php echo esc_url( $contact ); ?>">Contact Us <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
</div>

</div>
</main>

<?php get_footer(); ?>