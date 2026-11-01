<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            'image.mimes'    => 'Format gambar yang diizinkan adalah: jpeg, png, jpg, webp.',
            'image.max'      => 'Ukuran gambar tidak boleh melebihi 5MB.',
            'status.required' => 'Silakan pilih status layanan.',
            'category.required' => 'Silakan pilih kategori layanan.',
            'category.in' => 'Kategori layanan tidak valid.',
        ];

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => ['required', Rule::in(array_keys(Service::CATEGORIES))],
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|boolean',
        ], $messages);

        $data['image'] = $request->file('image')->store('services', 'public');

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $messages = [
            'name.required' => 'Nama layanan wajib diisi!',
            'description.required' => 'Deskripsi tidak boleh kosong.',
            'price.required' => 'Harga harus diisi.',
            'price.integer' => 'Harga harus dalam bentuk angka.',
            'image.required' => 'Gambar layanan wajib diisi',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambarnya cuma boleh jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar terlalu besar! Maksimal 5MB.',
            'status.required' => 'Statusnya dipilih dulu, aktif atau tidak aktif.',
            'category.required' => 'Kategorinya dipilih dulu.',
            'category.in' => 'Kategori layanan tidak valid.',
        ];

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => ['required', Rule::in(array_keys(Service::CATEGORIES))],
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|boolean',
        ], $messages);

        unset($data['image']);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->orders()->exists()) {
            return redirect()->route('admin.services.index')
                ->with('error', 'Layanan ini sudah memiliki pesanan, jadi tidak bisa dihapus. Ubah statusnya menjadi Tidak Aktif saja.');
        }

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
