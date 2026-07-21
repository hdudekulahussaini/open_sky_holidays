<!-- Sidebar -->
<aside class="sidebar" id="adminSidebar">

    <!-- Brand -->
    <div class="brand">
        <h2>Open Sky Holidays</h2>
        <p>Administration Panel</p>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                <rect x="3" y="14" width="7" height="7" rx="1"></rect>
            </svg>
            <span>Dashboard</span>
        </a>
        <!-- Hero & Banners Dropdown -->
        <div
            class="nav-dropdown-wrapper {{ request()->routeIs('admin.heroes.*', 'admin.page-banners.*') ? 'open' : '' }}">

            <button type="button" class="nav-dropdown-toggle dropdown-toggle">

                <svg class="nav-main-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                </svg>

                <span class="nav-dropdown-label">Hero &amp; Banners</span>

                <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>

            </button>

            <div class="nav-dropdown-menu">

                <a href="{{ route('admin.heroes.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.heroes.*') ? 'active' : '' }}">

                    <svg class="nav-sub-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                        <path d="M3 16l5-5 4 4 3-3 6 6"></path>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    </svg>

                    <span>Hero Slides</span>
                </a>

                <a href="{{ route('admin.page-banners.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.page-banners.*') ? 'active' : '' }}">

                    <svg class="nav-sub-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                        <path d="M7 8h10"></path>
                        <path d="M7 12h7"></path>
                        <path d="M7 16h4"></path>
                    </svg>

                    <span>Page Banners</span>
                </a>

            </div>
        </div>

        <a href="{{ route('admin.enquiries.index') }}"
            class="nav-item {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                <path d="M3 7l9 6 9-6"></path>
            </svg>
            <span>Enquiries</span>
        </a>
        <!-- About Section -->
        <a href="{{ route('admin.about-sections.index') }}"
            class="nav-item {{ request()->routeIs('admin.about-sections.*') ? 'active' : '' }}">

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="7" r="4"></circle>
                <path d="M5.5 21a6.5 6.5 0 0 1 13 0"></path>
                <path d="M3 3h18"></path>
            </svg>
            <span>About Section</span>
        </a>
        <a href="{{ route('admin.our-stories.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.our-stories.*') ? 'active' : '' }}">
            <span>Our Stories</span>
        </a>

        <a href="{{ route('admin.travel-support.index') }}"
            class="nav-item {{ request()->routeIs('admin.travel-support.*') ? 'active' : '' }}">

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 21s-6-5.33-6-11a6 6 0 1 1 12 0c0 5.67-6 11-6 11z"></path>
                <circle cx="12" cy="10" r="2"></circle>
            </svg>
            <span>Travel Support</span>
        </a>
        <a href="{{ route('admin.why-choose-sections.index') }}" class="sidebar-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
            <span>Why Choose Us</span>
        </a>
        <!-- Testimonials -->
        <a href="{{ route('admin.testimonials.index') }}"
            class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"></path>
                <path d="M8 9h8"></path>
                <path d="M8 13h5"></path>
            </svg>

            <span>Testimonials</span>
        </a>


        <!-- Tour Packages -->
        <a href="#" class="nav-item">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 6h18"></path>
                <path d="M5 6l1 15h12l1-15"></path>
                <path d="M9 6V4h6v2"></path>
                <path d="M9 11h6"></path>
            </svg>
            <span>Tour Packages</span>
        </a>

        <!-- Destinations -->
        <a href="#" class="nav-item">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span>Destinations</span>
        </a>


        <!-- Services -->
        <a href="#" class="nav-item">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="7" width="18" height="13" rx="2"></rect>
                <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <path d="M3 12h18"></path>
                <path d="M10 12v2h4v-2"></path>
            </svg>
            <span>Services</span>
        </a>

        <!-- Blog Management -->
        <div
            class="nav-dropdown-wrapper {{ request()->routeIs('admin.categories.*', 'admin.authors.*', 'admin.blogs.*') ? 'open' : '' }}">
            <button type="button" class="nav-dropdown-toggle dropdown-toggle">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <path d="M16 8h2"></path>
                    <path d="M16 12h2"></path>
                    <path d="M16 16h2"></path>
                    <path d="M6 8h6v8H6z"></path>
                </svg>
                <span>Blog Management</span>
                <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin.categories.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.authors.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Authors</span>
                </a>
                <a href="{{ route('admin.blogs.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    <span>Blogs</span>
                </a>
            </div>
        </div>
        <!-- Settings -->
        <a href="#" class="nav-item">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3"></circle>https://github.com/hdudekulahussaini/open_sky_holidays/pull/5/conflict?name=resources%252Fviews%252Fadmin%252Flayouts%252Fsidebar.blade.php&ancestor_oid=303e1a3c34d6141afd9c8cd41db71aed411c4e25&base_oid=2b767b8b54ee1e67d8266af1c4c854c95d1ac7e8&head_oid=d1170e3a0c0acda0472c0bdff24ed10e050067d3
                <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.05.05a2 2 0 1 1-2.83 2.83l-.05-.05a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V21a2 2 0 0 1-4 0v-.07a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.05.05a2 2 0 1 1-2.83-2.83l.05-.05A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.53-1H3a2 2 0 0 1 0-4h.07A1.7 1.7 0 0 0 4.6 9a1.7 1.7 0 0 0-.34-1.88l-.05-.05a2 2 0 1 1 2.83-2.83l.05.05A1.7 1.7 0 0 0 8.97 4.6 1.7 1.7 0 0 0 10 3.07V3a2 2 0 0 1 4 0v.07a1.7 1.7 0 0 0 1.03 1.53 1.7 1.7 0 0 0 1.88-.34l.05-.05a2 2 0 1 1 2.83 2.83l-.05.05A1.7 1.7 0 0 0 19.4 9a1.7 1.7 0 0 0 1.53 1H21a2 2 0 0 1 0 4h-.07A1.7 1.7 0 0 0 19.4 15z"></path>
            </svg>
            <span>Settings</span>
        </a>

    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="logout-button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <path d="M16 17l5-5-5-5"></path>
                <path d="M21 12H9"></path>
            </svg>
            <span>Logout</span>
        </button>
    </form>

</aside>
