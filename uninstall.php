<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   cell_rest_api
 * @author    Dion <ifdion@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Dion 
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// TODO: Define uninstall functionality here