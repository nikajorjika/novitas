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
define('DB_NAME', 'wp_redberry');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'LU%JIA H6,CW9NrC&2dG3I~>XF:%pn(4Vl|LEXr}3LT[+A:z1p<XnaA/dlI|25z~');
define('SECURE_AUTH_KEY',  '`bVHEN+TvnQG1fzKE^6FHk_F)aAqW&X8=xG#$02n&OfC=7GWzP=D*Q|$zf8 Zwh|');
define('LOGGED_IN_KEY',    'U=Pcd%,@@&r4}T.!)Kq-^]3wBf5_@/}K&sZax{_tI{OK4)R4~4te=+2eN=1R)4IG');
define('NONCE_KEY',        'T5useuHq0z>HKn9>z`pxi=t H=%phMF6K|>Wm(1fMO8VQ*YnO],<%7S&QaIAQXTC');
define('AUTH_SALT',        'BYzVfyc oQ<Eed,ttjWNDX4h-Sm]^87%9F&.g99B&9-W~?w2@q_kT03prO2h2s-=');
define('SECURE_AUTH_SALT', '((2R$JJWrF:1!r#|6 FEJ(;}j1]Tl6g<b45-(lF6U1L8B;y:1+dewpz4YtjmE|sQ');
define('LOGGED_IN_SALT',   'B.c=l$o IOyb<{hy-!r;Ci!mj$F5nZS{ZkoG_VI{G}Is7NCOr0`xk~G}uqE=dN6o');
define('NONCE_SALT',       '!e(k/uoE*c^w5a>aBu x$:ClriD#vAWy*77v:UIq|q@zV-e:-_JG|~={e|g[` Hz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'rb_';

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

/* In Production Server */
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );

@ini_set( 'display_errors', 'Off' );
@ini_set( 'log_errors', 'On' );
