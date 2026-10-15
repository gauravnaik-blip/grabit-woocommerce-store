
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
        <?php bloginfo('name'); ?>
    </a>

    <nav class="site-nav" aria-label="Primary navigation">
        <?php
        if (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-nav-list'
            ));
        } else {
            ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>

            <?php if (class_exists('WooCommerce')) : ?>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">
                    Shop
                </a>
            <?php endif; ?>

            <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a>
            <?php
        }
        ?>

        <?php if (class_exists('WooCommerce')) : ?>

            <a href="<?php echo esc_url(wc_get_cart_url()); ?>">
                Cart
                <?php if (WC()->cart) : ?>
                    (<?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>)
                <?php endif; ?>
            </a>

            <a class="grabit-login-link"
               href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                <?php
                echo is_user_logged_in()
                    ? 'My Account'
                    : 'Login / Sign Up';
                ?>
            </a>

        <?php endif; ?>

        <button type="button" class="theme-toggle" aria-label="Switch theme">
            ☀️ Light
        </button>
    </nav>
</header>
