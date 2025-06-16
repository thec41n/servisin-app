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
        $setting = Setting::first();

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $messages = [
            'name.required' => 'Nama layanan wajib diisi.',
            'name.string'   => 'Nama layanan harus berupa teks.',
            'name.max'      => 'Nama layanan tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi layanan wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.integer'  => 'Harga harus berupa angka.',
            'image.required' => 'Gambar layanan wajib diunggah.',
            'image.image'    => 'File yang diunggah harus berupa gambar.',
            'image.mimes'    => 'Format gambar yang diizinkan adalah: jpeg, png, jpg, gif, svg.',
            'image.max'      => 'Ukuran gambar tidak boleh melebihi 5MB.',
            'status.required' => 'Silakan pilih status layanan.',
        ];

        $request->validate([
            'website_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'social_links' => 'nullable|array'
        ], $messages);

        $setting = Setting::firstOrCreate([]);

        $dataToUpdate = $request->except(['_token', 'logo']);

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
