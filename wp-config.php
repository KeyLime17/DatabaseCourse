<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '@/=/8/#v@OxQ#]VlG}ka;,*i87iY:Aia^fQ(Gm^3?Er>SeD#~~YKG45Tn@(qim#}' );
define( 'SECURE_AUTH_KEY',  'Q] yu~7$txwJGX5Gp4qG ->1[}<aR11]@#hUGkKE^ uBo(^v?I^[NrO7`kK}>rM1' );
define( 'LOGGED_IN_KEY',    '<2tK|zu9x3zp?dba/ e]zq*Q1Eup8`(x )7i&}Y?V1GHW`hP|V)&S+z7YEN2wYf0' );
define( 'NONCE_KEY',        'V}|&jVwvT/@R+gFDW,@_/4X.o`j@WJKHBe:UP+cIhwK>A_%::(46)`Se0mv`nJZ:' );
define( 'AUTH_SALT',        'gOoS}vQHKiJ&?K`2Xs>CM38=8uk%nbn|z_r9Sw!ORJ-M-Awk`7$&dfBZbdB+f4f;' );
define( 'SECURE_AUTH_SALT', 'P!6?;)4TRKKCm[DU&JWQ[MxfYN6|2R2z;iQ}5CjR=PF_RE[V5ElL~Ax?q(XB:l(X' );
define( 'LOGGED_IN_SALT',   '(5=QIzB(=5mUj2.iDI1#1fq~u!2xrY!V}2!$C2{^uZsd{aN#GSAmD0}<sTWJ*N^@' );
define( 'NONCE_SALT',       '$i+VBA7Kz9TaY!(;vn eCF7OW #iu(e8N2 =6>JsqM;D^i*:AI^%A_V397Np#^x_' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
