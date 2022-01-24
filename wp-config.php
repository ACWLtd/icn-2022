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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'acw-db-icn2021' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'z#V.Tk0Hw!0Ga5.Wu)P:${2dH7=osacP}Ow{QW-vX?!mDTOZ.JBDDg1M5cGej6J<' );
define( 'SECURE_AUTH_KEY',  '0#Zrb~a=yn,E#[v;<lww6~$P9gD|*)#BqVqI,5)/5Ze$%&h<yXgSG{g]omRo_1~g' );
define( 'LOGGED_IN_KEY',    'Cf;y6C @y=CrDH-mr&S/:&7YK7~SQ[j^k}!irRWuF>~c~[1+X^9*`9;n,F{oo{mW' );
define( 'NONCE_KEY',        'Vt#)NSpw5<9qCw_mF#_% FDR08yo%wA2O6$; bf&EH=%ZQ5/&X<fg56SBl1I6M%3' );
define( 'AUTH_SALT',        'VZCj,ZygHb{tAO8%&X0<0u@WN2H}2ccR#LFW<ZReRM?k8vZg(a1C9hN{d29I60(C' );
define( 'SECURE_AUTH_SALT', 'z#abbJ1NyP48yI qmumB P%AT]xB<hJraj:WQ.1sxi]0BS=|~gL_Fj5[1bmFF%Yt' );
define( 'LOGGED_IN_SALT',   '}l))]y7^wGITX36H!M-/QwBIq<@%o&QP0z~$GhIx%-*A,YT2E-TCa i$G%fsxDQr' );
define( 'NONCE_SALT',       '2@kC*w9i%pJ$^X!@f!md]oZ9^RB#ywD0EE0~v-U`,#T`@r;o-#qkb~;zkuc(*`)>' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
