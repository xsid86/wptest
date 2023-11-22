<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
global $post;

$ads = get_posts( [
	'post_type'   => 'real_estate_object',
	'numberposts' => 10,
	'meta_query'  => [
		[
			'key'   => 'city',
			'value' => $post->ID,
		],
	],
] );

?>

<article <?php post_class( 'd-flex flex-column' ); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header mb-3">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header>

    <div class="d-flex gap-3 flex-column flex-lg-row">
        <div class="small-cover" style="background-image: url('<?= get_post_cover( $post->ID ) ?>');"></div>
        <table class="table table-sm table-borderless table-hover">
            <tr>
                <th>
					<?= sprintf( __( 'Last 10 ads in %s', THEME_DOMAIN ), $post->post_title ); ?>
                </th>
            </tr>
			<?php foreach ( $ads as $ad ) { ?>
                <tr>
                    <td>
                        <a href="<?= get_permalink( $ad->ID ); ?>"><?= $ad->post_title; ?></a>
                    </td>
                </tr>
			<?php } ?>
        </table>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
