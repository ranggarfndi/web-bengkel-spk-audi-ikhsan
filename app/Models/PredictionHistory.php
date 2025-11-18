<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PredictionHistory extends Model
{
    use HasFactory;

    /**
     * Kolom yang Boleh Diisi (Mass Assignable).
     */
    protected $fillable = [
        'vehicle_id',
        'input_usia_motor',
        'input_jarak_tempuh',
        'input_gejala',
        'hasil_kelas_prediksi',
        'hasil_rekomendasi_copras',
        'catatan_mekanik', // (Kita akan gunakan ini nanti)
    ];

    /**
     * Kolom yang di-cast (diubah) secara otomatis oleh Laravel.
     * Kita beri tahu Laravel bahwa 'hasil_rekomendasi_copras' adalah JSON/array.
     */
    protected $casts = [
        'hasil_rekomendasi_copras' => 'array',
    ];

    /**
     * Relasi: Satu Riwayat Prediksi DIMILIKI OLEH SATU Kendaraan.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}