
<?php
/**
 * Grabit single-product content template.
 * Keeps WooCommerce's native product features and hooks.
 */

defined('ABSPATH') || exit;

global $product;

if (!$product instanceof WC_Product) {
    $product = wc_get_product(get_the_ID());
}

if (!$product) {
    return;
}

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WordPress-generated password form.
    return;
}
?>

<div id="product-<?php the_ID(); ?>"
     <?php wc_product_class('grabit-single-product', $product); ?>>

    <div class="grabit-product-breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span aria-hidden="true">/</span>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Shop</a>
        <span aria-hidden="true">/</span>
        <span><?php echo esc_html($product->get_name()); ?></span>
    </div>

    <div class="grabit-product-layout">

        <div class="grabit-product-gallery">
            <?php
            /**
             * WooCommerce handles the product image gallery and sale badge.
             */
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>

        <div class="summary entry-summary grabit-product-summary">
            <div class="grabit-product-label">
                <span class="grabit-product-label-dot"></span>
                PRODUCT DETAILS
            </div>

            <?php
            /**
             * Keep WooCommerce's title, rating, price, description,
             * add-to-cart form, SKU, categories and structured data.
             */
            do_action('woocommerce_single_product_summary');
            ?>

            <div class="grabit-product-trust">
                <div>
                    <span aria-hidden="true">✓</span>
                    <span>Secure checkout options</span>
                </div>
                <div>
                    <span aria-hidden="true">◇</span>
                    <span>Product details and stock from WooCommerce</span>
                </div>
            </div>
        </div>

    </div>

    <div class="grabit-product-extras">
        <?php
        /**
         * Keep WooCommerce description/review tabs, upsells and related products.
         */
        do_action('woocommerce_after_single_product_summary');
        ?>
    </div>

</div>

<?php do_action('woocommerce_after_single_product'); ?>
