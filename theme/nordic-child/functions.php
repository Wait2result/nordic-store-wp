<?php
/**
 * Nordic & Co Child Theme — functions.php
 *
 * Enqueues parent and child styles, registers customizations
 * for the WooCommerce store: product badge, custom logo size,
 * and a few performance tweaks.
 */

defined( 'ABSPATH' ) || exit;


/* ─── Enqueue styles ─────────────────────────────────────── */

add_action( 'wp_enqueue_scripts', 'nordic_enqueue_styles' );

function nordic_enqueue_styles() {
    // Google Fonts — Jost (matches brand typography)
    wp_enqueue_style(
        'nordic-fonts',
        'https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap',
        [],
        null
    );

    // Parent theme
    wp_enqueue_style(
        'storefront-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'storefront' )->get( 'Version' )
    );

    // Child theme overrides
    wp_enqueue_style(
        'nordic-child-style',
        get_stylesheet_uri(),
        [ 'storefront-style' ],
        wp_get_theme()->get( 'Version' )
    );
}


/* ─── Custom header logo size ────────────────────────────── */

// The default Storefront logo is too large for the brand's minimal aesthetic
add_theme_support( 'custom-logo', [
    'height'      => 60,
    'width'       => 200,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => [ 'site-title', 'site-description' ],
] );


/* ─── Sale badge — replace "Sale!" with percentage off ──── */

add_filter( 'woocommerce_sale_flash', 'nordic_custom_sale_badge', 10, 3 );

function nordic_custom_sale_badge( $html, $post, $product ) {
    if ( $product->is_type( 'variable' ) ) {
        // Variable products: show generic badge
        return '<span class="onsale nc-badge">Sale</span>';
    }

    $regular = (float) $product->get_regular_price();
    $sale    = (float) $product->get_sale_price();

    if ( $regular > 0 && $sale > 0 ) {
        $pct = round( ( ( $regular - $sale ) / $regular ) * 100 );
        return '<span class="onsale nc-badge">−' . $pct . '%</span>';
    }

    return $html;
}


/* ─── Remove unnecessary scripts on shop pages ───────────── */

// Jetpack's device-detection script adds ~30 KB and is unused here
add_action( 'wp_enqueue_scripts', 'nordic_dequeue_unused', 20 );

function nordic_dequeue_unused() {
    if ( is_shop() || is_product() || is_product_category() ) {
        wp_dequeue_script( 'devicepx' );
    }
}


/* ─── Change number of products per row ─────────────────── */

add_filter( 'loop_shop_columns', function() { return 3; } );


/* ─── Custom image size for product thumbnails ───────────── */

add_image_size( 'nordic-product-thumb', 480, 600, true );
