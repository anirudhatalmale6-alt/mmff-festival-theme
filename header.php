<?php
/**
 * Theme Header
 *
 * Displays the <head> section and site header with navigation.
 *
 * @package MMFF_Festival
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e( 'Skip to content', 'mmff-festival' ); ?>
</a>

<header class="site-header" role="banner">
    <div class="site-header__container">
        <div class="site-header__brand">
            <?php if ( has_custom_logo() ) : ?>
                <div class="site-header__logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__title-link" rel="home">
                <span class="site-header__title"><?php esc_html_e( 'Migration Matters', 'mmff-festival' ); ?></span>
                <span class="site-header__subtitle"><?php esc_html_e( 'Film Festival', 'mmff-festival' ); ?></span>
            </a>
        </div>

        <nav class="site-header__nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'mmff-festival' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'site-header__menu',
                'container'      => false,
                'depth'          => 2,
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
            ) );
            ?>
        </nav>

        <button class="site-header__menu-toggle" aria-controls="mobile-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'mmff-festival' ); ?>">
            <span class="site-header__menu-icon" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
    </div>

    <div class="site-header__mobile-menu" id="mobile-menu" role="navigation" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'mmff-festival' ); ?>" hidden>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => 'site-header__mobile-list',
            'container'      => false,
            'depth'          => 2,
            'fallback_cb'    => false,
            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ) );
        ?>
    </div>
</header>
