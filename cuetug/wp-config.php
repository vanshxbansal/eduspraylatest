<?php
define( 'WP_CACHE', true );

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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u755359476_hgbAR' );

/** Database username */
define( 'DB_USER', 'u755359476_6Uvhf' );

/** Database password */
define( 'DB_PASSWORD', 'QJsLdPq6iM' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'i=F7q-WNVUbsk/z5v#y)xWsQO~~E7m9V;yDhs}Z2kX$-!6$;0RVogC;Gh>%Yml-/' );
define( 'SECURE_AUTH_KEY',   'S~Vg!Hq)%NWfgJVN4DmP)Cx$JlvGtk<.7(RjJ*bCZ-{k@1M0(j4j5]jEy1wlekHh' );
define( 'LOGGED_IN_KEY',     'mO+I,v,$r[7&UzZ o;r#&*y0Q/|!IX/[@RO~ [$XY3<8:pl9o0rng?lwVEMvN@@k' );
define( 'NONCE_KEY',         'o+GPRCV-pd{V].&.GxK0kOfX]$GD2_!q$a?_UtTkIUU@<0F]loV_?:)8W9&myF,B' );
define( 'AUTH_SALT',         'aJ2n9~ ,j*dY.Uc^6L6U6[Nu8,%-mu< 92OBEd;SUxbG._x+OTaq`_8r pQOKs|P' );
define( 'SECURE_AUTH_SALT',  '`Xpml%mWTny2Z@27oVm} 4qFFeA4=Y]{/~|:^LxT8U]a5JY9(abAzuo+r#*Qvl]8' );
define( 'LOGGED_IN_SALT',    'o$@,[4v/K_d~#: 5VXWA]ZjUFhfaqTH6vP![R]Q8F.z)X!RpqYtBdyVt&YY@RfY$' );
define( 'NONCE_SALT',        '%j;F9Exu3FJ;k:7!,TQV>L`_RH8-]wlp_,=cA] <2(7^;+}gM$))$5;lN= ~o]>k' );
define( 'WP_CACHE_KEY_SALT', '&`}RP;~}XWT {bvpN4NY5PMXyDMCqKhGYJ9dNLXQ$$jr9CQ-SvMaD$ctKcWf1+&+' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'a7f2a10c0f7e5bff4b11ccf767b9d206' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
