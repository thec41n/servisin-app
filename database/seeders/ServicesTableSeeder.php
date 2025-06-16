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
            'name' => 'Ganti Baterai HP & Tablet',
            'description' => '<p>Smartphone atau tablet Anda boros baterai? Kembalikan daya tahan perangkat Anda seperti baru dengan penggantian baterai original dari kami.</p><h3>Apa yang Anda Dapatkan?</h3><ul><li>Baterai original sesuai tipe perangkat</li><li>Pemasangan cepat oleh teknisi ahli</li><li>Garansi baterai hingga 3 bulan</li><li>Pengecekan kesehatan baterai gratis</li></ul>',
            'price' => 250000,
            'image' => 'services/ganti-batre.jpg',
            'status' => true,
        ]);

        Service::create([
            'name' => 'Ganti Layar LCD HP & Tablet',
            'description' => '<p>Layar retak atau rusak? Kembalikan kejernihan visual perangkat Anda dengan layanan penggantian layar profesional kami yang cepat dan bergaransi.</p><h3>Apa yang Anda Dapatkan?</h3><ul><li>Penggantian layar LCD + Touchscreen original</li><li>Pemasangan oleh teknisi berpengalaman</li><li>Garansi servis hingga 30 hari</li><li>Pembersihan internal perangkat gratis</li></ul>',
            'price' => 550000,
            'image' => 'services/ganti-lcd.jpg',
            'status' => true,
        ]);

        Service::create([
            'name' => 'Install Ulang OS Laptop & PC',
            'description' => '<p>Laptop atau PC Anda terasa lambat dan penuh virus? Segarkan kembali performanya dengan layanan install ulang OS lengkap dari kami.</p><h3>Apa yang Anda Dapatkan?</h3><ul><li>Install ulang Windows atau MacOS versi terbaru</li><li>Instalasi driver lengkap dan update</li><li>Bonus instalasi aplikasi standar (Office, Browser, dll)</li><li>Bebas virus dan malware</li></ul>',
            'price' => 150000,
            'image' => 'services/install-ulang-os.jpg',
            'status' => true,
        ]);

        Service::create([
            'name' => 'Analisa & Servis Mati Total (Laptop/PC)',
            'description' => '<p>Perangkat Anda tidak mau menyala sama sekali? Jangan panik. Tim kami akan melakukan diagnosa menyeluruh untuk menemukan dan memperbaiki sumber masalahnya.</p><h3>Apa yang Anda Dapatkan?</h3><ul><li>Pengecekan komponen menyeluruh (motherboard, power supply)</li><li>Estimasi biaya perbaikan sebelum pengerjaan</li><li>Perbaikan oleh teknisi hardware berpengalaman</li><li>Garansi untuk komponen yang diganti</li></ul>',
            'price' => 350000,
            'image' => 'services/mati-total.png',
            'status' => true,
        ]);

        Service::create([
            'name' => 'Upgrade RAM & SSD (Laptop/PC)',
            'description' => '<p>Tingkatkan kecepatan dan multitasking laptop atau PC Anda dengan paket upgrade RAM & SSD super cepat dari kami. Rasakan perbedaannya!</p><h3>Apa yang Anda Dapatkan?</h3><ul><li>Pemasangan RAM atau SSD baru (harga part terpisah)</li><li>Proses kloning data dari HDD ke SSD</li><li>Optimalisasi performa setelah upgrade</li><li>Pengerjaan bisa ditunggu</li></ul>',
            'price' => 125000,
            'image' => 'services/upgrade-ram-ssd.jpg',
            'status' => true,
        ]);

        Service::create([
            'name' => 'Penanganan Darurat Masuk Air',
            'description' => '<p>Perangkat Anda tercebur air? Segera bawa ke kami! Penanganan pertama yang cepat dan tepat dapat menyelamatkan perangkat Anda dari kerusakan total.</p><h3>Apa yang Anda Dapatkan?</h3><ul><li>Proses pengeringan komponen dengan alat khusus</li><li>Pembersihan korosi dan sisa cairan</li><li>Diagnosa kerusakan lanjutan</li><li>Prioritas penanganan tertinggi</li></ul>',
            'price' => 200000,
            'image' => 'services/hp-masuk-air.jpg',
            'status' => true,
        ]);

        Service::create([
            'name' => 'Jasa Rakit PC Custom',
            'description' => '<p>Wujudkan PC impian Anda! Kami menyediakan jasa perakitan PC custom sesuai budget dan kebutuhan, dari PC gaming hingga workstation.</p><h3>Apa yang Anda Dapatkan?</h3><ul><li>Konsultasi pemilihan komponen gratis</li><li>Perakitan rapi dengan manajemen kabel profesional</li><li>Instalasi OS dan driver</li><li>Stress testing untuk memastikan stabilitas sistem</li></ul>',
            'price' => 450000,
            'image' => 'services/rakit-pc.jpg',
            'status' => false,
        ]);
    }
}
