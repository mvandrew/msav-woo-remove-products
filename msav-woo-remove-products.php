<?php
/*
Plugin Name: WooCommerce Products Remover
Plugin URI: https://github.com/mvandrew/msav-woo-remove-products
Description: Removes all WooCommerce Products, including associated media files
Author: Andrey Mishchenko
Author URI: http://www.msav.ru/
Version: 1.0.0
WC tested up to: 3.3.5
Text Domain: msav-woo-remove-products
*/

if ( ! defined( 'ABSPATH' ) || ! is_admin() ) {
	return;
}

/**
 * Define the plugin settings
 */
define(
	'_MSAV_WOO_REMOVE_PRODUCTS_URL',
	plugins_url( basename(plugin_dir_path(__FILE__)) )
);


/**
 * Include libraries
 */
include_once (dirname(__FILE__) . '/includes/MsavWooRemoveProducts_Admin.php');
include_once (dirname(__FILE__) . '/includes/MsavWooRemoveProducts_API.php');
include_once (dirname(__FILE__) . '/includes/MsavWooRemoveProducts.php');


// Initialize the plugin
//
MsavWooRemoveProducts::getInstance()->init();
