<?php

define( 'THEME_DIR', get_stylesheet_directory() );
define( 'THEME_URL', get_stylesheet_directory_uri() );
const THEME_ASSETS_DIR = THEME_DIR . '/assets';
const THEME_ASSETS_URL = THEME_URL . '/assets';
const THEME_DOMAIN     = 'understrap';

/**
 * Initialize all available shortcodes
 */
if ( file_exists( THEME_DIR . '/inc/shortcodes' ) ) {
	$shortcodes = array_diff( scandir( THEME_DIR . '/inc/shortcodes' ), [
		'..',
		'.',
	] );
	foreach ( $shortcodes as $shortcode ) {
		$file = THEME_DIR . '/inc/shortcodes/' . $shortcode;
		if ( file_exists( $file ) && is_file( $file ) ) {
			require_once $file;
		}
	}
}

/**
 * Enqueue all styles and scripts
 * @return void
 */
function understrap_child_styles_and_scripts(): void {
	wp_enqueue_style( 'ucs-styles', THEME_ASSETS_URL . '/scss/style.css', [ 'understrap-styles' ], filemtime( THEME_ASSETS_DIR . '/scss/style.css' ) );
	wp_enqueue_script( 'ucs-scripts', THEME_ASSETS_URL . '/js/main.js', [ 'jquery-core' ], filemtime( THEME_ASSETS_DIR . '/js/main.js' ) );
}

add_action( 'wp_enqueue_scripts', 'understrap_child_styles_and_scripts' );

// define post types and taxonomies
define( 'POST_TYPES', [
	'real_estate_object' => [
		'singular' => _x( 'Real Estate Object', 'post type singular', THEME_DOMAIN ),
		'plural'   => _x( 'Real Estate Objects', 'post type plural', THEME_DOMAIN ),
		'tax'      => [
			'name'     => 'real_estate_object_type',
			'singular' => _x( 'Real Estate Object Type', 'taxonomy name singular', THEME_DOMAIN ),
			'plural'   => _x( 'Real Estate Object Types', 'taxonomy name plural', THEME_DOMAIN ),
		],
	],
	'city'               => [
		'singular' => _x( 'City', 'post type singular', THEME_DOMAIN ),
		'plural'   => _x( 'Cities', 'post type plural', THEME_DOMAIN ),
	],
] );

/**
 * Register all necessary post types and taxonomies
 */
function create_post_types_and_taxonomies(): void {
	foreach ( POST_TYPES as $key => $value ) {
		if ( array_key_exists( 'tax', $value ) ) {
			$args = [
				'labels'            => [
					'name'          => $value['tax']['plural'],
					'singular_name' => $value['tax']['singular'],
				],
				'public'            => true,
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
			];
			register_taxonomy( $value['tax']['name'], $key, $args );
		}

		$args = [
			'labels'              => [
				'name'          => sprintf( '%s %s', _x( 'All', 'all post type objects', THEME_DOMAIN ), $value['plural'] ),
				'singular_name' => $value['singular'],
				'add_new'       => sprintf( '%s %s', _x( 'Add', 'add new post type', THEME_DOMAIN ), $value['singular'] ),
				'menu_name'     => $value['plural'],
			],
			'description'         => $value['singular'],
			'supports'            => [
				'title',
				'editor',
				'excerpt',
				'author',
				'thumbnail',
				'custom-fields',
			],
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'menu_icon'           => THEME_ASSETS_URL . '/img/post_types/' . $key . '.svg',
		];
		register_post_type( $key, $args );
	}
}

add_action( 'init', 'create_post_types_and_taxonomies', 0 );

function widget_posts_args_add_custom_type( $params ) {
	$params['post_type'] = [ 'post', 'real_estate_object' ];

	return $params;
}

add_filter( 'widget_posts_args', 'widget_posts_args_add_custom_type' );

function understrap_logo_url() {
	$logo  = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image_src( $logo, 'full' );
	if ( $image ) {
		return $image[0];
	}

	return false;
}

function get_post_cover( $post_id ) {
	if ( has_post_thumbnail( $post_id ) ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );

		return $image[0];
	} else {
		return THEME_ASSETS_URL . '/img/default.png';
	}
}

function get_real_estate_object_taxonomies(): array {
	$res   = [];
	$terms = get_terms( [
		'taxonomy'   => 'real_estate_object_type',
		'hide_empty' => false,
	] );
	foreach ( $terms as $term ) {
		$res[] = [
			'name' => $term->name,
			'id'   => $term->term_id,
		];
	}

	return $res;
}

/////////////////////// CITY METABOX START ///////////////////////
function city_metabox(): void {
	$screens = [ 'real_estate_object' ];
	add_meta_box( 'real_estate_object-box', __( 'City', THEME_DOMAIN ), 'real_estate_object_html', $screens, 'side' );
}

add_action( 'add_meta_boxes', 'city_metabox' );

function real_estate_object_html( $post, $meta ): void {
	$cities   = get_posts( [
		'post_type'   => 'city',
		'numberposts' => - 1,
		'orderby'     => 'post_title',
		'order'       => 'ASC',
	] );
	$selected = get_post_meta( $post->ID, 'city', true );
	ob_start(); ?>
    <select name="city" required>
        <option value=""><?= __( 'Select city', THEME_DOMAIN ); ?></option>
		<?php foreach ( $cities as $city ) { ?>
            <option value="<?= $city->ID; ?>" <?= $selected == $city->ID ? 'selected' : ''; ?>><?= $city->post_title; ?></option>
		<?php } ?>
    </select>
	<?php echo ob_get_clean();
}

function save_real_estate_object_meta( $post_id ): void {
	if ( get_post( $post_id )->post_type == 'real_estate_object' ) {
		if ( array_key_exists( 'city', $_POST ) ) {
			update_post_meta( $post_id, 'city', $_POST['city'] );
		}
	}
}

add_action( 'save_post', 'save_real_estate_object_meta' );

/////////////////////// CITY METABOX END ///////////////////////

function api_endpoints() {
	add_real_estate_object();
}

add_action( 'rest_api_init', 'api_endpoints' );

function add_real_estate_object(): void {
	register_rest_route( 'xpartners', 'add-reo', [
		'methods'             => WP_REST_Server::CREATABLE,
		'callback'            => function ( WP_REST_Request $request ) {
			$args = $request->get_params();

			$reo = wp_insert_post( [
				'post_type'    => 'real_estate_object',
				'post_title'   => $args['title'],
				'post_content' => '',
				'post_status'  => 'publish',
				'post_author'  => 1,
			] );

			update_field( 'area', $args['area'], $reo );
			update_field( 'price', $args['price'], $reo );
			update_field( 'address', $args['address'], $reo );
			update_field( 'usable_area', $args['usable_area'], $reo );
			update_field( 'floor', $args['floor'], $reo );
			update_field( 'city', $args['city'], $reo );

			wp_set_post_terms( $reo, $args['category'], 'real_estate_object_type' );

			$filename    = $_FILES['cover']['name'];
			$file        = $_FILES['cover']['tmp_name'];
			$post_id     = $reo;
			$upload_file = wp_upload_bits( $filename, null, @file_get_contents( $file ) );
			if ( ! $upload_file['error'] ) {
				$wp_filetype   = wp_check_filetype( $filename, null );
				$attachment    = [
					'post_mime_type' => $wp_filetype['type'],
					'post_parent'    => $post_id,
					'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				];
				$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $post_id );
				if ( ! is_wp_error( $attachment_id ) ) {
					require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
					$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
					wp_update_attachment_metadata( $attachment_id, $attachment_data );
					set_post_thumbnail( $post_id, $attachment_id );
				}
			}

			return $reo;
		},
		'permission_callback' => function ( WP_REST_Request $request ) {
			return '__return_true';
		},
	] );
}