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
		}


		/**
		 * Initialize the plugin.
		 */
		public function init() {
			
		}

	}

endif;
