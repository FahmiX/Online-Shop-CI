const body = document.querySelector("body");
const sidebar = document.querySelector(".sidebar");
const toggle = document.querySelector(".toggle");
const modeSwitch = document.querySelector(".toggle-switch");
const modeText = document.querySelector(".mode-text");
const modeMoonSun = document.querySelector(".moon-sun");
modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark");
    if (body.classList.contains("dark")) {
        modeText.textContent = "Dark Mode";
        localStorage.setItem("theme", "dark");
    } else {
        modeText.textContent = "Light Mode";
        localStorage.setItem("theme", "light");
    }
});
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if (sidebar.classList.contains("close")) {
        // local storage
        localStorage.setItem("sidebar", "close");
    } else {
        // local storage
        localStorage.setItem("sidebar", "open");
    }
});
localStorage.getItem("theme") === "dark" ? body.classList.add("dark") : body.classList.remove("dark");
localStorage.getItem("sidebar") === "close" ? sidebar.classList.add("close") : sidebar.classList.remove("close");
