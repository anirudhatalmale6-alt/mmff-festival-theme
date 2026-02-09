<?php
/**
 * Template Name: About
 *
 * Clean content layout for the About page.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="site-main" role="main">

    <article <?php post_class( 'page-about' ); ?>>

        <!-- Page Header -->
        <section class="page-hero">
            <div class="page-hero__container">
                <h1 class="page-hero__title"><?php the_title(); ?></h1>
            </div>
        </section>

        <!-- Page Content -->
        <section class="page-content">
            <div class="page-content__container page-content__container--narrow">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <figure class="page-content__featured-image">
                            <?php the_post_thumbnail( 'large', array( 'class' => 'page-content__image' ) ); ?>
                            <?php if ( get_the_post_thumbnail_caption() ) : ?>
                                <figcaption class="page-content__caption"><?php echo esc_html( get_the_post_thumbnail_caption() ); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>

                    <div class="page-content__body entry-content">
                        <?php the_content(); ?>
                    </div>

                <?php endwhile; endif; ?>
            </div>
        </section>

    </article>

</main>

<?php
get_footer();
