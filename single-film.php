<?php
/**
 * Single Film Template
 *
 * Displays a single film with full metadata, poster image,
 * synopsis, and related films section.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

while ( have_posts() ) : the_post();

    $film_id        = get_the_ID();
    $director       = get_post_meta( $film_id, '_film_director', true );
    $producer       = get_post_meta( $film_id, '_film_producer', true );
    $duration       = get_post_meta( $film_id, '_film_duration', true );
    $film_type      = get_post_meta( $film_id, '_film_type', true );
    $screening_date = get_post_meta( $film_id, '_film_screening_date', true );
    $screening_time = get_post_meta( $film_id, '_film_screening_time', true );
    $countries      = wp_get_post_terms( $film_id, 'film_country', array( 'fields' => 'names' ) );
    $languages      = wp_get_post_terms( $film_id, 'film_language', array( 'fields' => 'names' ) );
    $categories     = wp_get_post_terms( $film_id, 'film_category', array( 'fields' => 'names' ) );
    $years          = wp_get_post_terms( $film_id, 'film_year', array( 'fields' => 'names' ) );
?>

<main id="main-content" class="site-main" role="main">

    <article <?php post_class( 'single-film' ); ?>>

        <!-- Film Hero -->
        <section class="single-film__hero">
            <div class="single-film__hero-container">
                <div class="single-film__layout">

                    <!-- Poster -->
                    <div class="single-film__poster">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'film-poster', array(
                                'class' => 'single-film__poster-image',
                                'alt'   => esc_attr( sprintf( __( 'Poster for %s', 'mmff-festival' ), get_the_title() ) ),
                            ) ); ?>
                        <?php else : ?>
                            <div class="single-film__poster-placeholder" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="64" height="64">
                                    <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect>
                                    <line x1="7" y1="2" x2="7" y2="22"></line>
                                    <line x1="17" y1="2" x2="17" y2="22"></line>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <line x1="2" y1="7" x2="7" y2="7"></line>
                                    <line x1="2" y1="17" x2="7" y2="17"></line>
                                    <line x1="17" y1="7" x2="22" y2="7"></line>
                                    <line x1="17" y1="17" x2="22" y2="17"></line>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Film Details -->
                    <div class="single-film__details">

                        <header class="single-film__header">
                            <?php if ( $film_type ) : ?>
                                <span class="single-film__type-badge"><?php echo esc_html( ucfirst( $film_type ) ); ?></span>
                            <?php endif; ?>
                            <h1 class="single-film__title"><?php the_title(); ?></h1>
                        </header>

                        <dl class="single-film__meta">
                            <?php if ( $director ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Director', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( $director ); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( $producer ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Producer', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( $producer ); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( $duration ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Duration', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( $duration ); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( $film_type ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Type', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( ucfirst( $film_type ) ); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $countries ) && ! is_wp_error( $countries ) ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Country', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( implode( ', ', $countries ) ); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $languages ) && ! is_wp_error( $languages ) ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Language', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( implode( ', ', $languages ) ); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Category', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( implode( ', ', $categories ) ); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $years ) && ! is_wp_error( $years ) ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Festival Year', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( implode( ', ', $years ) ); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( $screening_date ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Screening Date', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value">
                                        <time datetime="<?php echo esc_attr( $screening_date ); ?>">
                                            <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $screening_date ) ) ); ?>
                                        </time>
                                    </dd>
                                </div>
                            <?php endif; ?>

                            <?php if ( $screening_time ) : ?>
                                <div class="single-film__meta-row">
                                    <dt class="single-film__meta-label"><?php esc_html_e( 'Screening Time', 'mmff-festival' ); ?></dt>
                                    <dd class="single-film__meta-value"><?php echo esc_html( $screening_time ); ?></dd>
                                </div>
                            <?php endif; ?>
                        </dl>

                        <a href="<?php echo esc_url( home_url( '/program/' ) ); ?>" class="single-film__back-link">
                            <span aria-hidden="true">&larr;</span>
                            <?php esc_html_e( 'Back to Program', 'mmff-festival' ); ?>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- Synopsis -->
        <?php if ( get_the_content() ) : ?>
            <section class="single-film__synopsis" aria-labelledby="synopsis-heading">
                <div class="single-film__synopsis-container">
                    <h2 id="synopsis-heading" class="single-film__section-title"><?php esc_html_e( 'Synopsis', 'mmff-festival' ); ?></h2>
                    <div class="single-film__synopsis-body entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </article>

    <!-- Related Films -->
    <?php
    // Build related films query based on shared taxonomies.
    $related_tax_query = array( 'relation' => 'OR' );

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        $category_terms = wp_get_post_terms( $film_id, 'film_category', array( 'fields' => 'ids' ) );
        if ( ! empty( $category_terms ) && ! is_wp_error( $category_terms ) ) {
            $related_tax_query[] = array(
                'taxonomy' => 'film_category',
                'field'    => 'term_id',
                'terms'    => $category_terms,
            );
        }
    }

    if ( ! empty( $countries ) && ! is_wp_error( $countries ) ) {
        $country_terms = wp_get_post_terms( $film_id, 'film_country', array( 'fields' => 'ids' ) );
        if ( ! empty( $country_terms ) && ! is_wp_error( $country_terms ) ) {
            $related_tax_query[] = array(
                'taxonomy' => 'film_country',
                'field'    => 'term_id',
                'terms'    => $country_terms,
            );
        }
    }

    $related_args = array(
        'post_type'      => 'film',
        'posts_per_page' => 3,
        'post__not_in'   => array( $film_id ),
        'orderby'        => 'rand',
    );

    if ( count( $related_tax_query ) > 1 ) {
        $related_args['tax_query'] = $related_tax_query;
    }

    $related_films = new WP_Query( $related_args );

    if ( $related_films->have_posts() ) :
    ?>
    <section class="related-films" aria-labelledby="related-films-heading">
        <div class="related-films__container">
            <h2 id="related-films-heading" class="related-films__heading"><?php esc_html_e( 'Related Films', 'mmff-festival' ); ?></h2>
            <div class="related-films__grid">
                <?php while ( $related_films->have_posts() ) : $related_films->the_post(); ?>
                    <?php get_template_part( 'template-parts/film-card' ); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php
    wp_reset_postdata();
    endif;
    ?>

<?php endwhile; ?>

</main>

<?php
get_footer();
