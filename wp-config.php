<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dsswebdevelops-domain-hosting_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`.a@oL:6P&X8PH6T^C5/f#4ggjdY:)7w@k{a(j*QG=(0U.wl/JcBsf3?i?ox;Th{' );
define( 'SECURE_AUTH_KEY',  'nl=G3s42m7JSJ{;|u5@nTND2+_*Mq*G8[*`_p6,)O7jS7dyC;4&gX.OYJ5I0hOL>' );
define( 'LOGGED_IN_KEY',    'ZTQ}.k ]UI]._E#,%&o/Dyaf+B4+Nm#|[OdG5{vyx:6$^}Mu]onk6>g?[{7=4h{!' );
define( 'NONCE_KEY',        ';eO&IFM6 (4C9NI.D`KQhS[[q<T>{|K3.;AdBO-mp&]!_IVIJ{,>*S&]u2H-,DM}' );
define( 'AUTH_SALT',        'X7+_3A/Ti+Xa!bMKMwgk=JWp~c`oe-;MUFDhAS|?q{w(%dzCj)Y,8r$DjIScU+DW' );
define( 'SECURE_AUTH_SALT', 'pC9wc*Y}:;>#M4AYe@,k*bfS/0FFl/bni]Iu,BDL!nR%}QbID5ADnsNVsEF 1`k)' );
define( 'LOGGED_IN_SALT',   '&#y(QS^7UuZT&n[eB}r~;6wzH@S&~pj>hmb7[Nf$U eHURPs[bL)YQqhX:!)*e+b' );
define( 'NONCE_SALT',       ')%|g)7agq^!*ie4E@oxu(F@|;gziFO2NZhFl#pRvmks4 D[W:VuZA!2iR]1h1f;X' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
