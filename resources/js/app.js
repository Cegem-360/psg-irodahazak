import "./../css/app.css";

import.meta.glob(["../images/**", "../fonts/**"]);

import jQuery from "jquery";
window.$ = window.jQuery = jQuery;
import "ion-rangeslider";
import "ion-rangeslider/css/ion.rangeSlider.css";

import Swiper from "swiper/bundle";
import "swiper/css";
import "swiper/css/bundle";
import "swiper/css/navigation";

// Expose Swiper globally so Alpine.js components can access it
window.Swiper = Swiper;
import "flowbite";
import { initFlowbite } from "flowbite";
import "./office-search-form.js";
import "./counters.js";
document.addEventListener("livewire:navigated", () => {
    initFlowbite();
});

// Swipers are (re)initialised on every "livewire:navigated", which also fires on the
// first page load, so carousels work after wire:navigate page changes too. An
// element that already carries a Swiper instance is skipped.
function initSwiper(selector, options) {
    const element = document.querySelector(selector);

    if (!element || element.swiper) {
        return element?.swiper ?? null;
    }

    return new Swiper(element, options);
}

document.addEventListener("livewire:navigated", function () {
    const galleryCarouselSwiperThumbs = initSwiper(
        ".gallery-carousel-swiper-thumbs",
        {
            slidesPerView: 4,
            slideThumbActiveClass: "swiper-slide-thumb-active",
            spaceBetween: 12,
        }
    );

    const galleryCarouselSwiper = initSwiper(".gallery-carousel-swiper", {
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

    const referenceSwiper = initSwiper(".reference-swiper", {
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
            320: {
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

    const rolunkmondtakSwiper = initSwiper(".rolunkmondtak-swiper", {
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
            320: {
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
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    const kiemeltajanlatokSwiper = initSwiper(".kiemeltajanlatok-swiper", {
        direction: "horizontal",
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        loop: true,
        slidesPerView: 3,
        spaceBetween: 12,
        breakpoints: {
            // create responsive breakpoints matching Tailwind's breakpoints
            320: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 3,
            },
        },
        navigation: {
            nextEl: ".kiemelt-button-next",
            prevEl: ".kiemelt-button-prev",
        },
    });

    // NOTE: minicarousel-swiper initialization has been moved to Alpine.js
    // in the property-card Livewire component. Each card now initializes its own
    // Swiper instance via x-data/x-init, which ensures Swiper works correctly
    // after Livewire pagination re-renders the DOM.
});

// Cookie management for favorites
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie =
        name + "=" + value + ";expires=" + expires.toUTCString() + ";path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

// Listen for Livewire events
document.addEventListener("livewire:initialized", function () {
    // Listen for cookie setting events from Livewire
    Livewire.on("set-cookie", (event) => {
        setCookie(event.name, event.value, event.days);
        updateFavoritesCounter();
    });

    Livewire.on("favorites-updated", updateFavoritesCounter);
});

// Update favorites counter in navigation
function updateFavoritesCounter() {
    const favorites = getCookie("property_favorites");
    const count = favorites ? JSON.parse(favorites).length : 0;

    const counter = document.querySelector(".favorites-counter");
    if (counter) {
        counter.textContent = count;
        if (count > 0) {
            counter.style.display = "flex";
        } else {
            counter.style.display = "none";
        }
    }
}

// Initialize counter on page load and after every wire:navigate page change
document.addEventListener("livewire:navigated", function () {
    updateFavoritesCounter();
});
