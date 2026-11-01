@props(['service'])

<div class="card service-card h-100">
    @if ($service->image_url)
        <img src="{{ $service->image_url }}" class="service-card-img" alt="{{ $service->name }}" loading="lazy">
    @else
        <div class="service-card-img" aria-hidden="true"><i class="fas fa-tools fa-2x"></i></div>
    @endif
    <div class="card-body d-flex flex-column">
        <span class="service-card-category">{{ \App\Models\Service::CATEGORIES[$service->category] ?? '' }}</span>
        <h3 class="card-title">{{ $service->name }}</h3>
        <p class="service-card-price">Mulai dari Rp {{ number_format($service->price, 0, ',', '.') }}</p>
        <a href="{{ route('services.show_public', $service) }}" class="btn btn-secondary mt-auto">Lihat Detail</a>
    </div>
</div>
