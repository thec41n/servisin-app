@extends('layouts.app')

@section('title', 'Kontak Kami - ' . ($appSetting->website_name ?? ''))

@section('content')
    <section class="page-header text-center">
        <div class="container">
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu Anda. Jangan ragu untuk menghubungi kami melalui informasi di
                bawah ini.</p>
        </div>
    </section>

    <section class="contact-details py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="card shadow-sm border-0 p-4 p-md-5">
                        <div class="card-body">
                            <h2 class="mb-4 text-center">Informasi Kontak</h2>

                            <ul class="list-unstyled contact-info-list">
                                @if ($appSetting->website_name)
                                    <li>
                                        <i class="fas fa-globe me-2"></i>
                                        <strong>Nama Website:</strong> {{ $appSetting->website_name }}
                                    </li>
                                @endif
                                @if ($appSetting->email)
                                    <li>
                                        <i class="fas fa-envelope me-2"></i>
                                        <strong>Email:</strong> <a
                                            href="mailto:{{ $appSetting->email }}">{{ $appSetting->email }}</a>
                                    </li>
                                @endif
                                @if ($appSetting->phone_number)
                                    <li>
                                        <i class="fab fa-whatsapp me-2"></i>
                                        <strong>WhatsApp:</strong> <a
                                            href="{{ whatsapp_url($appSetting->phone_number) }}"
                                            target="_blank" rel="noopener noreferrer">{{ $appSetting->phone_number }}</a>
                                    </li>
                                @endif
                                @if ($appSetting->address)
                                    <li>
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <strong>Alamat:</strong> {{ $appSetting->address }}
                                    </li>
                                @endif
                            </ul>

                            @php
                                $socialLinks = array_filter($appSetting->social_links ?? []);
                                $socialNetworks = [
                                    'facebook' => ['fab fa-facebook-f', 'Facebook'],
                                    'instagram' => ['fab fa-instagram', 'Instagram'],
                                    'twitter' => ['fab fa-x-twitter', 'X / Twitter'],
                                ];
                            @endphp
                            @if ($socialLinks)
                                <hr class="my-4">
                                <h3 class="mb-3 text-center">Ikuti Kami</h3>
                                <div class="social-links">
                                    @foreach ($socialNetworks as $network => [$icon, $label])
                                        @isset($socialLinks[$network])
                                            <a href="{{ $socialLinks[$network] }}" class="social-btn" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="{{ $icon }}" aria-hidden="true"></i>
                                                <span>{{ $label }}</span>
                                            </a>
                                        @endisset
                                    @endforeach
                                </div>
                            @endif

                            @if (
                                !$appSetting->website_name &&
                                    !$appSetting->email &&
                                    !$appSetting->phone_number &&
                                    !$appSetting->address &&
                                    empty($appSetting->social_links))
                                <div class="alert alert-info text-center" role="alert">
                                    Informasi kontak belum diatur. Silakan atur di halaman pengaturan admin.
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
