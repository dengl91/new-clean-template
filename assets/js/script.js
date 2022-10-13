// custom script

document.addEventListener("DOMContentLoaded", function () {

    checkLazy();

    async function checkLazy() {

        const lazyImages = [].slice.call(document.querySelectorAll("[data-bg]"));

        if ("IntersectionObserver" in window) {
            let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        let lazyImage = entry.target;
                        let src = lazyImage.getAttribute('data-bg');
                        lazyImage.style.backgroundImage = 'url(' + src + ')';
                        lazyImage.classList.remove('lazy');
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });

            lazyImages.forEach(function (lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        } else {
            // Possibly fall back to event handlers here
        }

    }

    checkLoad();

    async function checkLoad() {

        const lazyLoadImages = [].slice.call(document.querySelectorAll('[data-load]'));

        lazyLoadImages.forEach(function (lazyImage) {
            let src = lazyImage.getAttribute('data-load');
            let img = new Image();
            img.src = src;
            img.onload = function () {
                lazyImage.src = src;
            }
        });

    }

    // data events

    const toggles = document.querySelectorAll('[data-toggle]');

    toggles.forEach(function (toggle, index, array) {
        toggle.addEventListener('click', () => {
            toggle.classList.toggle('active');
        });
    });

    const controls = document.querySelectorAll('[data-control]');

    controls.forEach(function (control, index, array) {
        control.addEventListener('click', () => {
            let target = control.getAttribute('data-control');
            document.querySelector('.' + target).classList.toggle('active');
        });
    });

    const modal_close = document.querySelector('.modal__close');

    if (modal_close) {
        document.querySelector('.modal__close').addEventListener('click', () => {
            document.querySelector('.modal').classList.remove('active');
        });
    }

    const modal = document.querySelector('.modal');

    if (modal) {
        document.querySelector('.modal').addEventListener('click', (event) => {
            let self = document.querySelector('.modal');
            if (event.target !== self) return;
            document.querySelector('.modal').classList.remove('active');
        });
    }

    const headers = [].slice.call(document.querySelectorAll('h2'));

    if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    let header = entry.target;
                    header.classList.add('animated');
                    lazyImageObserver.unobserve(header);
                }
            });
        });

        headers.forEach(function (header) {
            lazyImageObserver.observe(header);
        });
    }

});

// FCP logger
new PerformanceObserver((entryList) => {
    for (const entry of entryList.getEntriesByName('first-contentful-paint')) {
        console.log('FCP candidate:', entry.startTime, entry);
    }
}).observe({ type: 'paint', buffered: true });

// iOS Safari
document.addEventListener('click', x => 0);[]

// Native loading lazy support
if ('loading' in HTMLImageElement.prototype) {
    console.log('Supports loading');
}