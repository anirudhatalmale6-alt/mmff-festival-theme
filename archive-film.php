<?php
/**
 * Film Archive Template
 *
 * Displays film archive/listing with filters, similar to the program page.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Gather taxonomy terms for filter dropdowns.
$years     = get_terms( array( 'taxonomy' => 'film_year', 'hide_empty' => true ) );
$countries = get_terms( array( 'taxonomy' => 'film_country', 'hide_empty' => true ) );
?>

<main id="main-content" class="site-main" role="main">

    <!-- Page Header -->
    <section class="page-hero">
        <div class="page-hero__container">
            <h1 class="page-hero__title"><?php esc_html_e( 'All Films', 'mmff-festival' ); ?></h1>
            <p class="page-hero__subtitle">
                <?php esc_html_e( 'Browse our complete collection of films from all festival editions.', 'mmff-festival' ); ?>
            </p>
        </div>
    </section>

    <!-- Filter Bar -->
    <section class="program-filters" aria-label="<?php esc_attr_e( 'Filter films', 'mmff-festival' ); ?>">
        <div class="program-filters__container">
            <form class="program-filters__form" id="film-filter-form" role="search" aria-label="<?php esc_attr_e( 'Search and filter films', 'mmff-festival' ); ?>">
                <div class="program-filters__group">
                    <label for="film-search" class="screen-reader-text"><?php esc_html_e( 'Search films', 'mmff-festival' ); ?></label>
                    <input
                        type="search"
                        id="film-search"
                        class="program-filters__search"
                        name="search"
                        placeholder="<?php esc_attr_e( 'Search films...', 'mmff-festival' ); ?>"
                        autocomplete="off"
                    >
                </div>

                <?php if ( ! empty( $years ) && ! is_wp_error( $years ) ) : ?>
                    <div class="program-filters__group">
                        <label for="film-year" class="screen-reader-text"><?php esc_html_e( 'Filter by year', 'mmff-festival' ); ?></label>
                        <select id="film-year" class="program-filters__select" name="year">
                            <option value=""><?php esc_html_e( 'All Years', 'mmff-festival' ); ?></option>
                            <?php foreach ( $years as $year ) : ?>
                                <option value="<?php echo esc_attr( $year->slug ); ?>"><?php echo esc_html( $year->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="program-filters__group">
                    <label for="film-type" class="screen-reader-text"><?php esc_html_e( 'Filter by type', 'mmff-festival' ); ?></label>
                    <select id="film-type" class="program-filters__select" name="film_type">
                        <option value=""><?php esc_html_e( 'All Types', 'mmff-festival' ); ?></option>
                        <option value="documentary"><?php esc_html_e( 'Documentary', 'mmff-festival' ); ?></option>
                        <option value="short"><?php esc_html_e( 'Short', 'mmff-festival' ); ?></option>
                        <option value="feature"><?php esc_html_e( 'Feature', 'mmff-festival' ); ?></option>
                        <option value="experimental"><?php esc_html_e( 'Experimental', 'mmff-festival' ); ?></option>
                    </select>
                </div>

                <?php if ( ! empty( $countries ) && ! is_wp_error( $countries ) ) : ?>
                    <div class="program-filters__group">
                        <label for="film-country" class="screen-reader-text"><?php esc_html_e( 'Filter by country', 'mmff-festival' ); ?></label>
                        <select id="film-country" class="program-filters__select" name="country">
                            <option value=""><?php esc_html_e( 'All Countries', 'mmff-festival' ); ?></option>
                            <?php foreach ( $countries as $country ) : ?>
                                <option value="<?php echo esc_attr( $country->slug ); ?>"><?php echo esc_html( $country->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="program-filters__group program-filters__group--actions">
                    <button type="submit" class="program-filters__submit">
                        <?php esc_html_e( 'Filter', 'mmff-festival' ); ?>
                    </button>
                    <button type="reset" class="program-filters__reset" id="film-filter-reset">
                        <?php esc_html_e( 'Clear', 'mmff-festival' ); ?>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Film Grid -->
    <section class="program-grid" aria-label="<?php esc_attr_e( 'Film listings', 'mmff-festival' ); ?>">
        <div class="program-grid__container">

            <div class="program-grid__status" id="film-results-status" aria-live="polite" aria-atomic="true">
                <?php
                global $wp_query;
                printf(
                    /* translators: %d: number of films */
                    esc_html( _n( '%d film found', '%d films found', $wp_query->found_posts, 'mmff-festival' ) ),
                    (int) $wp_query->found_posts
                );
                ?>
            </div>

            <div class="program-grid__loading" id="film-loading" hidden>
                <div class="program-grid__spinner" aria-hidden="true"></div>
                <span class="screen-reader-text"><?php esc_html_e( 'Loading films...', 'mmff-festival' ); ?></span>
            </div>

            <div class="program-grid__films" id="film-grid">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/film-card' ); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="program-grid__empty">
                        <p><?php esc_html_e( 'No films found matching your criteria.', 'mmff-festival' ); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <nav class="pagination" aria-label="<?php esc_attr_e( 'Film archive navigation', 'mmff-festival' ); ?>">
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

        </div>
    </section>

</main>

<?php
get_footer();
