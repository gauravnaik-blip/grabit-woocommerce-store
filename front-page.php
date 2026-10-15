
<?php
/**
 * Grabit Custom Homepage
 * Uses existing WordPress theme header/footer and WooCommerce products.
 */

get_header();

$shop_url = function_exists('wc_get_page_permalink')
    ? wc_get_page_permalink('shop')
    : home_url('/shop/');

$categories = array(
    array('name' => 'Audio & Sound', 'slug' => 'audio', 'icon' => '♫', 'description' => 'Headphones, earbuds & speakers'),
    array('name' => 'Smart Wearables', 'slug' => 'wearables', 'icon' => '◉', 'description' => 'Smartwatches & everyday tech'),
    array('name' => 'Gaming Gear', 'slug' => 'gaming', 'icon' => '⌘', 'description' => 'Level up your setup'),
    array('name' => 'Accessories', 'slug' => 'accessories', 'icon' => '✳', 'description' => 'Useful tech for every day'),
);

$products = array();

if (function_exists('wc_get_products')) {
    $products = wc_get_products(array(
        'status'  => 'publish',
        'limit'   => 8,
        'orderby' => 'date',
        'order'   => 'DESC',
        'return'  => 'objects',
    ));
}
?>

<main id="primary" class="grabit-home">

    <!-- HERO -->
    <section class="grabit-hero">
        <div class="grabit-hero-glow grabit-glow-one"></div>
        <div class="grabit-hero-glow grabit-glow-two"></div>

        <div class="grabit-hero-content">
            <span class="grabit-eyebrow">
                <span class="grabit-live-dot"></span>
                YOUR NEXT-LEVEL TECH STORE
            </span>

            <h1>
                Upgrade your world.<br>
                <span>Power your vibe.</span>
            </h1>

            <p>
                Discover everyday tech, immersive audio, smart wearables
                and gaming essentials made for your lifestyle.
            </p>

            <div class="grabit-hero-actions">
                <a class="grabit-btn grabit-btn-primary"
                   href="<?php echo esc_url($shop_url); ?>">
                    Explore the store <span aria-hidden="true">↗</span>
                </a>

                <a class="grabit-btn grabit-btn-secondary"
                   href="#grabit-featured">
                    Discover products <span aria-hidden="true">↓</span>
                </a>
            </div>

            <div class="grabit-hero-note">
                <span>✦</span> Find your next favourite gadget.
            </div>
        </div>

        <div class="grabit-hero-art" aria-hidden="true">
            <div class="grabit-orbit grabit-orbit-one"></div>
            <div class="grabit-orbit grabit-orbit-two"></div>

            <div class="grabit-art-core">
                <div class="grabit-art-symbol">G<span>.</span></div>
                <div class="grabit-art-caption">TECH THAT MOVES YOU</div>
            </div>

            <div class="grabit-float-card grabit-float-top">
                <span class="grabit-float-icon">✦</span>
                <span><strong>FUTURE READY</strong><small>Find your next upgrade</small></span>
            </div>

            <div class="grabit-float-card grabit-float-bottom">
                <span class="grabit-float-icon">⌁</span>
                <span><strong>YOUR TECH. YOUR STYLE.</strong><small>Make it yours</small></span>
            </div>
        </div>
    </section>

    <!-- BENEFITS STRIP -->
    <section class="grabit-benefits" aria-label="Store highlights">
        <div><span>✧</span> Curated tech essentials</div>
        <div><span>◈</span> Discover your next favourite</div>
        <div><span>↗</span> Shop your way</div>
    </section>

    <!-- CATEGORIES -->
    <section class="grabit-section" id="grabit-categories">
        <div class="grabit-section-heading">
            <div>
                <span class="grabit-section-kicker">EXPLORE YOUR INTERESTS</span>
                <h2>Shop by <span>category.</span></h2>
                <p>Find the gear that fits your everyday life.</p>
            </div>

            <a class="grabit-text-link" href="<?php echo esc_url($shop_url); ?>">
                View all products <span aria-hidden="true">↗</span>
            </a>
        </div>

        <div class="grabit-category-grid">
            <?php foreach ($categories as $category) :
                $term = get_term_by('slug', $category['slug'], 'product_cat');

                $category_url = $term && !is_wp_error($term)
                    ? get_term_link($term)
                    : $shop_url;
            ?>
                <a class="grabit-category-card"
                   href="<?php echo esc_url($category_url); ?>">
                    <span class="grabit-category-icon" aria-hidden="true">
                        <?php echo esc_html($category['icon']); ?>
                    </span>

                    <span class="grabit-category-info">
                        <strong><?php echo esc_html($category['name']); ?></strong>
                        <small><?php echo esc_html($category['description']); ?></small>
                    </span>

                    <span class="grabit-category-arrow" aria-hidden="true">↗</span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section class="grabit-section grabit-featured-section"
             id="grabit-featured">
        <div class="grabit-section-heading">
            <div>
                <span class="grabit-section-kicker">THE LATEST FINDS</span>
                <h2>Tech worth <span>checking out.</span></h2>
                <p>Explore the latest additions to your Grabit store.</p>
            </div>

            <a class="grabit-text-link" href="<?php echo esc_url($shop_url); ?>">
                Shop everything <span aria-hidden="true">↗</span>
            </a>
        </div>

        <?php if (!empty($products)) : ?>
            <div class="grabit-product-grid">
                <?php foreach ($products as $product) :
                    if (!$product || !$product->is_visible()) {
                        continue;
                    }

                    $product_id = $product->get_id();
                    $image_id   = $product->get_image_id();
                    $image_url  = $image_id
                        ? wp_get_attachment_image_url($image_id, 'woocommerce_thumbnail')
                        : '';

                    $product_url = get_permalink($product_id);
                    $is_purchasable = $product->is_purchasable();
                    $is_in_stock = $product->is_in_stock();
                ?>
                    <article class="grabit-product-card">
                        <a class="grabit-product-image"
                           href="<?php echo esc_url($product_url); ?>">

                            <?php if ($product->is_on_sale()) : ?>
                                <span class="grabit-sale-label">ON SALE</span>
                            <?php endif; ?>

                            <?php if ($image_url) : ?>
                                <?php echo wp_get_attachment_image(
                                    $image_id,
                                    'woocommerce_thumbnail',
                                    false,
                                    array(
                                        'class'   => 'grabit-product-img',
                                        'alt'     => esc_attr($product->get_name()),
                                        'loading' => 'lazy',
                                    )
                                ); ?>
                            <?php else : ?>
                                <span class="grabit-image-placeholder"
                                      aria-hidden="true">✧</span>
                            <?php endif; ?>

                            <span class="grabit-view-product">View product ↗</span>
                        </a>

                        <div class="grabit-product-details">
                            <h3>
                                <a href="<?php echo esc_url($product_url); ?>">
                                    <?php echo esc_html($product->get_name()); ?>
                                </a>
                            </h3>

                            <div class="grabit-product-price">
                                <?php echo wp_kses_post($product->get_price_html()); ?>
                            </div>

                            <div class="grabit-product-actions">
                                <a class="grabit-add-button"
                                   href="<?php echo esc_url($product_url); ?>">
                                    View details <span aria-hidden="true">↗</span>
                                </a>

                                <?php if ($is_purchasable && $is_in_stock && $product->is_type('simple')) : ?>
                                    <a class="grabit-cart-icon"
                                       aria-label="<?php echo esc_attr('Add ' . $product->get_name() . ' to cart'); ?>"
                                       href="<?php echo esc_url(
                                           add_query_arg(
                                               'add-to-cart',
                                               $product_id,
                                               $shop_url
                                           )
                                       ); ?>">
                                        +
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <div class="grabit-empty-products">
                <h3>Your next favourite gadget goes here.</h3>
                <p>Publish products in WooCommerce to display them on this homepage.</p>
                <a class="grabit-btn grabit-btn-primary"
                   href="<?php echo esc_url(admin_url('edit.php?post_type=product')); ?>">
                    Manage products
                </a>
            </div>
        <?php endif; ?>
    </section>

    <!-- FINAL CALL TO ACTION -->
    <section class="grabit-final-cta">
        <div>
            <span class="grabit-section-kicker">READY WHEN YOU ARE</span>
            <h2>Your next upgrade <span>starts here.</span></h2>
            <p>Explore the collection and find something that fits your vibe.</p>
        </div>

        <a class="grabit-btn grabit-btn-primary"
           href="<?php echo esc_url($shop_url); ?>">
            Explore Grabit <span aria-hidden="true">↗</span>
        </a>
    </section>

</main>

<?php get_footer(); ?>
