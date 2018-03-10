<?php
/**
 * Credential-free wp-config.php (ideal for multitenancy setups).
 *
 * @package WordPress
 */

/**
 * Load .env file (see: https://github.com/vlucas/phpdotenv).
 */
require_once __DIR__ . '/vendor/autoload.php';

if ( file_exists( __DIR__ . '/conf/.env' ) ) {
	$dotenv = new Dotenv\Dotenv( __DIR__ . '/conf' );
	$dotenv->load();
	$dotenv->required( [ 'DB_NAME', 'DB_USER', 'DB_PASSWORD' ] );
}

/**
 * Database.
 */
define( 'DB_NAME', getenv( 'DB_NAME' ) );
define( 'DB_USER', getenv( 'DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'DB_HOST' ) ? getenv( 'DATABASE_SERVER' ) : 'localhost' );
define( 'DB_CHARSET', getenv( 'DB_CHARSET' ) );
define( 'DB_COLLATE', getenv( 'DB_COLLATE' ) );

$table_prefix = getenv( '$table_prefix' ) ?: 'wp_';

/**
 * Check for https.
 */
$is_ssl = (boolean) getenv( 'HTTPS' ) || 443 === getenv( 'SERVER_PORT' ) || 'https' === getenv( 'HTTP_X_FORWARDED_PROTO' );
$scheme = $is_ssl ? 'https' : 'http';

/**
 * Define domain.
 */
if ( ! defined( 'WP_DOMAIN' ) ) {
	define( 'WP_DOMAIN', getenv( 'SERVER_NAME' ) );
}

/**
 * URLs.
 */
define( 'WP_HOME', $scheme . '://' . WP_DOMAIN );
define( 'WP_SITEURL', WP_HOME . '/wp' );

/**
 * Custom content folder.
 */
define( 'WP_CONTENT_FOLDER', '/app' );
define( 'WP_CONTENT_URL', WP_HOME . WP_CONTENT_FOLDER );
define( 'WP_CONTENT_DIR', WP_ROOT . WP_CONTENT_FOLDER );

/**
 * Constants.
 */
if ( file_exists( __DIR__ . '/constants.php' ) ) {
	require_once __DIR__ . '/constants.php';
}

if ( 'https' === $scheme ) {
	define( 'FORCE_SSL_LOGIN', true );
	define( 'FORCE_SSL_ADMIN', true );
}

define( 'COOKIE_DOMAIN', WP_DOMAIN );
define( 'WP_CACHE_KEY_SALT', WP_DOMAIN . '_' );
define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

/**
 * Authentication unique keys and salts.
 */
if ( file_exists( __DIR__ . '/salts.php' ) ) {
	require_once __DIR__ . '/salts.php';
}

/**
 * Bootstrap WordPress.
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/wp' );
}

/**
 * Sets up vars and included files.
 */
require_once ABSPATH . 'wp-settings.php';