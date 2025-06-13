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
        $request->validate([
            'website_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'social_links' => 'nullable|array'
        ]);

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