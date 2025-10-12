const swiper = new Swiper('.swiper', {
  effect: 'fade',
    fadeEffect: {
      crossFade: true,
    },
    loop: true,
    loopAdditionalSlides: 1,
    speed: 3000,//3000
    autoplay: {
      delay: 4000,//7000
      disableOnInteraction: false,
      waitForTransition: false,
    },
    followFinger: false,
    observeParents: true,
});