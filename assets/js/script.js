// msav-woo-remove-products script
//
($ => {

    /**
     * Display the summary panel.
     */
    const displaySummary = () => {
        $('#msav_log').show();

        $('#msav_process_panel').fadeOut(600, () => {
            $('#msav_settings_panel').fadeIn(600);
        });
    };


    /**
     * Run the remove step.
     */
    const doRemove = productsCount => {
        // Form settings
        //
        const productsPerStep = $('#products_per_step').attr('value');
        const deleteMedia = $('#delete_media').prop('checked') ? '1' : '0';
        const deleteProducts = $('#delete_products').attr('value');
        const actionMethod = 'step';


        // Request data
        //
        const data = {
            action: 'msav_woo_remove_products',
            products_per_step: productsPerStep,
            delete_media: deleteMedia,
            delete_products: deleteProducts,
            action_method: actionMethod
        };


        // Step request
        //
        $.post(ajaxurl, data, (response) => {
            const res = JSON.parse(response);
            if (res.products_count > 0) {
                const productsAmount = $('#msav_amount').text();
                let newCount = productsCount + res.products_count;
                if (productsAmount < newCount) {
                    newCount = productsAmount;
                }
                const progress = Math.round(100 * newCount / productsAmount);

                // Change progress bar
                //
                const removeProgress = $('#remove_progress');
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
    $(document).ready( () => {

        const processPanel = $('#msav_process_panel');
        if ( processPanel != null && $(processPanel).hasClass('active') ) {
            doRemove(0);
        }

    });

}) (jQuery);
