<?php

namespace App\Http\Controllers;

use App\Models\Vehicle; // <-- 1. Impor Model Vehicle
use App\Models\PredictionHistory; // <-- 2. Impor Model History
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class PredictionController extends Controller
{
    /**
     * Menampilkan formulir prediksi.
     */
    public function showForm()
    {
        // 3. Ambil semua kendaraan (beserta info pemiliknya) untuk dropdown
        $vehicles = Vehicle::with('customer')
                            ->orderBy('no_polisi')
                            ->get();

        // 4. Kirim data $vehicles ke view
        return view('predict', [
            'hasil' => null,
            'vehicles' => $vehicles // <-- Kirim data ini
        ]);
    }

    /**
     * Menerima data dari formulir, memanggil API, dan MENYIMPAN HASIL.
     */
    public function submitForm(Request $request)
    {
        // 5. Validasi data (perhatikan perubahannya)
        $data = $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id', // <-- Diubah
            'usia_motor'   => 'required|integer|min:0',
            'jarak_tempuh' => 'required|integer|min:0',
            'gejala'       => 'required|string',
        ]);

        // 6. Ambil data kendaraan dari database
        $vehicle = Vehicle::find($request->vehicle_id);

        // 7. Siapkan data untuk dikirim ke API Python
        $apiData = [
            // API butuh 'nama_motor', kita gunakan 'tipe_motor' dari database
            'nama_motor'   => $vehicle->tipe_motor, 
            'usia_motor'   => $request->usia_motor,
            'jarak_tempuh' => $request->jarak_tempuh,
            'gejala'       => $request->gejala,
        ];

        $apiUrl = 'http://127.0.0.1:5000/predict';

        try {
            // 8. Kirim data ke API Python
            $response = Http::post($apiUrl, $apiData);

            if ($response->successful()) {
                $hasil = $response->json(); // Ambil hasil JSON dari Python

                // 9. !!! INTI PERUBAHAN: SIMPAN KE DATABASE !!!
                PredictionHistory::create([
                    'vehicle_id'               => $vehicle->id,
                    'input_usia_motor'         => $request->usia_motor,
                    'input_jarak_tempuh'       => $request->jarak_tempuh,
                    'input_gejala'             => $request->gejala,
                    'hasil_kelas_prediksi'   => $hasil['prediksi_kelas_perawatan'],
                    'hasil_rekomendasi_copras' => $hasil['rekomendasi_paket_copras'],
                ]);
                // ---------------------------------------------

                // 10. Ambil kembali data $vehicles untuk dropdown
                $vehicles = Vehicle::with('customer')->orderBy('no_polisi')->get();

                // 11. Kirim kembali ke view dengan data 'hasil' dan 'vehicles'
                return view('predict', [
                    'hasil' => $hasil,
                    'vehicles' => $vehicles
                ]);

            } else {
                $errorMsg = 'API merespon dengan error: ' . $response->status();
                return redirect()->route('predict.form')->with('error', $errorMsg);
            }

        } catch (ConnectionException $e) {
            $errorMsg = 'Tidak dapat terhubung ke Server API Prediksi. Pastikan server Python (api.py) sudah berjalan.';
            return redirect()->route('predict.form')->with('error', $errorMsg);
        }
    }

    public function showHistory()
    {
        // 1. Ambil semua data riwayat
        // Kita gunakan 'with' (Eager Loading) untuk mengambil data
        // kendaraan dan pelanggan terkait secara efisien.
        $histories = PredictionHistory::with('vehicle.customer')
                                      ->latest() // Tampilkan yang terbaru dulu
                                      ->paginate(15); // 15 data per halaman

        // 2. Kirim data ke view baru
        return view('history.index', compact('histories'));
    }
}