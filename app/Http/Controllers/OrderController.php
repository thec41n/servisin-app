<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Setting;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Service $service)
    {
        return view('orders.create', compact('service'));
    }

    public function store(Request $request)
    {
        $messages = [
            'service_id.required' => 'Silakan pilih layanan terlebih dahulu.',
            'service_id.exists'   => 'Layanan yang dipilih tidak valid.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format alamat email tidak valid.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'item_detail.required' => 'Mohon jelaskan detail barang dan kerusakannya.',
            'image.image'    => 'File yang diunggah harus berupa gambar.',
            'image.max'      => 'Ukuran gambar tidak boleh melebihi 5MB.',
        ];

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'item_detail' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], $messages);

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
        $setting = Setting::first();

        $pdf = app('dompdf.wrapper')->loadView('orders.receipt', compact('order', 'setting'));

        $fileName = 'receipt-' . $order->tracking_code . '.pdf';
        return $pdf->download($fileName);
    }
}
