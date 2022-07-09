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
 
define('WP_HOME','https://realrussia.co.uk');
define('WP_SITEURL','https://realrussia.co.uk');
 
define('JWT_AUTH_CORS_ENABLE', true);
define('JWT_AUTH_SECRET_KEY', 'RPF{O|P88e{] Zl_UF)yo?qvym43)<Z%]C]Y7.d^`V(n}ch~Gg_rgxW!//M/{%IY');

define( 'ALLOW_UNFILTERED_UPLOADS', true );
 
// define('COOKIE_DOMAIN', strtolower( stripslashes( $_SERVER['HTTP_HOST'] ) ) );
 
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rr_wp' );
/** MySQL database username */
define( 'DB_USER', 'rr_wp_user' );
/** MySQL database password */
define( 'DB_PASSWORD', 'm%dA3sEj?:D=' );
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
define( 'AUTH_KEY',         'W|ij?+[d);bnuAE;Qo }if!=?e8j[Gycn}Hx=[}C-z1XtlA,T(rZ%Gfl}6,eobKA' );
define( 'SECURE_AUTH_KEY',  'C:RgTcGJ{Kan6,.N1*uQ3avvc`ilE1&R9+5}_x{)lcy)$e:cuUPo zyWufSY6#(Q' );
define( 'LOGGED_IN_KEY',    'f#A!0E6Pc@9Gg+iHl&#d}PZJ$q~s7.y..%3&N(A5&B%1XS2sBRc/GQHX`@ D7FO,' );
define( 'NONCE_KEY',        'N6<{+ZGoBvm+!AvIbU9#hI-BUt28@%W-PV4Z:U<x9f=${N1G^KOSqHyv4l&0Xtw}' );
define( 'AUTH_SALT',        '4S`_/OQ[d;s&-~-Z&wh{Vw{p>gKiG~?uZFB1J(+@vOqT-:0RgIehy5;yyUd.d-NB' );
define( 'SECURE_AUTH_SALT', '#~?vZG/*e(g!Tecg|b_8(ZK;uupj#hT#xO_POQ,{g<EaMq2K.~thxW]x;cC5s-JE' );
define( 'LOGGED_IN_SALT',   '!5@{scr!/8#8sA)WqC*,l,Zy p@A.lP)}fTv<;Q.L3Kw~mt&/Z~CWk3PD uAl=pD' );
define( 'NONCE_SALT',       't)?C5~k#IqdT3>D81UT&Q!2@nMv GIkvnhBsmBsEq_b:{d=<2$k=}[.UmT*2hyg*' );
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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';