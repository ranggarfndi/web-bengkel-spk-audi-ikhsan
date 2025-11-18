<?php

namespace App\Http\Controllers;

use App\Models\PredictionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- 1. Impor DB Facade

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan statistik.
     */
    public function index()
    {
        // === Ambil Statistik ===

        // 1. Total Prediksi/Servis yang Tercatat
        $totalPrediksi = PredictionHistory::count();

        // 2. Distribusi Kelas Prediksi (Ringan, Sedang, Tinggi)
        $distribusiKelas = PredictionHistory::select('hasil_kelas_prediksi', DB::raw('count(*) as total'))
            ->groupBy('hasil_kelas_prediksi')
            ->get()
            ->pluck('total', 'hasil_kelas_prediksi'); // Format jadi [Ringan => 5, Sedang => 3]

        // 3. 5 Gejala Paling Sering Muncul
        $gejalaPopuler = PredictionHistory::select('input_gejala', DB::raw('count(*) as total'))
            ->groupBy('input_gejala')
            ->orderBy('total', 'desc') // Urutkan dari yang paling banyak
            ->limit(5) // Ambil 5 teratas
            ->get();

        // 4. Servis Terbaru (5 terakhir)
        $servisTerbaru = PredictionHistory::with('vehicle.customer')
            ->latest()
            ->limit(5)
            ->get();

        // === Kirim data ke View ===
        return view('dashboard', [
            'totalPrediksi'   => $totalPrediksi,
            'distribusiKelas' => $distribusiKelas,
            'gejalaPopuler'   => $gejalaPopuler,
            'servisTerbaru'   => $servisTerbaru,
        ]);
    }
}
