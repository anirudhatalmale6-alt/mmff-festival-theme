<?php
/**
 * Template Part: Film Card
 *
 * Reusable film card component for grids and listings.
 * Expects to be called within a WP_Query loop.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$film_id        = get_the_ID();
$director       = get_post_meta( $film_id, '_film_director', true );
$duration       = get_post_meta( $film_id, '_film_duration', true );
$film_type      = get_post_meta( $film_id, '_film_type', true );
$screening_date = get_post_meta( $film_id, '_film_screening_date', true );
$screening_time = get_post_meta( $film_id, '_film_screening_time', true );
$countries      = wp_get_post_terms( $film_id, 'film_country', array( 'fields' => 'names' ) );
?>
<article class="film-card" data-film-id="<?php echo esc_attr( $film_id ); ?>">
    <a href="<?php the_permalink(); ?>" class="film-card__link" aria-label="<?php echo esc_attr( sprintf( __( 'View details for %s', 'mmff-festival' ), get_the_title() ) ); ?>">
        <div class="film-card__poster">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'film-card', array( 'class' => 'film-card__image', 'loading' => 'lazy' ) ); ?>
            <?php else : ?>
                <div class="film-card__placeholder" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="48" height="48">
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

            <?php if ( $film_type ) : ?>
                <span class="film-card__badge"><?php echo esc_html( ucfirst( $film_type ) ); ?></span>
            <?php endif; ?>
        </div>

        <div class="film-card__content">
            <h3 class="film-card__title"><?php the_title(); ?></h3>

            <?php if ( $director ) : ?>
                <p class="film-card__director"><?php echo esc_html( $director ); ?></p>
            <?php endif; ?>

            <div class="film-card__meta">
                <?php if ( $duration ) : ?>
                    <span class="film-card__duration">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <?php echo esc_html( $duration ); ?>
                    </span>
                <?php endif; ?>

                <?php if ( ! empty( $countries ) && ! is_wp_error( $countries ) ) : ?>
                    <span class="film-card__country"><?php echo esc_html( implode( ', ', $countries ) ); ?></span>
                <?php endif; ?>
            </div>

            <?php if ( $screening_date || $screening_time ) : ?>
                <div class="film-card__screening">
                    <?php if ( $screening_date ) : ?>
                        <span class="film-card__date">
                            <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $screening_date ) ) ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( $screening_time ) : ?>
                        <span class="film-card__time"><?php echo esc_html( $screening_time ); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </a>
</article>
