<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\PredictionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class PredictionController extends Controller
{
    /**
     * Menampilkan Form Diagnosa
     */
    public function showForm()
    {
        $vehicles = Vehicle::with('customer')->orderBy('no_polisi')->get();
        return view('predict', [
            'hasil' => null,
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Memproses Diagnosa (Kirim ke Python -> Simpan DB)
     */
    public function submitForm(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id',
            'usia_motor'   => 'required|integer|min:0',
            'jarak_tempuh' => 'required|integer|min:0',
            'gejala'       => 'required|string',
        ]);

        // 2. Ambil Data Kendaraan
        $vehicle = Vehicle::find($request->vehicle_id);

        // 3. Siapkan Data API
        $apiData = [
            'nama_motor'   => $vehicle->tipe_motor,
            'usia_motor'   => $request->usia_motor,
            'jarak_tempuh' => $request->jarak_tempuh,
            'gejala'       => $request->gejala,
        ];

        $apiUrl = 'http://127.0.0.1:5000/predict';

        try {
            // 4. Tembak API Python
            $response = Http::post($apiUrl, $apiData);

            if ($response->successful()) {
                $hasil = $response->json(); 

                // 5. Simpan ke Database
                PredictionHistory::create([
                    'vehicle_id'           => $vehicle->id,
                    'input_usia_motor'     => $request->usia_motor,
                    'input_jarak_tempuh'   => $request->jarak_tempuh,
                    'input_gejala'         => $request->gejala,
                    'hasil_kelas_prediksi' => $hasil['hasil_diagnosa']['kategori_perawatan'], 
                    'hasil_rekomendasi_copras' => $hasil['rekomendasi_terbaik'], 
                ]);

                // 6. Kembalikan ke View
                $vehicles = Vehicle::with('customer')->orderBy('no_polisi')->get();

                return view('predict', [
                    'hasil' => $hasil,
                    'vehicles' => $vehicles,
                    'selected_vehicle' => $vehicle
                ]);

            } else {
                return back()->with('error', 'API Error: ' . $response->status());
            }

        } catch (ConnectionException $e) {
            return back()->with('error', 'Gagal koneksi ke server Python. Pastikan api.py jalan.');
        }
    }

    /**
     * Menampilkan Riwayat (UPDATE: Menggunakan get() untuk DataTables)
     */
    public function showHistory()
    {
        // PENTING: Gunakan get() agar DataTables bisa memfilter & export semua data.
        $histories = PredictionHistory::with('vehicle.customer')
                                      ->latest()
                                      ->get(); 
                                      
        return view('history.index', compact('histories'));
    }
}