const navBar = document.querySelector("nav");
    menuBtns = document.querySelectorAll(".menu-icon");
    overlay = document.querySelector(".overlay");
    
    menuBtns.forEach(menuBtn => {
    menuBtn.addEventListener("click", () => {
        navBar.classList.toggle("open");
        })
    });

    overlay.addEventListener("click", () => {
        navBar.classList.toggle("open")
    })

var swiper = new Swiper(".home-slider", {
    grabCursor: true,
    loop: true,
    centeredSlides: true,
    scrollbar: {
    el: ".swiper-scrollbar",
    hide: true,
    },   
});

const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'vertical',
    loop: true,
  
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });