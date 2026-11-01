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
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('services.index_public') }}" class="btn btn-primary btn-lg">Lihat Semua Layanan</a>
                        <a href="{{ route('track.show') }}" class="btn btn-secondary btn-lg w-auto">Lacak Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="steps-section">
        <div class="container">
            <h2 class="section-title text-center">Cara Kerja Servis Kami</h2>
            <div class="row g-4">
                @foreach ([
                    ['fas fa-magnifying-glass', 'Pilih Layanan', 'Cari layanan yang sesuai dengan kendala perangkat Anda.'],
                    ['fas fa-file-pen', 'Isi Formulir', 'Ceritakan kerusakannya, lalu simpan kode pelacakan yang Anda terima.'],
                    ['fas fa-clipboard-check', 'Lacak Status', 'Pantau progres servis kapan saja dengan kode pelacakan tersebut.'],
                ] as [$icon, $title, $text])
                    <div class="col-md-4">
                        <div class="step-card h-100">
                            <span class="step-number">{{ $loop->iteration }}</span>
                            <i class="{{ $icon }} step-icon" aria-hidden="true"></i>
                            <h3>{{ $title }}</h3>
                            <p class="mb-0">{{ $text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="services-section" id="layanan">
        <div class="container">
            <h2 class="section-title text-center">Layanan Populer Kami</h2>
            <div class="row g-4 justify-content-center">

                @forelse ($services as $service)
                    <div class="col-sm-6 col-lg-4">
                        <x-service-card :service="$service" />
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            Saat ini belum ada layanan yang tersedia.
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($services->isNotEmpty())
                <div class="text-center mt-5">
                    <a href="{{ route('services.index_public') }}" class="btn btn-primary">Lihat Semua Layanan</a>
                </div>
            @endif
        </div>
    </section>

    @if ($reviews->isNotEmpty())
        <section class="reviews-section">
            <div class="container">
                <h2 class="section-title text-center">Apa Kata Pelanggan</h2>
                <div class="review-carousel" role="region" aria-label="Ulasan pelanggan">
                    <div class="review-track">
                        @foreach ($reviews as $review)
                            <div class="review-slide">
                                <x-review-card :review="$review" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.review-carousel').forEach((carousel) => {
            const track = carousel.querySelector('.review-track');
            const slides = [...track.children];
            const cruiseSpeed = 40;
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let velocity = reduceMotion ? 0 : cruiseSpeed;
            let loopWidth = 0;
            let offset = 0;
            let width = 0;
            let paused = false;
            let drag = null;
            let lastTime = null;

            const setup = () => {
                if (carousel.clientWidth === width) return;
                width = carousel.clientWidth;
                track.querySelectorAll('[data-clone]').forEach((clone) => clone.remove());
                track.style.transform = '';
                loopWidth = 0;

                const overflowing = track.scrollWidth > carousel.clientWidth;
                carousel.classList.toggle('is-static', !overflowing);
                if (!overflowing) return;

                // One cloned set behind the originals lets the strip wrap around without a visible jump.
                slides.forEach((slide) => {
                    const clone = slide.cloneNode(true);
                    clone.dataset.clone = '';
                    clone.setAttribute('aria-hidden', 'true');
                    track.append(clone);
                });
                loopWidth = track.children[slides.length].offsetLeft - slides[0].offsetLeft;
            };

            const tick = (time) => {
                const elapsed = lastTime === null ? 0 : Math.min(time - lastTime, 50);
                lastTime = time;

                if (loopWidth) {
                    if (!drag) {
                        // Ease toward the target speed so pauses, resumes and flings glide instead of snapping.
                        const targetSpeed = paused || reduceMotion ? 0 : cruiseSpeed;
                        velocity += (targetSpeed - velocity) * (1 - Math.exp(-elapsed / 500));
                        offset += velocity * elapsed / 1000;
                    }
                    offset = ((offset % loopWidth) + loopWidth) % loopWidth;
                    track.style.transform = `translate3d(${-offset}px, 0, 0)`;
                }

                requestAnimationFrame(tick);
            };

            carousel.addEventListener('mouseenter', () => paused = true);
            carousel.addEventListener('mouseleave', () => paused = false);

            track.addEventListener('pointerdown', (event) => {
                if (!loopWidth) return;
                drag = { x: event.clientX, offset, lastX: event.clientX, lastTime: event.timeStamp, speed: 0 };
                track.classList.add('is-dragging');
                track.setPointerCapture(event.pointerId);
            });

            track.addEventListener('pointermove', (event) => {
                if (!drag) return;
                const elapsed = event.timeStamp - drag.lastTime;
                if (elapsed > 0) drag.speed = (drag.lastX - event.clientX) / elapsed * 1000;
                drag.lastX = event.clientX;
                drag.lastTime = event.timeStamp;
                offset = drag.offset - (event.clientX - drag.x);
            });

            ['pointerup', 'pointercancel'].forEach((name) => track.addEventListener(name, (event) => {
                if (!drag) return;
                const stillMoving = event.timeStamp - drag.lastTime < 100;
                velocity = stillMoving ? Math.max(-2000, Math.min(2000, drag.speed)) : 0;
                drag = null;
                track.classList.remove('is-dragging');
            }));

            window.addEventListener('resize', setup);
            setup();
            requestAnimationFrame(tick);
        });
    </script>

    @if (session('order_success') && session('receipt_url'))
        <script>
            Swal.fire({
                title: 'Pesanan Berhasil!',
                html: @json(session('order_success')),
                icon: 'success',
                confirmButtonColor: '#8e1616',
                confirmButtonText: 'Download E-Receipt',
                preConfirm: () => {
                    window.location.href = @json(session('receipt_url'));
                }
            });
        </script>
    @endif
@endpush
