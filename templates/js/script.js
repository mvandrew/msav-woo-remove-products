'use strict';

// msav-woo-remove-products script
//
(function ($) {

    var displaySummary = function displaySummary() {
        $('#msav_log').show();

        $('#msav_process_panel').fadeOut(600, function () {
            $('#msav_settings_panel').fadeIn(600);
        });
    };

    $(document).ready(function () {
        console.log('loaded');
    });
})(jQuery);