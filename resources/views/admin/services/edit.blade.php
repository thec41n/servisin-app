@extends('layouts.admin')

@section('title', 'Edit Layanan')

@section('content')
    <header class="content-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="h3 mb-0">Edit Layanan</h1>
        </div>
    </header>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Layanan</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $service->name }}"
                        required />
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" class="form-control">{{ $service->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ $service->price }}"
                        required />
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Layanan</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                    <img src="{{ asset('uploads/services/' . $service->image) }}" alt="Gambar lama"
                        class="img-thumbnail mt-2" width="150">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
