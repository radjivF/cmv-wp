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
//define('DB_NAME', 'cmv');
//
///** MySQL database username */
//define('DB_USER', 'cmv');
//
///** MySQL database password */
//define('DB_PASSWORD', 'paeLei4e');
//
///** MySQL hostname */
//define('DB_HOST', 'localhost');
//
///** Database Charset to use in creating database tables. */
//define('DB_CHARSET', 'utf8mb4');
//
///** The Database Collate type. Don't change this if in doubt. */
//define('DB_COLLATE', '');
    
if(isset($_ENV['CLEARDB_DATABASE_URL'])) {
    $db = parse_url($_ENV['CLEARDB_DATABASE_URL']);
    define(‘DB_NAME’, trim($db['cmv'],'/'));
    define(‘DB_USER’, $db['cmv']);
    define(‘DB_PASSWORD’, $db['paeLei4e']);
    define(‘DB_HOST’, $db['localhost']);
    define(‘DB_CHARSET’, 'utf8mb4');
    define(‘DB_COLLATE’, '');
} else {
    die('No Database credentials!');
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Bwd_EMVVXqmQ-/Bv;E&)ZP`jC$MqWRwo{zmW l{({P^ex-aR84H#s=IFEzK*xQab');
define('SECURE_AUTH_KEY',  'kaN{`^7Xx]G<9EvQ=Lvt2^TXZod$Zra_=6=E7T-+)i@!ocR7ua6a|/SwJd$6-_GB');
define('LOGGED_IN_KEY',    'j=S3.D[O^+zEq+&R`GrA}^+0$pHe[zcy~tI<:V4`B@o9@NH)(09X|GR|Of6M:<7^');
define('NONCE_KEY',        'NSZV|&)q99KOI:-9!%h8]]: y)&/gOxn=_ FBxW~t@ct{.| eD0iY+,,C!RCaB8B');
define('AUTH_SALT',        ':(3J|Ny@dM1:md_=5#m;iNbvLB-GaJAp+f;J/srAvQ;!Y2R^,4>Q3.14dk3GQ sl');
define('SECURE_AUTH_SALT', 'BH0X^x;F3-^aC-<xelmFEod=$;xBq$+j;RA81Cx40kPVQ5fO1hJ|-y~{Dv}-}hvM');
define('LOGGED_IN_SALT',   '{k%sm?G*x&:nx^5FfW66+S[`}m~;=<kRVw*q~2j:/2_N6P;C9[&rQ@{J8.]:*0 4');
define('NONCE_SALT',       '>gGaXm<$S6^Pd`<x*s?[g#UTYK2m+;yx04:&DX.{|,@z~ZT}DK<>yOH,RaWki1`f');

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
$_SERVER['HTTPS']='on';

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
