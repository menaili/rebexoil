<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rebexoil' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



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
define( 'AUTH_KEY',         'bLxLlPDHNxP1Q1Ou5ahC8r4pQzJqoHWbj02lSIPI86UWmT082B3hlWzS2VX4Stlp' );
define( 'SECURE_AUTH_KEY',  '8G7f9PXSeXNAvcZvyMDCRnfRgyj3ccClSeZZ6QIchaQRIXdakUJplxlxQKQcCBgt' );
define( 'LOGGED_IN_KEY',    '06HW9KNGOlVYt3RopCEJ2WdScXeoljjHGLzbuMa3sjlujjUzrMnX6ebfoRBHqUmp' );
define( 'NONCE_KEY',        'aUZWBrK53O9IOhAPsxGI9bunKAswhAry8sR6sYe63cisHUEDOlCIgGBZzJlYxsRn' );
define( 'AUTH_SALT',        'FlXjamfCYMVOx2CltTr7xxFoWhflWEapvkRIN1QspuzIKki7bXYsv9Un71x4Kar4' );
define( 'SECURE_AUTH_SALT', 'deJ9AsuIgFCZqn97cj9sNUpFUkz5nXYaMLMd9d6HW65BmO0Lj91qx3U8Znvlpzbt' );
define( 'LOGGED_IN_SALT',   '1cjgq3wMgOUQOt3R9XwWyk1pR8aUVoLx0yNlZSI3p85NYWZxXVtZGfnmZnBFzCDP' );
define( 'NONCE_SALT',       'F83yMMhfqGlSFvJrDBzeWilDFWPUeNVGSZPUaYIu2dOGacvoUPczCPtutTfCfkTe' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'rebexwoilp_';

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

/* Add any custom values between this line and the "stop editing" line. */
define('WP_HTTP_TIMEOUT', 60);
define('WP_MEMORY_LIMIT', '256M');
set_time_limit(300);



/* That's all, stop editing! Happy publishing. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
    define( 'ABSPATH', dirname( __FILE__ ) . '/' );
//define( 'DISALLOW_FILE_EDIT', true );
define('UPLOADS', '/medias');
define('WP_CONTENT_FOLDERNAME', '/deploy');
define('WP_CONTENT_DIR', ABSPATH . WP_CONTENT_FOLDERNAME);
//define('WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] . '/');
define('WP_CONTENT_URL', WP_SITEURL . WP_CONTENT_FOLDERNAME);



define('WP_PLUGIN_FOLDERNAME', 'assets');
define('WP_PLUGIN_DIR', ABSPATH . WP_CONTENT_FOLDERNAME.'/'. WP_PLUGIN_FOLDERNAME);
define('WP_PLUGIN_URL', WP_CONTENT_URL .'/' . WP_PLUGIN_FOLDERNAME);

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
