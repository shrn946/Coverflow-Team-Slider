var swiper = new Swiper(".swiper-container", {
  effect: "coverflow",
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: "auto",
  coverflowEffect: {
    rotate: 20,
    stretch: 0,
    depth: 350,
    modifier: 1,
    slideShadows: true
  },
  pagination: {
    el: ".swiper-pagination"
  },
  breakpoints: {
    // Breakpoint for tablets
    768: {
      slidesPerView: 3, // Display 3 slides per view on tablets
      minWidth: 768 // Minimum width for this breakpoint
    },
    // Breakpoint for mobile devices
    480: {
      slidesPerView: 1, // Display 1 slide per view on mobile devices
      minWidth: 480 // Minimum width for this breakpoint
    },
    // Breakpoint for full-screen desktop view
    1080: {
      slidesPerView: 4, // Display 4 slides per view on full-screen desktop
      minWidth: 1080 // Minimum width for this breakpoint
    },
    1920: {
      slidesPerView: 6, // Display 6 slides per view on full-screen desktop
      minWidth: 1920 // Minimum width for this breakpoint
    }
  }
});
