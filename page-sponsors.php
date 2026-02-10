<?php
/**
 * Template Name: Sponsors
 *
 * Displays sponsors grouped by sponsor level taxonomy.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$sponsor_levels = get_terms( array(
    'taxonomy'   => 'sponsor_level',
    'hide_empty' => true,
    'orderby'    => 'term_order',
    'order'      => 'ASC',
) );
?>

<main id="main-content" class="site-main" role="main">

    <!-- Page Header -->
    <section class="page-hero">
        <div class="page-hero__container">
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php if ( get_the_content() ) : ?>
                    <div class="page-hero__intro">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; endif; ?>
        </div>
    </section>

    <!-- Sponsors by Level -->
    <section class="page-sponsors">
        <div class="page-sponsors__container">

            <?php if ( ! empty( $sponsor_levels ) && ! is_wp_error( $sponsor_levels ) ) : ?>

                <?php foreach ( $sponsor_levels as $level ) : ?>
                    <?php
                    $level_sponsors = mmff_get_sponsors( $level->slug );
                    if ( ! $level_sponsors->have_posts() ) {
                        continue;
                    }
                    ?>
                    <div class="page-sponsors__level" id="level-<?php echo esc_attr( $level->slug ); ?>">
                        <h2 class="page-sponsors__level-title"><?php echo esc_html( $level->name ); ?></h2>

                        <?php if ( $level->description ) : ?>
                            <p class="page-sponsors__level-description"><?php echo esc_html( $level->description ); ?></p>
                        <?php endif; ?>

                        <div class="page-sponsors__grid page-sponsors__grid--<?php echo esc_attr( $level->slug ); ?>">
                            <?php while ( $level_sponsors->have_posts() ) : $level_sponsors->the_post(); ?>
                                <?php
                                $sponsor_url = get_post_meta( get_the_ID(), '_sponsor_url', true );
                                $has_link    = ! empty( $sponsor_url );
                                ?>
                                <div class="page-sponsors__item">
                                    <?php if ( $has_link ) : ?>
                                        <a href="<?php echo esc_url( $sponsor_url ); ?>" class="page-sponsors__link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( sprintf( __( 'Visit %s website', 'mmff-festival' ), get_the_title() ) ); ?>">
                                    <?php endif; ?>

                                    <div class="page-sponsors__logo-wrap">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'sponsor-logo', array(
                                                'class'   => 'page-sponsors__logo',
                                                'loading' => 'lazy',
                                                'alt'     => esc_attr( get_the_title() ),
                                            ) ); ?>
                                        <?php else : ?>
                                            <span class="page-sponsors__name"><?php the_title(); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ( $has_link ) : ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else : ?>
                <div class="page-sponsors__empty">
                    <p><?php esc_html_e( 'Collaboration partner information will be available soon.', 'mmff-festival' ); ?></p>
                </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
