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
define('DB_NAME', 'icnstaging2019');

/** MySQL database username */
define('DB_USER', 'icnstaging2019');

/** MySQL database password */
define('DB_PASSWORD', '55to0@zD');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '`9)HtsNq3!ck}jICNvu(K5XmGn0NCOU7Zp*#el)?bWC@hG-,BoP(~8{]5*>a-h>$');
define('SECURE_AUTH_KEY',  'S(/lnOMEd!9D}||f@.]BCw(+=lJ!Q6.Iu?-^U+e|=n]9pCDLZeO>ZC-B0$!JB8O|');
define('LOGGED_IN_KEY',    '7-sg&CSL]w|<TF!Z[6O-MT_U%mpT8)Pz7RZEdUn-/!4qhLP={KFz,F|RI;([M<]-');
define('NONCE_KEY',        'Z4Y(Q!=w.sj_C?+uDX@-fY[yOB%??d8?PZFAP{+Q#IE+pN-.[t[R_m#O.CovxCwQ');
define('AUTH_SALT',        '9tQWz^kwn[`]|CCva#;L:fT(Zv1z$&(C8nU~(poQeG]Hk#Z<6Fn20}Z%}rcqrxX0');
define('SECURE_AUTH_SALT', ';>UD<|u>H(>|2[7G,JP=o{y-cZG(l2Svw*% @lA?CUE]GN:Gd2S[x=84uUDxhT7$');
define('LOGGED_IN_SALT',   ':Q<]|OjQA]I8`4H?Blb#=]^]Iy|vO}ocY6[}ipnhsQ>MXK6V<O]YF7^Vthw-vHlI');
define('NONCE_SALT',       ' nsPB} cd}ft?h*+DLn/Gd|9|P~TDb{+Dwv]Bq,+EC)z?V5%46fqE_^ho1mTv4O5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'icn_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
