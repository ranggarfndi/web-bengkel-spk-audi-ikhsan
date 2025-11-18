<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prediction_histories', function (Blueprint $table) {
            $table->id();

            // Kunci asing (Foreign key) yang terhubung ke tabel 'vehicles'
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('cascade');

            // --- DATA INPUT DARI MEKANIK ---
            $table->integer('input_usia_motor');
            $table->integer('input_jarak_tempuh');
            $table->text('input_gejala');

            // --- DATA HASIL DARI API PYTHON ---
            $table->string('hasil_kelas_prediksi'); // Misal: "Sedang"

            // Menyimpan seluruh hasil peringkat COPRAS sebagai JSON
            $table->json('hasil_rekomendasi_copras');

            $table->text('catatan_mekanik')->nullable(); // Catatan opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediction_histories');
    }
};
