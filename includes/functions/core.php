<?php
/**
 * Core plugin functionality.
 *
 * @package PluginScaffold
 */

namespace TenUpScaffold\Core;
use \WP_Error as WP_Error;

/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $n( 'i18n' ) );
	add_action( 'init', $n( 'init' ) );
	add_action( 'wp_enqueue_scripts', $n( 'scripts' ) );
	add_action( 'wp_enqueue_scripts', $n( 'styles' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_scripts' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_styles' ) );

	// Editor styles. add_editor_style() doesn't work outside of a theme.
	add_filter( 'mce_css', $n( 'mce_css' ) );

	do_action( 'tenup_scaffold_loaded' );
}

/**
 * Registers the default textdomain.
 *
 * @return void
 */
function i18n() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'tenup-scaffold' );
	load_textdomain( 'tenup-scaffold', WP_LANG_DIR . '/tenup-scaffold/tenup-scaffold-' . $locale . '.mo' );
	load_plugin_textdomain( 'tenup-scaffold', false, plugin_basename( TENUP_SCAFFOLD_PATH ) . '/languages/' );
}

/**
 * Initializes the plugin and fires an action other plugins can hook into.
 *
 * @return void
 */
function init() {
	do_action( 'tenup_scaffold_init' );
}

/**
 * Activate the plugin
 *
 * @return void
 */
function activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	init();
	flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {

}


/**
 * The list of knows contexts for enqueuing scripts/styles.
 *
 * @return array
 */
function get_enqueue_contexts() {
	return [ 'admin', 'frontend', 'shared' ];
}

/**
 * Generate an URL to a script, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $script Script file name (no .js extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string|WP_Error URL
 */
function script_url( $script, $context ) {

	if ( ! in_array( $context, get_enqueue_contexts(), true ) ) {
		return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in TenUpScaffold script loader.' );
	}

	return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
		TENUP_SCAFFOLD_URL . "assets/js/${context}/{$script}.js" :
		TENUP_SCAFFOLD_URL . "dist/js/${script}.min.js";

}

/**
 * Generate an URL to a stylesheet, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $stylesheet Stylesheet file name (no .css extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string URL
 */
function style_url( $stylesheet, $context ) {

	if ( ! in_array( $context, get_enqueue_contexts(), true ) ) {
		return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in TenUpScaffold stylesheet loader.' );
	}

	return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
		TENUP_SCAFFOLD_URL . "assets/css/${context}/{$stylesheet}.css" :
		TENUP_SCAFFOLD_URL . "dist/css/${stylesheet}.min.css";

}

/**
 * Enqueue scripts for front-end.
 *
 * @return void
 */
function scripts() {

	wp_enqueue_script(
		'tenup_scaffold_shared',
		script_url( 'shared', 'shared' ),
		[],
		TENUP_SCAFFOLD_VERSION,
		true
	);

	wp_enqueue_script(
		'tenup_scaffold_frontend',
		script_url( 'frontend', 'frontend' ),
		[],
		TENUP_SCAFFOLD_VERSION,
		true
	);

}

/**
 * Enqueue scripts for admin.
 *
 * @return void
 */
function admin_scripts() {

	wp_enqueue_script(
		'tenup_scaffold_shared',
		script_url( 'shared', 'shared' ),
		[],
		TENUP_SCAFFOLD_VERSION,
		true
	);

	wp_enqueue_script(
		'tenup_scaffold_admin',
		script_url( 'admin', 'admin' ),
		[],
		TENUP_SCAFFOLD_VERSION,
		true
	);

}

/**
 * Enqueue styles for front-end.
 *
 * @return void
 */
function styles() {

	wp_enqueue_style(
		'tenup_scaffold_shared',
		style_url( 'shared-style', 'shared' ),
		[],
		TENUP_SCAFFOLD_VERSION
	);

	if ( is_admin() ) {
		wp_enqueue_style(
			'tenup_scaffold_admin',
			style_url( 'admin-style', 'admin' ),
			[],
			TENUP_SCAFFOLD_VERSION
		);
	} else {
		wp_enqueue_style(
			'tenup_scaffold_frontend',
			style_url( 'style', 'frontend' ),
			[],
			TENUP_SCAFFOLD_VERSION
		);
	}

}

/**
 * Enqueue styles for admin.
 *
 * @return void
 */
function admin_styles() {

	wp_enqueue_style(
		'tenup_scaffold_shared',
		style_url( 'shared-style', 'shared' ),
		[],
		TENUP_SCAFFOLD_VERSION
	);

	wp_enqueue_style(
		'tenup_scaffold_admin',
		style_url( 'admin-style', 'admin' ),
		[],
		TENUP_SCAFFOLD_VERSION
	);

}

/**
 * Enqueue editor styles. Filters the comma-delimited list of stylesheets to load in TinyMCE.
 *
 * @param string $stylesheets Comma-delimited list of stylesheets.
 * @return string
 */
function mce_css( $stylesheets ) {
	if ( ! empty( $stylesheets ) ) {
		$stylesheets .= ',';
	}

	return $stylesheets . TENUP_SCAFFOLD_URL . ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
			'assets/css/frontend/editor-style.css' :
			'dist/css/editor-style.min.css' );
}
