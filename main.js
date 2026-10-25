document.addEventListener("DOMContentLoaded", function () {
    const menuButton = document.getElementById("menuToggle");
    const navigation = document.getElementById("mainNav");

    if (menuButton && navigation) {
        menuButton.addEventListener("click", function () {
            const isOpen = navigation.classList.toggle("open");
            menuButton.setAttribute("aria-expanded", String(isOpen));
        });
    }

    const items = document.querySelectorAll(".reveal");

    if ("IntersectionObserver" in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        items.forEach(function (item) {
            observer.observe(item);
        });
    } else {
        items.forEach(function (item) {
            item.classList.add("visible");
        });
    }
});