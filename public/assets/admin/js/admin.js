document.addEventListener("DOMContentLoaded", function () {
    // ------------------------------------------------------------------
    // Sidebar & Mobile Navigation
    // ------------------------------------------------------------------
    const sidebar = document.getElementById("adminSidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebarClose = document.getElementById("sidebarClose");
    const sidebarOverlay = document.getElementById("sidebarOverlay") || document.getElementById("adminOverlay");

    function openSidebar() {
        if (sidebar) sidebar.classList.add("open");
        if (sidebarOverlay) sidebarOverlay.classList.add("show");
        document.body.classList.add("sidebar-open");
        if (sidebarToggle) {
            sidebarToggle.setAttribute("aria-expanded", "true");
            sidebarToggle.setAttribute("aria-label", "Close sidebar");
        }
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove("open");
        if (sidebarOverlay) sidebarOverlay.classList.remove("show");
        document.body.classList.remove("sidebar-open");
        if (sidebarToggle) {
            sidebarToggle.setAttribute("aria-expanded", "false");
            sidebarToggle.setAttribute("aria-label", "Open sidebar");
        }
    }

    function toggleSidebar() {
        if (sidebar && sidebar.classList.contains("open")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", function (e) {
            e.preventDefault();
            toggleSidebar();
        });
    }

    if (sidebarClose) {
        sidebarClose.addEventListener("click", function (e) {
            e.preventDefault();
            closeSidebar();
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener("click", closeSidebar);
    }

    // Close mobile sidebar on nav item link click
    document.querySelectorAll("#adminSidebar .nav-item:not(.nav-dropdown-toggle), #adminSidebar .nav-dropdown-item").forEach(function (link) {
        link.addEventListener("click", function () {
            if (window.innerWidth <= 991) {
                closeSidebar();
            }
        });
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && sidebar && sidebar.classList.contains("open")) {
            closeSidebar();
        }
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 991) {
            closeSidebar();
        }
    });

    // ------------------------------------------------------------------
    // Sidebar Dropdowns
    // ------------------------------------------------------------------
    document.querySelectorAll(".nav-dropdown-toggle").forEach(function (button) {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const wrapper = this.closest(".nav-dropdown-wrapper");
            if (wrapper) {
                const isOpen = wrapper.classList.toggle("open");
                this.setAttribute("aria-expanded", isOpen ? "true" : "false");
            }
        });
    });

    // ------------------------------------------------------------------
    // Password Toggle
    // ------------------------------------------------------------------
    const passwordInput = document.getElementById("password");
    const passwordToggle = document.getElementById("passwordToggle");

    if (passwordInput && passwordToggle) {
        passwordToggle.addEventListener("click", function () {
            const passwordIsHidden = passwordInput.type === "password";
            passwordInput.type = passwordIsHidden ? "text" : "password";
            passwordToggle.textContent = passwordIsHidden ? "Hide" : "Show";
        });
    }

    // ------------------------------------------------------------------
    // Alert Dismissal
    // ------------------------------------------------------------------
    document.querySelectorAll(".alert-close").forEach(function (button) {
        button.addEventListener("click", function () {
            const alert = button.closest(".alert");
            if (alert) {
                alert.remove();
            }
        });
    });

    // ------------------------------------------------------------------
    // Automatic Slug Generation
    // ------------------------------------------------------------------
    const titleInput = document.getElementById("title") || document.getElementById("name");
    const slugInput = document.getElementById("slug");

    if (titleInput && slugInput) {
        let userManuallyEditedSlug = false;

        slugInput.addEventListener("input", function () {
            userManuallyEditedSlug = slugInput.value.trim() !== "";
        });

        titleInput.addEventListener("input", function () {
            if (!userManuallyEditedSlug || slugInput.value.trim() === "") {
                slugInput.value = generateSlug(titleInput.value);
            }
        });
    }

    function generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, "-")
            .replace(/[^\w\-]+/g, "")
            .replace(/\-\-+/g, "-")
            .replace(/^-+/, "")
            .replace(/-+$/, "");
    }

    // ------------------------------------------------------------------
    // Services & Form Repeaters
    // ------------------------------------------------------------------
    function setupSimpleRepeater(containerId, addBtnId, inputName, placeholder) {
        const container = document.getElementById(containerId);
        const addBtn = document.getElementById(addBtnId);

        if (!container || !addBtn) return;

        addBtn.addEventListener("click", function () {
            const row = document.createElement("div");
            row.className = "repeater-card inline-repeater";
            row.innerHTML = `
                <div class="inline-repeater-input">
                    <input type="text" name="${inputName}" class="form-input" placeholder="${placeholder}">
                </div>
                <button type="button" class="remove-btn" title="Remove Item">&times;</button>
            `;
            container.appendChild(row);
        });

        container.addEventListener("click", function (e) {
            const removeBtn = e.target.closest(".remove-btn");
            if (removeBtn) {
                const rows = container.querySelectorAll(".inline-repeater");
                if (rows.length > 1) {
                    removeBtn.closest(".inline-repeater").remove();
                } else {
                    const input = removeBtn.closest(".inline-repeater").querySelector("input");
                    if (input) input.value = "";
                }
            }
        });
    }

    setupSimpleRepeater("serviceItemsContainer", "addServiceItemBtn", "service_items[]", "Enter service item name");
    setupSimpleRepeater("documentsContainer", "addDocumentBtn", "documents[]", "Enter document name");
    setupSimpleRepeater("whyChooseContainer", "addWhyChooseBtn", "why_choose_items[]", "Enter why choose point");

    // Features Repeater
    const featuresContainer = document.getElementById("featuresContainer");
    const addFeatureBtn = document.getElementById("addFeatureBtn");

    if (featuresContainer && addFeatureBtn) {
        addFeatureBtn.addEventListener("click", function () {
            const index = featuresContainer.querySelectorAll(".feature-row").length;
            const card = document.createElement("div");
            card.className = "repeater-card feature-row";
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

        featuresContainer.addEventListener("click", function (e) {
            const removeBtn = e.target.closest(".removeFeatureBtn");
            if (removeBtn) {
                const rows = featuresContainer.querySelectorAll(".feature-row");
                if (rows.length > 1) {
                    removeBtn.closest(".feature-row").remove();
                } else {
                    removeBtn.closest(".feature-row").querySelectorAll("input").forEach((i) => (i.value = ""));
                }
            }
        });
    }

    // Process Steps Repeater
    const stepsContainer = document.getElementById("processStepsContainer");
    const addProcessStepBtn = document.getElementById("addProcessStepBtn");

    if (stepsContainer && addProcessStepBtn) {
        addProcessStepBtn.addEventListener("click", function () {
            const index = stepsContainer.querySelectorAll(".step-row").length;
            const card = document.createElement("div");
            card.className = "repeater-card step-row";
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

        stepsContainer.addEventListener("click", function (e) {
            const removeBtn = e.target.closest(".removeStepBtn");
            if (removeBtn) {
                const rows = stepsContainer.querySelectorAll(".step-row");
                if (rows.length > 1) {
                    removeBtn.closest(".step-row").remove();
                } else {
                    removeBtn.closest(".step-row").querySelectorAll("input").forEach((i) => (i.value = ""));
                }
            }
        });
    }

    // ------------------------------------------------------------------
    // Topbar Profile Dropdown Toggle
    // ------------------------------------------------------------------
    const profileDropdown = document.getElementById("topbarProfileDropdown");
    const profileToggle = document.getElementById("topbarProfileToggle");

    if (profileDropdown && profileToggle) {
        profileToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            profileDropdown.classList.toggle("open");
            const isOpen = profileDropdown.classList.contains("open");
            profileToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
        });

        document.addEventListener("click", function (e) {
            if (!profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove("open");
                profileToggle.setAttribute("aria-expanded", "false");
            }
        });
    }
});
