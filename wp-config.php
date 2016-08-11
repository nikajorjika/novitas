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
define('DB_NAME', 'novitas');

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
define('AUTH_KEY',         'dO1ECWs3.Tt|Nj<K%jk&0/6:;r&AAB5&52+mbs@iG`,7h10GlG8xGnhE_lqoNOt&');
define('SECURE_AUTH_KEY',  'V6q{rE rSn mOW>?U6eo^C@5hZ`OM,xm~KWc0[1iwL&w8a4Ym4rLZO,%0`OmW.BW');
define('LOGGED_IN_KEY',    'm-HD*(`24MJ?B@2(Nh_S9ow}F`R2E~M=(pyvU3yN)(0Ixb|3^;>Ujb@SFqIt+U8P');
define('NONCE_KEY',        '^FN3 ZfK<);w3Cg+})wXGnsmZsd,cfx%_1Y!M{<E5+:6;^o8AYifd#fy+h=+btA0');
define('AUTH_SALT',        'LAJFwizbu}U9e~dQG1E:&qtr;W.30IwcIl Yd$R0IvJs}!|<5dN#+,t{VyOC[S};');
define('SECURE_AUTH_SALT', 't*^d -VA1=nS^>d&$6-mo;zs#rEp.-!zD^$NNoRC$%KF3vBe!gMu2(ul6Ir1FE-Q');
define('LOGGED_IN_SALT',   'CxN1mv7Cs&JYa61+F71sqmR-YRm?0u`CFc?Z .Q>33a2@zFmrR7kP0@+EV9OquaN');
define('NONCE_SALT',       '# s]UBdy[Lad<EG}*etVS,a8_|/@[b35-=nk^UE-(jv68;Lsz/KnM$#OWSJFU_Q:');

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
//Disable File Edits
define('DISALLOW_FILE_EDIT', true);