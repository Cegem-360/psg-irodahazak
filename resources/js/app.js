import "./../css/app.css";

import.meta.glob(["../images/**", "../fonts/**"]);

import jQuery from "jquery";
window.$ = window.jQuery = jQuery;

import "ion-rangeslider";
import "ion-rangeslider/css/ion.rangeSlider.css";

import Swiper from "swiper/bundle";
import "swiper/css/bundle";

document.addEventListener("livewire:load", function () {
    const galleryCarouselSwiperThumbs = new Swiper(
        ".gallery-carousel-swiper-thumbs",
        {
            slidesPerView: 4,
            /* grid: {
            fill: 'row',
            rows: 2,
        }, */
            slideThumbActiveClass: "swiper-slide-thumb-active",
            spaceBetween: 12,
        }
    );

    const galleryCarouselSwiper = new Swiper(".gallery-carousel-swiper", {
        direction: "horizontal",
        loop: true,
        thumbs: {
            swiper: galleryCarouselSwiperThumbs,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});
