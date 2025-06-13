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
                            <input type="text" id="name" name="name" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" id="price" name="price" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Layanan</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>

                            <div id="image-preview-wrapper" class="mt-2 d-none">
                                <p class="mb-1 small">Gambar saat ini:</p>

                                <img src="" id="current-image" class="img-thumbnail" width="150"
                                    alt="Gambar saat ini">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
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
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Tulis deskripsi layanan di sini...',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
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
            });

            $('#serviceModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                var serviceId = button.data('id');

                var imagePreviewWrapper = $('#image-preview-wrapper');
                var currentImage = $('#current-image');

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
                }
            });
        });
    </script>
@endpush
