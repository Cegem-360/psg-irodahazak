import "./../css/app.css";

import.meta.glob(["../images/**", "../fonts/**"]);

import jQuery from "jquery";
window.$ = window.jQuery = jQuery;
import "ion-rangeslider";
import "ion-rangeslider/css/ion.rangeSlider.css";

import Swiper from "swiper/bundle";
import "swiper/css/bundle";

document.addEventListener("DOMContentLoaded", function () {
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

    const referenceSwiper = new Swiper(".reference-swiper", {
        direction: "horizontal",
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        loop: true,
        slidesPerView: 6,
        spaceBetween: 12,
        breakpoints: {
            // create responsive breakpoints matching Tailwind's breakpoints
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 5,
            },
        },
        navigation: {
            nextEl: ".reference-button-next",
            prevEl: ".reference-button-prev",
        },
    });

    const rolunkmondtakSwiper = new Swiper(".rolunkmondtak-swiper", {
        direction: "horizontal",
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        loop: true,
        slidesPerView: 2,
        spaceBetween: 12,
        breakpoints: {
            // create responsive breakpoints matching Tailwind's breakpoints
            640: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
        },
        navigation: {
            nextEl: ".rolunkmondtak-button-next",
            prevEl: ".rolunkmondtak-button-prev",
        },
    });
});
