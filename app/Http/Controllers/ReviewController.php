<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if (! $order->isCompleted() || $order->review()->exists()) {
            throw ValidationException::withMessages([
                'review' => 'Ulasan hanya bisa dikirim satu kali untuk pesanan yang sudah selesai.',
            ]);
        }

        $data = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ], [
            'rating.required' => 'Silakan pilih jumlah bintang.',
            'rating.between' => 'Rating harus di antara 1 sampai 5.',
            'comment.required' => 'Ceritakan pengalaman Anda terlebih dahulu.',
            'comment.max' => 'Ulasan maksimal 1000 karakter.',
        ]);

        $order->review()->create($data);

        return redirect()->route('track.show', ['code' => $order->tracking_code])
            ->with('success', 'Terima kasih! Ulasan Anda akan tampil setelah ditinjau admin.');
    }
}
