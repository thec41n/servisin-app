@extends('layouts.app')

@section('title', 'Pesanan Berhasil Dikirim')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6">
                    <div class="success-card text-center">
                        <div class="success-icon" aria-hidden="true"><i class="fas fa-check"></i></div>
                        <h1>Pesanan Berhasil Dikirim</h1>
                        <p class="text-muted">
                            Terima kasih! Permintaan servis <strong>{{ $order->service->name }}</strong> sudah kami terima.
                            Simpan kode di bawah ini untuk melacak status servis Anda.
                        </p>

                        <div class="tracking-code-box">
                            <span class="tracking-code-label">Kode Pelacakan</span>
                            <strong class="tracking-code" id="trackingCode">{{ $order->tracking_code }}</strong>
                            <button type="button" class="btn btn-secondary btn-sm w-auto" id="copyTrackingCode">
                                <i class="far fa-copy me-2" aria-hidden="true"></i><span aria-live="polite">Salin Kode</span>
                            </button>
                        </div>

                        <div class="d-grid d-sm-flex justify-content-center gap-2">
                            <a href="{{ route('orders.receipt', $order->tracking_code) }}" class="btn btn-primary">
                                <i class="fas fa-download me-2" aria-hidden="true"></i>Download E-Receipt
                            </a>
                            <a href="{{ route('track.show', ['code' => $order->tracking_code]) }}"
                                class="btn btn-secondary w-auto">
                                <i class="fas fa-magnifying-glass me-2" aria-hidden="true"></i>Lacak Pesanan
                            </a>
                        </div>

                        <a href="{{ route('home') }}" class="back-link mt-4 mb-0">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.querySelector('#copyTrackingCode').addEventListener('click', function() {
            const label = this.querySelector('span');

            navigator.clipboard.writeText(document.querySelector('#trackingCode').textContent.trim())
                .then(() => label.textContent = 'Tersalin!')
                .catch(() => label.textContent = 'Gagal menyalin, salin manual ya')
                .finally(() => setTimeout(() => label.textContent = 'Salin Kode', 2500));
        });
    </script>
@endpush
