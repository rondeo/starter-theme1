(function () {

    function addScrollClasses(e) {

        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
        if (scrollTop > 0) {
            document.body.classList.add('__below-top');        
            document.body.classList.remove('__at-top');
        } else {
            document.body.classList.remove('__below-top');
            document.body.classList.add('__at-top');
        }

    }

    window.addEventListener("scroll", addScrollClasses);
    document.addEventListener("DOMContentLoaded", addScrollClasses);

}());