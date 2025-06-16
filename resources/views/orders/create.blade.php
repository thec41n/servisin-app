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
                            @if ($errors->any())
                                <div class="alert alert-danger mb-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
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
                                    <input type="file" name="image" class="form-control" id="orderImageInput" />
                                    <div class="file-upload-default">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>
                                        <span>Klik untuk memilih file...</span>
                                        <small>Maksimal Ukuran Gambar 5MB</small>
                                    </div>
                                    <div class="file-upload-preview d-none">
                                        <img src="" alt="Preview" />
                                        <button type="button" class="btn-close remove-preview-btn"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
        });
    </script>
@endpush
