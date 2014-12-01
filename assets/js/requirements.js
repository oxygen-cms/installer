var requirements = [
    'php', 'mcrypt', 'pdo', 'writable', 'http', 'packagist', 'github'
];

var classes = {
    list: "Requirement-list",
    passed: "Requirement--passed",
    failed: "Requirement--failed",
    testing: "Requirement--testing",
    messageSuccess: "RequirementsCheckMessage--success",
    messageError: "RequirementsCheckMessage--error",
    messageShow: "RequirementsCheckMessage--show"
};

var success = true;

function checkRequirements(i) {
    i = i ? i : 0;
    var requirement = requirements[i];
    if(!requirement) {
        checkRequirementsComplete();
        return;
    }

    $("." + classes.list).append('<li class="Requirement Requirement--testing" data-requirement="' + requirement + '"></li>');

    $.ajax({
        dataType: 'json',
        type: 'GET',
        url: 'doCheckRequirement.php',
        data: {
            name: requirement
        },
        success: function(data) {
            var element = $('[data-requirement="' + requirement + '"]');
            element.removeClass(classes.testing);
            element.addClass(data.result ? classes.passed : classes.failed);
            element.html(data.message);
            if(data.result === false) {
                success = false;
            }
            setTimeout(function() {
                checkRequirements(i + 1)
            }, 500);
        },
        error: function(data) {
            handleError(data.responseText);
        }
    });
}

function checkRequirementsComplete() {
    var message = $("." + (success ? classes.messageSuccess : classes.messageError));
    message.addClass(classes.messageShow);
}

function enableJS() {
    var enabledJS = $('[data-requirement="enabled-js"]');
    enabledJS.html('JavaScript is Enabled');
    enabledJS.removeClass(classes.failed);
    enabledJS.addClass(classes.passed);
    var errorMessage = $("." + classes.messageError);
    errorMessage.removeClass(classes.messageShow);
}

enableJS();
checkRequirements();