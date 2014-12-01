$.ajax({
    dataType: 'json',
    type: 'POST',
    url: 'doInstall.php',
    success: function(data) {
        console.log(data);
    },
    error: function(response, textStatus, errorThrown) {
        console.log(response, textStatus, errorThrown);
        handleError(response.responseText);
    }
});

var progressBar = new Oxygen.ProgressBar($("#install-progress"));
progressBar.transitionTo(1, 1);
var times = 0;
var currentSection = null;
var currentNotification = null;
var pollInterval = 2000;
var poll = function() {
    times++;
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: 'doGetInstallProgress.php',
        success: function(response) {
            if(response.log) {
                $("#install-log").html(response.log);
            }

            if(response.progress === false) {
                progressBar.reset();
                $("#install-log").html("");
            } else {
                if(response.progress) {
                    if(response.progress.section.count !== currentSection) {
                        progressBar.setSectionCount(response.progress.section.count);
                        progressBar.setSectionMessage(response.progress.section.message);
                        progressBar.reset(function() {
                            progressBar.transitionTo(response.progress.item.count, response.progress.item.total);
                        });
                        currentSection = response.progress.section.count;
                    } else {
                        progressBar.transitionTo(response.progress.item.count, response.progress.item.total);
                    }

                    progressBar.setMessage(response.progress.item.message);

                }
            }

            if(response.notification) {
                if(!response.notification.unique || currentNotification !== response.notification.unique) {
                    addMessage(response.notification.message, response.notification.status);
                    currentNotification = response.notification.unique;
                }
            }

            if(response.stopPolling !== true) {
                setTimeout(poll, pollInterval);
            }
        },
        error: function(response, textStatus, errorThrown) {
            console.log(response, textStatus, errorThrown);
            handleError(response.responseText);
            setTimeout(poll, pollInterval);
        }
    });
};

poll();