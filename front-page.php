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

    <!-- Film Highlights Gallery -->
    <?php
    $featured_films = new WP_Query( array(
        'post_type'      => 'film',
        'posts_per_page' => 12,
        'orderby'        => 'rand',
        'meta_query'     => array(
            array(
                'key'     => '_thumbnail_id',
                'compare' => 'EXISTS',
            ),
        ),
    ) );

    if ( $featured_films->have_posts() ) :
    ?>
    <section class="featured-films" aria-labelledby="featured-films-heading">
        <div class="featured-films__container">
            <div class="featured-films__header">
                <h2 id="featured-films-heading" class="featured-films__heading"><?php esc_html_e( 'Film Highlights', 'mmff-festival' ); ?></h2>
                <a href="<?php echo esc_url( home_url( '/program/' ) ); ?>" class="featured-films__view-all">
                    <?php esc_html_e( 'View full program', 'mmff-festival' ); ?>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="featured-films__gallery">
                <?php while ( $featured_films->have_posts() ) : $featured_films->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="gallery-item" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'film-card', array( 'class' => 'gallery-item__image', 'loading' => 'lazy' ) ); ?>
                        <?php endif; ?>
                        <div class="gallery-item__overlay">
                            <h3 class="gallery-item__title"><?php the_title(); ?></h3>
                            <?php $director = get_post_meta( get_the_ID(), '_film_director', true ); ?>
                            <?php if ( $director ) : ?>
                                <p class="gallery-item__director"><?php echo esc_html( $director ); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
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
