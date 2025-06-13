@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
    <header class="content-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle-btn" id="sidebar-toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h3 mb-0">Manajemen Pesanan</h1>
        </div>
        <a href="{{ route('admin.orders.export', request()->query()) }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Ekspor ke Excel
        </a>
    </header>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex align-items-end gap-3">
                <div class="flex-grow-1">
                    <label for="status_filter" class="form-label">Filter Berdasarkan Status</label>
                    <select name="status" id="status_filter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="dicek" {{ request('status') == 'dicek' ? 'selected' : '' }}>Dicek</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>
                <div class="flex-grow-1">
                    <label for="search_query" class="form-label">Cari Pesanan</label>
                    <input type="text" name="search" id="search_query" class="form-control"
                        placeholder="Kode, Nama, atau No. Telepon" value="{{ request('search') }}">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover data-table align-middle">
                    <thead>
                        <tr>
                            <th>Kode Pesanan</th>
                            <th>Pelanggan</th>
                            <th>No Telpon</th>
                            <th>Layanan</th>
                            <th>Tgl Masuk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#SVS-{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->phone_number }}</td>
                                <td>{{ $order->service->name }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <span
                                        class="badge status-{{ strtolower($order->status) }}">{{ $order->status }}</span>
                                </td>
                                <td class="action-buttons">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada pesanan yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
