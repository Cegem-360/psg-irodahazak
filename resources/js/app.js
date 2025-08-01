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

document.addEventListener("DOMContentLoaded", function () {
    const galleryCarouselSwiperThumbs = new Swiper(
        ".gallery-carousel-swiper-thumbs",
        {
            slidesPerView: 4,
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

    const kiemeltajanlatokSwiper = new Swiper(".kiemeltajanlatok-swiper", {
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

    const minicarouselSwiper = new Swiper(".minicarousel-swiper", {
        direction: "horizontal",
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: ".minicarousel-button-next",
            prevEl: ".minicarousel-button-prev",
        },
    });
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
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
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

// Initialize counter on page load
document.addEventListener("DOMContentLoaded", function () {
    updateFavoritesCounter();
});
