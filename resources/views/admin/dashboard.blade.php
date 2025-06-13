@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <header class="content-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle-btn" id="sidebar-toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h3 mb-0">Dashboard</h1>
        </div>
        <div class="user-info">
            <span>Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</span>
        </div>
    </header>

    <section class="stat-cards mt-4">
        <div class="row g-4">
            <div class="col-md-6 col-lg-6">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="card-icon icon-bg-info">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ $newOrdersCount }}</h3>
                            <p class="mb-0">Pesanan Baru</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="card-icon icon-bg-success">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                            <p class="mb-0">Pendapatan Total (Selesai)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="card-icon icon-bg-warning">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ $activeServicesCount }}</h3>
                            <p class="mb-0">Layanan Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="card-icon icon-bg-danger">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ $uniqueCustomersCount }}</h3>
                            <p class="mb-0">Total Pelanggan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Aktivitas Terbaru (5 Pesanan Terakhir)</h2>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestOrders as $order)
                            <tr>
                                <td>#SVS-{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->service->name }}</td>
                                <td><span class="badge status-{{ strtolower($order->status) }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada aktivitas pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
