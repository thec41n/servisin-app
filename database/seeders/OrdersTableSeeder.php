<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'service_id' => 1,
            'name' => 'Devi Mikhael',
            'email' => 'devi@example.com',
            'phone_number' => '081211112222',
            'item_detail' => 'iPhone 15 Pro Max, layar retak di pojok kanan atas.',
            'image' => null,
            'status' => 'selesai',
            'tracking_code' => 'SVS-' . uniqid(),
        ]);

        Order::create([
            'service_id' => 2,
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone_number' => '081233334444',
            'item_detail' => 'Laptop Asus ROG, sering bluescreen.',
            'image' => null,
            'status' => 'proses',
            'tracking_code' => 'SVS-' . uniqid(),
        ]);

        Order::create([
            'service_id' => 1,
            'name' => 'Citra Lestari',
            'email' => 'citra@example.com',
            'phone_number' => '081255556666',
            'item_detail' => 'Samsung S23 Ultra, ganti baterai.',
            'image' => null,
            'status' => 'selesai',
            'tracking_code' => 'SVS-' . uniqid(),
        ]);
    }
}
