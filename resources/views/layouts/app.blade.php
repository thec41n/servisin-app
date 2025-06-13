<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', $appSetting->website_name ?? 'Servis.in')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
    @stack('styles')
</head>

<body>
    <header class="header sticky-top">
        <nav class="navbar navbar-expand-lg container">
            <div class="container-fluid">
                <a class="navbar-brand logo"
                    href="{{ route('home') }}">{{ $appSetting->website_name ?? 'Servis.in' }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                href="{{ route('home') }}">Beranda</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('services*') ? 'active' : '' }}"
                                href="{{ route('services.index_public') }}">Layanan</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('track.show') ? 'active' : '' }}"
                                href="{{ route('track.show') }}">Lacak Status</a>
                        </li>
                        <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                            <a href="{{ route('login') }}" class="btn btn-primary">Login Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer text-center">
        <div class="container">
            <a href="{{ route('home') }}" class="logo">{{ $appSetting->website_name ?? 'Servis.in' }}</a>
            <p class="mt-2">
                Copyright © {{ date('Y') }} {{ $appSetting->website_name ?? 'Servis.in' }}. Dibuat dengan cinta
                dan
                kopi.
            </p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/script.js') }}"></script>
    @stack('scripts')
</body>

</html>
