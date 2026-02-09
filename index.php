<?php
/**
 * Main Index Template
 *
 * The default template for blog/archive views.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="site-main" role="main">
    <div class="site-main__container">

        <?php if ( is_home() && ! is_front_page() ) : ?>
            <header class="page-header">
                <h1 class="page-header__title"><?php single_post_title(); ?></h1>
            </header>
        <?php elseif ( is_archive() ) : ?>
            <header class="page-header">
                <?php the_archive_title( '<h1 class="page-header__title">', '</h1>' ); ?>
                <?php the_archive_description( '<div class="page-header__description">', '</div>' ); ?>
            </header>
        <?php elseif ( is_search() ) : ?>
            <header class="page-header">
                <h1 class="page-header__title">
                    <?php
                    printf(
                        /* translators: %s: search query */
                        esc_html__( 'Search results for: %s', 'mmff-festival' ),
                        '<span>' . esc_html( get_search_query() ) . '</span>'
                    );
                    ?>
                </h1>
            </header>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-card__thumbnail">
                                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                    <?php the_post_thumbnail( 'medium_large', array( 'class' => 'post-card__image', 'loading' => 'lazy' ) ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-card__content">
                            <header class="post-card__header">
                                <time class="post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </time>
                                <h2 class="post-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                            </header>

                            <div class="post-card__excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="post-card__read-more">
                                <?php esc_html_e( 'Read more', 'mmff-festival' ); ?>
                                <span class="screen-reader-text"><?php echo esc_html( sprintf( __( 'about %s', 'mmff-festival' ), get_the_title() ) ); ?></span>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <nav class="pagination" aria-label="<?php esc_attr_e( 'Posts navigation', 'mmff-festival' ); ?>">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => sprintf(
                        '<span aria-hidden="true">&larr;</span> <span class="screen-reader-text">%s</span>',
                        esc_html__( 'Previous page', 'mmff-festival' )
                    ),
                    'next_text' => sprintf(
                        '<span class="screen-reader-text">%s</span> <span aria-hidden="true">&rarr;</span>',
                        esc_html__( 'Next page', 'mmff-festival' )
                    ),
                ) );
                ?>
            </nav>

        <?php else : ?>
            <div class="no-results">
                <h2 class="no-results__title"><?php esc_html_e( 'Nothing found', 'mmff-festival' ); ?></h2>
                <p class="no-results__message">
                    <?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Try a different search or browse our festival program.', 'mmff-festival' ); ?>
                </p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
