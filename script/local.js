document.addEventListener("DOMContentLoaded", function () {
    const hamburgerMenu = document.querySelector(".hamburger-menu");
    const navLinks = document.querySelector(".menu-toggle");

    navLinks.addEventListener("click", function () {
        hamburgerMenu.classList.toggle("active");
        navLinks.classList.toggle("active");
    });
});
