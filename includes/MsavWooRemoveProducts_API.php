<?php
if ( ! defined( 'ABSPATH' ) || ! is_admin() ) {
	return;
}

if ( !class_exists('MsavWooRemoveProducts_API') ) {

	/**
	 * Class MsavWooRemoveProducts_API API helper
	 */
	class MsavWooRemoveProducts_API extends MsavWooRemoveProducts_Base {

		/**
		 * Products Amount
		 *
		 * @var integer
		 */
		private $products_count;


		/**
		 * Products amount to remove per step.
		 *
		 * @var integer
		 */
		private $remove_per_step;


		/**
		 * Delete the media files.
		 *
		 * @var bool
		 */
		private $delete_media;


		/**
		 * Run the process
		 *
		 * @var bool
		 */
		private $run;


		/**
		 * In AJAX action
		 *
		 * @var bool
		 */
		private $in_action;


		/**
		 * In AJAX action
		 *
		 * @return bool
		 */
		public function isInAction(): bool {
			return $this->in_action;
		}


		/**
		 * Run the process
		 *
		 * @return bool
		 */
		public function isRun(): bool {
			return $this->run;
		}


		/**
		 * Products amount to remove per step.
		 *
		 * @return int
		 */
		public function getRemovePerStep(): int {
			return $this->remove_per_step;
		}


		/**
		 * Delete the media files.
		 *
		 * @return bool
		 */
		public function isDeleteMedia(): bool {
			return $this->delete_media;
		}


		/**
		 * Products Amount
		 *
		 * @return int
		 */
		public function getProductsCount(): int {
			return $this->products_count;
		}


		/**
		 * MsavWooRemoveProducts_API constructor.
		 */
		public function __construct() {

			// Init settings
			//
			$this->remove_per_step = $this->getVar('products_per_step', 20);
			$this->run = $this->getVar('delete_products') == 'delete';
			$this->delete_media = $this->getVar('delete_media', '0') == '1' || !$this->run;
			$this->in_action = $this->getVar('action_method') == 'step';


			// Get the products count
			//
			$this->products_count = 0; // Init value

			$sql = "SELECT COUNT(*) FROM `{$this->getWpdb()->prefix}posts` "
			       . "WHERE `post_type` = 'product' OR `post_type` = 'product_variation'";
			if ( ($res = $this->getWpdb()->get_var($sql)) != null ) {
				$this->products_count = $res;
			}

		}


		/**
		 * Returns the list of products to remove.
		 *
		 * @return array
		 */
		private function get_products_list() {
			$sql = "SELECT `ID` FROM {$this->getWpdb()->posts} "
				. "WHERE `post_type` = 'product' OR `post_type` = 'product_variation' ORDER BY `ID` "
				. "LIMIT {$this->getRemovePerStep()}";

			$res = $this->getWpdb()->get_col($sql);

			return $res;
		}


		/**
		 * Returns a list of product attachments.
		 *
		 * @param int $product_id
		 */
		private function get_attachments($product_id) {

			// Image gallery
			//
			$sql = "SELECT `meta_value` FROM {$this->getWpdb()->postmeta} "
				. "WHERE `meta_key` = '_product_image_gallery' AND `post_id` = '{$product_id}'";
			if ( ($res = $this->getWpdb()->get_var($sql)) != null && $res != '' ) {
				$attachments = explode(',', $res);
			} else {
				$attachments = array();
			}


			// Product thumbnail
			//
			if ( !is_array($attachments) ) {
				$attachments = array();
			}
			$sql = "SELECT `meta_value` FROM {$this->getWpdb()->postmeta} "
			       . "WHERE `meta_key` = '_thumbnail_id' AND `post_id` = '{$product_id}'";
			if ( ($res = $this->getWpdb()->get_var($sql)) != null && $res != '' ) {
				$attachments[] = $res;
			}


			return $attachments;
		}


		/**
		 * Remove the product attachments.
		 *
		 * @param int $product_id
		 */
		private function remove_attachments($product_id) {

			$attachments = $this->get_attachments($product_id);
			foreach ( $attachments as $attachment ) {
				wp_delete_attachment($attachment);
			}

		}


		/**
		 * Remove products on request.
		 *
		 * @return int
		 */
		public function do_remove(): int {
			$deleted = 0;

			$products = $this->get_products_list();
			if (count($products) > 0) {
				foreach ( $products as $product ) {
					// Remove the product attachments
					//
					if ( $this->isDeleteMedia() ) {
						$this->remove_attachments($product);
					}

					// Remove the product
					//
					wp_delete_post($product);
					$deleted++;
				}
			}

			return $deleted;
		}

	}
}