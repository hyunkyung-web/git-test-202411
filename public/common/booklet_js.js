const tabBtn = document.querySelectorAll(".tab-btn");
const tabContent = document.querySelectorAll(".tab-content");

console.log(tabBtn);
console.log(tabContent);

let activeCont = ""; // #tab1

for (let i = 0; i < tabBtn.length; i++) {
    tabBtn[i].addEventListener("click", function (e) {
        e.preventDefault();
        for (let j = 0; j < tabBtn.length; j++) {
            tabBtn[j].classList.remove("active");
            tabContent[j].style.display = "none";
        }

        this.classList.add("active");
        activeCont = this.getAttribute("href");
        document.querySelector(activeCont).style.display = "block";
    });
}
