<?php
/**
 * Plugin Name: Query Test
 * Plugin URI:  http://wordpress.org/plugins
 * Description: Create and display SQL queries and performance from WP_Query objects
 * Version:     0.1.0
 * Author:      ryelle
 * Author URI:  http://redradar.net
 * License:     GPLv2+
 * Text Domain: query_test
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2014 ryelle (email : )
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using grunt-wp-plugin
 * Copyright (c) 2013 10up, LLC
 * https://github.com/10up/grunt-wp-plugin
 */

// Useful global constants
define( 'QUERY_TEST_VERSION', '0.1.0' );
define( 'QUERY_TEST_URL',     plugin_dir_url( __FILE__ ) );
define( 'QUERY_TEST_PATH',    dirname( __FILE__ ) . '/' );

require_once( QUERY_TEST_PATH . 'includes/class.query-test.php' );
require_once( QUERY_TEST_PATH . 'includes/admin-page.php' );

/**
 * Default initialization for the plugin:
 * - Registers the default textdomain.
 */
function query_test_init() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'query_test' );
	load_textdomain( 'query_test', WP_LANG_DIR . '/query_test/query_test-' . $locale . '.mo' );
	load_plugin_textdomain( 'query_test', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 * Activate the plugin
 */
function query_test_activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	query_test_init();
}
register_activation_hook( __FILE__, 'query_test_activate' );

// Wireup actions
add_action( 'init',                  'query_test_init' );
add_action( 'admin_menu',            'query_test_admin_menu' );
add_action( 'admin_enqueue_scripts', 'query_test_admin_enqueue' );
