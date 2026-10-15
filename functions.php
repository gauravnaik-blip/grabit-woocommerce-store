
<?php
function mystorecrm_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    register_nav_menus(array(
        'primary' => 'Primary Menu'
    ));
}
add_action('after_setup_theme', 'mystorecrm_setup');

function mystorecrm_assets() {
    wp_enqueue_style(
        'mystorecrm-style',
        get_stylesheet_uri(),
        array(),
        '1.1'
    );

    $script = <<<'JS'
(function () {
    const root = document.documentElement;
    const button = document.querySelector('.theme-toggle');

    let savedTheme = null;

    try {
        savedTheme = localStorage.getItem('mystorecrm-theme');
    } catch (e) {}

    const theme = savedTheme === 'light' ? 'light' : 'dark';
    root.setAttribute('data-theme', theme);

    function updateButton() {
        if (!button) return;

        const current = root.getAttribute('data-theme');
        button.textContent = current === 'dark' ? '☀️ Light' : '🌙 Dark';
        button.setAttribute('aria-label',
            current === 'dark' ? 'Switch to light theme' : 'Switch to dark theme'
        );
    }

    if (button) {
        updateButton();

        button.addEventListener('click', function () {
            const current = root.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';

            root.setAttribute('data-theme', next);

            try {
                localStorage.setItem('mystorecrm-theme', next);
            } catch (e) {}

            updateButton();
        });
    }
})();
JS;

    wp_register_script('mystorecrm-theme', '', array(), '1.1', true);
    wp_enqueue_script('mystorecrm-theme');
    wp_add_inline_script('mystorecrm-theme', $script);
}
add_action('wp_enqueue_scripts', 'mystorecrm_assets');

/**
 * Grabit: Require login before adding products to the cart.
 */
add_filter(
    'woocommerce_add_to_cart_validation',
    'grabit_require_login_before_add_to_cart',
    10,
    3
);

function grabit_require_login_before_add_to_cart($passed, $product_id, $quantity) {
    if (!is_user_logged_in()) {
        $login_url = wc_get_page_permalink('myaccount');

        wc_add_notice(
            sprintf(
                'Please <a href="%s">log in or create an account</a> before adding products to your cart.',
                esc_url($login_url)
            ),
            'error'
        );

        return false;
    }

    return $passed;
}
