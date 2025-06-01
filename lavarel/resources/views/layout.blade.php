<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'PureMeal - Catering Dietetyczny')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @stack('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <style>
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

        footer {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            text-align: center;
            padding: 1rem 0;
        }

        /* Styl powiadomień */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            max-width: 350px;
        }

        .alert {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            animation: slideInRight 0.5s forwards;
        }

        .alert-success {
            border-left-color: #198754;
        }

        .alert-danger {
            border-left-color: #dc3545;
        }

        .alert-warning {
            border-left-color: #ffc107;
        }

        .alert-info {
            border-left-color: #0dcaf0;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">PureMeal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/cennik') }}">Cennik</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/dopasowanie') }}">Menu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/dostawa') }}">Dostawa</a>
        </li>
        @if(Auth::check())
            <li class="nav-item ms-lg-3 me-lg-2">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-warning btn-sm px-3 py-1">
                    <i class="fas fa-shopping-cart"></i>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <span class="badge bg-danger ms-1">{{ count(session('cart')) }}</span>
                    @endif
                </a>
            </li>
        @endif
        <li class="nav-item">
            @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm px-3 py-1 me-2">
                    <i class="fas fa-user"></i> Panel
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-1">
                        <i class="fas fa-sign-out-alt"></i> Wyloguj
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3 py-1">
                    Zaloguj
                </a>
            @endif
        </li>
    </ul>
</div>
        </div>
    </nav>

    <!-- Kontener powiadomień -->
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

    <main class="container my-5" data-aos="fade-up">
        @yield('content')
    </main>

    <footer>
        <p class="mb-0">&copy; 2025 PureMeal. Wszystkie prawa zastrzeżone.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        AOS.init({ once: true });

        document.addEventListener("DOMContentLoaded", () => {
            document.body.classList.add("fade-in");
            
            // Auto-hide notifications after 5 seconds
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

        document.querySelectorAll('a.nav-link, a.btn').forEach(link => {
            link.addEventListener("click", function (e) {
                const href = this.getAttribute("href");

                if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

                e.preventDefault();
                document.body.classList.remove("fade-in");
                document.body.classList.add("fade-out");

                setTimeout(() => {
                    window.location.href = href;
                }, 500);
            });
        });
    </script>
</body>

</html>