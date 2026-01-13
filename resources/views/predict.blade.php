<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Diagnosa Kerusakan') }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">Isi formulir di bawah ini untuk mendapatkan analisis AI.</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm flex items-start" role="alert">
                    <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-bold text-red-700">Terjadi Kesalahan</p>
                        <p class="text-sm text-red-600">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="flex items-center mb-6 border-b pb-4">
                        <div class="bg-indigo-100 p-3 rounded-full text-indigo-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l5.414 5.414a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Formulir Diagnosa</h3>
                            <p class="text-sm text-gray-500">Masukkan data kendaraan dan gejala yang dialami.</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('predict.submit') }}" method="POST">
                        @csrf
                        
                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Kendaraan Pelanggan</label>
                            <div class="relative">
                                <select id="vehicle_id" name="vehicle_id" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg shadow-sm" required>
                                    <option value="" data-tahun="">-- Cari No. Polisi / Nama --</option>
                                    @foreach($vehicles as $v)
                                        <option value="{{ $v->id }}" 
                                                data-tahun="{{ $v->tahun_pembuatan }}"
                                                {{ (isset($selected_vehicle) && $selected_vehicle->id == $v->id) ? 'selected' : '' }}>
                                            {{ $v->no_polisi }} - {{ $v->tipe_motor }} 
                                            (Owner: {{ $v->customer->nama_pelanggan ?? 'Tanpa Pemilik' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Usia Motor (Tahun)</label>
                                <input type="number" id="usia_motor" name="usia_motor" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 bg-gray-50" placeholder="Otomatis terisi..." required value="{{ old('usia_motor', $input['usia_motor'] ?? '') }}">
                                <p class="text-xs text-gray-400 mt-1">*Dihitung otomatis dari tahun pembuatan.</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jarak Tempuh (KM)</label>
                                <input type="number" name="jarak_tempuh" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" placeholder="Contoh: 50000" required value="{{ old('jarak_tempuh', $input['jarak_tempuh'] ?? '') }}">
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Gejala Kerusakan Utama</label>
                            <input type="text" list="gejala_list" name="gejala" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" placeholder="Ketik gejala yang dirasakan..." required autocomplete="off" value="{{ old('gejala', $input['gejala'] ?? '') }}">
                            <datalist id="gejala_list">
                                <option value="Rem kurang pakem">
                                <option value="Oli bocor">
                                <option value="Rantai longgar">
                                <option value="CVT licin">
                                <option value="Mesin panas">
                                <option value="Tarikan berat">
                                <option value="Getaran CVT Parah">
                            </datalist>
                            <p class="text-xs text-gray-400 mt-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pastikan penulisan sesuai saran (case-sensitive).
                            </p>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transform transition hover:scale-[1.02] duration-200 flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Jalankan Diagnosa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL POP-UP (Hanya muncul jika ada variabel $hasil) --}}
    @if(isset($hasil))
    <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border-t-8 border-green-500">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-xl font-bold leading-6 text-gray-900" id="modal-title">Hasil Diagnosa AI Selesai</h3>
                                <div class="mt-4">
                                    <div class="bg-gray-100 rounded-xl p-6 text-center mb-6 border border-gray-200">
                                        <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Rekomendasi Tingkat Perawatan</p>
                                        <p class="text-4xl font-black text-gray-800 uppercase mt-2 tracking-tight">
                                            {{ $hasil['hasil_diagnosa']['kategori_perawatan'] }}
                                        </p>
                                    </div>
                                    <p class="font-bold text-gray-700 mb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Top 3 Rekomendasi Paket:
                                    </p>
                                    <div class="overflow-hidden rounded-lg border border-gray-200 mb-6">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket Servis</th>
                                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Biaya</th>
                                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Skor (Ui)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                @foreach($hasil['rekomendasi_terbaik'] as $paket)
                                                <tr class="hover:bg-blue-50 transition">
                                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $paket['nama'] }}</td>
                                                    <td class="px-4 py-3 text-sm text-right text-gray-500">Rp {{ number_format($paket['harga_asli'], 0, ',', '.') }}</td>
                                                    <td class="px-4 py-3 text-sm text-center font-bold text-blue-600">{{ number_format($paket['Utility (U_i)'], 1) }}%</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <a href="http://127.0.0.1:5000/laporan_terbaru.html" target="_blank" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:w-auto items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l5.414 5.414a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" />
                            </svg>
                            Download PDF
                        </a>
                        <a href="{{ route('predict.form') }}" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Tutup & Reset Form
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Script JavaScript untuk Auto-Calculate Usia --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vehicleSelect = document.getElementById('vehicle_id');
            const usiaInput = document.getElementById('usia_motor');

            vehicleSelect.addEventListener('change', function() {
                // Ambil tahun dari atribut data-tahun di option yang dipilih
                const selectedOption = this.options[this.selectedIndex];
                const tahunPembuatan = selectedOption.getAttribute('data-tahun');

                if (tahunPembuatan) {
                    const currentYear = new Date().getFullYear();
                    const usia = currentYear - parseInt(tahunPembuatan);
                    // Pastikan usia tidak minus (jika ada kesalahan data tahun di masa depan)
                    usiaInput.value = usia >= 0 ? usia : 0;
                } else {
                    usiaInput.value = ''; // Kosongkan jika tidak ada data
                }
            });
        });
    </script>

</x-app-layout>