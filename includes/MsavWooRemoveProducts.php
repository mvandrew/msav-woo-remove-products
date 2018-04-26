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
	class MsavWooRemoveProducts {


		/**
		 * Class instance
		 *
		 * @var MsavWooRemoveProducts
		 */
		private static $instance = null;


		/**
		 * Database connection class
		 *
		 * @var wpdb
		 */
		private $wpdb;


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
		 * Indicates the execution status.
		 *
		 * @var bool
		 */
		private $is_run;


		/**
		 * Indicates the execution status.
		 *
		 * @return bool
		 */
		public function isRun(): bool {
			return $this->is_run;
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
		 * Return database instance
		 *
		 * @return wpdb
		 */
		public function getWpdb(): wpdb {
			return $this->wpdb;
		}


		/**
		 * MsavWooRemoveProducts constructor.
		 */
		private function __construct() {
			global $wpdb;

			$this->wpdb = $wpdb;

			$this->is_init = false;
			$this->is_run = false;

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

				add_action(
					'admin_enqueue_scripts',
					array(
						$this->admin_panel,
						'enqueue_scripts'
					)
				);
			}
		}

	}

endif;
