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
						<label for="products_per_step">
							<?php _e('Remove per step', 'msav-woo-remove-products'); ?>
						</label>
					</th>
					<td>
						<input type="text" name="products_per_step" id="products_per_step"
                               value="<?php echo MsavWooRemoveProducts::getInstance()->getApi()->getRemovePerStep(); ?>"
                               class="form-control">
						<span class="description">
							<?php _e('Products amount to remove per step.', 'msav-woo-remove-products') ?>
						</span>
						<small><?php _e('It is recommended to set the value depending on server timeout settings.', 'msav-woo-remove-products') ?></small>
					</td>
				</tr>

                <tr>
                    <th>
                        <label for="products_count">
							<?php _e('Products Count', 'msav-woo-remove-products'); ?>
                        </label>
                    </th>
                    <td>
                        <input type="text"
                               name="products_count"
                               id="products_count"
                               value="<?php echo MsavWooRemoveProducts::getInstance()->getApi()->getProductsCount(); ?>"
                               class="form-control" readonly>
                    </td>
                </tr>

				<tr>
					<th>
						<label for="delete_media">
							<?php _e('Delete the media files.', 'msav-woo-remove-products'); ?>
						</label>
					</th>
					<td>
						<input
                                type="checkbox"
                                name="delete_media"
                                id="delete_media"
                                <?php echo MsavWooRemoveProducts::getInstance()->getApi()->isDeleteMedia() ? ' checked' : ''; ?>
                                value="1"
                                class="form-control">
						<span class="description">
							<?php _e('If checked, the media files associated with the products will be deleted.', 'msav-woo-remove-products') ?>
						</span>
					</td>
				</tr>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" class="btn btn-primary" value="<?php _e('Remove Products', 'msav-woo-remove-products'); ?>">
                <input type="hidden" name="delete_products" id="delete_products" value="delete">
			</p>
			
		</form>

	</div> <!-- end of #msav_settings_panel -->


	<div
		id="msav_process_panel"
		class="msav_admin_panel <?php echo MsavWooRemoveProducts::getInstance()->isRun() ? 'active' : '' ?>">

        <table class="form-table">
			<tbody>
			<tr>
				<th><?php _e( 'Deletion progress:', 'msav-woo-remove-products' ); ?></th>
				<td>
                    <div class="progress">
                        <div id="remove_progress"
                             class="progress-bar progress-bar-striped active"
                             role="progressbar"
                             aria-valuenow="0"
                             aria-valuemin="0"
                             aria-valuemax="100"
                             style="width: 0">
                            <span id="msav_progress">0</span>% (<span id="msav_count">0</span> / <span id="msav_amount"><?php echo MsavWooRemoveProducts::getInstance()->getApi()->getProductsCount(); ?></span>)
                        </div>
                    </div>
                </td>
			</tr>
			</tbody>
		</table>

		<p>
			<a href="<?php echo admin_url('admin.php?page=msav_woo_remove_products'); ?>" class="btn btn-danger"><?php _e( 'Abort', 'msav-woo-remove-products' ); ?></a>
		</p>

	</div> <!-- end of #msav_settings_panel -->

</div>
