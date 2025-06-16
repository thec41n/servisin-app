@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
    <header class="content-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle-btn" id="sidebar-toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h3 mb-0">Pengaturan Website</h1>
        </div>
    </header>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="website_name" class="form-label">Nama Website</label>
                            <input type="text" id="website_name" name="website_name"
                                class="form-control @error('website_name') is-invalid @enderror"
                                value="{{ old('website_name', $setting->website_name ?? '') }}" />
                            @error('website_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Kontak</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $setting->email ?? '') }}" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor WhatsApp</label>
                            <input type="tel" id="phone_number" name="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number', $setting->phone_number ?? '') }}" />
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="4">{{ old('address', $setting->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="social_links[facebook]" class="form-label">Link Facebook</label>
                            <input type="url" id="facebook-link" name="social_links[facebook]"
                                class="form-control @error('social_links.facebook') is-invalid @enderror"
                                value="{{ old('social_links.facebook', $setting->social_links['facebook'] ?? '') }}" />
                            @error('social_links.facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="social_links[instagram]" class="form-label">Link Instagram</label>
                            <input type="url" id="instagram-link" name="social_links[instagram]"
                                class="form-control @error('social_links.instagram') is-invalid @enderror"
                                value="{{ old('social_links.instagram', $setting->social_links['instagram'] ?? '') }}" />
                            @error('social_links.instagram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="social_links[twitter]" class="form-label">Link Twitter/X</label>
                            <input type="url" id="twitter-link" name="social_links[twitter]"
                                class="form-control @error('social_links.twitter') is-invalid @enderror"
                                value="{{ old('social_links.twitter', $setting->social_links['twitter'] ?? '') }}" />
                            @error('social_links.twitter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="logoInput" class="form-label">Logo Website</label>

                            <input type="file" name="logo" id="logoInput"
                                class="form-control @error('logo') is-invalid @enderror" style="display: none;" />
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="file-upload-wrapper text-center"
                                onclick="document.getElementById('logoInput').click();"
                                style="cursor: pointer; border: 2px dashed #ddd; padding: 1rem;">
                                <div id="logoPreviewContainer">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#logoModal"
                                        data-src="{{ $setting->logo_url }}">
                                        <img src="{{ $setting->logo_url }}" alt="Logo saat ini" class="img-thumbnail"
                                            width="150" id="logoPreview">
                                    </a>
                                    <p class="mb-0 small mt-2 text-muted">Klik untuk mengubah logo</p>
                                </div>
                            </div>

                            <button type="button" id="removeLogoBtn"
                                class="btn btn-sm btn-outline-danger mt-2 d-none">Batal & kembalikan ke logo awal</button>
                        </div>
                    </div>
                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const logoInput = $('#logoInput');
            const logoPreview = $('#logoPreview');
            const removeLogoBtn = $('#removeLogoBtn');

            const originalLogoSrc = logoPreview.attr('src');

            logoInput.on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.attr('src', e.target.result);
                        removeLogoBtn.removeClass('d-none');
                    }
                    reader.readAsDataURL(file);
                }
            });

            removeLogoBtn.on('click', function() {
                logoInput.val('');
                logoPreview.attr('src', originalLogoSrc);
                $(this).addClass('d-none');
            });

            const logoModal = $('#logoModal');
            const modalLogoImage = $('#modalLogoImage');

            logoModal.on('show.bs.modal', function(event) {
                const triggerElement = $(event.relatedTarget);
                const imageSrc = triggerElement.data('src');
                modalLogoImage.attr('src', imageSrc);
            });
        });
    </script>
@endpush
