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
                <a class="navbar-brand logo d-flex align-items-center gap-2" href="{{ route('home') }}">
                    @if ($appSetting->logo_url)
                        <img src="{{ $appSetting->logo_url }}" alt="" height="36">
                    @endif
                    {{ $appSetting->website_name ?? 'Servis.in' }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Buka menu navigasi">
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
                            <a class="nav-link {{ request()->routeIs('track.*') ? 'active' : '' }}"
                                href="{{ route('track.show') }}">Lacak Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact.show') ? 'active' : '' }}"
                                href="{{ route('contact.show') }}">Kontak Kami</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-5">
                    <a href="{{ route('home') }}" class="logo">{{ $appSetting->website_name ?? 'Servis.in' }}</a>
                    <p class="mt-2 mb-0">Servis laptop, PC, smartphone, dan tablet oleh teknisi berpengalaman.</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="footer-title">Navigasi</h2>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('services.index_public') }}">Layanan</a></li>
                        <li><a href="{{ route('track.show') }}">Lacak Status</a></li>
                        <li><a href="{{ route('contact.show') }}">Kontak Kami</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <h2 class="footer-title">Hubungi Kami</h2>
                    <ul class="list-unstyled footer-links">
                        @if ($whatsappUrl = whatsapp_url($appSetting->phone_number))
                            <li>
                                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-whatsapp me-2" aria-hidden="true"></i>{{ $appSetting->phone_number }}
                                </a>
                            </li>
                        @endif
                        @if ($appSetting->email)
                            <li>
                                <a href="mailto:{{ $appSetting->email }}">
                                    <i class="fas fa-envelope me-2" aria-hidden="true"></i>{{ $appSetting->email }}
                                </a>
                            </li>
                        @endif
                        @if ($appSetting->address)
                            <li><i class="fas fa-map-marker-alt me-2" aria-hidden="true"></i>{{ $appSetting->address }}</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="footer-bottom d-flex flex-column flex-sm-row justify-content-between gap-2">
                <p class="mb-0">© {{ date('Y') }} {{ $appSetting->website_name ?? 'Servis.in' }}. Dibuat dengan cinta dan kopi.</p>
                <a href="{{ route('login') }}">Login Admin</a>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/script.js') }}"></script>
    @stack('scripts')
</body>

</html>
