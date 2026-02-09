<?php
/**
 * Template Part: Sponsor Banner
 *
 * Displays a horizontal strip of sponsor logos.
 * Can be included on any page as a reusable component.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$sponsors = mmff_get_sponsors();

if ( ! $sponsors->have_posts() ) {
    return;
}
?>
<section class="sponsor-banner" aria-label="<?php esc_attr_e( 'Our Sponsors', 'mmff-festival' ); ?>">
    <div class="sponsor-banner__container">
        <h2 class="sponsor-banner__heading screen-reader-text"><?php esc_html_e( 'Sponsors', 'mmff-festival' ); ?></h2>
        <div class="sponsor-banner__track">
            <?php while ( $sponsors->have_posts() ) : $sponsors->the_post(); ?>
                <?php
                $sponsor_url = get_post_meta( get_the_ID(), '_sponsor_url', true );
                $has_link    = ! empty( $sponsor_url );
                ?>
                <div class="sponsor-banner__item">
                    <?php if ( $has_link ) : ?>
                        <a href="<?php echo esc_url( $sponsor_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( sprintf( __( 'Visit %s website', 'mmff-festival' ), get_the_title() ) ); ?>">
                    <?php endif; ?>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'sponsor-logo', array(
                            'class'   => 'sponsor-banner__logo',
                            'loading' => 'lazy',
                            'alt'     => esc_attr( get_the_title() ),
                        ) ); ?>
                    <?php else : ?>
                        <span class="sponsor-banner__name"><?php the_title(); ?></span>
                    <?php endif; ?>

                    <?php if ( $has_link ) : ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>
