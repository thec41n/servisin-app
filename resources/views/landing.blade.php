@extends('layouts.app')

@section('title', 'Solusi Cepat & Terpercaya untuk Servis Elektronik Anda')

@section('content')
    <section class="hero text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1>Solusi Cepat & Terpercaya untuk Servis Elektronik Anda</h1>
                    <p class="hero-subtitle">
                        Dari laptop yang rewel hingga smartphone yang pecah, tim ahli
                        kami siap membantu Anda kembali aktif dalam sekejap.
                    </p>
                    <a href="{{ route('services.index_public') }}" class="btn btn-primary btn-lg">Lihat Semua Layanan</a>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section" id="layanan">
        <div class="container">
            <h2 class="section-title text-center">Layanan Populer Kami</h2>
            <div class="row g-4 justify-content-center">

                @forelse ($services as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card service-card h-100">
                            <img src="{{ $service->image_url }}" class="service-card-img" alt="{{ $service->name }}">
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title">{{ $service->name }}</h3>
                                <p class="service-card-price">Mulai dari Rp
                                    {{ number_format($service->price, 0, ',', '.') }}</p>
                                <a href="{{ route('services.show_public', $service->id) }}"
                                    class="btn btn-secondary mt-auto">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            Saat ini belum ada layanan yang tersedia.
                        </div>
                    </div>
                @endforelse

            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $services->links() }}
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    @if (session('order_success') && session('receipt_url'))
        <script>
            Swal.fire({
                title: 'Pesanan Berhasil!',
                html: '{!! session('order_success') !!}',
                icon: 'success',
                confirmButtonColor: '#8e1616',
                confirmButtonText: 'Download E-Receipt',
                preConfirm: () => {
                    window.location.href = '{{ session('receipt_url') }}';
                }
            });
        </script>
    @endif
@endpush
