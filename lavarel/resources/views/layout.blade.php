<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PureMeal - Twoja zdrowa dieta')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    
    <!-- GLOBALNE STYLE PAGINACJI -->
    <style>
        /* === PAGINACJA - UNIWERSALNE STYLE === */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 40px 0;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
        }

        nav[aria-label="pagination"] {
            margin: 0 !important;
        }

        .pagination {
            display: flex !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
            background: white !important;
            border: 1px solid #e5e7eb !important;
        }

        .pagination .page-item {
            margin: 0 !important;
            border: none !important;
        }

        .pagination .page-link {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 12px 16px !important;
            color: #374151 !important;
            background-color: #fff !important;
            border: 1px solid #e5e7eb !important;
            border-left: none !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            min-width: 44px !important;
            height: 44px !important;
            font-weight: 500 !important;
            font-size: 0.9rem !important;
            position: relative !important;
        }

        .pagination .page-item:first-child .page-link {
            border-left: 1px solid #e5e7eb !important;
            border-top-left-radius: 12px !important;
            border-bottom-left-radius: 12px !important;
        }

        .pagination .page-item:last-child .page-link {
            border-top-right-radius: 12px !important;
            border-bottom-right-radius: 12px !important;
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
            color: white !important;
            border-color: #3b82f6 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4) !important;
            z-index: 2 !important;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
            border-color: #3b82f6 !important;
            color: white !important;
            font-weight: 600 !important;
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4) !important;
            transform: translateY(-1px) !important;
            z-index: 1 !important;
        }

        .pagination .page-item.active .page-link:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
        }

        .pagination .page-item.disabled .page-link {
            color: #9ca3af !important;
            background-color: #f9fafb !important;
            border-color: #e5e7eb !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
        }

        .pagination .page-item.disabled .page-link:hover {
            transform: none !important;
            box-shadow: none !important;
            background-color: #f9fafb !important;
            color: #9ca3af !important;
            border-color: #e5e7eb !important;
        }

        /* Responsywność */
        @media (max-width: 768px) {
            .pagination-wrapper {
                margin: 20px 0;
                padding: 15px;
            }
            
            .pagination .page-link {
                padding: 8px 12px !important;
                font-size: 14px !important;
                min-width: 36px !important;
                height: 36px !important;
            }
            
            /* Ukryj środkowe numery na tablecie */
            .pagination .page-item:not(.active):not(:first-child):not(:last-child):not([aria-label*="Previous"]):not([aria-label*="Next"]) {
                display: none !important;
            }
        }

        @media (max-width: 576px) {
            .pagination {
                border-radius: 8px !important;
            }
            
            .pagination .page-link {
                padding: 6px 10px !important;
                font-size: 12px !important;
                min-width: 32px !important;
                height: 32px !important;
            }
            
            .pagination-wrapper {
                margin: 15px 0;
                padding: 10px;
            }
        }

        /* Specjalne style dla dashboardu */
        .dashboard .pagination-wrapper {
            background: transparent;
            border-radius: 0;
            padding: 30px 0;
            margin: 20px 0;
        }

        .dashboard .pagination {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }

        /* Animacje */
        .pagination .page-item {
            animation: fadeInUp 0.3s ease forwards;
        }

        .pagination .page-item:nth-child(1) { animation-delay: 0.05s; }
        .pagination .page-item:nth-child(2) { animation-delay: 0.1s; }
        .pagination .page-item:nth-child(3) { animation-delay: 0.15s; }
        .pagination .page-item:nth-child(4) { animation-delay: 0.2s; }
        .pagination .page-item:nth-child(5) { animation-delay: 0.25s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Override dla konfliktów */
        .pagination * {
            box-sizing: border-box !important;
        }
        
        :root {
            --primary-color: #333;
            --secondary-color: #fff;
            --accent-color: #f39c12;
            --background-color: #f5f5f5;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        body.fade-in {
            opacity: 1;
        }

        body.fade-out {
            opacity: 0;
        }

        main {
            flex: 1;
        }

        .navbar {
            background-color: var(--primary-color) !important;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: var(--secondary-color) !important;
            font-weight: 700;
            font-size: 1.8rem;
            text-transform: lowercase;
        }

        .navbar-nav .nav-link {
            color: var(--secondary-color) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--secondary-color);
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .notification-container {
            position: fixed;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: 90%;
            max-width: 500px;
        }

        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: slideInDown 0.5s ease;
        }

        .alert-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .alert-danger,
        .alert-error {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
        }

        .alert-warning {
            background: linear-gradient(135deg, #ffc107, #ff8c00);
            color: white;
        }

        .alert-info {
            background: linear-gradient(135deg, #17a2b8, #007bff);
            color: white;
        }

        @keyframes slideInDown {
            from {
                transform: translateX(-50%) translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }

            to {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
        }

        .footer {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem 0;
            text-align: center;
            margin-top: auto;
        }

        .footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                text-align: center;
                padding-top: 1rem;
            }

            .navbar-nav .nav-link {
                margin: 5px 0;
            }

            .notification-container {
                width: 95%;
                top: 60px;
            }
        }
        
    </style>
    
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">puremeal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dopasowanie') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cennik') }}">Cennik</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cog me-1"></i>Zarządzanie
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('menu.index') }}">Zarządzaj Menu</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">Zamówienia</a></li>
                                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Użytkownicy</a></li>
                                    <li><a class="dropdown-item" href="{{ route('diet-plans.index') }}">Plany Diet</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('menu.create') }}">Dodaj Menu</a></li>
                                    <li><a class="dropdown-item" href="{{ route('diet-plans.create') }}">Dodaj Dietę</a></li>
                                </ul>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart me-1"></i>Koszyk
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="user-avatar me-2">
                                @else
                                    <div class="avatar-placeholder me-2">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Mój Panel</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-1"></i>Wyloguj
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3 py-1">
                                <i class="fas fa-sign-in-alt me-1"></i>
                                Zaloguj się
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="notification-container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>{{ session('warning') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i>
                <div>{{ session('info') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 PureMeal. Wszystkie prawa zastrzeżone.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.body.classList.add("fade-in");
            AOS.init({
                duration: 1000,
                once: true
            });

            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.animation = 'fadeOut 0.5s forwards';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });

        document.querySelectorAll('a.nav-link:not(.dropdown-toggle), a.btn').forEach(link => {
            link.addEventListener("click", function (e) {
                const href = this.getAttribute("href");

                if (this.classList.contains('dropdown-toggle') || 
                    this.classList.contains('dropdown-item') ||
                    this.closest('.dropdown') ||
                    this.getAttribute('data-bs-toggle') === 'dropdown' ||
                    this.getAttribute('role') === 'button') {
                    return; 
                }

                if (this.tagName.toLowerCase() === 'button' && this.closest('form')) {
                    return; 
                }

                if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

                e.preventDefault();
                document.body.classList.remove("fade-in");
                document.body.classList.add("fade-out");

                setTimeout(() => {
                    window.location.href = href;
                }, 500);
            });
        });

        document.querySelectorAll('.dropdown-item').forEach(item => {
            if (item.tagName.toLowerCase() === 'a') {
                item.addEventListener("click", function (e) {
                    const href = this.getAttribute("href");
                    
                    if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

                    e.preventDefault();
                    document.body.classList.remove("fade-in");
                    document.body.classList.add("fade-out");

                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
                });
            }
        });
    </script>
</body>

</html>