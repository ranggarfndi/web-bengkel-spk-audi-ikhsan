<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar semua pelanggan (Read).
     */
    public function index()
    {
        $customers = \App\Models\Customer::latest()->get();

        return view('customers.index', compact('customers'));
    }

    /**
     * Menampilkan formulir untuk membuat pelanggan baru (Create form).
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Menyimpan pelanggan baru ke database (Create action).
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_telepon'     => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
        ]);

        // 2. Simpan data ke database
        Customer::create($validatedData);

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('customers.index')
            ->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan data spesifik pelanggan (tidak kita gunakan, tapi ada).
     */
    public function show(Customer $customer)
    {
        // Biasanya untuk halaman detail, kita akan skip ini dulu
        return view('customers.show', compact('customer'));
    }

    /**
     * Menampilkan formulir untuk mengedit pelanggan (Update form).
     */
    public function edit(Customer $customer)
    {
        // Laravel's Route Model Binding otomatis menemukan pelanggan
        return view('customers.edit', compact('customer'));
    }

    /**
     * Memperbarui data pelanggan di database (Update action).
     */
    public function update(Request $request, Customer $customer)
    {
        // 1. Validasi data (sama seperti store)
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_telepon'     => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
        ]);

        // 2. Update data pelanggan yang ada
        $customer->update($validatedData);

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus data pelanggan dari database (Delete action).
     */
    public function destroy(Customer $customer)
    {
        try {
            // 1. Hapus pelanggan
            $customer->delete();

            // 2. Arahkan kembali dengan pesan sukses
            return redirect()->route('customers.index')
                ->with('success', 'Data pelanggan berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // 3. Tangani jika ada error (misal: foreign key constraint)
            // (Meskipun 'onDelete('cascade')' harusnya menangani ini)
            return redirect()->route('customers.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
