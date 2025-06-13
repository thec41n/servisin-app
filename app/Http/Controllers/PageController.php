<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $services = Service::where('status', true)->latest()->paginate(9);

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
        $request->validate([
            'tracking_code' => 'required|string',
        ]);

        $order = Order::where('tracking_code', $request->tracking_code)->first();

        if ($order) {
            return view('track.index', compact('order'));
        } else {
            return redirect()->route('track.show')->with('error', 'Kode pelacakan tidak ditemukan atau tidak valid.');
        }
    }

    public function showAllServices(Request $request)
    {
        $query = Service::where('status', true);
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('name', 'like', '%' . $request->category . '%');
        }
        $services = $query->latest()->paginate(9);

        if ($request->ajax()) {
            return view('services._service_list', compact('services'))->render();
        }

        return view('services.index', compact('services'));
    }
}
