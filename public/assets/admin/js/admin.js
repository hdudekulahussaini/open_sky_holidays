document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("adminSidebar");
    const overlay = document.getElementById("adminOverlay");
    const openButton = document.getElementById("sidebarToggle");
    const closeButton = document.getElementById("sidebarClose");

    function openSidebar() {
        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.add("open");
        overlay.classList.add("show");
        document.body.style.overflow = "hidden";
    }

    function closeSidebar() {
        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.remove("open");
        overlay.classList.remove("show");
        document.body.style.overflow = "";
    }

    if (openButton) {
        openButton.addEventListener("click", openSidebar);
    }

    if (closeButton) {
        closeButton.addEventListener("click", closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener("click", closeSidebar);
    }

    window.addEventListener("resize", function () {
        if (window.innerWidth > 992) {
            closeSidebar();
        }
    });

    const passwordInput = document.getElementById("password");
    const passwordToggle = document.getElementById("passwordToggle");

    if (passwordInput && passwordToggle) {
        passwordToggle.addEventListener("click", function () {
            const passwordIsHidden =
                passwordInput.type === "password";

            passwordInput.type = passwordIsHidden
                ? "text"
                : "password";

            passwordToggle.textContent = passwordIsHidden
                ? "Hide"
                : "Show";
        });
    }

    document.querySelectorAll(".alert-close").forEach(function (button) {
        button.addEventListener("click", function () {
            const alert = button.closest(".alert");

            if (alert) {
                alert.remove();
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("adminSidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebarOverlay = document.getElementById("sidebarOverlay");
    const sidebarLinks = document.querySelectorAll(
        "#adminSidebar .nav-item"
    );

    if (!sidebar || !sidebarToggle || !sidebarOverlay) {
        return;
    }

    function openSidebar() {
        sidebar.classList.add("open");
        sidebarOverlay.classList.add("show");
        document.body.classList.add("sidebar-open");

        sidebarToggle.setAttribute("aria-expanded", "true");
        sidebarToggle.setAttribute("aria-label", "Close sidebar");
    }

    function closeSidebar() {
        sidebar.classList.remove("open");
        sidebarOverlay.classList.remove("show");
        document.body.classList.remove("sidebar-open");

        sidebarToggle.setAttribute("aria-expanded", "false");
        sidebarToggle.setAttribute("aria-label", "Open sidebar");
    }

    function toggleSidebar() {
        if (sidebar.classList.contains("open")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    sidebarToggle.addEventListener("click", toggleSidebar);

    sidebarOverlay.addEventListener("click", closeSidebar);

    sidebarLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            if (window.innerWidth <= 991) {
                closeSidebar();
            }
        });
    });

    document.addEventListener("keydown", function (event) {
        if (
            event.key === "Escape" &&
            sidebar.classList.contains("open")
        ) {
            closeSidebar();
        }
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 991) {
            closeSidebar();
        }
    });
});
document.querySelectorAll('.dropdown-toggle').forEach(function (item) {
    item.addEventListener('click', function () {
        this.parentElement.classList.toggle('open');
    });
});

// Automatic Slug Generation
document.addEventListener("DOMContentLoaded", function () {
    const titleInput = document.getElementById("title") || document.getElementById("name");
    const slugInput = document.getElementById("slug");

    if (titleInput && slugInput) {
        let userEditedSlug = slugInput.value.trim() !== "";

        slugInput.addEventListener("input", function () {
            userEditedSlug = slugInput.value.trim() !== "";
        });

        titleInput.addEventListener("input", function () {
            if (!userEditedSlug) {
                slugInput.value = generateSlug(titleInput.value);
            }
        });
    }

    function generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, "-")           // Replace spaces with -
            .replace(/[^\w\-]+/g, "")       // Remove all non-word chars
            .replace(/\-\-+/g, "-")         // Replace multiple - with single -
            .replace(/^-+/, "")             // Trim - from start
            .replace(/-+$/, "");            // Trim - from end
    }
});
