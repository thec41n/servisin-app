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
        $totalRevenue = Order::whereIn('status', ['selesai', 'dikirim'])->sum('price');
        $activeServicesCount = Service::where('status', true)->count();
        $uniqueCustomersCount = Order::distinct()->count('email');
        $latestOrders = Order::with('service')->latest()->take(5)->get();


        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D');
            $chartData[] = Order::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'newOrdersCount',
            'totalRevenue',
            'activeServicesCount',
            'uniqueCustomersCount',
            'latestOrders',
            'chartLabels',
            'chartData'
        ));
    }
}
