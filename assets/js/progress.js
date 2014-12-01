var ProgressBar;

window.Oxygen || (window.Oxygen = {});

window.Oxygen.ProgressBar = ProgressBar = (function() {
    ProgressBar.classes = {
        container: "ProgressBar",
        fill: "ProgressBar-fill",
        noTransition: "ProgressBar-fill--jump",
        message: "ProgressBar-message",
        itemMessage: "ProgressBar-message-item",
        sectionCount: "ProgressBar-message-section-count",
        sectionMessage: "ProgressBar-message-section-message"
    };

    function ProgressBar(element) {
        this.container = element;
        this.fill = this.container.find("." + ProgressBar.classes.fill);
        this.message = this.container.parent().find("." + ProgressBar.classes.message);
        this.itemMessage = this.message.find("." + ProgressBar.classes.itemMessage);
        this.sectionCount = this.message.find("." + ProgressBar.classes.sectionCount);
        this.sectionMessage = this.message.find("." + ProgressBar.classes.sectionMessage);
        this.setup();
    }

    ProgressBar.prototype.setup = function() {
        return this.fill.css("opacity", "1");
    };

    ProgressBar.prototype.transitionTo = function(value, total) {
        var percentage;
        percentage = Math.round(value / total * 100);
        if (percentage > 100) {
            percentage = 100;
        }
        this.fill.css("width", percentage + "%");
    };

    ProgressBar.prototype.setMessage = function(message) {
        this.message.show();
        this.itemMessage.html(message);
    };

    ProgressBar.prototype.setSectionCount = function(count) {
        this.message.show();
        this.sectionCount.html(count);
    };

    ProgressBar.prototype.setSectionMessage = function(message) {
        this.message.show();
        this.sectionMessage.html(message);
    };

    ProgressBar.prototype.reset = function(callback) {
        var fill;
        if (callback == null) {
            callback = (function() {});
        }
        this.message.hide();
        fill = this.fill;
        fill.addClass(ProgressBar.classes.noTransition);
        return setTimeout(function() {
            fill.css("width", "0");
            return setTimeout(function() {
                fill.removeClass(ProgressBar.classes.noTransition);
                return callback();
            }, 5);
        }, 5);
    };

    ProgressBar.prototype.resetAfter = function(time) {
        return setTimeout(this.reset.bind(this), time);
    };

    return ProgressBar;

})();
