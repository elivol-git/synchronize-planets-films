document.addEventListener("DOMContentLoaded", () => {
    const themes = ["light", "dark", "datapad", "space"];
    const icons = {
        light: "☀️",
        dark: "🌙",
        datapad: "📟",
        space: "🌌"
    };

    const btn = document.getElementById("themeToggle");
    const icon = document.getElementById("themeIcon");

    // Load previous theme
    if (!localStorage.getItem("theme")) {
        localStorage.setItem("theme", "light");
    }

    applyTheme(localStorage.getItem("theme"));

    btn.addEventListener("click", () => {
        let current = localStorage.getItem("theme");
        let next = themes[(themes.indexOf(current) + 1) % themes.length];
        applyTheme(next);
    });

    function applyTheme(mode) {
        // Reset all modes
        document.body.classList.remove("dark-mode", "space-mode", "datapad-mode");

        if (mode === "dark") document.body.classList.add("dark-mode");
        if (mode === "space") document.body.classList.add("space-mode");
        if (mode === "datapad") document.body.classList.add("datapad-mode");

        localStorage.setItem("theme", mode);
        icon.textContent = icons[mode];
    }
});
