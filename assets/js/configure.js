$('[name="database[driver]"]').on("change", function() {
    var type = $(this).val();

    $('[data-hide-if]').each(function(key, value) {
        var element = $(value);
        if(element.attr('data-hide-if') === type) {
            element.hide();
        } else {
            element.show();
        }
    });
});

Oxygen.Ajax.handleSuccessCallback = function(response) {
    if(response.switchToTab) {
        Oxygen.TabSwitcher.list[0].setTo(response.switchToTab);
    }
};