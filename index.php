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
$hp_card = function ( $p ) {
	$name = $p->get_name();
	$url  = get_permalink( $p->get_id() );
	?>
	<article class="hp-card">
		<a class="hp-card-img" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $name ); ?>">
			<?php if ( $p->is_on_sale() ) : ?><span class="hp-sale">Sale</span><?php endif; ?>
			<?php echo $p->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'alt' => $name ) ); // phpcs:ignore ?>
		</a>
		<div class="hp-card-body">
			<h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $name ); ?></a></h3>
			<div class="hp-price"><?php echo wp_kses_post( $p->get_price_html() ); ?></div>
			<a class="hp-btn hp-btn-sm" href="<?php echo esc_url( $url ); ?>"><i class="fa-solid fa-eye" aria-hidden="true"></i> View details</a>
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
.hp-head p{margin:10px 0 0;color:#2ab2b0;}
.hp-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 26px;border-radius:6px;font:600 14px var(--th-fh,'Oswald',sans-serif);letter-spacing:.04em;text-transform:uppercase;background:var(--th-g,#2dbebc);color:#fff;border:2px solid var(--th-g,#2dbebc);transition:background .2s,border-color .2s;}
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
.hp-hero::before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,rgba(7,47,47,.92) 0%,rgba(7,47,47,.78) 45%,rgba(7,47,47,.15) 100%);}
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
.hp-trust i{font-size:1.6rem;color:var(--th-g,#2dbebc);}

/* Categories */
.hp-cats{display:grid;grid-template-columns:repeat(6,1fr);gap:16px;}
.hp-cat{display:flex;flex-direction:column;background:#fff;border:1px solid #d7f0f0;border-radius:10px;overflow:hidden;box-shadow:0 2px 10px rgba(9,60,60,.06);transition:transform .2s,box-shadow .2s;}
.hp-cat:hover{transform:translateY(-3px);box-shadow:0 8px 22px rgba(9,60,60,.16);}
.hp-cat-img{aspect-ratio:1/1;background:#f1fafa;display:flex;align-items:center;justify-content:center;padding:10px;}
.hp-cat-img img{width:100%;height:100%;object-fit:contain;}
.hp-cat-img i{font-size:2.6rem;color:var(--th-g,#2dbebc);opacity:.4;}
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
.hp-card h3 a:hover{color:var(--th-g,#2dbebc);}
.hp-price{margin-top:auto;font-weight:800;color:var(--th-g,#2dbebc);}
.hp-price del{color:#9aa3ad;font-weight:500;margin-right:6px;}
.hp-price ins{text-decoration:none;}

/* About */
.hp-about{display:grid;grid-template-columns:1fr 1fr;gap:clamp(24px,5vw,56px);align-items:center;}
.hp-about img{width:100%;border-radius:12px;box-shadow:0 10px 30px rgba(9,60,60,.18);display:block;}
.hp-about h2{margin-bottom:14px;}
.hp-about p{margin:0 0 14px;color:#239391;}
.hp-ticks{list-style:none;margin:0 0 22px;padding:0;display:grid;gap:8px;}
.hp-ticks li{display:flex;gap:10px;align-items:flex-start;}
.hp-ticks i{color:var(--th-g,#2dbebc);margin-top:5px;}

/* Why us */
.hp-why{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
.hp-why div{background:#fff;border-radius:10px;padding:24px 20px;text-align:center;border:1px solid #d7f0f0;}
.hp-why i{font-size:2rem;color:var(--th-g,#2dbebc);margin-bottom:12px;}
.hp-why h3{font-size:1.1rem;margin-bottom:8px;}
.hp-why p{margin:0;font-size:.92rem;color:#2ab2b0;}

/* Reviews */
.hp-rev{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.hp-rev blockquote{margin:0;background:#fff;border:1px solid #d7f0f0;border-left:4px solid var(--th-red,#e53935);border-radius:10px;padding:24px;display:flex;flex-direction:column;gap:16px;height:100%;}
.hp-rev blockquote>i{font-size:1.6rem;color:var(--th-g,#2dbebc);opacity:.5;}
.hp-rev blockquote p{margin:0;color:#239391;}
.hp-rev footer{margin-top:auto;display:flex;flex-direction:column;}
.hp-rev strong{color:var(--th-dk,#093c3c);}
.hp-rev span{font-size:.85rem;color:#6b7280;}

/* CTA */
.hp-cta{background:linear-gradient(135deg,var(--th-nv,#072f2f),var(--th-g,#2dbebc));color:#fff;padding:clamp(30px,5vw,48px) 0;border-top:4px solid var(--th-red,#e53935);}
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
	.hp-hero::before{background:linear-gradient(180deg,rgba(7,47,47,.85),rgba(7,47,47,.7));}
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

	<!-- REVIEWS (no stars) -->
	<section class="hp-sec alt" aria-labelledby="hp-rev-h">
		<div class="hp-wrap">
			<div class="hp-head">
				<h2 id="hp-rev-h">What Our Customers Say</h2>
				<p>Feedback from the clinics, laboratories and hospitals we supply.</p>
			</div>
			<div class="hp-rev">
				<?php foreach ( $hp_reviews as $r ) : ?>
				<blockquote>
					<i class="fa-solid fa-quote-left" aria-hidden="true"></i>
					<p><?php echo esc_html( $r[0] ); ?></p>
					<footer><strong><?php echo esc_html( $r[1] ); ?></strong><span><?php echo esc_html( $r[2] ); ?></span></footer>
				</blockquote>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

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
<?php get_footer(); ?>