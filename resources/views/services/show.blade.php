@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <main>
        <section class="detail-section py-5">
            <div class="container">
                <div class="row g-4 g-lg-5">
                    <div class="col-lg-6">
                        <div class="detail-gallery">
                            <div class="main-image-bs mb-3">
                                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover; border-radius: 15px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="detail-info">
                            <h1>{{ $service->name }}</h1>
                            <div class="price">Mulai dari Rp {{ number_format($service->price, 0, ',', '.') }}</div>

                            <div class="full-description">
                                {!! $service->description !!}
                            </div>

                            <div class="d-grid mt-4">
                                <a href="{{ route('orders.create', $service->id) }}" class="btn btn-primary btn-lg">
                                    Pesan Layanan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
