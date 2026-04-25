document.querySelectorAll("[data-include]").forEach(el => {
    fetch(el.getAttribute("data-include"))
        .then(res => res.text())
        .then(html => {
            el.innerHTML = html;

            // after load: set active class
            const current = el.getAttribute("data-active");
            if (current) {
                const target = el.querySelector(`[data-menu="${current}"]`);
                if (target) target.classList.add("active");
            }
        });
});
