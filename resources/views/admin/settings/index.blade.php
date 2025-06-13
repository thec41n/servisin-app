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
                            <input type="text" id="website_name" name="website_name" class="form-control"
                                value="{{ $setting->website_name ?? '' }}" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Kontak</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ $setting->email ?? '' }}" />
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor WhatsApp</label>
                            <input type="tel" id="phone_number" name="phone_number" class="form-control"
                                value="{{ $setting->phone_number ?? '' }}" />
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea id="address" name="address" class="form-control" rows="4">{{ $setting->address ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="social_links[facebook]" class="form-label">Link Facebook</label>
                            <input type="url" id="facebook-link" name="social_links[facebook]" class="form-control"
                                value="{{ $setting->social_links['facebook'] ?? '' }}" />
                        </div>
                        <div class="mb-3">
                            <label for="social_links[instagram]" class="form-label">Link Instagram</label>
                            <input type="url" id="instagram-link" name="social_links[instagram]" class="form-control"
                                value="{{ $setting->social_links['instagram'] ?? '' }}" />
                        </div>
                        <div class="mb-3">
                            <label for="social_links[twitter]" class="form-label">Link Twitter/X</label>
                            <input type="url" id="twitter-link" name="social_links[twitter]" class="form-control"
                                value="{{ $setting->social_links['twitter'] ?? '' }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Logo Website</label>
                            <input type="file" name="logo" class="form-control" />
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah logo.</small>

                            @if ($setting->logo_url)
                                <div class="mt-2">
                                    <p class="mb-1 small">Logo saat ini:</p>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#logoModal"
                                        data-src="{{ $setting->logo_url }}">
                                        <img src="{{ $setting->logo_url }}" alt="Logo saat ini" class="img-thumbnail"
                                            width="150">
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="logoModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="logoModalLabel">Logo Website</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="" id="modalLogoImage" class="img-fluid" alt="Logo Website">
                                    </div>
                                </div>
                            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const logoModal = document.getElementById('logoModal');
            if (logoModal) {
                const modalLogoImage = document.getElementById('modalLogoImage');

                logoModal.addEventListener('show.bs.modal', function(event) {
                    const triggerElement = event.relatedTarget;
                    const imageSrc = triggerElement.getAttribute('data-src');
                    modalLogoImage.setAttribute('src', imageSrc);
                });
            }
        });
    </script>
@endpush
