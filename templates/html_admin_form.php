<?php
if ( ! defined( 'ABSPATH' ) || ! is_admin() ) {
	return;
}
?>
<div class="wrap msav-woo-remove-products">
	<h1><?php _e('WooCommerce Products Remover', 'msav-woo-remove-products'); ?></h1>


	<div
		id="msav_settings_panel"
		class="msav_admin_panel <?php echo MsavWooRemoveProducts::getInstance()->isRun() ? '' : 'active' ?>">

        <div id="msav_log" class="alert alert-success">
	        <?php _e('Deleting products has been completed successfully.', 'msav-woo-remove-products'); ?>
        </div>

        <div class="alert alert-warning">
	        <?php _e('Removes all WooCommerce Products, including associated media files.', 'msav-woo-remove-products'); ?>
        </div>

		<form 
			action="<?php echo admin_url('admin.php?page=msav_woo_remove_products'); ?>" 
			method="post" 
			enctype="multipart/form-data">
			
			<table class="form-table">
				<tbody>
				<tr>
					<th>
						<label for="products_amount">
							<?php _e('Products amount', 'msav-woo-remove-products'); ?>
						</label>
					</th>
					<td>
						<input type="text" name="products_amount" id="products_amount" value="20" class="form-control">
						<span class="description">
							<?php _e('Products amount to remove per step.', 'msav-woo-remove-products') ?>
						</span>
						<small><?php _e('It is recommended to set the value depending on server timeout settings.', 'msav-woo-remove-products') ?></small>
					</td>
				</tr>

				<tr>
					<th>
						<label for="delete_media">
							<?php _e('Delete the media files.', 'msav-woo-remove-products'); ?>
						</label>
					</th>
					<td>
						<input type="checkbox" name="delete_media" id="delete_media" checked class="form-control">
						<span class="description">
							<?php _e('If checked, the media files associated with the products will be deleted.', 'msav-woo-remove-products') ?>
						</span>
					</td>
				</tr>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" class="btn btn-primary" value="<?php _e('Remove products', 'msav-woo-remove-products'); ?>">
			</p>
			
		</form>

	</div> <!-- end of #msav_settings_panel -->


	<div
		id="msav_process_panel"
		class="msav_admin_panel <?php echo MsavWooRemoveProducts::getInstance()->isRun() ? 'active' : '' ?>">

        <table class="form-table">
			<tbody>
			<tr>
				<th><?php _e( 'Products Remained:', 'msav-woo-remove-products' ); ?></th>
				<td><span id="msav_progress">0</span></td>
			</tr>
			</tbody>
		</table>

		<p>
			<a href="<?php echo admin_url('admin.php?page=msav_woo_remove_products'); ?>" class="btn btn-danger"><?php _e( 'Abort', 'msav-woo-remove-products' ); ?></a>
		</p>

	</div> <!-- end of #msav_settings_panel -->

</div>
