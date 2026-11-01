@extends('layouts.app')

@section('title', 'Lacak Status Pesanan')

@section('content')
    <section class="page-header text-center">
        <div class="container">
            <h1>Lacak Status Pesanan</h1>
        </div>
    </section>

    <section class="track-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="card shadow-sm border-0 p-4 p-md-5 text-center mb-5">
                        <div class="card-body">
                            <h2>Masukkan Kode Pelacakan</h2>
                            <p class="text-muted">
                                Kode unik yang Anda terima setelah melakukan pemesanan.
                            </p>
                            <form action="{{ route('track.show') }}" method="GET" class="track-form">
                                <div class="input-group">
                                    <label for="code" class="visually-hidden">Kode pelacakan</label>
                                    <input type="text" id="code" name="code" class="form-control form-control-lg"
                                        value="{{ $code }}" placeholder="Contoh: SVS-AB12CD34EF" required />
                                    <button type="submit" class="btn btn-primary px-4">
                                        Lacak Sekarang
                                    </button>
                                </div>
                                @error('code')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </form>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-center" role="status">{{ session('success') }}</div>
                    @endif

                    @if ($order)
                        @if ($order->status == 'dibatalkan')
                            <div class="card shadow-sm border-0 p-4 p-md-5">
                                <div class="card-body text-center">
                                    <h2 class="mb-3 text-danger">Pesanan Dibatalkan</h2>
                                    <p class="text-muted">
                                        Pesanan dengan kode <strong>{{ $order->tracking_code }}</strong> telah
                                        dibatalkan. <br>
                                        Silakan hubungi kami jika Anda merasa ini adalah sebuah kesalahan.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="card shadow-sm border-0 p-4 p-md-5">
                                <div class="card-body">
                                    <h2 class="text-center mb-5">Status Pesanan {{ $order->tracking_code }}</h2>
                                    <ul class="timeline">
                                        @php
                                            $statuses = ['menunggu', 'dicek', 'proses', 'selesai', 'dikirim'];
                                            $currentStatusFound = false;
                                        @endphp

                                        @foreach ($statuses as $status)
                                            @if ($status == $order->status)
                                                @php $currentStatusFound = true; @endphp
                                                <li class="timeline-item active">
                                                    <div class="timeline-content">
                                                        <h4>{{ ucfirst($status) }}</h4>
                                                        <p>Status pesanan Anda saat ini. (Diperbarui pada:
                                                            {{ $order->updated_at->translatedFormat('d F Y, H:i') }})</p>
                                                    </div>
                                                </li>
                                            @elseif (!$currentStatusFound)
                                                <li class="timeline-item active">
                                                    <div class="timeline-content">
                                                        <h4>{{ ucfirst($status) }}</h4>
                                                        <p>Pesanan telah melewati tahap ini.</p>
                                                    </div>
                                                </li>
                                            @else
                                                <li class="timeline-item">
                                                    <div class="timeline-content">
                                                        <h4>{{ ucfirst($status) }}</h4>
                                                        <p>Pesanan belum mencapai tahap ini.</p>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <div class="text-center mt-4">
                                        <a href="{{ route('orders.receipt', $order->tracking_code) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-download me-2"></i>Download E-Receipt
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if ($order->isCompleted())
                                <div class="card shadow-sm border-0 p-4 p-md-5 mt-4" id="ulasan">
                                    <div class="card-body">
                                        @if ($order->review)
                                            <h2 class="h4 text-center mb-3">Terima Kasih atas Ulasan Anda</h2>
                                            <div class="text-center">
                                                <x-rating :value="$order->review->rating" class="fs-4" />
                                                <p class="mt-3 mb-2">{{ $order->review->comment }}</p>
                                                <small class="text-muted">
                                                    {{ $order->review->is_published ? 'Ulasan Anda sudah tampil di website.' : 'Ulasan Anda sedang ditinjau admin.' }}
                                                </small>
                                            </div>
                                        @else
                                            <h2 class="h4 text-center mb-1">Bagaimana Pengalaman Servis Anda?</h2>
                                            <p class="text-muted text-center mb-4">Ulasan Anda membantu pelanggan lain memilih layanan.</p>
                                            <form action="{{ route('reviews.store', $order->tracking_code) }}" method="POST">
                                                @csrf
                                                @error('review')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <fieldset class="text-center mb-3">
                                                    <legend class="form-label fs-6">Rating</legend>
                                                    <div class="rating-input">
                                                        @for ($star = 5; $star >= 1; $star--)
                                                            <input type="radio" id="rating-{{ $star }}" name="rating"
                                                                value="{{ $star }}" @checked(old('rating') == $star) required>
                                                            <label for="rating-{{ $star }}" title="{{ $star }} bintang">
                                                                <i class="fas fa-star" aria-hidden="true"></i>
                                                                <span class="visually-hidden">{{ $star }} bintang</span>
                                                            </label>
                                                        @endfor
                                                    </div>
                                                    @error('rating')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </fieldset>
                                                <div class="mb-3">
                                                    <label for="comment" class="form-label">Ulasan</label>
                                                    <textarea id="comment" name="comment" rows="4" maxlength="1000"
                                                        class="form-control form-control-lg @error('comment') is-invalid @enderror"
                                                        placeholder="Ceritakan pengalaman servis Anda..." required>{{ old('comment') }}</textarea>
                                                    @error('comment')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    @elseif ($code)
                        <div class="alert alert-danger text-center" role="alert">
                            Kode pelacakan tidak ditemukan. Periksa kembali kode yang Anda terima saat memesan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
