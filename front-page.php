<?php
/**
 * Front Page Template
 *
 * Homepage with hero banner, festival highlights, featured films,
 * and sponsor banner strip.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$hero_image    = get_theme_mod( 'mmff_hero_image', '' );
$hero_title    = get_theme_mod( 'mmff_hero_title', 'Migration Matters Film Festival' );
$hero_subtitle = get_theme_mod( 'mmff_hero_subtitle', 'February 20-22, 2026 | Stockholm, Sweden' );
$hero_tagline  = get_theme_mod( 'mmff_hero_tagline', 'Where art sparks dialogue and builds an inclusive stage' );
?>

<main id="main-content" class="site-main" role="main">

    <!-- Hero Section -->
    <section class="hero" aria-label="<?php esc_attr_e( 'Festival Introduction', 'mmff-festival' ); ?>"<?php if ( $hero_image ) : ?> style="background-image: url(<?php echo esc_url( $hero_image ); ?>);"<?php endif; ?>>
        <div class="hero__overlay" aria-hidden="true"></div>
        <div class="hero__container">
            <div class="hero__content">
                <h1 class="hero__title"><?php echo esc_html( $hero_title ); ?></h1>
                <p class="hero__dates"><?php echo esc_html( $hero_subtitle ); ?></p>

                <?php if ( $hero_tagline ) : ?>
                    <p class="hero__tagline"><?php echo esc_html( $hero_tagline ); ?></p>
                <?php endif; ?>

                <div class="hero__actions">
                    <a href="<?php echo esc_url( home_url( '/program/' ) ); ?>" class="hero__btn hero__btn--primary">
                        <?php esc_html_e( 'View Program', 'mmff-festival' ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="hero__btn hero__btn--secondary">
                        <?php esc_html_e( 'About the Festival', 'mmff-festival' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Festival Highlights -->
    <section class="highlights" aria-labelledby="highlights-heading">
        <div class="highlights__container">
            <h2 id="highlights-heading" class="highlights__heading"><?php esc_html_e( 'Why MMFF?', 'mmff-festival' ); ?></h2>
            <div class="highlights__grid">

                <div class="highlights__card">
                    <div class="highlights__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40">
                            <path d="M15.5 5.5L18 8l-6 6-4-4 6-6z"></path>
                            <path d="M15.5 5.5l2.5-2.5 4 4-2.5 2.5"></path>
                            <path d="M6 14l-3.5 3.5a2.12 2.12 0 0 0 3 3L9 17"></path>
                            <path d="M14.5 5.5l-8 8"></path>
                        </svg>
                    </div>
                    <h3 class="highlights__card-title"><?php esc_html_e( 'Powerful Storytelling', 'mmff-festival' ); ?></h3>
                    <p class="highlights__card-text">
                        <?php esc_html_e( 'Curated films that illuminate the human experience of migration, displacement, and the search for belonging through compelling narratives.', 'mmff-festival' ); ?>
                    </p>
                </div>

                <div class="highlights__card">
                    <div class="highlights__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="highlights__card-title"><?php esc_html_e( 'Inclusive Community', 'mmff-festival' ); ?></h3>
                    <p class="highlights__card-text">
                        <?php esc_html_e( 'A welcoming space where filmmakers, audiences, and communities come together to share perspectives and foster understanding across cultures.', 'mmff-festival' ); ?>
                    </p>
                </div>

                <div class="highlights__card">
                    <div class="highlights__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <h3 class="highlights__card-title"><?php esc_html_e( 'Art as Catalyst', 'mmff-festival' ); ?></h3>
                    <p class="highlights__card-text">
                        <?php esc_html_e( 'Cinema as a catalyst for social change -- sparking dialogue, challenging assumptions, and inspiring action for a more just and connected world.', 'mmff-festival' ); ?>
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Featured Films -->
    <?php
    $featured_films = new WP_Query( array(
        'post_type'      => 'film',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( $featured_films->have_posts() ) :
    ?>
    <section class="featured-films" aria-labelledby="featured-films-heading">
        <div class="featured-films__container">
            <div class="featured-films__header">
                <h2 id="featured-films-heading" class="featured-films__heading"><?php esc_html_e( 'Featured Films', 'mmff-festival' ); ?></h2>
                <a href="<?php echo esc_url( home_url( '/program/' ) ); ?>" class="featured-films__view-all">
                    <?php esc_html_e( 'View full program', 'mmff-festival' ); ?>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="featured-films__grid">
                <?php while ( $featured_films->have_posts() ) : $featured_films->the_post(); ?>
                    <?php get_template_part( 'template-parts/film-card' ); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php
    wp_reset_postdata();
    endif;
    ?>

    <!-- Sponsor Banner Strip -->
    <?php get_template_part( 'template-parts/sponsor-banner' ); ?>

</main>

<?php
get_footer();
