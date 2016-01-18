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
});