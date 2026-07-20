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
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                        <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.enquiries.index') }}"
                    class="nav-item {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                        <path d="M3 7l9 6 9-6"></path>
                    </svg>

                    <span>Enquiries</span>
                </a>

                <!-- Tour Packages -->
                <a href="#" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18"></path>
                        <path d="M5 6l1 15h12l1-15"></path>
                        <path d="M9 6V4h6v2"></path>
                        <path d="M9 11h6"></path>
                    </svg>

                    <span>Tour Packages</span>
                </a>

                <!-- Destinations -->
                <a href="#" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>

                    <span>Destinations</span>
                </a>

                <!-- Services -->
                <a href="#" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="7" width="18" height="13" rx="2"></rect>
                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <path d="M3 12h18"></path>
                        <path d="M10 12v2h4v-2"></path>
                    </svg>

                    <span>Services</span>
                </a>

                <!-- Blogs -->
                <a href="#" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        <path d="M8 7h8"></path>
                        <path d="M8 11h6"></path>
                    </svg>

                    <span>Blogs</span>
                </a>

                <!-- Settings -->
                <a href="#" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>

                        <path
                            d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.05.05a2 2 0 1 1-2.83 2.83l-.05-.05a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V21a2 2 0 0 1-4 0v-.07a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.05.05a2 2 0 1 1-2.83-2.83l.05-.05A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.53-1H3a2 2 0 0 1 0-4h.07A1.7 1.7 0 0 0 4.6 9a1.7 1.7 0 0 0-.34-1.88l-.05-.05a2 2 0 1 1 2.83-2.83l.05.05A1.7 1.7 0 0 0 8.97 4.6 1.7 1.7 0 0 0 10 3.07V3a2 2 0 0 1 4 0v.07a1.7 1.7 0 0 0 1.03 1.53 1.7 1.7 0 0 0 1.88-.34l.05-.05a2 2 0 1 1 2.83 2.83l-.05.05A1.7 1.7 0 0 0 19.4 9a1.7 1.7 0 0 0 1.53 1H21a2 2 0 0 1 0 4h-.07A1.7 1.7 0 0 0 19.4 15z">
                        </path>
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