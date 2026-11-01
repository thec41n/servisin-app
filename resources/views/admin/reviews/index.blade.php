@extends('layouts.admin')

@section('title', 'Ulasan Pelanggan')

@section('content')
    <header class="content-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle-btn" id="sidebar-toggle-btn" aria-label="Buka menu">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h3 mb-0">Ulasan Pelanggan</h1>
        </div>
    </header>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <p class="text-muted">Ulasan baru tidak tampil di website sampai Anda menekan tombol <strong>Tampilkan</strong>.</p>
            <div class="table-responsive">
                <table class="table table-hover data-table align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Rating</th>
                            <th>Ulasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                            <tr>
                                <td>{{ $review->created_at->translatedFormat('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $review->order) }}">{{ $review->order->name }}</a>
                                </td>
                                <td>{{ $review->order->service->name }}</td>
                                <td><x-rating :value="$review->rating" /></td>
                                <td class="text-wrap" style="min-width: 260px;">{{ $review->comment }}</td>
                                <td>
                                    @if ($review->is_published)
                                        <span class="status-badge status-active">Ditampilkan</span>
                                    @else
                                        <span class="status-badge status-inactive">Menunggu</span>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $review->is_published ? 'btn-outline-secondary' : 'btn-maroon' }}">
                                            {{ $review->is_published ? 'Sembunyikan' : 'Tampilkan' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin mau hapus ulasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-delete" aria-label="Hapus ulasan">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada ulasan dari pelanggan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
@endsection
