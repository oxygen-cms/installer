$('[name="database[driver]"],[name="queue[driver]"]').on("change", function() {
    var type = $(this).val();

    $('[data-hide-if]').each(function(key, value) {
        var element = $(value);
        types = element.attr('data-hide-if').split(',');
        if(types.indexOf(type) !== -1) {
            element.hide();
        } else {
            element.show();
        }
    });
});

$('[name="queue[driver]"]').on("change", function() {
    var type = $(this).val();

    if(type === 'sql') {
        $('[name="queue[queue]"]').val('');
    }
    if(type === 'beanstalkd') {
        $('[name="queue[host]"]').val('localhost');
        $('[name="queue[queue]"]').val('default');
    }
    if(type === 'iron') {
        $('[name="queue[host]"]').val('mq-aws-us-east-1.iron.io');
    }
});

Oxygen.Ajax.handleSuccessCallback = function(response) {
    if(response.switchToTab) {
        Oxygen.TabSwitcher.list[0].setTo(response.switchToTab);
    }
};