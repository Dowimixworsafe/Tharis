function loadPageContent(url, targetSelector = "#main-content") {
    const container = document.querySelector(targetSelector);

    if (!container) return Promise.resolve();
    Loader.show(container);

    return fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((response) => response.text())
        .then((html) => {
            container.innerHTML = html;
            return html;
        })
        .finally(() => {
            Loader.hide(container);
        });
}

document.addEventListener("click", function (event) {
    const sidebarBtn = event.target.closest(".sidebar ul button");
    const link = event.target.closest(".ajax-link");

    if (!sidebarBtn && !link) return;

    if (sidebarBtn) {
        toggleSidebarUI(sidebarBtn);
    }

    if (link) {
        event.preventDefault();
        const url = link.getAttribute("href") || link.dataset.url;
        const target = link.dataset.target;

        loadPageContent(url, target).then(() => {
            history.pushState(null, "", url);
            updateSidebarActiveLink();
        });
    }
});

function updateSidebarActiveLink() {
    const currentPath = window.location.pathname;
    const buttons = document.querySelectorAll(".sidebar ul button.ajax-link");

    buttons.forEach((btn) => {
        const btnUrl = btn.getAttribute("href") || btn.dataset.url;

        if (btnUrl === currentPath) {
            btn.classList.add("active");

            const parentSubMenu = btn.closest(".sub-menu");
            if (parentSubMenu) {
                const ul = parentSubMenu.querySelector("ul");
                parentSubMenu.style.height = `${ul.clientHeight}px`;

                const parentBtn = parentSubMenu.previousElementSibling;
                if (parentBtn) parentBtn.classList.add("active");
            }
        } else {
            btn.classList.remove("active");
        }
    });
}

window.addEventListener("popstate", function () {
    const currentUrl = window.location.pathname;

    loadPageContent(currentUrl).then(() => {
        updateSidebarActiveLink();
    });
});
