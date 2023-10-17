jQuery(document).ready(function($) {

    var jQuerygrid = jQuery('.js-filter-wrapper').isotope({
        itemSelector: '.job-item',
        layoutMode: 'vertical',
        horizontalAlignment: 1,
    });

    jQuery('.filter-button-group').on('click', '.filter_buttons', function() {
        var filterValue = jQuery(this).attr('data-filter');
        jQuerygrid.isotope({ filter: filterValue });
    });

    jQuery('.button-group').each(function(i, buttonGroup) {
        var jQuerybuttonGroup = jQuery(buttonGroup);
        jQuerybuttonGroup.on('click', 'span', function() {
            jQuerybuttonGroup.find('.is-checked').removeClass('is-checked');
            jQuery(this).addClass('is-checked');
        });
    });
});

jQuery(window).load(function() {
    if (jQuery(".filter_buttons").length > 0) {
        jQuery(".filter_buttons:first-child").trigger('click');
    }
});