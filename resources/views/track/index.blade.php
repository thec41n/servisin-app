@extends('layouts.app')

@section('title', 'Lacak Status Pesanan')

@section('content')
    <main>
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
                                <form action="{{ route('track.post') }}" method="POST" class="track-form">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="tracking_code" class="form-control form-control-lg"
                                            placeholder="Contoh: SVS-..." required />
                                        <button type="submit" class="btn btn-primary px-4">
                                            Lacak Sekarang
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if (isset($order))
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
                                                                {{ $order->updated_at->format('d M Y, H:i') }})</p>
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
                                    </div>
                                </div>
                            @endif
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-4 text-center">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
