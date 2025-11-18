<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prediksi Perawatan Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(isset($hasil) && $hasil['status'] == 'sukses')
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Hasil Prediksi Kebutuhan Perawatan:</p>
                    <p class="text-2xl font-bold mt-1 mb-4">
                        {{ $hasil['prediksi_kelas_perawatan'] }}
                    </p>
                    <p class="font-bold border-t border-blue-300 pt-4 mt-4">Rekomendasi Paket Layanan (Peringkat COPRAS):</p>
                    @if(empty($hasil['rekomendasi_paket_copras']))
                        <p>Tidak ada rekomendasi paket layanan yang ditemukan untuk kelas ini.</p>
                    @else
                        <ol class="list-decimal list-inside mt-2 space-y-2">
                            @foreach($hasil['rekomendasi_paket_copras'] as $loop => $paket)
                                <li class="font-semibold">
                                    {{ $paket['nama'] }}
                                    <span class="font-normal text-sm">(Skor Utilitas: {{ number_format($paket['Utility (U_i)'], 2) }}%)</span>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('predict.submit') }}" method="POST">
                        @csrf 

                        <div>
                            <label for="vehicle_id" class="block font-medium text-sm text-gray-700">Pilih Kendaraan</label>
                            <select id="vehicle_id" name="vehicle_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('vehicle_id') border-red-500 @enderror" required>
                                <option value="">-- Pilih Kendaraan (Pelanggan - No. Polisi) --</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->customer->nama_pelanggan }} - ({{ $vehicle->no_polisi }}) - {{ $vehicle->tipe_motor }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('vehicle_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                            
                            @if($vehicles->isEmpty())
                                <span class="text-red-500 text-sm mt-1">
                                    Anda harus <a href="{{ route('customers.create') }}" class="underline">menambah pelanggan</a> 
                                    dan <a href="{{ route('vehicles.create') }}" class="underline">kendaraan</a> terlebih dahulu.
                                </span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <label for="usia_motor" class="block font-medium text-sm text-gray-700">Usia Motor (Tahun)</label>
                            <input type="number" id="usia_motor" name="usia_motor" value="{{ old('usia_motor') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                        </div>

                        <div class="mt-4">
                            <label for="jarak_tempuh" class="block font-medium text-sm text-gray-700">Jarak Tempuh (km) Saat Ini</label>
                            <input type="number" id="jarak_tempuh" name="jarak_tempuh" value="{{ old('jarak_tempuh') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                        </div>

                        <div class="mt-4">
                            <label for="gejala" class="block font-medium text-sm text-gray-700">Gejala Kerusakan</label>
                            <textarea id="gejala" name="gejala" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>{{ old('gejala') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500"
                                    @if($vehicles->isEmpty()) disabled @endif> Dapatkan Prediksi & Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>