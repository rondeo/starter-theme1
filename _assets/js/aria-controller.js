(function () {

    function toggleAria(e) {

        if (!! e) {
            e.preventDefault();
        }
    
        var thisButton = e.currentTarget,
            ariaControls,
            thisControls,
            isHidden,
            otherButtons;

        if (! thisButton) {
            return;
        }

        ariaControls = thisButton.getAttribute("aria-controls");

        if (! ariaControls) {
            return;
        }

        thisControls = document.getElementById(ariaControls);
            
        if (! thisControls) {
            return;
        }

        isHidden = ! (thisControls.getAttribute("aria-hidden") === "true");

        thisControls.setAttribute("aria-hidden", isHidden ? "true" : "false")

        if (! isHidden) {
            thisControls.focus();
        }

        otherButtons = document.querySelectorAll('*[aria-controls="' + ariaControls + '"]');
        for(var i = 0; i < otherButtons.length; i += 1) {
            otherButtons[i].setAttribute("aria-expanded", isHidden ? "false" : "true");
            otherButtons[i].blur();
        }

        if (undefined !== CustomEvent) {
        
            document.dispatchEvent(new CustomEvent('aria-changed', {detail: {
                
                button: thisButton,
                controls: thisControls,
                hidden: isHidden
        
            }}));

        }
    
    }

    var ariaControllers = document.querySelectorAll("button[aria-controls]");
    for (var j = 0; j < ariaControllers.length; j += 1) {
        console.log(ariaControllers[j]);
        if (ariaControllers[j].classList.contains("wp-block-typecase-accordion-tabs--toggle"))
            continue;
        ariaControllers[j].addEventListener("click", toggleAria);
    }

}());