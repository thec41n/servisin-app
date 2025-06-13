<div class="row g-4">
    @forelse ($services as $service)
        <div class="col-md-6 col-lg-4">
            <div class="card service-card h-100">
                <img src="{{ $service->image_url }}" class="service-card-img" alt="{{ $service->name }}">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title">{{ $service->name }}</h3>
                    <p class="service-card-price">Mulai dari Rp
                        {{ number_format($service->price, 0, ',', '.') }}</p>
                    <a href="{{ route('services.show_public', $service->id) }}" class="btn btn-secondary mt-auto">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <h4>Oops!</h4>
                <p class="mb-0">Layanan yang Anda cari tidak ditemukan.</p>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-5 d-flex justify-content-center">
    {{ $services->appends(request()->query())->links() }}
</div>