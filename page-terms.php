<?php
/*
Template Name: Terms & Conditions
*/

/* ---- Edit these to match your business ---- */
$tm_updated = 'November 2026';
$tm_phone_show = '+254 796 038686';
$tm_phone_link = '+254796038686';
$tm_wa = '254796038686';
$tm_email = 'info@travotech.co.ke';
$contact = home_url( '/contact/' );
$refund = home_url( '/return-refund-policy/' ); /* change if your refund page uses another URL */

if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) ) {
    add_filter( 'pre_get_document_title', function () {
        return 'Terms & Conditions | Travotech Agencies Kenya';
    } );
    add_action( 'wp_head', function () {
        echo '<meta name="description" content="' . esc_attr( 'Read the Travotech Agencies terms and conditions for buying laboratory analyzers, hospital beds, patient monitors, reagents and medical equipment in Kenya.' ) . '">' . "\n";
    }, 1 );
}
get_header();
?>
<script type="application/ld+json">
<?php echo wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'WebPage', 'name' => 'Terms and Conditions', 'url' => get_permalink(), 'publisher' => array( '@type' => 'Organization', 'name' => 'Travotech Agencies Limited', 'url' => home_url( '/' ) ) ), JSON_UNESCAPED_SLASHES ); ?>
</script>

<style>
.tm{--tm-g:var(--th-g,#0d4fc8);--tm-gd:var(--th-gd,#0a41a6);--tm-dk:var(--th-dk,#031a42);--tm-red:var(--th-red,#d32f2f);--tm-tint:#e6edfa;--tm-line:#cddaf1;
font-family:'Inter',system-ui,sans-serif;color:#1d2c48;overflow-x:hidden;}
.tm *,.tm *::before,.tm *::after{box-sizing:border-box;}
.tm h1,.tm h2,.tm h3{font-family:var(--th-fh,'Oswald',sans-serif);color:var(--tm-dk);margin:0;line-height:1.2;letter-spacing:.01em;}
.tm p{margin:0 0 12px;line-height:1.75;font-size:.95rem;}
.tm a{color:var(--tm-gd);}
.tm-wrap{width:100%;max-width:1200px;margin:0 auto;padding:0 5%;}

/* Hero */
.tm-hero{position:relative;background:var(--tm-dk);color:#fff;overflow:hidden;}
.tm-hero-in{position:relative;z-index:2;max-width:1200px;margin:0 auto;padding:clamp(44px,8vw,86px) 5%;}
.tm-hero-txt{max-width:640px;}
.tm-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#fff;font-size:.82rem;font-weight:600;padding:5px 14px;border-radius:6px;margin-bottom:16px;}
.tm .tm-hero h1{color:#fff;font-size:clamp(1.7rem,4.4vw,3rem);margin-bottom:14px;}
.tm-hero-line{display:block;width:70px;height:4px;background:var(--tm-red);border-radius:2px;margin-bottom:16px;}
.tm .tm-hero p{color:rgba(255,255,255,.9);font-size:clamp(.95rem,1.8vw,1.1rem);margin:0;}
.tm .tm-upd{margin-top:16px;font-size:.85rem;color:#8db0f2;}

/* Hero art: dotted grid, tilted square and icon tiles */
.tm-art{position:absolute;right:0;top:0;height:100%;width:min(58%,660px);pointer-events:none;overflow:hidden;}
.tm-art::before{content:"";position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.22) 1.5px,transparent 1.6px);background-size:22px 22px;-webkit-mask-image:linear-gradient(90deg,transparent 0,#000 60%);mask-image:linear-gradient(90deg,transparent 0,#000 60%);}
.tm-sq{position:absolute;right:8%;top:50%;width:min(300px,42vw);height:min(300px,42vw);border:2px solid rgba(141,176,242,.35);border-radius:28px;transform:translateY(-50%) rotate(14deg);}
.tm-sq2{right:14%;width:min(210px,30vw);height:min(210px,30vw);border-color:rgba(255,255,255,.14);transform:translateY(-50%) rotate(-10deg);}
.tm-tile{position:absolute;display:flex;align-items:center;justify-content:center;border-radius:20px;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.2);color:#fff;box-shadow:0 10px 26px rgba(0,0,0,.18);}
.tm-t1{right:22%;top:50%;transform:translateY(-50%);width:clamp(86px,11vw,132px);height:clamp(86px,11vw,132px);font-size:clamp(2.2rem,4.6vw,3.6rem);background:var(--tm-g);border-color:rgba(255,255,255,.35);}
.tm-t2{right:5%;top:16%;width:clamp(54px,6.4vw,78px);height:clamp(54px,6.4vw,78px);font-size:clamp(1.3rem,2.6vw,2rem);}
.tm-t3{right:42%;top:14%;width:clamp(46px,5.4vw,66px);height:clamp(46px,5.4vw,66px);font-size:clamp(1.1rem,2.2vw,1.7rem);color:#8db0f2;}
.tm-t4{right:6%;bottom:14%;width:clamp(50px,6vw,72px);height:clamp(50px,6vw,72px);font-size:clamp(1.2rem,2.4vw,1.8rem);}
.tm-t5{right:44%;bottom:12%;width:clamp(42px,5vw,60px);height:clamp(42px,5vw,60px);font-size:clamp(1rem,2vw,1.5rem);background:var(--tm-red);border-color:rgba(255,255,255,.3);}

/* Summary cards */
.tm-sum{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-top:-34px;position:relative;z-index:5;}
.tm-sum div{background:#fff;border:1px solid var(--tm-line);border-radius:10px;padding:18px 16px;box-shadow:0 8px 22px rgba(3,26,66,.10);}
.tm-sum i{font-size:1.5rem;color:var(--tm-g);margin-bottom:8px;display:block;}
.tm-sum b{display:block;font-family:var(--th-fh,'Oswald',sans-serif);font-weight:500;color:var(--tm-dk);font-size:1.02rem;margin-bottom:4px;}
.tm-sum span{font-size:.85rem;line-height:1.55;display:block;}

/* Layout */
.tm-layout{display:grid;grid-template-columns:270px 1fr;gap:34px;align-items:start;padding:40px 0 20px;}
.tm-toc{position:sticky;top:20px;background:var(--tm-tint);border:1px solid var(--tm-line);border-radius:10px;padding:18px;}
.tm-toc h2{font-size:1.1rem;margin-bottom:10px;}
.tm-toc ol{margin:0;padding:0;list-style:none;counter-reset:toc;display:grid;gap:2px;}
.tm-toc li{counter-increment:toc;}
.tm-toc a{display:flex;gap:8px;padding:6px 8px;border-radius:6px;text-decoration:none;font-size:.88rem;color:var(--tm-dk);font-weight:500;}
.tm-toc a::before{content:counter(toc) ".";color:var(--tm-g);font-weight:700;min-width:20px;}
.tm-toc a:hover{background:#fff;}

.tm-body section{padding:0 0 26px;margin-bottom:26px;border-bottom:1px solid var(--tm-line);scroll-margin-top:90px;}
.tm-body section:last-of-type{border-bottom:0;margin-bottom:0;padding-bottom:0;}
.tm-body h2{font-size:clamp(1.3rem,2.6vw,1.7rem);margin-bottom:12px;display:flex;align-items:center;gap:10px;}
.tm-body h2 i{color:var(--tm-g);font-size:1.2rem;}
.tm-body ul{margin:0 0 12px;padding-left:0;list-style:none;display:grid;gap:8px;}
.tm-body li{display:flex;gap:10px;align-items:flex-start;font-size:.95rem;line-height:1.6;}
.tm-body li i{font-size:.45rem;margin-top:10px;color:var(--tm-g);flex-shrink:0;}
.tm-note{background:#fff7e6;border-left:4px solid #e8a317;border-radius:6px;padding:12px 14px;font-size:.9rem;margin:12px 0;}

/* Contact */
.tm-contact{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:12px;}
.tm-contact a{display:flex;gap:12px;align-items:center;background:#fff;border:1px solid var(--tm-line);border-radius:10px;padding:14px;text-decoration:none;color:var(--tm-dk);font-weight:600;font-size:.9rem;word-break:break-word;}
.tm-contact i{width:40px;height:40px;border-radius:50%;background:var(--tm-g);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.tm-contact small{display:block;font-weight:400;color:#5a6b62;}

/* CTA */
.tm-cta{background:var(--tm-red);color:#fff;border-radius:12px;padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:20px;margin:10px 0 36px;}
.tm .tm-cta h2{color:#fff;font-size:clamp(1.2rem,2.4vw,1.6rem);margin-bottom:4px;}
.tm .tm-cta p{margin:0;color:#fff;font-size:.9rem;}
.tm .tm-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:6px;font-weight:700;font-size:.9rem;text-decoration:none;background:#fff;color:var(--tm-dk);white-space:nowrap;}
.tm .tm-btn:hover{background:var(--tm-tint);}

@media (max-width:1000px){
.tm-sum{grid-template-columns:repeat(2,1fr);}
.tm-layout{grid-template-columns:1fr;gap:22px;padding-top:28px;}
.tm-toc{position:static;}
.tm-toc ol{grid-template-columns:repeat(2,1fr);}
.tm-art{opacity:.5;width:75%;}
}
@media (max-width:640px){
.tm-sum{grid-template-columns:1fr;margin-top:-24px;}
.tm-toc ol{grid-template-columns:1fr;}
.tm-contact{grid-template-columns:1fr;}
.tm-cta{flex-direction:column;text-align:center;}
.tm-art{opacity:.3;width:100%;}
.tm-t3,.tm-t5{display:none;}
}
</style>

<main class="tm">

<div class="tm-hero">
<div class="tm-art" aria-hidden="true">
<span class="tm-sq"></span>
<span class="tm-sq tm-sq2"></span>
<span class="tm-tile tm-t1"><i class="fa-solid fa-file-contract"></i></span>
<span class="tm-tile tm-t2"><i class="fa-solid fa-scale-balanced"></i></span>
<span class="tm-tile tm-t3"><i class="fa-solid fa-handshake"></i></span>
<span class="tm-tile tm-t4"><i class="fa-solid fa-lock"></i></span>
<span class="tm-tile tm-t5"><i class="fa-solid fa-check"></i></span>
</div>
<div class="tm-hero-in">
<div class="tm-hero-txt">
<span class="tm-badge"><i class="fa-solid fa-file-contract" aria-hidden="true"></i> Legal</span>
<h1>Terms &amp; Conditions for Buying Medical and Laboratory Equipment in Kenya</h1>
<span class="tm-hero-line"></span>
<p>These simple terms explain how you can use our website and buy from Travotech Agencies Limited. Please read them before you place an order.</p>
<p class="tm-upd"><i class="fa-regular fa-calendar" aria-hidden="true"></i> Last updated: <?php echo esc_html( $tm_updated ); ?></p>
</div>
</div>
</div>

<div class="tm-wrap">

<div class="tm-sum">
<div><i class="fa-solid fa-circle-check" aria-hidden="true"></i><b>Easy to follow</b><span>Short, plain terms. No hidden conditions.</span></div>
<div><i class="fa-solid fa-credit-card" aria-hidden="true"></i><b>Clear payment</b><span>Prices in Kenya shillings, paid before dispatch unless agreed.</span></div>
<div><i class="fa-solid fa-truck-fast" aria-hidden="true"></i><b>Delivery in Kenya</b><span>We deliver to hospitals, clinics and labs across the country.</span></div>
<div><i class="fa-solid fa-scale-balanced" aria-hidden="true"></i><b>Kenyan law</b><span>These terms are governed by the laws of Kenya.</span></div>
</div>

<div class="tm-layout">

<aside class="tm-toc" aria-label="Page contents">
<h2>On this page</h2>
<ol>
<li><a href="#about">About these terms</a></li>
<li><a href="#website">Using our website</a></li>
<li><a href="#products">Products and information</a></li>
<li><a href="#orders">Orders and prices</a></li>
<li><a href="#payment">Payment</a></li>
<li><a href="#delivery">Delivery</a></li>
<li><a href="#returns">Returns and refunds</a></li>
<li><a href="#use">Proper use of equipment</a></li>
<li><a href="#liability">Liability</a></li>
<li><a href="#privacy">Privacy</a></li>
<li><a href="#changes">Changes and law</a></li>
<li><a href="#contact">Contact us</a></li>
</ol>
</aside>

<div class="tm-body">

<section id="about">
<h2><i class="fa-solid fa-circle-info" aria-hidden="true"></i> About these terms</h2>
<p>Travotech Agencies Limited supplies laboratory equipment, patient monitoring, hospital furniture and medical consumables to hospitals, clinics, pharmacies, schools and laboratories across Kenya.</p>
<p>By using this website or placing an order, you agree to these terms. If you do not agree, please do not use the site or place an order.</p>
</section>

<section id="website">
<h2><i class="fa-solid fa-globe" aria-hidden="true"></i> Using our website</h2>
<ul>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> Use the site only for lawful purposes and to find or buy our products.</li>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> Give correct information when you contact us or place an order.</li>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> Do not try to damage the site, copy its data or interfere with how it works.</li>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> All text, images and logos on this site belong to Travotech Agencies or its partners. Please do not copy them without our permission.</li>
</ul>
</section>

<section id="products">
<h2><i class="fa-solid fa-microscope" aria-hidden="true"></i> Products and information</h2>
<p>We try to keep product descriptions, images and specifications accurate. Small differences can happen, because manufacturers update their products. If you need exact details for your facility, ask us before you order and we will confirm them in writing.</p>
</section>

<section id="orders">
<h2><i class="fa-solid fa-cart-shopping" aria-hidden="true"></i> Orders and prices</h2>
<ul>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> Prices are in Kenya shillings and may change without notice.</li>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> An order is confirmed only when we accept it and, where needed, receive payment.</li>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> If an item is out of stock, we will offer a replacement, a later delivery date or a full refund.</li>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> We may cancel an order if there is a pricing error or we cannot supply the item. You will be refunded in full.</li>
</ul>
</section>

<section id="payment">
<h2><i class="fa-solid fa-credit-card" aria-hidden="true"></i> Payment</h2>
<p>We accept payment by M-Pesa, bank transfer and other methods shown at checkout or on your quotation. Unless we agree otherwise in writing, payment is due before dispatch. Large orders may need a deposit.</p>
</section>

<section id="delivery">
<h2><i class="fa-solid fa-truck-fast" aria-hidden="true"></i> Delivery</h2>
<ul>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> Delivery times are estimates and can change because of stock, transport or weather.</li>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> Please check your goods when they arrive and report any damage straight away.</li>
<li><i class="fa-solid fa-circle" aria-hidden="true"></i> Risk passes to you once the goods are delivered and signed for.</li>
</ul>
</section>

<section id="returns">
<h2><i class="fa-solid fa-rotate-left" aria-hidden="true"></i> Returns and refunds</h2>
<p>Our <a href="<?php echo esc_url( $refund ); ?>">Return &amp; Refund Policy</a> explains what can be returned, how long you have and how refunds are paid. It forms part of these terms.</p>
</section>

<section id="use">
<h2><i class="fa-solid fa-user-doctor" aria-hidden="true"></i> Proper use of equipment</h2>
<p>Medical and laboratory equipment must be used by trained staff and in line with the manufacturer&rsquo;s instructions and local regulations. You are responsible for choosing products that suit your facility.</p>
<div class="tm-note"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Our website and staff give product information, not medical advice. Always follow your own clinical and safety procedures.</div>
</section>

<section id="liability">
<h2><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Liability</h2>
<p>Equipment comes with the manufacturer&rsquo;s warranty, as stated on the product page or your quotation. Our liability for any claim is limited to the price paid for the product concerned, except where the law does not allow this limit. We are not responsible for delays or losses caused by events outside our control.</p>
</section>

<section id="privacy">
<h2><i class="fa-solid fa-lock" aria-hidden="true"></i> Privacy</h2>
<p>We use your name, phone number, email and address only to reply to you, process orders and arrange delivery. We do not sell your details. We share them only with partners who help us deliver or support your order, or when the law requires it.</p>
</section>

<section id="changes">
<h2><i class="fa-solid fa-gavel" aria-hidden="true"></i> Changes and governing law</h2>
<p>We may update these terms from time to time. The version on the site when you order is the one that applies to your order. These terms are governed by the laws of the Republic of Kenya, and the Kenyan courts will handle any dispute.</p>
</section>

<section id="contact">
<h2><i class="fa-solid fa-headset" aria-hidden="true"></i> Contact us</h2>
<p>Questions about these terms? Reach our team and we will be happy to help.</p>
<div class="tm-contact">
<a href="tel:<?php echo esc_attr( $tm_phone_link ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><span><small>Call us</small><?php echo esc_html( $tm_phone_show ); ?></span></a>
<a href="mailto:<?php echo esc_attr( $tm_email ); ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i><span><small>Email us</small><?php echo esc_html( $tm_email ); ?></span></a>
<a href="https://wa.me/<?php echo esc_attr( $tm_wa ); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><span><small>WhatsApp</small>Chat with us</span></a>
</div>
</section>

</div>
</div>

<div class="tm-cta">
<div>
<h2>Need help with an order?</h2>
<p>Our team will guide you on terms, delivery and choosing the right equipment.</p>
</div>
<a class="tm-btn" href="<?php echo esc_url( $contact ); ?>">Contact Us <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
</div>

</div>
</main>

<?php get_footer(); ?>