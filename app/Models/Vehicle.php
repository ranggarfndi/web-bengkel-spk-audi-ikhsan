<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * Kolom yang Boleh Diisi (Mass Assignable).
     */
    protected $fillable = [
        'customer_id',
        'no_polisi',
        'merek_motor',
        'tipe_motor',
        'tahun_pembuatan',
    ];

    /**
     * Relasi: Satu Kendaraan DIMILIKI OLEH SATU Pelanggan.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi: Satu Kendaraan BISA MEMILIKI BANYAK Riwayat Prediksi.
     */
    public function predictionHistories(): HasMany
    {
        return $this->hasMany(PredictionHistory::class);
    }
}