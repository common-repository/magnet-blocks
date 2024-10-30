<?php
/**
 * Plugin Name: Magnet Blocks
 * Plugin URI: https://pluginmagnet.com/wp-plugins/magnet-blocks/
 * Description: Wordpress extension add your custom text.
 * Version: 1.0.0
 * Author:      Plugin Magnet
 * Author URI:  https://pluginmagnet.com
 * License:     GPLv2+
 * Text Domain: magnet-blocks
 * Domain Path: /languages
 * Requires PHP: 5.6
 * Requires at least: 4.4
 * Tested up to: 6.5
 * WC requires at least: 5.0
 * WC tested up to: 8.8
 *
 * @package     WPMagnetBlocks
 * @author      pluginmagnet
 * @link        https://pluginmagnet.com/wp-plugins/magnet-blocks/
 */

/**
 * Copyright (c) 2017 PluginMagnet (email : support@pluginmagnet.com)
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
 * Foundation, Sharifpur Bazar, Sharifpur, Jamalpur Sadar, Jamalpur-2000, Mymensingh, Bangladesh
 */


use WPMagnetBlocks\Plugin;

// don't call the file directly.
defined( 'ABSPATH' ) || exit();

// Autoload function.
spl_autoload_register(
	function ( $class_name ) {
		$prefix = 'WPMagnetBlocks\\';
		$len    = strlen( $prefix );

		// Bail out if the class name doesn't start with our prefix.
		if ( strncmp( $prefix, $class_name, $len ) !== 0 ) {
			return;
		}

		// Remove the prefix from the class name.
		$relative_class = substr( $class_name, $len );
		// Replace the namespace separator with the directory separator.
		$file = str_replace( '\\', DIRECTORY_SEPARATOR, $relative_class ) . '.php';

		// Look for the file in the src and lib directories.
		$file_paths = array(
			__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $file,
			__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . $file,
		);

		foreach ( $file_paths as $file_path ) {
			if ( file_exists( $file_path ) ) {
				require_once $file_path;
				break;
			}
		}
	}
);

/**
 * Plugin compatibility with WooCommerce HPOS
 *
 * @since 1.0.0
 * @return void
 */
add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);


/**
 * Get the plugin instance.
 *
 * @since 1.0.0
 * @return Plugin
 */
function wp_magnet_blocks() { // phpcs:ignore
	return Plugin::create( __FILE__ );
}

// Initialize the plugin.
wp_magnet_blocks();
