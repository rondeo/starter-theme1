var SlideOut = function (selector, duration, property) {


    if (typeof selector === "string") {
        selector = document.querySelector(selector);
    }

    if (typeof selector !== "object") {
        throw "Selector is invalid";
        return;
    }

    if (typeof duration !== "number" || isNaN(duration)) {
        duration = 300;
    }

    if (property !== "width") {
        property = "height";
    }

    selector.classList.remove('hidden');    
    selector.classList.remove('__hidden');    

    var finalSize = property === "height" ? selector.offsetHeight : selector.offsetWidth;

    selector.setAttribute("style", "overflow:hidden; max-" + property + ": 0; transition: max-" + property + " " + (duration/1000) + "s");

    selector.classList.add('transitioning');

    window.setTimeout(function (domObject, duration, property, size) {

        domObject.setAttribute("style", "overflow:hidden; max-" + property + ": " + size + "px; transition: max-" + property + " " + (duration/1000) + "s");

    }, 10, selector, duration, property, finalSize);    

    window.setTimeout(function (domObject) {

        domObject.classList.remove("transitioning");
        domObject.setAttribute("style", "");
        domObject.classList.add("opened");

    }, duration + 10, selector);

};

var SlideIn = function (selector, duration, property) {


    if (typeof selector === "string") {
        selector = document.querySelector(selector);
    }

    if (typeof selector !== "object") {
        throw "Selector is invalid";
        return;
    }

    if (typeof duration !== "number" || isNaN(duration)) {
        duration = 300;
    }

    if (property !== "width") {
        property = "height";
    }

    selector.classList.remove('opened');    

    var finalSize = property === "height" ? selector.offsetHeight : selector.offsetWidth;

    selector.setAttribute("style", "overflow:hidden; max-" + property + ": " + finalSize + "px; transition: " + (duration/1000) + "s");

    selector.classList.add('transitioning');

    window.setTimeout(function (domObject, duration, property) {

        domObject.setAttribute("style", "overflow:hidden; max-" + property + ": 0; transition: " + (duration/1000) + "s");

    }, 10, selector, duration, property);    

    window.setTimeout(function (domObject) {

        domObject.classList.remove("transitioning");
        domObject.setAttribute("style", "");
        domObject.classList.add("hidden");
        domObject.classList.add("__hidden");

    }, duration + 10, selector);

};

var SlideToggle = function (selector, duration, property) {

    if (typeof selector === "string") {
        selector = document.querySelector(selector);
    }

    if (typeof selector !== "object") {
        throw "Selector is invalid";
        return;
    }

    if (selector.classList.contains("__hidden")) {
        SlideOut(selector, duration, property);
    } else {
        SlideIn(selector, duration, property);
    }
}