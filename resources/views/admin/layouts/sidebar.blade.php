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
        <a
            href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >
            <svg
                class="menu-icon"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                <rect x="3" y="14" width="7" height="7" rx="1"></rect>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Hero & Banners Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.heroes.*', 'admin.offer-banners.*', 'admin.page-banners.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.heroes.*', 'admin.offer-banners.*', 'admin.page-banners.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.heroes.*', 'admin.offer-banners.*', 'admin.page-banners.*') ? 'true' : 'false' }}"
            >
                <svg
                    class="menu-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                </svg>
                <span>Hero &amp; Banners</span>
                <svg
                    class="chevron-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="nav-dropdown-menu">
                <!-- Hero Slides -->
                <a
                    href="{{ route('admin.heroes.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.heroes.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    <span>Hero Slides</span>
                </a>
                <!-- Offer Banners -->
                <a
                    href="{{ route('admin.offer-banners.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.offer-banners.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                        <path d="M7 8h6"></path>
                        <path d="M7 12h4"></path>
                    </svg>
                    <span>Offer Banners</span>
                </a>
                <!-- Page Banners -->
                <a
                    href="{{ route('admin.page-banners.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.page-banners.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                        <path d="M7 8h10"></path>
                        <path d="M7 12h7"></path>
                        <path d="M7 16h4"></path>
                    </svg>
                    <span>Page Banners</span>
                </a>
            </div>
        </div>

        <!-- Adventure Management Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.adventure-categories.*', 'admin.adventures.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.adventure-categories.*', 'admin.adventures.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.adventure-categories.*', 'admin.adventures.*') ? 'true' : 'false' }}"
            >
                <svg
                    class="menu-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M3 20h18"></path>
                    <path d="M5 20l5-12 3 7 2-4 4 9"></path>
                    <circle cx="18" cy="5" r="2"></circle>
                </svg>
                <span>Adventure Management</span>
                <svg
                    class="chevron-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="nav-dropdown-menu">
                <a
                    href="{{ route('admin.adventure-categories.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.adventure-categories.*') ? 'active' : '' }}"
                >
                    <svg class="submenu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Adventure Categories</span>
                </a>
                <a
                    href="{{ route('admin.adventures.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.adventures.*') ? 'active' : '' }}"
                >
                    <svg class="submenu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>Adventures</span>
                </a>
            </div>
        </div>

        <!-- Enquiries -->
        <a
            href="{{ route('admin.enquiries.index') }}"
            class="nav-item {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}"
        >
            <svg
                class="menu-icon"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                <path d="M3 7l9 6 9-6"></path>
            </svg>
            <span>Enquiries</span>
        </a>

        <!-- Services -->
        <a
            href="{{ route('admin.services.index') }}"
            class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
        >
            <svg
                class="menu-icon"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            <span>Services</span>
        </a>

        <!-- About Management Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.about-sections.*', 'admin.our-stories.*', 'admin.our-processes.*', 'admin.counters.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.about-sections.*', 'admin.our-stories.*', 'admin.our-processes.*', 'admin.counters.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.about-sections.*', 'admin.our-stories.*', 'admin.our-processes.*', 'admin.counters.*') ? 'true' : 'false' }}"
            >
                <svg
                    class="menu-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M5.5 21a6.5 6.5 0 0 1 13 0"></path>
                    <path d="M3 3h18"></path>
                </svg>
                <span>About Management</span>
                <svg
                    class="chevron-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="nav-dropdown-menu">
                <!-- About Section -->
                <a
                    href="{{ route('admin.about-sections.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.about-sections.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M5.5 21a6.5 6.5 0 0 1 13 0"></path>
                    </svg>
                    <span>About Section</span>
                </a>
                <!-- Our Story -->
                <a
                    href="{{ route('admin.our-stories.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.our-stories.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        <path d="M8 7h8"></path>
                        <path d="M8 11h6"></path>
                    </svg>
                    <span>Our Story</span>
                </a>
                <!-- Our Process -->
                <a
                    href="{{ route('admin.our-processes.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.our-processes.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 11l3 3L22 4"></path>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <span>Our Process</span>
                </a>
                <!-- Counters -->
                <a
                    href="{{ route('admin.counters.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.counters.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 19V9"></path>
                        <path d="M10 19V5"></path>
                        <path d="M16 19v-7"></path>
                        <path d="M22 19V3"></path>
                    </svg>
                    <span>Counters</span>
                </a>
            </div>
        </div>
        <!-- Travel Support -->
        <a
            href="{{ route('admin.travel-support.index') }}"
            class="nav-item {{ request()->routeIs('admin.travel-support.*') ? 'active' : '' }}"
        >
            <svg
                class="menu-icon"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M12 21s-6-5.33-6-11a6 6 0 1 1 12 0 c0 5.67-6 11-6 11z"></path>
                <circle cx="12" cy="10" r="2"></circle>
            </svg>
            <span>Travel Support</span>
        </a>

        <!-- Why Choose Us -->
        <a
            href="{{ route('admin.why-choose-sections.index') }}"
            class="nav-item {{ request()->routeIs('admin.why-choose-sections.*') ? 'active' : '' }}"
        >
            <svg
                class="menu-icon"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M12 2l3.09 6.26L22 9.27 l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27 l6.91-1.01L12 2z"></path>
            </svg>
            <span>Why Choose Us</span>
        </a>

        <!-- Testimonials -->
        <a
            href="{{ route('admin.testimonials.index') }}"
            class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}"
        >
            <svg
                class="menu-icon"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M21 15a4 4 0 0 1-4 4H8 l-5 3V7a4 4 0 0 1 4-4h10 a4 4 0 0 1 4 4z"></path>
                <path d="M8 9h8"></path>
                <path d="M8 13h5"></path>
            </svg>
            <span>Testimonials</span>
        </a>
        <!-- Tour Types -->
<a
    href="{{ route('admin.tour-types.index') }}"
    class="nav-item {{ request()->routeIs('admin.tour-types.*') ? 'active' : '' }}"
>
    <svg
        class="menu-icon"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <!-- Suitcase -->
        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        <rect x="3" y="7" width="18" height="13" rx="2"></rect>
        <path d="M3 12h18"></path>
        <path d="M12 12v3"></path>
    </svg>

    <span>Tour Types</span>
</a>
<a
    href="{{ route('admin.tours.index') }}"
    class="nav-item {{ request()->routeIs('admin.tours.*') ? 'active' : '' }}"
>
    <svg
        class="menu-icon"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <path
            d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1 1 18 0z"
        ></path>

        <circle
            cx="12"
            cy="10"
            r="3"
        ></circle>
    </svg>

    <span>Tours</span>
</a>
        <!-- Blog Management Dropdown -->
        <div class="nav-dropdown-wrapper {{ request()->routeIs('admin.categories.*', 'admin.authors.*', 'admin.blogs.*') ? 'open' : '' }}">
            <button
                type="button"
                class="nav-dropdown-toggle nav-item {{ request()->routeIs('admin.categories.*', 'admin.authors.*', 'admin.blogs.*') ? 'active' : '' }}"
                aria-expanded="{{ request()->routeIs('admin.categories.*', 'admin.authors.*', 'admin.blogs.*') ? 'true' : 'false' }}"
            >
                <svg
                    class="menu-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4 a2 2 0 0 1-2-2V6 a2 2 0 0 1 2-2z"></path>
                    <path d="M16 8h2"></path>
                    <path d="M16 12h2"></path>
                    <path d="M16 16h2"></path>
                    <path d="M6 8h6v8H6z"></path>
                </svg>
                <span>Blog Management</span>
                <svg
                    class="chevron-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="nav-dropdown-menu">
                <!-- Categories -->
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M22 19a2 2 0 0 1-2 2H4 a2 2 0 0 1-2-2V5 a2 2 0 0 1 2-2h5l2 3h9 a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Categories</span>
                </a>
                <!-- Authors -->
                <a
                    href="{{ route('admin.authors.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8 a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Authors</span>
                </a>
                <!-- Blogs -->
                <a
                    href="{{ route('admin.blogs.index') }}"
                    class="nav-dropdown-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}"
                >
                    <svg
                        class="submenu-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M14 2H6a2 2 0 0 0-2 2v16 a2 2 0 0 0 2 2h12 a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    <span>Blogs</span>
                </a>
            </div>
        </div>

    </nav>

    <!-- Logout -->
    <form
        method="POST"
        action="{{ route('admin.logout') }}"
        class="logout-form"
    >
        @csrf
        <button
            type="submit"
            class="logout-button"
        >
            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M9 21H5a2 2 0 0 1-2-2V5 a2 2 0 0 1 2-2h4"></path>
                <path d="M16 17l5-5-5-5"></path>
                <path d="M21 12H9"></path>
            </svg>
            <span>Logout</span>
        </button>
    </form>
</aside>
