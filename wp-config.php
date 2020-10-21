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
define( 'DB_NAME', 'kandkschooltransport' );

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
define( 'AUTH_KEY',         '5cRd>E@}=W(l^P;>K0/6UOPD7q:Sc}j07tC$Nxz0e1_zQyB$@rV2?Rb?nCx|P)G_' );
define( 'SECURE_AUTH_KEY',  '?s]J28M@x?UO^@mcymQr&7P8>Izz+oXElE*>iyI%|MzmpX00+F{MwDp=jcqC&Y2{' );
define( 'LOGGED_IN_KEY',    '&IZ$l5h-Dby`JVP_lo3pWlAD#=b^E@E>Dc02[/bz~Lq<rZoR-J[:T<W16Q>7W?|;' );
define( 'NONCE_KEY',        '|d.E[fIG~s~W0>:xV6<af5o-lL|m;3719=kDc5yW>D42cb iI$6aoSB(zcZLX?`v' );
define( 'AUTH_SALT',        '942&|?R-D)DxT[=l$]yk$sLgZ@*9Wj5A,|KR7wmP9&);Uveg+Ftz?}Ee42)Nl:sh' );
define( 'SECURE_AUTH_SALT', '7D#7lax}!b,gHi$#)2MW?{Us/yDs-8tQvOI!mbU(%:p`4Q.(m1Wl7J6Zh;NWK8 }' );
define( 'LOGGED_IN_SALT',   'e.`sPaKMP4SKGzj+4UC6LgXvJ{s|rx5&k/tXohlatb($zvu8rhIb,NH|H|(9;vJh' );
define( 'NONCE_SALT',       'O]{2BL!vJDX8$vugvdanO?2+/!%x7.Ug/4{A3$?s/Dj35H::nKvll|nq=J~ b?R+' );

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
