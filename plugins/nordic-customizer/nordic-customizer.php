<?php
/**
 * Plugin Name:       Nordic Customizer
 * Plugin URI:        https://github.com/YOUR_USERNAME/nordic-store-wp
 * Description:       Small helper plugin for the Nordic & Co store.
 *                    Adds [nordic_featured] shortcode and a "New Arrival" product badge.
 * Version:           1.1.0
 * Author:            Islam
 * Author URI:        https://www.upwork.com/freelancers/~YOUR_ID
 * Text Domain:       nordic-customizer
 * Requires at least: 6.0
 * Requires PHP:      8.0
 */

defined( 'ABSPATH' ) || exit;


/* ─── [nordic_featured] shortcode ────────────────────────── */

/**
 * Outputs a grid of featured products.
 *
 * Usage: [nordic_featured limit="4" category="living-room"]
 */
add_shortcode( 'nordic_featured', 'nordic_featured_shortcode' );

function nordic_featured_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'limit'    => 4,
        'category' => '',
        'columns'  => 4,
    ], $atts, 'nordic_featured' );

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => (int) $atts['limit'],
        'tax_query'      => [
            [
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
            ],
        ],
    ];

    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $atts['category'] ),
        ];
    }

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return '';
    }

    ob_start();
    echo '<div class="nc-featured-products columns-' . esc_attr( $atts['columns'] ) . '">';

    while ( $query->have_posts() ) {
        $query->the_post();
        wc_get_template_part( 'content', 'product' );
    }

    wp_reset_postdata();
    echo '</div>';

    return ob_get_clean();
}


/* ─── "New Arrival" badge for recent products ────────────── */

add_action( 'woocommerce_before_shop_loop_item_title', 'nordic_new_arrival_badge', 5 );

function nordic_new_arrival_badge() {
    global $product;

    $created = $product->get_date_created();
    if ( ! $created ) {
        return;
    }

    // Show badge if product was added in the last 30 days
    $days_old = ( time() - $created->getTimestamp() ) / DAY_IN_SECONDS;

    if ( $days_old <= 30 ) {
        echo '<span class="nc-badge nc-badge--new">New</span>';
    }
}


/* ─── Badge styles (inline, avoids extra HTTP request) ───── */

add_action( 'wp_head', 'nordic_badge_styles' );

function nordic_badge_styles() {
    ?>
    <style>
    .nc-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #2d4a3e;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: 2px;
        z-index: 2;
        line-height: 1.4;
    }
    .nc-badge--new { background: #8b7355; }
    ul.products li.product { position: relative; }
    </style>
    <?php
}
