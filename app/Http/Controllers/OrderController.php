<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Service $service)
    {
        return view('orders.create', compact('service'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'item_detail' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $dataToStore = $request->except(['_token', 'image']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('orders', 'public');
            $dataToStore['image'] = $imagePath;
        }

        $dataToStore['status'] = 'menunggu';
        $dataToStore['tracking_code'] = 'SVS-' . uniqid();

        $order = Order::create($dataToStore);

        $receiptUrl = route('orders.receipt', $order->id);

        return redirect()->route('home')->with([
            'order_success' => 'Pesanan Anda telah diterima! <br><br>Kode pelacakan Anda adalah: <strong>' . $order->tracking_code . '</strong>',
            'receipt_url' => $receiptUrl
        ]);
    }

    public function receipt(Order $order)
    {
        $pdf = app('dompdf.wrapper')->loadView('orders.receipt', compact('order'));

        $fileName = 'receipt-' . $order->tracking_code . '.pdf';

        return $pdf->download($fileName);
    }
}
