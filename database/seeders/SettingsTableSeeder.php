<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'website_name' => 'Servis.in',
            'email' => 'kontak@servis.in',
            'phone_number' => '081234567890',
            'address' => 'Jl. Pembangunan No. 123, Depok, Jawa Barat',
            'logo' => null,
            'social_links' => json_encode([
                'facebook' => '#',
                'instagram' => '#',
                'twitter' => '#',
            ]),
        ]);
    }
}
