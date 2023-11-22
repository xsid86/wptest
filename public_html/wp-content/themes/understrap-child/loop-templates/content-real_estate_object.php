<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
global $post;
?>

<article <?php post_class( 'd-flex flex-column' ); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header mb-3">
		<?php the_title( '<h4 class="entry-title">', '</h1>' ); ?>
    </header>

    <div class="row g-3 mb-3">
        <div class="col-lg-6">
            <div class="post-cover-wrap rounded">
				<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <table class="table table-sm table-borderless table-striped table-hover">
                <tr>
                    <th><?= __( 'Area', THEME_DOMAIN ); ?>:</th>
                    <td><?= get_field( 'area' ); ?> м²</td>
                </tr>
                <tr>
                    <th><?= __( 'Price', THEME_DOMAIN ); ?>:</th>
                    <td><?= get_field( 'price' ); ?> ₽</td>
                </tr>
                <tr>
                    <th><?= __( 'Address', THEME_DOMAIN ); ?>:</th>
                    <td><?= get_field( 'address' ); ?></td>
                </tr>
                <tr>
                    <th><?= __( 'Usable area', THEME_DOMAIN ); ?>:</th>
                    <td><?= get_field( 'usable_area' ); ?> м²</td>
                </tr>
                <tr>
                    <th><?= __( 'Floor', THEME_DOMAIN ); ?>:</th>
                    <td><?= get_field( 'floor' ); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <a class="btn btn-primary" href="<?= get_permalink( $post->ID ); ?>"><?= __( 'Read more', THEME_DOMAIN ); ?></a>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
