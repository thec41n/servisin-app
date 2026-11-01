@extends('layouts.app')

@section('title', 'Formulir Pemesanan: ' . $service->name)

@section('content')
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
                            @if ($service->image_url)
                                <img src="{{ $service->image_url }}" alt="" class="summary-item-img">
                            @endif
                            <div class="summary-item-info">
                                <h4>{{ $service->name }}</h4>
                                <p class="mb-0">Mulai dari Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <p class="fw-semibold mb-3">Setelah Anda mengirim:</p>
                        <ul class="summary-features list-unstyled mb-0">
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i>Anda langsung mendapat kode pelacakan dan e-receipt.</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i>Teknisi kami mengecek perangkat dan mengonfirmasi biaya akhir.</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i>Progres servis bisa dipantau kapan saja di halaman Lacak.</li>
                        </ul>
                    </aside>
                </div>

                <div class="col-lg-7">
                    <a href="{{ route('services.show_public', $service) }}" class="back-link">
                        <i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Kembali ke detail layanan
                    </a>
                    <form action="{{ route('orders.store') }}" method="POST" class="order-form" id="orderForm"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">

                        <h2>Lengkapi Data Diri & Detail Barang</h2>
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3" role="alert">
                                Ada isian yang perlu diperbaiki. Silakan cek kolom yang ditandai merah.
                                @error('service_id')
                                    <div class="mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="name" name="name" autocomplete="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" id="email" name="email" autocomplete="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="contoh@email.com" required />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor WhatsApp</label>
                            <input type="tel" id="phone_number" name="phone_number" autocomplete="tel" inputmode="tel"
                                class="form-control form-control-lg @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number') }}" placeholder="081234567890" required />
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="item_detail" class="form-label">Detail Barang & Kerusakan</label>
                            <textarea id="item_detail" name="item_detail" rows="4" maxlength="2000"
                                class="form-control form-control-lg @error('item_detail') is-invalid @enderror"
                                placeholder="Contoh: iPhone 13 Pro, layar retak di pojok kanan atas setelah jatuh." required>{{ old('item_detail') }}</textarea>
                            @error('item_detail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="orderImageInput" class="form-label">Unggah Foto Barang (Opsional)</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="image" class="form-control" id="orderImageInput"
                                    accept="image/jpeg,image/png" />
                                <div class="file-upload-default">
                                    <i class="fas fa-cloud-upload-alt me-2"></i>
                                    <span>Klik untuk memilih file...</span>
                                    <small>Format JPG atau PNG, maksimal 5MB</small>
                                </div>
                                <div class="file-upload-preview d-none">
                                    <img src="" alt="Preview" />
                                    <button type="button" class="btn-close remove-preview-btn"
                                        aria-label="Hapus foto"></button>
                                </div>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="orderSubmit">
                                Kirim Permintaan Servis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('#orderImageInput');
            const previewContainer = document.querySelector('.file-upload-preview');
            const defaultTextContainer = document.querySelector('.file-upload-default');
            const previewImage = previewContainer.querySelector('img');
            const removeBtn = previewContainer.querySelector('.remove-preview-btn');
            const fileTextSpan = defaultTextContainer.querySelector('span');

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        fileTextSpan.textContent = file.name;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.setAttribute('src', e.target.result);
                            previewContainer.classList.remove('d-none');
                            defaultTextContainer.classList.add('d-none');
                        }
                        reader.readAsDataURL(file);
                    }
                });

                removeBtn.addEventListener('click', function() {
                    fileInput.value = "";
                    previewContainer.classList.add('d-none');
                    defaultTextContainer.classList.remove('d-none');
                    fileTextSpan.textContent = 'Klik untuk memilih file...';
                });
            }

            const submitButton = document.querySelector('#orderSubmit');
            const submitLabel = submitButton.textContent;

            document.querySelector('#orderForm').addEventListener('submit', function() {
                submitButton.disabled = true;
                submitButton.textContent = 'Mengirim...';
            });

            // The back button may restore this page from cache with the button still disabled.
            window.addEventListener('pageshow', function() {
                submitButton.disabled = false;
                submitButton.textContent = submitLabel;
            });
        });
    </script>
@endpush
