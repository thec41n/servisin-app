<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Ganti LCD HP',
            'description' => 'Layanan penggantian LCD untuk semua merk HP. Pengerjaan cepat dan bergaransi.',
            'price' => 500000,
            'image' => 'images/ganti-lcd.jpg',
            'status' => true,
        ]);

        Service::create([
            'name' => 'Install Ulang Laptop',
            'description' => 'Install ulang Windows/MacOS beserta aplikasi standar. Bebas virus.',
            'price' => 150000,
            'image' => 'images/install-ulang.jpg',
            'status' => true,
        ]);

        Service::create([
            'name' => 'Servis Printer Mati Total',
            'description' => 'Perbaikan untuk printer yang tidak mau menyala sama sekali.',
            'price' => 250000,
            'image' => 'images/servis-printer.jpg',
            'status' => false,
        ]);
    }
}
