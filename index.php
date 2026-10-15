
<?php get_header(); ?>

<main>
    <section class="hero">
        <h1>Discover Something Amazing</h1>
        <p>Explore our collection and find your next favourite.</p>
        <a class="button" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">
            Shop Now
        </a>
    </section>

    <section class="content">
        <h2>Latest Products</h2>

        <?php
        if (class_exists('WooCommerce')) {
            echo do_shortcode('[products limit="8" columns="4" orderby="date"]');
        } else {
            echo '<p>Our store is coming soon.</p>';
        }
        ?>
    </section>
</main>

<?php get_footer(); ?>
