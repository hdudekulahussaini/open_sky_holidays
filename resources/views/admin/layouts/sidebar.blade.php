<!-- Sidebar -->
<aside class="sidebar" id="adminSidebar">

    <!-- Brand -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <div class="brand">
            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="Open Sky Holidays" class="brand-logo">
            <p>Administration Panel</p>
        </div>
    </a>

    <!-- Navigation -->
    <nav class="sidebar-nav">

        <!-- Dashboard -->
        <a
            href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge menu-icon"></i>
            <span>Dashboard</span>
        </a>

        <!-- Hero & Banners Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.top-headers.*', 'admin.heroes.*', 'admin.offer-banners.*', 'admin.page-banners.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.top-headers.*', 'admin.heroes.*', 'admin.offer-banners.*', 'admin.page-banners.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.top-headers.*', 'admin.heroes.*', 'admin.offer-banners.*', 'admin.page-banners.*') ? 'true' : 'false' }}">
                <i class="fa-solid fa-images menu-icon"></i>
                <span>Home Page</span>
                <i class="fa-solid fa-chevron-down chevron-icon"></i>
            </button>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin.top-headers.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.top-headers.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-heading submenu-icon"></i>
                    <span>Top Header Bar</span>
                </a>
                <a href="{{ route('admin.heroes.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.heroes.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders submenu-icon"></i>
                    <span>Hero Slides</span>
                </a>
                <a href="{{ route('admin.page-banners.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.page-banners.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-image submenu-icon"></i>
                    <span>Page Banners</span>
                </a>
                <a href="{{ route('admin.about-sections.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.about-sections.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-building submenu-icon"></i>
                    <span>About Section</span>
                </a>
                <!-- Travel Support -->
                <a href="{{ route('admin.travel-support.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.travel-support.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-headset submenu-icon"></i>
                    <span>Travel Support</span>
                </a>
                <!-- Why Choose Us -->
                <a href="{{ route('admin.why-choose-sections.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.why-choose-sections.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-shield-halved submenu-icon"></i>
                    <span>Why Choose Us</span>
                </a>
                <!-- Offer Banners -->
                <a href="{{ route('admin.offer-banners.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.offer-banners.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags submenu-icon"></i>
                    <span>Offer Banners</span>
                </a>
                <!-- Testimonials -->
                <a href="{{ route('admin.testimonials.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-star submenu-icon"></i>
                    <span>Testimonials</span>
                </a>
            </div>
        </div>

                <!-- About Management Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.about-sections.*', 'admin.our-stories.*', 'admin.our-processes.*', 'admin.counters.*', 'admin.what-we-offers.*', 'admin.about-why-choose-us.*', 'admin.about-our-core-values.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.about-sections.*', 'admin.our-stories.*', 'admin.our-processes.*', 'admin.counters.*', 'admin.what-we-offers.*', 'admin.about-why-choose-us.*', 'admin.about-our-core-values.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.about-sections.*', 'admin.our-stories.*', 'admin.our-processes.*', 'admin.counters.*', 'admin.what-we-offers.*', 'admin.about-why-choose-us.*', 'admin.about-our-core-values.*') ? 'true' : 'false' }}">
                <i class="fa-solid fa-circle-info menu-icon"></i>
                <span>About Management</span>
                <i class="fa-solid fa-chevron-down chevron-icon"></i>
            </button>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin.our-stories.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.our-stories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open submenu-icon"></i>
                    <span>Our Story</span>
                </a>
                <a href="{{ route('admin.our-processes.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.our-processes.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gears submenu-icon"></i>
                    <span>Our Process</span>
                </a>
                <a href="{{ route('admin.counters.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.counters.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calculator submenu-icon"></i>
                    <span>Counters</span>
                </a>
                <a href="{{ route('admin.what-we-offers.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.what-we-offers.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-handshake submenu-icon"></i>
                    <span>What We Offer</span>
                </a>
                <a href="{{ route('admin.about-why-choose-us.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.about-why-choose-us.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-award submenu-icon"></i>
                    <span>Why Choose Us</span>
                </a>
                <a href="{{ route('admin.about-our-core-values.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.about-our-core-values.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-heart submenu-icon"></i>
                    <span>Core Values</span>
                </a>
            </div>
        </div>

        <!-- Tour Management Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.tours.*', 'admin.tour-types.*', 'admin.tour-details.*', 'admin.tour-features.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.tours.*', 'admin.tour-types.*', 'admin.tour-details.*', 'admin.tour-features.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.tours.*', 'admin.tour-types.*', 'admin.tour-details.*', 'admin.tour-features.*') ? 'true' : 'false' }}">
                <i class="fa-solid fa-plane-departure menu-icon"></i>
                <span>Tour Management</span>
                <i class="fa-solid fa-chevron-down chevron-icon"></i>
            </button>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin.tour-types.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.tour-types.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group submenu-icon"></i>
                    <span>Tour Types</span>
                </a>
                <a href="{{ route('admin.tours.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.tours.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-map-location-dot submenu-icon"></i>
                    <span>Tours</span>
                </a>
            </div>
        </div>

        <!-- Adventure Management Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.adventure-categories.*', 'admin.adventures.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.adventure-categories.*', 'admin.adventures.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.adventure-categories.*', 'admin.adventures.*') ? 'true' : 'false' }}">
                <i class="fa-solid fa-person-hiking menu-icon"></i>
                <span>Adventure Management</span>
                <i class="fa-solid fa-chevron-down chevron-icon"></i>
            </button>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin.adventure-categories.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.adventure-categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list submenu-icon"></i>
                    <span>Adventure Categories</span>
                </a>
                <a href="{{ route('admin.adventures.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.adventures.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-compass submenu-icon"></i>
                    <span>Adventures</span>
                </a>
            </div>
        </div>

        <!-- Blog Management Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.categories.*', 'admin.authors.*', 'admin.blogs.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.categories.*', 'admin.authors.*', 'admin.blogs.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.categories.*', 'admin.authors.*', 'admin.blogs.*') ? 'true' : 'false' }}">
                <i class="fa-solid fa-newspaper menu-icon"></i>
                <span>Blog Management</span>
                <i class="fa-solid fa-chevron-down chevron-icon"></i>
            </button>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin.categories.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-folder submenu-icon"></i>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.authors.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users submenu-icon"></i>
                    <span>Authors</span>
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="nav-dropdown-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-blog submenu-icon"></i>
                    <span>Blogs</span>
                </a>
            </div>
        </div>

        <!-- Enquiries -->
        <a href="{{ route('admin.enquiries.index') }}" class="nav-item {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
            <i class="fa-solid fa-envelope menu-icon"></i>
            <span>Enquiries</span>
        </a>

        <!-- Tour Inquiries -->
        <a href="{{ route('admin.tour-inquiries.index') }}" class="nav-item {{ request()->routeIs('admin.tour-inquiries.*') ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-list menu-icon"></i>
            <span>Tour Inquiries</span>
        </a>

        <!-- Services -->
        <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <i class="fa-solid fa-briefcase menu-icon"></i>
            <span>Services</span>
        </a>


        <!-- Contact Section -->
        <a href="{{ route('admin.contact-sections.index') }}" class="nav-item {{ request()->routeIs('admin.contact-sections.*') ? 'active' : '' }}">
            <i class="fa-solid fa-address-book menu-icon"></i>
            <span>Contact Section</span>
        </a>

        <!-- Profile Settings -->
        <a href="{{ route('admin.profile.edit') }}" class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-gear menu-icon"></i>
            <span>Profile Settings</span>
        </a>

    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="logout-button">
            <i class="fa-solid fa-right-from-bracket menu-icon"></i>
            <span>Logout</span>
        </button>
    </form>

</aside>