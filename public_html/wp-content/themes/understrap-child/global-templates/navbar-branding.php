<?php
/**
 * Navbar branding
 *
 * @package Understrap
 * @since 1.2.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<a class="navbar-brand d-flex align-items-center gap-2" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
    <img src="<?= understrap_logo_url(); ?>" alt="logo">
    <span><?= get_bloginfo( 'name' ); ?></span>
</a>