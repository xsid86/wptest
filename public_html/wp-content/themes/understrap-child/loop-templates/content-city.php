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

    <div class="row g-3">
        <div class="col-12">
            <div class="d-flex flex-column align-items-center gap-3">
                <div class="small-cover" style="background-image: url('<?=get_post_cover($post->ID)?>');"></div>
                <header class="entry-header mb-3">
					<?php the_title( '<h4 class="entry-title">', '</h1>' ); ?>
                </header>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center">
            <a class="btn btn-primary" href="<?= get_permalink( $post->ID ); ?>"><?= __( 'All ads', THEME_DOMAIN ); ?></a>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
<hr>
