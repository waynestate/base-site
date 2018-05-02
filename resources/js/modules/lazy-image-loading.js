(function() {
    "use strict";

    document.addEventListener("DOMContentLoaded", function() {
        var lazyImages = [].slice.call(document.querySelectorAll(".lazy"));

        if ("IntersectionObserver" in window) {
            let lazyImageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let lazyImage = entry.target;

                        if(lazyImage.tagName != 'IMG') {
                            lazyImage.style.backgroundImage = `url('${lazyImage.dataset.src}')`;
                        }else{
                            lazyImage.src = lazyImage.dataset.src;
                        }

                        lazyImage.classList.remove("lazy");
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });

            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        }
    });
})();
