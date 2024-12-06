document.addEventListener("DOMContentLoaded", function () {
    const hamburgerMenu = document.querySelector(".hamburger-menu");
    const navLinks = document.querySelector(".menu-toggle");

    navLinks.addEventListener("click", function () {
        hamburgerMenu.classList.toggle("active");
        navLinks.classList.toggle("active");
    });
});

function callData(pageNum) {
    var callUrl;

    switch (pageNum) {
        // main
        case 1:
            callUrl = "/";
            break;
        //member
        case 11:
            callUrl = "/member/verify";
            break;
        case 12:
            callUrl = "member/sign_up";
            break;
        // article
        case 2:
            callUrl = "/article/list";
            break;
        case 21:
            callUrl = "/article/node";
            break;
    }

    window.location.href = callUrl;
}
