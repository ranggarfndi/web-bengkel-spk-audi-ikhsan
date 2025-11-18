<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * Kolom yang Boleh Diisi (Mass Assignable).
     * Ini wajib untuk 'create()' and 'update()'.
     */
    protected $fillable = [
        'nama_pelanggan',
        'no_telepon',
        'alamat',
    ];

    /**
     * Relasi: Satu Pelanggan BISA MEMILIKI BANYAK Kendaraan.
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}