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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // Kunci asing (Foreign key) yang terhubung ke tabel 'customers'
            // 'onDelete('cascade')' berarti jika pelanggan dihapus, motornya juga terhapus
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onDelete('cascade');

            $table->string('no_polisi')->unique(); // Nomor polisi harus unik
            $table->string('merek_motor');
            $table->string('tipe_motor'); // Misal: Beat, Vario
            $table->integer('tahun_pembuatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
