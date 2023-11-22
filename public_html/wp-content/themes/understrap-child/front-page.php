<?php

defined( 'ABSPATH' ) || exit;

get_header();
$container           = get_theme_mod( 'understrap_container_type' );
$real_estate_objects = get_posts( [
	'post_type'   => 'real_estate_object',
	'numberposts' => 12,
	'orderby'     => 'date',
	'order'       => 'DESC',
] );

$cities = get_posts( [
	'post_type'   => 'city',
	'numberposts' => 12,
	'orderby'     => 'post_title',
	'order'       => 'ASC',
] );

$all_cities = get_posts( [
	'post_type'   => 'city',
	'numberposts' => - 1,
	'orderby'     => 'post_title',
	'order'       => 'ASC',
] );

?>

    <div class="wrapper" id="single-wrapper">

        <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

            <div class="row">

				<?php
				// Do the left sidebar check and open div#primary.
				get_template_part( 'global-templates/left-sidebar-check' );
				?>

                <main class="site-main" id="main">
                    <h2><?= __( 'New ads', THEME_DOMAIN ); ?></h2>
                    <hr>

                    <div class="row g-3 mb-5">
						<?php foreach ( $real_estate_objects as $object ) { ?>
                            <div class="real-estate-object-wrapper">
                                <a href="<?= get_permalink( $object->ID ); ?>" target="_blank" class="real-estate-object">
                                    <div class="img-wrap">
                                        <img src="<?= get_post_cover( $object->ID ); ?>">
                                    </div>
                                    <div class="flex-fill"></div>
                                    <div class="properties">
                                        <h3><?= $object->post_title; ?></h3>
                                        <div class="property-items-wrap">
                                            <div class="property-item">
                                                <span><?= __( 'Area', THEME_DOMAIN ); ?>:</span>
                                                <span><?= get_field( 'area', $object->ID ); ?> м²</span>
                                            </div>
                                            <div class="property-item">
                                                <span><?= __( 'Price', THEME_DOMAIN ); ?>:</span>
                                                <span><?= get_field( 'price', $object->ID ); ?> ₽</span>
                                            </div>
                                            <div class="property-item">
                                                <span><?= __( 'Usable area', THEME_DOMAIN ); ?>:</span>
                                                <span><?= get_field( 'usable_area', $object->ID ); ?> м²</span>
                                            </div>
                                            <div class="property-item">
                                                <span><?= __( 'Floor', THEME_DOMAIN ); ?>:</span>
                                                <span><?= get_field( 'floor', $object->ID ); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
						<?php } ?>
                        <div class="col-12 d-flex justify-content-center">
                            <a href="/real_estate_object/" class="btn btn-primary"><?= __( 'All ads', THEME_DOMAIN ); ?></a>
                        </div>
                    </div>

                    <h2><?= __( 'Ads by city', THEME_DOMAIN ); ?></h2>
                    <hr>

                    <div class="row g-3 mb-5">
						<?php foreach ( $cities as $object ) { ?>
                            <div class="city-object-wrapper">
                                <a href="<?= get_permalink( $object->ID ); ?>" target="_blank" class="city-object">
                                    <img src="<?= get_post_cover( $object->ID ); ?>">
                                    <span><?= $object->post_title; ?></span>
                                </a>
                            </div>
						<?php } ?>
                        <div class="col-12 d-flex justify-content-center">
                            <a href="/city/" class="btn btn-primary"><?= __( 'All cities', THEME_DOMAIN ); ?></a>
                        </div>
                    </div>

					<?php if ( current_user_can( 'manage_options' ) ) { ?>
                        <h2><?= __( 'Add new real estate object', THEME_DOMAIN ); ?></h2>
                        <hr>

                        <form action="/wp-json/xpartners/add-reo" class="ajax" enctype="multipart/form-data" method="post">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <label for="title" class="form-label"><?= __( 'Object title', THEME_DOMAIN ); ?></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="title" class="form-label"><?= __( 'Category', THEME_DOMAIN ); ?></label>
                                    <select type="text" class="form-select" id="category" name="category" required>
                                        <option value=""></option>
										<?php foreach ( get_real_estate_object_taxonomies() as $category ) { ?>
                                            <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
										<?php } ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="address" class="form-label"><?= __( 'Address', THEME_DOMAIN ); ?></label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="area" class="form-label"><?= __( 'Area', THEME_DOMAIN ); ?></label>
                                    <input type="number" min="0" step="0.01" class="form-control" id="area" name="area" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="price" class="form-label"><?= __( 'Price', THEME_DOMAIN ); ?></label>
                                    <input type="number" min="0" step="1" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="usable_area" class="form-label"><?= __( 'Usable area', THEME_DOMAIN ); ?></label>
                                    <input type="number" min="0" step="0.01" class="form-control" id="usable_area" name="usable_area" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="floor" class="form-label"><?= __( 'Floor', THEME_DOMAIN ); ?></label>
                                    <input type="number" min="0" step="1" class="form-control" id="floor" name="floor" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="city" class="form-label"><?= __( 'City', THEME_DOMAIN ); ?></label>
                                    <select type="text" class="form-select" id="city" name="city" required>
                                        <option value=""></option>
										<?php foreach ( $all_cities as $city ) { ?>
                                            <option value="<?= $city->ID; ?>"><?= $city->post_title; ?></option>
										<?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="cover" class="form-label"><?= __( 'Cover', THEME_DOMAIN ); ?></label>
                                    <input type="file" class="form-control" id="cover" name="cover" required>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <button class="btn btn-primary" type="submit"><?= __( 'Add', THEME_DOMAIN ); ?></button>
                                </div>
                            </div>
                        </form>
					<?php } else { ?>
                        <div class="alert alert-warning"><?= sprintf( __( 'You need to <a href="%s">authorize</a> to add new real estate object.', THEME_DOMAIN ), wp_login_url() ); ?></div>
					<?php } ?>
                </main>

				<?php
				// Do the right sidebar check and close div#primary.
				get_template_part( 'global-templates/right-sidebar-check' );
				?>

            </div><!-- .row -->

        </div><!-- #content -->

    </div><!-- #single-wrapper -->

<?php
get_footer();
