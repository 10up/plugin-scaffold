<?php
/**
 * Plugin Name: TenUpScaffold
 * Plugin URI:
 * Description:
 * Version:     0.1.0
 * Author:      10up
 * Author URI:  https://10up.com
 * Text Domain: tenup-scaffold
 * Domain Path: /languages
 *
 * @package PluginScaffold
 */

// Useful global constants.
define( 'TENUP_SCAFFOLD_VERSION', '0.1.0' );
define( 'TENUP_SCAFFOLD_URL', plugin_dir_url( __FILE__ ) );
define( 'TENUP_SCAFFOLD_PATH', dirname( __FILE__ ) . '/' );
define( 'TENUP_SCAFFOLD_INC', TENUP_SCAFFOLD_PATH . 'includes/' );

// Include files.
require_once TENUP_SCAFFOLD_INC . 'functions/core.php';

// Activation/Deactivation.
register_activation_hook( __FILE__, '\TenUpScaffold\Core\activate' );
register_deactivation_hook( __FILE__, '\TenUpScaffold\Core\deactivate' );

// Bootstrap.
TenUpScaffold\Core\setup();

// Require Composer autoloader if it exists.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once 'vendor/autoload.php';
}
