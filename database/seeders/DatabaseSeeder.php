<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Pakai data Indonesia

        // ==========================================
        // 1. BUAT AKUN ADMIN (Sesuai Request)
        // ==========================================
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Cek jika email ini ada, jangan buat baru
            [
                'name' => 'Admin Bengkel',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Password di-hash
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Akun Admin berhasil dibuat!');
        $this->command->info('   Email: admin@example.com');
        $this->command->info('   Pass : password');

        // ==========================================
        // 2. BUAT DATA PELANGGAN & KENDARAAN DUMMY
        // ==========================================
        
        // Kita buat 15 Pelanggan Palsu
        for ($i = 1; $i <= 15; $i++) {
            
            // Buat 1 Pelanggan
            $customer = Customer::create([
                'nama_pelanggan' => $faker->name,
                'no_telepon'     => $faker->phoneNumber,
                'alamat'         => $faker->address,
            ]);

            // Setiap Pelanggan punya 1 sampai 2 motor
            $jumlahMotor = rand(1, 2); 

            for ($j = 0; $j < $jumlahMotor; $j++) {
                
                // Acak Merek & Tipe biar variatif
                $motorList = [
                    ['Honda', 'Beat Street'],
                    ['Honda', 'Vario 150'],
                    ['Honda', 'Scoopy'],
                    ['Yamaha', 'NMAX 155'],
                    ['Yamaha', 'Mio M3'],
                    ['Yamaha', 'Aerox 155'],
                    ['Suzuki', 'Satria F150'],
                    ['Kawasaki', 'KLX 150'],
                ];
                $randomMotor = $motorList[array_rand($motorList)];

                // Plat Nomor Acak (Contoh: BK 1234 ABC)
                $platNomor = 'BK ' . rand(1000, 9999) . ' ' . strtoupper($faker->lexify('??'));

                Vehicle::create([
                    'customer_id'     => $customer->id,
                    'no_polisi'       => $platNomor,
                    'merek_motor'     => $randomMotor[0],
                    'tipe_motor'      => $randomMotor[1],
                    'tahun_pembuatan' => rand(2015, 2024), // Motor tahun 2015-2024
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }

        $this->command->info('✅ 15 Data Pelanggan & Kendaraan dummy berhasil ditambahkan!');
    }
}