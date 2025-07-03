// Mobile Navigation Toggle
document.addEventListener("DOMContentLoaded", function () {
    const navToggle = document.getElementById("navToggle");
    const navMenu = document.getElementById("navMenu");

    if (navToggle && navMenu) {
        navToggle.addEventListener("click", function () {
            navMenu.classList.toggle("active");
            navToggle.classList.toggle("active");
        });

        // Close mobile menu when clicking on a link
        const navLinks = document.querySelectorAll(".nav-link");
        navLinks.forEach((link) => {
            link.addEventListener("click", () => {
                navMenu.classList.remove("active");
                navToggle.classList.remove("active");
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener("click", function (event) {
            const isClickInsideNav =
                navMenu.contains(event.target) ||
                navToggle.contains(event.target);

            if (!isClickInsideNav && navMenu.classList.contains("active")) {
                navMenu.classList.remove("active");
                navToggle.classList.remove("active");
            }
        });
    }
});

// Smooth Scrolling for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));

        if (target) {
            target.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });
});

// Header Scroll Effect
window.addEventListener("scroll", function () {
    const header = document.querySelector(".header");

    if (window.scrollY > 100) {
        header.style.background = "rgba(102, 126, 234, 0.95)";
        header.style.backdropFilter = "blur(10px)";
    } else {
        header.style.background =
            "linear-gradient(135deg, #667eea 0%, #764ba2 100%)";
        header.style.backdropFilter = "none";
    }
});
