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
define('DB_NAME', 'wordpress47');

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
define('AUTH_KEY',         'v{]37ayMgCF_4v#KwWFurJ2a4%[#,w*I+8nR-cXME)[h 3H9iDf{5kLm^D8c:];)');
define('SECURE_AUTH_KEY',  'tCfzutFPHOaF@1~[ sN[#Q)|^%u$8GD##RmE I1Wuj6`:T8+XL4|+fi=jwg[8&Y|');
define('LOGGED_IN_KEY',    'lw),(W&Q`Fz30w{R{K2<UZU$QdWZ+~0$BJBc/<{E*!2YG5)(cywx5x70eBBoHo+]');
define('NONCE_KEY',        '@{pql6v?FQ[o@/DhaVM<d?le)h.BIte<R5 giBm[uu_p K.e#+H|nK^U,CW0n1>;');
define('AUTH_SALT',        'xQcHwsEa3tK eWG9C>^A*<OJ-Qi:Bqf?s=*0E/SzY5=d4wR3jy98sHbvY}eMUx;K');
define('SECURE_AUTH_SALT', 'rKwmgaLJ^p:#+L<M];-fu!J0nv8<g]?B/.Scz?:5YOo f8qSs$(|Yc$Pm[.XsY13');
define('LOGGED_IN_SALT',   'vYI]6j#WS01zVkKgh=YF zmra.?L|k([]8qSohOzZ.SFyaP?rSI.S^uusH_Czzv ');
define('NONCE_SALT',       'thx [8(K&lthxAz3)>ua=sBFZp%zj J_]rWrQu3~=K&+Z.AxWn>%hhF*BR*!Qqo&');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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