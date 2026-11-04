<?php
/**
 * Travotech Agencies — fonts and local SEO.
 * Titles, descriptions, social tags and LocalBusiness schema are only added when no SEO
 * plugin (Yoast, Rank Math, All in One SEO, SEOPress) is active.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'trv-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;600;700&display=swap',
        array(),
        null
    );
}, 5 );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
    if ( 'preconnect' === $relation ) {
        $urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
    }
    return $urls;
}, 10, 2 );

add_action( 'wp_head', function () {
    echo '<style id="trv-type">'
        . "body{font-family:'Inter',system-ui,-apple-system,'Segoe UI',Arial,sans-serif;font-size:1rem;line-height:1.65}"
        . "h1,h2,h3,h4,h5,h6{font-family:'Oswald','Arial Narrow',sans-serif;letter-spacing:.01em;line-height:1.2}"
        . 'button,input,select,textarea{font-family:inherit}'
        . "</style>\n";
}, 999 );

function trv_seo_plugin_active() {
    return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

function trv_seo_meta() {
    $brand = 'Travotech Agencies';

    if ( is_front_page() ) {
        return array(
            'title' => 'Lab & Hospital Equipment in Nairobi, Thika | ' . $brand,
            'desc'  => 'Top-quality lab and hospital equipment at pocket-friendly prices. Analyzers, hospital beds and patient monitors delivered in Nairobi, Thika and Kenya.',
        );
    }

    if ( function_exists( 'is_shop' ) && is_shop() ) {
        return array(
            'title' => 'Buy Medical & Lab Equipment in Kenya | ' . $brand,
            'desc'  => 'Shop affordable hematology analyzers, hospital beds, patient monitors and rapid tests. Professional supply and delivery in Nairobi, Thika and across Kenya.',
        );
    }

    if ( function_exists( 'is_product_category' ) && is_product_category() ) {
        $term = get_queried_object();
        if ( $term && ! empty( $term->name ) ) {
            return array(
                'title' => $term->name . ' for Sale in Nairobi, Thika & Kenya | ' . $brand,
                'desc'  => 'Affordable, professional ' . $term->name . ' from ' . $brand . '. Best prices in Kenya with delivery to Nairobi, Thika and nationwide. Request a quote today.',
            );
        }
    }

    if ( function_exists( 'is_product' ) && is_product() ) {
        $name = get_the_title();
        return array(
            'title' => $name . ' Price in Kenya | ' . $brand,
            'desc'  => 'Buy ' . $name . ' at an affordable price from ' . $brand . '. Professional supply in Nairobi, Thika and across Kenya. Order or request a quote on WhatsApp.',
        );
    }

    if ( is_page() ) {
        $obj  = get_queried_object();
        $slug = ( $obj && isset( $obj->post_name ) ) ? $obj->post_name : '';

        $pages = array(
            'about' => array(
                'slugs' => array( 'about-us', 'about' ),
                'title' => 'About ' . $brand . ' | Lab & Hospital Supplies Kenya',
                'desc'  => 'Meet ' . $brand . ', a professional Nairobi supplier of affordable laboratory and hospital equipment serving clinics, hospitals and labs in Thika and across Kenya.',
            ),
            'contact' => array(
                'slugs' => array( 'contact', 'contact-us' ),
                'title' => 'Contact ' . $brand . ' | Nairobi, Thika & Kenya',
                'desc'  => 'Call, WhatsApp or email ' . $brand . ' for a quote on lab and hospital equipment. Open Mon-Fri 8am-6pm, Sat 8:30am-1pm. Delivery in Nairobi, Thika and Kenya.',
            ),
            'return' => array(
                'slugs' => array( 'return-and-refund-policy', 'return-policy', 'refund-policy', 'returns' ),
                'title' => 'Return & Refund Policy | ' . $brand,
                'desc'  => 'Read the ' . $brand . ' return and refund policy for lab and hospital equipment bought in Nairobi, Thika and across Kenya.',
            ),
            'terms' => array(
                'slugs' => array( 'terms-and-conditions', 'terms', 'terms-conditions' ),
                'title' => 'Terms & Conditions | ' . $brand,
                'desc'  => 'Terms and conditions for buying professional lab and hospital equipment from ' . $brand . ' in Nairobi, Thika and across Kenya.',
            ),
        );

        foreach ( $pages as $p ) {
            if ( in_array( $slug, $p['slugs'], true ) ) {
                return array( 'title' => $p['title'], 'desc' => $p['desc'] );
            }
        }
    }

    return null;
}

if ( ! trv_seo_plugin_active() ) {

    add_filter( 'pre_get_document_title', function ( $title ) {
        $m = trv_seo_meta();
        return $m ? $m['title'] : $title;
    }, 20 );

    add_action( 'wp_head', function () {
        $m = trv_seo_meta();
        if ( ! $m ) {
            return;
        }

        $url  = is_singular() ? get_permalink() : home_url( add_query_arg( array() ) );
        $type = ( function_exists( 'is_product' ) && is_product() ) ? 'product' : 'website';

        $image = '';
        if ( is_singular() && has_post_thumbnail() ) {
            $image = get_the_post_thumbnail_url( null, 'large' );
        } elseif ( has_custom_logo() ) {
            $image = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
        }

        echo '<meta name="description" content="' . esc_attr( $m['desc'] ) . '">' . "\n";
        echo '<meta property="og:locale" content="en_KE">' . "\n";
        echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
        echo '<meta property="og:site_name" content="Travotech Agencies">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr( $m['title'] ) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( $m['desc'] ) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
        if ( $image ) {
            echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
        }
        echo '<meta name="twitter:card" content="' . ( $image ? 'summary_large_image' : 'summary' ) . '">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr( $m['title'] ) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr( $m['desc'] ) . '">' . "\n";
    }, 1 );

    add_action( 'wp_head', function () {
        $is_contact = is_page() && in_array( get_queried_object()->post_name, array( 'contact', 'contact-us' ), true );
        if ( ! is_front_page() && ! $is_contact ) {
            return;
        }

        $same = array();
        foreach ( array( 'facebook', 'instagram', 'tiktok', 'linkedin', 'x' ) as $net ) {
            foreach ( array( 'travotech_', 'trovatech_' ) as $prefix ) {
                $v = get_option( $prefix . $net, '' );
                if ( is_string( $v ) && '' !== trim( $v ) ) {
                    $same[] = esc_url_raw( trim( $v ) );
                    break;
                }
            }
        }

        $schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => array( 'LocalBusiness', 'Store' ),
            'name'        => 'Travotech Agencies Limited',
            'url'         => home_url( '/' ),
            'description' => 'Affordable, professional laboratory and hospital equipment supplier in Nairobi, serving Thika and all of Kenya.',
            'telephone'   => '+254720737151',
            'email'       => 'sales@travotechagencies.co.ke',
            'address'     => array(
                '@type'           => 'PostalAddress',
                'addressLocality' => 'Nairobi',
                'addressCountry'  => 'KE',
            ),
            'areaServed'  => array(
                array( '@type' => 'City', 'name' => 'Nairobi' ),
                array( '@type' => 'City', 'name' => 'Thika' ),
                array( '@type' => 'Country', 'name' => 'Kenya' ),
            ),
            'openingHoursSpecification' => array(
                array(
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
                    'opens'     => '08:00',
                    'closes'    => '18:00',
                ),
                array(
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => 'Saturday',
                    'opens'     => '08:30',
                    'closes'    => '13:00',
                ),
            ),
        );
        if ( has_custom_logo() ) {
            $schema['logo'] = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
        }
        if ( $same ) {
            $schema['sameAs'] = $same;
        }

        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
    }, 5 );
}