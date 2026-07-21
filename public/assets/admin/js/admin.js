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

/*
       |--------------------------------------------------------------------------
       | Adventure Sidebar Dropdown Management
       |--------------------------------------------------------------------------
       */
function toggleSidebarDropdown(button) {
    const currentDropdown = button.closest('.nav-dropdown');

    document
        .querySelectorAll('.nav-dropdown')
        .forEach(function (dropdown) {
            if (dropdown !== currentDropdown) {
                dropdown.classList.remove('open');
            }
        });

    currentDropdown.classList.toggle('open');
}



/* |--------------------------------------------------------------------------
     | Adventure Features Management
 |--------------------------------------------------------------------------
       */

document.addEventListener('DOMContentLoaded', function () {
    const featureContainer =
        document.getElementById('featureContainer');

    const addFeatureButton =
        document.getElementById('addFeatureButton');

    /*
    |--------------------------------------------------------------------------
    | Create one feature row
    |--------------------------------------------------------------------------
    */

    function createFeatureRow() {
        const row = document.createElement('div');

        row.className =
            'feature-row row g-2 align-items-start mb-3';

        row.innerHTML = `
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-check"></i>
                        </span>

                        <input
                            type="text"
                            name="features[]"
                            class="form-control"
                            placeholder="Enter feature"
                        >
                    </div>
                </div>

                <div class="col-auto">
                    <button
                        type="button"
                        class="btn btn-danger remove-feature"
                        title="Delete feature"
                        aria-label="Delete feature"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

        return row;
    }

    /*
    |--------------------------------------------------------------------------
    | Add one feature
    |--------------------------------------------------------------------------
    */

    addFeatureButton.addEventListener('click', function () {
        const rows =
            featureContainer.querySelectorAll('.feature-row');

        if (rows.length >= 10) {
            alert('You can add a maximum of 10 features.');
            return;
        }

        const newRow = createFeatureRow();

        featureContainer.appendChild(newRow);

        const newInput = newRow.querySelector(
            'input[name="features[]"]'
        );

        newInput.focus();
    });

    /*
    |--------------------------------------------------------------------------
    | Delete one feature
    |--------------------------------------------------------------------------
    */

    featureContainer.addEventListener('click', function (event) {
        const removeButton =
            event.target.closest('.remove-feature');

        if (!removeButton) {
            return;
        }

        const rows =
            featureContainer.querySelectorAll('.feature-row');

        if (rows.length === 1) {
            const input = rows[0].querySelector(
                'input[name="features[]"]'
            );

            input.value = '';
            input.focus();

            return;
        }

        const currentRow =
            removeButton.closest('.feature-row');

        currentRow.remove();
    });

    /*
    |--------------------------------------------------------------------------
    | Image preview
    |--------------------------------------------------------------------------
    */

    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (!input || !preview) {
            return;
        }

        input.addEventListener('change', function () {
            preview.innerHTML = '';

            const file = this.files[0];

            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                const image = document.createElement('img');

                image.src = event.target.result;
                image.alt = 'Selected adventure image';
                image.className = 'image-preview';

                preview.appendChild(image);
            };

            reader.readAsDataURL(file);
        });
    }

    setupImagePreview(
        'image_one',
        'imageOnePreview'
    );

    setupImagePreview(
        'image_two',
        'imageTwoPreview'
    );
});


