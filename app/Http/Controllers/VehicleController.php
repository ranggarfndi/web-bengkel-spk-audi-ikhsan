<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer; // <-- 1. Impor model Customer
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- 2. Impor untuk validasi 'unique'

class VehicleController extends Controller
{
    /**
     * Menampilkan daftar semua kendaraan.
     */
    public function index()
    {
        $vehicles = \App\Models\Vehicle::with('customer')->latest()->get();

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Menampilkan formulir untuk membuat kendaraan baru.
     */
    public function create()
    {
        // Ambil semua pelanggan untuk ditampilkan di dropdown
        $customers = Customer::orderBy('nama_pelanggan')->get(['id', 'nama_pelanggan']);

        return view('vehicles.create', compact('customers'));
    }

    /**
     * Menyimpan kendaraan baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $validatedData = $request->validate([
            'customer_id'     => 'required|exists:customers,id',
            'no_polisi'       => 'required|string|max:20|unique:vehicles',
            'merek_motor'     => 'required|string|max:100',
            'tipe_motor'      => 'required|string|max:100',
            'tahun_pembuatan' => 'nullable|integer|digits:4|min:1900|max:' . (date('Y') + 1),
        ]);

        // 2. Simpan
        Vehicle::create($validatedData);

        // 3. Redirect
        return redirect()->route('vehicles.index')
            ->with('success', 'Kendaraan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit kendaraan.
     */
    public function edit(Vehicle $vehicle)
    {
        // Ambil semua pelanggan untuk dropdown
        $customers = Customer::orderBy('nama_pelanggan')->get(['id', 'nama_pelanggan']);

        // $vehicle sudah otomatis diambil oleh Route Model Binding
        return view('vehicles.edit', compact('vehicle', 'customers'));
    }

    /**
     * Memperbarui data kendaraan di database.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        // 1. Validasi
        $validatedData = $request->validate([
            'customer_id'     => 'required|exists:customers,id',
            'no_polisi'       => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehicles')->ignore($vehicle->id), // Abaikan no polisi saat ini
            ],
            'merek_motor'     => 'required|string|max:100',
            'tipe_motor'      => 'required|string|max:100',
            'tahun_pembuatan' => 'nullable|integer|digits:4|min:1900|max:' . (date('Y') + 1),
        ]);

        // 2. Update
        $vehicle->update($validatedData);

        // 3. Redirect
        return redirect()->route('vehicles.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Menghapus kendaraan dari database.
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();
            return redirect()->route('vehicles.index')
                ->with('success', 'Data kendaraan berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
