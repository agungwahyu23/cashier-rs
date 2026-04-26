<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    <title>{{ config('app.name', 'Aplikasi E-Commerce') }}</title>
    <link rel="icon" href="{{ asset('assets/images/logo/logo-rs.webp') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.bootstrap5.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"></script> --}}
    {{-- <script src="https://cdn.datatables.net/2.3.6/css/dataTables.bootstrap5.css"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @stack('stylesheet')
</head>

<body class="font-sans antialiased">
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <div class="top-header">
            <div class="header-left">
                <button class="menu-toggle-btn" onclick="toggleSidebarDesktop()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-text-indent-right" viewBox="0 0 16 16">
                        <path
                            d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm10.646 2.146a.5.5 0 0 1 .708.708L11.707 8l1.647 1.646a.5.5 0 0 1-.708.708l-2-2a.5.5 0 0 1 0-.708l2-2zM2 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </button>
                <button class="mobile-menu-toggle" onclick="toggleSidebarMobile()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-text-indent-right" viewBox="0 0 16 16">
                        <path
                            d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm10.646 2.146a.5.5 0 0 1 .708.708L11.707 8l1.647 1.646a.5.5 0 0 1-.708.708l-2-2a.5.5 0 0 1 0-.708l2-2zM2 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </button>
            </div>
            <div class="header-icons">
                <button id="themeToggle" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-moon"></i>
                </button>
                <div class="header-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">2</span>
                </div>
                <div class="user-avatar" data-bs-toggle="dropdown" aria-expanded="false"></div>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Profil</a></li>
                    <li><a class="dropdown-item" href="#">Ubah Passwoed</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('signout') }}">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="container-fluid p-4">

            @yield('content')

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/libs/flatpickr/dist/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    {{-- <script src="../../../assets/libs/quill/dist/quill.js"></script> --}}

    <script>
        // Toggle sidebar untuk desktop (collapse/expand)
        function toggleSidebarDesktop() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        // Toggle sidebar untuk mobile (show/hide)
        function toggleSidebarMobile() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Handle dropdown menu items
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                this.classList.toggle('collapsed');
            });
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');

            if (window.innerWidth <= 992) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Prevent closing when clicking inside sidebar
        document.getElementById('sidebar').addEventListener('click', function (e) {
            e.stopPropagation();
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const html = document.documentElement;
            const toggle = document.getElementById("themeToggle");
            const icon = toggle.querySelector("i");

            // Function to set theme
            function setTheme(theme) {
                html.setAttribute("data-bs-theme", theme);
                localStorage.setItem("theme", theme);
                
                // Update icon
                if (theme === "dark") {
                    icon.classList.remove("bi-moon");
                    icon.classList.add("bi-sun");
                    toggle.classList.remove("btn-outline-secondary");
                    toggle.classList.add("btn-outline-warning");
                } else {
                    icon.classList.remove("bi-sun");
                    icon.classList.add("bi-moon");
                    toggle.classList.remove("btn-outline-warning");
                    toggle.classList.add("btn-outline-secondary");
                }
            }

            // ambil theme dari localStorage
            let savedTheme = localStorage.getItem("theme") || "light";
            setTheme(savedTheme);

            toggle.addEventListener("click", function () {
                let currentTheme = html.getAttribute("data-bs-theme");
                let newTheme = currentTheme === "light" ? "dark" : "light";
                setTheme(newTheme);
            });
        });
    </script>


    @stack('scripts')
</body>

</html>
