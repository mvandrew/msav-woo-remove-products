<?php
if ( ! defined( 'ABSPATH' ) || ! is_admin() ) {
	return;
}

if ( !class_exists('MsavWooRemoveProducts_Admin')) {

	/**
	 * Class MsavWooRemoveProducts_Admin Admin panel helper
	 *
	 * @author Andrey Mishchenko
	 * @since 1.0.0
	 */
	class MsavWooRemoveProducts_Admin {


		/**
		 * Create menu item
		 */
		public function admin_menu() {
			$page = add_submenu_page( 'woocommerce',
				__('Products Remover', 'msav-woo-remove-products'),
				__('Products Remover', 'msav-woo-remove-products'),
				apply_filters( 'woocommerce_csv_product_role', 'manage_woocommerce' ),
				'msav_woo_remove_products',
				array( $this, 'output' ) );
		}


		/**
		 * Display the admin form.
		 */
		public function output() {
			include ( dirname(__FILE__) . '/../templates/html_admin_form.php' );
		}


		/**
		 * Enqueue the script and style
		 */
		public function enqueue_scripts() {
			wp_enqueue_style(
				'msav_woo_remove_products_style',
				_MSAV_WOO_REMOVE_PRODUCTS_URL . '/templates/css/style.css'
			);

			wp_enqueue_script(
				'msav_woo_remove_products_script',
				_MSAV_WOO_REMOVE_PRODUCTS_URL . '/templates/js/script.js',
				array('jquery')
			);
		}

	}
}