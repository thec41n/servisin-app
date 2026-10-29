<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function create(Service $service)
    {
        abort_unless($service->status, 404);

        return view('orders.create', compact('service'));
    }

    public function store(Request $request)
    {
        $messages = [
            'service_id.required' => 'Silakan pilih layanan terlebih dahulu.',
            'service_id.exists' => 'Layanan yang dipilih tidak valid atau sedang tidak aktif.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'item_detail.required' => 'Mohon jelaskan detail barang dan kerusakannya.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh melebihi 5MB.',
        ];

        $data = $request->validate([
            'service_id' => ['required', Rule::exists('services', 'id')->where('status', true)],
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'item_detail' => 'required|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], $messages);

        $service = Service::findOrFail($data['service_id']);
        $data['image'] = $request->file('image')?->store('orders', 'public');

        $order = $service->orders()->create([...$data, 'price' => $service->price]);

        return redirect()->route('home')->with([
            'order_success' => 'Pesanan Anda telah diterima! <br><br>Kode pelacakan Anda adalah: <strong>'.$order->tracking_code.'</strong>',
            'receipt_url' => route('orders.receipt', $order->tracking_code),
        ]);
    }

    public function receipt(Order $order)
    {
        $setting = Setting::firstOrNew();

        $pdf = app('dompdf.wrapper')->loadView('orders.receipt', compact('order', 'setting'));

        $fileName = 'receipt-'.$order->tracking_code.'.pdf';

        return $pdf->download($fileName);
    }
}
