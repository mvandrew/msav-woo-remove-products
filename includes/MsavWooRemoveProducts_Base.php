<?php
if ( ! defined( 'ABSPATH' ) || ! is_admin() ) {
	return;
}


if ( !class_exists('MsavWooRemoveProducts_Base') ) {
	abstract class MsavWooRemoveProducts_Base {

		/**
		 * Return database instance
		 *
		 * @return wpdb
		 */
		public function getWpdb(): wpdb {
			global $wpdb;
			return $wpdb;
		}


		/**
		 * Return the query variable.
		 *
		 * @param string $name
		 * @param mixed $default
		 *
		 * @return mixed
		 */
		public function getVar($name, $default = "") {
			$res = $default;
			if (isset($_POST[$name])) {
				$res = $_POST[$name];
			} elseif (isset($_GET[$name])) {
				$res = $_GET[$name];
			}

			return $res;
		}


		/**
		 * Save the log message.
		 *
		 * @param $message
		 */
		public function log($message) {
			$file_name = dirname(__FILE__) . '/messages.log';
			$handler = @fopen($file_name, 'a');
			if ($handler !== false) {
				$date = new DateTime();
				fwrite($handler, sprintf("%s - %s\n", $date->format('d.m.Y H:i:s'), $message));
				fclose($handler);
			}
		}

	}
}