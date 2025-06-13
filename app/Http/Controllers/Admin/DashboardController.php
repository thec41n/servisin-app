<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $newOrdersCount = Order::where('status', 'menunggu')->count();

        $totalRevenue = Order::where('orders.status', 'selesai')
            ->join('services', 'orders.service_id', '=', 'services.id')
            ->sum('services.price');

        $activeServicesCount = Service::where('status', true)->count();

        $uniqueCustomersCount = Order::distinct()->count('email');

        $latestOrders = Order::with('service')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'newOrdersCount',
            'totalRevenue',
            'activeServicesCount',
            'uniqueCustomersCount',
            'latestOrders'
        ));
    }
}
