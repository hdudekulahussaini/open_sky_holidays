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

// Services Repeaters Management
document.addEventListener('DOMContentLoaded', function () {
    function setupSimpleRepeater(containerId, addBtnId, inputName, placeholder) {
        const container = document.getElementById(containerId);
        const addBtn = document.getElementById(addBtnId);

        if (!container || !addBtn) return;

        addBtn.addEventListener('click', function () {
            const row = document.createElement('div');
            row.className = 'repeater-card inline-repeater';
            row.innerHTML = `
                <div class="inline-repeater-input">
                    <input type="text" name="${inputName}" class="form-input" placeholder="${placeholder}">
                </div>
                <button type="button" class="remove-btn" title="Remove Item">&times;</button>
            `;
            container.appendChild(row);
        });

        container.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-btn');
            if (removeBtn) {
                const rows = container.querySelectorAll('.inline-repeater');
                if (rows.length > 1) {
                    removeBtn.closest('.inline-repeater').remove();
                } else {
                    const input = removeBtn.closest('.inline-repeater').querySelector('input');
                    if (input) input.value = '';
                }
            }
        });
    }

    setupSimpleRepeater('serviceItemsContainer', 'addServiceItemBtn', 'service_items[]', 'Enter service item name');
    setupSimpleRepeater('documentsContainer', 'addDocumentBtn', 'documents[]', 'Enter document name');
    setupSimpleRepeater('whyChooseContainer', 'addWhyChooseBtn', 'why_choose_items[]', 'Enter why choose point');

    // Features Repeater
    const featuresContainer = document.getElementById('featuresContainer');
    const addFeatureBtn = document.getElementById('addFeatureBtn');

    if (featuresContainer && addFeatureBtn) {
        addFeatureBtn.addEventListener('click', function () {
            const index = featuresContainer.querySelectorAll('.feature-row').length;
            const card = document.createElement('div');
            card.className = 'repeater-card feature-row';
            card.innerHTML = `
                <button type="button" class="remove-btn removeFeatureBtn" title="Remove Feature">&times;</button>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label class="form-label">Feature Title <span class="required">*</span></label>
                        <input type="text" name="features[${index}][title]" class="form-input" placeholder="Enter feature title" required>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">Feature Description</label>
                        <input type="text" name="features[${index}][description]" class="form-input" placeholder="Enter feature description">
                    </div>
                </div>
            `;
            featuresContainer.appendChild(card);
        });

        featuresContainer.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.removeFeatureBtn');
            if (removeBtn) {
                const rows = featuresContainer.querySelectorAll('.feature-row');
                if (rows.length > 1) {
                    removeBtn.closest('.feature-row').remove();
                } else {
                    removeBtn.closest('.feature-row').querySelectorAll('input').forEach(i => i.value = '');
                }
            }
        });
    }

    // Process Steps Repeater
    const stepsContainer = document.getElementById('processStepsContainer');
    const addProcessStepBtn = document.getElementById('addProcessStepBtn');

    if (stepsContainer && addProcessStepBtn) {
        addProcessStepBtn.addEventListener('click', function () {
            const index = stepsContainer.querySelectorAll('.step-row').length;
            const card = document.createElement('div');
            card.className = 'repeater-card step-row';
            card.innerHTML = `
                <button type="button" class="remove-btn removeStepBtn" title="Remove Step">&times;</button>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Step Icon / Number</label>
                        <input type="text" name="process_steps[${index}][icon]" class="form-input" placeholder="e.g. 01">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Step Title <span class="required">*</span></label>
                        <input type="text" name="process_steps[${index}][title]" class="form-input" placeholder="Enter step title" required>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">Step Description</label>
                        <input type="text" name="process_steps[${index}][description]" class="form-input" placeholder="Enter step description">
                    </div>
                </div>
            `;
            stepsContainer.appendChild(card);
        });

        stepsContainer.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.removeStepBtn');
            if (removeBtn) {
                const rows = stepsContainer.querySelectorAll('.step-row');
                if (rows.length > 1) {
                    removeBtn.closest('.step-row').remove();
                } else {
                    removeBtn.closest('.step-row').querySelectorAll('input').forEach(i => i.value = '');
                }
            }
        });
    }
});

