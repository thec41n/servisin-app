<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::firstOrNew();

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $messages = [
            'email.email' => 'Format email kontak tidak valid.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Format logo yang diizinkan adalah: png, jpg, jpeg.',
            'logo.max' => 'Ukuran logo tidak boleh melebihi 5MB.',
            'social_links.*.url' => 'Link media sosial harus diawali http:// atau https://.',
        ];

        $dataToUpdate = $request->validate([
            'website_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'social_links' => 'nullable|array:facebook,instagram,twitter',
            'social_links.*' => 'nullable|url:http,https|max:255',
        ], $messages);

        $setting = Setting::firstOrCreate([]);

        unset($dataToUpdate['logo']);

        if ($request->hasFile('logo')) {
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            $logoPath = $request->logo->store('settings', 'public');

            $dataToUpdate['logo'] = $logoPath;
        }

        $setting->update($dataToUpdate);

        return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
