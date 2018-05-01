<?php
if ( ! defined( 'ABSPATH' ) || ! is_admin() ) {
	return;
}

if ( !class_exists('MsavWooRemoveProducts') ) :

	/**
	 * Class MsavWooRemoveProducts - Main plugin class
	 *
	 * @author Andrey Mishchenko
	 * @since 1.0.0
	 */
	class MsavWooRemoveProducts extends MsavWooRemoveProducts_Base {


		/**
		 * Class instance
		 *
		 * @var MsavWooRemoveProducts
		 */
		private static $instance = null;


		/**
		 * Is plugin init
		 *
		 * @var bool
		 */
		private $is_init;


		/**
		 * Admin panel helper
		 *
		 * @var MsavWooRemoveProducts_Admin
		 */
		private $admin_panel;


		/**
		 * API helper
		 *
		 * @var MsavWooRemoveProducts_API
		 */
		private $api;


		/**
		 * Admin panel helper
		 *
		 * @return MsavWooRemoveProducts_Admin
		 */
		public function getAdminPanel(): MsavWooRemoveProducts_Admin {
			return $this->admin_panel;
		}


		/**
		 * API helper
		 *
		 * @return MsavWooRemoveProducts_API
		 */
		public function getApi(): MsavWooRemoveProducts_API {
			return $this->api;
		}


		/**
		 * Indicates the execution status.
		 *
		 * @return bool
		 */
		public function isRun(): bool {
			return $this->api->isRun();
		}


		/**
		 * Class instance
		 *
		 * @return MsavWooRemoveProducts
		 */
		public static function getInstance(): MsavWooRemoveProducts {

			if (self::$instance == null) {
				self::$instance = new MsavWooRemoveProducts();
			}

			return self::$instance;
		}


		/**
		 * MsavWooRemoveProducts constructor.
		 */
		private function __construct() {

			$this->is_init = false;

			// Helpers initialization.
			//
			$this->admin_panel = new MsavWooRemoveProducts_Admin();
			$this->api = new MsavWooRemoveProducts_API();
		}


		/**
		 * Initialize the plugin.
		 */
		public function init() {
			if ( !$this->is_init ) {
				// Initialize the plugin
				//
				$this->is_init = true;


				// Add actions
				//
				add_action(
					'admin_menu',
					array(
						$this->admin_panel,
						'admin_menu'
					)
				);

				if ( $this->isPluginPage() ) {
					add_action(
						'admin_enqueue_scripts',
						array(
							$this->admin_panel,
							'enqueue_scripts'
						)
					);
				}


				// Remove step
				//
				add_action( 'wp_ajax_msav_woo_remove_products', array($this, 'ajaxRemove') );
			}
		} // init


		/**
		 * Remove AJAX query
		 */
		public function ajaxRemove() {
			if ($this->api->isRun() && $this->api->isInAction()) {
				$res = array(
					'products_count' => $this->api->do_remove()
				);

				echo json_encode($res);
				wp_die();
			}
		}

	}

endif;
