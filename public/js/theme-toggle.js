let modes = ["light", "dark-mode", "space-mode"];
let index = 0;

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("themeToggle");

    btn.addEventListener("click", () => {
        // Remove all modes
        document.body.classList.remove("dark-mode", "space-mode");

        index = (index + 1) % modes.length;

        if (modes[index] !== "light") {
            document.body.classList.add(modes[index]);
        }

        btn.innerText = "Mode: " + modes[index];
    });
});
