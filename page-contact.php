<?php
/**
 * Template Name: Contact
 *
 * Contact page with info sidebar (email, venue, social links)
 * and main content area for a contact form plugin.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$contact_email = get_theme_mod( 'mmff_contact_email', 'contact@mmff.se' );
$venue         = get_theme_mod( 'mmff_venue', 'Bredgränd 2, 111 30 Stockholm' );
$instagram_url = get_theme_mod( 'mmff_instagram_url', '' );
$facebook_url  = get_theme_mod( 'mmff_facebook_url', '' );
$twitter_url   = get_theme_mod( 'mmff_twitter_url', '' );
?>

<main id="main-content" class="site-main" role="main">

    <!-- Page Header -->
    <section class="page-hero">
        <div class="page-hero__container">
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>

    <!-- Contact Layout -->
    <section class="page-contact">
        <div class="page-contact__container">
            <div class="page-contact__grid">

                <!-- Sidebar: Contact Information -->
                <aside class="page-contact__sidebar" aria-label="<?php esc_attr_e( 'Contact information', 'mmff-festival' ); ?>">
                    <div class="page-contact__info-card">

                        <h2 class="page-contact__info-heading"><?php esc_html_e( 'Get in Touch', 'mmff-festival' ); ?></h2>

                        <?php if ( $contact_email ) : ?>
                            <div class="page-contact__info-item">
                                <h3 class="page-contact__info-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" aria-hidden="true">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                    <?php esc_html_e( 'Email', 'mmff-festival' ); ?>
                                </h3>
                                <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" class="page-contact__info-value">
                                    <?php echo esc_html( $contact_email ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ( $venue ) : ?>
                            <div class="page-contact__info-item">
                                <h3 class="page-contact__info-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" aria-hidden="true">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <?php esc_html_e( 'Venue', 'mmff-festival' ); ?>
                                </h3>
                                <address class="page-contact__info-value page-contact__address">
                                    <?php echo esc_html( $venue ); ?>
                                </address>
                            </div>
                        <?php endif; ?>

                        <?php if ( $instagram_url || $facebook_url || $twitter_url ) : ?>
                            <div class="page-contact__info-item">
                                <h3 class="page-contact__info-label">
                                    <?php esc_html_e( 'Social Media', 'mmff-festival' ); ?>
                                </h3>
                                <ul class="page-contact__social-list">
                                    <?php if ( $instagram_url ) : ?>
                                        <li>
                                            <a href="<?php echo esc_url( $instagram_url ); ?>" class="page-contact__social-link" target="_blank" rel="noopener noreferrer">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" aria-hidden="true">
                                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                                </svg>
                                                <span><?php esc_html_e( 'Instagram', 'mmff-festival' ); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ( $facebook_url ) : ?>
                                        <li>
                                            <a href="<?php echo esc_url( $facebook_url ); ?>" class="page-contact__social-link" target="_blank" rel="noopener noreferrer">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" aria-hidden="true">
                                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                                </svg>
                                                <span><?php esc_html_e( 'Facebook', 'mmff-festival' ); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ( $twitter_url ) : ?>
                                        <li>
                                            <a href="<?php echo esc_url( $twitter_url ); ?>" class="page-contact__social-link" target="_blank" rel="noopener noreferrer">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" aria-hidden="true">
                                                    <path d="M4 4l11.733 16h4.267l-11.733 -16z"></path>
                                                    <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path>
                                                </svg>
                                                <span><?php esc_html_e( 'X (Twitter)', 'mmff-festival' ); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                    </div>
                </aside>

                <!-- Main Content: Contact Form -->
                <div class="page-contact__content">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <div class="page-contact__body entry-content">
                            <?php the_content(); ?>
                        </div>
                    <?php endwhile; endif; ?>
                </div>

            </div>
        </div>
    </section>

</main>

<?php
get_footer();
