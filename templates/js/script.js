'use strict';

// msav-woo-remove-products script
//
(function ($) {

    /**
     * Display the summary panel.
     */
    var displaySummary = function displaySummary() {
        $('#msav_log').show();

        $('#msav_process_panel').fadeOut(600, function () {
            $('#msav_settings_panel').fadeIn(600);
        });
    };

    /**
     * Run the remove step.
     */
    var doRemove = function doRemove(productsCount) {
        // Form settings
        //
        var productsPerStep = $('#products_per_step').attr('value');
        var deleteMedia = $('#delete_media').prop('checked') ? '1' : '0';
        var deleteProducts = $('#delete_products').attr('value');
        var actionMethod = 'step';

        // Request data
        //
        var data = {
            action: 'msav_woo_remove_products',
            products_per_step: productsPerStep,
            delete_media: deleteMedia,
            delete_products: deleteProducts,
            action_method: actionMethod
        };

        // Step request
        //
        $.post(ajaxurl, data, function (response) {
            var res = JSON.parse(response);
            if (res.products_count > 0) {
                var productsAmount = $('#msav_amount').text();
                var newCount = productsCount + res.products_count;
                if (productsAmount < newCount) {
                    newCount = productsAmount;
                }
                var progress = Math.round(100 * newCount / productsAmount);

                // Change progress bar
                //
                var removeProgress = $('#remove_progress');
                $(removeProgress).attr('aria-valuenow', progress);
                $(removeProgress).css('width', progress + '%');

                // Change progress labels
                //
                $('#msav_progress').text(progress);
                $('#msav_count').text(newCount);

                doRemove(newCount);
            } else {
                displaySummary();
            }
        });
    };

    /**
     * On document ready.
     */
    $(document).ready(function () {

        var processPanel = $('#msav_process_panel');
        if (processPanel != null && $(processPanel).hasClass('active')) {
            doRemove(0);
        }
    });
})(jQuery);