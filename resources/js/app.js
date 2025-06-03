import './../css/app.css';

import.meta.glob(["../images/**", "../fonts/**"]);

import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.swiper-container').forEach((el) => {
    new Swiper(el, {
      slidesPerView: 1,
      spaceBetween: 10,
      pagination: {
        el: el.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: el.querySelector('.swiper-button-next'),
        prevEl: el.querySelector('.swiper-button-prev'),
      },
      loop: true,
    });
  });
  const galleryCarouselSwiperThumbs = new Swiper(".gallery-carousel-swiper-thumbs", {

        slidesPerView: 3,
        grid: {
            fill: 'row',
            rows: 8,
        },
        spaceBetween: 10,
    });

    const galleryCarouselSwiper = new Swiper('.gallery-carousel-swiper', {

        direction: 'horizontal',
        loop: true,
        thumbs: {
            swiper: galleryCarouselSwiperThumbs,
        },
    });

});