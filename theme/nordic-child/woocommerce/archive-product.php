<?php
/**
 * Custom product archive template — Nordic & Co
 *
 * Overrides WooCommerce's default archive-product.php to add
 * a category hero banner, adjust the results count position,
 * and inject the featured-products shortcode at the top.
 *
 * @package nordic-child
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<?php
// Hero banner for category pages
if ( is_product_category() ) {
    $term        = get_queried_object();
    $thumbnail   = get_term_meta( $term->term_id, 'thumbnail_id', true );
    $banner_url  = $thumbnail ? wp_get_attachment_image_url( $thumbnail, 'full' ) : '';
    ?>
    <div class="nc-category-hero" <?php echo $banner_url ? 'style="background-image:url(' . esc_url( $banner_url ) . ')"' : ''; ?>>
        <div class="nc-category-hero__inner">
            <h1 class="nc-category-hero__title"><?php echo esc_html( $term->name ); ?></h1>
            <?php if ( $term->description ) : ?>
                <p class="nc-category-hero__desc"><?php echo esc_html( $term->description ); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php woocommerce_content(); ?>

    </main>
</div>

<?php get_footer( 'shop' );
