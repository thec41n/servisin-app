<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'image.mimes'    => 'Format gambar yang diizinkan adalah: jpeg, png, jpg, gif, svg.',
            'image.max'      => 'Ukuran gambar tidak boleh melebihi 5MB.',
            'status.required' => 'Silakan pilih status layanan.',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'status' => 'required|boolean',
        ], $messages);

        $imagePath = $request->file('image')->store('services', 'public');

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            'image.mimes' => 'Format gambarnya cuma boleh jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar terlalu besar! Maksimal 5MB.',
            'status.required' => 'Statusnya dipilih dulu, aktif atau tidak aktif.',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'status' => 'required|boolean',
        ], $messages);

        $dataToUpdate = $request->only(['name', 'description', 'price', 'status']);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $imagePath = $request->file('image')->store('services', 'public');
            $dataToUpdate['image'] = $imagePath;
        }

        $service->update($dataToUpdate);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
