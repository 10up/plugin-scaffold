<?php
/**
 * Plugin Name: <%= projectTitle %>
 * Plugin URI:  <%= projectHome %>
 * Description: <%= description %>
 * Version:     0.1.0
 * Author:      <%= authorName %>
 * Author URI:  <%= authorUrl %>
 * Text Domain: <%= funcPrefix %>
 * Domain Path: /languages
 */

/**
 * Built using yo wp-make:plugin
 * Copyright (c) 2015 10up, LLC
 * https://github.com/10up/generator-wp-make
 */

// Useful global constants
define( '<%= funcPrefix.toUpperCase() %>_VERSION', '0.1.0' );
define( '<%= funcPrefix.toUpperCase() %>_URL',     plugin_dir_url( __FILE__ ) );
define( '<%= funcPrefix.toUpperCase() %>_PATH',    dirname( __FILE__ ) . '/' );
define( '<%= funcPrefix.toUpperCase() %>_INC',     <%= funcPrefix.toUpperCase() %>_PATH . 'includes/' );

// Include files
require_once <%= funcPrefix.toUpperCase() %>_INC . 'functions/core.php';


// Activation/Deactivation
register_activation_hook( __FILE__, '\TenUp\<%= namespace %>\Core\activate' );
register_deactivation_hook( __FILE__, '\TenUp\<%= namespace %>\Core\deactivate' );

// Bootstrap
TenUp\<%= namespace %>\Core\setup();
