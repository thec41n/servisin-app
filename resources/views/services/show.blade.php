@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <section class="detail-section py-4 py-lg-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services.index_public') }}">Layanan</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('services.index_public', ['category' => $service->category]) }}">
                            {{ \App\Models\Service::CATEGORIES[$service->category] ?? 'Lainnya' }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $service->name }}</li>
                </ol>
            </nav>

            <div class="row g-4 g-lg-5">
                <div class="col-lg-6">
                    <div class="main-image-bs">
                        @if ($service->image_url)
                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}">
                        @else
                            <i class="fas fa-tools fa-3x" aria-hidden="true"></i>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="detail-info">
                        <h1>{{ $service->name }}</h1>
                        @if ($reviewsCount)
                            <a href="#ulasan" class="rating-summary">
                                <x-rating :value="$averageRating" />
                                <span>{{ number_format($averageRating, 1, ',', '.') }} ({{ $reviewsCount }} ulasan)</span>
                            </a>
                        @endif
                        <div class="price">Mulai dari Rp {{ number_format($service->price, 0, ',', '.') }}</div>

                        <div class="full-description">
                            {{-- Rich text written only by admins (routes behind can:admin). --}}
                            {!! $service->description !!}
                        </div>

                        <div class="d-grid d-sm-flex gap-2 mt-4">
                            <a href="{{ route('orders.create', $service) }}" class="btn btn-primary btn-lg flex-sm-fill">
                                Pesan Layanan Sekarang
                            </a>
                            @if ($whatsappUrl = whatsapp_url($appSetting->phone_number, "Halo, saya ingin bertanya tentang layanan {$service->name}."))
                                <a href="{{ $whatsappUrl }}" class="btn btn-secondary btn-lg flex-sm-fill w-auto"
                                    target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-whatsapp me-2" aria-hidden="true"></i>Tanya via WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($reviews->isNotEmpty())
        <section class="reviews-section pt-0" id="ulasan">
            <div class="container">
                <h2 class="section-title">Ulasan Pelanggan</h2>
                <div class="row g-4">
                    @foreach ($reviews as $review)
                        <div class="col-md-6 col-lg-4">
                            <x-review-card :review="$review" :show-service="false" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
