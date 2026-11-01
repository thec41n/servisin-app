<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

        return view('landing', compact('services'));
    }

    public function showService(Service $service)
    {
        if (!$service->status) {
            abort(404, 'Layanan tidak ditemukan atau tidak aktif.');
        }

        return view('services.show', compact('service'));
    }

    public function showTrackPage()
    {
        return view('track.index');
    }

    public function trackOrder(Request $request)
    {
        $messages = [
            'tracking_code.required' => 'Mohon masukkan kode pelacakan Anda.',
        ];

        $request->validate([
            'tracking_code' => 'required|string',
        ], $messages);

        $order = Order::where('tracking_code', $request->tracking_code)->first();

        if ($order) {
            return view('track.index', compact('order'));
        } else {
            return redirect()->route('track.show')->with('error', 'Kode pelacakan tidak ditemukan atau tidak valid.');
        }
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
