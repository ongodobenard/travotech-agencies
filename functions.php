<?php
/**
 * Travotech Agencies — functions.php
 * Updated: April 2026
 *
 * CHANGES:
 * - No emojis anywhere — Dashicons only
 * - WC admin badge: counts ONLY orders created AFTER the admin last viewed Orders.
 *   The "last viewed" timestamp is stored in user meta so it persists across sessions.
 *   Badge resets to 0 and hides when Orders page is opened; new orders after that
 *   point start counting from 1 again.
 * - WhatsApp buttons on home/shop/product pages: after AJAX order saved, cart is
 *   cleared server-side AND client is redirected to the shop page with a clean reload.
 * - Cart + form reset silently via WC fragments after successful Place Order (server-side cart clear)
 * - Yoast SEO focus keyphrase auto-filled from product title on save (new + existing products)
 * - FIX: Customer confirmation email WhatsApp button now links to STORE number, not customer number
 */

if ( defined('WP_DEBUG') && WP_DEBUG ) {
    @set_time_limit(300);
}

// ─── SMTP CONFIGURATION ───────────────────────
add_action( 'phpmailer_init', function ( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'cs2.rcnoc.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 465;
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->Username   = 'sales@travotechagencies.co.ke';
    $phpmailer->Password   = 'CHANGE_ME_SMTP_PASSWORD';
    $phpmailer->From       = 'sales@travotechagencies.co.ke';
    $phpmailer->FromName   = get_bloginfo( 'name' ) . ' Website';
    $phpmailer->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];
} );

// ─── THEME SETUP ──────────────────────────────
function travotech_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'custom-logo', [ 'width' => 46, 'height' => 46, 'flex-square' => true ] );
    register_nav_menus( [ 'primary' => 'Primary Menu' ] );
}
add_action( 'after_setup_theme', 'travotech_setup' );

// ─── ENQUEUE ──────────────────────────────────
function travotech_enqueue() {
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700&display=swap', [], null );
    wp_enqueue_style( 'medicare-style', get_stylesheet_uri(), [], '1.0.2' );
    wp_enqueue_script( 'medicare-main', get_template_directory_uri() . '/assets/js/main.js', [ 'jquery' ], '1.0.2', true );

    $shop_url = home_url( '/shop' );
    if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_page_id' ) ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id > 0 ) {
            $shop_url = get_permalink( $shop_page_id );
        }
    }

    wp_localize_script( 'medicare-main', 'medicareData', [
        'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
        'nonce'      => wp_create_nonce( 'travotech_nonce' ),
        'orderNonce' => wp_create_nonce( 'travotech_order_nonce' ),
        'waNumber'   => esc_js( travotech_wa() ),
        'shopUrl'    => esc_url( $shop_url ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'travotech_enqueue' );

// ─── HELPERS ──────────────────────────────────
function travotech_wa()      { return get_option( 'travotech_wa',      '254720737151' ); }
function travotech_phone()   { return get_option( 'travotech_phone',   '+254 720 737 151' ); }
function travotech_address() { return get_option( 'travotech_address', 'Nairobi, Kenya' ); }
function travotech_tagline() { return get_option( 'travotech_tagline', 'Trusted Care, Delivered Daily' ); }
function travotech_email()   { return get_option( 'travotech_email',   'sales@travotechagencies.co.ke' ); }

// ─── FORCE PAGE TEMPLATES BY SLUG ─────────────
function travotech_page_template( $template ) {
    if ( is_page() ) {
        $slug   = get_post_field( 'post_name', get_queried_object_id() );
        $custom = get_template_directory() . '/page-' . $slug . '.php';
        if ( file_exists( $custom ) ) return $custom;
    }
    return $template;
}
add_filter( 'template_include', 'travotech_page_template', 99 );

// ─── WA URL HELPER ────────────────────────────
function travotech_get_wa_url( $product_id ) {
    $product = wc_get_product( $product_id );
    if ( ! $product ) return '';
    $wa    = travotech_wa();
    $name  = $product->get_name();
    $price = strip_tags( $product->get_price_html() );
    $url   = get_permalink( $product_id );
    $msg   = urlencode( "Hello " . get_bloginfo( 'name' ) . "! I'd like to order: *{$name}* Price: {$price} Link: {$url} Please confirm availability. Thank you!" );
    return "https://wa.me/" . esc_attr( $wa ) . "?text=" . $msg;
}

// ─── WC WRAPPERS ──────────────────────────────
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_main_content', function () { echo '<div class="wc-outer">'; }, 10 );
add_action( 'woocommerce_after_main_content',  function () { echo '</div>'; }, 10 );

// ─── WHATSAPP ORDER BUTTON (Single Product Page) ──────────────────────────
function travotech_wa_button() {
    if ( ! class_exists( 'WooCommerce' ) ) return;
    global $product;
    if ( ! $product || ! is_a( $product, 'WC_Product' ) ) return;

    $product_id = $product->get_id();
    $wa_url     = travotech_get_wa_url( $product_id );
    ?>
    <button
        type="button"
        class="wc-wa-btn travotech-wa-order-btn"
        data-product-id="<?php echo esc_attr( $product_id ); ?>"
        data-wa-url="<?php echo esc_url( $wa_url ); ?>"
        data-nonce="<?php echo esc_attr( wp_create_nonce( 'travotech_order_nonce' ) ); ?>"
    >
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        Buy Via WhatsApp
    </button>
    <?php
}
add_action( 'woocommerce_single_product_summary', 'travotech_wa_button', 35 );

// ─── CASH ON DELIVERY ONLY ────────────────────
add_filter( 'woocommerce_payment_gateways', function ( $gateways ) {
    if ( isset( $gateways['cod'] ) ) {
        return [ 'cod' => $gateways['cod'] ];
    }
    return $gateways;
} );

// ─── PRICE RANGE FILTER ───────────────────────
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    if ( ! function_exists( 'is_shop' ) ) return;
    if ( ! is_shop() && ! is_product_category() && ! is_search() ) return;
    if ( ! isset( $_GET['min_price'] ) && ! isset( $_GET['max_price'] ) ) return;

    $min = isset( $_GET['min_price'] ) ? floatval( $_GET['min_price'] ) : 0;
    $max = isset( $_GET['max_price'] ) ? floatval( $_GET['max_price'] ) : 999999999;

    $existing   = (array) $query->get( 'meta_query' );
    $existing[] = [
        'key'     => '_price',
        'value'   => [ $min, $max ],
        'compare' => 'BETWEEN',
        'type'    => 'NUMERIC',
    ];
    $query->set( 'meta_query', $existing );
    $query->set( 'post_type', 'product' );
} );

// ─── CART CLEAR ON REDIRECT (WA orders) ───────
add_action( 'template_redirect', function () {
    if ( ! isset( $_GET['travotech_order_sent'] ) || $_GET['travotech_order_sent'] !== '1' ) return;
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) return;

    WC()->cart->empty_cart();
    if ( WC()->session ) {
        WC()->session->set( 'cart', [] );
        WC()->session->set( 'cart_totals', null );
    }
    if ( function_exists( 'wc_clear_notices' ) ) wc_clear_notices();

    $shop_url = function_exists( 'wc_get_page_id' )
        ? get_permalink( wc_get_page_id( 'shop' ) )
        : home_url( '/shop' );

    wp_redirect( esc_url_raw( $shop_url ) );
    exit;
} );

// ─── AJAX: FILTER PRODUCTS BY CATEGORY ───────
function travotech_filter_products() {
    if ( ! class_exists( 'WooCommerce' ) ) wp_send_json_error( 'WooCommerce not active' );

    $cat  = sanitize_text_field( $_POST['cat'] ?? '' );
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
    ];
    if ( $cat ) {
        $args['tax_query'] = [
            [ 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $cat ]
        ];
    }

    $q = new WP_Query( $args );
    ob_start();

    if ( $q->have_posts() ) {
        while ( $q->have_posts() ) {
            $q->the_post();
            $product_id = get_the_ID();
            $product    = wc_get_product( $product_id );
            if ( ! $product ) continue;

            $sale      = $product->is_on_sale();
            $is_new    = ( time() - strtotime( $product->get_date_created() ) ) < ( 30 * DAY_IN_SECONDS );
            $price_cur = number_format( (float) $product->get_price(), 2 );
            $price_reg = $product->get_regular_price();
            $img       = get_the_post_thumbnail_url( $product_id, 'woocommerce_thumbnail' );
            $cart_url  = $product->is_type( 'simple' ) ? '?add-to-cart=' . $product_id : get_permalink( $product_id );

            $cats    = get_the_terms( $product_id, 'product_cat' );
            $cat_n   = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
            $cat_lnk = ( $cats && ! is_wp_error( $cats ) ) ? get_term_link( $cats[0] ) : '#';
            $brands  = get_the_terms( $product_id, 'product_brand' );
            if ( ! $brands || is_wp_error( $brands ) ) $brands = get_the_terms( $product_id, 'pa_brand' );
            $brand_n = ( $brands && ! is_wp_error( $brands ) ) ? $brands[0]->name : '';

            $wa_product_url = travotech_get_wa_url( $product_id );
            $wa_nonce       = wp_create_nonce( 'travotech_order_nonce' );
            ?>
            <div class="p-card">
              <a href="<?php the_permalink(); ?>" class="p-img-link">
                <div class="p-img">
                  <?php if ( $img ) : ?>
                    <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                  <?php else : ?>
                    <svg style="width:48px;height:48px;opacity:.2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M10.5 3.5a6 6 0 018 8l-8.5 8.5a6 6 0 01-8-8l8.5-8.5z"/></svg>
                  <?php endif; ?>
                  <button class="p-wish" aria-label="Wishlist" onclick="event.preventDefault();event.stopPropagation();">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                  </button>
                  <?php if ( $sale && $price_reg ) : ?>
                    <div class="p-badge-sale"><?php echo round( ( ( $price_reg - $product->get_price() ) / $price_reg ) * 100 ); ?>% OFF</div>
                  <?php elseif ( $is_new ) : ?>
                    <div class="p-badge-new">NEW</div>
                  <?php endif; ?>
                </div>
              </a>
              <div class="p-body">
                <?php if ( $cat_n || $brand_n ) : ?>
                  <div class="p-card-meta">
                    <?php if ( $cat_n ) : ?><a href="<?php echo esc_url( $cat_lnk ); ?>" class="p-card-cat"><?php echo esc_html( $cat_n ); ?></a><?php endif; ?>
                    <?php if ( $brand_n ) : ?><span class="p-card-brand"><?php echo esc_html( $brand_n ); ?></span><?php endif; ?>
                  </div>
                <?php endif; ?>
                <div class="p-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                <div class="p-price-wrap">
                  <?php if ( $sale && $price_reg ) : ?>
                    <div class="p-price-old">KES <?php echo number_format( $price_reg, 2 ); ?></div>
                  <?php endif; ?>
                  <div class="p-price-cur">KES <?php echo $price_cur; ?></div>
                </div>
                <div class="p-btns">
                  <a href="<?php echo esc_url( $cart_url ); ?>" class="p-btn-cart"
                     <?php if ( $product->is_type( 'simple' ) ) : ?>data-product_id="<?php echo $product_id; ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow"<?php endif; ?>>
                    <span class="p-btn-ico">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
                    </span>
                    Add to Cart
                  </a>
                  <button
                    type="button"
                    class="p-btn-wa travotech-wa-order-btn"
                    data-product-id="<?php echo esc_attr( $product_id ); ?>"
                    data-wa-url="<?php echo esc_url( $wa_product_url ); ?>"
                    data-nonce="<?php echo esc_attr( $wa_nonce ); ?>"
                  >
                    <span class="p-btn-ico">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </span>
                    Buy Via WhatsApp
                  </button>
                </div>
              </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    }

    wp_send_json_success( ob_get_clean() );
}
add_action( 'wp_ajax_travotech_filter_products',        'travotech_filter_products' );
add_action( 'wp_ajax_nopriv_travotech_filter_products', 'travotech_filter_products' );

// ════════════════════════════════════════════════════════════════════════════
// ─── GLOBAL JS FOR WA ORDER BUTTON ──────────────────────────────────────
//
// After the AJAX order is saved:
//   1. Opens WhatsApp in a new tab
//   2. Clears the WooCommerce cart client-side (WC fragment refresh)
//   3. Reloads the current page redirected to the shop URL (clean state)
// ════════════════════════════════════════════════════════════════════════════
add_action( 'wp_footer', function () {
    $shop_url = function_exists( 'wc_get_page_id' )
        ? get_permalink( wc_get_page_id( 'shop' ) )
        : home_url( '/shop' );
    ?>
    <script>
    (function($){
        if (typeof travotechWaBound !== 'undefined') return;
        window.travotechWaBound = true;

        $(document).on('click', '.travotech-wa-order-btn', function(e){
            e.preventDefault();
            var $btn      = $(this);
            var productId = $btn.data('product-id');
            var waUrl     = $btn.data('wa-url');
            var nonce     = $btn.data('nonce');
            var qty       = 1;

            var $qtyInput = $('input.qty');
            if ($qtyInput.length) qty = parseInt($qtyInput.val()) || 1;

            // Disable button to prevent double-clicks
            $btn.prop('disabled', true).css('opacity', '0.6');

            $.ajax({
                url  : (typeof medicareData !== 'undefined' ? medicareData.ajaxUrl : '/wp-admin/admin-ajax.php'),
                type : 'POST',
                data : {
                    action             : 'travotech_wa_order',
                    travotech_order_nonce: nonce,
                    product_id         : productId,
                    qty                : qty,
                    phone              : '',
                    customer_name      : 'WhatsApp Client',
                },
                complete: function(){
                    // 1. Open WhatsApp in new tab
                    window.open(waUrl, '_blank');

                    // 2. Redirect current window to shop page (this also clears the cart
                    //    visually since the server already emptied it in the AJAX handler)
                    window.location.href = <?php echo wp_json_encode( esc_url_raw( $shop_url ) ); ?>;
                }
            });
        });
    })(jQuery);
    </script>
    <?php
} );

// ─── CONTACT FORM AJAX ────────────────────────
function travotech_contact() {
    ob_clean();

    if ( ! wp_verify_nonce( $_POST['nonce'] ?? '', 'travotech_nonce' ) ) {
        wp_send_json_error( [ 'msg' => 'Security check failed. Please refresh and try again.' ] );
    }

    $name  = sanitize_text_field( $_POST['contact_name']    ?? '' );
    $email = sanitize_email( $_POST['contact_email']        ?? '' );
    $phone = sanitize_text_field( $_POST['contact_phone']   ?? '' );
    $dept  = sanitize_text_field( $_POST['contact_dept']    ?? '' );
    $msg   = sanitize_textarea_field( $_POST['contact_msg'] ?? '' );

    if ( empty( $name ) || strlen( $name ) < 2 )
        wp_send_json_error( [ 'msg' => 'Please enter your full name.' ] );
    if ( empty( $email ) || ! is_email( $email ) )
        wp_send_json_error( [ 'msg' => 'Please enter a valid email address.' ] );
    if ( empty( $phone ) || strlen( preg_replace( '/\s/', '', $phone ) ) < 9 )
        wp_send_json_error( [ 'msg' => 'Please enter a valid phone number.' ] );
    if ( empty( $dept ) )
        wp_send_json_error( [ 'msg' => 'Please select a department.' ] );
    if ( empty( $msg ) || strlen( trim( $msg ) ) < 5 )
        wp_send_json_error( [ 'msg' => 'Please enter your message (at least 5 characters).' ] );

    $to      = travotech_email();
    $subject = "[Travotech Contact] {$dept} - {$name}";
    $body    = "New contact form submission from travotechagencies.co.ke\n\n";
    $body   .= "Name:        {$name}\n";
    $body   .= "Email:       {$email}\n";
    $body   .= "Phone:       {$phone}\n";
    $body   .= "Department:  {$dept}\n\n";
    $body   .= "Message:\n{$msg}\n\n";
    $body   .= "Sent via Travotech Agencies website contact form.\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( [ 'msg' => 'Message sent successfully!' ] );
    } else {
        global $phpmailer;
        $smtp_err = ( isset( $phpmailer ) && ! empty( $phpmailer->ErrorInfo ) )
            ? $phpmailer->ErrorInfo
            : 'Unknown mail error.';
        wp_send_json_error( [ 'msg' => 'Mail failed: ' . $smtp_err ] );
    }
}
add_action( 'wp_ajax_travotech_contact',        'travotech_contact' );
add_action( 'wp_ajax_nopriv_travotech_contact', 'travotech_contact' );

// ─── PRESCRIPTION FORM AJAX ───────────────────
function travotech_submit_prescription() {
    ob_clean();

    if ( ! wp_verify_nonce( $_POST['rx_nonce'] ?? '', 'rx_nonce_action' ) ) {
        wp_send_json_error( [ 'msg' => 'Security check failed. Please refresh and try again.' ] );
    }

    $fname     = sanitize_text_field( $_POST['rx_fname']     ?? '' );
    $lname     = sanitize_text_field( $_POST['rx_lname']     ?? '' );
    $age       = sanitize_text_field( $_POST['rx_age']       ?? '' );
    $gender    = sanitize_text_field( $_POST['rx_gender']    ?? '' );
    $phone     = sanitize_text_field( $_POST['rx_phone']     ?? '' );
    $email     = sanitize_email( $_POST['rx_email']          ?? '' );
    $location  = sanitize_text_field( $_POST['rx_location']  ?? '' );
    $allergies = sanitize_text_field( $_POST['rx_allergies'] ?? '' );
    $notes     = sanitize_textarea_field( $_POST['rx_notes'] ?? '' );

    if ( empty( $fname ) )    wp_send_json_error( [ 'msg' => 'First name is required.' ] );
    if ( empty( $lname ) )    wp_send_json_error( [ 'msg' => 'Last name is required.' ] );
    if ( empty( $age ) )      wp_send_json_error( [ 'msg' => 'Age is required.' ] );
    if ( empty( $gender ) )   wp_send_json_error( [ 'msg' => 'Please select your gender.' ] );
    if ( empty( $phone ) )    wp_send_json_error( [ 'msg' => 'Phone number is required.' ] );
    if ( empty( $location ) ) wp_send_json_error( [ 'msg' => 'Delivery address is required.' ] );

    $attachment = [];
    if ( ! empty( $_FILES['rx_file']['name'] ) ) {
        $allowed_types = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        if ( ! in_array( $_FILES['rx_file']['type'], $allowed_types ) ) {
            wp_send_json_error( [ 'msg' => 'Invalid file type. Please upload an image, PDF or Word document.' ] );
        }
        if ( $_FILES['rx_file']['size'] > 10 * 1024 * 1024 ) {
            wp_send_json_error( [ 'msg' => 'File too large. Maximum size is 10MB.' ] );
        }
        $upload = wp_upload_bits( $_FILES['rx_file']['name'], null, file_get_contents( $_FILES['rx_file']['tmp_name'] ) );
        if ( $upload['error'] ) {
            wp_send_json_error( [ 'msg' => 'File upload failed: ' . $upload['error'] ] );
        }
        $attachment[] = $upload['file'];
    } else {
        wp_send_json_error( [ 'msg' => 'Please attach your prescription file.' ] );
    }

    $to      = 'sales@travotechagencies.co.ke';
    $subject = '[Travotech Prescription] ' . $fname . ' ' . $lname . ' - ' . $phone;
    $body    = "New Prescription Submission from travotechagencies.co.ke\n\n";
    $body   .= "================================\n";
    $body   .= "PATIENT DETAILS\n";
    $body   .= "================================\n";
    $body   .= "Name:             " . $fname . ' ' . $lname . "\n";
    $body   .= "Age:              " . $age . "\n";
    $body   .= "Gender:           " . $gender . "\n";
    $body   .= "Phone:            " . $phone . "\n";
    $body   .= "Email:            " . ( $email ?: 'Not provided' ) . "\n";
    $body   .= "Delivery Address: " . $location . "\n";
    $body   .= "Allergies:        " . ( $allergies ?: 'None mentioned' ) . "\n";
    $body   .= "Notes:            " . ( $notes ?: 'None' ) . "\n";
    $body   .= "================================\n";
    $body   .= "Prescription file is attached.\n";
    $body   .= "Please review and contact the patient via phone or WhatsApp.\n\n";
    $body   .= "Submitted: " . current_time( 'mysql' ) . "\n";

    $headers = [ 'Content-Type: text/plain; charset=UTF-8' ];
    if ( $email ) {
        $headers[] = "Reply-To: {$fname} {$lname} <{$email}>";
    }

    $sent = wp_mail( $to, $subject, $body, $headers, $attachment );

    if ( ! empty( $attachment[0] ) && file_exists( $attachment[0] ) ) {
        @unlink( $attachment[0] );
    }

    if ( $sent ) {
        wp_send_json_success( [ 'msg' => 'Your prescription was successfully received! Our professional pharmacist will review it and get back to you soon.' ] );
    } else {
        global $phpmailer;
        $err = ( isset( $phpmailer ) && ! empty( $phpmailer->ErrorInfo ) ) ? $phpmailer->ErrorInfo : 'Unknown error.';
        wp_send_json_error( [ 'msg' => 'Failed to send: ' . $err ] );
    }
}
add_action( 'wp_ajax_travotech_submit_prescription',        'travotech_submit_prescription' );
add_action( 'wp_ajax_nopriv_travotech_submit_prescription', 'travotech_submit_prescription' );

// ════════════════════════════════════════════════════════════════════════════
// ─── SHARED ORDER HELPER ─────────────────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
function travotech_build_and_send_order( $args ) {

    $fname      = $args['fname']      ?? '';
    $lname      = $args['lname']      ?? '';
    $company    = $args['company']    ?? '';
    $phone      = $args['phone']      ?? '';
    $email      = $args['email']      ?? '';
    $addr1      = $args['addr1']      ?? '';
    $addr2      = $args['addr2']      ?? '';
    $city       = $args['city']       ?? '';
    $state      = $args['state']      ?? '';
    $postcode   = $args['postcode']   ?? '';
    $country    = $args['country']    ?: 'KE';
    $notes      = $args['notes']      ?? '';
    $payment    = $args['payment']    ?: 'cod';
    $via        = $args['via']        ?: 'website';
    $cart_lines = $args['cart_lines'] ?? [];
    $wc_items   = $args['wc_items']   ?? [];

    $total = array_sum( array_column( $cart_lines, 'sub' ) );

    // ── CREATE WC ORDER ──
    $order_id    = 0;
    $order_url   = '';
    $order_error = '';

    if ( function_exists( 'wc_create_order' ) && ! empty( $wc_items ) ) {
        try {
            $order = wc_create_order( [
                'status'      => 'pending',
                'customer_id' => get_current_user_id(),
            ] );

            if ( is_wp_error( $order ) ) throw new Exception( $order->get_error_message() );

            $order->set_billing_first_name( $fname );
            $order->set_billing_last_name(  $lname );
            $order->set_billing_company(    $company );
            $order->set_billing_phone(      $phone );
            $order->set_billing_email(      is_email( $email ) ? $email : get_option( 'admin_email' ) );
            $order->set_billing_address_1(  $addr1 );
            $order->set_billing_address_2(  $addr2 );
            $order->set_billing_city(       $city );
            $order->set_billing_state(      $state );
            $order->set_billing_postcode(   $postcode );
            $order->set_billing_country(    $country );
            $order->set_payment_method(     $payment );
            $order->set_payment_method_title( ucwords( str_replace( [ '_', '-' ], ' ', $payment ) ) );

            foreach ( $wc_items as $item ) {
                $order->add_product( $item['product'], $item['qty'] );
            }

            if ( $notes ) $order->add_order_note( 'Customer note: ' . $notes, 1 );
            $order->add_order_note(
                'Order placed via Travotech ' . ( $via === 'whatsapp' ? 'WhatsApp button' : 'website checkout' ) . '.',
                0
            );

            $order->calculate_totals();
            $order->save();

            $order_id  = $order->get_id();
            $order_url = admin_url( 'admin.php?page=wc-orders&action=edit&id=' . $order_id );

        } catch ( Exception $e ) {
            $order_error = $e->getMessage();
        }
    }

    // ── SHARED EMAIL BUILDING ──
    $store_name   = get_bloginfo( 'name' );
    $notify_email = function_exists( 'travotech_email' ) ? travotech_email() : 'sales@travotechagencies.co.ke';
    $order_label  = $order_id ? '#' . $order_id : 'N/A';
    $via_label    = $via === 'whatsapp' ? 'WhatsApp Order' : 'Website Checkout';
    $total_fmt    = 'KES ' . number_format( $total, 2 );

    $items_html = '';
    foreach ( $cart_lines as $item ) {
        $items_html .= '<tr>
            <td style="padding:10px 14px;border-bottom:1px solid #e8f8f0;font-family:Arial,sans-serif;font-size:14px;color:#1a2e25;">' . esc_html( $item['name'] ) . '</td>
            <td style="padding:10px 14px;border-bottom:1px solid #e8f8f0;text-align:center;font-family:Arial,sans-serif;font-size:14px;color:#4a6358;">' . intval( $item['qty'] ) . '</td>
            <td style="padding:10px 14px;border-bottom:1px solid #e8f8f0;text-align:right;font-family:Arial,sans-serif;font-size:14px;color:#2eaf6e;font-weight:700;">KES ' . number_format( $item['sub'], 2 ) . '</td>
        </tr>';
    }

    $wc_block = $order_id
        ? '<tr><td style="padding:12px 32px 0;"><div style="background:#e8f8f0;border:1.5px solid #b8ecd4;border-radius:8px;padding:10px 16px;font-size:12px;color:#1e8a54;">Order #' . $order_id . ' saved to WooCommerce, Status: <strong>Pending Payment</strong></div></td></tr>'
        : ( $order_error ? '<tr><td style="padding:12px 32px 0;"><div style="background:#fff0f0;border:1.5px solid #f0b8b8;border-radius:8px;padding:10px 16px;font-size:12px;color:#c0392b;">WC order creation failed: ' . esc_html( $order_error ) . '</div></td></tr>' : '' );

    $view_btn = $order_id
        ? '<a href="' . esc_url( $order_url ) . '" style="display:inline-block;background:#2eaf6e;color:#fff;padding:12px 28px;border-radius:50px;font-size:14px;font-weight:800;text-decoration:none;">View Order #' . $order_id . ' in WooCommerce</a>'
        : '<a href="' . esc_url( admin_url( 'admin.php?page=wc-orders' ) ) . '" style="display:inline-block;background:#2eaf6e;color:#fff;padding:12px 28px;border-radius:50px;font-size:14px;font-weight:800;text-decoration:none;">View WooCommerce Orders</a>';

    $customer_rows = '
        <tr><td style="padding:5px 0;font-size:13px;color:#8aaa98;font-weight:700;width:130px;">Name</td><td style="padding:5px 0;font-size:13px;color:#1a2e25;font-weight:700;">' . esc_html( trim( $fname . ' ' . $lname ) ) . '</td></tr>'
        . ( $company ? '<tr><td style="padding:5px 0;font-size:13px;color:#8aaa98;font-weight:700;">Company</td><td style="padding:5px 0;font-size:13px;color:#1a2e25;">' . esc_html( $company ) . '</td></tr>' : '' )
        . ( $phone   ? '<tr><td style="padding:5px 0;font-size:13px;color:#8aaa98;font-weight:700;">Phone</td><td style="padding:5px 0;font-size:13px;color:#1a2e25;font-weight:700;"><a href="tel:' . esc_attr( $phone ) . '" style="color:#2eaf6e;">' . esc_html( $phone ) . '</a></td></tr>' : '' )
        . ( is_email( $email ) ? '<tr><td style="padding:5px 0;font-size:13px;color:#8aaa98;font-weight:700;">Email</td><td style="padding:5px 0;font-size:13px;color:#1a2e25;"><a href="mailto:' . esc_attr( $email ) . '" style="color:#2eaf6e;">' . esc_html( $email ) . '</a></td></tr>' : '' )
        . '<tr><td style="padding:5px 0;font-size:13px;color:#8aaa98;font-weight:700;">Address</td><td style="padding:5px 0;font-size:13px;color:#1a2e25;">' . esc_html( implode( ', ', array_filter( [ $addr1, $addr2, $city, $state, $postcode, $country ] ) ) ) . '</td></tr>'
        . '<tr><td style="padding:5px 0;font-size:13px;color:#8aaa98;font-weight:700;">Payment</td><td style="padding:5px 0;font-size:13px;color:#1a2e25;">' . esc_html( ucwords( str_replace( [ '_', '-' ], ' ', $payment ) ) ) . '</td></tr>';

    $wa_phone = preg_replace( '/[^0-9]/', '', $phone );

    // ── SALES NOTIFICATION EMAIL HTML ──
    $html_sales = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f0faf5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0faf5;padding:30px 0;">
      <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;max-width:600px;width:100%;">
          <tr><td style="background:linear-gradient(135deg,#1e8a54,#2eaf6e);padding:28px 32px;text-align:center;">
            <div style="font-size:26px;font-weight:900;color:#fff;">' . esc_html( $store_name ) . '</div>
            <div style="font-size:13px;color:rgba(255,255,255,.8);margin-top:4px;">New Order Notification</div>
          </td></tr>
          <tr><td style="padding:24px 32px 0;text-align:center;">
            <div style="display:inline-block;background:#e8f8f0;border:1.5px solid #b8ecd4;border-radius:50px;padding:7px 20px;font-size:13px;font-weight:800;color:#1e8a54;">' . esc_html( $via_label ) . ' &nbsp;|&nbsp; Order ' . esc_html( $order_label ) . '</div>
          </td></tr>
          ' . $wc_block . '
          <tr><td style="padding:24px 32px 0;">
            <div style="font-size:15px;font-weight:800;color:#1a2e25;margin-bottom:12px;border-bottom:2px solid #e8f8f0;padding-bottom:8px;">Customer Details</div>
            <table width="100%" cellpadding="0" cellspacing="0">' . $customer_rows . '</table>
          </td></tr>
          <tr><td style="padding:24px 32px 0;">
            <div style="font-size:15px;font-weight:800;color:#1a2e25;margin-bottom:12px;border-bottom:2px solid #e8f8f0;padding-bottom:8px;">Order Items</div>
            <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e8f8f0;border-radius:8px;overflow:hidden;">
              <thead><tr style="background:#f8fffe;">
                <th style="padding:9px 14px;text-align:left;font-size:11px;font-weight:800;color:#8aaa98;text-transform:uppercase;">Product</th>
                <th style="padding:9px 14px;text-align:center;font-size:11px;font-weight:800;color:#8aaa98;text-transform:uppercase;">Qty</th>
                <th style="padding:9px 14px;text-align:right;font-size:11px;font-weight:800;color:#8aaa98;text-transform:uppercase;">Total</th>
              </tr></thead>
              <tbody>' . $items_html . '</tbody>
              <tfoot><tr style="background:#f0faf5;">
                <td colspan="2" style="padding:12px 14px;font-size:15px;font-weight:900;color:#1a2e25;">ORDER TOTAL</td>
                <td style="padding:12px 14px;text-align:right;font-size:17px;font-weight:900;color:#2eaf6e;">' . $total_fmt . '</td>
              </tr></tfoot>
            </table>
          </td></tr>
          ' . ( $notes ? '<tr><td style="padding:20px 32px 0;"><div style="background:#fff8e8;border:1.5px solid #f0d080;border-radius:8px;padding:12px 16px;"><div style="font-size:12px;font-weight:800;color:#b8860b;margin-bottom:5px;text-transform:uppercase;">Customer Notes</div><div style="font-size:13px;color:#4a6358;line-height:1.6;">' . esc_html( $notes ) . '</div></div></td></tr>' : '' ) . '
          <tr><td style="padding:20px 32px 0;">
            <div style="background:#f0faf5;border:1.5px solid #b8ecd4;border-radius:8px;padding:14px 16px;">
              <div style="font-size:12px;font-weight:800;color:#2eaf6e;text-transform:uppercase;margin-bottom:8px;">Payment Reminder</div>
              <div style="font-size:12px;color:#4a6358;line-height:1.8;">
                Nairobi: Collect Cash on delivery<br>
                Other Counties: Full payment before dispatch<br>
                
              </div>
            </div>
          </td></tr>
          <tr><td style="padding:24px 32px;text-align:center;">
            ' . $view_btn . '
            ' . ( $wa_phone ? '<div style="margin-top:14px;"><a href="https://wa.me/' . esc_attr( $wa_phone ) . '" style="font-size:12px;color:#25d366;text-decoration:none;font-weight:700;">WhatsApp Customer</a></div>' : '' ) . '
          </td></tr>
          <tr><td style="background:#f8fffe;border-top:2px solid #e8f8f0;padding:16px 32px;text-align:center;">
            <div style="font-size:11px;color:#8aaa98;">Automated notification from ' . esc_html( $store_name ) . '</div>
            <div style="font-size:11px;color:#8aaa98;margin-top:3px;">+254 720 737 151 &nbsp;|&nbsp; ' . esc_html( home_url( '/' ) ) . '</div>
          </td></tr>
        </table>
      </td></tr>
    </table>
    </body></html>';

    $subject_sales = 'New Order ' . $order_label . ' - ' . trim( $fname . ' ' . $lname ) . ' | ' . $store_name;
    $headers_sales = [ 'Content-Type: text/html; charset=UTF-8' ];
    if ( is_email( $email ) ) {
        $headers_sales[] = 'Reply-To: ' . trim( $fname . ' ' . $lname ) . ' <' . $email . '>';
    }

    $sent_sales = wp_mail( $notify_email, $subject_sales, $html_sales, $headers_sales );

    // ── CUSTOMER CONFIRMATION EMAIL ──
    $sent_customer = false;
    if ( is_email( $email ) && $via !== 'whatsapp' ) {
        $sent_customer = travotech_send_customer_confirmation( $email, $fname, $lname, $phone, $order_id, $order_label, $cart_lines, $total_fmt, $notes, $payment, $store_name );
    }

    return [
        'order_id'            => $order_id,
        'order_error'         => $order_error,
        'email_sent'          => $sent_sales,
        'customer_email_sent' => $sent_customer,
    ];
}

// ════════════════════════════════════════════════════════════════════════════
// ─── CUSTOMER CONFIRMATION EMAIL ─────────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
function travotech_send_customer_confirmation( $email, $fname, $lname, $phone, $order_id, $order_label, $cart_lines, $total_fmt, $notes, $payment, $store_name ) {

    $items_html = '';
    foreach ( $cart_lines as $item ) {
        $items_html .= '<tr>
            <td style="padding:10px 14px;border-bottom:1px solid #e8f8f0;font-family:Arial,sans-serif;font-size:14px;color:#1a2e25;">' . esc_html( $item['name'] ) . '</td>
            <td style="padding:10px 14px;border-bottom:1px solid #e8f8f0;text-align:center;font-family:Arial,sans-serif;font-size:14px;color:#4a6358;">' . intval( $item['qty'] ) . '</td>
            <td style="padding:10px 14px;border-bottom:1px solid #e8f8f0;text-align:right;font-family:Arial,sans-serif;font-size:14px;color:#2eaf6e;font-weight:700;">KES ' . number_format( $item['sub'], 2 ) . '</td>
        </tr>';
    }

    // ── FIX: Use STORE WhatsApp number so customer contacts the shop, not themselves ──
    $store_wa = preg_replace( '/[^0-9]/', '', function_exists( 'travotech_wa' ) ? travotech_wa() : '254720737151' );

    $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f0faf5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0faf5;padding:30px 0;">
      <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;max-width:600px;width:100%;">

          <tr><td style="background:linear-gradient(135deg,#1e8a54,#2eaf6e);padding:30px 32px;text-align:center;">
            <div style="font-size:28px;font-weight:900;color:#fff;letter-spacing:-0.5px;">' . esc_html( $store_name ) . '</div>
            <div style="font-size:13px;color:rgba(255,255,255,.8);margin-top:4px;font-style:italic;">Trusted Care, Delivered Daily</div>
          </td></tr>

          <tr><td style="padding:28px 32px 10px;text-align:center;">
            <div style="font-family:Arial,sans-serif;font-size:22px;font-weight:900;color:#1a2e25;margin-bottom:6px;">Order Confirmed</div>
            <div style="font-family:Arial,sans-serif;font-size:14px;color:#4a6358;line-height:1.6;">
              Thank you, <strong>' . esc_html( $fname ) . '</strong>! Your order has been received and our team will contact you shortly to confirm delivery.
            </div>
            <div style="display:inline-block;background:#e8f8f0;border:1.5px solid #b8ecd4;border-radius:50px;padding:7px 20px;font-size:13px;font-weight:800;color:#1e8a54;margin-top:14px;">
              Order ' . esc_html( $order_label ) . '
            </div>
          </td></tr>

          <tr><td style="padding:20px 32px 0;">
            <div style="font-size:15px;font-weight:800;color:#1a2e25;margin-bottom:12px;border-bottom:2px solid #e8f8f0;padding-bottom:8px;">Your Order</div>
            <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e8f8f0;border-radius:8px;overflow:hidden;">
              <thead><tr style="background:#f8fffe;">
                <th style="padding:9px 14px;text-align:left;font-size:11px;font-weight:800;color:#8aaa98;text-transform:uppercase;">Product</th>
                <th style="padding:9px 14px;text-align:center;font-size:11px;font-weight:800;color:#8aaa98;text-transform:uppercase;">Qty</th>
                <th style="padding:9px 14px;text-align:right;font-size:11px;font-weight:800;color:#8aaa98;text-transform:uppercase;">Total</th>
              </tr></thead>
              <tbody>' . $items_html . '</tbody>
              <tfoot><tr style="background:#f0faf5;">
                <td colspan="2" style="padding:12px 14px;font-size:15px;font-weight:900;color:#1a2e25;">ORDER TOTAL</td>
                <td style="padding:12px 14px;text-align:right;font-size:17px;font-weight:900;color:#2eaf6e;">' . $total_fmt . '</td>
              </tr></tfoot>
            </table>
          </td></tr>

          ' . ( $notes ? '<tr><td style="padding:16px 32px 0;"><div style="background:#fff8e8;border:1.5px solid #f0d080;border-radius:8px;padding:12px 16px;"><div style="font-size:12px;font-weight:800;color:#b8860b;margin-bottom:5px;text-transform:uppercase;">Your Notes</div><div style="font-size:13px;color:#4a6358;line-height:1.6;">' . esc_html( $notes ) . '</div></div></td></tr>' : '' ) . '

          <tr><td style="padding:16px 32px 0;">
            <div style="background:#f0faf5;border:1.5px solid #b8ecd4;border-radius:8px;padding:14px 16px;">
              <div style="font-size:12px;font-weight:800;color:#2eaf6e;text-transform:uppercase;margin-bottom:8px;">Payment: ' . esc_html( ucwords( str_replace( [ '_', '-' ], ' ', $payment ) ) ) . '</div>
              <div style="font-size:12px;color:#4a6358;line-height:1.9;">
                Nairobi: Pay Cash on delivery<br>
                Other Counties: Full payment before dispatch<br>
                
                Total to pay: <span style="color:#2eaf6e;font-weight:800;">' . $total_fmt . '</span>
              </div>
            </div>
          </td></tr>

          <tr><td style="padding:16px 32px 0;">
            <div style="font-size:15px;font-weight:800;color:#1a2e25;margin-bottom:10px;border-bottom:2px solid #e8f8f0;padding-bottom:8px;">What Happens Next</div>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="width:32px;vertical-align:top;padding:4px 0;">
                  <div style="width:22px;height:22px;background:#2eaf6e;border-radius:50%;text-align:center;color:#fff;font-size:11px;font-weight:900;line-height:22px;">1</div>
                </td>
                <td style="padding:4px 0 4px 8px;font-size:13px;color:#4a6358;font-family:Arial,sans-serif;line-height:1.5;">Our pharmacist reviews your order and verifies stock availability.</td>
              </tr>
              <tr>
                <td style="width:32px;vertical-align:top;padding:4px 0;">
                  <div style="width:22px;height:22px;background:#2eaf6e;border-radius:50%;text-align:center;color:#fff;font-size:11px;font-weight:900;line-height:22px;">2</div>
                </td>
                <td style="padding:4px 0 4px 8px;font-size:13px;color:#4a6358;font-family:Arial,sans-serif;line-height:1.5;">We call or WhatsApp you on <strong>' . esc_html( $phone ) . '</strong> to confirm delivery details.</td>
              </tr>
              <tr>
                <td style="width:32px;vertical-align:top;padding:4px 0;">
                  <div style="width:22px;height:22px;background:#2eaf6e;border-radius:50%;text-align:center;color:#fff;font-size:11px;font-weight:900;line-height:22px;">3</div>
                </td>
                <td style="padding:4px 0 4px 8px;font-size:13px;color:#4a6358;font-family:Arial,sans-serif;line-height:1.5;">Your order is dispatched and delivered to your address.</td>
              </tr>
            </table>
          </td></tr>

          <tr><td style="padding:24px 32px;text-align:center;">
            <a href="https://wa.me/' . esc_attr( $store_wa ) . '" style="display:inline-block;background:#25d366;color:#fff;padding:12px 24px;border-radius:50px;font-size:14px;font-weight:800;text-decoration:none;margin:0 6px 10px;">Chat on WhatsApp</a>
            <a href="tel:+254720737151" style="display:inline-block;background:#2eaf6e;color:#fff;padding:12px 24px;border-radius:50px;font-size:14px;font-weight:800;text-decoration:none;margin:0 6px 10px;">Call Us</a>
          </td></tr>

          <tr><td style="background:#f8fffe;border-top:2px solid #e8f8f0;padding:16px 32px;text-align:center;">
            <div style="font-size:12px;color:#4a6358;font-weight:700;">' . esc_html( $store_name ) . ' :Trusted Care, Delivered Daily</div>
            <div style="font-size:11px;color:#8aaa98;margin-top:4px;">+254 720 737 151 &nbsp;|&nbsp; sales@travotechagencies.co.ke</div>
            <div style="font-size:11px;color:#8aaa98;margin-top:2px;">' . esc_html( home_url( '/' ) ) . '</div>
            <div style="font-size:10px;color:#b0c8bc;margin-top:8px;">This is an automated order confirmation email. Please do not reply directly.</div>
          </td></tr>

        </table>
      </td></tr>
    </table>
    </body></html>';

    $subject = 'Order ' . $order_label . ' Confirmed - ' . $store_name;
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $store_name . ' <sales@travotechagencies.co.ke>',
    ];

    return wp_mail( $email, $subject, $html, $headers );
}

// ─── AJAX: WHATSAPP QUICK ORDER ───────────────
add_action( 'wp_ajax_travotech_wa_order',        'travotech_wa_order_handler' );
add_action( 'wp_ajax_nopriv_travotech_wa_order', 'travotech_wa_order_handler' );

function travotech_wa_order_handler() {

    if ( ! isset( $_POST['travotech_order_nonce'] ) ||
         ! wp_verify_nonce( sanitize_text_field( $_POST['travotech_order_nonce'] ), 'travotech_order_nonce' ) ) {
        wp_send_json_error( [ 'msg' => 'Security check failed.' ] );
        return;
    }

    $product_id = intval( $_POST['product_id'] ?? 0 );
    $qty        = max( 1, intval( $_POST['qty'] ?? 1 ) );

    $fname = 'WhatsApp';
    $lname = 'Client';

    if ( ! $product_id || ! function_exists( 'wc_get_product' ) ) {
        wp_send_json_error( [ 'msg' => 'Invalid product.' ] );
        return;
    }

    $product = wc_get_product( $product_id );
    if ( ! $product ) {
        wp_send_json_error( [ 'msg' => 'Product not found.' ] );
        return;
    }

    $price = (float) $product->get_price();
    $sub   = $price * $qty;

    $result = travotech_build_and_send_order( [
        'fname'      => $fname,
        'lname'      => $lname,
        'country'    => 'KE',
        'payment'    => 'cod',
        'via'        => 'whatsapp',
        'cart_lines' => [ [ 'name' => $product->get_name(), 'qty' => $qty, 'price' => $price, 'sub' => $sub ] ],
        'wc_items'   => [ [ 'product' => $product, 'qty' => $qty ] ],
    ] );

    if ( function_exists( 'WC' ) && WC()->cart ) {
        WC()->cart->empty_cart();
        if ( WC()->session ) {
            WC()->session->set( 'cart', [] );
            WC()->session->set( 'cart_totals', null );
        }
    }

    wp_send_json_success( [
        'msg'      => 'Order logged.',
        'order_id' => $result['order_id'],
    ] );
}

// ─── AJAX: CHECKOUT PLACE ORDER ───────────────
add_action( 'wp_ajax_travotech_send_order_email',        'travotech_send_order_email_handler' );
add_action( 'wp_ajax_nopriv_travotech_send_order_email', 'travotech_send_order_email_handler' );

function travotech_send_order_email_handler() {

    if ( ! isset( $_POST['travotech_order_nonce'] ) ||
         ! wp_verify_nonce( sanitize_text_field( $_POST['travotech_order_nonce'] ), 'travotech_order_nonce' ) ) {
        wp_send_json_error( [ 'msg' => 'Security check failed.' ] );
        return;
    }

    $fname    = sanitize_text_field( $_POST['billing_first_name'] ?? '' );
    $lname    = sanitize_text_field( $_POST['billing_last_name']  ?? '' );
    $company  = sanitize_text_field( $_POST['billing_company']    ?? '' );
    $phone    = sanitize_text_field( $_POST['billing_phone']      ?? '' );
    $email    = sanitize_email( $_POST['billing_email']           ?? '' );
    $addr1    = sanitize_text_field( $_POST['billing_address_1']  ?? '' );
    $addr2    = sanitize_text_field( $_POST['billing_address_2']  ?? '' );
    $city     = sanitize_text_field( $_POST['billing_city']       ?? '' );
    $state    = sanitize_text_field( $_POST['billing_state']      ?? '' );
    $postcode = sanitize_text_field( $_POST['billing_postcode']   ?? '' );
    $country  = sanitize_text_field( $_POST['billing_country']    ?? 'KE' );
    $notes    = sanitize_textarea_field( $_POST['order_comments'] ?? '' );
    $payment  = sanitize_text_field( $_POST['payment_method']     ?? 'cod' );
    $via      = sanitize_text_field( $_POST['order_via']          ?? 'website' );

    if ( empty( $fname ) || empty( $lname ) ) {
        wp_send_json_error( [ 'msg' => 'Please enter your first and last name.', 'field' => 'name' ] );
        return;
    }
    if ( empty( $phone ) ) {
        wp_send_json_error( [ 'msg' => 'Please enter your phone number.', 'field' => 'billing_phone' ] );
        return;
    }
    if ( $via !== 'whatsapp' && ( empty( $email ) || ! is_email( $email ) ) ) {
        wp_send_json_error( [ 'msg' => 'A valid email address is required to receive your order confirmation.', 'field' => 'billing_email' ] );
        return;
    }

    $cart_lines = [];
    $wc_items   = [];

    if ( function_exists( 'WC' ) && WC()->cart && ! WC()->cart->is_empty() ) {
        foreach ( WC()->cart->get_cart() as $ci ) {
            $p     = $ci['data'];
            $q     = $ci['quantity'];
            $price = (float) $p->get_price();
            $sub   = $price * $q;
            $cart_lines[] = [ 'name' => $p->get_name(), 'qty' => $q, 'price' => $price, 'sub' => $sub ];
            $wc_items[]   = [ 'product' => $p, 'qty' => $q ];
        }
    }

    if ( empty( $cart_lines ) ) {
        wp_send_json_error( [ 'msg' => 'Your cart is empty. Please add items before placing an order.' ] );
        return;
    }

    $result = travotech_build_and_send_order( [
        'fname'      => $fname,
        'lname'      => $lname,
        'company'    => $company,
        'phone'      => $phone,
        'email'      => $email,
        'addr1'      => $addr1,
        'addr2'      => $addr2,
        'city'       => $city,
        'state'      => $state,
        'postcode'   => $postcode,
        'country'    => $country,
        'notes'      => $notes,
        'payment'    => $payment,
        'via'        => $via,
        'cart_lines' => $cart_lines,
        'wc_items'   => $wc_items,
    ] );

    $order_id = $result['order_id'];
    $sent     = $result['email_sent'];
    $err      = $result['order_error'];

    if ( $order_id && function_exists( 'WC' ) && WC()->cart ) {
        WC()->cart->empty_cart();
        if ( WC()->session ) {
            WC()->session->set( 'cart', [] );
            WC()->session->set( 'cart_totals', null );
        }
    }

    if ( $sent && $order_id ) {
        wp_send_json_success( [
            'msg'                 => 'Order #' . $order_id . ' placed successfully.',
            'order_id'            => $order_id,
            'email_sent'          => true,
            'customer_email_sent' => $result['customer_email_sent'],
        ] );
    } elseif ( $order_id && ! $sent ) {
        wp_send_json_error( [
            'msg'      => 'Order #' . $order_id . ' saved but confirmation email failed. Please check SMTP settings.',
            'order_id' => $order_id,
        ] );
    } elseif ( $sent && ! $order_id ) {
        wp_send_json_error( [
            'msg'      => 'Email sent but WooCommerce order could not be saved. Error: ' . esc_html( $err ),
            'order_id' => 0,
        ] );
    } else {
        wp_send_json_error( [
            'msg'      => 'Something went wrong. Please contact us on WhatsApp or call +254 720 737 151.',
            'order_id' => 0,
        ] );
    }
}

// ════════════════════════════════════════════════════════════════════════════
// ─── WOOCOMMERCE ADMIN ORDER BADGE ───────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
add_action( 'admin_menu', 'travotech_wc_order_badge', 999 );

function travotech_wc_order_badge() {
    global $submenu;

    $current_page   = $_GET['page']      ?? '';
    $current_post   = $_GET['post_type'] ?? '';
    $is_orders_page = ( $current_page === 'wc-orders' || $current_post === 'shop_order' );

    $admin_user_id = get_current_user_id();

    if ( $is_orders_page ) {
        update_user_meta( $admin_user_id, 'travotech_orders_last_viewed', time() );
        return;
    }

    $last_viewed = (int) get_user_meta( $admin_user_id, 'travotech_orders_last_viewed', true );

    $new_count = 0;

    if ( function_exists( 'wc_get_orders' ) ) {
        $args = [
            'status'       => [ 'wc-pending', 'wc-processing' ],
            'limit'        => -1,
            'return'       => 'ids',
            'date_created' => '>' . $last_viewed,
        ];
        $new_orders = wc_get_orders( $args );
        $new_count  = count( $new_orders );
    } else {
        global $wpdb;
        $dt = date( 'Y-m-d H:i:s', $last_viewed );
        $new_count = (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->posts}
             WHERE post_type = 'shop_order'
               AND post_status IN ('wc-pending','wc-processing')
               AND post_date_gmt > %s",
            $dt
        ) );
    }

    if ( $new_count < 1 ) return;

    $badge = ' <span class="awaiting-mod count-' . $new_count . '" id="travotech-order-badge">'
           . '<span class="pending-count">' . number_format_i18n( $new_count ) . '</span>'
           . '</span>';

    $parents = [ 'woocommerce', 'edit.php?post_type=shop_order' ];
    foreach ( $parents as $parent ) {
        if ( ! isset( $submenu[ $parent ] ) ) continue;
        foreach ( $submenu[ $parent ] as $k => $sub ) {
            if ( isset( $sub[2] ) && (
                $sub[2] === 'wc-orders' ||
                $sub[2] === 'edit.php?post_type=shop_order'
            ) ) {
                $submenu[ $parent ][ $k ][0] .= $badge;
                break 2;
            }
        }
    }

    add_action( 'admin_footer', function() {
        ?>
        <script>
        (function(){
            var badge = document.getElementById('travotech-order-badge');
            if (!badge) return;
            var ordersPatterns = ['page=wc-orders', 'post_type=shop_order'];
            document.querySelectorAll('#adminmenu a').forEach(function(link){
                var href = link.getAttribute('href') || '';
                var isOrders = ordersPatterns.some(function(p){ return href.indexOf(p) !== -1; });
                if (!isOrders) return;
                link.addEventListener('click', function(){
                    var b = document.getElementById('travotech-order-badge');
                    if (b) b.style.display = 'none';
                });
            });
        })();
        </script>
        <?php
    } );
}

// ─── ADMIN SETTINGS PAGE ──────────────────────
function travotech_admin_menu() {
    add_menu_page( 'Travotech Settings', 'Travotech Settings', 'manage_options', 'medicare-settings', 'travotech_settings_page', 'dashicons-heart', 60 );
}
add_action( 'admin_menu', 'travotech_admin_menu' );

function travotech_settings_page() {
    if ( isset( $_POST['travotech_save'] ) ) {
        check_admin_referer( 'travotech_settings_save' );
        foreach ( [ 'travotech_wa', 'travotech_phone', 'travotech_address', 'travotech_tagline', 'travotech_email' ] as $k ) {
            update_option( $k, sanitize_text_field( $_POST[ $k ] ?? '' ) );
        }
        echo '<div class="updated"><p>Settings saved successfully.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Travotech Settings</h1>
        <form method="post">
            <?php wp_nonce_field( 'travotech_settings_save' ); ?>
            <table class="form-table">
                <tr>
                    <th>WhatsApp Number</th>
                    <td>
                        <input type="text" name="travotech_wa" value="<?php echo esc_attr( travotech_wa() ); ?>" class="regular-text">
                        <p class="description">Numbers only, no spaces or + e.g. <strong>254720737151</strong></p>
                    </td>
                </tr>
                <tr>
                    <th>Display Phone</th>
                    <td>
                        <input type="text" name="travotech_phone" value="<?php echo esc_attr( travotech_phone() ); ?>" class="regular-text">
                        <p class="description">Displayed in header/footer e.g. <strong>+254 720 737 151</strong></p>
                    </td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><input type="text" name="travotech_address" value="<?php echo esc_attr( travotech_address() ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Tagline</th>
                    <td><input type="text" name="travotech_tagline" value="<?php echo esc_attr( travotech_tagline() ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Display Email</th>
                    <td><input type="text" name="travotech_email" value="<?php echo esc_attr( travotech_email() ); ?>" class="regular-text"></td>
                </tr>
            </table>
            <?php submit_button( 'Save Settings', 'primary', 'travotech_save' ); ?>
        </form>
    </div>
    <?php
}

// ─── SCHEMA MARKUP ────────────────────────────
function travotech_schema() {
    if ( is_admin() ) return;
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Pharmacy',
        'name'        => get_bloginfo( 'name' ),
        'description' => get_bloginfo( 'description' ),
        'url'         => home_url( '/' ),
        'telephone'   => travotech_phone(),
        'address'     => [
            '@type'           => 'PostalAddress',
            'addressLocality' => travotech_address(),
            'addressCountry'  => 'KE',
        ],
        'contactPoint' => [
            '@type'       => 'ContactPoint',
            'contactType' => 'customer service',
            'telephone'   => travotech_phone(),
        ],
    ];
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'travotech_schema' );

// ─── MISC ─────────────────────────────────────
add_filter( 'excerpt_length', function () { return 18; }, 999 );
add_filter( 'excerpt_more',   function () { return '...'; } );

add_action( 'init', function () {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
} );

// ════════════════════════════════════════════════════════════════════════════
// ─── YOAST SEO: AUTO-FILL FOCUS KEYPHRASE FROM PRODUCT TITLE ────────────
//
// - New products: keyphrase is set automatically on save (only if empty)
// - Existing products: bulk-filled once on first load, never runs again
// - Manual keyphrases are never overwritten
// ════════════════════════════════════════════════════════════════════════════

// Auto-fill on save for new & edited products
add_action( 'save_post_product', 'travotech_auto_yoast_keyphrase', 10, 2 );
function travotech_auto_yoast_keyphrase( $post_id, $post ) {

    // Skip autosaves and revisions
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( wp_is_post_revision( $post_id ) ) return;

    // Only run if Yoast SEO is active
    if ( ! defined( 'WPSEO_VERSION' ) ) return;

    // Only fill if keyphrase is currently empty
    $existing = get_post_meta( $post_id, '_yoast_wpseo_focuskw', true );
    if ( ! empty( $existing ) ) return;

    update_post_meta( $post_id, '_yoast_wpseo_focuskw', $post->post_title );
}

// Bulk-fill all existing products — runs once only
add_action( 'init', 'travotech_bulk_yoast_keyphrase_once' );
function travotech_bulk_yoast_keyphrase_once() {

    // Only run if Yoast is active
    if ( ! defined( 'WPSEO_VERSION' ) ) return;

    // Skip if already done
    if ( get_option( 'travotech_yoast_kw_filled' ) ) return;

    $products = get_posts( [
        'post_type'      => 'product',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ] );

    foreach ( $products as $id ) {
        $existing = get_post_meta( $id, '_yoast_wpseo_focuskw', true );
        if ( empty( $existing ) ) {
            $title = get_the_title( $id );
            update_post_meta( $id, '_yoast_wpseo_focuskw', $title );
        }
    }

    // Mark as done so this never runs again
    update_option( 'travotech_yoast_kw_filled', true );
}

require_once get_template_directory() . '/inc/trv-seo.php';

/* travotech_shop_per_page: 10 per page on phones, 9 on desktop and tablets */
add_filter( 'loop_shop_per_page', function ( $n ) { return ( isset( $_SERVER['HTTP_USER_AGENT'] ) && false !== stripos( $_SERVER['HTTP_USER_AGENT'], 'Mobi' ) ) ? 10 : 9; }, 20 );
