@extends('layouts.admin')

@section('title', 'Manajemen Layanan')

@section('content')
    <header class="content-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle-btn" id="sidebar-toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h3 mb-0">Manajemen Layanan</h1>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal">
            <i class="fas fa-plus"></i> Tambah Layanan Baru
        </button>
    </header>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover data-table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                        data-src="{{ $service->image_url }}">
                                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" width="100"
                                            class="img-thumbnail">
                                    </a>
                                </td>
                                <td>{{ $service->name }}</td>
                                <td>
                                    {!! $service->short_description !!}
                                </td>
                                <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                <td>
                                    @if ($service->status)
                                        <span class="status-badge status-active">Aktif</span>
                                    @else
                                        <span class="status-badge status-inactive">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="#" class="btn btn-sm btn-edit" data-id="{{ $service->id }}"
                                        data-edit-url="{{ route('admin.services.edit', $service->id) }}"
                                        data-update-url="{{ route('admin.services.update', $service->id) }}"
                                        data-bs-toggle="modal" data-bs-target="#serviceModal">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin mau hapus layanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceModalLabel">
                        Tambah Layanan Baru
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="service-form" action="{{ route('admin.services.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Layanan</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="text" id="price" name="price"
                                class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}"
                                onkeyup="formatRupiah(this)" required data-raw-price="" /> @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Layanan</label>
                            <input type="file" id="image" name="image"
                                class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>

                            <div id="image-preview-wrapper" class="mt-2 d-none">
                                <p class="mb-1 small">Gambar saat ini:</p>
                                <img src="" id="current-image" class="img-thumbnail" width="150"
                                    alt="Gambar saat ini">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Detail Gambar Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid" alt="Detail Gambar Layanan">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $services->links() }}
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            imageModal.addEventListener('show.bs.modal', function(event) {
                const triggerElement = event.relatedTarget;
                const imageSrc = triggerElement.getAttribute('data-src');
                modalImage.setAttribute('src', imageSrc);
            });
        });
    </script>
@endpush

@push('scripts')
    <script>
        function formatRupiah(input) {
            let value = input.value;
            value = value.replace(/\D/g, '');

            input.setAttribute('data-raw-price', value);

            if (value === "") {
                input.value = "";
                return;
            }

            let formattedValue = new Intl.NumberFormat('id-ID').format(value);
            input.value = formattedValue;
        }

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Tulis deskripsi layanan di sini...',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['fullscreen', 'codeview']]
                ],
                callbacks: {
                    onPaste: function(e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData)
                            .getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    }
                }
            });

            $('#service-form').on('submit', function() {
                if ($('#description').summernote('isEmpty')) {
                    $('#description').val('');
                } else {
                    $('#description').val($('#description').summernote('code'));
                }

                let priceInput = $('#price');
                let rawPrice = priceInput.attr('data-raw-price');
                if (rawPrice) {
                    priceInput.val(rawPrice);
                }
            });

            $('#serviceModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                var serviceId = button.data('id');

                var imagePreviewWrapper = $('#image-preview-wrapper');
                var currentImage = $('#current-image');
                var priceInput = modal.find('#price');

                if (serviceId) {
                    modal.find('.modal-title').text('Edit Layanan');
                    $('#service-form').attr('action', button.data('update-url'));

                    if (!$('#service-form').find('input[name="_method"]').length) {
                        $('#service-form').prepend('<input type="hidden" name="_method" value="PUT">');
                    }

                    fetch(button.data('edit-url'))
                        .then(response => response.json())
                        .then(data => {
                            modal.find('#name').val(data.name);
                            modal.find('#price').val(data.price);
                            modal.find('#status').val(data.status);
                            modal.find('#description').summernote('code', data.description);
                            priceInput.val(data.price);
                            formatRupiah(priceInput[0]);

                            if (data.image_url) {
                                currentImage.attr('src', data.image_url);
                                imagePreviewWrapper.removeClass('d-none');
                            } else {
                                imagePreviewWrapper.addClass('d-none');
                            }
                        });
                } else {
                    modal.find('.modal-title').text('Tambah Layanan Baru');
                    $('#service-form').attr('action', "{{ route('admin.services.store') }}");
                    $('#service-form')[0].reset();
                    $('#description').summernote('code', '');
                    $('#service-form').find('input[name="_method"]').remove();
                    imagePreviewWrapper.addClass('d-none');
                    priceInput.val('');
                    priceInput.removeAttr('data-raw-price');
                }
            });

            $('#imageModal').on('show.bs.modal', function(event) {
                var triggerElement = $(event.relatedTarget);
                var imageSrc = triggerElement.data('src');
                $('#modalImage').attr('src', imageSrc);
            });

            @if ($errors->any())
                var serviceModal = new bootstrap.Modal(document.getElementById('serviceModal'), {});
                serviceModal.show();
                let priceInputWithError = $('#price');
                if (priceInputWithError.val() !== '') {
                    formatRupiah(priceInputWithError[0]);
                }
            @endif
        });
    </script>
@endpush
