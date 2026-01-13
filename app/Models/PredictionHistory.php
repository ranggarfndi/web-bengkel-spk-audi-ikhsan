<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredictionHistory extends Model
{
    protected $guarded = [];

    // Tambahkan ini agar Array otomatis jadi JSON saat disimpan, 
    // dan jadi Array lagi saat diambil.
    protected $casts = [
        'hasil_rekomendasi_copras' => 'array', 
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}