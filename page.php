
<?php
/**
 * Default page template for MyStoreCRM / Grabit.
 * Displays the content saved in the WordPress page editor.
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main grabit-page-content">

    <?php
    while (have_posts()) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('grabit-page'); ?>>

            <?php if (get_the_title() && !is_cart() && !is_checkout() && !is_account_page()) : ?>
                <header class="entry-header">
                    <h1 class="entry-title">
                        <?php the_title(); ?>
                    </h1>
                </header>
            <?php endif; ?>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">',
                    'after'  => '</div>',
                ));
                ?>
            </div>

        </article>

        <?php
    endwhile;
    ?>

</main>

<?php get_footer(); ?>
