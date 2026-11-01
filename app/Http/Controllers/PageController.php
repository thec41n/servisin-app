<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function home()
    {
        $services = Service::where('status', true)
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->latest()
            ->take(3)
            ->get();

        $reviews = Review::published()->with('order.service')->latest()->take(9)->get();

        return view('landing', compact('services', 'reviews'));
    }

    public function showService(Service $service)
    {
        if (!$service->status) {
            abort(404, 'Layanan tidak ditemukan atau tidak aktif.');
        }

        $averageRating = $service->reviews()->published()->avg('rating');
        $reviewsCount = $service->reviews()->published()->count();
        $reviews = $service->reviews()->published()->with('order')->latest('reviews.created_at')->take(5)->get();

        return view('services.show', compact('service', 'reviews', 'averageRating', 'reviewsCount'));
    }

    public function trackOrder(Request $request)
    {
        $code = $request->validate(['code' => 'nullable|string|max:50'])['code'] ?? null;

        $order = $code ? Order::with('review')->where('tracking_code', $code)->first() : null;

        return view('track.index', compact('order', 'code'));
    }

    public function showAllServices(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:100',
            'category' => ['nullable', Rule::in(array_keys(Service::CATEGORIES))],
        ]);

        $services = Service::where('status', true)
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('category', $category))
            ->latest()
            ->paginate(9);

        if ($request->ajax()) {
            return view('services._service_list', compact('services'))->render();
        }

        return view('services.index', compact('services'));
    }

    public function showContactPage()
    {
        $appSetting = Setting::firstOrCreate([]);

        return view('contact.contact', compact('appSetting'));
    }
}
