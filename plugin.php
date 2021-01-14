<?php
/**
 * Plugin Name:       10up Plugin Scaffold
 * Plugin URI:        https://github.com/10up/plugin-scaffold
 * Description:       A brief description of the plugin.
 * Version:           0.1.0
 * Requires at least: 4.9
 * Requires PHP:      7.2
 * Author:            10up
 * Author URI:        https://10up.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tenup-scaffold
 * Domain Path:       /languages
 *
 * @package           TenUpScaffold
 */

// Useful global constants.
define( 'TENUP_SCAFFOLD_VERSION', '0.1.0' );
define( 'TENUP_SCAFFOLD_URL', plugin_dir_url( __FILE__ ) );
define( 'TENUP_SCAFFOLD_PATH', plugin_dir_path( __FILE__ ) );
define( 'TENUP_SCAFFOLD_INC', TENUP_SCAFFOLD_PATH . 'includes/' );

// Include files.
require_once TENUP_SCAFFOLD_INC . 'functions/core.php';

// Activation/Deactivation.
register_activation_hook( __FILE__, '\TenUpScaffold\Core\activate' );
register_deactivation_hook( __FILE__, '\TenUpScaffold\Core\deactivate' );

// Bootstrap.
TenUpScaffold\Core\setup();

// Require Composer autoloader if it exists.
if ( file_exists( TENUP_SCAFFOLD_PATH . 'vendor/autoload.php' ) ) {
	require_once TENUP_SCAFFOLD_PATH . 'vendor/autoload.php';
}
