<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   cell_rest_api
 * @author    Dion <ifdion@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Dion 
 *
 * @wordpress-plugin
 * Plugin Name:       Cell Rest API
 * Plugin URI:        http://wordpress.org
 * Description:       Rest API made to work with other Cell plugin
 * Version:           1.0.0
 * Author:            Dion
 * Author URI:        http://google.com
 * Text Domain:       cell-rest-api
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
 * TODO:
 *
 * - replace `class-rest-api.php` with the name of the plugin's class file
 * - replace `class-plugin-admin.php` with the name of the plugin's admin file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'class-rest-api.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-rest-api-admin.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * TODO:
 *
 * - replace cell_rest_api with the name of the class defined in
 *   `class-rest-api.php`
 */
register_activation_hook( __FILE__, array( 'cell_rest_api', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'cell_rest_api', 'deactivate' ) );

/*
 * TODO:
 *
 * - replace cell_rest_api with the name of the class defined in
 *   `class-rest-api.php`
 * - replace cell_rest_api_admin with the name of the class defined in
 *   `class-rest-api-admin.php`
 */
add_action( 'plugins_loaded', array( 'cell_rest_api', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'cell_rest_api_admin', 'get_instance' ) );