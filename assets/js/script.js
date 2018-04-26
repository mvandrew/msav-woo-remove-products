// msav-woo-remove-products script
//
($ => {

    const displaySummary = () => {
        $('#msav_log').show();

        $('#msav_process_panel').fadeOut(600, () => {
            $('#msav_settings_panel').fadeIn(600);
        });
    };

    $(document).ready( () => {
        console.log('loaded');
    });

}) (jQuery);
