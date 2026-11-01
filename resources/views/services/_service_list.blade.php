<div class="row g-4">
    @forelse ($services as $service)
        <div class="col-sm-6 col-lg-4">
            <x-service-card :service="$service" />
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