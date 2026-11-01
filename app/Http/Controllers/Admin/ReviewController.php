<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('order.service')->latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function update(Review $review)
    {
        $review->is_published = ! $review->is_published;
        $review->save();

        return redirect()->route('admin.reviews.index')
            ->with('success', $review->is_published ? 'Ulasan ditampilkan di website.' : 'Ulasan disembunyikan.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
