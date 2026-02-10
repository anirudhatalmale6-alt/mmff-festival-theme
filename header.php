<?php
/**
 * Theme Header
 *
 * Displays the <head> section, logo banner, and site header with navigation.
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

<!-- Logo Banner -->
<?php
$logo_url = '';
$custom_logo_id = get_theme_mod( 'custom_logo' );
if ( ! $custom_logo_id ) {
    // Fallback: check site_logo option (block themes)
    $custom_logo_id = get_option( 'site_logo' );
}
if ( $custom_logo_id ) {
    $logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
}
?>
<?php if ( $logo_url ) : ?>
<div class="site-banner" role="banner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-banner__link" rel="home">
        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="site-banner__image">
    </a>
</div>
<?php endif; ?>

<!-- Navigation Header -->
<header class="site-header" role="navigation">
    <div class="site-header__container">
        <div class="site-header__brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__title-link" rel="home">
                <span class="site-header__title"><?php esc_html_e( 'MMFF', 'mmff-festival' ); ?></span>
            </a>
        </div>

        <nav class="site-header__nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'mmff-festival' ); ?>">
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

    <div class="site-header__mobile-menu" id="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'mmff-festival' ); ?>" hidden>
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
