var scrollPageTop = window.scrollPageTop || (function() {
    "use strict";

    var doc = document,
    backBtn, hz = 1.25,
    intervalId = 0,
    bindEvent, removeEvent, getScrollTop, setScrollTop, animation, clickHandler, init;

    getScrollTop = function() {
        var yScroll = 0;
        if (self.pageYOffset) {
            yScroll = self.pageYOffset;
        } else if (doc.documentElement && doc.documentElement.scrollTop) {
            yScroll = doc.documentElement.scrollTop;
        } else if (doc.body) {
            yScroll = doc.body.scrollTop;
        }
        return yScroll;
    };

    setScrollTop = function(yScroll) {
        doc.documentElement.scrollTop = yScroll;
        doc.body.scrollTop = yScroll;
    };

    animation = function() {
        intervalId = window.setInterval(function() {
            setScrollTop(getScrollTop() / hz);
            if (getScrollTop() < 1) {
                window.clearInterval(intervalId);
            }
        },
        17);
    };

    clickHandler = function() {
        animation();
    };

    init = function(btn) {
        backBtn = btn;
        if (doc.body.addEventListener) {
            bindEvent = function(elem, type, handler) {
                elem.addEventListener(type, handler, false);
            };
            removeEvent = function(elem, type, handler) {
                elem.removeEventListener(type, handler, false);
            };
        } else {
            bindEvent = function(elem, type, handler) {
                elem.attachEvent('on' + type, handler);
            };
            removeEvent = function(elem, type, handler) {
                elem.detachEvent('on' + type, handler);
            };
        }

        bindEvent(btn, 'click', clickHandler);
    };

    return {
        init: init,
        hz: hz
    };
} ());