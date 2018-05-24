/**
 * @author    Yaroslav Velychko
 */
jQuery(function () {
    var activeLink = jQuery('a[href!="/"].active');
    var items = activeLink.parents('li');
    jQuery.each(items, function (index) {
        var item = jQuery(this);
        if (!item.hasClass('active')) {
            item.toggleClass('active');
        }
    });

    var expandMainMenu = tools.cookie.get('expandMainMenu');

    if (expandMainMenu === undefined) {
        expandMainMenu = 'true';
    }

    jQuery('.menu-button').on('click', function () {
        setTimeout(function () {
            tools.cookie.set('expandMainMenu', !jQuery('.sidebar').hasClass('closed'));
        });
    });

    if (expandMainMenu === 'true') {
        jQuery('.sidebar').addClass('none-transition').removeClass('closed');
        jQuery('#page-wrapper').removeClass('maximized').addClass('none-transition');
        setTimeout(function () {
            jQuery('.sidebar').removeClass('none-transition');
            jQuery('#page-wrapper').removeClass('none-transition');
        }, 500);
    }
});