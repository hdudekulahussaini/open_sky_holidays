<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard') | Open Sky Holidays</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="{{ asset('assets/admin/css/admin.css') }}?v={{ filemtime(public_path('assets/admin/css/admin.css')) }}">

    @stack('styles')
</head>

<body>

    <div class="admin-layout">

        @include('admin.layouts.sidebar')

        {{-- Mobile dark overlay --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <main class="main-content">

            <header class="topbar">

                <div class="topbar-left">

                    {{-- Mobile sidebar button --}}
                    <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Open sidebar"
                        aria-expanded="false" aria-controls="adminSidebar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="4" y1="6" x2="20" y2="6"></line>
                            <line x1="4" y1="12" x2="20" y2="12"></line>
                            <line x1="4" y1="18" x2="20" y2="18"></line>
                        </svg>
                    </button>

                    <h1>
                        @yield('page-title', 'Dashboard')
                    </h1>

                </div>

                <div class="admin-profile">

                    <div class="admin-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="admin-name">
                        {{ auth()->user()->name }}
                    </div>

                </div>

            </header>

            <div class="page-content">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')

            </div>

        </main>

    </div>

    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
    <script src="{{ asset('assets/admin/js/image-preview.js') }}"></script>
    @stack('scripts')

    <script>
    (function() {
        function initDropdowns() {
            // Dropdown toggle function
            document.querySelectorAll('.nav-dropdown-toggle').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const wrapper = this.closest('.nav-dropdown-wrapper');
                    if (wrapper) {
                        wrapper.classList.toggle('open');
                    }
                });
            });

            // Mobile sidebar toggle script
            const sidebarToggle = document.getElementById("sidebarToggle");
            const sidebarOverlay = document.getElementById("sidebarOverlay");

            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", function () {
                    document.body.classList.toggle("sidebar-open");
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener("click", function () {
                    document.body.classList.remove("sidebar-open");
                });
            }
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initDropdowns);
        } else {
            initDropdowns();
        }
    })();
    </script>
</body>

</html>
