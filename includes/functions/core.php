<?php
namespace TenUp\TenUpScaffold\Core;

/**
 * Default setup routine
 *
 * @uses add_action()
 * @uses do_action()
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
	
	// Editor styles. add_editor_style() doesn't work outside of a theme.
	add_filter( 'mce_css', $n( 'mce_css' ) );

	do_action( 'tenup_scaffold_loaded' );
}

/**
 * Registers the default textdomain.
 *
 * @uses apply_filters()
 * @uses get_locale()
 * @uses load_textdomain()
 * @uses load_plugin_textdomain()
 * @uses plugin_basename()
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
 * @uses do_action()
 *
 * @return void
 */
function init() {
	do_action( 'tenup_scaffold_init' );
}

/**
 * Activate the plugin
 *
 * @uses init()
 * @uses flush_rewrite_rules()
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
 * Enqueue scripts for front-end.
 *
 * @uses wp_enqueue_script() to load front end scripts.
 *
 * @since 0.1.0
 *
 * @return void
 */
function scripts() {

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script(
		'tenup_scaffold_shared',
		TENUP_SCAFFOLD_URL . "assets/js/shared/shared${suffix}.js",
		[],
		TENUP_SCAFFOLD_VERSION,
		true
	);

	if( is_admin() ) {
		wp_enqueue_script(
			'tenup_scaffold_admin',
			TENUP_SCAFFOLD_URL . "assets/js/admin/admin${suffix}.js",
			[],
			TENUP_SCAFFOLD_VERSION,
			true
		);
	}
	else {
		wp_enqueue_script(
			'tenup_scaffold_frontend',
			TENUP_SCAFFOLD_URL . "assets/js/frontend/frontend${suffix}.js",
			[],
			TENUP_SCAFFOLD_VERSION,
			true
		);
	}

}

/**
 * Enqueue styles for front-end.
 *
 * @uses wp_enqueue_style() to load front end styles.
 *
 * @since 0.1.0
 *
 * @return void
 */
function styles() {

	wp_enqueue_style(
		'tenup_scaffold_shared',
		TENUP_SCAFFOLD_URL . "assets/css/shared/shared-style.css",
		[],
		TENUP_SCAFFOLD_VERSION
	);

	if( is_admin() ) {
		wp_enqueue_script(
			'tenup_scaffold_admin',
			TENUP_SCAFFOLD_URL . "assets/css/admin/admin-style.css",
			[],
			TENUP_SCAFFOLD_VERSION,
			true
		);
	}
	else {
		wp_enqueue_script(
			'tenup_scaffold_frontend',
			TENUP_SCAFFOLD_URL . "assets/js/frontend/style.css",
			[],
			TENUP_SCAFFOLD_VERSION,
			true
		);
	}
	
}

/**
 * Enqueue editor styles
 * 
 * @since 0.1.0
 *
 * @return string
 */
function mce_css( $stylesheets ) {
	return $stylesheets . ',' . TENUP_SCAFFOLD_URL . "assets/css/admin/editor-style.css";
}