@extends('layouts.app')

@section('title', 'Formulir Pemesanan: ' . $service->name)

@section('content')
    <main>
        <section class="page-header text-center">
            <div class="container">
                <h1>Formulir Pemesanan</h1>
            </div>
        </section>

        <section class="form-section py-5">
            <div class="container">
                <div class="row g-4 g-lg-5">
                    <div class="col-lg-5">
                        <aside class="order-summary-bs">
                            <h3>Pesanan Anda</h3>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="summary-item-img">
                                <div class="summary-item-info">
                                    <h4>{{ $service->name }}</h4>
                                    <p class="mb-0">Mulai dari Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <ul class="summary-features list-unstyled">
                            </ul>
                        </aside>
                    </div>

                    <div class="col-lg-7">
                        <form action="{{ route('orders.store') }}" method="POST" class="order-form"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">

                            <h2>Lengkapi Data Diri & Detail Barang</h2>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="form-control form-control-lg"
                                    placeholder="Masukkan nama lengkap Anda" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg"
                                    placeholder="contoh@email.com" required />
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Nomor WhatsApp</label>
                                <input type="tel" id="phone_number" name="phone_number"
                                    class="form-control form-control-lg" placeholder="081234567890" required />
                            </div>
                            <div class="mb-3">
                                <label for="item_detail" class="form-label">Detail Barang & Kerusakan</label>
                                <textarea id="item_detail" name="item_detail" class="form-control form-control-lg"
                                    placeholder="Contoh: iPhone 13 Pro, layar retak di pojok kanan atas setelah jatuh." required rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Unggah Foto Barang (Opsional)</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="image" class="form-control" />
                                    <i class="fas fa-cloud-upload-alt me-2"></i>
                                    <span>Klik untuk memilih file...</span>
                                </div>
                                <small>Maksimal Ukuran Gambar 5MB</small>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Kirim Permintaan Servis
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('.file-upload-wrapper input[type="file"]');

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    const fileText = this.closest('.file-upload-wrapper').querySelector('span');

                    if (this.files && this.files.length > 0) {
                        fileText.textContent = this.files[0].name;
                    } else {
                        fileText.textContent = 'Klik untuk memilih file...';
                    }
                });
            }
        });
    </script>
@endpush
