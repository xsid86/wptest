<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wptest' );

/** Database username */
define( 'DB_USER', 'xsid' );

/** Database password */
define( 'DB_PASSWORD', '123asdcvb' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ' 6(=a+F4D7guP#I+ NJHA]eA,!$fN[&|-i2erW!#UZbp0^% ?M?ZsSd|6ut~%e[D' );
define( 'SECURE_AUTH_KEY',  '~h/>pX5w- fvc^TNq{3:X2[9q*Qn;mUY)7Y`tMIj)a=B?cA^TX$~:Xx{(`/3fq1L' );
define( 'LOGGED_IN_KEY',    '2]D6ocy5eHf{;?9dt+sO2i#4 IGs6lVbhn&lp!snin*}Z*BDBH]P^3Im1Ksf e !' );
define( 'NONCE_KEY',        '@K0:dd+sO73)AhN7#HNx(epm!qHG%<N4J6K|-WdGDb?,,FU%&<b#*LDt^Me0|&=3' );
define( 'AUTH_SALT',        'T+Qx`1=Jdc? s`{gU-?-Ib,`dlb#Y0GU!EL[HLfk5(og^R0E1^Xj[Zoa,1ZPgAfT' );
define( 'SECURE_AUTH_SALT', 'vX*6Y$!(hHY5>?|R}*`FD4.mPjSA*!$Xche^eo*}UTJ7FN6XLCKK u2u;8/k$Mry' );
define( 'LOGGED_IN_SALT',   '{o`BlvkWxhp&3Zz}Dne.82lce1@+tD*,]e*f9jz5h-2FGHP0RT)aiq,m)V*i]`!s' );
define( 'NONCE_SALT',       'cn91g2`wTqY?E{;(bSO ,@OQ-Y?]-YA)|Mnm/G2w3fqKf;oUu*gxv@{J;U)mxQ.u' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
