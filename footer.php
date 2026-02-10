<?php
/**
 * Theme Footer
 *
 * Displays the sponsor banner and site footer with navigation,
 * social links, contact info, and copyright.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$contact_email = get_theme_mod( 'mmff_contact_email', 'contact@mmff.se' );
$venue         = get_theme_mod( 'mmff_venue', 'Bredgränd 2, 111 30 Stockholm' );
$instagram_url = get_theme_mod( 'mmff_instagram_url', '' );
$facebook_url  = get_theme_mod( 'mmff_facebook_url', 'https://www.facebook.com/migrationmattersfilmfestival/' );
$twitter_url   = get_theme_mod( 'mmff_twitter_url', '' );
?>

<?php get_template_part( 'template-parts/sponsor-banner' ); ?>

<footer class="site-footer" role="contentinfo">
    <div class="site-footer__container">
        <div class="site-footer__grid">

            <!-- Brand / About Column -->
            <div class="site-footer__column site-footer__column--brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo-link" rel="home">
                    <span class="site-footer__brand-name"><?php esc_html_e( 'MMFF', 'mmff-festival' ); ?></span>
                </a>
                <p class="site-footer__about">
                    <?php esc_html_e( 'Migration Matters Film Festival celebrates stories of movement, belonging, and identity through the power of cinema. Join us in Stockholm for three days of film, dialogue, and community.', 'mmff-festival' ); ?>
                </p>
            </div>

            <!-- Navigation Column -->
            <div class="site-footer__column site-footer__column--nav">
                <h3 class="site-footer__heading"><?php esc_html_e( 'Navigate', 'mmff-festival' ); ?></h3>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'site-footer__menu',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => false,
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                ) );
                ?>
            </div>

            <!-- Social Links Column -->
            <div class="site-footer__column site-footer__column--social">
                <h3 class="site-footer__heading"><?php esc_html_e( 'Follow Us', 'mmff-festival' ); ?></h3>
                <ul class="site-footer__social-list">
                    <?php if ( $instagram_url ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $instagram_url ); ?>" class="site-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Follow us on Instagram', 'mmff-festival' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" aria-hidden="true">
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
                            <a href="<?php echo esc_url( $facebook_url ); ?>" class="site-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Follow us on Facebook', 'mmff-festival' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" aria-hidden="true">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                                <span><?php esc_html_e( 'Facebook', 'mmff-festival' ); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ( $twitter_url ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $twitter_url ); ?>" class="site-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Follow us on X (Twitter)', 'mmff-festival' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" aria-hidden="true">
                                    <path d="M4 4l11.733 16h4.267l-11.733 -16z"></path>
                                    <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path>
                                </svg>
                                <span><?php esc_html_e( 'X (Twitter)', 'mmff-festival' ); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="site-footer__column site-footer__column--contact">
                <h3 class="site-footer__heading"><?php esc_html_e( 'Contact', 'mmff-festival' ); ?></h3>
                <address class="site-footer__contact">
                    <?php if ( $contact_email ) : ?>
                        <p class="site-footer__contact-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16" aria-hidden="true">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a>
                        </p>
                    <?php endif; ?>

                    <?php if ( $venue ) : ?>
                        <p class="site-footer__contact-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16" aria-hidden="true">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span><?php echo esc_html( $venue ); ?></span>
                        </p>
                    <?php endif; ?>
                </address>
            </div>

        </div>

        <div class="site-footer__bottom">
            <p class="site-footer__copyright">
                &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php esc_html_e( 'Migration Matters Film Festival. All rights reserved.', 'mmff-festival' ); ?>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
