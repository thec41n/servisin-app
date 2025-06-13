<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $status;
    public function __construct($status)
    {
        $this->status = $status;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Order::with('service');

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Kode Pesanan',
            'Nama Pelanggan',
            'Email',
            'No Telepon',
            'Layanan',
            'Harga',
            'Status',
            'Tanggal Pesan',
        ];
    }

    /**
     * @param mixed $order
     * @return array
     */
    public function map($order): array
    {
        return [
            '#SVS-' . $order->id,
            $order->name,
            $order->email,
            $order->phone_number,
            $order->service->name,
            $order->service->price,
            $order->status,
            $order->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
