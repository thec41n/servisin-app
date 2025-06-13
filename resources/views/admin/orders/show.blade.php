@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <header class="content-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="h3 mb-0">Detail Pesanan: {{ $order->tracking_code }}</h1>
        </div>
    </header>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <h5 class="mb-3">Update Status Pesanan</h5>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row align-items-end">
                    <div class="col-md-9">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="menunggu" {{ $order->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="dicek" {{ $order->status == 'dicek' ? 'selected' : '' }}>Dicek</option>
                            <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-2">
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-6 mt-3">
                    <h5>Info Pelanggan</h5>
                    <ul class="list-unstyled">
                        <li><strong>Nama:</strong> {{ $order->name }}</li>
                        <li><strong>Email:</strong> {{ $order->email }}</li>
                        <li><strong>No. Telepon:</strong> {{ $order->phone_number }}</li>
                    </ul>
                    <hr>
                    <h5>Info Layanan</h5>
                    <ul class="list-unstyled">
                        <li><strong>Layanan:</strong> {{ $order->service->name }}</li>
                        <li><strong>Harga:</strong> Rp {{ number_format($order->service->price, 0, ',', '.') }}</li>
                        <li><strong>Status:</strong> <span
                                class="badge status-{{ strtolower($order->status) }}">{{ $order->status }}</span></li>
                    </ul>
                </div>

                <div class="col-md-6 mt-3">
                    <h5>Detail Kendala</h5>
                    <p>{{ $order->item_detail }}</p>

                    <hr>
                    <h5>Gambar Barang</h5>

                    @if ($order->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($order->image))
                        <a href="{{ asset('storage/' . $order->image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->image) }}" alt="Gambar Barang"
                                class="img-fluid rounded" style="max-height: 400px; cursor: pointer;">
                        </a>
                    @else
                        <p class="text-muted fst-italic">Tidak ada gambar yang diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
