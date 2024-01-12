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