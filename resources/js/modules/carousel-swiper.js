import { Swiper } from 'swiper';
import { Navigation, Pagination, A11y } from 'swiper/modules';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

(function() {
    "use strict";

    // Find carousel elements that should use Swiper
    const swiperCarousels = document.querySelectorAll('.rotate[data-carousel="swiper"]');

    swiperCarousels.forEach(function(carousel) {
        // Transform existing HTML structure to Swiper-compatible structure
        const heroWrappers = carousel.querySelectorAll('.hero__wrapper');

        if(heroWrappers.length > 0) {
            // Add Swiper class
            carousel.classList.add('swiper');

            // Create swiper-wrapper and move existing content
            const swiperWrapper = document.createElement('div');
            swiperWrapper.className = 'swiper-wrapper';

            // Convert each hero__wrapper to swiper-slide
            heroWrappers.forEach(function(wrapper) {
                const slide = document.createElement('div');
                slide.className = 'swiper-slide';
                slide.innerHTML = wrapper.outerHTML;
                swiperWrapper.appendChild(slide);
            });

            // Clear original content and add swiper structure
            carousel.innerHTML = '';
            carousel.appendChild(swiperWrapper);

            // Add navigation and pagination elements with custom SVG icons that we are using from Flickity
            carousel.insertAdjacentHTML('beforeend', `
            <div class="swiper-button-prev">
                <svg class="swiper-button-icon" viewBox="0 0 100 100">
                    <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path>
                </svg>
            </div>
            <div class="swiper-button-next">
                <svg class="swiper-button-icon" viewBox="0 0 100 100">
                    <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path>
                </svg>
            </div>
            <div class="swiper-pagination visually-hidden"></div>
        `);

            // Initialize Swiper
            new Swiper(carousel, {
                modules: [Navigation, Pagination, A11y],
                loop: true,
                autoHeight: true,
                speed: 600, // *duration in ms
                effect: 'slide',
                slidesPerView: 1,
                spaceBetween: 0,
                threshold: 3,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                a11y: {
                    enabled: true,
                },
            });
        }
    });
})();
