<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'db_9b111e_w40_1');

/** MySQL database username */
define('DB_USER', '9b111e_w40_1');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', 'MYSQL5005.smarterasp.net');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '&w@Vtt[sp6)S<.Ov:0rH&Rf=G?.]?xIGTu{sD*e+]7`hn`F[@*Qkcl cv4=uO>?b');
define('SECURE_AUTH_KEY',  'Ep/.6p0A[XwM{>PB=%L.:-E7vAe+?bv[q,%bhu4F-z_.>WLyaZi%dnwS-,MSZ90L');
define('LOGGED_IN_KEY',    'k+le4MG~WR^+#Mzj9Ilh<;%%6vc8M}Zp!0p.>pAkYF5)Bu4O%?|_bmKD/~vI2S&c');
define('NONCE_KEY',        '9a?Ua-(jGl|tAa,.((N(62)uq*2<PFnO:|(Y}|S|TB-3psm.~gxB^~XdWL%U,OOx');
define('AUTH_SALT',        '?+_cq9[9gHK]N7KX(~/E+4A*W-1Qi*?KFCM_TGt^T=ANwUJGo-ty<7YkAAVSNtE_');
define('SECURE_AUTH_SALT', ',!;vCN^_SpD=3qPk]}rHFiCg5E[w4`@Go ddjfthJVZ(F#3b>{X_hn[1|Y<O|z O');
define('LOGGED_IN_SALT',   'OwZ_Z-m!+[K~> b+ u/i?inWgK&Ub/(OCS<)l=s&AJcEW`o d2%IARV=--O+zKHt');
define('NONCE_SALT',       '][>:{+%p1}TOZ,X!7zRrZ*NqCyn&PX4GwiL7^|-ckNr_;mX{>D@Tr?tXJ_@pjS!t');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
